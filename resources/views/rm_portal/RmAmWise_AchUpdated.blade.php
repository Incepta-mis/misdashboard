@extends('_layout_shared._master')
@section('title', 'Terr Wise Achievement')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('public/site_resource/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
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

        .table>thead>tr>th {
            padding: 1px;
            font-size: 10px;
        }

        .table>tbody>tr>td {
            padding: 1px;
            font-size: 10px;
        }

        .table>tfoot>tr>td {
            padding: 1px;
            font-size: 10px;
        }

        .table>tfoot th,
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
                        RM/AM Sales Achievement  - <span style="color:red"> ( {{ $workingDate[0]->wdate }}) </span>
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">


                        @if (Auth::user()->desig === 'GM')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label for="rm_terr" class="col-lg-6 col-md-6 col-sm-12 control-label"><b>SM Terr
                                                Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="sm_terr" id="sm_terr" class="form-control input-sm rm_terr">
                                                    <option value="">Select SM Territory</option>
                                                    @foreach ($sm_terr as $terr)
                                                        <option value="{{ $terr->sm_emp_id }}">{{ $terr->sm_name }} - {{ $terr->sm_emp_id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{-- <div class="row"> --}}
                                            <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>DSM Terr
                                                Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="dsm_terr" id="dsm_terr" class="form-control input-sm rm_terr">
                                                    <option value="" >Select DSM Territory</option>
                                                    @foreach ($dsm_terr as $terr)
                                                        <option value="{{ $terr->dsm_emp_id }}">{{ $terr->dsm_name }} - {{ $terr->dsm_emp_id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{-- <div class="row"> --}}
                                            <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>Region Terr
                                                Id:</b></label>
                                            <div class="col-md-6">
                                                <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr">
                                                    <option value="">Select RM Territory</option>
                                                    <option value="All" >All</option>
                                                    @foreach ($rm_terr as $terr)
                                                        <option value="{{ $terr->rm_terr_id }}">{{ $terr->rm_terr_id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{-- <div class="row"> --}}
                                            <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                            <div class="col-md-6">
                                                <select name="brand_name" id="brand_name"
                                                    class="form-control input-sm brand_name">
                                                    <option value="">Select Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm"
                                                style="display: none">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->desig === 'SM')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>SM Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="sm_terr" id="sm_terr" class="form-control input-sm rm_terr" disabled>
                                                <option value="">Select SM Territory</option>
                                                <option value="{{ Auth::user()->user_id }}" selected>{{ Auth::user()->name }} - {{ Auth::user()->user_id }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>DSM Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="dsm_terr" id="dsm_terr" class="form-control input-sm rm_terr">
                                                <option value="" >Select DSM Territory</option>
                                                @foreach ($dsm_terr as $terr)
                                                    <option value="{{ $terr->dsm_emp_id }}">{{ $terr->dsm_name }} - {{ $terr->dsm_emp_id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>Region Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr">
                                                <option value="">Select RM Territory</option>
                                                <option value="All" >All</option>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->rm_terr_id }}">{{ $terr->rm_terr_id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="brand_name" id="brand_name"
                                                class="form-control input-sm brand_name">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                     <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->desig === 'DSM')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>SM Terrds
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="sm_terr" id="sm_terr" class="form-control input-sm rm_terr" disabled>
                                                <option value="">Select  SM Territory</option>
                                                <option value="{{ $sm_terr->sm_emp_id }}" selected>{{ $sm_terr->sm_name }} - {{ $sm_terr->sm_emp_id }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>DSM Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="dsm_terr" id="dsm_terr" class="form-control input-sm rm_terr" disabled>
                                                <option value="" >Select DSM Territory</option>
                                                <option value="{{ Auth::user()->user_id }}" selected>{{ Auth::user()->name }} - {{ Auth::user()->user_id }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>Region Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr">
                                                <option value="">Select RM Territory</option>
                                                <option value="All" >All</option>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->rm_terr_id }}">{{ $terr->rm_terr_id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="brand_name" id="brand_name"
                                                class="form-control input-sm brand_name">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                     <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->desig === 'NSM' ||
                                Auth::user()->desig === 'All' ||
                                Auth::user()->desig === 'HO')

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rm_terr" class="col-md-6 col-sm-12 control-label"><b>Region Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr">
                                                <option value="">Select RM Territory</option>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->rm_terr_id }}">{{ $terr->rm_terr_id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_month" class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="am_terr" id="am_terr" class="form-control input-sm am_terr">
                                                <option value="">Select Territory</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="brand_name" id="brand_name"
                                                class="form-control input-sm brand_name">
                                                <option value="">Select Brand</option>


                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm"
                                                style="display: none">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if (Auth::user()->desig === 'RM' || Auth::user()->desig === 'ASM')

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_month" class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr"
                                                disabled>
                                                <option value="{{ Auth::user()->terr_id }}">{{ Auth::user()->terr_id }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_group" class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="am_terr" id="am_terr" class="form-control input-sm am_terr">
                                                <option value="">Select Territory</option>
                                                <option value="All">All</option>
                                                @foreach ($am_terr as $terr)
                                                    <option value="{{ $terr->am_terr_id }}">{{ $terr->am_terr_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="brand_name" id="brand_name"
                                                class="form-control input-sm brand_name">
                                                <option value="">Select Brand</option>


                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Auth::user()->desig === 'AM' || Auth::user()->desig === 'Sr. AM')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_month" class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr"
                                                disabled>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->rm_terr_id }}">{{ $terr->rm_terr_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_group" class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="am_terr" id="am_terr" class="form-control input-sm am_terr"
                                                disabled>
                                                <option value="{{ Auth::user()->terr_id }}">{{ Auth::user()->terr_id }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="brand_name" id="brand_name"
                                                class="form-control input-sm brand_name">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                   <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                            <button type="button" id="btn_display" class="btn btn-info btn-sm">
                                                <i class="fa fa-check"></i> <b>Display Report</b></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Auth::user()->desig === 'MPO' || Auth::user()->desig === 'Sr. MPO')
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_month" class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="rm_terr" id="rm_terr" class="form-control input-sm rm_terr"
                                                disabled>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->rm_terr_id }}">{{ $terr->rm_terr_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_group" class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="am_terr" id="am_terr" class="form-control input-sm am_terr"
                                                disabled>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->am_terr_id }}">{{ $terr->am_terr_id }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_month" class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                Id:</b></label>
                                        <div class="col-md-6">
                                            <select name="mpo_terr" id="mpo_terr" class="form-control input-sm mpo_terr"
                                                disabled>
                                                @foreach ($rm_terr as $terr)
                                                    <option value="{{ $terr->mpo_terr_id }}">{{ $terr->mpo_terr_id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="p_name" class="col-md-6 col-sm-6 control-label"><b>Brand
                                                Name:</b></label>
                                        <div class="col-md-6">
                                            <select name="brand_name" id="brand_name"
                                                class="form-control input-sm brand_name">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                   <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-lg-12">
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
                <img src="{{ url('public/site_resource/images/preloader.gif') }}" alt="Loading Report Please wait..."
                    width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>



    <div class="row" id="report-body" style="display: none;">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    {{-- <div class="table table-responsive">
                        <table id="example" class="display table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">PRODUCT NAME</th>
                                    <th>QT/VALUE</th>
                                    <th>TARGET</th>
                                    <th>SOLD</th>
                                    <th>INT</th>
                                    <th>EXPECTED</th>
                                    <th>ACH%</th>
                                </tr>
                            </thead>
                            <tfoot id="tbl_body_data">

                            </tfoot>
                        </table>
                        
                    </div>
                    <div class="table table-responsive">
                            <div class="col-md-4 col-lg-4">
                                <button type="button" class="btn btn-info btn-sm" id="exapnd_btn">Expand</button>
                            </div>
                    </div> --}}
                    

                    <div class="table table-responsive" id="table2">
                        <table id="example" class="display table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr class="bg-dark">
                                    <th class="text-center">PRODUCT NAME</th>
                                    <th>TARGET QTY</th>
                                    <th>SOLD QTY</th>
                                    <th>INT QTY</th>
                                    <th>EXPECTED QTY</th>
                                    <th>ACH%</th>

                                </tr>
                            </thead>
                            <tfoot id="tbl_body_data2">

                            </tfoot>
                        </table>
                        
                    </div>
                </div>
                <div class="panel-body">
                    
                </div>
            </section>
        </div>
    </div>


@endsection
@section('footer-content')
    {{ date('Y') }} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{ Html::script('public/site_resource/js/jquery.dataTables.min.js') }}
    {{ Html::script('public/site_resource/js/dataTables.bootstrap.min.js') }}
    {{ Html::script('public/site_resource/js/dataTables.fixedHeader.min.js') }}

    {{ Html::script('public/site_resource/js/dataTables.select.min.js') }}


    {{ Html::script('public/site_resource/js/dataTables.buttons.min.js') }}
    {{ Html::script('public/site_resource/js/buttons.bootstrap.min.js') }}
    {{ Html::script('public/site_resource/js/buttons.flash.min.js') }}

    {{ Html::script('public/site_resource/js/jszip.min.js') }}
    {{ Html::script('public/site_resource/js/pdfmake.min.js') }}
    {{ Html::script('public/site_resource/js/vfs_fonts.js') }}

    {{ Html::script('public/site_resource/js/buttons.html5.min.js') }}

    {{ Html::script('public/site_resource/js/dataTables.rowsGroup.js') }}

    {{ Html::script('public/site_resource/js/toast/toastr.min.js') }}

    {{ Html::script('public/site_resource/select2/select2.min.js') }}

    <script type="text/javascript">
        var auth_id = "{{ Auth::user()->user_id }}";
        var desig = "{{ Auth::user()->desig }}";

        $('.sm_terr').select2();
        $('.dsm_terr').select2();
        $('.rm_terr').select2();
        $('.am_terr').select2();
        $('.mpo_terr').select2();
        $('.p_group').select2();
        $('.p_name').select2();
        $('.brand_name').select2();


        $("#sm_terr").on('change', function() {
            var sm_terr = $("#sm_terr").val();
            var url = "{{ url('rm_portal/regWDsmTerrAmDataList') }}";
            if(desig=='GM'){

            }else if(desig=='SM'){
                if (sm_terr) {
                    $("#btn_display").css("display", "block");
                } else {
                    $("#btn_display").css("display", "none");
                }
            }
           
            

            $("#dsm_terr").empty().append("<option value='loader'>Loading...</option>");
            $("#rm_terr").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: {
                    smTerr: sm_terr,
                    auth_id: auth_id,
                    desig: desig
                },
                success: function(response) {

                    var selOptsDSM = "";
                    selOptsDSM += "<option value=''>Select DSM Territory</option>";
                    for (var i = 0; i < response.dsm_terr.length; i++) {
                        var id = response.dsm_terr[i]['dsm_emp_id'];
                        var val = response.dsm_terr[i]['dsm_name']+" - "+response.dsm_terr[i]['dsm_emp_id'];
                        selOptsDSM += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#dsm_terr').empty().append(selOptsDSM);

                    var selOptsRM = "";
                    selOptsRM += "<option value=''>Select RM Territory</option>";
                    selOptsRM += "<option value='All'>All</option>";
                    for (var i = 0; i < response.rm_terr.length; i++) {
                        var id = response.rm_terr[i]['rm_terr_id'];
                        var val = response.rm_terr[i]['rm_terr_id'];
                        selOptsRM += "<option value='" + id + "'>" + val + "</option>";
                    }

                    $('#rm_terr').empty().append(selOptsRM);
                },
                error: function(response) {
                    console.log(response);
                }
            });

        });

        $("#dsm_terr").on('change', function() {
            var dsm_terr = $("#dsm_terr").val();
            var sm_terr = $("#sm_terr").val();
            var url = "{{ url('rm_portal/regWRmTerrAmDataList') }}";
           
            $("#rm_terr").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: {
                    dsmTerr: dsm_terr,
                    smTerr: sm_terr,
                    auth_id: auth_id,
                    desig: desig
                },
                success: function(response) {
                    var selOptsDSM = "";
                    selOptsDSM += "<option value=''>Select RM Territory</option>";
                    selOptsDSM += "<option value='All'>All</option>";
                    for (var i = 0; i < response.rm_terr.length; i++) {
                        var id = response.rm_terr[i]['rm_terr_id'];
                        var val = response.rm_terr[i]['rm_terr_id'];
                        selOptsDSM += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#rm_terr').empty().append(selOptsDSM);
                },
                error: function(response) {
                    console.log(response);
                }
            });

        });


        $("#rm_terr").on('change', function() {
            var rm_terr = $("#rm_terr").val();
            if(desig=='GM'){
                var url = "{{ url('rm_portal/getRmAmPgroupByBrand') }}";
                // $("#brand_name").empty().append("<option value='loader'>Loading...</option>");
            }else{
                var url = "{{ url('rm_portal/regWTerrAmDataList') }}";
                $("#am_terr").empty().append("<option value='loader'>Loading...</option>");
            }
           
            if (rm_terr) {
                $("#btn_display").css("display", "block");
            } else {
                $("#btn_display").css("display", "none");
            }

            
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: {
                    rmTerr: rm_terr,
                    auth_id: auth_id,
                    desig: desig,
                    amTerr:'',
                },
                success: function(response) {
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
                error: function(response) {
                    console.log(response);
                }
            });

        });

        $("#am_terr").on('change', function() {
            var am_terr = $("#am_terr").val();
            var smrm_id = $("#rm_terr").val();
            console.log(am_terr, smrm_id);
            var url = "{{ url('rm_portal/getRmAmPgroupByBrand') }}";

            $("#brand_name").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                data: {
                    amTerr: am_terr,
                    rmTerrId: smrm_id
                },
                success: function(response) {
                    var selBrand = '';
                    selBrand += "<option value=''>Select Product</option>";
                    // selBrand += "<option value='All'>All</option>";
                    for (var k = 0; k < response.length; k++) {
                        var id = response[k]['brand_name'];
                        var val = response[k]['brand_name'];
                        selBrand += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('#brand_name').empty().append(selBrand);
                },
                error: function(response) {
                    console.log(response);
                }
            });
        });

        $("#mpo_terr").on('change', function() {

            $("#p_group").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: "{{ url('rm_portal/getPgroup') }}",
                dataType: 'json',
                success: function(response) {
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
                error: function(response) {
                    console.log(response);
                }
            });
        });

        $("#p_group").on('change', function() {
            var p_group = $('#p_group').val();
            $("#brand_name").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: "{{ url('rm_portal/getRmAmPgroupByBrand') }}",
                dataType: 'json',
                data: {
                    p_group: p_group
                },
                success: function(response) {
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
                error: function(response) {
                    console.log(response);
                }
            });
        });

        $("#brand_name").on('change', function() {
            var brand_name = $('#brand_name').val();
            var p_group = $('#p_group').val();
            $("#p_name").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "GET",
                url: "{{ url('rm_portal/getProudctNamebyPGroup') }}",
                dataType: 'json',
                data: {
                    brand_name: brand_name,
                    p_group: p_group
                },
                success: function(response) {
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
                error: function(response) {
                    console.log(response);
                }
            });
        });

        function validation(){
            
        }

        $('#btn_display').on('click', function() {

            $("#loader").show();
            $("#report-body").hide();

            var sm_terr = $('#sm_terr').val();
            var dsm_terr = $('#dsm_terr').val();
            var rm_terr = $('#rm_terr').val();
            var am_terr = $('#am_terr').val();
            var mpo_terr = $('#mpo_terr').val();
            var p_group = $('#p_group').val();
            var brand_name = $('#brand_name').val();
            var p_code = $('#p_name').val();
            var auth_id = "{{ Auth::user()->user_id }}";
            var desig = "{{ Auth::user()->desig }}";
            var url = "{{ url('rm_portal/getRmAmAch') }}";
            console.log(auth_id);
            
            if((desig=='GM' || desig=='SM' || desig=='DSM') && (!rm_terr || !brand_name)){
                $("#loader").hide();
                alert('Please fill up all the entities');
            }else{
                $.ajax({
                    // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                    type: "post",
                    url: url,
                    data: {
                        'sm_terr': sm_terr,
                        'dsm_terr': dsm_terr,
                        'rm_terr': rm_terr,
                        'am_terr': am_terr,
                        'mpo_terr': mpo_terr,
                        'brand_name': brand_name,
                        'p_group': p_group,
                        'p_code': p_code,
                        'desig': desig,
                        'auth_id': auth_id,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $("#loader").hide();
                        $("#report-body").show();
                        $("#tbl_body_data2").empty().append(`
                            ${data}
                        `);
                    },
                    error: function(e) {
                        $("#loader").hide();
                        console.log('Error : ', e);
                    }
                });
            }



        });

        $('#exapnd_btn').on("click",function(){
            if($(this).text()=='Expand'){
                $(this).text('Collapse')
                $('#table2').show('slow');
                $(this).removeClass('btn-info').addClass('btn-danger');
            }else{
                $(this).text('Expand');
                $('#table2').hide('slow');
                $(this).removeClass('btn-danger').addClass('btn-info');
            }
        })
        $(document).on("click","#produt_wise_details",function(){
            var rclass = $(this).data('id');
            $('.'+rclass).each(function(){
                $(this).toggle(500)
            })
        })

        $(document).on('click','#tbl_body_data2 tr',function(){
           
            if(desig=='GM' || desig=='SM' || desig=='DSM'){
                next = $(this).data('next');
                $('.next-'+next).each(function(){
                    if($(this).css('display')=='none'){
                        $(this).show(500);
                    }else{
                        $(this).hide(500);
                        $('.'+next+"-child").each(function(){
                            $(this).hide(500);
                        })
                    }
                })
            }
            
        });
    </script>

    
@endsection
