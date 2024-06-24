<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="file_view" class="modal fade"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Print Document</h4>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="progress progress-striped active progress-sm" ng-if="isPrinting">
                        <div style="width: 100%"
                             aria-valuemax="100"
                             aria-valuemin="0"
                             aria-valuenow="100"
                             role="progressbar"
                             class="progress-bar progress-bar-success">
                            <span class="sr-only">Working</span>
                        </div>
                    </div>
                    <div class="panel panel-primary" style="border: 1px solid #337ab7;">
                        <div class="panel-body">
                            <label class="radio-inline">
                                <input type="radio" name="print_type" ng-model="printType"
                                       ng-change="printTypeChange()" value="I">Initial Print
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="print_type" ng-model="printType"
                                       ng-change="printTypeChange()" value="R">Reprint
                            </label>
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="batchno">Batch</label>
                                <input type="text"
                                       ng-model="batch"
                                       class="form-control"
                                       placeholder="Enter Batch"
                                       min="1"
                                >
                            </div>
                            <div class="form-group" ng-show="printType === 'R'" style="margin-top: 10px;">
                                <label for="comment">Reason for reprint</label>
                                <textarea ng-model="comment" class="form-control" rows="3"
                                          placeholder="Enter Reason" maxlength="100"></textarea>
                            </div>
                            {{--                                <br ng-if="printType === 'I'">--}}
                            <button class="btn btn-sm btn-success" ng-click="print()"
                                    ng-style="printType === 'I' && {'margin-top':'10px'}"
                                    ng-disabled="isPrinting">
                                <span ng-if="!isPrinting"><i class="fa fa-print"></i> View Document </span>
                                <span ng-if="isPrinting"><i class="fa fa-spinner fa-spin"></i> Please wait</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-sm" ng-click="dismissModal()">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
