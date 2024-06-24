<script src="{{url('public/site_resource/js/ng/angular_1.6.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/angular-sanitize.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/loading-spinner.min.js')}}"></script>
<script>
    /*
       Programmer: 'Md.Raqib Hasan'
       Company: Incepta Pharmaceuticals Ltd.
       last modification: 5-sep-20
     */
    'use strict';
    var imgurl = '{{url('public/site_resource/images/ibd_img/')}}';
    var ibdApp = angular.module('ibdoc',
        ['ngAnimate', 'ngSanitize', 'angular-loading-bar', 'toaster', 'sarsha.spinner'])
        .config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
            cfpLoadingBarProvider.includeSpinner = false;
        }]);

    ibdApp.controller('ibdController', ['$scope', 'helper', 'spinnerService', '$sce', 'toaster', '$sce',
        function ($scope, helper, spinnerService, $sce, toaster) {
            helper.log('app initialized');

            $scope.showBackIcon = false;
            $scope.navtext = '';
            $scope.navtext_full = '';
            $scope.printType = 'I';
            $scope.filepath = '';
            $scope.pageType = 'A';
            $scope.pageNumber = '';
            $scope.isPrinting = false;
            $scope.url = '';
            $scope.viewType = "";
            $scope.key = "vt";
            $scope.isEmpty = false;
            $scope.comment = '';
            $scope.batch = '';
            $scope.loadingContent = false;
            $scope.pdf_src = '';

            //helper.clearItem();
            if (helper.getItem($scope.key)) {
                $scope.viewType = helper.getItem($scope.key).value;
            } else {
                $scope.viewType = "L";
            }

            // $scope.root_dir = [];
            $scope.get_root_folder = function () {
                $scope.root_dir = [];
                spinnerService.show('spinner2');
                $scope.loadingContent = true;
                helper.request('{{url('ibd/initial_folders')}}', 'get', {}).then(function (value) {
                    if (Array.isArray(value)) {
                        $scope.root_dir = value;
                        spinnerService.close('spinner2');
                    } else {
                        toaster.pop('error', 'Error', value, 12000);
                    }

                    if ($scope.root_dir.length === 0) {
                        $scope.isEmpty = true;
                    } else {
                        $scope.isEmpty = false;
                    }

                    $scope.loadingContent = false;
                });
            };

            $scope.viewTypeChange = function (type) {
                $scope.viewType = type;
                helper.setItem($scope.key, {value: type});
            };

            $scope.row_clicked = function (object) {
                if (object.text.split('|')[2] === '...') {
                    spinnerService.show('spinner2');
                    helper.log(object);
                    $scope.navtext_full += object.text.split('|')[0] + '/';

                    $scope.loadingContent = true;
                    $scope.root_dir = [];

                    helper.request('{{url('ibd/handle_ev')}}', 'post', {
                        type: object.text.split('|')[2] === '...' ? 'd' : 'f',
                        text: $scope.navtext_full
                    }).then(function (value) {
                        //helper.log(value);
                        $scope.root_dir = value;
                        $scope.loadingContent = false;

                        if ($scope.root_dir.length === 0) {
                            $scope.isEmpty = true;
                        } else {
                            $scope.isEmpty = false;
                        }

                        $scope.showBackIcon = true;
                        spinnerService.close('spinner2');
                    });
                }

            };

            $scope.navigateBack = function () {
                spinnerService.show('spinner2');
                helper.log($scope.navtext_full);
                // $scope.loadingContent = true;
                $scope.root_dir = [];

                helper.request('{{url('ibd/navigate')}}', 'post', {
                    text: $scope.navtext_full
                }).then(function (value) {
                    // $scope.loadingContent = false;
                    $scope.root_dir = value.result;

                    if ($scope.root_dir.length === 0) {
                        $scope.isEmpty = true;
                    } else {
                        $scope.isEmpty = false;
                    }

                    var url = value.url + "/";
                    helper.log(url.split('/'));
                    helper.log(url.split('/')[url.split('/').length - 1] === '');
                    if (url.split('/').length > 1 && value.root !== 'Y') {
                        $scope.navtext_full = url;
                        $scope.showBackIcon = true;
                    } else {
                        $scope.navtext_full = '';
                        $scope.showBackIcon = false;
                    }
                    spinnerService.close('spinner2');
                });
            };

            $scope.goto_root = function () {
                $scope.isEmpty = false;
                $scope.navtext_full = '';
                $scope.showBackIcon = false;
                $scope.get_root_folder();
            };

            $scope.open_dialog = function (row) {
                // $scope.disableFunctions();
                $scope.pdf_src =
                    $sce.trustAsResourceUrl('{{url('public/site_resource/js/pdfjs/web/viewer_ct.html?file=')}}');
                helper.log(row);
                $scope.url = row.text.split('|')[3];
                angular.element('#file_view').modal('show');
            };

            $scope.print = function () {

                if ($scope.printType === 'R' && $scope.comment.length === 0) {
                    toaster.pop('error', 'Error', 'Reason for reprint is required', 8000);
                } else {
                    if ($scope.batch.length === 0) {
                        toaster.pop('error', 'Error', 'Batch is required', 8000);
                    } else {
                        $scope.isPrinting = true;
                        // console.log($scope.batch);
                        var log_data = {
                            page: '',
                            print_type: $scope.printType,
                            reason: $scope.comment,
                            printer: '',
                            document: $scope.url,
                            copies: '',
                            batch: $scope.batch
                        };

                        helper.log(log_data);

                        helper.request('{{url('ibd/save_log')}}', 'post', log_data).then(function (response) { 
                            if (response) {
                                $scope.isPrinting = false;
                                helper.log('Print Successful');

                                helper.log(response.uri);
                                window.open(response.uri,'_blank'); 
                            }
                        });
                    }

                }

            };

            $scope.dismissModal = function () {
                angular.element('#file_view').modal('hide');
                $scope.reset();
                $scope.pdf_src =
                    $sce.trustAsResourceUrl('{{url('public/site_resource/js/pdfjs/web/viewer_ct.html?file=')}}');
            };

            $scope.reset = function () {
                $scope.pageNumber = '';
                $scope.printType = 'I';
                $scope.pageType = 'A';
                $scope.comment = '';
                $scope.url = '';
                $scope.batch = '';
            };

            $scope.get_root_folder();

        }]);

    ibdApp.factory('helper', function ($http, $log) {
        return {
            request: function (url, method, data) {
                return $http({
                    method: method,
                    url: url,
                    data: data
                }).then(function (value) {
                    $log.log(value);
                    return value.data;
                }, function (error) {
                    $log.log(error);
                });
            },
            log: function (value) {
                $log.log(value);
            },
            setItem: function (key, val) {
                localStorage.setItem(key, JSON.stringify(val));
            },
            getItem: function (key) {
                return JSON.parse(localStorage.getItem(key));
            },
            clearItem: function () {
                localStorage.clear();
            }
        }
    });

    //disable container page scroll
    //to fix page scroll
    var isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
        $('html, body').css({
            overflow: 'auto',
            height: 'auto'
        });
    } else {
        $('html, body').css({
            overflow: 'hidden',
            height: '100%'
        });
    }

</script>
