<div class="panel panel-primary setup-content" id="step-4">
    <div class="panel-heading">
        <h3 class="panel-title">Page 4</h3>
    </div>
    <form method="post" id="frm_pagefour">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="emp_code_id" name="emp_code_nam" readonly value="{{$login_moreinfo[0]->emp_id}}"/>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-10 col-sm-10">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Nominee List
                            @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')
                                    <scan style="color:#fd6363;font-size:13px;text-transform: none;"><b> (For
                                            Update,Contact with HR.) </b></scan>
                                @endif
                            @else
                            @endif
                        </legend>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped nominee_table">
                                <!-- thead -->
                                <thead>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact No.</th>
                                <th>Relationship</th>
                                <th>% of Share</th>
                                <th style="text-align: center;">
                                    <a href="#" class="addRowNominee">
                                        <i class="glyphicon glyphicon-plus"></i>
                                    </a>
                                </th>
                                </thead>
                                <!-- TBODY -->
                                <tbody>
                                @forelse($emp_his_nomi_data as $nominee)
                                    <tr>
                                        <td style="display: none">
                                            <input type="hidden" class="row_id" value="{{$loop->index}}">
                                        </td>
                                        <td>
                                            <input type="text" value="{{$nominee->nominee_nam}}" name="nominee_nam[]"
                                                   class="hr_restrict form-control ">
                                        </td>
                                        <td>
                                            <input type="text" value="{{$nominee->nominee_addr}}" name="nominee_addr[]"
                                                   class="hr_restrict form-control ">
                                        </td>
                                        <td>
                                            <input type="text" value="{{$nominee->nominee_mob_no}}"
                                                   name="nominee_contact_no[]"
                                                   class="hr_restrict form-control " maxlength="11">
                                        </td>
                                        <td>
                                            <input type="text" value="{{$nominee->nominee_rel}}" name="nominee_rela[]"
                                                   readonly=""
                                                   class="hr_restrict form-control  nominee_list"
                                                   placeholder="Click to select Nominee">
                                        </td>
                                        <td>
                                            <input type="text" value="{{$nominee->nominee_share}}"
                                                   name="nominee_share[]"
                                                   class="hr_restrict form-control  nominee_share_clss">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm remove_nominee">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td style="display: none">
                                            <input type="hidden" class="row_id" value="0">
                                        </td>
                                        <td>
                                            <input type="text" name="nominee_nam[]" class="form-control ">
                                        </td>
                                        <td>
                                            <input type="text" name="nominee_addr[]" class="form-control ">
                                        </td>
                                        <td>
                                            <input type="text" name="nominee_contact_no[]"
                                                   class="form-control ">
                                        </td>
                                        <td>
                                            <input type="text" name="nominee_rela[]" readonly
                                                   class="form-control  nominee_list"
                                                   placeholder="Click to select Nominee">
                                        </td>
                                        <td>
                                            <input type="text" name="nominee_share[]"
                                                   class="form-control  nominee_share_clss">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-danger remove_nominee">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>

                            </table>
                        </div>
                    </fieldset>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 text-center">
                    <input type="hidden" id="url_n"
                           value="{{url('ehf/nomineeImage_hr')}}|{{url("public/emp_history_img/nominee/")}}">
                    <div class="loader">
                            <span style="position: absolute;margin-top: 64px;margin-left: 62px;font-size: 30px; display: none;"
                                  id="img_loader">
                                <i class="fa fa-spinner fa-spin"></i>
                            </span>
                        <img id="img-nominee-preview"
                             onError="this.onerror=null;this.src='{{url('public/site_resource/images/user.png')}}';"
                             src="{{isset($emp_his_nomi_data[0]) && $emp_his_nomi_data[0]->nominee_img ? url('public/emp_history_img/nominee/').'/'.$emp_his_nomi_data[0]->nominee_img : url('public/site_resource/images/user.jpg')}}"
                             class="img img-thumbnail" width="150px" height="150px" alt="nominee photo">
                    </div>
                    <input type="file"
                           accept="image/jpeg, image/jpg"
                           class="btn btn-sm btn-default btn-block"
                           id="img-nominee"
                           style="height: 21px;padding-top: 0px;">
                </div>
                {{--//distribution part--}}
                @if(strtoupper($login_moreinfo[0]->emp_dept_name) == 'DISTRIBUTION' || strtoupper($login_moreinfo[0]->emp_dept_name) =='CENTRAL WAREHOUSE')
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cl-dist">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                Guarantor Details
                            </legend>
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label>Guarantor Name <span class="relative"><span
                                                    class="required-star">*</span></span></label>
                                    <input class="form-control  input-style err_input_empty cl_grname" type="text"
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_nam:""}}"
                                           name="careOfguar">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <label>Relation <span class="relative"><span
                                                    class="required-star">*</span></span></label>
                                    <input class="form-control  input-style err_input_empty cl_grrel" type="text"
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_relation:""}}"
                                           name="relationOfguar">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>Home Address <span class="relative"><span
                                                    class="required-star">*</span></span></label>
                                    <textarea class="form-control  input-style err_input_empty cl_grhaddr"
                                              name="grntrHomeAdd">{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_homeaddr:""}}</textarea>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px;">
                                <div class=" col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label>Police Station <span class="relative"><span
                                                    class="required-star">*</span></span></label>

                                    <input class="form-control  input-style cl_grpstat" type="text"
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_polista:""}}"
                                           name="postStaguar">
                                </div>

                                <div class=" col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label>Post Office <span class="relative"><span
                                                    class="required-star">*</span></span></label>

                                    <input class="form-control  input-style cl_grpoff" type="text"
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_postoff:""}}"
                                           name="postOfficeguar">
                                </div>
                                <div class=" col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label>Post Code<span class="relative"><span
                                                    class="required-star">*</span></span></label>

                                    <input class="form-control  input-style err_input_empty cl_grpcod" type="text"
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_pcode:""}}"
                                           name="postcodeguar">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 5px;">
                                <div class=" col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                    <label>Division <span class="relative"><span
                                                    class="required-star">*</span></span></label>


                                    <select id="guar_bd_div_id"
                                            class="form-control  input-style err_input_empty cl_grdiv"
                                            size="1"
                                            name="guar_bd_div">
                                        <option selected value="">Select Division</option>
                                        @forelse($bd_div as $bd_divisions)
                                            <option value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>
                                        @empty
                                            <option>No Data Found</option>
                                        @endforelse
                                        @forelse($bd_div as $bd_divisions)
                                            @if(!empty($emp_his_qurantr_data[0]->guarantor_div))
                                                <option data-divnam="{{$bd_divisions->div_name}}"
                                                        {{ $emp_his_qurantr_data[0]->guarantor_div==$bd_divisions->div_id  ? 'selected="selected"' : '' }} value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>
                                            @else
                                                <option data-divnam="{{$bd_divisions->div_name}}"
                                                        value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>
                                            @endif
                                        @empty
                                            <option>No Data Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                                    <input type="hidden" id="guar_dis_sel_id"
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_dist:''}}">
                                    <label>District <span class="relative"><span
                                                    class="required-star">*</span></span></label>
                                    <select id="guar_bd_dis_id"
                                            class="form-control  input-style err_input_empty cl_grdis"
                                            size="1"
                                            name="guar_bd_dis">
                                        @if(!empty($emp_his_qurantr_data[0]->guarantor_div))
                                            <option data-divnam="{{$bd_divisions->div_name}}"
                                                    {{ $emp_his_qurantr_data[0]->guarantor_div==$bd_divisions->div_id  ? 'selected="selected"' : '' }} value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>
                                        @endif
                                    </select>

                                </div>
                                <div class=" col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                    <label>Country <span class="relative"><span
                                                    class="required-star">*</span></span></label>

                                    <input class="form-control  input-style err_input_empty cl_grcou" type="text"
                                           readonly
                                           value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_cuntry:"Bangladesh"}}"
                                           name="guarCountry">
                                </div>
                            </div>
                            <div class="row" style="margin: 18px 2px 0 2px;">
                                <div class="panel panel-success" style="border: 1px solid green;">
                                    <div style="padding: 10px;color: #337ab7;font-weight: bold;">Organization Details
                                    </div>
                                    <div class="panel-body">
                                        <div class="row" style="margin-bottom: 5px;">
                                            <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label>Organization name <span class="relative"><span
                                                                class="required-star"></span></span></label>
                                                <input class="form-control  input-style" type="text"
                                                       value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_orgname:""}}"
                                                       name="grntroname">
                                            </div>
                                            <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label>Designation <span class="relative"><span
                                                                class="required-star"></span></span></label>
                                                <input class="form-control  input-style" type="text"
                                                       value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_desig:""}}"
                                                       name="grntrdesig">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <label>Organization Address<span class="relative"><span
                                                                class="required-star"></span></span></label>

                                                <input class="form-control  input-style err_input_empty" type="text"
                                                       value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_orgaddr:""}}"
                                                       name="grntroaddr">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label>Email<span class="relative"><span
                                                                class="required-star"></span></span></label>
                                                <input type="email" placeholder=""
                                                       class="form-control " id="phonenoguarid"
                                                       value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_email:""}}"
                                                       name="grntremail">
                                                <span class="help-inline">Ex. x@gmail.com</span>
                                            </div>
                                            <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label>Contact Number<span class="relative"><span
                                                                class="required-star">*</span></span></label>

                                                <input class="form-control  input-style err_input_empty cl_grcno"
                                                       type="text"
                                                       maxlength="11"
                                                       value="{{ count($emp_his_qurantr_data)>0 ?$emp_his_qurantr_data[0]->guarantor_cno:""}}"
                                                       name="grntrcno">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                @endif
                {{--distribution part end--}}
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Reference Details
                        </legend>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">
                                        References 01 *
                                    </legend>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Name <span class="relative"><span
                                                            class="required-star">*</span></span></label>
                                            <input class="form-control input-style err_input_empty" type="text"
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_nam:""}}"
                                                   name="ref_one_name">
                                        </div>
                                        <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Designation <span class="relative"><span
                                                            class="required-star"></span></span></label>
                                            <input class="form-control input-style err_input_empty" type="text"
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_desig:""}}"
                                                   id="countryPermaid" name="ref_one_desig">

                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Phone Number <span class="relative"><span
                                                            class="required-star">*</span></span></label>
                                            <input type="text" placeholder=""
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_mob_no:""}}"
                                                   class="form-control err_input_empty" name="ref_one_phn_number"
                                                   maxlength="11">
                                            <span class="help-inline">Ex. 01709874394</span>
                                        </div>
                                        <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Email <span class="relative"><span
                                                            class="required-star"></span></span></label>
                                            <input class="form-control input-style" type="text"
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_email:""}}"
                                                   name="ref_one_mail">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Organization/Address <span class="relative"><span
                                                            class="required-star">*</span></span></label>
                                            <textarea class="form-control input-style err_input_empty"
                                                      name="ref_one_addr">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_one_addr:"" }}</textarea>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">
                                        References 02 *
                                    </legend>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Name <span class="relative"><span
                                                            class="required-star">*</span></span></label>
                                            <input class="form-control input-style err_input_empty" type="text"
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_nam:""}}"
                                                   name="ref_two_name">
                                        </div>
                                        <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Designation <span class="relative"><span
                                                            class="required-star"></span></span></label>
                                            <input class="form-control input-style err_input_empty" type="text"
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_desig:""}}"
                                                   name="ref_two_desig">
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Phone Number <span class="relative"><span
                                                            class="required-star">*</span></span></label>
                                            <input type="text" placeholder=""
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_mob_no:""}}"
                                                   class="form-control err_input_empty" name="ref_two_phn_number"
                                                   maxlength="11">
                                            <span class="help-inline">Ex. 01709874394</span>

                                        </div>
                                        <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Email <span class="relative"><span
                                                            class="required-star"></span></span></label>
                                            <input class="form-control input-style" type="text"
                                                   value="{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_email:""}}"
                                                   name="ref_two_mail">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                            <label>Organization/Address <span class="relative"><span
                                                            class="required-star">*</span></span></label>
                                            <textarea class="form-control input-style err_input_empty"
                                                      name="ref_two_addr">{{ count($emp_his_ref_data)>0 ?$emp_his_ref_data[0]->ref_two_addr:""}}</textarea>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row" id="page_four_error" style="display: none">
                <div class="alert alert-warning">
                    <p>
                        <b>
                            <i class="fa fa-warning"></i>
                            Please fill required fields marked red!
                        </b>
                    </p>
                </div>
            </div>
            <button style="display:none" class="btn btn-success pull-right pagefour_btn" type="submit">Finish!</button>
            {{--            <button class="btn btn-primary nextBtn pagefour_btn" type="button">Save & Print</button>--}}
            <span class="pull-right">
                <button class="btn btn-primary btn-sm nextBtn pagefour_btn" type="button">Save Temporarily</button>

                 <button type="submit" id="page_final_preview" formaction="{{url('ehf/emp_final_pdfform_preview_hr')}}" class="btn btn-info btn-sm" >
                    Preview</button>

              <button type="submit" id="bpf_pdf"  formaction="{{url('ehf/emp_final_pdfform_hr')}}"  class="btn btn-success btn-sm">
                        <i class="fa fa-file"></i> <b>Download PDF</b></button>

                <button class="btn btn-success btn-sm nextBtn pagefour_btn_submit" type="button">Submit</button>
            </span>
        </div>
    </form>

    {{--    <form class="form-horizontal" method="post" action="{{url('ehf/emp_final_pdfform_preview')}}">--}}
    {{--        {{csrf_field()}}--}}
    {{--        <button class="btn btn-success page_final_preview pull-right" type="submit">Preview</button>--}}
    {{--    </form>--}}

</div>
