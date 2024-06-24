@extends('_layout_shared._master')
@section('title','Doctor Maintenance Report')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/liveSearch/liveSearch.css')}}">
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        textarea {
            resize: vertical;
        }

        .panel-custom {
            border: 1px solid;
            border-color: #2a6496 !important;
        }

        .box-shadow {
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, .05);
        }

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 1.4rem;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: #000000;
        }

        input {
            color: black;
        }


    </style>
@endsection
@section('right-content')
    <div ng-app="dmrApp" ng-controller="dmrAppController">
        <toaster-container toaster-options="{'position-class': 'toast-top-center'}"></toaster-container>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Doctor Information</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <live-search id="doc_id"
                                             type="text"
                                             live-search-callback="searchDoctor"
                                             live-search-item-template=
                                             '<span style="padding:5px;">
                                             <i class="fa fa-user-md"></i> @{{ result.doctor_id }} - @{{ result.name | uppercase }}
                                             </span>'
                                             live-search-select="doctor_id"
                                             ng-model="search"
                                             class="form-control">
                                </live-search>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" ng-click="displayInformation()">
                                        <i class="fa fa-user-md"></i> Display Doctor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" ng-hide="initialLoad" ng-cloak="">
            <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
                <div class="panel panel-primary">
                    {{--<div class="panel-heading">--}}
                    {{--<h3 class="panel-title">Doctor Maintenance Report</h3>--}}
                    {{--</div>--}}
                    <div class="panel-body" ng-hide="showLoader">
                        <div class="row">
                            <div class="col-md-5 " ng-cloak="" style="font-size: 1.5rem;">
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Doctor Id:</span> @{{ doctor.doctor_id  }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Doctor Name:</span> @{{ doctor.name}}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Designation:</span> @{{ doctor.designation |capitalize }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Qualification:</span> @{{ doctor.qualification }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Sex:</span> @{{ doctor.sex |capitalize }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Speciality:</span> @{{ doctor.spec_code |capitalize }}</span><br>
                            </div>
                            <div class="col-md-7 " ng-cloak="" style="font-size: 1.5rem;">
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Region:</span> @{{ doctor.region |capitalize }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Main Territory:</span> @{{ doctor.terr_id }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Chamber Address:</span> @{{ doctor.chember_address |capitalize }}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Hospital Address:</span> @{{ doctor.hospital_addr |capitalize}}</span><br>
                                <span style="padding: 5px;"><span class="text-primary" style="font-weight: bold;">Doctor Status:</span> @{{ doctor.doctor_status |capitalize}}</span><br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12 col-sm-12" ng-cloak="">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center text-primary">Sl.</th>
                                            <th class="text-center text-primary">In Favour Of</th>
                                            <th class="text-center text-primary">Terr Id</th>
                                            <th class="text-center text-primary">MPO Id</th>
                                            <th class="text-center text-primary">MPO Name</th>
                                            <th class="text-center text-primary">Visiting Address</th>
                                            <th class="text-center text-primary">Guest</th>
                                            <th class="text-center text-primary">Patient</th>
                                            <th class="text-center text-primary">Valid</th>
                                            <th class="text-center text-primary">Doc. Cata.</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="t in terr">
                                            <td>@{{ $index+1 }}</td>
                                            <td style="white-space: nowrap;">@{{ t.ifo | lowercase }}</td>
                                            <td style="white-space: nowrap;">@{{ t.terr }}</td>
                                            <td>@{{ t.eid }}</td>
                                            <td style="white-space: nowrap;">@{{ t.ename |lowercase }}</td>
                                            <td>@{{ t.vaddr |lowercase }}</td>
                                            <td>@{{ t.guest }}</td>
                                            <td>@{{ t.patient }}</td>
                                            <td>@{{ t.valid }}</td>
                                            <td>@{{ t.cata }}</td>
                                        </tr>
                                        <tr ng-if="terr.length == 0">
                                            <td colspan="10" class="text-center">No Records Found!!</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" ng-if="showLoader">
                        <div class="text-center">
                            <img src="{{url('public/site_resource/images/c_loading.gif')}}" width="100px" height="100px"
                                 alt="content_loading">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <script src="{{url('public/site_resource/js/ng/angular_1.6.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-sanitize.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/liveSearch/liveSearch.js')}}"></script>
    <script src="{{url('public/site_resource/js/custom/dmr_app.js')}}"></script>
    <script>
        _url_search = '{{route('search_doc')}}';
        _url_dinfo = '{{route('doc_info')}}';
    </script>
@endsection
