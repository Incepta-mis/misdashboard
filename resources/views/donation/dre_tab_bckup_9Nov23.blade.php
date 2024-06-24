<table class="table table-condensed table-striped table-bordered" id="dre" ng-cloak="">
    <thead>
    <tr>
        <th></th>
        <th>Doc.ID(*)</th>
        <th>Territory(*)</th>
        <th>Name(*)</th>
        <th>In Favor Of(*)</th>
        <th>Expense Type(*)</th>
        <th>Group/Brand/Region(*)</th>
        <th>Frequency(*)</th>
        <th>Payment Mode(*)</th>
        <th>Proposed Amt.(*)</th>
    </tr>
    </thead>
    <tbody>
    <tr ng-repeat="td in dataArr" ng-if="dataArr.length > 0" >
        <td>
            <input type="checkbox" class="chk form-control" name="row_chk" ng-model="td.check" >
        </td>
        <td style="white-space: nowrap;">
            <input type="text" name="doc_id" class="doc_id form-control"
                   ng-model="td.doc_id" autocomplete="off"
                   maxlength="6" size="6"
                   ng-enter="fetchDoctor(td.doc_id,$index)">
        </td>
        <td>
            <select name="mpo_terr" class="mpo_terr form-control" ng-model="td.mpo_terr" ng-change="reset_exp($index)">
                <option value="" disabled selected>Select Terr</option>
                <option ng-repeat="terr in td.mterrList"
                        value="@{{ terr.terr_id }}|@{{ terr.eid }}|@{{ terr.ename }}">
                    @{{ terr.terr_id }}
                </option>
            </select>
        </td>
        <td>
            <input type="text" name="doc_name" title="@{{td.doc_name}}" style="text-transform: uppercase;" class="doc_name form-control" ng-model="td.doc_name"
                   autocomplete="off" readonly="">
        </td>
        <td>
            <input type="text" name="ifav" title="@{{td.ifav}}" style="text-transform: uppercase;" class="ifav form-control" ng-model="td.ifav"
                   autocomplete="off" ng-readonly="td.ifavRonly">
        </td>
        <td>
            <select name="exp_type" class="exp_type form-control" ng-model="td.exp_type"  ng-change="fetch_gbr($index,td.exp_type)">
                <option value="" disabled selected>Select Type</option>
                <option ng-repeat="dtype in expType"
                        value="@{{ dtype.type}}|@{{dtype.gl}}|@{{ dtype.main_cost_center_name}}|@{{ dtype.type_name }}">
                    @{{ dtype.type_name }}
                </option>
            </select>
        </td>
        <td>
            <select name="gbr_name"  class="gbr_name form-control" ng-model="td.gbr_name" ng-change="reset_pay_mode($index)">
                <option value="" disabled selected>Select Group/Brand/Region</option>
                <option value="@{{ s.cost_center_id }}|@{{ s.cost_center_name }}|@{{ s.sub_cost_center_id }}" ng-repeat="s in td.gbrList">@{{ s.cost_center_name }}</option>
            </select>
        </td>
        <td>
            <select name="frequency" ng-disabled="td.freqRonly" class="frequency form-control" ng-model="td.frequency" ng-change="checkDoctor($index)">
                <option value="" disabled selected>Select Frequency</option>
                <option  ng-repeat="f in freq" value="@{{ f.df_description }}">@{{ f.df_description }}</option>
            </select>
        </td>
        <td>
            <select name="pay_mode" ng-disabled="td.pmodeRonly" class="pay_mode form-control" ng-model="td.pay_mode" >
                <option value="" disabled selected>Select Mode</option>
                <option  ng-repeat="m in pay_mode" value="@{{ m }}">@{{ m }}</option>
            </select>
        </td>
        <td>
            <input type="text" name="proposed_amt" class="proposed_amt form-control"
                   ng-model="td.proposed_amt" pattern="\d*"
                   autocomplete="off" maxlength="8" size="8" ng-change="checkval($index,td.proposed_amt)" ng-enter="addAmount()">
        </td>
    </tr>
    <tr ng-if="dataArr[0].proposed_amt > 0">
        <td colspan="9" style="text-align: right;"><b>Total Amount</b></td>
        <td ><b>@{{ totalAmt | number }} \=</b></td>
    </tr>
    <tr ng-show="showInitProgress">
        <td colspan="10" class="text-center">
            <i class="fa fa-spin fa-spinner" style="font-size: 20px;"></i>
            <span style="font-size: 15px;">  Please Wait..</span></td>
    </tr>
    </tbody>
</table>
