
<div class="modal fade" id="decision_emphis_id" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <form class="form-horizontal" method="post" action="{{url('ehf/emp_final_pdfform')}}">
            {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header" style="background: #337AB7">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title">Download pdf?</h3>
                </div><!--modal-header-->
                <div class="modal-body">

                <span style="color:red;font-size: 18px"> Are you sure the informations are correct? <br> Because after clicking download, you can not fill up following fields

                <ul style="color:green;font-size: 16px">
                    <li>Name</li>
                    <li>Permanent Address</li>
                    <li>Education</li>
                    <li>Employee Record</li>
                    <li>Nominee</li>
                </ul>

                </span>



                    <button type="submit" id="btn_submit" class="btn btn-success btn-lg">
                        <i class="fa fa-check"></i> <b>Download pdf</b></button>


                </div><!--modal-body-->




            </div><!-- Modal content-->
        </form>

    </div><!-- Modal dialog-->
</div><!-- Modal-->
