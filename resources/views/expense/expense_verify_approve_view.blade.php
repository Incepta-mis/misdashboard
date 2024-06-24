@extends('_layout_shared._master')
@section('title','Doctor Visit Summary Report')
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
                        Expense Verify Approve
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">

                        <form method="post" id="myfrm" action="">
                            {{--                            {{ csrf_token() }}--}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                    <b>Expense Month:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="e_month" id="e_month_id" class="form-control input-sm">
                                        {{--@foreach($expense_months as $expense_mon)--}}
                                            {{--<option value="{{$expense_mon->month}}">{{$expense_mon->month}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>

                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                       for="terr_id">
                                    <b>Employee ID:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="e_emp_id" id="e_emp_id" class="form-control input-sm">
                                        {{--<option value="All">Region Territory</option>--}}
                                        {{--@foreach($datas as $dd)--}}
                                            {{--<option value="{{$dd->emp_id}}">{{$dd->emp_id}}</option>--}}
                                        {{--@endforeach--}}
                                    </select>
                                </div>


                            </div>
                            <div class="form-group">

                                @if(Auth::user()->desig!='MPO')
                                    <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                        <b>AM Territory:</b></label>
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        <select name="e_am_terr_id" id="e_am_terr_id" class="form-control input-sm">
                                            {{--@foreach($datas as $dd)--}}
                                                {{--<option value="{{$dd->am_terr_id}}">{{$dd->am_terr_id}}</option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </div>
                                @endif


                                @if(Auth::user()->desig!='AM')
                                    <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" style="width: 12%;"
                                           for="terr_id">
                                        <b>Region Territory:</b></label>
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        <select name="e_rm_terr_id" id="e_rm_terr_id" class="form-control input-sm">
                                            {{--<option value="All">Region Territory</option>--}}
                                            {{--@foreach($datas as $dd)--}}
                                                {{--<option value="{{$dd->rm_terr_id}}">{{$dd->rm_terr_id}}</option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="submit" id="btn_display" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Submit</b></button>
                                </div>
                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                    <div  id="export_buttons">

                                    </div>
                                </div>
                            </div>

                        </form>

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
    <div class="row" id="report-body">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body table-responsive">
                        <table id="dvsr_data" class="table table-condensed table-striped table-bordered"
                        width="100%">
                        <thead style="white-space:nowrap;">
                        <tr>
                        <th>Product Group</th>
                        <th>Territory Id</th>
                        <th>Employee Id</th>
                        <th>Employee Name</th>
                        <th>No. of Doctor Visited</th>
                        <th>No. of Call</th>
                        <th>Product Group</th>
                        <th>Territory Id</th>
                        <th>Employee Id</th>
                        <th>Employee Name</th>
                        <th>No. of Doctor Visited</th>
                        <th>No. of Call</th>
                        </tr>
                        </thead>
                        <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                        <tfoot>
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
    {{--    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}--}}
    {{--{{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}--}}
    {{--{{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}--}}
    {{--{{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}--}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{--    {{Html::script('public/site_resource/js/dcr_scripts/dvsr_script.js')}}--}}
    <script>
        {{--servloc = "{{url('dcrep/resp_dvs_rep')}}";--}}
        {{--servloc_t = "{{url('dcrep/resp_terr_id')}}";--}}
    </script>
@endsection
