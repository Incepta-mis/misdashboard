@extends('_layout_shared._master')
@section('title','Daily Attendance Mail')
@section('styles')
    @include('_damail.damail_styles')
@endsection
@section('right-content')
    <div ng-app="dailyAttnMail" ng-controller="dam_controller">
        <toaster-container toaster-options="{'position-class': 'toast-top-right'}"></toaster-container>
        <div>
            <div class="col-md-6 col-md-offset-3 col-xs-12 col-sm-12" ng-cloak="">
                <div class="panel weather-info card">
                    {{-- <div class="turquoise-bg white-text top-radius">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="text-center">
                                        <i class="big-icon  ico-users2" style="font-size: 38px;"></i>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="text-center">
                                        <div><b>{{\Carbon\Carbon::now()->format('d-M-y')}}</b></div>
                                        <div>{{\Carbon\Carbon::now()->formatLocalized('%A')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="weather-location dark-turquoise-bg" style="padding: 10px 30px 10px 30px;">
                        <form role="form" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="fade in text-center" style="color:white;">
                                        <label class="radio-inline">
                                            <input type="radio" name="depttype" ng-model="dtype.type"
                                                   value="ALL">
                                            All Department
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="depttype" ng-model="dtype.type"
                                                   value="SEL">
                                            Selected Department
                                        </label>
                                        <br>
                                        <strong>N.B. Choose type by selecting the radio button.</strong>
                                    </div>
                                    <br>
                                    <div class="input-group date" id="work_date" style="margin-bottom: 10px;">
                                        <input type="text"
                                               class="form-control emp_mari_date_id"
                                               name="nwork_date"
                                               placeholder="Select Working date"
                                               id="id_work_date">
                                        <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                    </div>
                                    {{--                       department selection--}}
                                    <ui-select multiple ng-model="selectedDept.data" id="groups" theme="select2"
                                               ng-disabled="disabled" ng-if="dtype.type == 'SEL'">
                                        <ui-select-match placeholder="Select Departments...">
                                            @{{$item.dept}}
                                        </ui-select-match>
                                        <ui-select-choices
                                                repeat="dept in deptList |filter : omitSelectedDept | filter:$select.search"
                                        >
                                            <i class="fa fa-users"></i>
                                            @{{dept.dept}} | Total Employee: @{{dept.t_count}}
                                        </ui-select-choices>
                                    </ui-select>
                                    {{--                                            <input type="text" placeholder="Find Location" class="form-control find-loc">--}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="progress progress-striped active progress-sm" ng-if="isProcessing">
                        <div style="width: 100%"
                             aria-valuemax="100"
                             aria-valuemin="0"
                             aria-valuenow="100"
                             role="progressbar"
                             class="progress-bar progress-bar-primary">
                            <span class="sr-only">Working</span>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow-y: scroll; height: calc(100vh - 365px)">
                        <p class="badge badge-primary" style="margin-left: 20px;"><b>Processed Files: @{{ processedList.length }}</b></p>
                        <ul class="list-unstyled">
                            <li ng-if="processedList.length == 0" class="alert alert-info">
                                <center>
                                    <p style="font-weight: bold;padding: 10px;">
                                        <i class="fa fa-info"> <b>No processed Report Available</b></i>
                                    </p>
                                </center>
                            </li>
                            <li ng-if="processedList.length > 0"  class="row list-item"
                                ng-repeat="pl in processedList | orderBy: 'f_name' track by $index">
                                <div class="col-md-2 col-sm-2 col-xs-2 text-center">
                                    <img src="{{url('public/site_resource/images/pdf.png')}}" width="45px" alt="">
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-7" style="padding: 5px;">
                                    <span class="custom-text" title="@{{ pl.f_name }}"><b>@{{ shorten(pl.f_name) }}</b></span><br>
                                    <span><small class="text-muted">@{{ pl.c_date }}</small></span>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3 text-center" style="padding: 10px;">
                                    <button title="Send Individual Mail" ng-disabled="isProcessing" ng-click="send_mail(pl)">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                    <button title="View Report" ng-disabled="isProcessing" ng-click="view_file(pl)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </li>
                            {{--                            <sarsha-spinner name="spinner2"></sarsha-spinner>--}}
                        </ul>

                    </div>
                    <div class="panel-footer text-center">
                        <button class="btn btn-success btn-sm" ng-click="process('PS')" ng-disabled="isProcessing" title="Process and Send mail">
                            <i class="fa fa-envelope"></i>
                            Process & Send
                        </button>
                        <button class="btn btn-success btn-sm" ng-click="process('P')" ng-disabled="isProcessing" title="Process but don't send mail">
                            <i class="fa fa-gear"></i> 
                            Process
                        </button>
                        <button class="btn btn-success btn-sm" ng-click="refreshList()" ng-disabled="isProcessing" title="Refresh Records">
                            <i class="fa fa-refresh"></i> 
                            Reload
                        </button>
                        <button class="btn btn-success btn-sm" ng-click="display_modal()" ng-disabled="isProcessing" title="Create/Update/Delete Master Records">
                            <i class="fa fa-users"></i>
                            Maintain Records
                        </button>
{{--                        <button class="btn btn-success btn-sm" ng-click="send()"><i class="fa fa-envelope"></i> Send--}}
{{--                        </button>--}}
                    </div>
                </div>
            </div>
        </div>
        @include('_damail.damail_modal')
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    @include('_damail.damail_scripts')
@endsection