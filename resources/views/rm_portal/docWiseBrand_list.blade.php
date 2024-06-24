@extends('_layout_shared._master')
@section('title','Doctor Brand')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link href="{{ url('public/site_resource/css/jquery.ui.autocomplete.css')}}" rel="stylesheet"/>


    <style>

        /*.fixed {position:fixed;
            top: 30px; left:0;}*/

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
                        Doctor Brand
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
                                                           class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="rm_terr" id="rm_terr" class="form-control input-sm">
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
                                                           class="col-md-6 col-sm-6 control-label"><b>Am Terr Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="am_terr" id="am_terr" class="form-control input-sm" >
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>MPO Terr Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="mpo_terr" id="mpo_terr" class="form-control input-sm" >
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Search By:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="ser_by" id="ser_by" class="form-control input-sm" >
                                                            <option value="">Select Id / Name</option>
                                                            <option value="doc_id">Doctor Id</option>
                                                            <option value="doc_name">Doctor Name</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div1" class="group" style="display: none;">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input class="form-control input-sm autocomplete_txt docband" type='text' data-type="doctorname" id='doctorname_1' name='doctorname[]'/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="float: right">
                                                    <div class="form-group">
                                                        <label for="bnd"  class="col-md-6 col-sm-6 control-label"><b>Brand:</b></label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <select name="bnd" id="bnd" class="form-control input-sm" >
                                                                <option value="">Select Brand</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div2" class="group" style="display: none;">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input class="form-control input-sm autocomplete_txt" type='text' data-type="doctorid" id='doctorid_1' name='doctorid[]'/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="float: right">
                                                    <div class="form-group">
                                                        <label for="bnd"  class="col-md-6 col-sm-6 control-label"><b>Brand:</b></label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <select name="bndx" id="bndx" class="form-control input-sm" >
                                                                <option value="">Select Brand</option>

                                                            </select>
                                                        </div>
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

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM' || Auth::user()->desig === 'MPO' || Auth::user()->desig === 'AM')
                                    <div class="row">

                                       <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="emp_month"
                                                       class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                        Id:</b></label>
                                                <div class="col-md-6">
                                                    <select name="rm_terr" id="rm_terr" class="form-control input-sm" readonly="">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="emp_month"
                                                       class="col-md-6 col-sm-6 control-label"><b>Am Terr Id:</b></label>
                                                <div class="col-md-6">
                                                    <select name="am_terr" id="am_terr" class="form-control input-sm"
                                                    >
                                                        <option value=""  >Select Territory</option>
                                                        @foreach($am_terr as $terr)
                                                            <option value="{{$terr->am_terr_id}}" >
                                                                {{$terr->am_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 bs-month">
                                            <div class="form-group">
                                                <label for="emp_month"
                                                       class="col-md-6 col-sm-6 control-label"><b>MPO Terr Id:</b></label>
                                                <div class="col-md-6">
                                                    <select name="mpo_terr" id="mpo_terr" class="form-control input-sm" >
                                                        <option value="">Select Territory</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="emp_month"
                                                       class="col-md-6 col-sm-6 control-label"><b>Search By:</b></label>
                                                <div class="col-md-6">
                                                    <select name="ser_by" id="ser_by" class="form-control input-sm" >
                                                        <option value="">Select Id / Name</option>
                                                        <option value="doc_id">Doctor Id</option>
                                                        <option value="doc_name">Doctor Name</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="div1" class="group" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input class="form-control input-sm autocomplete_txt" type='text' data-type="doctorname" id='doctorname_1' name='doctorname[]'/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="float: right">
                                                <div class="form-group">
                                                    <label for="bnd"  class="col-md-6 col-sm-6 control-label"><b>Brand:</b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select name="bnd" id="bnd" class="form-control input-sm" >
                                                            <option value="">Select Brand</option>


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="div2" class="group" style="display: none;">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input class="form-control input-sm autocomplete_txt" type='text' data-type="doctorid" id='doctorid_1' name='doctorid[]'/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="float: right">
                                                <div class="form-group">
                                                    <label for="bnd"  class="col-md-6 col-sm-6 control-label"><b>Brand:</b></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <select name="bndx" id="bndx" class="form-control input-sm" >
                                                            <option value="">Select Brand</option>


                                                        </select>
                                                    </div>
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
    <div class="row" id="report-body" style="display: none;">

        <div class="col-sm-12 col-md-12" id="task_flyout">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title" id="brand_len"> </h3>
                </div>
                <div class="panel-body" id="brCnt">
                    Panel content
                </div>
            </div>
        </div>

        <div class="">
            <div class="col-sm-12 col-md-12">

                <section class="panel" id="data_table">
                    <div class="panel-body table-responsive">
                       
                        <table id="doc_list" class="table table-condensed table-striped table-bordered"
                               width="100%">
                            <thead style="white-space:nowrap;">
                           
                            <tr>
                                <th>MPO Terr Id</th>
                                <th>Doctor Id</th>
                                <th>Doctor Name</th>
                                <th>Brand Name</th>
                                {{--<th>Item Id</th>--}}
                                {{--<th>Item Name</th>--}}
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                            <tfoot>
                            <tr>
                            </tr>
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
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>--}}
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

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/rm_portal_scripts/docbrand_script.js')}}


    <script type="text/javascript">
        servloc_tid = "{{url('rm_portal/docMpoTerrListTr')}}";
        servloc = "{{url('rm_portal/docBrandwList')}}";
        servloc_am = "{{url('rm_portal/regWTerrAmList')}}";
        servloc_bnd = "{{url('rm_portal/doctorBrandName')}}";
        servloc_bndid = "{{url('rm_portal/doctorBrandId')}}";
        servloc_test = "{{url('rm_portal/searchajax')}}";
        brandCount = "{{url('rm_portal/brandCountDoc')}}";

        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";
    </script>


@endsection