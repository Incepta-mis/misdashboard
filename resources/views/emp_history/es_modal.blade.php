<div class="modal fade" id="es_modal" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="background: #337AB7;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-transform: none;">Choose from list</h4>
                </div><!--modal-header-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                              <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                              </span>
                              <input type="text" id="es_search_str" class="form-control" placeholder="Search ..."/>
                                <input type="hidden" id="es_type" value=""/>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    </div>
                    <div class="row" style="margin-top: 20px;margin-right:5px; " id="es_body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed table-striped table-hover">
                                    <thead>
                                    <tr>
                                       <!--  <th>Select</th>
                                        <th>Description</th> -->
                                         <th>Name</th>
                                    </tr>
                                    </thead>
                                    <tbody id="es_tab_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!--modal-body-->
    </div><!-- Modal content-->
</div><!-- Modal-->
