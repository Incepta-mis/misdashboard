<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="itemList" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Brand List</h4>
            </div>
            <div class="modal-body" id="item_modal"  style="overflow-y: scroll;">
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-sm-4 from-group">
                            <label for="" class="col-sm-4" style="margin-top: 5px;font-weight: normal;">Type</label>
                            <div class="col-sm-8">
                                <select ng-model="scType" ng-change="brandbyType()" class="form-control input-sm"
                                        ng-class="showRloader">
                                    <option ng-repeat="letter in letters" value="@{{ letter }}">@{{ letter }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center text-success" style="padding-top: 6px;font-weight: bold;">Brand Added ( @{{ mBrands.length }} )</div>
                        <div class="col-sm-4  form-group">
                            <label for="" style="margin-top: 5px;">
                                <input type="checkbox" ng-model="all" ng-click="selectAll()"
                                       ng-disabled="brands.length == 0">
                                Select All
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-codensed" id="itemtab">
                            <thead>
                            <tr>
                                <th class="text-center">Select (<i class="fa fa-check"></i>)</th>
                                <th>Brand Name</th>
                                <th class="text-center">Exposure Qty</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="brand in brands" ng-class="{ 'bg-info' : brand.stat == 'Y'}">
                                <td class="text-center"><input type="checkbox" ng-model="brand.val" ng-true-value="'1'"
                                                               ng-checked="brand.stat == 'Y'" ng-disabled="brand.stat == 'Y'"
                                                               ng-false-value="'0'" ng-click="nchange_qty(brand)"></td>
                                <td>@{{ brand.brand }}</td>
                                <td class="text-center"><input type="number" ng-model="brand.s_qty" min="1"
                                                               max="@{{ defaultQty }}" ng-hide="brand.stat == 'Y'">
                                    <span ng-show="brand.stat == 'Y'" class="text-center text-primary">
                                        <i class="fa fa-check"></i> Assigned</span>
                                </td>

                            </tr>
                            <tr ng-if="brands.length == 0">
                                <td colspan="7" class="text-center">
                                    No Data Available
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" ng-click="closeItemList()">
                    <i class="fa fa-save"></i> Save
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</div>
