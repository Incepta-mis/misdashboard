<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="terrList" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">Territory List</h4>
            </div>
            <div class="modal-body" style="overflow-y: scroll;">
               <div class="col-md-12 col-sm-12" > <div class="table-responsive">
                    <table class="table table-bordered table-codensed" id="terrtab">
                        <thead>
                        <tr>
                            <th>Action</th>                   
                            <th>Territory</th>
                            <th>Mpo Id</th>
                            <th>Mpo Name</th>
                            <th>Mpo Designation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="tl in terrList" >
                            <td><button type="button" ng-click="selectTerr(tl)">Select</button></td>
                            <td>@{{ tl.mpo_terr_id }}</td>
                            <td>@{{ tl.mpo_emp_id }}</td>
                            <td>@{{ tl.mpo_name }}</td>
                            <td>@{{ tl.desig }}</td>
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
