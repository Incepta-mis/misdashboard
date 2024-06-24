<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="editContacts" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">
                    <span><i class="fa fa-book"></i> Contact List</span>
                </h4>
            </div>
            <div class="modal-body" id="create_list_modal" style="overflow-y: scroll;">
                <div class="col-md-12 col-sm-12 table-responsive">
                    <div>
                        <div class="pull-left"><span>Group Name: @{{ contactList[0].grp_name }}</span></div>
                        <div class="pull-right" style="margin-bottom: 10px;">
                            <input type="text" name="searchText" id="searchText" ng-model="searchText" placeholder=" Search..">
                        </div>
                    </div>
                    <table class="table table-condensed table-striped table-bordered">
                        <thead>
                        <tr>
                        <th></th>
                        <th class="text-center">Id</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Contact No.</th>
                        <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr dir-paginate="c in contactList| filter: searchText | itemsPerPage:12" pagination-id="pg2">
                            <td class="text-center" style="padding: 4px;"><i class="fa fa-user"></i></td>
                            <td class="text-center">
                                <span>@{{ c.emp_code }}</span>
                            </td>
                            <td class="text-center">
                                <span ng-show="c.d == '0'">@{{ c.emp_name }}</span>
                                <input type="text" ng-model="c.emp_name" ng-hide="c.d == '0'" value="@{{ c.emp_name }}">
                            </td>
                            <td class="text-center">
                                <span ng-show="c.d == '0'"><i class="fa fa-phone"></i> @{{ c.contact_no }}</span>
                                <input type="text" ng-hide="c.d == '0'" ng-model="c.contact_no"
                                       value="@{{ c.contact_no }}">
                            </td>
                            <td class="text-center">
                                <button type="button" title="Edit row" ng-show="c.d == '0'" ng-click="enable_row(c)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" title="Save" ng-hide="c.d == '0'" ng-click="save_row(c)">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button type="button" title="Cancel Edit" ng-hide="c.d == '0'"
                                        ng-click="cancel_edit(c)">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button type="button" title="Delete row" ng-show="c.d == '0'" ng-click="delete_row(c)">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                        </tr>
                        <tr ng-if="contactList.length === 0">
                            <td>
                                <br>
                                <img src="{{url('public/site_resource/images/contacts_logo.png')}}"
                                     alt="no contacts" width="80" height="80">
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
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-sm btn-default">--}}
                {{--<i class="fa fa-save"></i> Done--}}
                {{--</button>--}}
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
