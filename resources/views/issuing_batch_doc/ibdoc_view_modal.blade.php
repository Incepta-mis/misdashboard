<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="file_view" class="modal fade"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
{{--            <div class="modal-header">--}}
{{--                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>--}}
{{--                <h4 class="modal-title">Print Document</h4>--}}
{{--            </div>--}}
            <div class="modal-body" >
                <div class="col-md-12 col-sm-12">
                    <div class="col-md-4">
                        <div class="panel panel-primary card card-1" style="border: 1px solid #337ab7;">
                            <div class="panel-body">
                                <label class="radio-inline">
                                    <input type="radio" name="print_type" ng-model="printType" ng-change="printTypeChange()" value="I">Initial Print
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="print_type" ng-model="printType" ng-change="printTypeChange()" value="R">Reprint
                                </label>
                                <div class="form-group" ng-show="printType === 'R'" style="margin-top: 10px;">
                                    <label for="comment">Reason for reprint</label>
                                    <textarea ng-model="comment" class="form-control" rows="3"
                                              placeholder="Enter Reason here" maxlength="100"></textarea>
                                </div>
                                <br ng-if="printType !== 'R'">
                                <label class="radio-inline">
                                    <input type="radio" name="page_type" ng-change="pageTypeChange()" ng-model="pageType" value="A">Print All Pages
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="page_type" ng-change="pageTypeChange()" ng-model="pageType" value="S">Pages
                                </label>
                                <input type="text" ng-show="pageType === 'S'" ng-model="pageNumber"
                                       class="form-control input-sm" style="margin-top: 10px;"
                                placeholder="Enter Page Number(e.g:1,4,5-9)">
                                <br ng-if="pageType === 'A'">
                                <button class="btn btn-sm btn-success" ng-click="print()" style="margin-top: 10px;" ng-disabled="isPrinting">
                                    <span ng-if="!isPrinting"><i class="fa fa-print"></i> Print Document</span>
                                    <span ng-if="isPrinting" >
                                        <i class="fa fa-spinner fa-spin"></i> Printing Document
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-primary" style="border: 1px solid #337ab7;">
                            <div class="panel-heading" style="padding: 3px;text-transform: none;font-weight: normal;">
                                <button id="prev" class="btn btn-sm btn-default" ng-click="onPrevPage()">Previous</button>
                                <button id="next" class="btn btn-sm btn-default" ng-click="onNextPage()">Next</button>
                                <span class="pull-right" style="padding: 4px;margin-right: 15px;">
                                    <i>Page: <span id="page_num"></span> / <span id="page_count"></span></i>
                                </span>
                            </div>
                            <div class="panel-body text-center shadow" style="background-color: #a9a2a2;">
                                <canvas id="the-canvas"></canvas>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" ng-click="dismissModal()">Close</button>
            </div>
        </div>
    </div>
</div>
