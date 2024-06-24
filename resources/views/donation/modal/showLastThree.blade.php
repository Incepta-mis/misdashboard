<!-- The Modal -->
<div class="modal" id="dxdModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-center">Last 3 months SSRD Rx report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table style="width: 100%">
                    <tr>
                        <td><b>Beneficiary ID</b></td>
                        <td><b>Beneficiary Name</b></td>
                    </tr>
                    <tr>
                        <td><input type="text" readonly style="width: 40%" name="beID" id="beID" value=""/></td>
                        <td><i><input type="text" readonly style="width: 100%" name="beName" id="beName" value=""/></i></td>

                    </tr>

                </table>
                <div class="form-group">
                    <label class="control-label"><b>Brand</b></label>
                    <div>
                        <textarea style="width: 561px; height: 200px;" readonly name="beBrand" id="beBrand"></textarea>
                    </div>
                </div>


            </div>


            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>