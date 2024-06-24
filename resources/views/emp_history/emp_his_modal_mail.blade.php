<div id="mail_emphis_id" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        {{--<form class="form-horizontal" method="post" action="{{url('ehf/emp_mail_pdfsent')}}">--}}
            {{--{{csrf_field()}}--}}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mail sent</h4>
            </div>
            <div class="modal-body">
                <div>
                    <label for="">Mail address</label>
                    <input type="text" id="mail_personal_id_pdf">
                    <span id="mail_emp_is"></span>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" id="btn_submit_mal" class="final_sentmail btn btn-success btn-lg">
                    <i class="fa fa-check"></i> <b>Sent</b></button>
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

        {{--</form>--}}

    </div>
</div>