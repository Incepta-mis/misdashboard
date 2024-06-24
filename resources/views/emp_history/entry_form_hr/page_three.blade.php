<div class="panel panel-primary setup-content" id="step-3">
    <div class="panel-heading">
        <h3 class="panel-title">Page 3</h3>
    </div>
    <form method="post" id="frm_pagethree">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="emp_code_id" name="emp_code_nam" readonly value="{{$login_moreinfo[0]->emp_id}}"/>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-lg-12 col-sm-12">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Children(s)/Brother(s)/Sister(s)</legend>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped sib_bro_sis_table">

                                        <!-- thead -->
                                        <thead>

                                        <th>Title</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Place of Birth</th>
                                        <th>Country of Birth</th>
                                        <th>Nationality</th>
                                        <th>Relationship</th>

                                        <th style="text-align: center;">
                                            <a href="#" class="addRowcbs">
                                                <i class="glyphicon glyphicon-plus"></i>
                                            </a>
                                        </th>
                                        </thead>
                                        <!-- TBODY -->
                                        <tbody>

                                        @forelse($emp_his_cbs_old as $emp_his_cbs_old)
                                            <tr>

                                                <td>
                                                    <div class="input-group-btn">
                                                        <select class="input-sm cbs_title" name="cbs_title[]">
                                                            <option value="0" disabled="true" selected="true">
                                                                Select
                                                            </option>

                                                            <option {{'Mr.' == $emp_his_cbs_old->cbs_title ? 'selected="selected"' : '' }} value="Mr.">
                                                                Mr.
                                                            </option>
                                                            <option {{'Ms.' == $emp_his_cbs_old->cbs_title ? 'selected="selected"' : '' }} value="Ms.">
                                                                Ms.
                                                            </option>

                                                        </select>
                                                    </div>

                                                </td>
                                                <td>

                                                    <input type="text" name="cbs_name[]"
                                                           value="{{$emp_his_cbs_old->cbs_name}}"
                                                           class="qty form-control">
                                                </td>
                                                <td>
                                                    {{--<input type="text" name="cbs_name[]"--}}
                                                    {{--value="{{$emp_his_cbs_old->cbs_date_birth}}" class="form-control qty">--}}
                                                    <div class="input-group date cbs_datebir_id">

                                                        @if(empty($emp_his_cbs_old) || count($emp_his_cbs_old)==0)
                                                            <input type="text" name="cbs_datebir[]"
                                                                   class="form-control ">

                                                        @else
                                                            <input type="text" name="cbs_datebir[]"
                                                                   value="{{ count($emp_his_cbs_old->cbs_date_birth)>0 ? \Carbon\Carbon::parse($emp_his_cbs_old->cbs_date_birth)->format('d/m/Y'):""}}"
                                                                   class=" form-control">

                                                        @endif
                                                        <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                    </div>
                                                    {{--<div class="input-group date cbs_datebir_id">--}}
                                                    {{--<input type="text" name="cbs_datebir[]" class="form-control ">--}}
                                                    {{--<span class="input-group-addon">--}}
                                                    {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                                                    {{--</span>--}}
                                                    {{--</div>--}}


                                                </td>
                                                <td>
                                                    <input type="text" name="cbs_placebir[]"
                                                           value="{{$emp_his_cbs_old->cbs_plac_birth}}"
                                                           class="form-control qty">
                                                </td>
                                                <td>
                                                    <input type="text" name="cbs_country_bir[]"
                                                           value="{{$emp_his_cbs_old->cbs_cuntry_birth}}"
                                                           class="form-control price">
                                                </td>
                                                <td>
                                                    <input type="text" name="cbs_nationality[]"
                                                           value="{{$emp_his_cbs_old->cbs_nationality}}"
                                                           class="form-control dis">
                                                </td>

                                                <td>
                                                    <select class="form-control"
                                                            name="cbs_relationship[]">
                                                        <option value="0" disabled="true" selected="true">
                                                            Select
                                                        </option>
                                                        <option {{'Son' == $emp_his_cbs_old->cbs_relation ? 'selected="selected"' : '' }} value="Son">
                                                            Son
                                                        </option>
                                                        <option {{'Daughter' == $emp_his_cbs_old->cbs_relation ? 'selected="selected"' : '' }} value="Daughter">
                                                            Daughter
                                                        </option>
                                                        <option {{'Brother' == $emp_his_cbs_old->cbs_relation ? 'selected="selected"' : '' }} value="Brother">
                                                            Brother
                                                        </option>
                                                        <option {{'Sister' == $emp_his_cbs_old->cbs_relation ? 'selected="selected"' : '' }} value="Sister">
                                                            Sister
                                                        </option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <a href="#" class="btn btn-danger remove_cbs">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>

                                                <td>
                                                    <div class="input-group-btn">
                                                        <select class="input-sm cbs_title" name="cbs_title[]">
                                                            <option value="0" disabled="true" selected="true">
                                                                Select
                                                            </option>

                                                            <option value="Mr.">Mr.</option>
                                                            <option value="Ms.">Ms.</option>

                                                        </select>
                                                    </div>

                                                </td>
                                                <td>

                                                    <input type="text" name="cbs_name[]"
                                                           class="qty form-control">
                                                </td>
                                                <td>

                                                    <div class="input-group date cbs_datebir_id">
                                                        <input type="text" name="cbs_datebir[]" class="form-control ">
                                                        <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="cbs_placebir[]"
                                                           class="form-control qty">
                                                </td>
                                                <td>
                                                    <input type="text" name="cbs_country_bir[]"
                                                           class="form-control price">
                                                </td>
                                                <td>
                                                    <input type="text" name="cbs_nationality[]"
                                                           class="form-control dis">
                                                </td>

                                                <td>
                                                    <select class="form-control"
                                                            name="cbs_relationship[]">
                                                        <option value="0" disabled="true" selected="true">
                                                            Select
                                                        </option>
                                                        <option value="Son">Son</option>
                                                        <option value="Daughter">Daughter</option>
                                                        <option value="Brother">Brother</option>
                                                        <option value="Sister">Sister</option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <a href="#" class="btn btn-danger remove_cbs">
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

                        <div class="col-lg-12 col-sm-12 ">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Professional Qualification / Specialized Training (Start from recent)</legend>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped pro_quali_table">
                                        <!-- thead -->
                                        <thead>

                                        <th>Institution Name</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Duration</th>
                                        <th>Course Name</th>
                                        <th>Result</th>
                                        <th>Country</th>

                                        <th style="text-align: center;">
                                            <a href="#" class="addRowProQuali">
                                                <i class="glyphicon glyphicon-plus"></i>
                                            </a>
                                        </th>
                                        </thead>
                                        <!-- TBODY -->
                                        <tbody>
                                        @forelse($emp_his_pro_quali as $emp_his_pro_quali)
                                            <tr>

                                                <td>
                                                    <input type="text" value="{{$emp_his_pro_quali->pro_insti_nam}}"
                                                           name="proquali_inst_nam[]" class="form-control">
                                                </td>
                                                <td>
                                                    <div class="input-group date prof_from_datebir_id">
                                                        {{--<input type="text" name="proquali_from[]" class="form-control ">--}}
                                                        @if(empty($emp_his_pro_quali) || count($emp_his_pro_quali)==0)
                                                            <input type="text" name="proquali_from[]"
                                                                   class="form-control proq_from">

                                                        @else
                                                            <input type="text" name="proquali_from[]"
                                                                   value="{{ count($emp_his_pro_quali->pro_from)>0 ? \Carbon\Carbon::parse($emp_his_pro_quali->pro_from)->format('d/m/Y'):""}}"
                                                                   class=" form-control proq_from">

                                                        @endif
                                                        <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date prof_to_datebir_id">
                                                        {{--<input type="text" name="proquali_to[]" class="form-control ">--}}
                                                        @if(empty($emp_his_pro_quali) || count($emp_his_pro_quali)==0)
                                                            <input type="text" name="proquali_to[]"
                                                                   class="form-control proq_to">

                                                        @else
                                                            <input type="text" name="proquali_to[]"
                                                                   value="{{ count($emp_his_pro_quali->pro_to)>0 ? \Carbon\Carbon::parse($emp_his_pro_quali->pro_to)->format('d/m/Y'):""}}"
                                                                   class=" form-control proq_to">

                                                        @endif
                                                        <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <input type="text" value="{{$emp_his_pro_quali->pro_duration}}"
                                                           name="proquali_duration[]" readonly
                                                           class="proquali_duration_clss form-control">
                                                </td>
                                                <td>
                                                    <input type="text" value="{{$emp_his_pro_quali->pro_cour_nam}}"
                                                           name="proquali_coursenam[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" value="{{$emp_his_pro_quali->pro_result}}"
                                                           name="proquali_result[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" value="{{$emp_his_pro_quali->pro_cuntry}}"
                                                           name="proquali_country[]" class="form-control">
                                                </td>


                                                <td>
                                                    <a href="#" class="btn btn-danger remove_proquali">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>

                                                <td>
                                                    <input type="text" name="proquali_inst_nam[]" class="form-control">
                                                </td>
                                                <td>
                                                    <div class="input-group date prof_from_datebir_id">
                                                        <input type="text" name="proquali_from[]"
                                                               class="form-control proq_from">
                                                        <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date prof_to_datebir_id">
                                                        <input type="text" name="proquali_to[]"
                                                               class="form-control proq_to">
                                                        <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                                    </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="proquali_duration[]"
                                                           class="proquali_duration_clss form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="proquali_coursenam[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="proquali_result[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="proquali_country[]" class="form-control">
                                                </td>


                                                <td>
                                                    <a href="#" class="btn btn-danger remove_proquali">
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
                                <div>
                                    <label for="">
                                        <scan style="color:#337ab7">
                                            <b>Have you any relative in Incepta? </b>
                                        </scan>
                                    </label>
                                </div>
                                <div>
                                    @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                        <input type="radio" class="rel_incep_clss" name="incep_rel" value="No"> No
                                        <input type="radio" class="rel_incep_clss" name="incep_rel" value="Yes"> Yes
                                    @else
                                        <input type="radio"
                                               {{'No' == $emp_his_moreinfoid[0]->relative_incep ? 'checked=true"' : 'false' }} class="rel_incep_clss"
                                               name="incep_rel" value="No"> No
                                        <input type="radio"
                                               {{'Yes' == $emp_his_moreinfoid[0]->relative_incep ? 'checked="true"' : 'false' }} class="rel_incep_clss"
                                               name="incep_rel" value="Yes"> Yes
                                    @endif
                                    &emsp;
                                    <span id="emp_inceprel_divid" style="visibility: hidden">
                                        @if(empty($emp_his_moreinfoid) || count($emp_his_moreinfoid)==0)
                                            <input type="text" name="incep_rel_empnam"
                                                   class="emp_inceprel_clss form-control-custom"
                                                   id="inc_emp_rel_name_id" placeholder=" Employee Name">
                                            <input type="text" name="incep_rel_empcode"
                                                   class="emp_inceprel_clss form-control-custom"
                                                   id="inc_emp_rel_code_id" placeholder=" Employee Code">
                                            <input type="text" name="incep_rel_rela"
                                                   class="emp_inceprel_clss form-control-custom"
                                                   id="inc_emp_rel_rel_id" placeholder=" Employee Relation">
                                        @else
                                            <input type="text" name="incep_rel_empnam"
                                                   class="emp_inceprel_clss form-control-custom"
                                                   id="inc_emp_rel_name_id"
                                                   value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->rela_incep_empnam:""}}"
                                                   placeholder=" Employee Name">
                                            <input type="text" name="incep_rel_empcode"
                                                   class="emp_inceprel_clss form-control-custom"
                                                   id="inc_emp_rel_code_id"
                                                   value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->rela_incep_empcode:""}}"
                                                   placeholder=" Employee Code">
                                            <input type="text" name="incep_rel_rela"
                                                   class="emp_inceprel_clss form-control-custom"
                                                   id="inc_emp_rel_rel_id"
                                                   value="{{ count($emp_his_moreinfoid)>0 ?$emp_his_moreinfoid[0]->rela_incep_emprel:""}}"
                                                   placeholder=" Employee Relation">
                                        @endif
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-sm nextBtn pagethree_btn pull-right" type="button">Save & Continue
            </button>
        </div>
    </form>
</div>
