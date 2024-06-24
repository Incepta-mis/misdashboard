@extends('_layout_shared._master')
@section('title','Prescription Survey Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.css" rel="stylesheet"/>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}

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
                        Prescription Survey Report
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
{{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
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
                                                        <select name="exp_month" id="exp_month"
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
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                            ID:</b></label>
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
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>RM
                                                            Name:</b></label>
                                                    <div class="col-md-6">

                                                        <select name="smrm_name" id="smrm_name"
                                                                class="form-control input-sm" disabled>
                                                            <option value="{{Auth::user()->name}}">Select Territory
                                                            </option>
                                                            {{--                                                            <option value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

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
                                            {{-- First row ends here--}}

                                        </div>

                                        <div class="row">

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


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="brand_name"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand
                                                            Name:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="brand_name" id="brand_name"
                                                                class="form-control input-sm select2_search">
                                                            <option value="">Select Brand</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($brand_name as $bn)
                                                                <option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>
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

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')
                                        <div class="row">



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-6 col-sm-6 control-label"><b>Emp
                                                            Month:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="exp_month" id="exp_month"
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
                                                    <label for="rm_terr"
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
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>RM/ASM
                                                            Name:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="smrm_name" id="smrm_name"
                                                                class="form-control input-sm" disabled>
                                                            <option value="{{Auth::user()->name}}">{{Auth::user()->name}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

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

                                        </div>

                                    {{--First Row ends here --}}

                                        <div class="row">

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

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="brand_name"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand
                                                            Name:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="brand_name" id="brand_name"
                                                                class="form-control input-sm select2_search">
                                                            <option value="">Select Brand</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($brand_name as $bn)
                                                                <option value="{{$bn->brand_name}}">{{$bn->brand_name}}</option>
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
    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="doc_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>MPO Terr Id</th>
                                    <th>Doctor Id</th>
                                    <th>Doctor Name</th>
                                    <th>Plan Brand</th>
                                    <th>Visit Brand</th>
                                    <th>Survey Brand</th>
                                    {{--<th>Spec Code</th>--}}
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
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
    {{Html::script('public/site_resource/js/dcr_scripts/psr_script.js')}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script type="text/javascript">
        {{--  Select2 custom search function for matching input from the beginning of data--}}
        //         function matchStart(params, data) {
        //             // If there are no search terms, return all of the data
        //             if ($.trim(params.term) === '') {
        //                 return data;
        //             }
        //
        //             // Skip if there is no 'children' property
        //             if (typeof data.children === 'undefined') {
        //                 return null;
        //             }
        //
        //             // `data.children` contains the actual options that we are matching against
        //             var filteredChildren = [];
        //             $.each(data.children, function (idx, child) {
        //                 if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
        //                     filteredChildren.push(child);
        //                 }
        //             });
        //
        //             // If we matched any of the timezone group's children, then set the matched children on the group
        //             // and return the group object
        //             if (filteredChildren.length) {
        //                 var modifiedData = $.extend({}, data, true);
        //                 modifiedData.children = filteredChildren;
        //
        //                 // You can return modified objects from here
        //                 // This includes matching the `children` how you want in nested data sets
        //                 return modifiedData;
        //             }
        //
        //             // Return `null` if the term should not be displayed
        //             return null;
        //         }

        //  function ended
        $(document).ready(function () {
                $('.select2_search').select2({
                    // placeholder: "Select a State",
                    // allowClear: true
                    // minimumResultsForSearch: Infinity
                    theme: "classic"
                    // matcher: matchStart
                });
            }
        );
        servloc_tid = "{{url('dcrep/regwMpoTerrList')}}";
        servloc = "{{url('dcrep/prescripSurveyReport')}}";
        servloc_am = "{{url('dcrep/regWTerrAmList')}}";
        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";
        _csrf_token = '{{csrf_token()}}';
    </script>

@endsection