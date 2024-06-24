@extends('_layout_shared._master')
@section('title','Expense Actual vs Corrected')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link href="{{ url('public/site_resource/css/jquery.ui.autocomplete.css')}}" rel="stylesheet"/>


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
            padding: 2px;
            font-size: 8px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 9px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 8px;
        }

        body {
            color: #000;
        }

        .table {
            overflow: visible !important;
        }

    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Expense Actual vs Corrected
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    @if(Auth::user()->desig === 'GM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
                                      Auth::user()->desig === 'DSM' || Auth::user()->desig === 'All'||
                                      Auth::user()->desig === 'HO')

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Emp
                                                            Month:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="emp_month" id="emp_month"
                                                                class="form-control input-sm">
                                                            <option value="">Select Month</option>
                                                            @foreach($month_name as $mn)
                                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select RM Territory</option>
                                                            {{-- @foreach($rm_terr as $terr)
                                                                 <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                             @endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="am_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="emp_code"
                                                           class="col-md-3 col-sm-3 control-label"><b>Emp
                                                            Code:</b></label>
                                                    <div class="col-md-6">
                                                        {{--<input type="text" class="form-control input-sm" id="emp_code" name="emp_code">--}}
                                                        <select name="emp_code" id="emp_code"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')
                                        <div class="row">

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">

                                                        <label for="emp_month"
                                                               class="col-md-6 col-sm-6 control-label"><b>Emp Month:</b></label>
                                                        <div class="col-md-6">
                                                            <select name="emp_month" id="emp_month"
                                                                    class="form-control input-sm">
                                                                <option value="">Select Month</option>
                                                                @foreach($month_name as $mn)
                                                                    <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="emp_month"
                                                               class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                                Id:</b></label>
                                                        <div class="col-md-6">
                                                            <select name="rm_terr" id="rm_terr"
                                                                    class="form-control input-sm" disabled>
                                                                <option value="{{Auth::user()->terr_id}}">{{Auth::user()->terr_id}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="am_terr"
                                                               class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                                Id:</b></label>
                                                        <div class="col-md-6">
                                                            <select name="am_terr" id="am_terr"
                                                                    class="form-control input-sm">
                                                                <option value="">Select Territory</option>
                                                                @foreach($am_terr as $am)
                                                                    <option value="{{$am->am_terr_id}}">{{$am->am_terr_id}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="emp_code"
                                                               class="col-md-3 col-sm-3 control-label"><b>Emp Code:</b></label>
                                                        <div class="col-md-6">
                                                            {{--<input type="text" class="form-control input-sm" id="emp_code" name="emp_code">--}}
                                                            <select name="emp_code" id="emp_code"
                                                                    class="form-control input-sm">
                                                                <option value="">Select Territory</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display"
                                                            class="btn btn-default btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display Report</b></button>
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
    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        {{--<div class=" table-responsive">--}}
                        <table id="exvcol" class="table table-condensed table-striped table-bordered" width="100%">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th rowspan="2" class="text-center">EXP. DATE</th>
                                <th colspan="6" class="text-center" style="background-color: #2a88bd">ACTUAL EXPENSE
                                    DATA
                                </th>
                                <th colspan="7" class="text-center" style="background-color: #5bc5a4">VERIFIED EXPENSE
                                    DATA
                                </th>
                                <th colspan="7" class="text-center" style="background-color: #9b8a30">APPROVED EXPENSE
                                    DATA
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center">TOUR<br>TYPE</th>
                                <th class="text-center">TA<br>AMOUNT</th>
                                <th class="text-center">DAILY<br>ALLOWANCE</th>
                                <th class="text-center">CITY FARE<br>ALLOWANCE TYPE</th>
                                <th class="text-center">CITY FARE<br>ALLOWANCE</th>
                                <th class="text-center">OTHER<br>AMOUNT</th>
                                <th class="text-center">TOUR<br>TYPE</th>
                                <th class="text-center">TA<br>AMOUNT</th>
                                <th class="text-center">DAILY<br>ALLOWANCE</th>
                                <th class="text-center">CITY FARE<br>ALLOWANCE TYPE</th>
                                <th class="text-center">CITY FARE<br>ALLOWANCE</th>
                                <th class="text-center">OTHER<br>AMOUNT</th>
                                <th class="text-center">ADDITIONAL<br>AMOUNT</th>
                                <th class="text-center">TOUR<br>TYPE</th>
                                <th class="text-center">TA<br>AMOUNT</th>
                                <th class="text-center">DAILY<br>ALLOWANCE</th>
                                <th class="text-center">CITY FARE<br>ALLOWANCE TYPE</th>
                                <th class="text-center">CITY FARE<br>ALLOWANCE</th>
                                <th class="text-center">OTHER<br>AMOUNT</th>
                                <th class="text-center">ADDITIONAL<br>AMOUNT</th>

                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                            {{--<tfoot>
                            <tr>
                            </tr>
                            </tfoot>--}}
                        </table>
                      </div>
                    {{--</div>--}}

                </section>
            </div>
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>--}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}


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
    {{Html::script('public/site_resource/js/expense/exVcol_script.js')}}


    <script type="text/javascript">
        servloc_tid = "{{url('expense/eac_serEmp')}}";
        servloc_am = "{{url('expense/eac_regWTerrAmList')}}";
        servloc_t = "{{url('expense/eac_regwTLgmrm')}}";
        servloc = "{{url('expense/eac_actualVsCorrected')}}";

        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";
    </script>


@endsection