<div class="panel panel-primary setup-content" id="step-2">
    <div class="panel-heading">
        <h3 class="panel-title">Page 2</h3>
    </div>
    <form method="post" id="frm_pagetwo">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Passport No(if any):</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" name="emp_passport_no" class="form-control"
                                       placeholder="Enter Passport No"/>
                            @else
                                <input type="text" name="emp_passport_no" class="form-control"
                                       value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->emp_passport_no:""}}"
                                       placeholder="Enter Passport No"/>
                            @endif

                        </div>
                        <div class="col-md-3">

                            <label>Driving License(if any):</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" name="emp_driving_license" class="form-control"
                                       placeholder="Enter Driving License"/>
                            @else
                                <input type="text" name="emp_driving_license" class="form-control"
                                       value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->drive_license:""}}"
                                       placeholder="Enter Driving License"/>
                            @endif

                        </div>
                        <div class="col-md-3">
                            <label>TIN No(if any):</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" name="emp_tin_no" class="form-control emp_tin_noclss"
                                       placeholder="Enter TIN No" maxlength="12"/>
                            @else
                                <input type="text" name="emp_tin_no" class="form-control emp_tin_noclss"
                                       value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->tin_no:""}}"
                                       placeholder="Enter TIN No" maxlength="12"/>
                            @endif
                            <div class="text-danger text-center" id="tin_err"
                                 style="display: none;background-color: #FAEBD7;font-weight: bold;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Gender*:</label>

                            <input type="hidden"
                                   value="{{key_exists('gender',$emp_his_infoid) ? $emp_his_infoid[0]->gender:''}}">
                            <input type="hidden"
                                   value="{{ key_exists('gender',$emp_his_infoid) ?$emp_his_infoid[0]->gender:''}}">


                            <select class="err_input_empty form-control" id="emp_gender_id" size="1"
                                    name="emp_gender">
                                <option value="" selected>Select one</option>
                                @if(empty($emp_his_infoid) || count($emp_his_infoid)==0)
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>

                                @else
                                    @if (!empty($emp_his_infoid[0]->gender))
                                        <option {{ 'Female'== $emp_his_infoid[0]->gender ? 'selected="selected"' : '' }} value="Female">
                                            Female
                                        </option>
                                        <option {{ 'Male'== $emp_his_infoid[0]->gender ? 'selected="selected"' : '' }} value="Male">
                                            Male
                                        </option>
                                        <option {{ 'Other'== $emp_his_infoid[0]->gender ? 'selected="selected"' : '' }} value="Other">
                                            Other
                                        </option>
                                    @else
                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                        <option value="Other">Other</option>
                                    @endif

                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            <label>Bank A/C number(personal):</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" name="bank_ac_no" class="form-control bank_ac_no_clss"
                                       placeholder="Enter Bank A/C number(personal)"/>
                            @else
                                <input type="text"
                                       value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->bank_ac_no:""}}"
                                       name="bank_ac_no" class="form-control bank_ac_no_clss"
                                       placeholder="Enter Bank A/C number(personal)"/>
                            @endif

                        </div>
                        <div class="col-md-3">
                            <label>Bank name(personal):</label>
                            @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                <input type="text" name="bank_name" class="form-control"
                                       placeholder="Enter Bank name(personal)"/>
                            @else
                                <input value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->bank_name:""}}"
                                       type="text" name="bank_name" class="form-control"
                                       placeholder="Enter Bank name(personal)"/>
                            @endif

                        </div>

                        <div class="col-md-3">
                            <label>Height:</label>

                            <div class="input-group">
                                <span class="input-group-addon">ft</span>
                                @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                    <input data-mask='9' name="emp_height_ft" type="text" class="form-control">
                                @else
                                    <input data-mask='9' name="emp_height_ft" type="text"
                                           value="{{ count($emp_his_moreinfoid)>0 ? explode(' ',$emp_his_moreinfoid[0]->emp_height)[0]:""}}"
                                           class="form-control">
                                @endif


                                <span class="input-group-addon ">inch</span>
                                @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                    <input name="emp_height_inch" type="text" class="form-control">

                                @else
                                    <input name="emp_height_inch" type="text"
                                           value="{{ count($emp_his_moreinfoid[0]->emp_height)>0 ?explode(' ',$emp_his_moreinfoid[0]->emp_height)[2]:""}}"
                                           class="form-control">

                                @endif

                            </div>


                        </div>
                        <div class="col-md-3">
                            <label>Blood Group:</label>

                            <select class="form-control" id="emp_blood_id" size="1"
                                    name="emp_blood">
                                <option value="">Select one</option>
                                @if (!empty($emp_his_infoid[0]->blood_group))
                                    <option {{'O+' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="O+">
                                        O+
                                    </option>
                                    <option {{'O-' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="O-">
                                        O-
                                    </option>
                                    <option {{'A+' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="A+">
                                        A+
                                    </option>
                                    <option {{'A-' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="A-">
                                        A-
                                    </option>
                                    <option {{'B+' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="B+">
                                        B+
                                    </option>
                                    <option {{'B-' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="B-">
                                        B-
                                    </option>
                                    <option {{'AB+' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="AB+">
                                        AB+
                                    </option>
                                    <option {{'AB-' == $emp_his_infoid[0]->blood_group ? 'selected="selected"' : '' }} value="AB-">
                                        AB-
                                    </option>
                                @else
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                @endif
                            </select>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">
                                    <span style="color:#337ab7"><b> Education (Start from recent)* </b></span>
                                    @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                        @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')
                                            <scan style="color:#fd6363;font-size:13px;text-transform: none;"><b> For
                                                    Update,Contact with HR (Show Original
                                                    Certificates to make updates)</b></scan>
                                        @endif
                                    @else
                                    @endif
                                </legend>
                                <div class="alert alert-danger" style="margin-bottom: 8px;display: none;"
                                     id="error_education">
                                    <p>
                                        <i class="fa fa-info-circle"></i>
                                        <span id="error_edu_text">Lorem inpsum dolar sat amet</span>
                                    </p>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered education_table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Name of Degree</th>
                                            <th>Name of Institute</th>
                                            <th>Group</th>
                                            <th>Subject/Specialization</th>
                                            <th>Board</th>
                                            <th>Passing Year</th>
                                            <th>Division/CGPA</th>
                                            <th>Marks%</th>
{{--                                            @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))--}}
{{--                                                @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')--}}

{{--                                                @endif--}}
{{--                                            @else--}}
                                                <th style="text-align: center;">
                                                    <a href="#" class="addRowEdu">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                    </a>
                                                </th>
{{--                                            @endif--}}
                                        </tr>
                                        </thead>

                                        <tbody>

                                        @forelse($emp_his_edu_old as $emp_his_edu_old)
                                            {{--//data base theke asar pore--}}
                                            <tr>
                                                <td style="display: none">
                                                    <input type="hidden" class="row_id" value="{{$loop->index}}">
                                                </td>
                                                <td class="tdDeg">
                                                    <select class="hr_restrict_dw err_input_empty form-control edu_deg_nam_clss input-style edu_deg_name"
                                                            size="1"
                                                            name="edu_deg_nam[]">
                                                        <option value="">Select</option>

                                                        @forelse($edu_all_degree as $edu_all_d)
                                                            {{--<option>ff</option>--}}

                                                            <option {{$emp_his_edu_old->edu_desig_name== $edu_all_d->deg_id? 'selected="selected"' : '' }} value="{{$edu_all_d->deg_id}}">{{$edu_all_d->degree_name}}</option>
                                                        @empty
                                                            <option value="{{$edu_all_d->deg_id}}">{{$edu_all_d->degree_name}}</option>

                                                        @endforelse

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" value="{{$emp_his_edu_old->edu_insti_name}}"
                                                           name="edu_insti_nam[]"
                                                           class="hr_restrict err_input_empty form-control edu_insti_nam">
                                                </td>
                                                <td>

                                                    <select class="hr_restrict_dw  form-control edu_grp_nam_clss input-style edu_group"
                                                            size="1" name="edu_group[]">
                                                        @forelse($edu_all_grp as $edu_all_g)


                                                            @if (count($emp_his_edu_old)>0)
                                                                @if(($emp_his_edu_old->edu_desig_name==5||$emp_his_edu_old->edu_desig_name==11||$emp_his_edu_old->edu_desig_name==12))

                                                                    @if($edu_all_g->deg_grp_pkid==1)

                                                                        <option data-test="{{$edu_all_g->deg_grp_pkid}}"
                                                                                {{$emp_his_edu_old->edu_group == $edu_all_g->grp_id? 'selected="selected"' : '' }} value="{{$edu_all_g->grp_id}}">{{$edu_all_g->grp_name}}</option>
                                                                    @endif
                                                                @else

                                                                    @if($edu_all_g->deg_grp_pkid==2)
                                                                        <option data-test="{{$edu_all_g->deg_grp_pkid}}"
                                                                                {{$emp_his_edu_old->edu_group == $edu_all_g->grp_id? 'selected="selected"' : '' }} value="{{$edu_all_g->grp_id}}">{{$edu_all_g->grp_name}}</option>

                                                                    @endif
                                                                @endif
                                                            @else

                                                            @endif

                                                        @empty
                                                            <option>No Data Found</option>
                                                        @endforelse

                                                    </select>

                                                </td>
                                                <td>
                                                    <input type="text" value="{{$emp_his_edu_old->edu_subject}}"
                                                           name="edu_subject[]"
                                                           class="hr_restrict form-control edu_subject">
                                                </td>
                                                <td>

                                                    <select class="hr_restrict_dw form-control input-style edu_board"
                                                            size="1"
                                                            name="edu_board[]">
                                                        <option value="">Select</option>

                                                        @forelse($edu_all_board as $edu_all_b)

                                                            @if (count($emp_his_edu_old)>0)
                                                                <option {{$emp_his_edu_old->edu_board == $edu_all_b->board_id? 'selected="selected"' : '' }} value="{{$edu_all_b->board_id}}">{{$edu_all_b->board_name}}</option>
                                                            @else

                                                            @endif

                                                        @empty
                                                            <option>No Data Found</option>
                                                        @endforelse

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="edu_passing_yr[]"
                                                           value="{{$emp_his_edu_old->edu_passing_yr}}"
                                                           class="hr_restrict err_input_empty form-control edu_passing_yr"
                                                           maxlength="4" size="4">
                                                </td>
                                                <td>

                                                    <select class="hr_restrict_dw err_input_empty edu_cgpa_div_clss form-control input-style edu_cgpa"
                                                            size="1"
                                                            name="edu_cgpa[]">
                                                        <option value="">Select</option>
                                                        <option {{'division' == $emp_his_edu_old->edu_div_cgpa ? 'selected="selected"' : '' }} value="division">
                                                            Division
                                                        </option>
                                                        <option {{'cgpa' == $emp_his_edu_old->edu_div_cgpa ? 'selected="selected"' : '' }} value="cgpa">
                                                            CGPA
                                                        </option>


                                                    </select>
                                                </td>
                                                <td class="div_cpga_add">

                                                    @if('division' == $emp_his_edu_old->edu_div_cgpa && ($emp_his_edu_old->edu_desig_name==5||$emp_his_edu_old->edu_desig_name==11))
                                                        <select class="hr_restrict_dw err_input_empty edu_cgpa_div_clss form-control input-style edu_marks"
                                                                size="1" name="edu_marks[]">
                                                            <option disabled selected>Select</option>

                                                            <option {{'1st_Division' == $emp_his_edu_old->edu_marks ? 'selected="selected"' : '' }} value="1st_Division">
                                                                1st Division
                                                            </option>
                                                            <option {{'2nd_Division' == $emp_his_edu_old->edu_marks ? 'selected="selected"' : '' }} value="2nd_Division">
                                                                2nd Division
                                                            </option>
                                                            <option {{'3rd_Division' == $emp_his_edu_old->edu_marks ? 'selected="selected"' : '' }} value="3rd_Division">
                                                                3rd Division
                                                            </option>

                                                        </select>
                                                    @elseif('division' == $emp_his_edu_old->edu_div_cgpa)
                                                        <select class="hr_restrict_dw err_input_empty edu_cgpa_div_clss form-control input-style edu_marks"
                                                                size="1" name="edu_marks[]">';
                                                            <option disabled selected>Select</option>

                                                            <option {{'1st_Class' == $emp_his_edu_old->edu_marks ? 'selected="selected"' : '' }} value="1st_Class">
                                                                1st Class
                                                            </option>
                                                            <option {{'2nd_Class' == $emp_his_edu_old->edu_marks ? 'selected="selected"' : '' }} value="2nd_Class">
                                                                2nd Class
                                                            </option>
                                                            <option {{'3rd_Class' == $emp_his_edu_old->edu_marks ? 'selected="selected"' : '' }} value="3rd_Class">
                                                                3rd Class
                                                            </option>

                                                        </select>
                                                    @elseif('cgpa' == $emp_his_edu_old->edu_div_cgpa)
                                                        <input type='text' name='edu_marks[]'
                                                               value="{{$emp_his_edu_old->edu_marks}}"
                                                               class='hr_restrict form-control edu_marks_clss edu_marks'>
                                                    @endif

                                                </td>

                                                @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                                    @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')

                                                    @endif
                                                @else
                                                    <td>
                                                        <a href="#" class="btn btn-danger remove_edu">
                                                            <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                    </td>
                                                @endif


                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="display: none">
                                                    <input type="hidden" class="row_id" value="0">
                                                </td>

                                                <td class="tdDeg">

                                                    <select class=" hr_restrict_dw err_input_empty form-control edu_deg_nam_clss input-style edu_deg_name"
                                                            size="1"
                                                            name="edu_deg_nam[]">
                                                        <option value="">Select</option>

                                                        @forelse($edu_all_degree as $edu_all_degree)

                                                            <option data-edupk="{{$edu_all_degree->deg_grp_id}}"
                                                                    value="{{$edu_all_degree->deg_id}}">{{$edu_all_degree->degree_name}}</option>

                                                        @empty
                                                            <option>No Data Found</option>
                                                        @endforelse

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="edu_insti_nam[]"
                                                           readonly
                                                           class="err_input_empty hr_restrict form-control edu_insti_nam">
                                                </td>
                                                <td>

                                                    <select class="err_input_empty hr_restrict_dw form-control edu_grp_nam_clss input-style edu_group"
                                                            size="1"
                                                            name="edu_group[]">

                                                    </select>

                                                </td>
                                                <td>
                                                    <input type="text" name="edu_subject[]"
                                                           class="form-control hr_restrict edu_subject"
                                                           readonly>
                                                </td>
                                                <td>

                                                    <select class="form-control hr_restrict_dw input-style edu_board"
                                                            size="1"
                                                            name="edu_board[]">
                                                        <option value="">Select</option>

                                                        @forelse($edu_all_board as $edu_all_board)
                                                            <option value="{{$edu_all_board->board_id}}">{{$edu_all_board->board_name}}</option>
                                                        @empty
                                                            <option>No Data Found</option>
                                                        @endforelse

                                                    </select>

                                                    {{--edu_all_board--}}
                                                </td>
                                                <td>
                                                    <input type="text" name="edu_passing_yr[]"
                                                           class="hr_restrict err_input_empty form-control edu_passing_yr_clss edu_passing_yr"
                                                           maxlength="4" size="4">

                                                </td>
                                                <td>
                                                    <select class="hr_restrict_dw err_input_empty edu_cgpa_div_clss form-control input-style edu_cgpa"
                                                            size="1"
                                                            name="edu_cgpa[]">
                                                        <option value="">Select</option>
                                                        <option value="division">Division</option>
                                                        <option value="cgpa">CGPA</option>
                                                    </select>
                                                </td>
                                                <td class="div_cpga_add">

                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-danger remove_edu">
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
                        <div class="col-lg-12 col-sm-12">
                            <div>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">
                                        Language Proficiency
                                    </legend>
                                    {{--                                <label for="">--}}
                                    {{--                                    <span style="color:#337ab7"><b> Language Proficiency </b></span>--}}
                                    {{--                                </label>--}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed" id="lang-tab"
                                               style="width: 50%;">
                                            <thead>
                                            <tr>
                                                <th>Language</th>
                                                <th>Level</th>
                                                <th style="text-align: center;">
                                                    <a href="#" id="addNewLang">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                    </a>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($emp_his_language) > 0)
                                                @foreach($emp_his_language as $lang)
                                                    <tr>
                                                        <td>
                                                            @if($lang->lang !== 'Bangla' && $lang->lang !== 'Hindi'
                                                                && $lang->lang !== 'English'  && $lang->lang !== 'Others')
                                                                <input type='text'
                                                                       name='langu[]'
                                                                       value="{{$lang->lang}}"
                                                                       placeholder='Enter Language'
                                                                       class='form-control input-style langu'/>
                                                            @else
                                                            <select name="langu[]"
                                                                    class="form-control input-style langu"
                                                                    style="font-weight: normal;">
                                                                <option value="Bangla"
                                                                        @if($lang->lang === 'Bangla') selected @endif>
                                                                    Bangla
                                                                </option>
                                                                <option value="Hindi"
                                                                        @if($lang->lang === 'Hindi') selected @endif>
                                                                    Hindi
                                                                </option>
                                                                <option value="English"
                                                                        @if($lang->lang === 'English') selected @endif>
                                                                    English
                                                                </option>
                                                                <option value="Others"
                                                                        @if($lang->lang === 'Others') selected @endif>
                                                                    Others
                                                                </option>
                                                            </select>
                                                            @endif
                                                        </td>
                                                        <td>
                                                                <select name="language_level[]"
                                                                        class="form-control input-style language_level"
                                                                        style="font-weight: normal;">
                                                                    <option value="Native"
                                                                            @if($lang->lang_level === 'Native') selected @endif>
                                                                        Native
                                                                    </option>
                                                                    <option value="Fluent"
                                                                            @if($lang->lang_level === 'Fluent') selected @endif>
                                                                        Fluent
                                                                    </option>
                                                                    <option value="Intermediate"
                                                                            @if($lang->lang_level === 'Intermediate') selected @endif>
                                                                        Intermediate
                                                                    </option>
                                                                    <option value="Basic"
                                                                            @if($lang->lang_level === 'Basic') selected @endif>
                                                                        Basic
                                                                    </option>
                                                                </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn btn-danger removeLang">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <select name="langu[]" class="form-control input-style langu"
                                                                style="font-weight: normal;">
                                                            <option value="Bangla">Bangla</option>
                                                            <option value="Hindi">Hindi</option>
                                                            <option value="English">English</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="language_level[]"
                                                                class="form-control input-style language_level"
                                                                style="font-weight: normal;">
                                                            <option value="Native">Native</option>
                                                            <option value="Fluent">Fluent</option>
                                                            <option value="Intermediate">Intermediate</option>
                                                            <option value="Basic">Basic</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-danger removeLang">
                                                            <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">
                                    Employment History
                                    @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                        @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')
                                            <span style="color:#fd6363;font-size:13px;text-transform: none;"> (<b>
                                                        For
                                                        Update,Contact with HR </b> )</span>
                                        @endif
                                    @endif
                                </legend>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">External History(Employment history before joining
                                        in incepta, if any):
                                    </legend>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped employment_table"
                                               id="external_emp">

                                            <!-- thead -->
                                            <thead>
                                            <tr>
                                                <th>Name of the Company</th>
                                                <th>Designation</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Country</th>
                                                <th>Reference Name</th>
                                                <th>Contact Number</th>
                                                <th>Reason For leaving</th>
                                                @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                                    @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')

                                                    @endif
                                                @else
                                                    <th style="text-align: center;">
                                                        <a href="#" class="addRowEmplo">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                        </a>
                                                    </th>
                                                @endif

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($emp_his_emplment_old_ext as $emp_his_emplment_old)
                                                <tr>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_comp_name}}"
                                                               title="{{$emp_his_emplment_old->emplo_comp_name}}"
                                                               type="text"
                                                               name="emplo_com_name[]"
                                                               class="form-control hr_restrict">
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_desig}}"
                                                               title="{{$emp_his_emplment_old->emplo_desig}}"
                                                               type="text"
                                                               name="emplo_desig_name[]"
                                                               class="form-control emp_desig_list hr_restrict">
                                                    </td>
                                                    <td>
                                                        <div class="input-group date emplo_from_datebir_id">
                                                            @if(empty($emp_his_emplment_old) || count($emp_his_emplment_old)==0)
                                                                <input type="text" name="emplo_from[]"
                                                                       class="form-control">
                                                                <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                            @else
                                                                <input type="text" name="emplo_from[]"
                                                                       value="{{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_from)->format('d/m/Y')}}"
                                                                       class=" form-control hr_restrict">
                                                                <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group date emplo_to_datebir_id"
                                                        >
                                                            @if(empty($emp_his_emplment_old) || count($emp_his_emplment_old)==0)
                                                                <input type="text" name="emplo_to[]"
                                                                       class="form-control">
                                                            @else
                                                                <input type="text" name="emplo_to[]"
                                                                       value="{{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_to)->format('d/m/Y')}}"
                                                                       class=" form-control hr_restrict">
                                                            @endif
                                                            <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->country}}"
                                                               type="text" name="emplo_country_nam[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input value="{{$emp_his_emplment_old->department}}"
                                                               type="text" name="emplo_country_dept[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_ref_name}}"
                                                               title="{{$emp_his_emplment_old->emplo_ref_name}}"
                                                               type="text"
                                                               name="emplo_ref_nam[]"
                                                               class="form-control amount hr_restrict">
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_cont_no}}"
                                                               type="text"
                                                               name="emplo_contact_no[]"
                                                               class="form-control price hr_restrict"
                                                               maxlength="11">
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_rea_lev}}"
                                                               type="text"
                                                               name="emplo_rea_leav[]"
                                                               class="form-control hr_restrict">
                                                    </td>
                                                    @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                                        @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')

                                                        @endif
                                                    @else
                                                        <td>
                                                            <a href="#" class="btn btn-danger remove_emplo">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                            </a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>

                                                    <td>
                                                        <input type="text" name="emplo_com_name[]"
                                                               class="hr_restrict form-control ">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_desig_name[]"
                                                               class="hr_restrict form-control emp_desig_list">
                                                    </td>
                                                    <td>
                                                        {{--<input type="text" name="emplo_from[]"--}}
                                                        {{--class="form-control ">--}}
                                                        <div class="input-group date emplo_from_datebir_id">
                                                            <input type="text" name="emplo_from[]"
                                                                   class="form-control hr_restrict ">
                                                            <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group date emplo_to_datebir_id">
                                                            <input type="text" name="emplo_to[]"
                                                                   class="form-control hr_restrict ">
                                                            <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_country_nam[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" name="emplo_country_dept[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_ref_nam[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_contact_no[]"
                                                               class="form-control price hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_rea_leav[]"
                                                               class="form-control hr_restrict ">
                                                    </td>

                                                    <td>
                                                        <a href="#" class="btn btn-danger remove_emplo">
                                                            <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                </fieldset>
                                <fieldset class="scheduler-border">
                                    <legend class="scheduler-border">
                                        Internal History(Please write down the department wise employment history
                                        from joining in incepta to present):
                                    </legend>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped employment_table_internal"
                                               id="internal_emp">
                                            <thead>

                                            <th>Name of the Company</th>
                                            <th>Designation</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Department</th>
                                            <th style="text-align: center;">
                                                <a href="#" class="addRowEmploInt">
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                </a>
                                            </th>
                                            </thead>
                                            <tbody>
                                            @forelse($emp_his_emplment_old_int as $emp_his_emplment_old)
                                                <tr>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_comp_name}}"
                                                               title="{{$emp_his_emplment_old->emplo_comp_name}}"
                                                               type="text"
                                                               readonly
                                                               name="emplo_com_name[]"
                                                               class="form-control hr_restrict">
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->emplo_desig}}"
                                                               title="{{$emp_his_emplment_old->emplo_desig}}"
                                                               type="text"
                                                               name="emplo_desig_name[]"
                                                               class="form-control emp_desig_list hr_restrict">
                                                    </td>
                                                    <td>
                                                        {{--                                                                <input value="{{$emp_his_emplment_old->emplo_from}}" type="text" name="emplo_from[]" class="form-control ">--}}
                                                        <div class="input-group date emplo_from_datebir_id">
                                                            {{--<input type="text" name="emplo_from[]" class="form-control ">--}}
                                                            @if(empty($emp_his_emplment_old) || count($emp_his_emplment_old)==0)
                                                                <input type="text" name="emplo_from[]"
                                                                       class="form-control">
                                                                <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                            @else
                                                                <input type="text" name="emplo_from[]"
                                                                       value="{{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_from)->format('d/m/Y')}}"
                                                                       class=" form-control hr_restrict">
                                                                <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                            @endif

                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{--<input value="{{$emp_his_emplment_old->emplo_to}}" type="text" name="emplo_to[]" class="form-control ">--}}
                                                        <div class="input-group date emplo_to_datebir_id">
                                                            {{--<input type="text" name="emplo_to[]" class="form-control ">--}}

                                                            @if(empty($emp_his_emplment_old) || count($emp_his_emplment_old)==0)
                                                                <input type="text" name="emplo_to[]"
                                                                       class="form-control">
                                                            @else
                                                                <input type="text" name="emplo_to[]"
                                                                       value="{{ \Carbon\Carbon::parse($emp_his_emplment_old->emplo_to)->format('d/m/Y')}}"
                                                                       class=" form-control hr_restrict">
                                                            @endif
                                                            <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                        </div>
                                                    </td>
                                                    <td style="display: none;">
                                                        <input value="{{$emp_his_emplment_old->country}}"
                                                               type="text" name="emplo_country_nam[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <input value="{{$emp_his_emplment_old->department}}"
                                                               type="text" name="emplo_country_dept[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input value="{{$emp_his_emplment_old->emplo_ref_name}}"
                                                               title="{{$emp_his_emplment_old->emplo_ref_name}}"
                                                               type="text"
                                                               name="emplo_ref_nam[]"
                                                               class="form-control amount hr_restrict">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input value="{{$emp_his_emplment_old->emplo_cont_no}}"
                                                               type="text"
                                                               name="emplo_contact_no[]"
                                                               class="form-control price hr_restrict"
                                                               maxlength="11">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input value="{{$emp_his_emplment_old->emplo_rea_lev}}"
                                                               type="text"
                                                               @if($loop->index == 0) readonly @endif
                                                               name="emplo_rea_leav[]"
                                                               class="form-control hr_restrict">
                                                    </td>
                                                    @if(!empty($emp_his_moreinfoid[0]->emp_final_sub))
                                                        @if($emp_his_moreinfoid[0]->emp_final_sub=='submit_yes')

                                                        @endif
                                                    @else
                                                        <td>
                                                            <a href="#" class="btn btn-danger remove_emplo_int">
                                                                <i class="glyphicon glyphicon-remove"></i>
                                                            </a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>

                                                    <td>
                                                        <input type="text" name="emplo_com_name[]"
                                                               class="hr_restrict form-control "
                                                               value="{{$company_name[0]->com_name}}"
                                                               title="{{$company_name[0]->com_name}}"
                                                               readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_desig_name[]"
                                                               class="hr_restrict form-control emp_desig_list">
                                                    </td>
                                                    <td>
                                                        {{--<input type="text" name="emplo_from[]"--}}
                                                        {{--class="form-control ">--}}

                                                        <div class="input-group date emplo_from_datebir_id">
                                                            <input type="text" name="emplo_from[]"
                                                                   class="form-control hr_restrict ">
                                                            <span class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </span>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        {{--<input type="text" name="emplo_to[]" class="form-control ">--}}
                                                        <div class="input-group date emplo_to_datebir_id">
                                                            <input type="text" name="emplo_to[]"
                                                                   class="form-control hr_restrict ">
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" name="emplo_country_nam[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="emplo_country_dept[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" name="emplo_ref_nam[]"
                                                               class="form-control amount hr_restrict ">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" name="emplo_contact_no[]"
                                                               class="form-control price hr_restrict ">
                                                    </td>
                                                    <td style="display: none;">
                                                        <input type="text" name="emplo_rea_leav[]"
                                                               class="form-control hr_restrict ">
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-danger remove_emplo_int">
                                                            <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                </fieldset>
                            </fieldset>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Family Details (
                                    Father/Mother/Children/Brother/Sister)*
                                </legend>
                                <div class="table-responsive">
                                    <table class="table table-bordered family_table table-striped">
                                        <!-- thead -->
                                        <thead>
                                        <th>Relation</th>
                                        <th>Name<span>*</span></th>
                                        <th>Date of Birth</th>
                                        <th>Place of Birth<span>*</span></th>
                                        <th>Country of birth<span>*</span></th>
                                        <th>Nationality<span>*</span></th>
                                        <th>Mobile No</th>
                                        </thead>
                                        <!-- TBODY -->
                                        <tbody>
                                        <tr>
                                            <td>
                                                <b>
                                                    <scan style="color:#ab6a19;">Father</scan>
                                                </b>
                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="fa_relation_name"
                                                           class="err_input_empty form-control">

                                                @else
                                                    <input type="text" name="fa_relation_name"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->father_name:""}}"
                                                           class="err_input_empty form-control">
                                                @endif
                                            </td>
                                            <td>

                                                <div class="input-group date" id="rela_datebir_faid">
                                                    @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                        <input type="text" name="rela_datebir_faid"
                                                               class="form-control">
                                                    @else
                                                        <input type="text" name="rela_datebir_faid"
                                                               value="{{ count($emp_hisfamidetail[0]->fa_bir_date)>0 ?\Carbon\Carbon::parse($emp_hisfamidetail[0]->fa_bir_date)->format('d/m/Y'):""}}"
                                                               class=" form-control">
                                                    @endif

                                                    <span class="input-group-addon">
                                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                             </span>
                                                </div>

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="fa_relation_plabir"
                                                           class="err_input_empty form-control">
                                                @else
                                                    <input type="text" name="fa_relation_plabir"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_place_birth:""}}"
                                                           class="err_input_empty form-control">
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="emp_all_countryfa"
                                                           class="err_input_empty form-control">
                                                @else
                                                    <input type="text" name="emp_all_countryfa"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_cuntry_birth:""}}"
                                                           class="err_input_empty form-control">
                                                @endif
                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <div class="input-group" style="display: inline-block;">
                                                        <Select class="form-control sp_nationality" style="width: 50%;">
                                                            <option value="" disabled>Select</option>
                                                            <option value="Bangladeshi" selected>Bangladeshi</option>
                                                            <option value="Others">Others</option>
                                                        </Select>
                                                        <input type="text" name="fa_rel_nationality" style="width: 50%;"
                                                               readonly value="Bangladeshi"
                                                               class="err_input_empty form-control">
                                                    </div>
                                                @else
                                                    <div class="input-group" style="display: inline-block;">
                                                        <Select class="form-control sp_nationality" style="width: 50%;">
                                                            <option value="" disabled>Select</option>
                                                            <option {{ ( $emp_hisfamidetail[0]->fa_nationality == 'Bangladeshi') ? 'selected' : '' }} value="Bangladeshi">
                                                                Bangladeshi
                                                            </option>
                                                            <option {{ ( $emp_hisfamidetail[0]->fa_nationality != 'Bangladeshi') ? 'selected' : '' }} value="Others">
                                                                Others
                                                            </option>
                                                        </Select>
                                                        <input type="text" name="fa_rel_nationality" style="width: 50%;"
                                                               {{ ( $emp_hisfamidetail[0]->fa_nationality == 'Bangladeshi') ? 'readonly' : '' }}
                                                               value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_nationality:""}}"
                                                               class="err_input_empty form-control">
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" maxlength="11" name="fa_relation_mobno"
                                                           class="form-control">
                                                @else
                                                    <input type="text" maxlength="11"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->fa_mob_no:""}}"
                                                           name="fa_relation_mobno" class=" form-control">
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>
                                                    <scan style="color:#ab6a19;">Mother</scan>
                                                </b>
                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="mo_relation_name"
                                                           class="err_input_empty form-control qty">
                                                @else
                                                    <input type="text" name="mo_relation_name"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mother_name:""}}"
                                                           class="err_input_empty form-control qty">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="input-group date" id="rela_datebir_moid">
                                                    @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                        <input type="text" name="rela_datebir_moid"
                                                               class=" form-control">

                                                    @else
                                                        <input type="text" name="rela_datebir_moid"
                                                               value="{{ count($emp_hisfamidetail[0]->mo_bir_date)>0 ?\Carbon\Carbon::parse($emp_hisfamidetail[0]->mo_bir_date)->format('d/m/Y'):""}}"
                                                               class=" form-control">

                                                    @endif
                                                    <span class="input-group-addon">
                                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                             </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="mo_relation_plabir"
                                                           class="err_input_empty form-control dis">
                                                @else
                                                    <input type="text" name="mo_relation_plabir"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_place_birth:""}}"
                                                           class="err_input_empty form-control dis">
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="emp_all_countrymo"
                                                           class="err_input_empty form-control dis">
                                                @else
                                                    <input type="text" name="emp_all_countrymo"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_cuntry_birth:""}}"
                                                           class="err_input_empty form-control dis">
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <div class="input-group" style="display: inline-block;">
                                                        <Select class="form-control sp_nationality" style="width: 50%;">
                                                            <option value="" disabled>Select</option>
                                                            <option value="Bangladeshi" selected>Bangladeshi</option>
                                                            <option value="Others">Others</option>
                                                        </Select>
                                                        <input type="text" name="mo_rel_nationality" style="width: 50%;"
                                                               readonly value="Bangladeshi"
                                                               class="err_input_empty form-control">
                                                    </div>
                                                @else
                                                    <div class="input-group" style="display: inline-block;">
                                                        <Select class="form-control sp_nationality" style="width: 50%;">
                                                            <option value="" disabled>Select</option>
                                                            <option {{ ( $emp_hisfamidetail[0]->mo_nationality == 'Bangladeshi') ? 'selected' : '' }} value="Bangladeshi">
                                                                Bangladeshi
                                                            </option>
                                                            <option {{ ( $emp_hisfamidetail[0]->mo_nationality != 'Bangladeshi') ? 'selected' : '' }} value="Others">
                                                                Others
                                                            </option>
                                                        </Select>
                                                        <input type="text" name="mo_rel_nationality" style="width: 50%;"
                                                               {{ ( $emp_hisfamidetail[0]->mo_nationality == 'Bangladeshi') ? 'readonly' : '' }}
                                                               value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_nationality:""}}"
                                                               class="err_input_empty form-control">
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" maxlength="11" name="mo_relation_mobno"
                                                           class=" form-control dis">
                                                @else
                                                    <input type="text" maxlength="11"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->mo_mob_no:""}}"
                                                           name="mo_relation_mobno" class=" form-control dis">
                                                @endif

                                            </td>

                                        </tr>
                                        <tr>

                                            <td>
                                                <b>
                                                    <scan style="color:#ab6a19;">Spouse</scan>
                                                </b>
                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="sp_relation_name"
                                                           class="err_input_empty form-control qty">
                                                @else
                                                    <input type="text" name="sp_relation_name"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->spouse_name:""}}"
                                                           class="err_input_empty form-control qty">
                                                @endif

                                            </td>
                                            <td>
                                                <div class="input-group date" id="rela_datebir_spouseid">
                                                    @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                        <input type="text" name="rela_datebir_spid"
                                                               class=" form-control">

                                                    @else
                                                        <input type="text" name="rela_datebir_spid"
                                                               value="{{ count($emp_hisfamidetail[0]->sp_bir_date)>0 ? \Carbon\Carbon::parse($emp_hisfamidetail[0]->sp_bir_date)->format('d/m/Y'):""}}"
                                                               class=" form-control">

                                                    @endif

                                                    <span class="input-group-addon">
                                                                 <span class="glyphicon glyphicon-calendar"></span>
                                                             </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" name="sp_relation_plabir"
                                                           class="err_input_empty form-control dis">
                                                @else
                                                    <input type="text" name="sp_relation_plabir"
                                                           value="{{ count($emp_hisfamidetail[0]->sp_place_birth)>0 ?$emp_hisfamidetail[0]->sp_place_birth:""}}"
                                                           class="err_input_empty form-control dis">
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" class="err_input_empty form-control"
                                                           id="emp_all_country_spouseid" name="emp_all_countrysp">
                                                @else
                                                    <input type="text" class="err_input_empty form-control"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->sp_cuntry_birth:""}}"
                                                           id="emp_all_country_spouseid"
                                                           name="emp_all_countrysp">
                                                @endif


                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <div class="input-group" style="display: inline-block;">
                                                        <Select class="form-control sp_nationality" style="width: 50%;">
                                                            <option value="" disabled>Select</option>
                                                            <option value="Bangladeshi" selected>Bangladeshi</option>
                                                            <option value="Others">Others</option>
                                                        </Select>
                                                        <input type="text" name="sp_rel_nationality" style="width: 50%;"
                                                               readonly value="Bangladeshi"
                                                               class="err_input_empty form-control">
                                                    </div>
                                                @else
                                                    <div class="input-group" style="display: inline-block;">
                                                        <Select class="form-control sp_nationality" style="width: 50%;">
                                                            <option value="" disabled>Select</option>
                                                            <option {{ ( $emp_hisfamidetail[0]->sp_nationality == 'Bangladeshi') ? 'selected' : '' }} value="Bangladeshi">
                                                                Bangladeshi
                                                            </option>
                                                            <option {{ ( $emp_hisfamidetail[0]->sp_nationality != 'Bangladeshi') ? 'selected' : '' }} value="Others">
                                                                Others
                                                            </option>
                                                        </Select>
                                                        <input type="text" name="sp_rel_nationality" style="width: 50%;"
                                                               {{ ( $emp_hisfamidetail[0]->sp_nationality == 'Bangladeshi') ? 'readonly' : '' }}
                                                               value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->sp_nationality:""}}"
                                                               class="err_input_empty form-control">
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                @if(empty($emp_hisfamidetail) || count($emp_hisfamidetail)==0)
                                                    <input type="text" maxlength="11" name="sp_relation_mobno"
                                                           class=" form-control">
                                                @else
                                                    <input type="text" maxlength="11"
                                                           value="{{ count($emp_hisfamidetail)>0 ?$emp_hisfamidetail[0]->sp_mob_no:""}}"
                                                           name="sp_relation_mobno" class=" form-control">
                                                @endif

                                            </td>

                                        </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="display: none" id="page_two_error">
                <div class="alert alert-warning">
                    <p><b><i class="fa fa-warning"></i> Please fill required fields marked red!</b></p>
                </div>
            </div>
            <button class="btn btn-primary btn-sm pagetwo_btn nextBtn pull-right" type="button">Save & Continue</button>
        </div>
    </form>
</div>
