@extends('_layout_shared._master')
@section('title','New Requisition Exception')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
    <link rel="stylesheet" href="{{ url('public/site_resource/jtoast/jquery.toast.min.css')}}" />
    <link rel="stylesheet" href="{{ url('public/site_resource/css/gh-buttons.css')}}" />

    <style>

        body {
            color: #000000;
        }

        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 10px;
        }

        input, select {
            color: #000000;
        }

        body {
            color: #000;
        }

        #inf {
            text-transform: uppercase;
        }

        .shadow{
            box-shadow: 0 3px 3px 0 rgba(0,0,0,0.2)
        }

        #dre td, #dre th {
            border: 1px solid #ddd;
        }

        #dre th {
            background-color: #424F63;
            color: white;
        }

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

        .button + .button{
            margin-left: 0px;
        }

        .cf{
            font-size: 11px;
        }

        .form-control {
            display: inline;
            width: auto;
            height: auto;
            padding: 0px;
            font-size: 11px;
            border-radius: 0px ;
        }
    </style>
@endsection
@section('right-content')
    <div ng-app="DREApp" ng-controller="dreController">
        <toaster-container></toaster-container>
        <div class="row" ng-cloak="">
            <div class="col-sm-12 col-md-12" id="div_scroll">
                <section class="panel shadow" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary" style="text-transform: none;">
                        New Requisition Exception
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12 cf">
                                <div class="col-md-11" style="padding: 0px;">
                                    <div class="form-group col-md-2" style="width: 177px;">
                                        <label for="pay_month">Month</label>
                                        <select name="pay_month" id="pay_month" ng-model="v_pmonth" class="form-control" 
                                        ng-change ="resetButton()">
                                            <option value="" disabled="" selected>Select Month</option>
                                            <option ng-repeat="pm in payMonth" value="@{{ pm.monthname }}">@{{
                                                pm.monthname }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>


                                    <div class="form-group col-md-2" style="width: 195px;">
                                        <label for="rmterr">Rm Terr.</label>
                                        <select name="rmterr" id="rmterr" ng-model="v_rmterr" class="form-control"  ng-change="fetchAmTerr()">
                                            <option value="" disabled="" selected>Select RM Terr.</option>
                                            <option ng-repeat="at in rmterr" value="@{{at.rm_terr_id}}">@{{ at.rm_terr_id
                                                }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>

                                    <div class="form-group col-md-2" style="width: 195px;">
                                        <label for="amterr">Am Terr.</label>
                                        <select name="amterr" id="amterr" ng-model="v_amterr" class="form-control" ng-change="fetchMpoTerr()">
                                            <option value="" disabled="" selected>Select AM Terr.</option>
                                            <option ng-repeat="at in amterr" value="@{{at.am_terr_id}}">@{{ at.am_terr_id
                                                }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>


                                    <div class="form-group col-md-2" style="width: 200px;">
                                        <label for="mpoterr">Mpo Terr.</label>
                                        <select name="mpoterr" id="mpoterr" ng-model="v_mpoterr" class="form-control" ng-change="fetchDepot()">
                                            <option value="" disabled="" selected>Select MPO Terr.</option>
            <option ng-repeat="at in mpoterr" value="@{{at.mpo_terr_id}}|@{{ at.mpo_id }}|@{{ at.mpo_name }}">@{{ at.mpo_terr_id
                                                }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>


                                    <div class="form-group col-md-2" style="width: 210px;">
                                        <label for="depot">Depot</label>
                                        <select name="depot" id="depot" ng-model="v_dname" class="form-control">
                                            <!-- <option value="" disabled="" selected>Select Depot</option> -->
                                            <option ng-repeat="d in depot" value="@{{d.depot_id}}|@{{ d.depot_name }}">@{{ d.depot_name
                                                }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>

 <div class="form-group col-md-3" style="width: 300px;">
                                        <label for="exp_type">Exp Typ</label>
                                        <select name="exp_type" class="exp_type form-control" ng-model="exp_type" ng-change ="resetButton()">
                <option value="" disabled selected>Select Type</option>
                <option ng-repeat="dtype in expType"
                        value="@{{ dtype.type}}|@{{dtype.gl}}|@{{ dtype.main_cost_center_name}}|@{{ dtype.type_name }}">
                    @{{ dtype.type_name }}
                </option>
            </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>

                                    <!-- <div class="form-group col-md-3" style="width: 300px;">
                                        <label for="purpose">Purpose</label>
                                        <select name="purpose" id="purpose" ng-model="v_purpose" class="form-control">
                                            <option value="" disabled selected>Select Purpose</option>
                                            <option ng-repeat="p in purpose" value="@{{p.purpose_name}}">@{{
                                                p.purpose_name
                                                }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div> -->


                                    <!-- <div class="form-group col-md-4" style="width: 205px;">
                                        <label for="purpose">Beneficiary</label>
                                        <select name="beneficiary" id="beneficiary" ng-model="v_benif" class="form-control" ng-change="fetchExpType()">
                                            <option value="" disabled selected>Select Benef.</option>
                                            <option ng-repeat="b in benif" value="@{{b.dbt_description}}|@{{b.cost_center_type}}">@{{
                                                b.dbt_description
                                                }}
                                            </option>
                                        </select>
                                        <spinner ng-show="showInitProgress"></spinner>
                                    </div>
                                </div> -->

                                <div class="form-group col-md-2" style="width: 210px;">
                                <button id="btnDisplay" ng-click="dispReq()" class="btn btn-sm btn-primary" ng-disabled="saveProgress">
                                    <span ng-hide="saveProgress"><b><i class="fa fa-check"></i> Display</b></span>
                                    <span ng-show="saveProgress"><b><i class="fa fa-spinner fa-spin"></i>Wait..</b></span>
                                </button>
                            </div>

                                 <div class="col-md-1 pull-right" style="padding: 0px;">
                                    <div  class="button-group">
                                        <!-- <button id="add_row" ng-click="addRow()" class="button primary"><i class="fa fa-plus"></i> </button> -->
                                        <button id="remove_row" ng-click="removeRow()" class="button danger"><i class="fa fa-minus"></i>
                                        </button> 
                         <!-- <button ng-click="refresh()" class="button primary"><i class="fa fa-refresh"></i></button>  -->
                                    </div>
                                </div>  
                                            
                            </div>
                            <div class="col-md-12 table-responsive" style="padding-left: 5px;padding-right: 5px;">
                                @include('donation.dre_tab_new')
                            </div>
                            <!-- ng-click="saveReq()" -->
                            <div class="col-md-6 text-right" style="padding-top: 10px;" ng-if="dataArr[0].ifav">
                                <button id="btnSubmit" ng-click="checkDoctor()" class="btn btn-sm btn-primary" ng-disabled="saveProgress">
                                    <span ng-hide="saveProgress"><b><i class="fa fa-save"></i> Check Requisitions</b></span>
                                    <span ng-show="saveProgress"><b><i class="fa fa-spinner fa-spin"></i> Checking Please Wait....</b></span>
                                </button>
                            </div>

                            <div class="col-md-6 text-left" style="padding-top: 10px;"  ng-if="!rowFreq[0].flag && dataArr[0].ifav">
            <button id="btnSubmit" ng-click="saveReq()" class="btn btn-sm btn-primary" ng-disabled="saveProgress">
                                    <span ng-hide="saveProgress"><b><i class="fa fa-save"></i> Save Requisitions</b></span>
                                    <span ng-show="saveProgress"><b><i class="fa fa-spinner fa-spin"></i> Saving Please Wait....</b></span>
                                </button>
                            </div>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{url('public/site_resource/js/ng/angular_1.6.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-animate.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/angular-sanitize.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/loading-bar.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/ng/ng-toaster.js')}}"></script>
    <script src="{{url('public/site_resource/jtoast/jquery.toast.min.js')}}"></script>

    <script>
        var initialReqURL = '{{url('donation/getInitialData_n')}}';
        var getAmTerr = '{{url('donation/getAmTerr_n')}}';   
        var getMpoTerr = '{{url('donation/getMpoTerr')}}';
        var getDepot = '{{url('donation/getDepot')}}';   
        var getDoctorInfo = '{{url('donation/getDoctorById')}}';
        var getTerrByAmterr = '{{url('donation/getTerrByDepot')}}';
        var getGbrInfo = '{{url('donation/getGbrInfo')}}';
        var saveReq = '{{url('donation/saveReq_n')}}';
        var displayReq = '{{url('donation/displayReq')}}';
        var d_eligible = '{{url('donation/checkEligibility_n')}}';
        var getBEFTNmasterData = '{{url('donation/getBEFTNmasterData')}}';

        var app = angular.module('DREApp', ['toaster', 'angular-loading-bar']);
        app.config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
            cfpLoadingBarProvider.includeSpinner = false;
        }]);

        app.controller('dreController', ['$scope', '$log', 'toaster', 'helper','cfpLoadingBar',
            function ($scope, $log, toaster, helper,cfpLoadingBar) {

                $scope.dataArr = [];
                $scope.rowFreq = [];
                $scope.payMonth = [];
                $scope.depot = [];
                $scope.purpose = [];
                $scope.expType = [];
                $scope.exp_type = [];
                $scope.flag = false;
                    
                $scope.benif = [];
                $scope.freq = [];
                $scope.pay_mode = ['BEFTN','CASH','CHEQUE'];
                $scope.showInitProgress = false;
                $scope.bgrType = '';
                $scope.saveProgress = false;
                $scope.totalAmt = 0;
                $scope.amterr = [];
                $scope.mpoterr = [];
                $scope.rmterr = [];
                $scope.months = ['JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'];
                $scope.et_assoc = [];
                $scope.expTypeAll = [];

                //table initialization
                $scope.init = function () {
                    $scope.showInitProgress = true;
                    if($scope.dataArr.length > 0){
                        $scope.dataArr = [];
                    }
                    helper.http_request({}, 'get', initialReqURL).then(function (value) {
                        $scope.payMonth = value.pmonth;
                        $scope.rmterr = value.rm_terr;
                        $scope.rowFreq = [{flag: true}];
                        // $scope.depot = value.depot;
                        // $scope.purpose = value.purpose;
                        $scope.expType = value.dtype;
                        console.log($scope.expType);
                        // $scope.benif = value.benf;
                        $scope.freq = value.freq;
                        // $scope.dataArr = helper.getInitialRows();
                        $scope.et_assoc.push(value.dtype[3]);
                        $scope.expTypeAll = value.dtype;

                        //$scope.v_pmonth = $scope.payMonth[0].monthname;
                        var date = new Date();
                        $scope.v_pmonth = $scope.months[date.getMonth()]+'-'+date.getFullYear().toString().substr(2);

                        $scope.showInitProgress = false;
                        cfpLoadingBar.complete();
                    });
                };
                $scope.init();  

                    $scope.hideB = function(){

                    $scope.rowFreq = [{ flag: true }];
                    },

                $scope.resetButton = function(){

                    $scope.rowFreq = [{ flag: true }];
                    $scope.dataArr = [];
                },

                //fetch am terr based on depot
                $scope.fetchAmTerr = function(){
                    console.log($scope.v_rmterr);
                    if($scope.v_rmterr){
                        helper.http_request({rmTerr:$scope.v_rmterr},'post',getAmTerr).then(function (value) {
                            $scope.amterr = value;
                            $log.log($scope.amterr);
                            cfpLoadingBar.complete();
                        });
                    }

                };
                
                $scope.fetchMpoTerr = function(){
                    console.log($scope.v_amterr);
                    if($scope.v_amterr){
                        helper.http_request({amTerr:$scope.v_amterr},'post',getMpoTerr).then(function (value) {
                            $scope.mpoterr = value;
                            $log.log($scope.mpoterr);
                            cfpLoadingBar.complete();
                        });
                    }

                };

                $scope.fetchDepot = function(){
                    $scope.resetButton();
                    console.log($scope.v_mpoterr);
                    if($scope.v_mpoterr){
                        helper.http_request({mpoTerr:$scope.v_mpoterr.split('|')[0]},'post',getDepot).then(function (value) {
                            $scope.depot = value;
                            $scope.v_dname = value[0].depot_id + '|' + value[0].depot_name;
                            $log.log($scope.depot);
                            cfpLoadingBar.complete();
                        });
                    }

                };

                $scope.fetchExpType = function(){
                    if($scope.v_benif){
                        if($scope.v_benif.split('|')[0] == 'ASSOCIATION') {
                            $scope.expType = $scope.et_assoc;
                        }
                        else if($scope.v_benif.split('|')[0] == 'CHEMIST') {
                            $scope.expType = $scope.et_assoc;
                        }
                        else{
                            $scope.expType = [];
                            $scope.expType = $scope.expTypeAll;
                        }

                        // helper.http_request({depot:$scope.v_benif},'post',getExpType).then(function (value) {
                        //     $scope.amterr = value;
                        //     $log.log($scope.amterr);
                        //     cfpLoadingBar.complete();
                        // });
                    }

                };


                $scope.checkDoctor = async function () {
                $scope.rowFreq = [{ flag: true }];

    for (const [index, value] of $scope.dataArr.entries()) {
        if (value.frequency !== 'OCCASIONAL' &&
            value.frequency !== 'ONE TIME' &&
            value.doc_id &&
            $scope.v_mpoterr &&
            $scope.exp_type &&
            value.gbr_name) {

            if ($scope.exp_type.split('|')[0] === 'BRAND' ||
                $scope.exp_type.split('|')[0] === 'REGION' ||
                $scope.exp_type.split('|')[3] === 'BRAND RESEARCH SALES') {
                
                try {
                    const response = await helper.http_request({
                        doc_id: value.doc_id,
                        pay_month: $scope.v_pmonth,
                        terr_id: $scope.v_mpoterr.split('|')[0],
                        d_type: $scope.exp_type.split('|')[3],
                        gbr_name: value.gbr_name.split('|')[2]
                    }, 'post', d_eligible);

                    if (parseInt(response.status)) {
                        $('#row_' + index).css('border', '2px solid #ff6f6f');
                        // helper.showToast('', 'Doctor id ' + value.doc_id + " is not eligible for expense for the given selection criteria!", 'error', 'top-center', true);
                        // $scope.dataArr.splice(index, 1);
                        $scope.rowFreq.push(value);
                        console.log($scope.rowFreq);
                    } else {
                        // value.flag = false;
                    }
                } catch (error) {
                    console.error('Error during HTTP request:', error);
                }
                
                // Optional: Trigger a digest cycle if necessary
                $scope.$apply();
            }
        }
    }

    if ($scope.rowFreq.length == 1) {
        console.log("loop completed");
        $scope.rowFreq = [{ flag: false }];
    }
    console.log('Length :' + $scope.rowFreq.length);

    cfpLoadingBar.complete();  // Ensure the loading bar is completed at the end
};

                

                //save requisition
                $scope.saveReq = function () {

                        if($scope.rowFreq.length >1){
 helper.showToast('', "There  is requests  for expense which are not eligible for the given selection criteria!", 'error', 'top-center', true);

                        }
                        else{

                            if($scope.v_pmonth && $scope.v_dname && $scope.v_mpoterr && $scope.exp_type){
                        var finalArray = [];
                        var rowError = [];                       
                        angular.forEach($scope.dataArr, function (value, index) {

                            if(value.doc_id && value.doc_name ){
                                if( value.ifav &&
                                    value.pay_mode &&
                                    value.frequency &&
                                    value.gbr_name &&
                                    value.proposed_amt){

                                    var postData = angular.copy(value);
                                    postData.mterrList = [];
                                    postData.gbrList = [];
                                    postData.ifav = postData.ifav.toUpperCase();
                                    finalArray.push(postData);

                                }else{
                                    rowError.push(angular.copy(value));
                                }
                            }
                        });

                        console.log(finalArray);
                        
                        if(rowError.length > 0){
                            helper.showToast('Message','Please fill required(*) fields!','error','top-center',true);
                        }else{
                            if(finalArray.length > 0){
                                $scope.saveProgress = true;
                                helper.http_request(
                                    {req:finalArray,
                                        depot:$scope.v_dname,
                                        month:$scope.v_pmonth,
                                        terr_id: $scope.v_mpoterr,
                                        d_type: $scope.exp_type },
                                    'post', saveReq)
                                    .then(function (value) {
                                        if(value.message === 'success'){
                                            $scope.saveProgress = false;
                                            helper.showToast('Message','Requisition Saved','info','top-center',true);
                                            $scope.dataArr = [];
                                            $scope.rowFreq = [{flag: true}];
                                            // $scope.dataArr = helper.getInitialRows();
                                        }else{
                                            $scope.saveProgress = false;
                                        }
                                        cfpLoadingBar.complete();
                                    });
                            }
                        }
                    }else{
                        helper.showToast('Message','Select Pay month/Depot/Purpose/Beneficiary','error','top-center',true);
                    }

                        }

                    
                    // });    

                };


                
                $scope.dispReq = function () {
                    if($scope.v_pmonth && $scope.v_dname && $scope.v_mpoterr && $scope.exp_type){
                        $scope.dataArr = [];
                        $scope.totalAmt = 0;
                        // if($scope.v_pmonth ){
                        console.log($scope.v_pmonth);
                        // console.log($scope.v_dname.split('|')[0]);
                        console.log($scope.v_mpoterr);
                        console.log($scope.exp_type);
                        console.log($scope.v_dname);

                                $scope.saveProgress = true;  
                                $scope.bgrType = false;
                                $scope.rowFreq = [{flag: true}];
                                helper.http_request(
     {month:$scope.v_pmonth, terr:$scope.v_mpoterr.split('|')[0],did :$scope.v_dname.split('|')[0], dtype:$scope.exp_type},
                                    'post', displayReq)
                                    .then(function (value) {
                                        // $log.log(value);
                                        // $log.log(value.arr);
                                        // $log.log(value.gb);
                                        // console.log(value);
                                        // console.log(value.arr);
                                        // console.log(value.gb.val);
                                        if(value.arr.length > 0){
                                           
                                            $scope.dataArr = helper.getDispRows(value.arr,value.gb.val);
                                            console.log($scope.dataArr);
                                            $scope.saveProgress = false;

                                            $scope.totalAmt = 0;
                        angular.forEach($scope.dataArr,function (val,index) {
                            if(val.proposed_amt){
                                $scope.totalAmt = parseInt($scope.totalAmt) + parseInt(val.proposed_amt);
                            }
                        });
                                        }else{
                                            console.log('gggggg');
                                            $scope.saveProgress = false;
                                        }
                                        cfpLoadingBar.complete();
                                    });
                            
                        
                    }else{
                        helper.showToast('Message','Please Select all the required field','error','top-center',true);
                    }

                };

                //group/brand/region
                $scope.fetch_gbr = function(index,exp_type){
                    console.log(exp_type.split('|')[3]);
                    if(exp_type){
                        if($scope.dataArr[index].mpo_terr){
                            $scope.bgrType = false;
                            helper.http_request({dtype:exp_type,terr:$scope.v_mpoterr},'post',getGbrInfo).then(function (value) {
                                $scope.dataArr[index].gbrList = value.val;
                                $scope.bgrType = value.type;
                                if(exp_type.split('|')[0] === 'SALES' && exp_type.split('|')[3] != 'BRAND RESEARCH SALES'){
                                    console.log(' Entered in this condition');
                                    if($scope.dataArr[index].gbrList.length > 0){
                                        $scope.dataArr[index].gbr_name = $scope.dataArr[index].gbrList[0].cost_center_id +"|"+$scope.dataArr[index].gbrList[0].cost_center_name+"|";
                                    }
                                }
                                if($scope.dataArr[index].doc_id !== '00'){
                                    $scope.dataArr[index].pay_mode = '';
                                }
                                cfpLoadingBar.complete();
                            });
                        }else{
                            helper.showToast('Message','Please select territory','error','top-center',true);
                        }
                    }
                };



                //get doctor information on given id
                $scope.fetchDoctor = function (docid, index, pmode) {
                    if(docid){
                        helper.http_request({doc_id: docid}, 'post', getDoctorInfo).then(function (value) {
                            if (value.dterr[0]) {
                                $scope.dataArr[index].mterrList = value.dterr;
                            } else {
                                helper.showToast('Message','Doctor Not Found!','error','top-center',true);
                            }
                            cfpLoadingBar.complete();
                        });
                        $scope.dataArr[index].pay_mode = '';
                        $scope.dataArr[index].proposed_amt = '';
                        // update total amount
                        $scope.totalAmt = 0;
                        angular.forEach($scope.dataArr,function (val,index) {
                            if(val.proposed_amt){
                                $scope.totalAmt = parseInt($scope.totalAmt) + parseInt(val.proposed_amt);
                            }
                        });
                    }
                };

                $scope.checkBEFTNmasterData = function(index, pmode, amt){
                    if(pmode == 'BEFTN'){
                        if($scope.dataArr[index].doc_id && $scope.v_mpoterr){
                            var doc_id = $scope.dataArr[index].doc_id;
                            var terr_code = $scope.v_mpoterr.split('|')[0];
                            helper.http_request({doc_id: doc_id,terr_code: terr_code}, 'post', getBEFTNmasterData).then
                            (function (result) {
                                // console.log(result);
                                if (!result.exists) {
                                    helper.showToast('Message','BEFTN Data Not Found!','error','top-center',true);
                                    $('#row_'+index).css('border', '2px solid #ff6f6f');
                                    $scope.dataArr[index].proposed_amt = '';
                                }else{
                                    $('#row_'+index).css('border', 'none');
                                }
                            });
                        }
                    }else{
                        $('#row_'+index).css('border', 'none');
                    }

                    if(pmode === 'BEFTN' && amt > 22000 && amt !== ''){
                        helper.showToast('Message','Expenses equal to or below BDT 22,000 will be ' +
                            'processed through the BEFTN method.','error','top-center',true);
                        $scope.dataArr[index].proposed_amt = '';
                    }
                    $scope.totalAmt = 0;
                    angular.forEach($scope.dataArr,function (val) {
                        if(val.proposed_amt){
                            $scope.totalAmt = parseInt($scope.totalAmt) + parseInt(val.proposed_amt);
                        }
                    });
                };

                //mpo terr change
                $scope.fetchMterr = function(index){
                    if(!$scope.dataArr[index].doc_id){
                        if($scope.v_amterr){
                            helper.http_request({amterr:$scope.v_amterr},'post',getTerrByAmterr).then(function (value) {
                                $scope.dataArr[index].mterrList = value;
                                cfpLoadingBar.complete();
                            });
                        }else{
                            helper.showToast('Message','Please select am territory','error','top-center',true);
                        }

                    }
                };

                
                // on terr change reset fields exp_type & group brand region
                $scope.reset_exp = function(index){
                    
                    $scope.dataArr[index].exp_type = '';
                    $scope.dataArr[index].gbrList = [];
                    if($scope.dataArr[index].doc_id && $scope.dataArr[index].mpo_terr){
                        helper.http_request({doc_id:$scope.dataArr[index].doc_id,doc_terr:$scope.dataArr[index].mpo_terr},'post',getDoctorInfo).then(function (value) {
                            $log.log(value);
                            $scope.dataArr[index].doc_name = value.dinfo[0].doctor_name;
                            $scope.dataArr[index].ifav = value.dinfo[0].in_favour_of;
                            $scope.dataArr[index].no_patient = value.dinfo[0].no_of_patient;
                            $scope.dataArr[index].mobile = value.dinfo[0].mobile;
                            $scope.dataArr[index].address = value.dinfo[0].address;
                            $scope.dataArr[index].spec = value.dinfo[0].speciality;

                            $scope.dataArr[index].pay_mode = '';
                            $scope.dataArr[index].proposed_amt = '';
                            // update total amount
                            $scope.totalAmt = 0;
                            angular.forEach($scope.dataArr,function (val,index) {
                                if(val.proposed_amt){
                                    $scope.totalAmt = parseInt($scope.totalAmt) + parseInt(val.proposed_amt);
                                }
                            });

                            if($scope.dataArr[index].doc_id === '00'){
                                $scope.dataArr[index].ifavRonly = false;
                                $scope.dataArr[index].freqRonly = true;
                                $scope.dataArr[index].frequency = "OCCASIONAL";
                                $scope.dataArr[index].pmodeRonly = true;
                                $scope.dataArr[index].pay_mode = "CHEQUE";
                            }
                            $log.log($scope.dataArr[index]);
                            cfpLoadingBar.complete();
                        });
                    }
                };


                $scope.reset_pay_mode = function(index){
                    $scope.rowFreq = [{ flag: true }];
                    if($scope.dataArr[index].doc_id !== '00'){
                        $scope.dataArr[index].pay_mode = '';
                        $scope.dataArr[index].frequency = '';
                    }
                };

                //end

                $scope.checkval = function( index,amt){
                    if(isNaN(amt)){
                        helper.showToast('Message','Value must be number','error','top-center',true);
                        $scope.dataArr[index].proposed_amt = '';
                    }
                };

                $scope.addAmount = function(ind,amt,pmode){
                    if(pmode === 'BEFTN' && amt > 22000 && amt !== ''){
                        helper.showToast('Message','Expenses equal to or below BDT 22,000 will be ' +
                            'processed through the BEFTN method.','error','top-center',true);
                        $scope.dataArr[ind].proposed_amt = '';
                    }
                    $scope.totalAmt = 0;
                    angular.forEach($scope.dataArr,function (val,index) {
                        if(val.proposed_amt){
                            $scope.totalAmt = parseInt($scope.totalAmt) + parseInt(val.proposed_amt);
                        }
                    });
                };

                //add single row to table
                $scope.addRow = function () {
                    var copy = angular.copy(helper.getSingleRow());
                    copy.id = $scope.dataArr.length + 1;
                    $scope.dataArr.push(copy);
                };

                $scope.refresh = function(){
                    $scope.init();
                };

                //delete selected rows from table
                $scope.removeRow = function () {
                    for(var i=$scope.dataArr.length-1 ;i >= 0;i--){
                        if($scope.dataArr[i].check === true){
                            $scope.dataArr.splice(i,1);
                        }
                    }
                };



                $scope.fetchMterr = function(index){
                    if(!$scope.dataArr[index].doc_id){
                        if($scope.v_amterr){
                            helper.http_request({amterr:$scope.v_amterr},'post',getTerrByAmterr).then(function (value) {
                                $scope.dataArr[index].mterrList = value;
                                cfpLoadingBar.complete();
                            });
                        }else{
                            helper.showToast('Message','Please select am territory','error','top-center',true);
                        }

                    }
                };

            }]);

        app.component('spinner', {
            template: '<span><i class="fa fa-spinner fa-spin"></i></span>'
        });

        app.directive('ngEnter', function () {
            return function (scope, element, attrs) {
                element.bind('keypress keydown', function (event) {
                    if (event.which === 13) {
                        scope.$apply(function () {
                            scope.$eval(attrs.ngEnter);
                        });
                        event.preventDefault();
                    }
                });
            }
        });

        app.factory('helper', function ($http, $log) {
            return {
                http_request: function (data, type, url) {
                    return $http({
                        method: type,
                        url: url,
                        data: data
                    }).then(function (value) {
                        return value.data;
                    }, function (reason) {
                        $log.log(reason);
                    });
                },
                getInitialRows: function () {
                    var dataArr = [];
                    for (var i = 0; i < 10; i++) {
                        var copy = angular.copy(this.getSingleRow());
                        copy.id = i;
                        dataArr.push(copy);
                    }
                    return dataArr;
                },
                getSingleRow: function () {
                    return {
                        id: 0,
                        check: false,
                        doc_id: '',
                        doc_name: '',
                        ifav: '',
                        no_patient: '',
                        mobile: '',
                        address: '',
                        spec: '',
                        mpo_terr: '',
                        exp_type: '',
                        gbr_name: '',
                        pay_mode: '',
                        frequency: '',
                        proposed_amt: '',
                        remarks: '',
                        mterrList: [],
                        gbrList: [],
                        progress: false,
                        ifavRonly: true,
                        freqRonly: false,
                        pmodeRonly: false
                    };
                },
                getDispRows: function (arr_val,gbr) {
                    // console.log(arr_val);
                    var dataArr = [];
                    for (var i = 0; i < arr_val.length; i++) {
                        var copy = angular.copy(this.getSingledisRow(arr_val[i],gbr));
                        copy.id = i;
                        dataArr.push(copy);
                    }
                    return dataArr;
                    // return arr_val;
                }

                ,  
                getSingledisRow: function (va,gbr) {
                    
                            if(va.sub_cost_center_id == null){
                                console.log('found');
                                va.sub_cost_center_id = '';
                            }
                   
                    return {
                        id: 0,
                        check: true,
                        doc_id: va.doctor_id,
                        doc_name: va.doctor_name,
                        ifav: va.in_favour_of,
                        no_patient: va.no_of_patient,
                        mobile: va.contact_no,
                        address: va.address,
                        spec: va.speciality,
                        mpo_terr: va.terr_id,
                        mpo_id: va.emp_id,
                        mpo_name:va.emp_name,
                        ccid: va.cost_center_id,
                        sccid: va.sub_cost_center_id,
                        exp_type: va.donation_type,
                        gbr_name: va.cost_center_id + '|' + va.cost_center_name + '|' + va.sub_cost_center_id,
                        pay_mode: va.payment_mode,
                        frequency: va.frequency,
                        proposed_amt: va.approved_amount,
                        remarks: va.commitment,
                        mterrList: [],
                        gbrList: gbr,
                        progress: false,
                        ifavRonly: true,
                        freqRonly: false,
                        pmodeRonly: false,
                        flag: true
                    };
                },
                showToast: function (heading, text,icon,position,loader) {
                    $.toast({
                        heading: heading ? heading : 'Message',
                        text: text ? text : 'Doctor Not Found',
                        position: position,
                        stack: false,
                        icon: icon,
                        showHideTransition: 'fade',
                        loader: loader,
                        hideAfter: 8000
                    })
                }
            }
        });

    </script>
@endsection
