@extends('_layout_shared._master')
@section('title','Requisition Status For SSD')
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

        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Requisition Status For SSD
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 0px">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

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
                                                            {{--<option value="ALL">ALL</option>--}}
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


                                            {{--<div class="form-group">--}}
                                            <div class=" col-md-1 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                                </button>
                                                {{--<i class="fa fa-angle-double-down fa-lg" aria-hidden="true"></i>--}}
                                            </div>
                                            {{--<div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">--}}
                                            {{--<div id="export_buttons">--}}

                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}


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
                            <table id="req_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                <th>Terr Id</th>   
                                <th>DocId</th>
                                    <th>Doctor Name</th> 
                                    <th>Infavor </th>
                                    <th>Beneficiary</th>
                                    <th>Depot</th>
                                    <th>Don Type</th>
                                    <th>Brand/Region</th>
                                    <th>Frequency</th>
                                     <th>Pay Month</th>
                                    
                                    <th>Pay Mode</th>
                                    <th>App Amt</th>
                                    
                                
                                    <th>Summ Id</th>
                                    
                                    <th>Rq No</th>
                                    <th>Rq Dt</th>
                                    <th >Remarks</th>

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




    @include('donation.modal.delete_requisition')
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
    {{Html::script('public/site_resource/js/donation_script/request_status_for_ssd_script.js')}}


    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}

    <script type="text/javascript">

        servloc_tid = "{{url('donation/regwMpoTerrList')}}";
        servloc = "{{url('dcrep/prescripSurveyReport')}}";
        servloc_am = "{{url('donation/regWTerrAmList')}}";
        brand_region = "{{url('donation/brandRegion')}}";
        display_data = "{{url('donation/requisition_data_ssd')}}";
        update_row = "{{url('donation/update_row')}}";
        delete_row = "{{url('donation/delete_row')}}";
        verify_row = "{{url('donation/verify_row')}}";
        freq_edit = "{{url('donation/freq_edit')}}";
        brand_region_be = "{{url('donation/brandRegion_be_ssd')}}";

        eid = "{{Auth::user()->user_id}}";
        {{--log_name = '{{Auth::user()->name}}';--}}
            log_id = '{{Auth::user()->user_id}}';
        log_desig = '{{Auth::user()->desig}}';
        _csrf_token = '{{csrf_token()}}';
    </script>

@endsection