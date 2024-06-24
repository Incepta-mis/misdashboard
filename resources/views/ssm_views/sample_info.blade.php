@extends('_layout_shared._master')
@section('title','Sample Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
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

        body {
            color: black;
        }

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 32px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
        }

        .field-h {
            font-size: 11px;
            resize: both;
            /*background: #ffd73e33;*/
            border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg' %3E %3Cstyle%3Epath%7Banimation:stroke 5s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' stop-color='red' /%3E%3Cstop offset='50%25' stop-color='red' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
        }

        .input-xs {
            height: 23px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove orangered !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: orangered;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }


        .btn-primary {
            background-color: #337AC7;
        }
        .cls-req{
            color: red;
            font-weight: bold;
        }

        .select2-results__option {
            padding: 4px;
            border: 1px solid ghostwhite;
            font-size: 1.2rem;
        }

    </style>
@endsection
@section('right-content')
    <div class="row" id="top_ssmri">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Sample Information
                    </label>
                </header>
                <form action="" id="sample_info_data">
                    <div class="panel-body" style="margin-top: 10px;">
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group select2-bootstrap-prepend ">
                                        <select type="text" id="productlist" class="form-control">
                                            {{--                                            <option value="">SELECT PRODUCT</option>--}}
                                            {{--                                            @foreach($productinfo as $pi)--}}
                                            {{--                                                <option value="{{$pi->pname}}|{{$pi->batch_number}}|{{$pi->chamber_stor_loc}}">{{$pi->pname}} {{$pi->batch_number}} {{$pi->chamber_stor_loc}}</option>--}}
                                            {{--                                            @endforeach--}}
                                        </select>
                                        <span class="input-group-btn">
                                <button class="btn btn-primary" id="btn_display" type="button">Display!</button>
                              </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">Sample Info</legend>
                                    <div class="col-md-12">
                                        <p class="cls-req">*(Fields are required)</p>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Product Name:</b><span  class="cls-req">*</span></label>
                                                <select type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs"
                                                       id="prdctname" placeholder="" name="prdctname"> </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Mode of Packing:</b></label>
                                                <select name="m_pack" id="m_pack" class="form-control input-xs">
                                                    <option value="" selected>Select MOP</option>
                                                    @foreach($modp as $mop)

                                                        <option value="{{$mop->mop_name}}">{{$mop->mop_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="m_pack" placeholder="Enter Mode Of Packing" name="m_pack">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Pack Size:</b></label>
                                                <select name="psize" id="psize" class="form-control input-xs">
                                                    <option value="" selected>Enter Pack Size</option>
                                                    @foreach($psize as $ps)

                                                        <option value="{{$ps->ps_name}}">{{$ps->ps_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="psize" placeholder="Enter Pack Size" name="psize">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Unit:</b></label>
                                                <select name="punit" id="punit" class="form-control input-xs">
                                                    <option value="" selected>Enter Unit</option>
                                                    @foreach($sunit as $u)

                                                        <option value="{{$u->su_name}}">{{$u->su_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="punit" placeholder="Enter Unit" name="punit">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Analysis time /product"><b>Analysis time
                                                        /prod.:</b></label>
                                                <input type="number" class="form-control input-xs" id="anatp" min="0"
                                                       placeholder="" name="anatp"/>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Analysis time/next single batch"><b>Analysis
                                                        next batch:</b></label>
                                                <input type="number" class="form-control input-xs" id="anasb" min="0"
                                                       placeholder="" name="anasb"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Test Duration:</b></label>
                                                <input type="number" class="form-control input-xs" id="testdu" min="0"
                                                       placeholder=""
                                                       name="testdu">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Test Duration Unit:</b></label>
                                                <select class="form-control input-xs" id="testduunit" name="testduunit">
                                                    <option value="">Select Unit</option>
                                                    <option value="DAY">DAY</option>
                                                    <option value="WEEK">WEEK</option>
                                                    <option value="MONTH">MONTH</option>
                                                    <option value="YEAR">YEAR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Export Country:</b></label>
                                                <select name="excountry" id="excountry" class="form-control input-xs">
                                                    <option value="" selected>Select Export Country</option>
                                                    @foreach($export as $e)

                                                        <option value="{{$e->ec_name}}">{{$e->ec_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="excountry" placeholder="Enter Export Country" name="excountry">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Batch Number:</b><span  class="cls-req">*</span></label>
                                                <input type="text" class="form-control input-xs" id="btchnumber" min="0"
                                                       placeholder=""
                                                       name="btchnumber">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Kept on Date:</b></label>
                                                <input type="text" class="form-control input-xs" id="keepdate"
                                                       placeholder=""
                                                       name="keepdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Dosage form:</b></label>
                                                <select name="dosageform" id="dosageform" class="form-control input-xs">
                                                    <option value="" selected>Select Dosage</option>
                                                    @foreach($dosage as $d)

                                                        <option value="{{$d->df_name}}">{{$d->df_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="dosageform" placeholder="Enter Dosage form" name="dosageform">--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                <label for="email"><b>Chamber ID:</b><span  class="cls-req">*</span></label>
                                                {{--                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"--}}
                                                {{--                                                       class="form-control input-xs"--}}
                                                {{--                                                       id="chid" placeholder="" name="chid">--}}
                                                <select name="chid" id="chid" class="form-control input-xs">
                                                    <option value="">Select Chamber Id</option>
                                                    @foreach($chamber_id as $cid)
                                                        <option value="{{$cid->ci_name}}">{{$cid->ci_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Chamber Storage Location"><b>Storage
                                                        Location:</b></label>
                                                <input type="text" class="form-control input-xs"
                                                       onkeyup="this.value = this.value.toUpperCase();"
                                                       id="chlocation" placeholder="" name="chlocation">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Chamber Storage Condition"><b>Storage
                                                        Conditions:</b></label>
                                                <select name="storagecond" id="storagecond"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Enter Storage Condition</option>
                                                    @foreach($scond as $sc)

                                                        <option value="{{$sc->sc_name}}">{{$sc->sc_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="storagecond" placeholder="Enter Storage Conditions" name="storagecond">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Time Points:</b></label>
                                                <input type="number" class="form-control input-xs" id="timepoint"
                                                       min="0" placeholder=""
                                                       name="timepoint">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Time Points Unit:</b></label>
                                                <select name="timepointunit" id="timepointunit"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Enter Time Point Unit</option>
                                                    @foreach($stpunit as $stpu)

                                                        <option value="{{$stpu->tpu_name}}">{{$stpu->tpu_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="timepointunit" placeholder="Enter Time Points Unit" name="timepointunit">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Stability Types :</b></label>
                                                <select name="stabtype" id="stabtype" class="form-control input-xs">
                                                    <option value="" selected>Enter Stability Types</option>
                                                    @foreach($stypes as $st)

                                                        <option value="{{$st->tt_name}}">{{$st->tt_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="stabtype" placeholder="Enter Stability Types " name="stabtype">--}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Stability Study Reason:"><b>Study Reason:</b></label>
                                                <select name="stabstudyreason" id="stabstudyreason"
                                                        class="form-control input-xs">
                                                    <option value="" selected>Enter Stability Study Reason</option>
                                                    @foreach($ssreason as $ssr)

                                                        <option value="{{$ssr->ttr_name}}">{{$ssr->ttr_name}}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                <input type="text" class="" id="stabstudyreason" placeholder="Enter Stability Study Reason" name="stabstudyreason">--}}
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Samples for QC Test:</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="sampleqctest"
                                                       placeholder="" name="sampleqctest">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Samples for M/B Test"><b>Samp. for M/B Test
                                                        :</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="samplembtest"
                                                       placeholder="" name="samplembtest">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Required Quantity per full test"><b>Required
                                                        Q.P.F
                                                        test:</b></label>
                                                <input type="number" min="0" class="reqqpftest form-control input-xs"
                                                       id="reqqpftest"
                                                       placeholder="" name="reqqpftest">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>No of Testing points:</b></label>
                                                <input type="number" min="0" class="notestpoint form-control input-xs"
                                                       id="notestpoint"
                                                       placeholder="" name="notestpoint">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Excess Sample Qty:</b></label>
                                                <input type="number" min="0"
                                                       class="excesssampleqty form-control input-xs"
                                                       id="excesssampleqty"
                                                       placeholder="" name="excesssampleqty">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Total Sample quantity kept for full test"><b>T.S.Q
                                                        kept for full test:</b></label>
                                                <input type="number" readonly min="0" class="form-control input-xs"
                                                       id="tsqfulltest"
                                                       placeholder=""
                                                       name="tsqfulltest">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>Sample Orientation:</b></label>
                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                       class="form-control input-xs" id="sampleorient" placeholder=""
                                                       name="sampleorient">
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="email"><b>Remarks:</b></label>
                                                <input type="text" class="form-control input-xs" id="premarks"
                                                       placeholder=" "
                                                       name="premarks">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="scheduler-border2">
                                    <legend class="scheduler-border2">Pulling Info</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="1st pulled sample Qty"><b>1W Pulled
                                                        Qty.</b></label>
                                                <input type="number" class="form-control input-xs" id="firstqty"
                                                       placeholder="" name="firstqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1W Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="firstdate"
                                                       placeholder=" " readonly
                                                       name="firstdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="2nd pulled sample Qty"><b>2W Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="secondqty"
                                                       placeholder="" name="secondqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2W Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="seconddate"
                                                       placeholder=" " readonly
                                                       name="seconddate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="3rd pulled sample Qty"><b>3W Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs" id="thirdqty"
                                                       placeholder="" name="thirdqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3W Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="thirddate"
                                                       placeholder=" " readonly
                                                       name="thirddate">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="4th pulled sample Qty"><b>1M Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="fourthqty"
                                                       placeholder="" name="fourthqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>1M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="fourthdate"
                                                       placeholder=" " readonly
                                                       name="fourthdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="5th pulled sample Qty"><b>2M Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs" id="fifthqty"
                                                       placeholder="" name="fifthqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>2M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="fifthdate"
                                                       placeholder=" " readonly
                                                       name="fifthdate">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="6th pulled sample Qty"><b>3M Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs" id="sixthqty"
                                                       placeholder="" name="sixthqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>3M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="sixthdate"
                                                       placeholder=" " readonly
                                                       name="sixthdate">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="7th pulled sample Qty"><b>6M Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="seventhqty"
                                                       placeholder="" name="seventhqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>6M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="seventhdate"
                                                       placeholder=" " readonly
                                                       name="seventhdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="8th pulled sample Qty"><b>9M Pulled
                                                        Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs"
                                                       id="eighthqty"
                                                       placeholder="" name="eighthqty">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>9M Pulled Date</b></label>
                                                <input type="text" class="form-control input-xs" id="eighthdate"
                                                       placeholder=" " readonly
                                                       name="eighthdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="9th pulled sample Qty"><b>12M Pulled Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs" id="ninthqty"
                                                       placeholder="" name="ninthqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>12M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="ninthdate"
                                                       placeholder=" " readonly
                                                       name="ninthdate">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="10th pulled sample Qty"><b>18M Pulled Qty.</b></label>
                                                <input type="number" min="0" class="form-control input-xs" id="tenthqty"
                                                       placeholder="" name="tenthqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>18M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="tengthdate"
                                                       placeholder=" " readonly
                                                       name="tengthdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="11th pulled sample Qty"><b>24M Pulled Qty.</b></label>
                                                <input type="number" class="form-control input-xs" id="eleventhqty"
                                                       placeholder="" name="eleventhqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>24M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="eleventhdate"
                                                       placeholder=" " readonly
                                                       name="eleventhdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="12th pulled sample Qty"><b>36M Pulled Qty.</b></label>
                                                <input type="number" class="form-control input-xs" id="twelvethqty"
                                                       placeholder="" name="twelvethqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="Total Sample quantity kept for full test"><b>36M
                                                        Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="twelvethdate"
                                                       placeholder=" " readonly
                                                       name="twelvethdate">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="13th pulled sample Qty"><b>48M Pulled Qty.</b></label>
                                                <input type="number" class="form-control input-xs" id="thirteenthqty"
                                                       placeholder="" name="thirteenthqty">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>48M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="thirteenthdate"
                                                       placeholder=" " readonly name="thirteenthdate">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email" title="14th pulled sample Qty"><b>60M Pulled Qty.</b></label>
                                                <input type="number" class="form-control input-xs" id="fourteenthqty"
                                                       placeholder=" " name="fourteenthqty">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="email"><b>60M Pulling Date</b></label>
                                                <input type="text" class="form-control input-xs" id="fourteenthdate"
                                                       placeholder=" " readonly name="fourteenthdate">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email" title="Remaining Sample Quantity"><b>Remaining Sample
                                                        Quantity </b></label>
                                                <input type="number" readonly min="0" class="form-control input-xs"
                                                       id="rsquantity"
                                                       placeholder=" " name="rsquantity">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-8 col-md-offset-2 text-center" style="padding-top: 20px;">
                                <button type="button" id="btn_save" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> <b>SAVE</b></button>
                                <button type="button" id="btn_update" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> <b>UPDATE</b></button>
                                <button type="button" id="btn_refresh" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> <b>REFRESH</b></button>
                            </div>
                        </div>
                    </div>
                </form>

            </section>
        </div>
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
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/custom/emp_history_js/jquery.scrollTo.min.js')}}

    <script>
        var pname;
        var batch;
        var ch_id;
        $.fn.select2.defaults.set("theme", "bootstrap");

        $('#productlist').select2({
            width: null
        });

        var date = new Date();

        var pullingInfo = [];

        $('#keepdate').datetimepicker({
            defaultDate: date,
            format: 'DD-MMM-YY',
            showTodayButton: true,
            showClose: true,
            showClear: true
        });

        $(document).ready(function () {




            var date = $('#keepdate').val();
            var date1 = moment(date).add(6, 'days');

            $('#btn_update').prop('disabled', true);

            function objectifyForm(formArray) {
                //serialize data function

                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }

            function validate()
            {
                var isvalid = true;
                var firstqty = parseInt($('#firstqty').val() ? $('#firstqty').val() : 0),
                    secondqty = parseInt($('#secondqty').val() ? $('#secondqty').val() : 0),
                    thirdqty = parseInt($('#thirdqty').val() ? $('#thirdqty').val() : 0),
                    fourthqty = parseInt($('#fourthqty').val() ? $('#fourthqty').val() : 0),
                    fifthqty = parseInt($('#fifthqty').val() ? $('#fifthqty').val() : 0),
                    sixthqty = parseInt($('#sixthqty').val() ? $('#sixthqty').val() : 0),
                    seventhqty = parseInt($('#seventhqty').val() ? $('#seventhqty').val() : 0),
                    eighthqty = parseInt($('#eighthqty').val() ? $('#eighthqty').val() : 0),
                    ninthqty = parseInt($('#ninthqty').val() ? $('#ninthqty').val() : 0),
                    tenthqty = parseInt($('#tenthqty').val() ? $('#tenthqty').val() : 0),
                    eleventhqty = parseInt($('#eleventhqty').val() ? $('#eleventhqty').val() : 0),
                    twelvethqty = parseInt($('#twelvethqty').val() ? $('#twelvethqty').val() : 0),
                    thirteenthqty = parseInt($('#thirteenthqty').val() ? $('#thirteenthqty').val() : 0),
                    fourteenthqty = parseInt($('#fourteenthqty').val() ? $('#fourteenthqty').val() : 0);

                if (parseInt($('#rsquantity').val()) > parseInt($('#tsqfulltest').val())) {
                    isvalid = false;
                }
                else
                {
                    var tsq = $('#tsqfulltest').val();
                    if (parseInt(tsq)>0)
                    {
                        var total = firstqty + secondqty + thirdqty + fourthqty + fifthqty + sixthqty + seventhqty + eighthqty + ninthqty + tenthqty + eleventhqty + twelvethqty + thirteenthqty + fourteenthqty;
                        if (total<=tsq)
                        {
                            $('#rsquantity').val(tsq-total);
                        }
                        else {
                            $('#rsquantity').val('');
                            toastr.error('Remaining sample quantity cannot be Greater then Total Sample Quantity kept for full Test','',{timeOut: 0});
                        }


                    }


                }

                return isvalid;
            }

            $('#btn_save').on('click', function () {
                if ($('#prdctname').val() && $('#btchnumber').val() && $('#chid').val()) {
                    if (validate()){
                        console.log('clicked');
                        var formdata = $('#sample_info_data').serializeArray();


                        console.log(objectifyForm(formdata));
                        $.ajax({
                            type: 'post',
                            url: '{{url('ssm/save_info')}}',
                            data: {
                                fdata: objectifyForm(formdata),
                                _token: '{{csrf_token()}}'
                            },
                            success: function (response) {
                                if (response.status === 'SUCCESSFULLY') {
                                    console.log(response.xyz);
                                    $('#sample_info_data')[0].reset();
                                    var optionlist = '<option value="">SELECT PRODUCT</option>';
                                    for (var i = 0; i < response.xyz.length; i++) {
                                        optionlist += '<option value="' + response.xyz[i].pname + '|' + response.xyz[i].batch_number + '|' + response.xyz[i].chamber_stor_loc + '">' + response.xyz[i].pname + ' ' + response.xyz[i].batch_number + ' ' + response.xyz[i].chamber_stor_loc + '</option>';
                                    }
                                    $('#productlist').empty().append(optionlist);

                                    toastr.info('SAVED SUCCESSULLY');
                                    console.log(response);
                                }

                            },
                            error: function (error) {
                                toastr.error('This PRODUCT ,BATCH NUMBNER & CHAMBER ID are already exists');
                                console.log(error);
                            }
                        })
                    }
                    else {
                        toastr.error('Remaining sample quantity cannot be Greater then Total Sample Quantity kept for full Test','',{timeOut: 0});
                    }

                }
                else {
                    toastr.error('This PRODUCT ,BATCH NUMBNER & CHAMBER ID IS REQUIRED');
                }

            });


            $('#btn_refresh').on('click', function () {
                console.log('clicked');
                $('#prdctname,#btchnumber,#chlocation').prop('readonly', false);
                $('#sample_info_data')[0].reset();
                $('#btn_update').prop('disabled', true);
                $('#btn_save').prop('disabled', false);
                if (pullingInfo.length > 0) {
                    for (var i = 0; i < pullingInfo.length; i++) {

                        $('#' + pullingInfo[i].fname + '').removeClass('field-h');

                    }
                }

                $('html, body').animate({scrollTop: $("#top_ssmri").position().top}, 800);

            });

            $('#btn_update').on('click', function (){
                if (validate()) {
                    console.log('clicked');
                    var formdata = $('#sample_info_data').serializeArray();


                    console.log(objectifyForm(formdata));
                    $.ajax({
                        type: 'post',
                        url: '{{url('ssm/update_info')}}',
                        data: {
                            fdata: objectifyForm(formdata),
                            pname:pname,
                            batch:batch,
                            ch_id:ch_id,
                            param: $('#productlist :selected').text().trim(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            if (response.status === 'SUCCESSFULLY') {
                                toastr.info('UPDATED SUCCESSULLY');
                                console.log(response);
                                $('#sample_info_data')[0].reset();
                                pname = "";
                                batch = "";
                                ch_id= "";
                            }

                        },
                        error: function (error) {
                            toastr.info('UNABLE TO SAVE');
                            console.log(error);
                        }
                    });
                }
                else {
                    toastr.error('Remaining sample quantity cannot be Greater then Total Sample Quantity kept for full Test','',{timeOut: 0});
                }


            });

            $('#btn_display').on('click', function () {
                console.log('clicked');
                var sample = $('#productlist :selected').text().trim();

                $.ajax({
                    type: 'post',
                    url: '{{url('ssm/retrieve_info')}}',
                    data: {
                        fdata: sample,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response[0]);
                        if (response[0]) {
                            pname = response[0].prdctname;
                            batch = response[0].btchnumber;
                            ch_id = response[0].chid;


                            $('#sample_info_data').autofill(response[0]);

                            var $newOption = $("<option selected='selected'></option>").val(pname).text(pname);
                            $("#prdctname").append($newOption).trigger('change');


                       
                            pullingInfo = [
                                {date: response[0].firstdate, qty: response[0].firstqty, fname: 'firstqty'},
                                {date: response[0].seconddate, qty: response[0].secondqty, fname: 'secondqty'},
                                {date: response[0].thirddate, qty: response[0].thirdqty, fname: 'thirdqty'},
                                {date: response[0].fourthdate, qty: response[0].fourthqty, fname: 'fourthqty'},
                                {date: response[0].fifthdate, qty: response[0].fifthqty, fname: 'fifthqty'},
                                {date: response[0].sixthdate, qty: response[0].sixthqty, fname: 'sixthqty'},
                                {date: response[0].seventhdate, qty: response[0].seventhqty, fname: 'seventhqty'},
                                {date: response[0].eighthdate, qty: response[0].eighthqty, fname: 'eighthqty'},
                                {date: response[0].ninthdate, qty: response[0].ninthqty, fname: 'ninthqty'},
                                {date: response[0].tengthdate, qty: response[0].tenthqty, fname: 'tenthqty'},
                                {date: response[0].eleventhdate, qty: response[0].eleventhqty, fname: 'eleventhqty'},
                                {date: response[0].twelvethdate, qty: response[0].twelvethqty, fname: 'twelvethqty'},
                                {
                                    date: response[0].thirteenthdate,
                                    qty: response[0].thirteenthqty,
                                    fname: 'thirteenthqty'
                                },
                                {
                                    date: response[0].fourteenthdate,
                                    qty: response[0].fourteenthqty,
                                    fname: 'fourteenthqty'
                                }
                            ]
                            console.log(pullingInfo);
                            if (response[0].keepdate) {
                                console.log(response[0]);
                                console.log(response[0]);
                                var date2 = moment();
                                for (var i = 0; i < pullingInfo.length; i++) {
                                    var date1 = moment(pullingInfo[i].date, "DD-MMM-YY");

                                    console.log(date1);
                                    console.log(date2);

                                    var test = moment(date2).isAfter(date1, 'day'); // true
                                    console.log(test);
                                    if (test && pullingInfo[i].qty === null) {
                                        console.log('conditionpassed');
                                        // $('#'+pullingInfo[i].fname+'').css('border','1px solid red');
                                        $('#' + pullingInfo[i].fname + '').addClass('field-h');
                                    }


                                }
                            }

                        }


                        // $('#prdctname,#btchnumber,#chlocation').prop('readonly', true);
                        $('#btn_update').prop('disabled', false);
                        $('#btn_save').prop('disabled', true);
                    },
                    error: function (error) {
                        toastr.info('UNABLE TO FETCH RECORDS');
                        console.log(error);
                    }
                })
            });
            $('#reqqpftest,#notestpoint,#excesssampleqty').on('change', function (event) {
                var reqqpftest = parseInt($('#reqqpftest').val()),
                    notestpoint = parseInt($('#notestpoint').val()),
                    excesssampleqty = parseInt($('#excesssampleqty').val());
                $('#tsqfulltest').val((reqqpftest * notestpoint) + excesssampleqty);

                console.log(event.target.value);
            });

            $('#firstqty,#secondqty,#thirdqty,#fourthqty,#fifthqty,#sixthqty,#seventhqty,#eighthqty,#ninthqty,#tenthqty,#eleventhqty,#twelvethqty,#thirteenthqty,#fourteenthqty').on('input', function (event) {
                if (validate() === false)
                {
                    toastr.error('Remaining sample quantity cannot be Greater then Total Sample Quantity kept for full Test','',{timeOut: 0});
                };
                console.log(event.target.value);
            })


            $('input[type="number"]').on('keyup', function (event) {
                console.log(event.target.value);
                var value = event.target.value;
                var regex = new RegExp(/^\+?[0-9(),.-]+$/);
                if (value.match(regex)) {
                    event.target.value = value;
                } else {
                    event.target.value = '';
                }
                ;
            });

            $('#keepdate').on('dp.change', function (e) {
                var date = moment($(this).val(), "DD-MMM-YY");
                console.log(date);
                var date1 = moment(date).add(7, 'days').format("DD-MMM-YY");
                var date2 = moment(date).add(14, 'days').format("DD-MMM-YY");
                var date3 = moment(date).add(21, 'days').format("DD-MMM-YY");
                var date4 = moment(date).add(1, 'M').format("DD-MMM-YY");
                var date5 = moment(date).add(2, 'M').format("DD-MMM-YY");
                var date6 = moment(date).add(3, 'M').format("DD-MMM-YY");
                var date7 = moment(date).add(6, 'M').format("DD-MMM-YY");
                var date8 = moment(date).add(9, 'M').format("DD-MMM-YY");
                var date9 = moment(date).add(12, 'M').format("DD-MMM-YY");
                var date10 = moment(date).add(18, 'M').format("DD-MMM-YY");
                var date11 = moment(date).add(24, 'M').format("DD-MMM-YY");
                var date12 = moment(date).add(36, 'M').format("DD-MMM-YY");
                var date13 = moment(date).add(48, 'M').format("DD-MMM-YY");
                var date14 = moment(date).add(60, 'M').format("DD-MMM-YY");

                console.log(date1);
                console.log(date2);
                console.log(date3);
                console.log(date4);
                console.log(date5);
                console.log(date6);
                console.log(date7);
                console.log(date8);
                console.log(date9);
                console.log(date10);
                console.log(date11);
                console.log(date12);
                console.log(date13);
                console.log(date14);

                $('#firstdate').val(date1)
                $('#seconddate').val(date2)
                $('#thirddate').val(date3)
                $('#fourthdate').val(date4)
                $('#fifthdate').val(date5)
                $('#sixthdate').val(date6)
                $('#seventhdate').val(date7)
                $('#eighthdate').val(date8)
                $('#ninthdate').val(date9)
                $('#tengthdate').val(date10)
                $('#eleventhdate').val(date11)
                $('#twelvethdate').val(date12)
                $('#thirteenthdate').val(date13)
                $('#fourteenthdate').val(date14)
            });

            var currentQuery;
            $('#productlist').select2({
                placeholder: 'Select Sample',
                delay: 250,
                minimumInputLength: 3,
                ajax: {
                    url: '{{url('ssm/search_saved_sample')}}',
                    data: function (params) {
                        var query = {
                            search: params?.term?.toUpperCase()
                        }
                        return query;
                    }
                },
                datatype:'json'
            }).on('select2:closing', function (e) {
                // Preserve typed value
                currentQuery = $('.select2-search input').prop('value');
            }).on('select2:open', function (e) {
                // Fill preserved value back into Select2 input field and trigger the AJAX loading (if any)
                $('.select2-search input').val(currentQuery).trigger('change').trigger("input");
            });


            var  lastResults;
            $("#prdctname").select2({
                tags: true,
                placeholder: 'Select product',
                delay: 250,
                minimumInputLength: 3,
                ajax: {
                    multiple: true,
                    url: '{{url('ssm/get_product_name')}}',
                    data: function (params) {

                        var query = {
                            search: params?.term?.toUpperCase()
                        }
                        return query;
                    },
                    dataType: "json",
                },
            }).on('select2:closing', function (e) {
                // Preserve typed value
                lastResults = $('.select2-search input').prop('value');

            }).on('select2:open', function (e) {
                // Fill preserved value back into Select2 input field and trigger the AJAX loading (if any)
                $('.select2-search input').val(lastResults).trigger('change').trigger("input");
            });




        });
    </script>
@endsection
