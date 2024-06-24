<!-- Modal -->
<div class="deleteRequisitioin modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color:#ce6574">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Proposal</h4>
            </div>
            <div class="modal-body">
                <center>
                    <p>Are you sure you want to delete <span style="color:red" id="ex_date_m"></span> this proposal ???</p>
                </center>
                 <div class="overlay">
                    <div id="loading-img"></div>
                </div>

            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger del-modal-requisition" >Delete</button>


                </center>

            </div>
        </div>

    </div>
</div>
