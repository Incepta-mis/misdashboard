@extends('_layout_shared._master')
@section('title','SMS')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/select.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/select2.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/css/ng-css/selectize.default.css')}}">
    {{--    <link rel="stylesheet" href="{{url('public/site_resource/css/tree-style.css')}}">--}}
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        textarea {
            resize: vertical;
        }

        .form-control {
            border-radius: 0;
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
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 1.4rem;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .modal-body {
            max-height: calc(100vh - 210px);
        }

        .modal-header {
            background: #5A89BC;
        }

        body {
            color: #000000;
        }

        .pagination {
            margin-top: 0px;
        }

        input {
            color: black;
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

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

    </style>
@endsection
@section('right-content')
    <div ng-app="smsApp">
        <toaster-container toaster-options="{'position-class': 'toast-top-center'}"></toaster-container>
        <div class="col-md-10 col-md-offset-1">
            <section class="panel">
                <header class="panel-heading custom-tab">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#sms" data-toggle="tab"><i class="fa fa-envelope-o"></i> Send SMS</a>
                        </li>
                        <li class="">
                            <a href="#contact" data-toggle="tab"><i class="fa fa-edit"></i> Manage Contacts</a>
                        </li>
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active" ng-controller="smsController" id="sms">
                            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                                <div class="alert alert-info fade in text-center">
                                    <label class="radio-inline">
                                        <input type="radio" name="smstype" ng-model="sms.type" value="M">Multiple
                                        Number
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="smstype" ng-model="sms.type" value="S">Single
                                        Number
                                    </label>
                                    <br>
                                    <strong>N.B. Choose send type by selecting the radio button.</strong>
                                </div>

                            </div>
                            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12" ng-cloak>
                                <div>
                                    <div ng-if="sms.type == 'M'">
                                        <ui-select multiple ng-model="selectedGroup.data" id="groups" theme="select2"
                                                   ng-disabled="disabled">
                                            <ui-select-match placeholder="Select Groups..."
                                            >@{{$item.grp_name}}
                                            </ui-select-match>
                                            <ui-select-choices repeat="grp in groupList |
                                                       filter : omitSelectedGroups | filter:$select.search">
                                                <i class="fa fa-book"></i> @{{grp.grp_name}} | Total Cotacts:
                                                @{{grp.t_count}}
                                            </ui-select-choices>
                                        </ui-select>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="form-group" ng-show="sms.type == 'S'">
                                        <label for="to" class="control-label">To</label>
                                        <input type="text" id="to" name="to" ng-model="to" class="form-control"
                                               placeholder="eg:8801766666180">
                                    </div>

                                    <div class="form-group">
                                        <label for="message" class="control-label">Message Text</label>
                                        <textarea type="text" id="message" class="form-control" name="message"
                                                  ng-model="message"
                                                  rows="6" ng-change="countCharacter()">
                                        </textarea>
                                        <small class="text-muted badge badge-primary" ng-if="message">
                                            <b>Character Count: @{{messageLength }}</b>
                                        </small>
                                    </div>
                                    <div class="col-md-8 col-md-offset-2 text-center">
                                        @if(strtoupper(Auth::user()->terr_id) == 'IT')
                                            <button type="button" class="btn btn-info btn-sm" ng-click="smsText()">
                                                <span ng-hide="isWorking"><i class="fa fa-file"></i> Sms Text</span>
                                                <span ng-show="isWorking" ng-disabled="isSending"><i
                                                            class="fa fa-spinner fa-spin"></i> Working..</span>
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-success btn-sm" ng-click="sendSMS()">
                                            <span ng-hide="isSending"><i class="fa fa-envelope"></i> Send</span>
                                            <span ng-show="isSending" ng-disabled="isSending"><i
                                                        class="fa fa-spinner fa-spin"></i> Sending</span>

                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm" ng-click="clearAll()">
                                            <i class="fa fa-reply"></i>
                                            Clear
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary" ng-hide="sms.type == 'S'"
                                                ng-click="refreshList()">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" ng-controller="contactController" id="contact">
                            <div class="row">
                                <div>
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-sm btn-success" ng-click="createList()">
                                            <i class="fa fa-plus-circle"></i>
                                            Create Number List
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-primary"
                                                ng-click="refreshList()">
                                            <i class="fa fa-refresh"></i>
                                            Refresh list
                                        </button>
                                    </div>
                                    <div class="col-md-12 col-sm-12" style="padding-top: 10px;">
                                        <div class="table-responsive" ng-cloak>
                                            <table class="table table-condensed table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center" ng-hide="true"><input type="checkbox"></th>
                                                    <th class="text-center">Group Name</th>
                                                    <th class="text-center">Total Contacts</th>
                                                    {{--<th class="text-center">Create Date</th>--}}
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr dir-paginate="d in groupData | itemsPerPage:8" pagination-id="pg1">
                                                    <td class="text-center" ng-hide="true">
                                                        <input type="checkbox" ng-model="isChecked"
                                                               ng-click="enableControl()">
                                                    </td>
                                                    <td style="padding-left: 5px;padding-top: 8px;"><i
                                                                class="fa fa-book"></i>
                                                        @{{d.grp_name}}
                                                    </td>
                                                    <td class="text-center" style="padding-left: 5px;padding-top: 8px;">
                                                        <i class="fa fa-users"></i> @{{d.t_count}}
                                                    </td>
                                                    {{--<td class="text-center">@{{d.cd|date:'medium'}}</td>--}}
                                                    <td class="text-center">
                                                        <button type="button" ng-click="modifyList(d)"
                                                                ng-disabled="d.create_user !== 'Y'"
                                                                class="btn btn-sm btn-primary"
                                                                title="Edit contacts under this group">
                                                            <i class="fa fa-edit"> <b>Edit contacts</b></i>
                                                        </button>
                                                        |
                                                        <button type="button" ng-click="deleteGroup(d)"
                                                                class="btn btn-sm btn-danger"
                                                                title="Delete this group"
                                                                ng-disabled="d.create_user !== 'Y'">
                                                            <i class="fa fa-minus-circle"> <b>Delete group</b></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr ng-if="groupData.length == 0">
                                                    <td colspan="4" class="text-center">
                                                        <br>
                                                        <img src="{{url('public/site_resource/images/contacts_logo.png')}}"
                                                             alt="no contacts" width="80" height="80">
                                                        <br>
                                                        <b>!!No Contacts Available!!</b>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <dir-pagination-controls max-size="5" pagination-id="pg1"
                                                                     direction-links="true"
                                                                     boundary-links="true">
                                            </dir-pagination-controls>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--edit contacts--}}
                            @include('sms_layout.edit_contacts')
                            {{--create new list--}}
                            @include('sms_layout.create_list')
                        </div>
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
    <script src="{{url('public/site_resource/js/ng/angular_1.6.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/dirPagination.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-sanitize.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/select.js')}}"></script>
    {{--    <script src="{{url('public/site_resource/js/tree.min.js')}}"></script>--}}
{{--    <script src="{{url('public/site_resource/js/custom/smsapp.js')}}"></script>--}}
    <script>

        /*
        Coder:Md. Raqib Hasan
        Date Created: 25/06/18
        */
        "use strict";

        var _url_soap = '{{route('soap_send')}}';
        var _url_usave = '{{route('upload_save')}}';
        var _url_grp = '{{route('grp_list')}}';
        var _url_scntct = '{{route('save_contact')}}';
        var _url_clist = '{{route('contacts')}}';
        var _url_upd = '{{route('update')}}';
        var _url_del = '{{route('delete')}}';
        var _url_dgp = '{{route('delete_grp')}}';
        var _url_stext = '{{route('sms_text')}}';
        var allowedType = '{{strtoupper(Auth::user()->terr_id)}}';

        var app = angular.module('smsApp', ['angular-loading-bar', 'ngAnimate',
            'toaster', 'angularUtils.directives.dirPagination', 'ui.select', 'ngSanitize'])
            .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeSpinner = false;
            }]);

        app.controller('smsController', ['$scope', '$log', 'http_service', 'toaster',
            function ($scope, $log, http_service, toaster) {

                var log = function (data) {
                    $log.log(data);
                };

                $scope.isSending = false;
                $scope.isWorking = false;
                $scope.messageLength = 0;

                $scope.to = '';
                $scope.message = '';
                $scope.sms = {
                    type: 'M'
                };

                $scope.groupList = [];
                $scope.getGroupsData = function () {
                    http_service.request_post(_url_grp, {}).then(function (value) {
                        $scope.groupList = value;
                        log($scope.groupList);
                    });
                };

                $scope.getGroupsData();
                $scope.selectedGroup = {};
                $scope.selectedGroup.data = [];
                $scope.omitSelectedGroups = function (data) {
                    return $scope.selectedGroup.data.indexOf(data) === -1;
                };

                $scope.refreshList = function () {
                    http_service.request_post(_url_grp, {}).then(function (value) {
                        $scope.groupList = value;
                        log($scope.groupList);
                    });
                };

                $scope.smsText = function () {
                    log('retrieving');
                    $scope.isWorking = true;
                    http_service.request_post(_url_stext, {}).then(function (value) {
                        // log(value);
                        $scope.isWorking = false;
                        if (value) {
                            $scope.message = '';
                            $scope.message = value;
                            angular.element('#message').height(200);
                        }

                    });
                };

                $scope.sendSMS = function () {
                    log('button clicked');
                    log($scope.sms.type);

                    if ($scope.sms.type === 'S') {
                        if ($scope.to === '' || $scope.message === '') {
                            toaster.pop('error', 'Error', 'Please enter number/sms text', 5000);
                        } else if ($scope.to.length < 13) {
                            toaster.pop('error', 'Error', 'Please add 88 before number', 5000);
                        } else {
                            $scope.isSending = true;
                            http_service.request_post(_url_soap, {
                                type: $scope.sms.type,
                                to: $scope.to.trim(),
                                content: $scope.message.trim()
                            }).then(function (value) {
                                // console.log(value);
                                $scope.isSending = false;
                                var text = $scope.readXML(value);
                                if(allowedType === 'IT'){
                                    toaster.pop(text.status ==='success' ? 'info' : 'error', '', 'Sending Status: ' + text.status +", SMS Count: "+text.smscount+", Available Credit: "+text.credit, 10000);
                                }else{
                                    toaster.pop(text.status ==='success' ? 'info' : 'error', '', 'Sending Status ' + text.status, 5000);
                                }

                            });
                        }
                    } else if ($scope.sms.type === 'M') {
                        if ($scope.selectedGroup.data.length === 0 || $scope.message === '') {
                            toaster.pop('error', 'Error', 'Please select group/enter message', 5000);
                        } else {
                            $scope.isSending = true;
                            http_service.request_post(_url_soap, {
                                type: $scope.sms.type,
                                to: $scope.selectedGroup.data,
                                content: $scope.message.trim()
                            }).then(function (value) {
                                // console.log(value);
                                $scope.isSending = false;
                                var text = $scope.readXML(value);
                                if(allowedType === 'IT'){
                                    toaster.pop(text.status ==='success' ? 'info' : 'error', '', 'Sending Status: ' + text.status +", SMS Count: "+text.smscount+", Available Credit: "+text.credit, 10000);
                                }else{
                                    toaster.pop(text.status ==='success' ? 'info' : 'error', '', 'Sending Status ' + text.status, 5000);
                                }
                                $scope.clearAll();
                            });
                        }
                    }

                };

                $scope.clearAll = function () {
                    $log.log('clearing');
                    $scope.to = '';
                    $scope.message = '';
                    $scope.sms.type = 'M';
                    $scope.selectedGroup.data.length = 0;
                };

                $scope.readXML = function (text) {
                    // console.log(text);
                    var response = {};
                    var parser = new DOMParser();
                    var xmlDoc = parser.parseFromString(text, 'text/xml');

                    if (xmlDoc.getElementsByTagName('Status')[0] !== undefined) {
                        // console.log(xmlDoc.getElementsByTagName('Status')[0]);
                        response.status = xmlDoc.getElementsByTagName('StatusText')[0].childNodes[0].nodeValue;
                        response.smscount = xmlDoc.getElementsByTagName('SMSCount')[0].childNodes[0].nodeValue;
                        response.credit = xmlDoc.getElementsByTagName('CurrentCredit')[0].childNodes[0].nodeValue;
                    } else {
                        console.log('Error Occurred');
                        response.status = "failed";
                    }

                    // console.log(response);
                    return response;
                };

                $scope.countCharacter = function () {
                    if ($scope.message)
                        $scope.messageLength = $scope.message.length;
                };
            }]);

        app.controller('contactController', ['$scope', '$log', 'toaster', 'http_service',
            function ($scope, $log, toaster, http_service) {
                $scope.fileArr = [];
                $scope.searchText = '';

                var log = function (data) {
                    $log.log(data);
                };
                $scope.isSending = false;

                $scope.fileExt = '';
                $scope.btn_control = true;
                $scope.isChecked = false;
                // $scope.grpType = 'NEW';
                $scope.uploadType = {
                    type: 'F'
                };
                $scope.contact = {
                    grp: 'NEW',
                    ngname: '',
                    emp_id: '',
                    emp_name: '',
                    c_no: ''
                };
                $scope.grpList = [];
                $scope.contactList = [];

                $scope.fetchGroups = function () {
                    http_service.request_post(_url_grp, {}).then(function (value) {
                        $scope.grpList = value;
                        log($scope.grpList);
                    });
                };

                $scope.displayAllGroups = function () {
                    http_service.request_post(_url_grp, {}).then(function (value) {
                        $scope.groupData = value;
                    });
                };

                $scope.displayAllGroups();

                $scope.enableControl = function () {
                    log('enabling controls');
                    log($scope.isChecked);

                    if ($scope.isChecked) {
                        // console.log($scope.isChecked);
                        $scope.btn_control = false;
                    }
                };

                $scope.refreshList = function () {
                    log('button clicked');
                    $scope.displayAllGroups();
                };

                //create list modal
                $scope.createList = function () {
                    log('button clicked');
                    angular.element('#createList').modal('show');
                    $scope.fetchGroups();
                };

                //on file input change
                $scope.fileChanged = function (files) {
                    log(files[0]);
                    $scope.fileArr.length = 0;
                    $scope.fileArr.push(files[0]);
                };

                //upload the requested file
                $scope.upload = function () {
                    if ($scope.uploadType.type === 'F') {

                        if ($scope.fileArr.length > 0) {
                            $scope.fileExt = $scope.fileArr[0].name.substr($scope.fileArr[0].name.indexOf('.') + 1, 4);
                            if ($scope.fileExt.toUpperCase() === 'XLS' || $scope.fileExt.toUpperCase() === 'XLSX') {
                                log($scope.fileArr[0]);
                                $scope.isSending = true;
                                var fd = new FormData();
                                fd.append('utype', $scope.uploadType.type);
                                fd.append('file', $scope.fileArr[0]);
                                http_service.file_save(_url_usave, fd).then(function (value) {
                                    if (value === 'OK') {
                                        toaster.pop('info', '', 'Contacts Uploaded Successfully', 6000);
                                        $scope.fetchGroups();
                                    }
                                    $scope.isSending = false;
                                });
                            } else {
                                log('File extension not correct');
                                toaster.pop('info', 'message', 'File type must be xls/xlsx', 4000);
                            }
                        } else {
                            toaster.pop('error', '', 'Please select a file!', 6000);
                        }
                    } else {
                        log($scope.contact);
                        if ($scope.contact.grp === 'NEW') {
                            if ($scope.contact.ngname !== '' && $scope.contact.c_no !== '' && $scope.contact.emp_id !== '') {
                                log('New Contact');
                                log($scope.contact);
                                $scope.isSending = true;
                                http_service.request_post(_url_scntct, $scope.contact).then(function (value) {
                                    log(value);
                                    if (angular.isArray(value)) {
                                        $scope.grpList = value;
                                        toaster.pop('info', '', 'Contact created successfully!', 5000);
                                    } else {
                                        toaster.pop('info', '', value, 5000);
                                    }
                                    $scope.isSending = false;

                                });
                            } else {
                                toaster.pop('error', '', 'Please fill required fields(*)', 5000);
                            }
                        } else {
                            if ($scope.contact.c_no !== '' && $scope.contact.emp_id !== '') {
                                log('Existing Contact');
                                log($scope.contact);
                                $scope.isSending = true;
                                http_service.request_post(_url_scntct, $scope.contact).then(function (value) {
                                    log(value);
                                    toaster.pop('info', '', value, 5000);
                                    $scope.isSending = false;
                                });
                            } else {
                                toaster.pop('error', '', 'Please fill required fields(*)', 5000);
                            }
                        }
                    }
                };

                //edit/modify list modal
                $scope.modifyList = function (d) {
                    log(d);
                    http_service.request_post(_url_clist, {grp_id: d.grp_id}).then(function (value) {
                        $scope.contactList = value;
                        log($scope.contactList);
                        angular.element('#editContacts').modal('show');
                    });
                };

                $scope.deleteGroup = function (d) {
                    log(d);
                    var isConfirmed = confirm('Are you sure you want to delete Group - ' + d.grp_name + ' and all of its contacts?');
                    if (isConfirmed) {
                        var index;
                        http_service.request_post(_url_dgp, d).then(function (value) {
                            log(value);
                            if (parseInt(value) > 0) {
                                $scope.groupData.some(function (value1, i) {
                                    return value1.grp_id === d.grp_id ? index = i : false;
                                });

                                $scope.groupData.splice(index, 1);
                                toaster.pop('info', '', 'Group Deleted successfully', 5000);
                            }
                        });
                    }

                };

                $scope.enable_row = function (c) {
                    log(c);
                    c.d = '1';
                };

                $scope.save_row = function (c) {
                    log(c);
                    http_service.request_post(_url_upd, c).then(function (value) {
                        log(value);
                        if (parseInt(value) === 1) {
                            toaster.pop('info', '', 'Contact updated successfully', 5000);
                        }
                    });
                    c.d = '0';
                };

                $scope.cancel_edit = function (c) {
                    log(c);
                    c.d = '0';
                };

                $scope.delete_row = function (c) {
                    log(c);
                    var index;
                    http_service.request_post(_url_del, c).then(function (value) {
                        if (parseInt(value) === 1) {
                            $scope.contactList.some(function (value, i) {
                                return value.emp_code === c.emp_code ? index = i : false;
                            });
                            $scope.contactList.splice(index, 1);
                            toaster.pop('info', '', 'Contact deleted successfully', 5000);
                        }
                    });
                };

            }]);

        app.factory('http_service', function ($http, $log, toaster) {

            return {
                request_post: function (url, data) {
                    return $http({
                        method: 'POST',
                        url: url,
                        data: data
                    }).then(function (value) {
                        return value.data;
                    }, function (reason) {
                        $log.log(reason);
                    });
                },
                file_save: function (url, data) {
                    return $http({
                        method: 'POST',
                        url: url,
                        data: data,
                        headers: {'Content-Type': undefined},
                        transformRequest: angular.identity
                    }).then(function (value) {
                        $log.log(value.data);
                        return value.data;

                    }, function (reason) {
                        $log.log(reason);
                    });
                }
            };

        });


    </script>
@endsection
