<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_mail_data"
     class="modal fade"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{--            <div class="modal-header">--}}
            {{--                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>--}}
            {{--                <h4 class="modal-title">Mail Data</h4>--}}
            {{--            </div>--}}
            <div class="modal-body">
                <section class="panel">
                    <header class="panel-heading custom-tab" style="text-transform: none;">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#master" data-toggle="tab">Maintain To/Cc/Bcc</a>
                            </li>
                            <li class="">
                                <a href="#details" data-toggle="tab">Maintain Employee</a>
                            </li>
                        </ul>
                    </header>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="master">
                                <div class="col-md-12 col-sm-12 table-responsive">
                                    <div>
                                        <div class="pull-left">
                                            <button ng-click="create_row('m')"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="pull-right" style="margin-bottom: 10px;">
                                            <input type="text" name="searchText_m" id="searchText_m"
                                                   ng-model="searchText_m" placeholder=" Search..">
                                        </div>
                                    </div>
                                    <div ng-if="newRecordM" class="row">
                                        <table class="table table-bordered table-condensed">
                                            <tbody>
                                            <tr>
                                                <td><input type="text" class="form-control input-sm"
                                                           ng-model="newRowM.department" placeholder="Department"></td>
                                                <td><input type="text" class="form-control input-sm"
                                                           ng-model="newRowM.section" placeholder="Section"></td>
                                                <td><input type="text" class="form-control input-sm"
                                                           ng-model="newRowM.mail_to" placeholder="Mail To"></td>
                                                <td><input type="text" class="form-control input-sm"
                                                           ng-model="newRowM.mail_cc" placeholder="Mail Cc"></td>
                                                <td><input type="text" class="form-control input-sm"
                                                           ng-model="newRowM.mail_bcc" placeholder="Mail Bcc"></td>
                                                <td style="vertical-align: middle;">
                                                    <button ng-disabled="newRowM.department == '' || newRowM.section == ''
                                                                || newRowM.mail_to == ''"
                                                            ng-click="add_row('m')"><i class="fa fa-check" ></i></button>
                                                    <button ng-click="cancel_entry('m')"><i class="fa fa-times" ></i></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <table class="table table-condensed table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Section</th>
                                            <th class="text-center">Mail To</th>
                                            <th class="text-center">Mail Cc</th>
                                            <th class="text-center">Mail Bcc</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr dir-paginate="c in masterRecords| filter: searchText_m | itemsPerPage:10"
                                            pagination-id="pg1">
                                            <td>
                                                <span>@{{ c.department }}</span>
                                            </td>
                                            <td>
                                                <span>@{{ c.section }}</span>
                                            </td>
                                            <td>
                                                <span ng-show="c.d == '0'" title="@{{ c.mail_to }}"> @{{ c.mail_to.substr(0,35)+' ...' }}</span>
                                                <input type="text" ng-hide="c.d == '0'" ng-model="c.mail_to"
                                                       value="@{{ c.mail_to }}">
                                            </td>
                                            <td>
                                                <span ng-show="c.d == '0'" title="@{{ c.mail_cc }}"> @{{ c.mail_cc.substr(0,35)+' ...' }}</span>
                                                <input type="text" ng-hide="c.d == '0'" ng-model="c.mail_cc"
                                                       value="@{{ c.mail_cc }}">
                                            </td>
                                            <td>
                                                <span ng-show="c.d == '0'" title="@{{ c.mail_bcc }}"> @{{ c.mail_bcc.substr(0,35)+' ...' }}</span>
                                                <input type="text" ng-hide="c.d == '0'" ng-model="c.mail_bcc"
                                                       value="@{{ c.mail_bcc }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" title="Edit row" ng-show="c.d == '0'"
                                                        ng-click="enable_row(c)">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button type="button" title="Save" ng-hide="c.d == '0'"
                                                        ng-click="save_row(c,'m')">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button type="button" title="Cancel Edit" ng-hide="c.d == '0'"
                                                        ng-click="cancel_edit(c)">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <button type="button" title="Delete row" ng-show="c.d == '0'"
                                                        ng-click="delete_row(c,'m')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr ng-if="masterRecords.length === 0">
                                            <td>
                                                <br>
                                                <b>!!No Records Available!!</b>
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
                            <div class="tab-pane" id="details">
                                <div class="col-md-12 col-sm-12 table-responsive">
                                    <div>
                                        <div class="pull-left">
                                            <button ng-click="create_row('d')"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="pull-right" style="margin-bottom: 10px;">
                                            <input type="text" name="searchText" id="searchText" ng-model="searchText"
                                                   placeholder=" Search..">
                                        </div>
                                    </div>
                                    <div ng-if="newRecordD" class="row">
                                        <table class="table table-bordered table-condensed">
                                            <tbody>
                                            <tr>
                                                 <td>
{{--                                                    <input type="text" class="form-control input-sm"--}}
{{--                                                           ng-model="newRowD.department" placeholder="Department">--}}
                                                    <select name="dept" id="dept" ng-model="newRowD.department" class="form-control input-sm">
                                                        <option value="" disabled selected>Select Department</option>
                                                        <option ng-repeat="d in deptList" value="@{{ d.dept }}">@{{ d.dept }}</option>
                                                    </select>
                                                </td>
                                                <td>
{{--                                                    <input type="text" class="form-control input-sm"--}}
{{--                                                           ng-model="newRowD.section" placeholder="Section">--}}
                                                    <select name="sect" id="sect" ng-model="newRowD.section" class="form-control input-sm">
                                                        <option value="" disabled selected>Select Section</option>
                                                        <option ng-repeat="s in sections" value="@{{ s.section }}">@{{ s.section }}</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control input-sm"
                                                           ng-model="newRowD.emp_id" placeholder="Employee Id"></td>
                                                <td style="vertical-align: middle;">
                                                    <button ng-click="add_row('d')"
                                                            ng-disabled="newRowD.department == '' || newRowD.section == ''
                                                                || newRowD.emp_id == ''"><i class="fa fa-check"></i></button>
                                                    <button ng-click="cancel_entry('d')"><i class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <table class="table table-condensed table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Section</th>
                                            <th class="text-center">Employee Id</th>
                                            <th class="text-center">Employee Name</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr dir-paginate="c in detailRecords| filter: searchText | itemsPerPage:10"
                                            pagination-id="pg2">
                                            <td>
                                                <span>@{{ c.department }}</span>
                                            </td>
                                            <td>
                                                <span>@{{ c.section }}</span>
                                            </td>
                                            <td>
                                                <span ng-show="c.d == '0'"> @{{ c.emp_id }}</span>
                                                <input type="text" ng-hide="c.d == '0'" ng-model="c.emp_id"
                                                       value="@{{ c.emp_id }}">
                                            </td>
                                            <td>
                                                <span>@{{ c.name }}</span>
                                            </td>
                                            <td class="text-center">
                                                {{--                                                <button type="button" title="Edit row" ng-show="c.d == '0'" ng-click="enable_row(c)">--}}
                                                {{--                                                    <i class="fa fa-pencil"></i>--}}
                                                {{--                                                </button>--}}
                                                {{--                                                <button type="button" title="Save" ng-hide="c.d == '0'" ng-click="save_row(c,'d')">--}}
                                                {{--                                                    <i class="fa fa-check"></i>--}}
                                                {{--                                                </button>--}}
                                                {{--                                                <button type="button" title="Cancel Edit" ng-hide="c.d == '0'"--}}
                                                {{--                                                        ng-click="cancel_edit(c)">--}}
                                                {{--                                                    <i class="fa fa-times"></i>--}}
                                                {{--                                                </button>--}}
                                                <button type="button" title="Delete row" ng-show="c.d == '0'"
                                                        ng-click="delete_row(c,'d')">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr ng-if="detailRecords.length === 0">
                                            <td>
                                                <br>
                                                <b>!!No Contacts Available!!</b>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <dir-pagination-controls max-size="5" pagination-id="pg2"
                                                             direction-links="true"
                                                             boundary-links="true">
                                    </dir-pagination-controls>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm" ng-click="dismiss_modal()">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

