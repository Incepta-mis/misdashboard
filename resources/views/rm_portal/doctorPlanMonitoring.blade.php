@extends('_layout_shared._master')
@section('title','Doctor Plan')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
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

        body {
            color: black;
        }

        #criteria > ul > li {
            padding: 15px;
        }

        .border {
            border-bottom: 1px solid grey;
        }

        .highcharts-xaxis-labels {
            height: 450px;
        }

        @media (min-width: 992px) {
            .col-md-4 {
                width: 30.33333333%;
            }
        }

        .form-group {
            margin-bottom: 0px;
        }

        .pad10 {
            padding-bottom: 3px;
        }

        .inputRow {
            position: relative;
            overflow: auto;
        }

        .searchItem {
            position: absolute;
            background-color: white;
            border: 1px solid gray;
            z-index: 50;
            height: 250px;
            overflow-y: scroll;
        }

        #sresult > li:hover {
            background-color: #285e8e;
            color: #ffff;
            cursor: pointer;
            font-weight: bold;
        }

        #sresult > li {
            padding: 2px;
            border-bottom: 1px solid #2A3542;
            font-size: .9em;
        }

        .modal-body {
            max-height: calc(100vh - 210px);
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

        .modal-header {
            background: #5A89BC;
        }

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

        .rloader {
            background-color: #ffffff;
            background-image: url('{{url('public/site_resource/images/preloader.gif')}}');
            background-size: 25px 25px;
            background-position: right center;
            background-repeat: no-repeat;
            background-position-x: 90%;
        }


    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Doctor Plan Monitoring
                    <span class="tools pull-right">
                                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                                        <a href="javascript:;" class="fa fa-times"></a>
                                     </span>
                </div>
                <div class="panel-body" style="display: block;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="gm_id"
                                           class="col-md-4 col-sm-4 control-label input-xs"><b>General
                                            Manager:</b></label>
                                    <div class="col-md-8 col-sm-8">
                                        <select name="gm_id" id="gm_id" class="form-control input-sm gm_id">
                                            <option value="">Select GM</option>
                                            <option value="ALL">ALL</option>
                                            @foreach($gmInfo as $info)
                                                <option value="{{$info->gm_id}}">{{$info->gm_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="gm_id" class="col-md-4 col-sm-4 control-label input-xs"><b>Rm / Asm :</b></label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="rm_id" id="rm_id" class="form-control input-sm rm_id">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                        <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Report</b></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                <div id="export_buttons">

                </div>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <table id="elr" width="100%" class="table table-bordered table-condensed">
                            <thead>
                            <tr>
                                <th>REGION</th>
                                <th>RM/ASM NAME</th>
                                <th>AM CODE</th>
                                <th>MPO CODE</th>
                                <th>DOCTOR COUNT</th>
                                <th>DOCTOR VISIT PLAN</th>
                                <th>ASSIGNED_BRANDS</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>

                </div>
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

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}



    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    {{Html::script('public/site_resource/js/rm_portal_scripts/doctorPlanMonitoring.js')}}
    <!-- {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}} -->





    <script type="text/javascript">

            servloc_am = "{{url('rm_portal/docPlanGetRMASM')}}";
            servloc_data = "{{ url('rm_portal/docPlanGetdocPlanData') }}";

    </script>


@endsection