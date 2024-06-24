<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/8/2018
 * Time: 5:18 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Apply Leave')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    {{--        <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"--}}
    {{--type="text/css"/>--}}

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/clockpicker/jquery-clockpicker.min.css')}}" rel="stylesheet"
          type="text/css"/>

    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">--}}



    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: black;
        }

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        input[type=file]::-webkit-file-upload-button {
            width: 0;
            padding: 0;
            margin: 0;
            -webkit-appearance: none;
            border: none;
            border: 0px;
        }

        x::-webkit-file-upload-button, input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

        input {
            color: black;
            font-size: x-small;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }


        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }


    </style>

@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Leave Application Form
                    </label>
                </header>

                <div class="panel-body hd">


                    @if (\Session::has('success'))
                        <div class="alert alert-success" id="success-alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Success! </strong>
                            {!! \Session::get('success') !!}
                        </div>
                    @elseif(\Session::has('error'))
                        <div class="alert alert-danger" id="error-alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Error!</strong>
                            {!! \Session::get('error') !!}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" id="error-alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif


                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <form class="form-horizontal" name="myForm" onsubmit="return validateForm()" role="form"
                                  method="post" action="{{url('elm_portal/userSubmit')}}" id="appfrm"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @foreach($factMgr as $item)
                                    @if($item->emp_id == Auth::user()->user_id)

                                        <div class="row" style="display: none;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" checked="checked" class="custom-control-input"
                                                       id="defaultUnchecked" name="hd">
                                                <label class="custom-control-label" for="defaultUnchecked">
                                                    <span class="text-danger">If Department Head</span>
                                                </label>
                                            </div>
                                        </div>

                                    @endif
                                @endforeach

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <h5 class="text-center text-primary"><b> Employee Leave Details</b></h5>
                                        @if(!empty($absentStatus))
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 table-responsive ">

                                                    <table class="table table-hover table-bordered emp_info">
                                                        <tbody>
                                                        <tr>
                                                            <td style="background-color: orangered"><span
                                                                        style="color: white">ABSENT DATE</span></td>
                                                            @foreach($absentStatus as $as)
                                                                <td>{{ $as->wk_date}}</td>
                                                            @endforeach
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 col-sm-12 table-responsive ">
                                        <table class="table table-hover table-bordered emp_info">
                                            <thead>
                                            <tr>
                                                <th>Employee Code</th>
                                                <th>Employee Name</th>
                                                <th>Designation</th>
                                                <th>Department</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                @foreach($emp_info as $e)
                                                    <td class="cnt">{{ $e->emp_id }}</td>
                                                    <td class="cnt">{{ $e->sur_name }} </td>
                                                    <td class="cnt">{{ $e->desig_name }}</td>
                                                    <td class="cnt">{{ $e->dept_name }}</td>

                                                    <input type="hidden" id="employee_id" name="emp_id" value="{{ $e->emp_id  }}"/>
                                                    <input type="hidden" name="sur_name" value="{{ $e->sur_name  }}"/>
                                                    <input type="hidden" name="desig_id" value="{{ $e->desig_id  }}"/>
                                                    <input type="hidden" name="desig_name"
                                                           value="{{ $e->desig_name  }}"/>
                                                    <input type="hidden" name="dept_id" value="{{ $e->dept_id  }}"/>
                                                    <input type="hidden" name="dept_name" value="{{ $e->dept_name  }}"/>

                                                    <input type="hidden" name="rpt_visor_id"
                                                           value="{{ $e->report_supervisor  }}"/>
                                                    <input type="hidden" name="rpt_head_id"
                                                           value="{{ $e->head_of_dept  }}"/>
                                                    <input type="hidden" name="plant_id" value="{{ $e->plant_id  }}"/>
                                                @endforeach
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-5 col-md-5">
                                        <div class="form-group">
                                            <label for="date" class="col-md-4 col-sm-4 control-label fnt_size"><b>Date of leave on</b></label>
                                            <div class="col-sm-3 col-md-3">
                                                <input type="text" autocomplete="off" class="form-control input-sm"
                                                       name="st_dt" style="font-size: x-small; padding-right: 0px;" id="date1">
                                                <input type="hidden" autocomplete="off" class="form-control input-sm"
                                                       style="font-size: x-small; padding-right: 0px;"
                                                       name="cus_st_dt" id="cus_st_dt">
                                            </div>
                                            <div class="col-sm-3 col-md-3">
                                                <input type="text" autocomplete="off" class="form-control input-sm"
                                                       style="font-size: x-small;" name="en_dt" id="date2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-md-3">
                                        <div class="form-group">
                                            <label for="contact" class="col-sm-5 col-md-5 control-label
                                            fnt_size"><b>Day of leave</b></label>
                                            <div class="col-md-4 col-sm-4">
                                                <input type="text" class="form-control input-sm" name="dol" id="dol"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cmp" class="col-md-4 col-sm-4 control-label fnt_size"><b>Type of leave</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select name="tol" id="tol"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Leave</option>
                                                    @if(Auth::user()->plant_id == '1100' || Auth::user()->plant_id == '2100')
                                                        @foreach($leaveTypes as $l)
                                                            @if( $l->leave_type != 'COMPENSATION')
                                                                <option value="{{$l->leave_type}}">{{$l->leave_type}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($leaveTypes as $l)
                                                            @if( $l->leave_type != 'ADVANCE')
                                                                <option value="{{$l->leave_type}}">{{$l->leave_type}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>

                                                <div class="row" id="row_dim"
                                                     style="display: block;padding-left:15px;display: none;">
                                                    <p class="help-block text-danger">Only jpg, jpeg file types are allowed</p>
                                                    <input type="file" id="medicalFile" name="medicalFile"
                                                           style="background-color: #9cf264;">
                                                </div>

                                                <div class="row" id="row_mtrn"
                                                     style="display: block; padding-left:15px;display: none;">
                                                    <p class="help-block text-danger">Only jpg, jpeg file types are allowed</p>
                                                    <input type="file" id="mtrn_file" name="mtrn_file"
                                                           style="background-color: #9cf264;">
                                                </div>


                                                <div class="input-group control-group increment" style="display: none">
                                                    <p class="help-block text-danger">Only jpg, jpeg file types are allowed</p>
                                                    <input type="file" name='filename[]' class="form-control">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-success btn-xs" type="button"><i
                                                                    class="glyphicon glyphicon-plus"></i>Add
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="clone hide">
                                                    <div class="control-group input-group" style="margin-top:10px">
                                                        <input type="file" name="filename[]"
                                                               class="form-control input-sm">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-danger btn-xs" type="button"><i
                                                                        class="glyphicon glyphicon-remove"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="cmp"
                                                   class="col-md-6 col-sm-6 control-label fnt_size"><b>Address
                                                    during leave</b></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" class="form-control input-sm" name="adl"
                                                       id="adl">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="contact"
                                                   class="col-sm-4 col-md-4 control-label fnt_size"><b>Contact
                                                    No</b></label>
                                            <div class="col-md-6 col-sm-6">
                                                @foreach($emp_info as $e)
                                                    <input type="text" class="form-control input-sm" name="mob" readonly
                                                           id="mob"
                                                           value="{{ $e->contact_no }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="contact"
                                                   class="col-sm-4 col-md-4 control-label fnt_size"><b>Email</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="text" class="form-control input-sm" name="email"
                                                       value="{{ $e->mail_address }}"
                                                       id="emil" readonly>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <label for="" class="col-md-3 col-sm-3 control-label fnt_size"><b>Purpose
                                                    of leave</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <input type="text" class="form-control input-sm" name="pol"
                                                       id="pol">
                                                @if(!empty($matStatus))
                                                    <input type="hidden" id="no_of_mat" name="no_of_mat"
                                                           value="{{ $matStatus[0]->no_of_leave }}">
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <!--  <div class="col-md-4 col-sm-4">
                                         <div class="form-group">
                                             <label class="col-md-4 col-sm-4 checkbox-inline control-label fnt_size">
                                                 <input type="checkbox"  id="chk_val" value="1">
                                                 <span style="color: #761c19;"><b> Half Day </b></span>
                                             </label>
                                             <div class="col-md-8 col-sm-8" id="lev_period" style="display:none;">
                                                 <select name="period" id="period"
                                                         class="form-control input-sm filter-option pull-left">
                                                     <option value="">Select Period</option>
                                                     <option value="FIRST">FIRST</option>
                                                     <option value="SECOND">SECOND</option>
                                                 </select>
                                             </div>
                                         </div>
                                     </div> -->

                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12">

                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label class="col-md-4 col-sm-4 checkbox-inline control-label fnt_size">
                                                    <input type="checkbox" id="chk_val" value="1">
                                                    <span style="color: #761c19;"><b> Half Day </b></span>
                                                </label>
                                                <div class="col-md-8 col-sm-8" id="lev_period" style="display:none;">
                                                    <select name="period" id="period"
                                                            class="form-control input-sm filter-option pull-left">
                                                        <option value="">Select Period</option>
                                                        <option value="FIRST">FIRST</option>
                                                        <option value="SECOND">SECOND</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="lev_time">
                                            <div class="col-md-4 col-sm-4">
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control input-sm" value=""
                                                           name="st_time">
                                                    <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4">
                                                <div class="input-group clockpicker2">
                                                    <input type="text" class="form-control input-sm" value=""
                                                           name="en_time">
                                                    <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" class="mgtStatus" value="{{ $mgt_status }}">

                                @if($mgt_status != 'NM')
                                    {{-- @if($emp_info[0]->emp_id == '5000043' || $emp_info[0]->emp_id == 'FE001') --}}
                                    @if($exception_emp[0]->emp_cnt > 0 )

                                    @else
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <h5 class="text-center text-primary"><b>Duties Will be carried out by
                                                        (Person)</b></h5>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 table-responsive ">

                                                <table class="table table-hover table-bordered emp_info">
                                                    <thead>
                                                    <tr>
                                                        <th>Responsible Person Name</th>
                                                        <th>Employee Code</th>
                                                        <th>Designation</th>
                                                        <th>Department</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="cnt">
                                                            <select name="rsp_emp" id="rsp_emp"
                                                                    class="form-control input-sm rsp_emp">
                                                                <option value="">Select Employee</option>
                                                                @foreach($employees as $c)
                                                                    <option value="{{$c->emp_id}}">{{$c->emp_id}}
                                                                        - {{$c->sur_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td><input type="text" class="form-control input-sm"
                                                                   id="rsp_emp_code"
                                                                   name="rsp_emp_code" readonly></td>
                                                        <td><input type="text" class="form-control input-sm" id="rsp_desig"
                                                                   name="rsp_desig_name" readonly></td>
                                                        <td><input type="text" class="form-control input-sm"
                                                                   id="rsp_dept_name"
                                                                   name="rsp_dept_name" readonly></td>

                                                        <input type="hidden" class="form-control input-sm" id="rsp_emp_name"
                                                               name="rsp_emp_name">
                                                        <input type="hidden" class="form-control input-sm" id="rsp_desig_id"
                                                               name="rsp_desig_id">
                                                        <input type="hidden" class="form-control input-sm" id="rsp_dept_id"
                                                               name="rsp_dept_id">

                                                    </tr>
                                                    <tr>
                                                        <td class="cnt " colspan="2"><b>Contact No:</b> <input type="text"
                                                                                                               class="form-control input-sm"
                                                                                                               id="rsp_cnt_no"
                                                                                                               name="rsp_cnt_no"
                                                                                                               readonly/>
                                                        </td>
                                                        <td class="cnt " colspan="2"><b>Email:</b> <input type="text"
                                                                                                          class="form-control input-sm"
                                                                                                          id="rsp_email"
                                                                                                          name="rsp_email"
                                                                                                          readonly>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label for="" class="col-md-2 col-sm-2 control-label fnt_size"><b>Responsible
                                                            Duties</b></label>
                                                    <div class="col-md-10 col-sm-10">
                                                        <input type="text" class="form-control input-sm" name="rsp_duties"
                                                               id="rsp_duties">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 text-center">
                                        <div class="form-group">
                                            {{--<div class="col-md-6 col-sm-6 col-xs-6 text-center">--}}

                                            <button type="submit" id="btn_submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Submit</b></button>

                                            <!-- <input type="submit" value="Submit"> -->

                                            {{--</div>--}}
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-success">
                <header class="panel-heading">
                    <label class="text-default">
                        Employee Leave Status
                    </label>
                </header>

                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                {{--<tr>--}}
                                {{--<td colspan="9" style="text-align: center;"><h5 class="text-primary"><b>Employee--}}
                                {{--Leave Status</b></h5></td>--}}
                                {{--</tr>--}}

                                <tr>
                                    <th>TYPE</th>
                                    <th>ANNUAL</th>
                                    <th>CASUAL</th>
                                    <th>LWP</th>
                                    <?php
                                    if($emp_info[0]->gender != 'MALE'){ ?>
                                    <th>MATERNITY</th>
                                    <?php } ?>
                                    <th>MEDICAL</th>
                                    @if(Auth::user()->plant_id == '1100' || Auth::user()->plant_id == '2100')
                                        <th>ADL</th>
                                    @endif
                                    <th>SPECIAL MEDICAL</th>
                                    <th>HAJJ OR PILGRIMAGE LEAVE</th>
                                </tr>
                                </thead>
                                <?php

                                foreach ($leaveStatus as $row => $value) {
                                    echo '<tr>';
                                    if ($row == 0) echo '<td> Eligibility</td>';
                                    else if ($row == 1) echo '<td> Enjoyed</td>';
                                    else if ($row == 2) {
                                        echo '<td> Balance</td> <input type="hidden" id="cas" value="' . $value->casual . '">';
                                        echo '<input type="hidden" id="anl" value="' . $value->annual . '">';
                                        echo '<input type="hidden" id="lwp" value="' . $value->lwp . '">';
                                        if ($emp_info[0]->gender != 'MALE') {
                                            echo '<input type="hidden" id="mat" value="' . $value->maternity . '">';
                                        }
                                        echo '<input type="hidden" id="med" value="' . $value->medical . '">';
                                        if(Auth::user()->plant_id == '1100' || Auth::user()->plant_id == '2100'){
                                            echo '<input type="hidden" id="adv" value="' . $value->advance . '">';
                                        }
                                        echo '<input type="hidden" id="sp_med" value="' . $value->special_medical . '">';
                                        echo '<input type="hidden" id="hajj_pil" value="' . $value->hajj .
                                            '">';
                                    }

//                                            echo '<td>' . $value->emp_id . '</td>';
                                    echo '<td >' . $value->annual . '</td>';
                                    echo '<td >' . $value->casual . '</td>';
                                    echo '<td>' . $value->lwp . '</td>';
                                    if ($emp_info[0]->gender != 'MALE') {
                                        echo '<td>' . $value->maternity . '</td>';
                                    }
                                    echo '<td>' . $value->medical . '</td>';
                                    if(Auth::user()->plant_id == '1100' || Auth::user()->plant_id == '2100'){
                                        echo '<td>' . $value->advance . '</td>';
                                    }
                                    echo '<td>' . $value->special_medical . '</td>';
                                    echo '<td>' . $value->hajj . '</td>';
                                    echo '</tr>';
                                }

                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    {{--    @if( !empty($materials) ) --}}

    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>


    {{--@endif--}}

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>--}}
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Date--}}
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{--Time Picker--}}
    {{Html::script('public/site_resource/js/clockpicker/jquery-clockpicker.min.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    <script>
        var logginUser  = "{{ Auth::user()->user_id }}";
        $(document).ready(function () {
            var currentValue = '';
            var dol = '';
            var cas = '';
            var anl = '';
            var lwp = '';
            var mat = '';
            var med = '';
            var adv = '';
            var sl = '';
            var sp_med = '';
            var hajj_pil = '';
            var mat_chk = '';
            var totalLeave = 0;
            var ck;
            var mgtStatus = $('.mgtStatus').val();
            // console.log('Employee Status = ',mgtStatus);


            //leave absent status
            var absentDateArr = new Array();
            <?php
            if(!empty($absentStatus)) {
            foreach($absentStatus as $as){?>
            absentDateArr.push('<?php echo $as->wk_date; ?>');
            <?php }
            }?>

            // console.log(absentDateArr);
            // console.log(absentDateArr.length);

            if(mgtStatus){
                if(logginUser === '500043'){
                    $("#btn_submit").prop("disabled",true);
                }else{
                    $("#btn_submit").prop("disabled",false);
                }
            }else{
                $("#btn_submit").prop("disabled",true);
            }

            $('.clockpicker').clockpicker({autoclose: true});
            $('.clockpicker2').clockpicker({autoclose: true});

            $('#date1').datepicker({
                format: "dd-M-yyyy",
                todayHighlight: 'TRUE',
                autoclose: true,
                minDate: 0,
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {
                $('#date2').val('');
            });
            $('#date2').datepicker({
                format: "dd-M-yyyy",
                todayHighlight: 'TRUE',
                autoclose: true,
                minDate: '0',
                maxDate: '+1Y+6M'
            }).on('changeDate', function (ev) {

                var d1 = $('#date1').datepicker('getDate');
                var d2 = $('#date2').datepicker('getDate');
                var diff = 0;
                if (d1 && d2) {
                    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                }
                // console.log(diff);
                if(diff <= 0){
                    swal({
                        type: 'error',
                        text: 'Second date must be equal or bigger than the first date.',
                    });
                    $('#date2').val('');
                    $('#dol').val('');
                }else{
                    $('#dol').val(diff);
                    $('#tol').val('');

                    if($('[name="plant_id"]').val() == '1100' || $('[name="plant_id"]').val() == '2100'){
                        var st_dt = $('#date1').datepicker('getFormattedDate');
                        if(st_dt != ''){
                            $.ajax({
                                type: "post",
                                url: "{{url('elm_portal/checkFacLeaveData')}}",
                                data: {'st_dt': st_dt,'plant_id':$('[name="plant_id"]').val(), '_token': '{{csrf_token()}}'},
                                success: function (data) {
                                    // console.log(data);
                                    if(data.status == 1){
                                        var holiday_cnt = data.holiday_cnt;
                                        var Ddiff = parseInt(diff)+parseInt(holiday_cnt);
                                        $('#dol').val(Ddiff);
                                        $('#cus_st_dt').val(data.frst_holiday);
                                        swal({
                                            type: 'warning',
                                            text: 'As you took your last leave right before the vacation, the holidays ' +
                                                'will be counted as leave except for Medical leave.' +
                                                ' There will be a total of '+Ddiff+' days of leave. ',
                                        });
                                    }else{
                                        $('#cus_st_dt').val("");
                                    }
                                },
                                error: function () {
                                    $('#cus_st_dt').val("");
                                    swal({
                                        type: 'error',
                                        text: 'Contact Your Administrator.!',
                                    });
                                }
                            });
                        }
                    }
                }
            });

            // for medical leave
            $('#row_dim').hide();
            $('.increment').hide();

            //for maternity leave
            $('#row_mtrn').hide();

            $('#lev_period').hide();
            $('#lev_time').hide();

            $(".rsp_emp").select2();

            $('#rsp_emp').on('change', function () {

                var emp_id = $('#rsp_emp').val();
                // $("#btn_submit").prop("disabled",true);

                $.ajax({
                    type: "get",
                    url: "{{url('elm_portal/getSelectEmp')}}",
                    data: {emp_id: emp_id, '_token': '{{csrf_token()}}'},
                    success: function (data) {
                        // console.log(data);
                        $('#rsp_emp_name').val(data[0].sur_name);
                        $('#rsp_emp_code').val(data[0].emp_id);
                        $('#rsp_desig_id').val(data[0].desig_id);
                        $('#rsp_desig').val(data[0].desig_name);
                        $('#rsp_dept_id').val(data[0].dept_id);
                        $('#rsp_dept_name').val(data[0].dept_name);
                        $('#rsp_cnt_no').val(data[0].contact_no);
                        $('#rsp_email').val(data[0].mail_address);
                        // $("#btn_submit").prop("disabled",false);

                        if($('#dol').val() !== "" && $('#tol').val() !== "" && $('#adl').val() !== "" && $('#pol').val() !== ""
                            && $('#rsp_emp').val() !== ""){
                            $('#btn_submit').prop('disabled', false);
                        }else{
                            $('#btn_submit').prop('disabled', true);
                        }
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Contact Your Administrator.!',
                        });
                    }
                });

            });

            $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                $("#success-alert").slideUp(500);
            });

            $('#tol').change(function () {
                if ($('#tol').val() === 'MEDICAL') {
                    if ($('#tol').val() === 'MEDICAL') {

                        $('#row_dim').show();
                        $('.increment').hide();
                        $('#row_mtrn').hide();

                        if($('[name="plant_id"]').val() == '1100' || $('[name="plant_id"]').val() == '2100'){
                            var d1 = $('#date1').datepicker('getDate');
                            var d2 = $('#date2').datepicker('getDate');
                            var diff = 0;
                            if (d1 && d2) {
                                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                            }
                            if(diff > 0){
                                $('#dol').val(diff);
                                $('#cus_st_dt').val("");
                            }else{
                                $('#dol').val('');
                                $('#cus_st_dt').val("");
                            }
                        }
                    } else {
                        $('#row_dim').hide();
                        $('#row_mtrn').hide();
                    }
                } else if ($('#tol').val() === 'SPECIAL MEDICAL') {
                    if ($('#tol').val() === 'SPECIAL MEDICAL') {
                        $('.increment').show();
                        $('#row_dim').hide();
                        $('#row_mtrn').hide();
                    } else {
                        $('.increment').hide();
                    }
                } else if ($('#tol').val() === 'MATERNITY') {
                    if ($('#tol').val() === 'MATERNITY') {
                        $('#row_mtrn').show();
                        $('.increment').hide();
                        $('#row_dim').hide();
                    } else {
                        $('#row_mtrn').hide();
                    }
                } else {
                    $('.increment').hide();
                    $('#row_dim').hide();
                    $('#row_mtrn').hide();
                }
                if($('#dol').val() !== "" && $('#tol').val() !== "" && $('#adl').val() !== "" && $('#pol').val() !== ""
                    && $('#rsp_emp').val() !== ""){
                    $('#btn_submit').prop('disabled', false);
                }else{
                    $('#btn_submit').prop('disabled', true);
                }
            });

            $(".btn-success").click(function () {
                var html = $(".clone").html();
                $(".increment").after(html);
            });

            $("body").on("click", ".btn-danger", function () {
                $(this).parents(".control-group").remove();
            });

            $("#chk_val").change(function () {
                var ischecked = $(this).is(':checked');
                // console.log("ischecked=", ischecked);
                if (!ischecked) {
                    $('#period').val("");
                    ck = $('#chk_val').val("0");
                    // console.log("Unchecked value = ", $('#chk_val').val());
                    $('#lev_period').hide();
                    $('#lev_time').hide();
                } else {
                    ck = $('#chk_val').val("1");
                    // console.log("Check value = ", $('#chk_val').val());
                    $('#lev_period').show();
                    $('#lev_time').show();
                }
            });

            $('#tol').on('change', function () {

                currentValue = $(this).val();
                if(currentValue === 'MEDICAL'){
                    if($('[name="plant_id"]').val() == '1100' || $('[name="plant_id"]').val() == '2100'){
                        var d1 = $('#date1').datepicker('getDate');
                        var d2 = $('#date2').datepicker('getDate');
                        var diff = 0;
                        if (d1 && d2) {
                            diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000) + 1; // ms per day
                        }
                        if(diff > 0){
                            $('#dol').val(diff);
                            $('#cus_st_dt').val("");
                        }else{
                            $('#dol').val('');
                            $('#cus_st_dt').val("");
                        }
                    }
                }
                dol = parseInt($('#dol').empty().val());
                cas = parseInt($('#cas').empty().val());
                anl = parseInt($('#anl').empty().val());
                lwp = parseInt($('#lwp').empty().val());
                mat = parseInt($('#mat').empty().val());
                med = parseInt($('#med').empty().val());
                adv = parseInt($('#adv').empty().val());
                sp_med = parseInt($('#sp_med').empty().val());
                hajj_pil = parseInt($('#hajj_pil').empty().val());

                if(isNaN(cas)) {cas = 0;}
                if(isNaN(anl)) {anl = 0;}
                if(isNaN(mat)) {mat = 0;}
                if(isNaN(lwp)) {lwp = 0;}
                if(isNaN(med)) {med = 0;}
                if(isNaN(adv)) {adv = 0; }
                if(isNaN(sp_med)) {sp_med = 0;}
                if(isNaN(hajj_pil)) {hajj_pil = 0;}

                // console.log('Annual', anl);
                // console.log('hajj_pil', hajj_pil);

                var mat_chk = $('#no_of_mat').val();
                // console.log(mat_chk);

                // $('#btn_submit').prop('disabled', false);

                if (currentValue === 'CASUAL') {
                    if (dol > 3) {
                        swal({
                            type: 'error',
                            text: 'Casual Leave Maximum 3 days at a time.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                    } else if (dol > cas) {
                        swal({
                            type: 'error',
                            text: 'Check Your Casual Leave Status.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                    }
                } else if (currentValue === 'ANNUAL') {
                    if (dol > anl) {
                        swal({
                            type: 'error',
                            text: 'Check Your Annual Leave Status.!',
                        });

                        $('#btn_submit').prop('disabled', true);
                    }
                } else if (currentValue === 'HAJJ') {
                    if (dol > hajj_pil) {
                        swal({
                            type: 'error',
                            text: 'Check your leave status for Hajj or Pilgrimage!',
                        });

                        $('#btn_submit').prop('disabled', true);
                    }
                    if (dol != 12){
                        swal({
                            type: 'error',
                            text: 'Leave for Hajj or Pilgrimage must be 12 days!',
                        });
                        return false;
                    }
                } else if (currentValue === 'COMPENSATION') {
                    swal({
                        type: 'error',
                        text: 'You are not eligible for this type of leave.',
                    });
                    $('#btn_submit').prop('disabled', true);

                } else if (currentValue === 'LWP') {
                    swal({
                        type: 'warning',
                        text: 'Please contact with your department head before applying.',
                    });
                    if (dol > lwp) {
                        swal({
                            type: 'error',
                            text: 'Check Your LWP Leave Status.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                    }
                }else if (currentValue === 'MATERNITY') {
                    if (dol > mat) {
                        swal({
                            type: 'error',
                            text: 'Check Your Maternity Leave Status.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                        return false;
                    } else if (mat_chk >= 2) {
                        swal({
                            type: 'error',
                            text: 'You have already 2 times take maternity leave.!'
                        });
                        $('#btn_submit').prop('disabled', true);
                        return false;
                    }
                } else if (currentValue === 'MEDICAL') {

                    var d1 = $('#date1').datepicker('getFormattedDate');
                    var d2 = $('#date2').datepicker('getFormattedDate');

                    var employees_id = $('#employee_id').val();

                    $.ajax({
                        url: "{{url('elm_portal/getSelectEmp')}}",
                        method: "GET",
                        data: {emp_id: employees_id}
                    })
                        .done(function (data) {

                            let v_plant_id = data[0].plant_id;

                            if ( data[0].plant_id !== '1100' && data[0].plant_id !== '2100' && data[0].plant_id !=='1300' && data[0].plant_id !=='1400' && data[0].plant_id !=='2200'  && data[0].plant_id !=='4100' && data[0].plant_id !=='5100') {
                                $.ajax({
                                    type: "get",
                                    url: "{{url('elm_portal/getHoliday')}}",
                                    data: {'st_dt': d1, 'en_dt': d2, 'plant_id' : v_plant_id},
                                    success: function (data) {
                                        totalLeave = dol - parseInt(data[0].holiday_cnt);
                                        if(!isNaN(totalLeave)) {
                                            $('#dol').empty().val(totalLeave);
                                        }else{
                                            $('#dol').empty().val('');
                                        }
                                        if (totalLeave > med) {
                                            swal({
                                                type: 'error',
                                                text: 'Check Your Medical Leave Status.!',
                                            });
                                            $('#btn_submit').prop('disabled', true);
                                            return false;
                                        }
                                    },
                                    error: function (e) {
                                        console.log(e);
                                    }
                                });
                            } else {
                                if (dol > med) {
                                    swal({
                                        type: 'error',
                                        text: 'Check Your Medical Leave Status.!',
                                    });
                                    $('#btn_submit').prop('disabled', true);
                                    return false;
                                }

                            }

                        })
                        .fail(function (xhr) {
                            console.log('error', xhr);
                        });
                } else if (currentValue === 'SL') {
                    if (dol > sl) {
                        swal({
                            type: 'error',
                            text: 'Check Your sl Leave Status.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                        return false;
                    }
                }else if (currentValue === 'ADVANCE') {
                    if (dol > adv) {
                        swal({
                            type: 'error',
                            text: 'Check Your Advance Leave Status.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                        return false;
                    }
                }
                else if (currentValue === 'SPECIAL MEDICAL') {
                    swal({
                        type: 'warning',
                        text: 'Please contact with your department head before applying.',
                    });
                    if (dol > sp_med) {
                        swal({
                            type: 'error',
                            text: 'Check Your Special Medical Leave Status.!',
                        });
                        $('#btn_submit').prop('disabled', true);
                        return false;
                    }
                }
            });

            $('input[type="text"]').keyup(function() {
                if($('#dol').val() !== "" && $('#tol').val() !== "" && $('#adl').val() !== "" && $('#pol').val() !== ""
                    && $('#rsp_emp').val() !== ""){
                    $('#btn_submit').prop('disabled', false);
                }else{
                    $('#btn_submit').prop('disabled', true);
                }
            });

            $('form#appfrm').submit(function () {

                var d1 = $('#date1').val();
                var d2 = $('#date2').val();
                var dol = $('#dol').val();

                if (absentDateArr.length > 0) {
                    var a = absentDateArr.indexOf(d1);
                    if (a === -1) {
                        swal({
                            type: 'error',
                            text: 'Please adjust first, your previous absent.!'
                        });
                        return false;
                    }
                }
                if (absentDateArr.length > 0) {
                    if (absentDateArr[0] !=  d1) {
                        swal({
                            type: 'error',
                            text: 'Please start adjusting your absent days from the beginning!'
                        });
                        return false;
                    }
                }
                if (currentValue === 'CASUAL') {
                    if (dol > 3) {
                        swal({
                            type: 'error',
                            text: 'Casual Leave Maximum 3 days at a time.!',
                        });
                        return false;
                    } else if (dol > cas) {
                        swal({
                            type: 'error',
                            text: 'Check Your Casual Leave Status.!',
                        });
                        return false;
                    }
                } else if (currentValue === 'ANNUAL') {
                    if (dol > anl) {
                        swal({
                            type: 'error',
                            text: 'Check Your Annual Leave Status.!',
                        });
                        return false;
                    }
                } else if (currentValue === 'HAJJ') {
                    if (dol > hajj_pil) {
                        swal({
                            type: 'error',
                            text: 'Check your leave status for Hajj or Pilgrimage!',
                        });
                        return false;
                    }
                    if (dol != 12){
                        swal({
                            type: 'error',
                            text: 'Leave for Hajj or Pilgrimage must be 12 days!',
                        });
                        return false;
                    }
                }else if (currentValue === 'COMPENSATION') {
                    swal({
                        type: 'error',
                        text: 'You are not eligible for this type of leave.',
                    });
                    $('#btn_submit').prop('disabled', true);
                    return false;
                }else if (currentValue === 'LWP') {
                    if (dol > lwp) {
                        swal({
                            type: 'error',
                            text: 'Check Your LWP Leave Status.!',
                        });
                        return false;
                    }
                } else if (currentValue === 'MATERNITY') {
                    if (dol > mat) {
                        swal({
                            type: 'error',
                            text: 'Check Your Maternity Leave Status.!',
                        });
                        return false;
                    } else if (mat_chk >= 2) {
                        swal({
                            type: 'error',
                            text: 'You have already 2 times take maternity leave.!'
                        });
                        return false;
                    }
                } else if (currentValue === 'MEDICAL') {
                    if (dol > med) {
                        swal({
                            type: 'error',
                            text: 'Check Your Medical Leave Status.!',
                        });
                        return false;
                    }
                    if(dol > 2){
                        if($('[name="plant_id"]').val() == '1100' || $('[name="plant_id"]').val() == '2100'){
                            if($('#medicalFile')[0].files.length == 0){
                                swal({
                                    type: 'error',
                                    text: 'Please Upload Medical file.',
                                });
                                return false;
                            }
                        }
                    }
                } else if (currentValue === 'SL') {
                    if (dol > sl) {
                        swal({
                            type: 'error',
                            text: 'Check Your sl Leave Status.!',
                        });
                        return false;
                    }
                } else if (currentValue === 'ADVANCE') {
                    if (dol > adv) {
                        swal({
                            type: 'error',
                            text: 'Check Your Advance Leave Status.!',
                        });
                        return false;
                    }
                } else if (currentValue === 'SPECIAL MEDICAL') {
                    if (dol > sp_med) {
                        swal({
                            type: 'error',
                            text: 'Check Your Special Medical Leave Status.!',
                        });
                        return false;
                    }
                }
            })


        });

        function validateForm() {
            var dt1 = document.forms["myForm"]["st_dt"].value;
            if (dt1 == "") {
                swal({
                    type: 'error',
                    text: 'Date must be filled out!',
                });
                return false;
            }
            var dt2 = document.forms["myForm"]["en_dt"].value;
            if (dt2 == "") {
                swal({
                    type: 'error',
                    text: 'Date must be filled out!',
                });
                return false;
            }
            var tol = document.forms["myForm"]["tol"].value;
            if (tol == "") {
                swal({
                    type: 'error',
                    text: 'Type of leave must be filled out!',
                });
                return false;
            }
            var adl = document.forms["myForm"]["adl"].value;
            if (adl == "") {
                swal({
                    type: 'error',
                    text: 'Address during leave must be filled out!',
                });
                return false;
            }
            var pol = document.forms["myForm"]["pol"].value;
            if (pol == "") {
                swal({
                    type: 'error',
                    text: 'Purpose of leave must be filled out!',
                });
                return false;
            }
            var rsp_emp = document.forms["myForm"]["rsp_emp"].value;
            if (rsp_emp == "") {
                swal({
                    type: 'error',
                    text: 'Responsible Person must be filled out!',
                });
                return false;
            }
            var dol = $('#dol').val();
            if(tol == 'MEDICAL'){
                if(dol > 2){
                    if($('[name="plant_id"]').val() == '1100' || $('[name="plant_id"]').val() == '2100'){
                        if($('#medicalFile')[0].files.length == 0){
                            swal({
                                type: 'error',
                                text: 'Please Upload Medical file.',
                            });
                            return false;
                        }
                    }
                }
            }
        }
    </script>
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


@endsection

