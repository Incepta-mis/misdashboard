@extends('_layout_shared._master')
@section('title','Employee Supervisor')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
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
            font-size: 14px;
            text-align: center;
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

        .lbl_custom {
            padding-left: 0px;
            padding-right: 0px;
            text-align: left;
        }

        @media (min-width: 992px) {
            .col-md-4 {
                width: 30.33333333%;
            }
        }

        .form-group {
            margin-bottom: 0px;
        }

        .padTop3 {
            padding-top: 3px;
        }

        .loading {
            background-color: #ffffff;
            background-image: url('{{url('public/site_resource/images/preloader.gif')}}');
            background-size: 25px 25px;
            background-position: right center;
            background-repeat: no-repeat;
            background-position-x: 90%;
        }

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

    </style>
@endsection
@section('right-content')
    <div ng-app="EmpSv" ng-controller="eSvController">
        <toaster-container></toaster-container>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Employee Supervisor
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                {{--company name--}}
                                <div class="col-sm-6 form-group">
                                    <label for="" class="col-sm-4 control-label padTop3">
                                        Company Name
                                    </label>
                                    <div class="col-sm-8">
                                        {{--@if(!(Auth::user()->desig === 'HO' || strtoupper(Auth::user()->desig) === 'ALL'))--}}
                                            {{--<select name="_cname" id="_cname" class="form-control input-sm"--}}
                                                    {{--ng-model="_cname" disabled>--}}
                                                {{--@foreach($company as $com)--}}
                                                    {{--<option value="{{$com->id}}">{{$com->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--@else--}}
                                            {{--<select name="_cname" id="_cname" class="form-control input-sm"--}}
                                                    {{--ng-change="deptList()"--}}
                                                    {{--ng-model="_cname">--}}
                                                {{--<option value="default">Select Company</option>--}}
                                                {{--@foreach($company as $com)--}}
                                                    {{--<option value="{{$com->id}}">{{$com->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        <!-- <input type="text" readonly name="_cname" id="_cname" ng-model="_cname" class="form-control input-sm" value="{{$user_infos[0]->company_name}}">
 -->
                                         <select name="_cname" id="_cname" class="form-control input-sm" ng-model="_cname" disabled>
                                            <option value="{{$user_infos[0]->com_id}}">{{$user_infos[0]->company_name}}</option>
                                        </select>

                                        {{--@endif--}}
                                    </div>
                                </div>
                                {{--departments--}}
                                <div class="col-sm-6 form-group">
                                    <label for="" class="col-sm-4 control-label padTop3">
                                        Department Name
                                    </label>
                                    <div class="col-sm-8">
                                        <!-- <input type="text" readonly name="_dname" id="_dname" class="form-control input-sm" ng-model="_dname" value="{{$user_infos[0]->dept_name}}"> -->

                                        {{--@if(!(Auth::user()->desig === 'HO' || strtoupper(Auth::user()->desig) === 'ALL'))--}}
                                            {{--<select name="_dname" id="_dname" class="form-control input-sm"--}}
                                                    {{--ng-model="_dname" disabled>--}}
                                                {{--@foreach($department as $dept)--}}
                                                    {{--<option value="{{$dept->id}}">{{$dept->name}}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--@else--}}
                                            {{--<select name="_dname" id="_dname" class="form-control input-sm"--}}
                                                    {{--ng-class="deptLoader"--}}
                                                    {{--ng-model="_dname" ng-change="getEmployees()">--}}
                                                {{--<option value="default">Select Department</option>--}}
                                                {{--<option ng-repeat="dept in departments" value="@{{dept.id}}">--}}
                                                    {{--@{{dept.name}}--}}
                                                {{--</option>--}}
                                            {{--</select>--}}
                                        {{--@endif--}}

                                          <select name="_dname" id="_dname" class="form-control input-sm" ng-model="_dname" disabled>
                                            <option value="{{$user_infos[0]->dept_id}}">{{$user_infos[0]->dept_name}}</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row padTop3">
                                {{--emp supervisor--}}
                                <div class="col-sm-6 form-group">
                                    <label for="" class="col-sm-4 control-label padTop3">
                                        Emp. Supervisor
                                    </label>
                                    <div class="col-sm-8">
                                        <select name="_esv" id="_esv" class="form-control input-sm" ng-model="_esv">
                                            <option value="NEW">NEW</option>
                                            <option value="EXT">ASSIGNED</option>
                                        </select>
                                    </div>
                                </div>
                                {{--employee code/name--}}
                                <div class="col-sm-6 form-group">
                                    <label for="" class="col-sm-4 control-label padTop3">
                                        Emp. Code/Name
                                    </label>
                                    <div class="col-sm-8">
                                        {{--<select name="_ename" id="_ename" class="form-control input-sm"--}}
                                                {{--ng-class="empLoader"--}}
                                                {{--ng-model="_ename">--}}
                                            {{--<option value="default">Select Employee</option>--}}
                                            {{--<option value="All">All</option>--}}
                                            {{--<option value="@{{ emp.id }}" ng-repeat="emp in employeesList">--}}
                                                {{--@{{ emp.name }}--}}
                                            {{--</option>--}}
                                        {{--</select>--}}


                                        <select name="_ename" id="_ename" ng-model="_ename" class="form-control input-sm">
                                            {{--<option disabled selected>Select Company Name</option>--}}
                                            <option value="">Select Employee</option>
                                            <option value="All">All</option>
                                            @foreach($emp_list as $emp_name)
                                                <option value="{{$emp_name->emp_id}}">{{$emp_name->emp_id}} {{$emp_name->sur_name}}</option>
                                            @endforeach
                                        </select>
                                        {{--</select>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="row " style="padding-top: 7px;padding-left: 6px;">
                                <div class="col-sm-2 col-sm-offset-2">
                                    <button class="btn btn-sm btn-success" ng-click="submitRequest()">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!--Loader -->
        <div class="row" ng-hide="displayResult" ng-cloak>
            <div class="col-md-12 col-sm-12" id="loader" style="margin-top: 55px;padding-bottom: 55px;">
                <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                    <div class="panel">
                        <img src="{{url('public/site_resource/images/preloader.gif')}}" width="35px" height="35px"
                             alt="Loading Report Please wait..."><br>
                        <span><b><i>Please wait...</i></b></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" ng-show="displayResult" ng-cloak>
            <div class="col-sm-12 col-md-12" ng-show="employees.length > 0">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Supervisor Employee Code</th>
                                    <th>Supervisor Employee Name</th>
                                    <th>Valid</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="emp in employees">
                                    <td>@{{ $index+1 }}</td>
                                    <td class="text-center" ng-cloak>@{{ emp.eid }}</td>
                                    <td class="text-center" ng-cloak>@{{ emp.ename }}</td>
                                    <td class="text-center" ng-cloak>@{{ emp.edesig }}</td>
                                    <td class="text-center"><input type="text" size="12" ng-disabled="emp.d == 1"
                                                                   ng-model="emp.seid"></td>
                                    <td class="text-center">


                                        <select name="_ename" id="_ename_selopt" ng-disabled="emp.d == 1" ng-model="emp.seid" ng-change="nameChanged(emp)" class="form-control input-sm">

                                            @foreach($emp_list as $emp_name)

                                                <option value="{{$emp_name->emp_id}}">{{$emp_name->sur_name}}</option>

                                            @endforeach
                                        </select>

                                    </td>

                                    <!-- <td class="text-center"><input type="text" size="40" ng-disabled="emp.d == 1"
                                                                   ng-model="emp.sename"></td> -->
                                    <td class="text-center"><select name="" id="" ng-disabled="emp.d == 1"
                                                                    ng-model="emp.valid">
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="col-sm-4 col-sm-offset-4 col-xs-12" ng-cloak>
                                <div class="col-sm-4" ng-hide="_HBE" style="padding-right: 0px;">
                                    <button title="Edit Record" class="btn btn-sm btn-default btn-block"
                                            ng-disabled="_DBE"
                                            ng-click="performEdit()">
                                        Edit
                                    </button>
                                </div>
                                <div class="col-sm-8" ng-hide="_HBS">
                                    <button title="Save Record" class="btn btn-sm btn-default  btn-block"
                                            ng-click="performSave()">
                                        Save
                                    </button>
                                </div>
                                <div class="col-sm-4" ng-hide="_HBU" style="padding-left: 0px;padding-right: 0px;">
                                    <button title="Update Record" class="btn btn-sm btn-default  btn-block"
                                            ng-disabled="_DBU"
                                            ng-click="performUpdate()">
                                        Update
                                    </button>
                                </div>
                                <div class="col-sm-4" ng-hide="_HBC" style="padding-left: 0px;">
                                    <button title="Update Record" class="btn btn-sm btn-default  btn-block"
                                            ng-disabled="_DBC"
                                            ng-click="performCancel()">
                                        Cancel
                                    </button>
                                </div>
                            </div>
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
    <script src="{{url('public/site_resource/js/ng/angular_1.6.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
    <script src="{{url('public/site_resource/js/custom/emp_sv.js')}}"></script>
    <script>
         _desig = '{{Auth::user()->desig}}';
         _purl = '{{url('emp_comp/param_data')}}';
         _durl = '{{url('emp_comp/dept_data')}}';
         _eurl = '{{url('emp_comp/emp_data')}}';
         _surl = '{{url('emp_comp/save_record')}}';
         _uurl = '{{url('emp_comp/update_record')}}';
    </script>
@endsection