<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="mTerrList" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Main Territory List</h4>
            </div>
            <div class="modal-body" style="overflow-y: scroll;">
                <div class="col-md-12 col-sm-12" > <div class="table-responsive">
                        <table class="table table-bordered table-codensed" id="mterrtab">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Territory</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="tl in terrList" >
                                <td><button type="button" ng-click="selectmTerr(tl)">Select</button></td>
                                <td>@{{ tl.mpo_terr_id }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
