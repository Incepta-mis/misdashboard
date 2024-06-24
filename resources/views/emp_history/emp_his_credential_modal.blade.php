<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="ehcmodal" class="modal fade"
     style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #337AB7">
                <h4 class="modal-title">Please Login to Continue..</h4>
            </div>
            <div class="modal-body">
{{--                progressbar--}}
                <div class="progress progress-striped active progress-sm" id="ehc_progress"
                     style="margin-bottom: 10px; display: none;">
                    <div style="width: 100%"
                         aria-valuemax="100"
                         aria-valuemin="0"
                         aria-valuenow="100"
                         role="progressbar"
                         class="progress-bar progress-bar-primary">
                        <span class="sr-only">Please wait....</span>
                    </div>
                </div>
{{--                buttons--}}
                <form>
                    <div id="ehc_buttons">
                        <button class="btn btn-block btn-info ehc_btn ehc_hide" name="signin" type="button">
                        <span class="pull-left">
                            <i class="fa fa-sign-in"></i>
                        </span>
                            <span class="bold">Sign In</span>
                        </button>
                        <button class="btn btn-block btn-info ehc_btn ehc_hide" name="signup" type="button">
                        <span class="pull-left">
                            <i class="fa fa-edit"></i>
                        </span>
                            <span class="bold">Sign Up</span>
                        </button>
                        <button class="btn btn-block btn-danger ehc_btn" name="fpass" type="button">
                        <span class="pull-left">
                            <i class="fa fa-info"></i>
                        </span>
                            <span class="bold">Forgot Password</span>
                        </button>
                    </div>
                    <div id="ehc_error" style="display: none;">
                        <div class="alert alert-warning">
                            <p><i class="fa fa-info"></i> <span id="ehc_error_msg">Password Didn't Matched</span></p>
                        </div>
                    </div>
                    <div id="ehc_fields" style="display: none;">
                        <div class="form-group" id="ehc_pass">
                            <label>Password</label>
                            <div class="iconic-input">
                                <i class="fa fa-lock" style="padding-top: 2px;"></i>
                                <input type="password" autocomplete="nope" id="eh_pass" class="form-control"
                                       minlength="6" placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="form-group" id="ehc_cpass">
                            <label>Confirm Password</label>
                            <div class="iconic-input">
                                <i class="fa fa-lock" style="padding-top: 2px;"></i>
                                <input type="password" autocomplete="nope" id="eh_cpass" class="form-control"
                                       minlength="6" placeholder="Repeat Password">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="ehc_btn_close"><i class="fa fa-times"></i> Close</button>
                <button type="button" class="btn btn-default" id="ehc_btn_back" style="display: none;"><i class="fa fa-angle-left"></i> Back</button>
                <button type="button" class="btn btn-success" id="ehc_btn_signup" style="display: none;"><i class="fa fa-check"></i> Signup</button>
                <button type="button" class="btn btn-success" id="ehc_btn_signin" style="display: none;"><i class="fa fa-check"></i> Signin</button>
                <button type="button" class="btn btn-success" id="ehc_btn_fpass" style="display: none;"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>
