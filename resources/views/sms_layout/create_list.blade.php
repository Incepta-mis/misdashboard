<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="createList" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">
                    <span ng-show="uploadType.type == 'F'"><i class="fa fa-plus-circle"></i> Create Contact List</span>
                    <span ng-hide="uploadType.type == 'F'"><i class="fa fa-plus-circle"></i> Create Contact</span>

                </h4>
            </div>
            <div class="modal-body" id="create_list_modal" style="overflow-y: scroll;">
                <div class="col-md-12 col-sm-12">

                    <div class="row" style="padding: 10px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="border: 1px solid grey;">
                                <label class="radio-inline">
                                    <input type="radio" name="uploadType" ng-model="uploadType.type" value="F"><span
                                            class="text-primary">Form File</span>
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="uploadType" ng-model="uploadType.type" value="D"><span
                                            class="text-primary">Direct
                                    Input</span>
                                </label>
                                <div ng-show="uploadType.type == 'F'">

                                    <div class="form-group" style="padding: 20px 0 25px 0;">
                                        <label for="" class="col-md-4 text-primary" style="padding-top: 6px;">Upload
                                            from xls/xlsx</label>
                                        <div class="col-md-8" style="padding: 5px;border:1px solid;">
                                            <input type="file" id="file" name="file"
                                                   onchange="angular.element(this).scope().fileChanged(this.files)"
                                                   >
                                        </div>
                                    </div>
                                    <br>
                                    <div class="text-center">
                                        <img src="{{url('public/site_resource/images/grp_up_frmt.jpg')}}"
                                             class="img-thumbnail img-responsive" alt="xl format">
                                    </div>
                                    <br>
                                    <div class="text-success">
                                            <span class="text-danger">Maximum numbers allowed for a single file is 3000</span>
                                    </div>
                                </div>
                                <div ng-hide="uploadType.type == 'F'">
                                    <br>
                                    <div class="form-group" style="padding-bottom: 8px;">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="col-md-4" style="padding-top: 7px;">Group</label>
                                                <div class="col-md-8">
                                                    <select name="grpType" ng-model="contact.grp" class="form-control input-sm">
                                                        <option value="NEW">New</option>
                                                        <option ng-repeat="g in grpList" ng-if="g.create_user === 'Y'" value="@{{g.grp_id}}" >@{{ g.grp_name }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group" ng-show="contact.grp=='NEW'">
                                                <label class="col-md-4">Group Name *</label>
                                                <div class="col-md-8"><input type="text" ng-model="contact.ngname" class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4">Employee Id *</label>
                                                <div class="col-md-8"><input type="text" ng-model="contact.emp_id" class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4">Employee Name</label>
                                                <div class="col-md-8"><input type="text" class="form-control input-sm" ng-model="contact.emp_name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4">Contact No *</label>
                                                <div class="col-md-8"><input type="text" class="form-control input-sm" ng-model="contact.c_no"
                                                                             value=""></div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="text-success">
                                        <span class="text-justify">
                                            Note: Numbers format .(Ex-01812345678)
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-success" ng-click="upload()">
                    <span ng-hide="isSending"><i class="fa fa-save"></i> Upload & Save</span>
                    <span ng-show="isSending" ng-disabled="isSending"><i class="fa fa-spinner fa-spin"></i>
                       <span ng-show="uploadType.type == 'F'">Uploading...</span>
                       <span ng-hide="uploadType.type == 'F'">Saving...</span>
                    </span>
                </button>
                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
