@extends('_layout_shared._master')
@section('title','Doctor Plan')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/loading-bar.min.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/js/ng/ng-toaster.css')}}">
    <link rel="stylesheet" href="{{url('public/site_resource/awaitme/waitme.min.css')}}">
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

        @media (min-width: 992px) {
            .col-md-4 {
                width: 30.33333333%;
            }
        }

        .form-group {
            margin-bottom: 0px;
        }

        .pad10 {
            padding-bottom: 3px;
        }

        .inputRow {
            position: relative;
            overflow: auto;
        }

        .searchItem {
            position: absolute;
            background-color: white;
            border: 1px solid gray;
            z-index: 50;
            height: 250px;
            overflow-y: scroll;
        }

        #sresult > li:hover {
            background-color: #285e8e;
            color: #ffff;
            cursor: pointer;
            font-weight: bold;
        }

        #sresult > li {
            padding: 2px;
            border-bottom: 1px solid #2A3542;
            font-size: .9em;
        }

        .modal-body {
            max-height: calc(100vh - 210px);
        }

        .input-xs {
            height: 23px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
        }

        .modal-header {
            background: #5A89BC;
        }

        [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

        .rloader {
            background-color: #ffffff;
            background-image: url('{{url('public/site_resource/images/preloader.gif')}}');
            background-size: 25px 25px;
            background-position: right center;
            background-repeat: no-repeat;
            background-position-x: 90%;
        }


    </style>
@endsection
@section('right-content')
    <div ng-app="docPlan" ng-controller="docController">
        <toaster-container></toaster-container>
        {{--doctor part--}}
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Doctor Information & Visit Plan Entry
                        </label>
                    </header>
                    <div class="panel-body">
                        <form name="docForm" role="form" id="docForm" novalidate>
                            <div class="col-md-12 col-sm-12">
                                {{--first row--}}
                                <div class="row form-inline pad10">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="form-group">
                                            <label for="" style="font-weight: bold;color: #1f648b;">
                                                Search By &nbsp;&nbsp;&nbsp;&nbsp;
                                            </label>
                                            <select name="searchType" id="searchType" ng-model="sType"
                                                    class="form-control input-sm" ng-change="changeType()">
                                                <option value="ID">Doctor ID</option>
                                                <option value="NAME">Doctor Name</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group" ng-show="hStatus">
                                                <input type="text"
                                                       ng-model="doc_id" name="doc_id" placeholder="enter Doctor Id"
                                                       maxlength="7"
                                                       class="form-control input-sm" autocomplete="off">
                                                <span class="input-group-btn"><button type="button"
                                                                                      class="btn btn-sm btn-default"
                                                                                      ng-click="searchByID()">Search</button></span>
                                            </div>
                                            <div class="input-group" ng-hide="hStatus" ng-cloak>
                                                <div class="inputRow">
                                                    <div class="input-group">
                                                        <input type="text" size="50"
                                                               ng-model="doc_name" placeholder="enter Doctor Name"
                                                               ng-change="findDocByName()"
                                                               style="text-transform: uppercase;"
                                                               class="form-control input-sm" ng-class="showRloader"
                                                               autocomplete="off">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-sm btn-default"
                                                                    ng-click="closeList()"><i
                                                                        class="fa fa-times"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="searchItem" style="width: 350px;" ng-show="showResult"
                                                     ng-cloak>
                                                    <ul class="list-unstyled" id="sresult" class="list-group">
                                                        <li class="list-group-item" ng-repeat="dctr in docList"
                                                            ng-click="showDoc(dctr)">
                                                            @{{ dctr.doctor_id }}|@{{ dctr.name }}|@{{ dctr.terr_id }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--second row--}}
                                <div class="row pad10" style="padding-top: 11px;">
                                    <div class="col-sm-5 form-group">
                                        <label for="" class="col-md-5">
                                            Title
                                        </label>
                                        <div class="col-md-7">
                                            <select name="title" id="title" ng-model="docData.title"
                                                    class="form-control input-xs" ng-disabled="readOnly">
                                                <option value="DR">DR</option>
                                                <option value="QK">QK</option>
                                                <option value="PS">PR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 form-group">
                                        <label for="" class="col-md-4" style="width: 22%;">
                                            ID/Name
                                        </label>
                                        <div class="col-sm-8 form-group">
                                            <div class="col-sm-3" style="padding-left: 0px;">
                                                <input type="text" ng-model="docData.id" readonly
                                                       class="form-control input-xs" autocomplete="off">
                                            </div>
                                            <div class="col-sm-9"><input type="text" ng-model="docData.name"
                                                                         class="form-control input-xs"
                                                                         ng-disabled="readOnly">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--third row--}}
                                <div class="row pad10">
                                    <div class="col-sm-5 form-group">
                                        <label for="" class="col-md-5">Designation&nbsp;</label>
                                        <div class="col-md-7">
                                            <select ng-model="docData.desig" class="form-control input-xs"
                                                    ng-disabled="readOnly">
                                                <option value="default">Select designation</option>
                                                @foreach($doc_desig as $dd)
                                                    <option value="{{$dd->position}}">{{$dd->position}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 form-group">
                                        <label for="" class="col-md-4" style="width: 22%;">Speciality
                                            &nbsp;</label>
                                        <div class="col-md-8"><select id="spclty" ng-model="docData.scode"
                                                                      class="form-control input-xs"
                                                                      ng-disabled="readOnly">
                                                <option value="default" disabled="">Select speciality</option>
                                                @foreach($doc_sp as $ds)
                                                    <option value="{{$ds->code}}">{{$ds->details}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>
                                {{--fourth row--}}
                                <div class="row pad10">
                                    <div class="col-sm-5 form-group">
                                        <label for="" class="col-md-5">Sex</label>
                                        <div class="col-md-7"><select name="sex" id="sex" ng-model="docData.sex"
                                                                      class="form-control input-xs"
                                                                      ng-disabled="readOnly">
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>
                                            </select></div>
                                    </div>
                                    <div class="col-sm-7 form-group">
                                        <label for="" class="col-md-4" style="width: 22%;">Contact No &nbsp;</label>
                                        <div class="col-md-8"><input type="text" ng-model="docData.cno"
                                                                     class="form-control input-xs"
                                                                     size="30" ng-disabled="readOnly"
                                                                     autocomplete="off"></div>
                                    </div>
                                </div>
                                {{--sixth row--}}
                                <div class="row pad10">
                                    <div class="col-sm-5 form-group">
                                        <label for="" class="col-md-5">Qualification</label>
                                        <div class="col-md-7"><input type="text" ng-model="docData.qual"
                                                                     class="form-control input-xs"
                                                                     ng-disabled="readOnly"></div>
                                    </div>
                                    <div class="col-sm-7 form-group">
                                        <label for="" class="col-md-4" style="width: 22%;">Doctor
                                            Status&nbsp;</label>
                                        <div class="col-md-8"><select name="status" id="docStatus"
                                                                      ng-model="docData.dstatus"
                                                                      class="form-control input-xs"
                                                                      ng-disabled="readOnly">
                                                <option value="INSERT">INSERT</option>
                                                <option value="UPDATE">UPDATE</option>
                                                {{-- <option value="DELETE" disabled="">DELETE</option> --}}
                                            </select></div>
                                    </div>
                                </div>
                                {{--seventh row--}}
                                <div class="row pad10">
                                    <div class="col-sm-5 form-group">
                                        <label for="" class="col-md-5">Main Territory</label>
                                        <div class="col-md-5"><input type="text" style="text-transform: uppercase;"
                                                                     ng-model="docData.mterr" name="docMTerr"
                                                                     ng-enter="showmTerrList()"
                                                                     ng-click="showmTerrList()" autocomplete="off"
                                                                     placeholder="click to select terr_id"
                                                                     readonly
                                                                     class="form-control input-xs" size="10" required
                                                                     ng-disabled="readOnly"></div>
                                    </div>
                                    <div class="col-sm-7 form-group">
                                        <label for="" class="col-md-4" style="width: 24.4%;">Hospital Address </label>
                                        <div class="input-group input-group-xs col-md-7"><input type="text"
                                                                                                ng-model="docData.haddr"
                                                                                                class="form-control input-xs"
                                                                                                size="40"
                                                                                                ng-disabled="readOnly">
                                            <span class="input-group-addon">
                                            <input type="checkbox" ng-model="docData.cbHAddr" ng-click="cbHCheck()"
                                                   ng-checked="docData.cbHAddr" ng-disabled="readOnly"
                                                   autocomplete="off">
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                {{--eighth row--}}
                                <div class="form-group pad10">
                                    <label for="" class="col-md-2" style="width: 18%;">Chamber Address </label>
                                    <div class=" input-group input-group-xs col-md-8"><input type="text"
                                                                                             ng-model="docData.caddr"
                                                                                             autocomplete="off"
                                                                                             class="form-control input-xs"
                                                                                             size="60"
                                                                                             ng-disabled="readOnly">
                                        <span class="input-group-addon">
                                            <input type="checkbox" ng-model="docData.cbCAddr" ng-click="cbCCheck()"
                                                   ng-checked="docData.cbCAddr" ng-disabled="readOnly">
                                        </span>
                                    </div>
                                </div>
                                {{--tenth row--}}
                                <div class="row form-group pad10" style="padding-bottom: 8px;">
                                    <div class="col-sm-12"><label for="" class="col-md-2" style="width: 18%;">Others
                                            Address </label>
                                        <div class=" input-group input-group-xs col-md-8"><input type="text"
                                                                                                 ng-model="docData.oaddr"
                                                                                                 autocomplete="off"
                                                                                                 class="form-control input-xs"
                                                                                                 size="60"
                                                                                                 ng-disabled="readOnly">
                                            <span class="input-group-addon">
                                            <input type="checkbox" ng-model="docData.cbOAddr" ng-click="cbOCheck()"
                                                   ng-checked="docData.cbOAddr" ng-disabled="readOnly">
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" ng-cloak>
                                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                                        <button type="button" class="btn btn-default btn-sm" ng-disabled="_DBN"
                                                ng-click="newEntry()">
                                            <i class=" fa fa-plus"></i>
                                            New Entry
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm" ng-click="saveRecord()"
                                                ng-hide="_HBS">
                                            <i class="fa fa-floppy-o"></i>
                                            Save
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm" ng-click="updateRecord()"
                                                ng-hide="_HBU" ng-disabled="_DBU" disabled="">
                                            <i class="fa fa-floppy-o"></i>
                                            Update Doctor
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm" ng-click="assignTerr()"
                                                ng-disabled="_DBT"><i
                                                    class="fa fa-map-marker"></i>
                                            Assign Territory
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm" ng-click="cancel()"
                                                ng-hide="_HBC">
                                            <i class="fa fa-eraser"></i>
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </section>
            </div>
        </div>
        {{--territory part--}}
        <div class="row" ng-show="displayTerrView" ng-hide="terrData.length == 0" ng-cloak>
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Doctor Territory Maintenance
                        </label>
                    </header>
                    <div class="panel-body ">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center;">
                                    <th>Doctor ID</th>
                                    <th>Doctor Name</th>
                                    <th>In Favour of</th>
                                    <th>Terr Id</th>
                                    <th>Emp Id</th>
                                    <th>Emp Name</th>
                                    {{--<th>Emp Desig</th>--}}
                                    <th>Visiting Address</th>
                                    <th>Practice</th>
                                    <th>Patient</th>
                                    <th>Valid</th>
                                    <th>Doc. <br> Cate.</th>
                                    <th>Action</th>
                                    <th>Doctor Plan</th>
                                    <th>Brand Plan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="td in terrData">
                                    <td>@{{ td.id }}</td>
                                    <td>@{{ td.name }}</td>
                                    <td><textarea type="text" ng-model="td.ifo" rows="2" cols="15"
                                                  ng-disabled="td.d == 1"></textarea></td>
                                    <td><textarea type="text" ng-model="td.terr" rows="2" cols="8"
                                                  placeholder="click to select" ng-enter="showTerrList($index)"
                                                  ng-click="showTerrList($index)" ng-disabled="td.r == 1"
                                                  readonly></textarea></td>
                                    <td><textarea type="text" ng-model="td.eid" rows="2" cols="8" readonly></textarea>
                                    </td>
                                    <td><textarea type="text" ng-model="td.ename" rows="2" cols="15"
                                                  readonly></textarea></td>
                                    {{--<td><input type="text" ng-model="td.edesig" size="7" readonly></td>--}}
                                    <td><textarea type="text" ng-model="td.vaddr" rows="2" cols="15"
                                                  ng-disabled="td.d == 1"></textarea></td>
                                    <td>
                                        <select ng-model="td.guest" ng-disabled="td.d == 1" >
                                            <option value="GUEST">Guest</option>
                                            <option value="INSTITUTE">Institute</option>
                                            <option value="GP">GP</option>
                                            <option value="ASSOCIATION">Association</option>
                                        </select>
                                    </td>
                                    <td><input type="text" ng-model="td.patient" size="6" ng-disabled="td.d == 1"></td>
                                    <td>
                                        <select ng-model="td.valid" ng-disabled="td.d == 1">
                                            <option value="YES">Yes</option>
                                            <option value="NO">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select ng-model="td.cata" ng-disabled="td.d == 1">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                    </td>
                                    <td style="width: 80px;">
                                        <button type="button" ng-disabled="btnTedit" ng-click="enableTrow($index)"
                                                ng-show="td.h == 1">Edit
                                        </button>
                                        <button type="button" ng-disabled="td.terr == ''" ng-click="saveTrow($index)"
                                                ng-hide="td.h == 1" title="Save Record">
                                            <i class="fa fa-check"></i></button>
                                        <button type="button" ng-click="cancelTrow($index)" ng-hide="td.h == 1"
                                                title="Cancel">X
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" ng-disabled="td.terr == '' || td.h == 0"
                                                ng-click="assignPlan(td)">Plan
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" ng-disabled="td.terr == '' || td.h == 0"
                                                ng-click="assignBrand(td)">Brand
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-offset-5 col-sm-4 col-xs-4 col-xs-offset-4" ng-if="terrData.length > 0">
                            <button type="button" ng-hide="_HBST" class="btn btn-default btn-sm"
                                    ng-disabled="terrData[0].terr == ''" ng-click="saveTerrRecord()"><i
                                        class="fa fa-floppy-o"></i> Save Territory
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{--plan part--}}
        <div class="row" ng-show="displayPlanView" ng-cloak>
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Territory Wise Doctor Plan
                        </label>
                    </header>
                    <div class="panel-body ">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Doctor ID</th>
                                    <th>Doctor Name</th>
                                    <th>Terr Id</th>
                                    <th>Emp Id</th>
                                    <th>Emp Name</th>
                                    <th class="text-center">Week1</th>
                                    <th class="text-center">Visit</th>
                                    <th class="text-center">Week2</th>
                                    <th class="text-center">Visit</th>
                                    <th class="text-center">Week3</th>
                                    <th class="text-center">Visit</th>
                                    <th class="text-center">Week4</th>
                                    <th class="text-center">Visit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="pd in planData">
                                    <td>@{{ pd.id }}</td>
                                    <td>@{{ pd.name }}</td>
                                    <td>@{{ pd.tid }}</td>
                                    <td>@{{ pd.eid }}</td>
                                    <td>@{{ pd.ename }}</td>
                                    <td class="text-center">@{{ pd.wone }}</td>
                                    <td class="text-center"><input type="checkbox" autocomplete="off" ng-model="pd.vone"
                                                                   ng-true-value="'1'" ng-false-value="'0'"></td>
                                    <td class="text-center">@{{ pd.wtwo }}</td>
                                    <td class="text-center"><input type="checkbox" autocomplete="off" ng-model="pd.vtwo"
                                                                   ng-true-value="'1'" ng-false-value="'0'"></td>
                                    <td class="text-center">@{{ pd.wthree }}</td>
                                    <td class="text-center"><input type="checkbox" autocomplete="off"
                                                                   ng-model="pd.vthree" ng-true-value="'1'"
                                                                   ng-false-value="'0'"></td>
                                    <td class="text-center">@{{ pd.wfour }}</td>
                                    <td class="text-center"><input type="checkbox" autocomplete="off"
                                                                   ng-model="pd.vfour" ng-true-value="'1'"
                                                                   ng-false-value="'0'"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="col-sm-offset-5 col-sm-4 col-xs-4 col-xs-offset-4" ng-if="planData.length > 0">
                                <button type="button" class="btn btn-default btn-sm" ng-click="savePlan()"><i
                                            class="fa fa-floppy-o"></i> Save Plan
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-3" ng-if="planTxt != ''">
                                <span style="color: #2a88bd;font-weight: bold;white-space: nowrap;">Total Plan: @{{ planTxt }}</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{--brand part--}}
        <div class="row" ng-show="displayItemView" ng-cloak>
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Doctor Brand Assign
                        </label>
                    </header>
                    <div class="panel-body ">
                        <div class="row" style="padding-bottom: 10px;">
                            <div class="col-md-12 col-sm-12 form-group " style="padding-bottom: 20px;">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label for="" class="col-sm-3" style="padding-top: 5px;"><b>Brands</b></label>
                                    <div class="col-md-8">
                                        <select ng-model="fbrand" ng-disabled="mBrands.length == 0"
                                                class="form-control input-sm">
                                            <option value="All">All</option>
                                            <option value="@{{ b }}" ng-repeat="b in mBrands ">@{{ b }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
                                    <button type="button" ng-disabled="mBrands.length == 0" ng-click="showAddedBrand()">
                                        Show brands
                                    </button>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
                                    <button type="button" ng-click="showItemList()"> Assign Brands</button>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12 text-center">
                                    <button type="button" ng-disabled="mBrands.length == 0" ng-click="deleteByBrand()">
                                        Delete Brands
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding: 0 20px 0 20px;">
                            <div ng-show="distinctBrands" class="well"
                                 style="border: 1px solid #5EB99A;border-left: 6px solid #5EB99A;padding: 8px;"
                                 ng-cloak>
                                <span ng-bind-html="snippetHtml()"></span>
                            </div>
                        </div>
                        <div class="row" style="padding: 0 20px 0 20px;">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered"
                                       ng-show="itemUtilData.length > 0">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Terr Id</th>
                                        <th>Doctor Id</th>
                                        <th>Doctor Name</th>
                                        <th>Brand</th>
                                        <th>Exposer Qty</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="udata in itemUtilData ">
                                        <td>@{{ $index+1 }}</td>
                                        <td>@{{ udata.terr }}</td>
                                        <td>@{{ udata.id }}</td>
                                        <td>@{{ udata.name }}</td>
                                        <td>@{{ udata.brand }}</td>
                                        <td><input type="number" ng-disabled="udata.d == 1" ng-model="udata.exp_qty"
                                                   min="1" max="@{{eqty}}" required></td>
                                        <td style="width: 80px;">
                                            <button type="button" ng-click="enableIrow($index)" ng-disabled="udata.r == 1" ng-show="udata.h == 1">Edit</button>
                                            <button type="button" ng-disabled="udata.exp_qty == ''" ng-click="saveIrow($index)" ng-hide="udata.h == 1" title="Save Record">
                                                <i class="fa fa-check"></i></button>
                                            <button type="button"  ng-click="cancelIrow($index)" ng-hide="udata.h == 1" title="Cancel">X</button>
                                        </td>           
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{--main terr modal--}}
        @include('rm_portal.dplan_mterr_modal')
        {{--territory list modal--}}
        @include('rm_portal.dplan_terr_modal')
        {{--item List modal--}}
        @include('rm_portal.dplan_item_modal')
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
    <script src="{{url('public/site_resource/awaitme/waitme.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/custom/doctor_plan.js')}}"></script>
    <script>
        _edesig = '{{Auth::user()->desig}}';
        _doc_search = '{{url('rm_portal/doc_search')}}';
        _terr_details = '{{url('rm_portal/terr_details')}}';
        _save_doctor = '{{url('rm_portal/save_doctor')}}';
        _terrList = '{{url('rm_portal/terrList')}}';
        _save_terr = '{{url('rm_portal/save_terr')}}';
        _plan_details = '{{url('rm_portal/plan_details')}}';
        _brand_details = '{{url('rm_portal/brand_details')}}';
        _save_plan = '{{url('rm_portal/save_plan')}}';
        _item_info = '{{url('rm_portal/item_info')}}';
        _del_item = '{{url('rm_portal/del_item')}}';
        _del_brand = '{{url('rm_portal/del_brand')}}';
        _save_brand = '{{url('rm_portal/save_brand')}}';
        _user = '{{Auth::user()->user_id}}';
    </script>
@endsection