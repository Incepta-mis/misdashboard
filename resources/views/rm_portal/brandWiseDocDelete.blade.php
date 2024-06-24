@extends('_layout_shared._master')
@section('title','Brand Wise Doctors Delete')
@section('styles')
<link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- <link href=" https://cdn.datatables.net/select/1.2.5/css/select.dataTables.min.css" rel="stylesheet" type="text/css"/> -->




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


</style>
@endsection

@section('right-content')
<div class="row">
    <div class="col-sm-12 col-md-12">
        <section class="panel" id="data_table">
            <header class="panel-heading">
                <label class="text-primary">
                    Brand Wise Doctors Delete
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
                                            <label for="rm_terr"
                                                   class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="rm_terr" id="rm_terr"
                                                        class="form-control input-sm">
                                                    <option value="">Select RM Territory</option>
                                                    @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                    Id:</b></label>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rm_terr"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="bnd_name" id="bnd_name"
                                                        class="form-control input-sm">
                                                    <option value="">Select Brand</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="emp_month"--}}
                                                   {{--class="col-md-3 col-sm-3 control-label"><b>Item Name:</b></label>--}}
                                            {{--<div class="col-md-9 col-sm-9">--}}
                                                {{--<select name="item_name" id="item_name"--}}
                                                        {{--class="form-control input-sm">--}}
                                                    {{--<option value="">Select Item</option>--}}

                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
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
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="am_terr" id="am_terr"
                                                        class="form-control input-sm">
                                                    <option value="">Select Territory</option>
                                                    @foreach($am_terr as $terr)
                                                    <option value="{{$terr->am_terr_id}}">{{$terr->am_terr_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                    Id:</b></label>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rm_terr"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="bnd_name" id="bnd_name"
                                                        class="form-control input-sm">
                                                    <option value="">Select Brand</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="emp_month"--}}
                                                   {{--class="col-md-3 col-sm-3 control-label"><b>Item Name:</b></label>--}}
                                            {{--<div class="col-md-9 col-sm-9">--}}
                                                {{--<select name="item_name" id="item_name"--}}
                                                        {{--class="form-control input-sm">--}}
                                                    {{--<option value="">Select Item</option>--}}

                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
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

                                @if(Auth::user()->desig === 'AM' ||  Auth::user()->desig === 'Sr. AM')
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="rm_terr" id="rm_terr"
                                                        class="form-control input-sm" disabled>
                                                    @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="am_terr" id="am_terr"
                                                        class="form-control input-sm" disabled>
                                                    <option value="{{Auth::user()->terr_id}}">{{Auth::user()->terr_id}}</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="mpo_terr" id="mpo_terr"
                                                        class="form-control input-sm">
                                                    <option value="">Select Territory</option>
                                                    @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->mpo_terr_id}}">{{$terr->mpo_terr_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rm_terr"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="bnd_name" id="bnd_name"
                                                        class="form-control input-sm">
                                                    <option value="">Select Brand</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="form-group">--}}
                                            {{--<label for="emp_month"--}}
                                                   {{--class="col-md-3 col-sm-3 control-label"><b>Item Name:</b></label>--}}
                                            {{--<div class="col-md-9 col-sm-9">--}}
                                                {{--<select name="item_name" id="item_name"--}}
                                                        {{--class="form-control input-sm">--}}
                                                    {{--<option value="">Select Item</option>--}}

                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
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

                                @if(Auth::user()->desig === 'MPO' ||  Auth::user()->desig === 'Sr. MPO')
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="rm_terr" id="rm_terr"
                                                        class="form-control input-sm" disabled>
                                                    @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="am_terr" id="am_terr"
                                                        class="form-control input-sm" disabled>
                                                    @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->am_terr_id}}">{{$terr->am_terr_id}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                    Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="mpo_terr" id="mpo_terr"
                                                        class="form-control input-sm" disabled>
                                                    @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->mpo_terr_id}}">{{$terr->mpo_terr_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rm_terr"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="bnd_name" id="bnd_name"
                                                        class="form-control input-sm">
                                                    <option value="">Select Brand</option>
                                                    @foreach($brand_name as $brands)
                                                    <option value="{{$brands->brand_name}}">{{$brands->brand_name}}</option>
                                                    @endforeach
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


<div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
    <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
        <div class="panel">
            <img src="{{url('public/site_resource/images/processing.gif')}}"
                 alt="Loading Report Please wait..."><br>
        </div>
    </div>
</div>



<div class="row" id="report-body" style="display: none;">
    <div class="">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <div class="panel-body">



                    <form id="frm-example" action="" method="POST">

                        <div class="table-responsive">
                            <table id="doc_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>

                                    <th style="text-align: center"><input type="checkbox" id="selectAll">All</th>
                                    <th>TERR_ID</th>
                                    <th>DOCTOR ID</th>
                                    <th>DOCTOR NAME</th>
                                    <th>BRAND NAME</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>

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


{{Html::script('public/site_resource/js/dataTables.select.min.js')}}



{{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
{{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
{{Html::script('public/site_resource/js/buttons.flash.min.js')}}

{{Html::script('public/site_resource/js/jszip.min.js')}}
{{Html::script('public/site_resource/js/pdfmake.min.js')}}
{{Html::script('public/site_resource/js/vfs_fonts.js')}}

{{Html::script('public/site_resource/js/buttons.html5.min.js')}}

{{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
{{Html::script('public/site_resource/js/rm_portal_scripts/brandWiseDocDelete.js')}}
{{Html::script('public/site_resource/js/toast/toastr.min.js')}}


<script type="text/javascript">
    servloc_loc = "{{url('rm_portal/brandWiseDoc')}}";
    servloc_tid = "{{url('rm_portal/itemWiseMpoTerrList')}}";
    servloc_am = "{{url('rm_portal/regWTerrAmList')}}";
    servloc_bnd = "{{url('rm_portal/getBrandsTw')}}";
    servloc_data = "{{url('rm_portal/brandWiseDocData')}}";
    servloc_deleteData = "{{url('rm_portal/brandWiseDocDelete')}}";

    eid = "{{Auth::user()->user_id}}";
    desig = "{{Auth::user()->desig}}";
    _token = "{{Session::token()}}";
</script>


@endsection