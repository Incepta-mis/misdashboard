
<div class="modal fade" id="decision_err_emphis_id" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background: #337AB7;padding: 10px;">
                <h3 class="modal-title row_initial">Are you sure?</h3>
                <h3 class="modal-title row_secondary" style="display: none;">Success</h3>
            </div><!--modal-header-->
            <div class="modal-body">
                <div class="row_initial"><b>Once Submitted, you cannot change the following data field:
                        <br>
                        <br>
                        <ul>
                            <li class="text-warning"> Name</li>
                            <li class="text-warning"> Permanent Address</li>
                            <li class="text-warning"> Education</li>
                            <li class="text-warning"> Employment Record</li>
                            <li class="text-warning"> Nominee</li>
                        </ul>
                    </b>
                    <br></div>
                <div class="row_secondary" style="display: none;">
                    <b>You have Successfully submitted your Employee History Form!.</b>
                    <br>
                </div>
                <div class="mail_div" style="display: none;margin-top: 10px;">
                    <div class="form-group">
                        <label for="email_add">Email Address</label>
                        <div class="input-group input-group-sm">
                            <input type="text"
                                   class="form-control"
                                   id="user_email_address"
                                   placeholder="Please type your email">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="btn_send_mail" type="button">
                                   <i class="fa fa-envelope"></i> Submit
                                </button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
            </div><!--modal-body-->

            <div class="modal-footer">
                <div class="row_initial" >
                    <button class="btn btn-sm btn-success" id="btnYes"><i class="fa fa-check"></i> Yes</button>
                    <button class="btn btn-sm btn-danger" id="btnNo" class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> No</button>
                </div>
                <div class="row_secondary" style="display: none;" >
{{--                    <button class="btn btn-info btn-sm" data-dismiss="modal" aria-hidden="true">Save and Temporarily</button>--}}
                    <button type="button" class="btn btn-success btn-sm bpf_pdf">
                        <i class="fa fa-file"></i> <b>Download PDF</b></button>

                    <button type="button" id="btn_email_div" class="btn btn-primary btn-sm">
                        <i class="fa fa-envelope"></i> <b>Email PDF</b></button>
                    <button class="btn btn-danger btn-sm btnCloseModal"><i class="fa fa-times"></i> Close</button>
                </div>
            </div><!--modal-footer-->
        </div><!-- Modal content-->


    </div>
</div>
