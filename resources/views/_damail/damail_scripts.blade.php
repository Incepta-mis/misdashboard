<script src="{{url('public/site_resource/js/ng/angular_1.6.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/dirPagination.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/angular-sanitize.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/loading-spinner.min.js')}}"></script>
<script src="{{url('public/site_resource/js/ng/select.js')}}"></script>
<script src="{{url('public/site_resource/dpicker/moment-with-locales.js')}}"></script>
<script src="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}"></script>
<script>
    /*
     Programmer: 'Md.Raqib Hasan'
     Company: Incepta Pharmaceuticals Ltd.
     Created On: 23-sep-20
   */
    'use strict';

    $('#work_date').datetimepicker({
        format: 'DD-MMM-YY',
        maxDate: moment(),
        allowInputToggle: true
        // format:'L'
    });

    $('#work_date').data('DateTimePicker').date(moment().subtract(1,'days'));

    var app = angular.module(
        'dailyAttnMail',
        ['ngAnimate','ngSanitize','angular-loading-bar','toaster','sarsha.spinner','ui.select',
            'angularUtils.directives.dirPagination']
    ).config(['cfpLoadingBarProvider',function (cfploadingBarProvider) {
        cfploadingBarProvider.includeSpinner = false;
    }]);

    app.controller('dam_controller',['$scope','spinnerService', '$sce', 'toaster','helper','$log','$window',
       function ($scope,spinnerService,$sce,toaster,helper,$log,$window) {
           $log.log('app initialized');
           $scope.isProcessing = false;
           $scope.newRecordM = false;
           $scope.newRecordD = false;
           $scope.processedList = [];
           $scope.masterRecords = [];
           $scope.detailRecords = [];
           $scope.dtype = {
               type: 'ALL'
           };
           $scope.newRowM = {
             department:'',
             section:'',
             mail_to:'',
             mail_cc:'',
             mail_bcc:''
           };

           $scope.newRowD = {
             department:'',
             section:'',
             emp_id:''
           };

           //select value
           $scope.deptList = [];
           $scope.sections = [];
           $scope.getDeptData = function () {
               $scope.isProcessing = true;
               helper.request('{{url('damail/get_departments')}}','GET', {}).then(function (value) {
                   $scope.deptList = value.dept;
                   $scope.processedList = value.pl;
                   $scope.sections = value.sect;
                   $log.log($scope.deptList);
                   $scope.isProcessing = false;
               });
           };

           $scope.getDeptData();
           $scope.selectedDept = {};
           $scope.selectedDept.data = [];
           $scope.omitSelectedGroups = function(data){
               return $scope.selectedDept.data.indexOf(data) === -1;
           };

           $scope.refreshList = function(){
            $scope.isProcessing = true;
               helper.request('{{url('damail/get_departments')}}','GET', {}).then(function (value) {
                   $scope.deptList = value.dept;
                   $scope.processedList = value.pl;
                   $scope.sections = value.sect;
                   $log.log($scope.deptList);
                   $scope.isProcessing = false;
               });
           };

           $scope.process = function (process_type) {
               if(angular.element('#id_work_date').val().toUpperCase()){

                   if($scope.dtype.type ==='SEL'){
                       if(!$scope.selectedDept.data.length){
                           toaster.pop('error','','Department is required',8000);
                           return;
                       }
                   }

                   $scope.isProcessing = true;

                   $log.log(helper.getObject($scope.dtype.type === 'ALL' ? 'ALL': $scope.selectedDept.data.map(function (dept) {
                           return dept.dept;
                       }).join(','),
                       process_type,angular.element('#id_work_date').val().toUpperCase()));

                   helper.request('{{url('damail/process_attn')}}','POST',
                       helper.getObject($scope.dtype.type === 'ALL' ? 'ALL':
                           $scope.selectedDept.data.map(function (dept) {
                               return dept.dept;
                           }).join(','),
                           process_type,angular.element('#id_work_date').val().toUpperCase()))
                       .then(function (response) {
                           $log.log(response);
                           if(response){
                               $scope.processedList = response;
                               toaster.pop('info','','Process Completed successfully!',8000);
                           }else{
                               toaster.pop('error','','An error occured! Please try again!',8000);
                           }

                           $scope.isProcessing = false;
                       })

               }else{
                   toaster.pop('error','','Working date is required',8000);
               }
           };

           $scope.send_mail = function(file){
               $scope.isProcessing = true;
               helper.request('{{url('damail/send_mail')}}','POST',file)
                   .then(function (response) {
                       $log.log(response);
                       toaster.pop('success','','Mail Sent successfully!!!',8000);
                       $scope.isProcessing = false;
                   })
           };

           $scope.view_file = function(file){
               var hostUrl = '{{url('public/daily_attn_mail')}}';
               $window.open(hostUrl+'/'+file.f_name+".pdf",'_blank');
           };

           $scope.display_modal = function(){
               helper.request('{{url('damail/record_details')}}','GET',{}).then(function (response) {
                  if(response){
                      $scope.masterRecords = [];
                      $scope.detailRecords = [];
                      $scope.masterRecords = response.master;
                      $scope.detailRecords = response.details;
                      angular.element('#modal_mail_data').modal('show');
                  }else{
                      toaster.pop('error','','An error occured! Please try again.',8000);
                  }
               });

           };

           $scope.dismiss_modal = function(){
               console.log('clicked');
               angular.element('#modal_mail_data').modal('hide');
               $scope.masterRecords = [];
               $scope.detailRecords = [];
           };

           //modal

           $scope.create_row = function(type){
               type === 'm' ? $scope.newRecordM = true : $scope.newRecordD = true;
           };

           $scope.add_row = function(type){
              $log.log(type);
              var value = angular.copy(type === 'm' ? $scope.newRowM  : $scope.newRowD);
              value.type = type;
              helper.request('{{url('damail/save_record')}}','POST',value).then(function (response) {
                  if(response){
                      toaster.pop('info','','Record savedd successfully',8000);
                      type === 'm' ? $scope.masterRecords.push($scope.newRowM) :
                          $scope.detailRecords.push($scope.newRowD);
                      $scope.reset();
                  }else{
                      toaster.pop('error','','An error occured while saving !Please try again!',8000);
                  }
              });

           };

           $scope.cancel_entry = function(type){
               type === 'm' ? $scope.newRecordM = false : $scope.newRecordD = false;
           };

           $scope.enable_row = function(c){
               $log.log(c);
               c.d = '1';
           };

           $scope.save_row = function(c,type){
               // $log.log(c);
               var val = angular.copy(c);
               val.type = type;
               helper.request('{{url('damail/update_record')}}','PATCH',val).then(function (value) {
                   $log.log(value);

                   if(value){
                       toaster.pop('info','','Record updated successfully',8000);
                   }
               });
               c.d = '0';
           };

           $scope.cancel_edit = function(c){
               $log.log(c);
               c.d = '0';
           };

           $scope.delete_row = function(c,type){
               var index;
               var value = angular.copy(c);
               value.type = type;
               $log.log(value);
               helper.request('{{url('damail/delete_record')}}','POST',value).then(function (value) {
                   if(value){
                       if(type === 'm'){
                           $scope.masterRecords.some(function (value, i) {
                               return value.section === c.section ? index = i : false;
                           });
                           $scope.masterRecords.splice(index,1);
                       }else{
                           $scope.detailRecords.some(function (value, i) {
                               return value.section === c.section && value.emp_id === c.emp_id ? index = i : false;
                           });
                           $scope.detailRecords.splice(index,1);
                       }
                       toaster.pop('info','','Record deleted successfully',8000);
                   }
               });
           };

           $scope.reset = function () {
               $scope.newRowM = {
                   department:'',
                   section:'',
                   mail_to:'',
                   mail_cc:'',
                   mail_bcc:''
               };

               $scope.newRowD = {
                   department:'',
                   section:'',
                   emp_id:''
               };
           };

           $scope.shorten = function (text) {
               if(text.length > 25){
                   return text.substr(0,25)+"...";
               }
               return  text;
           };

           //select value end
       }]);

    app.factory('helper', function ($http, $log) {
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
            getObject: function (dtype,ptype,wdate) {
                return {dtype:dtype,ptype:ptype,wdate: wdate};
            }
        }
    });



</script>
