@extends('_layout_shared._master')
@section('title','Terr Wise Achievement')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
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
            padding: 1px;
            font-size: 10px;
        }

        .table > tbody > tr > td {
            padding: 1px;
            font-size: 10px;
        }

        .table > tfoot > tr > td {
            padding: 1px;
            font-size: 10px;
        }

        .table > tfoot th,
        tfoot td {
            font-size: 10px;

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
                        Territory Wise Sales Achievement - <span style="color:red"> ( {{ $workingDate[0]->wdate  }}) </span>
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">


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
                                                    class="form-control input-sm rm_terr">
                                                <option value="">Select RM Territory</option>
                                                <option value="All">All</option>
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
                                                    class="form-control input-sm am_terr">
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
                                                    class="form-control input-sm mpo_terr">
                                                <option value="">Select Territory</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 col-md-12">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Group:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_group" id="p_group"
                                                        class="form-control input-sm p_group">
                                                    <option value="">Select Group</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="brand_name" id="brand_name"
                                                        class="form-control input-sm brand_name">
                                                    <option value="">Select Brand</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_name" id="p_name"
                                                        class="form-control input-sm p_name">
                                                    <option value="">Select Product</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sa_name"
                                               class="col-md-6 col-sm-6 control-label"><b>Sales Area Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="sa_name" id="sa_name"
                                                    class="form-control input-sm">
                                                <option value="">Select Sales Area Name</option>
                                                <option value="All">All</option>
                                                @foreach($sales_ar_name as $sa_names)
                                                    <option value="{{$sa_names->sales_area_name}}">{{$sa_names->sales_area_name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-7">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
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
                                                    class="form-control input-sm rm_terr" disabled>
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
                                                    class="form-control input-sm am_terr">
                                                <option value="">Select Territory</option>
                                                <option value="All">All</option>
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
                                                    class="form-control input-sm mpo_terr">
                                                <option value="">Select Territory</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 col-md-12">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Group:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_group" id="p_group"
                                                        class="form-control input-sm p_group">
                                                    <option value="">Select Group</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="brand_name" id="brand_name"
                                                        class="form-control input-sm brand_name">
                                                    <option value="">Select Brand</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_name" id="p_name"
                                                        class="form-control input-sm p_name">
                                                    <option value="">Select Product</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sa_name"
                                               class="col-md-6 col-sm-6 control-label"><b>Sales Area Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="sa_name" id="sa_name"
                                                    class="form-control input-sm">
                                                <option value="">Select Sales Area Name</option>
                                                <option value="All">All</option>
                                                @foreach($sales_ar_name as $sa_names)
                                                    <option value="{{$sa_names->sales_area_name}}">{{$sa_names->sales_area_name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-7">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
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
                                                    class="form-control input-sm rm_terr" disabled>
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
                                                    class="form-control input-sm am_terr" disabled>
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
                                                    class="form-control input-sm mpo_terr">
                                                <option value="">Select Territory</option>
                                                <option value="All">All</option>
                                                @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->mpo_terr_id}}">{{$terr->mpo_terr_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Group:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_group" id="p_group"
                                                        class="form-control input-sm p_group">
                                                    <option value="">Select Group</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="brand_name" id="brand_name"
                                                        class="form-control input-sm brand_name">
                                                    <option value="">Select Brand</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_name" id="p_name"
                                                        class="form-control input-sm p_name">
                                                    <option value="">Select Product</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sa_name"
                                               class="col-md-6 col-sm-6 control-label"><b>Sales Area Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="sa_name" id="sa_name"
                                                    class="form-control input-sm">
                                                <option value="">Select Sales Area Name</option>
                                                <option value="All">All</option>
                                                @foreach($sales_ar_name as $sa_names)
                                                    <option value="{{$sa_names->sales_area_name}}">{{$sa_names->sales_area_name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-7">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
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
                                                    class="form-control input-sm rm_terr" disabled>
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
                                                    class="form-control input-sm am_terr" disabled>
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
                                                    class="form-control input-sm mpo_terr" disabled>
                                                @foreach($rm_terr as $terr)
                                                    <option value="{{$terr->mpo_terr_id}}">{{$terr->mpo_terr_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12 col-md-12">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_group"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Group:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_group" id="p_group"
                                                        class="form-control input-sm p_group">
                                                    <option value="">Select Group</option>
                                                    <option value="All">All</option>
                                                    @foreach($p_group as $group)
                                                        <option value="{{$group->p_group}}">{{$group->p_group}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Brand
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="brand_name" id="brand_name"
                                                        class="form-control input-sm brand_name">
                                                    <option value="">Select Brand</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="p_name"
                                                   class="col-md-6 col-sm-6 control-label"><b>Product
                                                    Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="p_name" id="p_name"
                                                        class="form-control input-sm p_name">
                                                    <option value="">Select Product</option>


                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sa_name"
                                               class="col-md-6 col-sm-6 control-label"><b>Sales Area Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="sa_name" id="sa_name"
                                                    class="form-control input-sm">
                                                <option value="">Select Sales Area Name</option>
                                                <option value="All">All</option>
                                                @foreach($sales_ar_name as $sa_names)
                                                    <option value="{{$sa_names->sales_area_name}}">{{$sa_names->sales_area_name}}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-7">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

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
        <div class="col-sm-12 col-md-12 col-xs-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="table table-responsive" >
                        <table id="example" class="display table table-bordered table-striped"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>TERR_ID</th>
                                <th>P_GROUP</th>
                                <th>BRAND_NAME</th>
                                <th>P_CODE</th>
                                <th>P_NAME</th>
                                <th>PACK_SIZE</th>
                                <th>TP</th>
                                <th>TGT_QTY</th>
                                <th>TGT_VAL</th>
                                <th>INT_QTY</th>
                                <th>INT_VAL</th>
                                <th>SOLD_QTY</th>
                                <th>SOLD_VAL</th>
                                <th>EXP_QTY</th>
                                <th>EXP_VAL</th>
                                <th>ACH%</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th colspan="6" ></th>
                                <th style="text-align:right">Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
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

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">

        var auth_id = "{{ Auth::user()->user_id }}";
        var desig = "{{ Auth::user()->desig }}";

        $('.rm_terr').select2();
        $('.am_terr').select2();
        $('.mpo_terr').select2();
        $('.p_group').select2();
        $('.p_name').select2();
        $('.brand_name').select2();
        $('#sa_name').select2();

        $("#rm_terr").on('change', function () {

            var rm_terr = $("#rm_terr").val();
            var url = "{{ url('rm_portal/regWTerrAmDataList') }}";

            $("#am_terr").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: {rmTerr: rm_terr, auth_id: auth_id, desig: desig},
                success: function (response) {


                    var selOptsAM = "";
                    selOptsAM += "<option value=''>Select Territory</option>";
                    selOptsAM += "<option value='All'>All</option>";
                    for (var i = 0; i < response.length; i++) {
                        var id = response[i]['am_terr_id'];
                        var val = response[i]['am_terr_id'];
                        selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#am_terr').empty().append(selOptsAM);
                },
                error: function (response) {
                    console.log(response);
                }
            });

        });

        $("#am_terr").on('change', function () {
            var am_terr = $("#am_terr").val();
            var smrm_id = $("#rm_terr").val();
            var url = "{{ url('rm_portal/itemWiseMpoTerrList') }}";

            $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: {amTerr: am_terr, rmTerrId: smrm_id},
                success: function (response) {
                    var selOptsMPO = "";
                    selOptsMPO += "<option value=''>Select Territory</option>";
                    selOptsMPO += "<option value='All'>All</option>";
                    for (var j = 0; j < response.length; j++) {
                        var id = response[j]['mpo_terr_id'];
                        var val = response[j]['mpo_terr_id'];
                        selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#mpo_terr').empty().append(selOptsMPO);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $("#mpo_terr").on('change', function () {

            $("#p_group").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: "{{ url('rm_portal/getPgroup') }}",
                dataType: 'json',
                success: function (response) {
                    var selBrand = '';
                    selBrand += "<option value=''>Select Group</option>";
                    selBrand += "<option value='All'>All</option>";
                    for (var k = 0; k < response.length; k++) {
                        var id = response[k]['p_group'];
                        var val = response[k]['p_group'];
                        selBrand += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#p_group').empty().append(selBrand);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $("#p_group").on('change', function () {
            var p_group = $('#p_group').val();
            $("#brand_name").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: "{{ url('rm_portal/getPgroupByBrand') }}",
                dataType: 'json',
                data: {p_group: p_group},
                success: function (response) {
                    var selBrand = '';
                    selBrand += "<option value=''>Select Product</option>";
                    selBrand += "<option value='All'>All</option>";
                    for (var k = 0; k < response.length; k++) {
                        var id = response[k]['brand_name'];
                        var val = response[k]['brand_name'];
                        selBrand += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#brand_name').empty().append(selBrand);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $("#brand_name").on('change', function () {

            var brand_name = $('#brand_name').val();
            var p_group = $('#p_group').val();
            $("#p_name").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: "{{ url('rm_portal/getProudctNamebyPGroup') }}",
                dataType: 'json',
                data: {brand_name: brand_name, p_group: p_group},
                success: function (response) {
                    var selBrand = '';
                    selBrand += "<option value=''>Select Product</option>";
                    selBrand += "<option value='All'>All</option>";
                    for (var k = 0; k < response.length; k++) {
                        var id = response[k]['p_code'];
                        var val = response[k]['name'];
                        selBrand += "<option value='" + id + "'>" + id + " - " + val + "</option>";
                    }
                    $('#p_name').empty().append(selBrand);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });


        $('#btn_display').on('click', function () {

            $("#loader").show();
            $("#report-body").hide();

            var rm_terr = $('#rm_terr').val();
            var am_terr = $('#am_terr').val();
            var mpo_terr = $('#mpo_terr').val();
            var p_group = $('#p_group').val();
            var brand_name = $('#brand_name').val();
            var p_code = $('#p_name').val();
            var sa_name = $('#sa_name').val();


            var auth_id = "{{ Auth::user()->user_id }}";
            var desig = "{{ Auth::user()->desig }}";
            var url = "{{ url('rm_portal/getAch') }}";
            console.log(auth_id);

            $.ajax({
                // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                type: "post",
                url: url,
                data: {
                    'rm_terr': rm_terr,
                    'am_terr': am_terr,
                    'mpo_terr': mpo_terr,
                    'brand_name': brand_name,
                    'p_group': p_group,
                    'p_code': p_code,
                    'sa_name': sa_name,
                    'desig': desig,
                    'auth_id': auth_id,
                    '_token': "{{ csrf_token() }}",
                },
                success: function (data) {

                    console.log(data)


                    $("#loader").hide();
                    $("#report-body").show();

                    $("#example").DataTable().destroy();
                    table = $("#example").DataTable({

                        data: data,
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                className: 'btn-warning',
                                exportOptions: [  6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ],
                                footer: true
                            }
                        ],
                        autoWidth: true,
                        columns: [
                            {data: 'terr_id'},
                            {data: 'p_group'},
                            {data: 'brand_name'},
                            {data: 'p_code'},
                            {data: 'p_name'},
                            {data: 'pack_size'},
                            {data: 'tp'},
                            {data: 'target_qty'},
                            {data: 'target_value'},
                            {data: 'int_qty'},
                            {data: 'int_value'},
                            {data: 'sold_qty'},
                            {data: 'sold_value'},
                            {data: 'exp_sale_qty'},
                            {data: 'exp_sale_value'},
                            {data: 'achivement'}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        columnDefs: [
                            {
                                // "targets": [0, 1],
                                // "visible": false
                            }
                        ],
                        info: true,
                        paging: false,
                        filter: true,
                        footerCallback: function ( row, data, start, end, display ) {
                            var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };


                            // Total over all pages
                            total_7 = api
                                .column( 7 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_7 = api
                                .column( 7, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 7).footer() ).html(
                                // pageTotal_7 +' ( '+ total_7 +' total)'
                                total_7
                            );


                            // Total over all pages
                            total = api
                                .column( 8 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal = api
                                .column( 8, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 8 ).footer() ).html(
                                // pageTotal +' ( '+ total +' total)'
                                total
                            );


                            // Total over all pages
                            total_9 = api
                                .column( 9 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_9  = api
                                .column( 9, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 9 ).footer() ).html(
                                total_9
                                // pageTotal_9 +' ( '+ total_9 +' total)'
                            );

                            // Total over all pages
                            total_10 = api
                                .column( 10 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_10  = api
                                .column( 10, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 10 ).footer() ).html(
                                // pageTotal_10 +' ( '+ total_10 +' total)'
                                total_10
                            );

                            // Total over all pages
                            total_11 = api
                                .column( 11 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_11  = api
                                .column( 11, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 11 ).footer() ).html(
                                // pageTotal_11 +' ( '+ total_11 +' total)'
                                total_11
                            );

                            // Total over all pages
                            total_12 = api
                                .column( 12 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_12  = api
                                .column( 12, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 12 ).footer() ).html(
                                // pageTotal_12 +' ( '+ total_12 +' total)'
                                total_12
                            );

                            // Total over all pages
                            total_13 = api
                                .column( 13 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_13  = api
                                .column( 13, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 13 ).footer() ).html(
                                // pageTotal_13 +' ( '+ total_13 +' total)'
                                total_13
                            );

                            // Total over all pages
                            total_14 = api
                                .column( 14 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Total over this page
                            pageTotal_14  = api
                                .column( 14, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 ).toFixed(2);

                            // Update footer
                            $( api.column( 14 ).footer() ).html(
                                // pageTotal_14 +' ( '+ total_14 +' total)'
                                total_14
                            );
                        }
                    });
                },
                error: function (e) {
                    console.log('Error : ', e);
                }
            });


        });

    </script>


@endsection