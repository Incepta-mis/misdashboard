<div class="panel panel-primary setup-content" id="step-1">
    <div class="panel-heading">
        <h3 class="panel-title">Page1</h3>
    </div>

    <form method="post" id="frm_pageone">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">
                                    <b>Application Source(optional)</b>
                                </label>
                                <br>
                                @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                    <label>
                                        <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                               value="Incepta Website">&nbsp;Incepta Website
                                    </label>
                                    <label>
                                        <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                               value="Advertisement">&nbsp;Advertisement
                                    </label>
                                    <label>
                                        <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                               value="Reference">
                                        &nbsp;Reference
                                    </label>
                                    <label>
                                        <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                               id="other_app_src_id"
                                               value="Others">&nbsp;Others(please specify below)
                                    </label>
                                    <label>
                                        <input name="app_source_op_other" type="text" style="display:none"
                                               id="other_app_srctxt_id"
                                               value="" placeholder=" specify below">
                                    </label>
                                @else
                                    @if(key_exists('app_source',$emp_his_moreinfoid))

                                        <label for="app_source_op"><input type="checkbox" name="app_source_op"
                                                                          {{ 'Incepta Website'== $emp_his_moreinfoid[0]->app_source ? 'checked=true"' : 'false'}} class="app_sour_opclss"
                                                                          value="Incepta Website">&nbsp;Incepta Website
                                        </label>
                                        <label>
                                            <input type="checkbox" name="app_source_op"
                                                   {{ 'Advertisement'== $emp_his_moreinfoid[0]->app_source ?  'checked=true"' : 'false'}} class="app_sour_opclss"
                                                   value="Advertisement">&nbsp;Advertisement
                                        </label>
                                        <label>
                                            <input type="checkbox" name="app_source_op"
                                                   {{ 'Reference'== $emp_his_moreinfoid[0]->app_source ?  'checked=true"' : 'false'}} class="app_sour_opclss"
                                                   value="Reference">&nbsp;Reference
                                        </label>
                                        <label>
                                            <input type="checkbox" name="app_source_op"
                                                   {{ 'Others'== $emp_his_moreinfoid[0]->app_source ?  'checked=true"' : 'false'}} class="app_sour_opclss"
                                                   id="other_app_src_id"
                                                   value="Others">&nbsp;Others(please specify below)
                                        </label>
                                        <label>
                                            <input name="app_source_op_other" type="text" style="display:none"
                                                   id="other_app_srctxt_id"
                                                   value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->app_sour_other:""}}"
                                                   placeholder=" specify below">
                                        </label>
                                        <label>
                                            <input type="hidden" id="app_s_op_id"
                                                   value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->app_sour_other:""}}">
                                        </label>
                                    @else
                                        <label>
                                            <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                                   value="Incepta Website">&nbsp;Incepta Website
                                        </label>
                                        <label>
                                            <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                                   value="Advertisement">&nbsp;Advertisement
                                        </label>
                                        <label>
                                            <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                                   value="Reference">&nbsp;Reference
                                        </label>
                                        <label>
                                            <input type="checkbox" name="app_source_op" class="app_sour_opclss"
                                                   id="other_app_src_id"
                                                   value="Others">&nbsp;Others(please specify below)
                                        </label>
                                        <label>
                                            <input name="app_source_op_other" type="text" style="display:none"
                                                   id="other_app_srctxt_id"
                                                   value="" placeholder=" specify below">
                                        </label>
                            @endif
                            @endif</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Name:</label>
                            <span>{{$login_moreinfo[0]->sur_name}}</span>
                            <input type="hidden" id="emp_full_nam_id" readonly name="emp_full_nam"
                                   value="{{$login_moreinfo[0]->sur_name}}"/>
                        </div>
                        <div class="col-md-4">
                            <label>Empl Code:</label>
                            <span>{{$login_moreinfo[0]->emp_id}}</span>
                            <input type="hidden" id="emp_code_id" name="emp_code_nam" readonly
                                   value="{{$login_moreinfo[0]->emp_id}}"/>
                        </div>
                        <div class="col-md-4">
                            <label>Designation: </label>
                            <span>{{$login_moreinfo[0]->desig_name}}</span>
                            <input type="hidden" id="emp_desig_nam_id" readonly name="emp_desig_nam"
                                   value="{{$login_moreinfo[0]->desig_name}}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Department:</label>
                            <span>{{$login_moreinfo[0]->emp_dept_name}}</span>
                            <input type="hidden" class="form-control" id="emp_dept_nam_id" readonly
                                   name="emp_dept_nam" value="{{$login_moreinfo[0]->emp_dept_name}}"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" style="padding-right: 0px;">
                            <label>Nationality*:</label>
                            {{--<input type="text" name="emp_nationality" class="form-control"--}}
                            {{--value="Bangladeshi"/>--}}

                            <select id="emp_nationality_id" name="emp_nationality_type"
                                    class="err_input_empty form-control" style=" padding: 5px 2px;font-size: 13px;">
                                <option value="" disabled>Select</option>
                                @if (!empty($emp_his_infoid[0]->nationality))
                                    <option {{ ( $emp_his_infoid[0]->nationality == 'Bangladeshi') ? 'selected' : '' }} value="Bangladeshi">
                                        Bangladeshi
                                    </option>
                                    <option {{ ( $emp_his_infoid[0]->nationality != 'Bangladeshi') ? 'selected' : '' }} value="Others">
                                        Others
                                    </option>
                                @else
                                    <option value="Bangladeshi">Bangladeshi</option>
                                    <option value="Others">Others</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2" style="padding-left: 0px;">
                            <label>Name</label>
                            <input id="emp_nationality_id_nam" name="emp_nationality" type="text"
                                   style="padding: 5px 2px;font-size: 13px;" placeholder=" name "
                                   value="{{key_exists('nationality',$emp_his_infoid) > 0 ? $emp_his_infoid[0]->nationality : 'Bangladeshi'}}"
                                   class="err_input_empty form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Smart ID/ NID Card:</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <div class="input-group">
                                    <select name="nid_type" id="nid_type" class="form-control " style="width: 40%;">
                                        <option value="SID" selected>Smart ID</option>
                                        <option value="NID">NID Card</option>
                                    </select>
                                    <input type="text" name="emp_nid_no" class="form-control emp_nid"
                                           placeholder="Enter NID No" maxlength="10" style="width: 60%;"/>
                                </div>
                            @else
                                <div class="input-group">
                                    <select name="nid_type" id="nid_type" class="form-control" style="width: 40%;">
                                        <option value="SID" {{ ( $emp_his_moreinfoid[0]->nid_type == 'SID') ? 'selected' : '' }}>
                                            Smart ID
                                        </option>
                                        <option value="NID" {{ ( $emp_his_moreinfoid[0]->nid_type == 'NID') ? 'selected' : '' }}>
                                            NID Card
                                        </option>
                                    </select>
                                    <input type="text" name="emp_nid_no" class="form-control emp_nid"
                                           value="{{ count($emp_his_moreinfoid[0]->nid)>0 ?$emp_his_moreinfoid[0]->nid:""}}"
                                           placeholder="Enter NID No"
                                           {{ ( $emp_his_moreinfoid[0]->nid_type == 'SID') ? 'maxlength=10' : 'maxlength=17' }}
                                           style="width: 60%;"/>
                                </div>
                            @endif
                            <div class="text-danger text-center" id="nid_err"
                                 style="display: none;background-color: #FAEBD7;font-weight: bold;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Date of birth(S.S.C)*:</label>

                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker1">
                                    @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                        <input type="text" name="date_birth_ssc" class="err_input_empty form-control "
                                               id="date_birth_ssc_id">
                                    @else
                                        <input type="text" name="date_birth_ssc" class="err_input_empty form-control "
                                               value="{{ count($emp_his_moreinfoid[0]->birt_dt_ssc)>0 ?\Carbon\Carbon::parse($emp_his_moreinfoid[0]->birt_dt_ssc)->format('d/m/Y'):""}}"
                                               id="date_birth_ssc_id">

                                    @endif
                                    <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>Date of birth(Original): <input id="bir_ori_same_ssc"
                                                                   type="checkbox"><span
                                        style="font-size:11px;color:green">Same as S.S.C</span></label>
                            <div class="form-group">
                                <div class="input-group date" id="datetimepicker2">
                                    @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                        <input type="text" name="date_birth_ori" class="form-control"
                                               id="date_birth_ori_id">
                                    @else
                                        <input type="text" name="date_birth_ori" class="form-control"
                                               value="{{ count($emp_his_moreinfoid[0]->birth_dt_ori)>0 ?\Carbon\Carbon::parse($emp_his_moreinfoid[0]->birth_dt_ori)->format('d/m/Y'):""}}"
                                               id="date_birth_ori_id">
                                    @endif
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Place of birth(District): </label>
                            <select class="err_input_empty form-control input-style" size="1" id="emp_bir_dis_id"
                                    name="emp_bir_dis">
                                <option value="" disabled>Select one</option>
                                @forelse($bd_dis as $bd_districts)
                                    @if (!count($emp_his_infoid)>0)
                                        <option value="{{$bd_districts->dis_id}}">{{$bd_districts->dis_name}}</option>
                                    @else
                                        <option {{$bd_districts->dis_id == $emp_his_infoid[0]->birth_place ? 'selected="selected"' : ''}} value="{{$bd_districts->dis_id}}">{{$bd_districts->dis_name}}</option>
                                    @endif
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Country of birth*: </label>
                            <select class="err_input_empty form-control input-style" size="1"
                                    id="emp_all_country_id"
                                    name="emp_bir_country">
                                <option value="" disabled>Select one</option>
                                @forelse($all_country as $all_country)
                                    @if (count($emp_his_moreinfoid)>0)
                                        <option {{$all_country->country_id == $emp_his_moreinfoid[0]->birth_place_cuntry ? 'selected="selected"' : '' }} value="{{$all_country->country_id}}">{{$all_country->country_name}}</option>
                                    @else
                                        <option value="{{$all_country->country_id}}">{{$all_country->country_name}}</option>
                                    @endif
                                @empty
                                    <option>No Data Found</option>
                                @endforelse

                            </select>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-4">
                            <label>Mobile No(Official): </label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" class="form-control" name="emp_mob_official"
                                       placeholder="Enter desig name" maxlength="11"/>
                            @else
                                <input type="text"
                                       value="{{ count($emp_his_moreinfoid[0]->emp_mob_no_offi)>0 ?$emp_his_moreinfoid[0]->emp_mob_no_offi:""}}"
                                       class="form-control" name="emp_mob_official"
                                       placeholder="Enter Mobile No" maxlength="11"/>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label>Mobile No(Personal)*: </label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" class="form-control err_input_empty" name="emp_mob_personal"
                                       placeholder="Enter Mobile No" maxlength="11"/>
                            @else
                                <input type="text"
                                       value="{{ count($emp_his_moreinfoid[0]->emp_mob_no_per)>0 ?$emp_his_moreinfoid[0]->emp_mob_no_per:""}}"
                                       class="form-control err_input_empty" name="emp_mob_personal"
                                       placeholder="Enter Mobile No" maxlength="11"/>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label>Email(Official): </label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="email" class="form-control" name="emp_mail_official"
                                       placeholder="Enter Email "/>
                            @else
                                <input type="email" class="form-control" name="emp_mail_official"
                                       value="{{ count($emp_his_moreinfoid[0]->emp_mail_offi)>0 ?$emp_his_moreinfoid[0]->emp_mail_offi:""}}"
                                       placeholder="Enter Email"/>
                            @endif
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">

                        <div class="col-md-4">
                            <label>Email(Personal): </label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input class="form-control" id="emp_mail_personalid" type="text"
                                       name="emp_mail_personal" placeholder="Enter Email(Personal)"/>
                            @else
                                <input class="form-control" id="emp_mail_personalid" type="text"
                                       name="emp_mail_personal"
                                       value="{{ count($emp_his_moreinfoid[0]->emp_mail_per)>0 ?$emp_his_moreinfoid[0]->emp_mail_per:""}}"
                                       placeholder="Enter Email(Personal)"/>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label>Religion*: </label>
                            <select class="form-control input-style err_input_empty" size="1" id="religion_id"
                                    name="emp_religion">
                                <option value="" disabled>Select one</option>
                                @if (!empty($emp_his_infoid[0]->religion))
                                    <option {{ ( $emp_his_infoid[0]->religion == 'Islam') ? 'selected' : '' }} value="Islam">
                                        Islam
                                    </option>
                                    <option {{ ( $emp_his_infoid[0]->religion == 'Hinduism') ? 'selected' : '' }} value="Hinduism">
                                        Hinduism
                                    </option>
                                    <option {{ ( $emp_his_infoid[0]->religion == 'Christianity') ? 'selected' : '' }} value="Christianity">
                                        Christianity
                                    </option>
                                    <option {{ ( $emp_his_infoid[0]->religion == 'Buddhism') ? 'selected' : '' }} value="Buddhism">
                                        Buddhism
                                    </option>
                                    <option {{ ( $emp_his_infoid[0]->religion == 'Others') ? 'selected' : '' }} value="Others">
                                        Others
                                    </option>
                                @else
                                    <option value="Islam">Islam</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Others">Others</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Designation (at the time of joining)*:</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" name="desig_at_time_join" class="err_input_empty form-control"
                                       placeholder="Enter designation name"/>
                            @else
                                <input type="text" name="desig_at_time_join" class="err_input_empty form-control"
                                       value="{{ count($emp_his_moreinfoid[0]->desig_first_time)>0 ?$emp_his_moreinfoid[0]->desig_first_time:""}}"
                                       placeholder="Enter designation name"/>
                            @endif
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-4">
                            <label>Marital Status*: </label>
                            <select class="err_input_empty form-control" id="emp_marital_id" size="1"
                                    name="mari_status">
                                <option value="" disabled>Select one</option>
                                @if (!empty($emp_his_infoid[0]->maritial_status))
                                    <option {{ 'Single'== $emp_his_infoid[0]->maritial_status ? 'selected="selected"' : '' }} value="Single">
                                        Single
                                    </option>
                                    <option {{ 'Married'== $emp_his_infoid[0]->maritial_status ? 'selected="selected"' : '' }} value="Married">
                                        Married
                                    </option>
                                    <option {{ 'Divorced'== $emp_his_infoid[0]->maritial_status ? 'selected="selected"' : '' }} value="Divorced">
                                        Divorced
                                    </option>
                                    <option {{ 'Widowed'== $emp_his_infoid[0]->maritial_status ? 'selected="selected"' : '' }} value="Widowed">
                                        Widowed
                                    </option>
                                    <option {{ 'Separated'== $emp_his_infoid[0]->maritial_status ? 'selected="selected"' : '' }} value="Separated">
                                        Separated
                                    </option>
                                @else
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Separated">Separated</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4" id="emp_mari_datediv_id" style="visibility: hidden">
                            <label class="emp_mari_date_id">Marriage Date: </label>
                            <div class="emp_mari_date_id" class="form-group">
                                <div class="input-group date" id="datetimepicker_maridate">
                                    @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                        <input type="text" class="form-control emp_mari_date_id" name="emp_mari_date">
                                    @else
                                        <input value="{{ count($emp_his_moreinfoid[0]->marriage_date)>0 ?\Carbon\Carbon::parse($emp_his_moreinfoid[0]->marriage_date)->format('d/m/Y'):""}}"
                                               type="text" class="form-control emp_mari_date_id" name="emp_mari_date">

                                    @endif
                                    <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" id="emp_mari_chilnodiv_id" style="visibility: hidden">
                            <label class="emp_mari_childnodiv_id">Number of Child:</label>
                            <div id="spinner3">
                                <div class="input-group input-small">
                                    @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                        <input type="text" name="no_of_child" class="spinner-input form-control"
                                               maxlength="3" readonly>
                                    @else
                                        <input value="{{ count($emp_his_moreinfoid[0]->no_of_child)>0 ?$emp_his_moreinfoid[0]->no_of_child:""}}"
                                               type="text" name="no_of_child" class="spinner-input form-control"
                                               maxlength="3" readonly>
                                    @endif
                                    <div class="spinner-buttons input-group-btn btn-group-vertical">
                                        <button type="button"
                                                class="btn spinner-up btn-xs btn-default">
                                            <i class="fa fa-angle-up"></i>
                                        </button>
                                        <button type="button"
                                                class="btn spinner-down btn-xs btn-default">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group last">
                        <div class="fileupload fileupload-new text-center" data-provides="fileupload">
                                <span class="propic_preview">
                                    @if(empty($emp_his_moreinfoid[0]->emp_img))
                                        <img id="img_prv"
                                             style="max-width: 150px; max-height: 150px; line-height: 20px;"
                                             class="img img-thumbnail"
                                             src="{{url('public/site_resource/images/user.png')}}">
                                    @else
                                        <img id="img_prv"
                                             style="max-width: 150px; max-height: 150px; line-height: 20px;"
                                             class="img img-thumbnail"
                                             src="{{url('public/emp_history_img/'.$emp_his_moreinfoid[0]->emp_img)}}"
                                             onError="this.onerror=null;this.src='{{url('public/site_resource/images/user.png')}}';"
                                        >
                                    @endif
                                </span>
                            <span id="message_ta"></span>
                            <div>
                                <div class="form-group">
                                    <input type="file" id="file_img_upid" name="emp_img" class="form-control"
                                           style="height: 21px;padding-top: 0px;">
                                </div>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div id="presentAddress" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 subDiv">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Present address *
                        </legend>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Care of <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <input class="form-control input-style" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_careof:""}}"
                                       id="careOfPresentid" name="careOfPresent">

                                <input type="hidden" id="present_url_id" value="{{url('ehf/getWholeDistrict')}}">

                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Country <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <input class="form-control input-style" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_country:"Bangladesh"}}"
                                       id="countryPresentid" name="countryPresent">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>1st Address Line <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <textarea class="form-control input-style err_input_empty"
                                          id="villageTownPre1stid"
                                          name="villageTownPre1st">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_addr_1st:""}}</textarea>
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>2nd Address Line <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <textarea class="form-control input-style"
                                          id="villageTownPre2ndid"
                                          name="villageTownPre2nd">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_addr_2nd:""}}</textarea>
                            </div>
                        </div>
                        <div class="row row-present">
                            <div class="col-present-div col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Division <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <select id="pread_bd_div_id" class="form-control input-style err_input_empty"
                                        size="1"
                                        name="pread_bd_div">
                                    <option selected disabled>Select Division</option>
                                    @forelse($bd_div as $bd_divisions)

                                        @if(!empty($emp_his_addr[0]->pre_div))
                                            <option data-divnam="{{$bd_divisions->div_name}}"
                                                    {{ $emp_his_addr[0]->pre_div==$bd_divisions->div_id  ? 'selected="selected"' : '' }} value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>


                                        @else
                                            <option data-divnam="{{$bd_divisions->div_name}}"
                                                    value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>


                                        @endif

                                    @empty
                                        <option>No Data Found</option>
                                    @endforelse

                                </select>
                            </div>
                            <div class="col-present-dis col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <input type="hidden" id="present_dis_sel_id"
                                       value="{{count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_dis:''}}">
                                <input type="hidden" id="present_dis_sel_id"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_dis:""}}">
                                <label>District <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <select id="pread_bd_dis_id" class="form-control input-style err_input_empty"
                                        size="1"
                                        name="pread_bd_dis">
                                    <option value="-1" selected>Select District</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Police Station <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="form-control input-style err_input_empty" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_police_sta:""}}"
                                       id="PoliceStaPreid" name="PoliceStaPre">
                            </div>

                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Post Office <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="form-control input-style err_input_empty" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_post_off:""}}"
                                       id="postOfficePresentid" name="postOfficePresent">
                            </div>

                        </div>
                        <div class="row ">
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Post Code <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <input class="form-control input-style err_input_empty" id="postCodePresentid"
                                       type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_post_code:""}}"
                                       name="postCodePresent">
                            </div>

                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Phone Number <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input type="text" placeholder="" maxlength="11"
                                       class="form-control err_input_empty" id="phonenoPresentid"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->pre_phne:""}}"
                                       name="phonenoPresent">
                                <span class="help-inline">Ex. 01709874394</span>


                            </div>

                        </div>
                    </fieldset>
                </div>

                {{-------------------------------permanent address--}---------------------------------------------------------}}
                {{--------------------------------------------------------------------------------------------------------------}}
                {{------------------------------------}}
                <div id="permanentAddress" class="col-xs-12 col-sm-6 col-md-6 col-lg-6 subDiv">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">Permanent address *
                            @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')

                                    <span style="color:#fd6363;text-transform: none;font-size: 13px;">For Update ,Contact with HR Dept.</span>
                                @endif
                            @else
                                <input type="checkbox" id="per_add_same_preid">
                                <span>( Same as Present address )</span>
                            @endif
                            <input type="hidden" id="hr_data_res_id"
                                   value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->emp_final_sub:""}}">

                        </legend>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Care of <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <input class="hr_restrict form-control input-style perform" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_careof:""}}"
                                       id="careOfPermaid" name="careOfPerma">
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Country <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <input class="hr_restrict form-control input-style perform" type="text"

                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_country:"Bangladesh"}}"
                                       value="Bangladesh"
                                       id="countryPermaid" name="countryPerma">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>1st Address Line <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <textarea class="hr_restrict form-control err_input_empty input-style perform"
                                          id="villageTownPerma1stid"
                                          name="villageTownPerma1st">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_addr_1st:""}}</textarea>
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>2nd Address Line <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <textarea class="hr_restrict form-control input-style perform"
                                          id="villageTownPerma2ndid"
                                          name="villageTownPer2nd">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_addr_2nd:""}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <input type="hidden" id="per_dis_sel_id"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_dis:''}}">

                                <label>Division <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <select id="pd_bd_div_id"
                                        class="hr_restrict_dw form-control err_input_empty input-style"
                                        size="1"
                                        name="pd_bd_div">
                                    <option selected value="">Select Division</option>
                                    @forelse($bd_div as $bd_divisions)

                                        @if(!empty($emp_his_addr[0]->per_div))
                                            <option data-divnam="{{$bd_divisions->div_name}}"
                                                    {{ $emp_his_addr[0]->per_div==$bd_divisions->div_id  ? 'selected="selected"' : '' }} value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>


                                        @else
                                            <option data-divnam="{{$bd_divisions->div_name}}"
                                                    value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>


                                        @endif


                                    @empty
                                        <option>No Data Found</option>
                                    @endforelse


                                </select>
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>District <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <select id="pd_bd_dis_id"
                                        class="hr_restrict_dw form-control err_input_empty input-style"
                                        size="1"
                                        name="pd_bd_dis">
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Police Station <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="hr_restrict form-control err_input_empty input-style perform"
                                       type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_police_sta:""}}"
                                       id="PoliceStaPermaid"
                                       name="PoliceStaPerma">
                            </div>

                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Post Office <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="hr_restrict form-control input-style perform err_input_empty"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_post_off:""}}"
                                       id="postOfficePermaid" type="text"
                                       name="postOfficePerma">
                            </div>

                        </div>
                        <div class="row ">
                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Post Code <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <input class="hr_restrict form-control input-style perform err_input_empty"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_post_code:""}}"
                                       id="postCodePermaid" type="text"
                                       name="postCodePerma">
                            </div>

                            <div class=" col-xs-12 col-sm-5 col-md-6 col-lg-6">
                                <label>Phone Number <span class="relative"><span
                                                class="required-star">*</span></span></label>


                                <input type="text" placeholder=""
                                       class="hr_restrict form-control perform err_input_empty" id="phonenoPermaid"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->per_phne:""}}"
                                       name="phonenoPerma" maxlength="11">
                                <span class="help-inline">Ex. 01709874394</span>

                            </div>

                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border">
                            Emergency Address * (Name & Full address of person to be notified in case of
                            emergency)
                        </legend>
                        <div class="row">
                            <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
                                <label>Care of <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <input class="form-control input-style" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_careof:""}}"
                                       name="careOfemer">

                            </div>
                            <div class="col-xs-12 col-sm-5 col-md-2 col-lg-2">
                                <label>Relation <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <input class="form-control input-style" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_relation:""}}"
                                       name="emer_relation">

                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                                <label>1st Address Line <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <textarea class="form-control input-style err_input_empty"
                                          rows="1"
                                          name="villageTownemer1st">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_addr_1st:""}}</textarea>

                            </div>
                            <div class="col-xs-12 col-sm-7 col-md-4 col-lg-4">
                                <label>2nd Address Line <span class="relative"><span
                                                class="required-star"></span></span></label>
                                <textarea class="form-control input-style"
                                          rows="1"
                                          name="villageTownemer2nd">{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_addr_2nd:""}}</textarea>

                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                <input type="hidden" id="emer_dis_sel_id"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_dis:''}}">

                                <label>Division <span class="relative"><span
                                                class="required-star">*</span></span></label>


                                <select id="emer_bd_div_id" class="form-control input-style err_input_empty"
                                        size="1"
                                        name="emer_bd_div">
                                    <option selected value="" disabled>Select Division</option>


                                    @forelse($bd_div as $bd_divisions)

                                        @if(!empty($emp_his_addr[0]->emer_div))
                                            <option data-divnam="{{$bd_divisions->div_name}}"
                                                    {{ $emp_his_addr[0]->emer_div==$bd_divisions->div_id  ? 'selected="selected"' : '' }} value="{{$bd_divisions->div_id}}">{{$bd_divisions->div_name}}</option>


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
                                <label>District <span class="relative"><span
                                                class="required-star">*</span></span></label>
                                <select id="emer_bd_dis_id" class="form-control input-style err_input_empty"
                                        size="1"
                                        name="emer_bd_dis">

                                </select>

                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                <label>Country <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="form-control input-style" type="text" readonly
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_country:"Bangladesh"}}"
                                       name="emerCountry">


                            </div>


                        </div>
                        <div class="row">
                            <div class=" col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                <label>Police Station <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="form-control input-style err_input_empty" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_police_sta:""}}"
                                       name="postStaEmer">
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-4 col-lg-4">
                                <label>Post Office <span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="form-control input-style err_input_empty" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_post_off:""}}"
                                       name="postOfficeEmer">
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-2 col-lg-2">
                                <label>Post Code<span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input class="form-control input-style err_input_empty" type="text"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_post_code:""}}"
                                       name="postcodeEmer" id="postCodeEmr">
                            </div>
                            <div class=" col-xs-12 col-sm-5 col-md-2 col-lg-2">
                                <label>Phone Number<span class="relative"><span
                                                class="required-star">*</span></span></label>

                                <input type="text" placeholder="e.g: 01700000000"
                                       class="form-control err_input_empty" id="phonenoEmerid"
                                       value="{{ count($emp_his_addr)>0 ?$emp_his_addr[0]->emer_phne:""}}"
                                       name="phonenoEmer" maxlength="11">

                            </div>

                        </div>

                    </fieldset>
                </div>
            </div>
            <div class="row" id="page_one_error" style="display: none">
                <div class="alert alert-warning">
                    <p><b><i class="fa fa-warning"></i> Please fill required fields marked red!</b></p>
                </div>
            </div>
            <button class="btn btn-primary btn-sm nextBtn pageone_btn pull-right" type="button">Save & Continue</button>
        </div>

    </form>
</div>
