@extends('_layout_shared._master')
@section('title','Employee history Report Panel')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/select.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/select2.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/selectize.default.css')}}">
    <style>
        .panel-heading {
            padding: 10px 15px 10px 15px;
        }

        .text-primary {
            color: #ffffff;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 13px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 12px;
        }

        .select2 > .select2-choice.ui-select-match {
            /* Because of the inclusion of Bootstrap */
            height: 29px;
        }

        .selectize-control > .selectize-dropdown {
            top: 36px;
        }

        .select2-results .select2-highlighted {
            background: #2a6496;
            color: #fff;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-search-choice-close {
            top: 3px;
        }

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

        body {
            color: #000000;
        }

        td.detail {
            cursor: pointer;
        }

        div.slider {
            display: none;
        }

    </style>
@endsection
@section('right-content')
    <div style="margin-left:0px" ng-app="quizApp">
        <!-- <toaster-container toaster-options="{'position-class':'toast-top-center'}"></toaster-container> -->
        <div style="margin-left:0px" class="row">
            <div style="margin-left:0px" class="col-sm-8 col-sm-offset-2 col-md-10 col-md-offset-2">
                <section class="panel panel-primary">
                    <header class="panel-heading custom-tab dark-tab">
                        <ul class="nav nav-tabs">
                            <!-- <li class="active">
                                <a href="#send_ntf" data-toggle="tab"> <i class="fa fa-bell"></i> Send Notice</a>
                            </li> -->
                            <li class="active">
                                <a href="#ntf_log" data-toggle="tab"> <i class="fa fa-list-alt"></i> Employee history Report</a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            
                              
                            <div class="tab-pane active" id="ntf_log" ng-controller="logController">
                                <div class="adv-table table-responsive">
                                    <table id="t_notifications"
                                           class="table table-bordered table-condensed table-striped" width="100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Emp_id</th>
                                            <th>Employee Name</th>
                                            <th>NID</th>
                                            <th>Gender </th>
                                            <!-- <th>Phone (Officical)</th> -->

                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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
    <script src="{{url('public/site_resource/js/ng/angular_1.6.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-sanitize.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/select.js')}}"></script>
    <script src="{{url('public/site_resource/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript">

        var app = angular.module('quizApp', ['toaster', 'angular-loading-bar', 'ngAnimate', 'ui.select'])
            .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false;
            }]);

        app.controller('ntfController', function ($scope, appService) {
            $scope.isSending = false;
            $scope.message = '';
            $scope.title = '';

            $scope.groupList = [];
            $scope.getGroupsData = function () {
                appService.requestPost('post', '{{route('get_group_list')}}', null).then(function (value) {
                    $scope.groupList = value;
                    appService.log('retrieved', $scope.groupList);
                });
            };

            $scope.getGroupsData();
            $scope.selectedGroup = {};
            $scope.selectedGroup.data = [];
            $scope.omitSelectedGroups = function (data) {
                return $scope.selectedGroup.data.indexOf(data) === -1;
            };

            $scope.sendNotification = function () {
                if ($scope.performCheck()) {
                    $scope.isSending = true;
                    appService.log('sending', $scope.selectedGroup.data);
                    appService.requestPost(
                        'post', '{{route('send_notice')}}',
                        {groups: $scope.selectedGroup.data, message: $scope.message, title: $scope.title})
                        .then(function (value) {
                            $scope.isSending = false;
                            if (value.status === 'success') {
                                appService.log('status', value);
                                appService.requestPost('post', '{{route('save_ntf')}}', {
                                    groups: $scope.selectedGroup.data,
                                    message: $scope.message,
                                    title: $scope.title
                                })
                                    .then(function (response) {
                                        appService.log('save_ntf', response.status);
                                        appService.message('info', '', 'Notification Sent Successfully', 8000);
                                        appService.initialize_dtable(response.logs);
                                        $scope.clearAll();
                                    });
                            }
                        });
                } else {
                    appService.log("Error", "message/title not given");
                    appService.message('error', '', 'Group,Title,Message is required', 8000);
                }

            };

            $scope.clearAll = function () {
                appService.log('btn clear', "clearing ...")
                $scope.message = '';
                $scope.title = '';
                $scope.selectedGroup.data.length = 0;
            };

            $scope.refreshList = function () {
                $scope.getGroupsData();
            };

            $scope.performCheck = function () {
                var isValid = false;
                if ($scope.title.length > 0 && $scope.message.length > 0 && $scope.selectedGroup.data.length > 0) {
                    isValid = true;
                } else {
                    isValid = false;
                }
                return isValid;
            };
        });

        app.controller('logController', function ($scope, appService) {
            angular.element(document).ready(function () {
                // appService.requestPost('post', '{{route('get_logs')}}', null)
                //     .then(function (value) {
                //         appService.log('get_logs', value);
                //         appService.initialize_dtable(value);
                //     });

                    appService.requestPost('post', '{{route('getEmpWiseRpt')}}', null)
                    .then(function (value) {
                        appService.log('getEmpWiseRpt', value);
                        appService.initialize_dtable(value);
                    });
            });
        });

        app.service('appService', function ($http, toaster, $log) {
            return {
                requestPost: function (type, url, data) {
                    return $http({
                        url: url,
                        method: type,
                        data: data
                    }).then(function (value) {
                        $log.log(value.data);
                        return value.data
                    }, function (reason) {
                        $log.log(reason);
                    });
                },
                message: function (type, title, message, duration) {
                    toaster.pop(type, title, message, duration);
                },
                log: function (info, message) {
                    $log.log(info);
                    $log.log(message);
                },
                initialize_dtable: function (value) {
                    var dtable = $('#t_notifications');
                    dtable.DataTable().destroy();
                    var table = dtable.DataTable({
                        data: value,
                        columns: [
                            {
                                className: 'detail text-center',
                                data: null,
                                orderable: false,
                                defaultContent: '',
                                render: function () {
                                    return '<i class="fa fa-plus-square" aria-hidden="true"></i>';
                                }
                            },
                            {data: 'emp_id'},
                            {data: 'name', orderable: false},
                            {data: 'empnid',
                             orderable: false,
                             render:function (data) {
                                 return data.substr(0,50)+'...';
                             }
                            },
                            {data: 'empgender'},
                            // {data:'emp_mob_no_offi_d'}
                        ]
                    });

                    function format(data) {
                        return '<div class="slider">'+
                            '<table class="table table-condensed table-bordered table-hover" style="padding-left:50px;background-color: #F9F9F9;border: 2px solid #65CEA7;">' +
                            '<tr>' +
                            '<td>Emp Mail Official:</td>' +
                            '<td>' + data.emp_mail_offi_d + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Employee Type:</td>' +
                            '<td>' + data.emp_type_d + '</td>' +
                            '</tr>' +
                            '</table>'+
                            '</div>';
                    }

                    $('#t_notifications tbody').on('click', 'td.detail', function () {
                        var tr = $(this).closest('tr');
                        var row = table.row(tr);
                        var tdi = tr.find('i.fa');
                        console.log(row);
                        if (row.child.isShown()) {
                            $('div.slider',row.child()).slideUp(function () {
                                tr.removeClass('shown');
                                row.child.hide();
                                tdi.first().addClass('fa-plus-square');
                                tdi.first().removeClass('fa-minus-square');
                            });

                        } else {
                            row.child(format(row.data())).show();
                            tr.addClass('shown');
                            tdi.first().addClass('fa-minus-square');
                            tdi.first().removeClass('fa-plus-square');
                            $('div.slider',row.child()).slideDown();
                            $('div.slider').parents('tr').css({'background-color':'#f0fff0'});
                        }
                    });
                }
            }
        });
    </script>
@endsection
