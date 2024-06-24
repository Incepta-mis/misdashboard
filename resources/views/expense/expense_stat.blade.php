@extends('_layout_shared._master')
@section('title','Expense Statistics')
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
            font-size: 12px;
            text-align: center;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
            text-align: center;
        }

        body {
            color: black;
        }

        .padTop {
            padding-top: 4px;
        }

    </style>
@endsection
@section('right-content')
    <div ng-app="ExpStat" ng-controller="esController">
        <toaster-container></toaster-container>
        <div class="row">
            <div class=" col-md-offset-2 col-sm-8 col-md-8">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Expense Statistics
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <label for="" class="col-md-6 control-label padTop">Expense Month</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select name="_exp_mon" id="_exp_mon" ng-model="_smonth"
                                                class="form-control input-sm" ng-change="monthChange()">
                                            <option value="default">Select Month</option>
                                            @forelse($expense_months as $em)
                                                <option value="{{$em->acmon}}">{{$em->mon}}</option>
                                            @empty
                                                <option value="">Months Not Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label for="" class="control-label col-sm-3 col-md-3 padTop">Region</label>
                                    <div class="col-md-7 col-sm-7">
                                        <select name="_region" id="_region" ng-model="_sregion"
                                                class="form-control input-sm">
                                            <option value="default">Select Region</option>
                                            <option value="All">All</option>
                                            <option value="AR">All Region</option>
                                            <option value="@{{ed.rid}}" ng-repeat="ed in _esdata ">@{{ed.rid}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="row">
            <div class=" col-md-offset-2 col-sm-8 col-md-8">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class=" table-responsive">
                            <table class="table table-condensed table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th >Month</th>
                                    <th >Region</th>
                                    <th >Expense Send Employee Id</th>
                                    <th >Expense Approved Employee Id</th>
                                    <th >Expense Report Employee Id</th>
                                </tr>
                                </thead>
                                <tbody>
                                   <tr ng-repeat="ed in _esdata | filter: (_sregion == 'AR') ? '' :_sregion" ng-if="_sregion != 'All'">
                                       <td >@{{ ed.em }}</td>
                                       <td style="font-weight: bold;">@{{ ed.rid }}</td>
                                       <td >@{{ ed.es_eid }}</td>
                                       <td >@{{ ed.ea_eid }}</td>
                                       <td >@{{ ed.er_eid }}</td>
                                   </tr>
                                   <tr ng-if="_sregion == 'All' || _sregion == 'AR'">
                                        <td colspan="2" style="font-weight: bold;">All Total</td>
                                        <td style="font-weight: bold;">@{{totalEs}}</td>
                                        <td style="font-weight: bold;">@{{totalEa}}</td>
                                        <td style="font-weight: bold;">@{{totalEr}}</td>
                                    </tr>
                                   <tr ng-if="_esdata.length == 0">
                                       <td colspan="5"> No Data Available to Display</td>
                                   </tr>
                                </tbody>
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
    <script src="{{url('public/site_resource/js/ng/angular_1.6.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
    <script src="{{url('public/site_resource/js/custom/expense_stat.js')}}"></script>
    <script>
        _url = '{{url('expense/get_exp_mon')}}';
    </script>
@endsection