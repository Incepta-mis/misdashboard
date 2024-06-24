<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 10/8/2018
 * Time: 5:18 PM
 */
?>
@extends('_layout_shared._master')
@section('title','ELM Master Info')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
        }
        <style>
         .odd{
             background-color: #FFF8FB !important;
         }
        .even{
            background-color: #DDEBF8 !important;
        }
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        ELM Master Info
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="comp"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Company</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="comp" name="comp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled>Select Company</option>
                                                    @foreach($com as $c)
                                                        <option value="{{$c->com_id}}">{{$c->com_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant" name="plant"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Plant</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Department</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="dept" name="dept"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Department</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6">
                                            <label for="emp" class="col-md-2 col-sm-2 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee</b></label>
                                            <div class="col-md-10 col-sm-10">
                                                <select id="emp" name="emp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Employee</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for="valid" class="col-md-2 col-sm-2 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Valid</b></label>
                                            <div class="col-md-10 col-sm-10">
                                                <select id="valid" name="valid" class="form-control input-sm
                                                filter-option pull-left">
                                                    <option value="All" selected>All</option>
                                                    <option value="YES">YES</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="button" id="btn_submit" class="btn btn-warning btn-sm">
                                        <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                </div>
                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                    <div id="export_buttons">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                         alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th>EMP ID</th>
                                    <th>RECOMMENDED_BY</th>
                                    <th>APPROVED_BY</th>
                                    <th>HR_OFFICER</th>
                                    <th>HR_OFFICER1</th>
                                    <th>HR_OFFICER2</th>
                                    <th>HEAD_OF_HR</th>
                                    <th>CONTACT_NO</th>
                                    <th>MAIL_ADDRESS</th>
                                    <th>MGT_STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ELM Master Data</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="elm_emp" method="get">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="plant_id">Plant Id:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="plant_id" id="plant_id" placeholder="Enter Plant ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="e_id">Emp Id:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm"  name="e_id" id="e_id" placeholder="Enter Employee ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="ename">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm"  name="ename" id="ename" placeholder="Enter Employee Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="desig">Designation:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm"  name="desig" id="desig" placeholder="Enter Designation">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="p_grp">P. Group:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm"  name="p_grp" id="p_grp" placeholder="Enter Group">
                                <p class="help-block"><span class="text-danger">if not product group please type: NA</span></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="terr_id">Terr ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm"  name="terr_id" id="terr_id" placeholder="Enter Territory">
                                <p class="help-block"><span class="text-danger">if not terr id please type: NA</span></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="rpt_sup">RCM. Id:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="rpt_sup" id="rpt_sup" placeholder="Enter Recommended By Employee ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="appr_id">APPR. Id:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="appr_id" id="appr_id" placeholder="Enter Approved By Employee ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hr_id1">HR Off1:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="hr_id1" id="hr_id1" placeholder="Enter HR Officer Employee ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hr_id2">HR Off2:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="hr_id2" id="hr_id2" placeholder="Enter HR Officer Employee ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hr_id3">HR Off3:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="hr_id3" id="hr_id3" placeholder="Enter HR Officer Employee ID">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hr_head">HR Head:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="hr_head" id="hr_head" placeholder="Enter Head Of HR">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="mobile">Mobile :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="mobile" id="mobile" placeholder="Enter Mobile Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="email" id="email" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="urole">URole:</label>
                            <div class="col-sm-10">
                                <select class="form-control input-sm" id="urole" name="urole">
                                    <option selected disabled>Select Role</option>
                                    <option value="60">ELM NON-MANAGEMENT</option>
                                    <option value="15">ELM GENERAL PEOPLE</option>
                                    <option value="16">ELM SUPERVISOR / RECOMMENDED BY</option>
                                    <option value="17">ELM DEPT HEAD / APPROVED BY</option>
                                    <option value="20">ELM RECOMMENDED BY and APPROVED BY</option>
                                    <option value="18">ELM HR HEAD</option>
                                    <option value="19">ELM PLANT HEAD</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info" id="elm_btn">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div> -->
            </div>

        </div>
    </div>
    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    <script type="text/javascript">
        $(document).ready(function () {

            //Changing company from option
            $('#comp').change(function () {
                $('#plant').empty();
                $('#dept').empty();
                $('#emp').empty();
                $('#plant').append($('<option></option>').html('Loading...'));

                var comp_id = $('#comp').val();
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('elm_portal/get_plant_id') !!}',
                    data: {'c_id': comp_id},
                    success: function (data) {
                        // console.log(data.plant);
                        var op = '';
                        op += '<option value="0" selected disabled>Select Plant</option>';
                        for (var i = 0; i < data.plant.length; i++) {
                            op += '<option value="' + data.plant[i]['plant_id'] + '">' + data.plant[i]['plant_name'] + '</option>';
                        }
                        $('#plant').html(" ");
                        $('#plant').append(op);
                    },
                    error: function () {

                    }
                });
            });

            // Changing plant option started here
            $('#plant').change(function () {
                $('#dept').empty();
                $('#emp').empty();
                $('#dept').append($('<option></option>').html('Loading...'));

                var plant_id = $('#plant').val();
                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('elm_portal/get_dept') !!}',
                    data: {'plant_id': plant_id},
                    success: function (data) {
                        // console.log(data.dept);
                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.dept.length; i++) {
                                op += '<option value= " ' + data.dept[i]['dept_id'] + ' ">' + data.dept[i]['dept_name'] + '</option>';
                            }
                            $('#dept').html(" ");
                            $('#dept').append(op);

                        }
                        else {
                            $('#dept').html(" ");
                            $('#dept').append('<option value="0" selected disabled>No Department available in this Category</option>');
                            // console.log("no data found");
                        }
                    },
                    error: function () {
                    }
                });
            });

            // Changing Dept option started here
            $('#dept').change(function () {
                $('#emp').empty().append($('<option></option>').html('Loading...'));
                var dept_id = $('#dept').val();

                // console.log('dept_id',dept_id);

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('elm_portal/getDeptEmp') !!}',
                    data: {'dept_id': dept_id},
                    success: function (data) {
                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Employees</option>';
                            em += '<option value="All">All</option>'
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['emp_id'] + ' ">' + data[i]['emp_id'] + '-' + data[i]['sur_name'] + '</option>';
                            }
                            $('#emp').html(" ");
                            $('#emp').append(em);

                        }
                        else {
                            $('#emp').html(" ");
                            $('#emp').append('<option value="0" selected disabled>No Employee available in this Category</option>');
                            // console.log("no data found");
                        }
                    },
                    error: function () {
                    }
                });

            });

            $('#btn_submit').on('click', function (e) {
                // e.preventDefault();
                $("#loader").show();
                var pl = $('#plant').val();
                var dpt = $('#dept').val();
                var emp = $('#emp').val();
                var valid = $('#valid').val();
                // console.log('Submit button Clicked', pl, dpt, emp);
                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{!! URL::to('elm_portal/getElmMasterInfo') !!}',
                    data: {'dept_id': dpt, 'plant_id': pl, 'emp_id': emp, 'valid':valid, '_token': "{{ csrf_token()
                    }}"},
                    success: function (data) {

                        $("#showTable").show();
                        $("#loader").hide();

                        $("#elr").DataTable().destroy();
                        table = $("#elr").DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: '<button class="btn btn-success btn-xs" type="button"><i class="fa fa-plus"></i> Add </button>',
                                    action: function ( e, dt, node, config ) {
                                        $("#myModal").modal('show');
                                    }
                                }
                            ],
                            data: data,
                            columns: [
                                {data: "emp_id"},
                                {data: "report_supervisor" , className:"editable"},
                                {data: "head_of_dept" , className:"editable"},
                                {data: "hr_officer" , className:"editable"},
                                {data: "hr_officer1" , className:"editable"},
                                {data: "hr_officer2" , className:"editable"},
                                {data: "head_of_hr" , className:"editable"},
                                {data: "contact_no" , className:"editable"},
                                {data: "mail_address" , className:"editable"},
                                {data: "mgt_status" , className:"editable"}
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: false,
                            filter: true
                        });


                        table.fixedHeader.enable();
                        new $.fn.dataTable.Buttons(table, {
                            buttons: [
                                {
                                    extend: 'collection',
                                    text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                    buttons: [
                                        {
                                            extend: 'excel',
                                            text: 'Save As Excel',
                                            footer: true,
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }, {
                                            extend: 'pdf',
                                            text: 'Save As PDF',
                                            orientation: 'landscape',
                                            footer: true,
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'PDF';
                                                $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }
                                    ],
                                    className: 'btn btn-sm btn-primary'
                                }
                            ]
                        }).container().appendTo($('#export_buttons'));

                    },
                    error: function (e) {
                        console.log(e);
                        $("#loader").hide();
                        $("#showTable").show();
                    }
                });

            });


            // Inline editing
            var oldValue = null;
            var emp_id   = null;
            var colName  = null;
            $(document).on('dblclick', '.editable', function(){

                oldValue = $(this).html();
                $(this).removeClass('editable');    // to stop from making repeated request
                $(this).html('<input type="text" style="width:150px;" class="update" value="'+ oldValue +'" />');
                $(this).find('.update').focus();

                emp_id  = $(this).parent().find('td').html().trim();
                clcolName = $('#elr thead tr th').eq($(this).index()).html().trim();

                // alert('Data:'+$(this).html().trim());
                // alert('Row:'+$(this).parent().find('td').html().trim());
                // alert('Column:'+$('#elr thead tr th').eq($(this).index()).html().trim());

            });

            var newValue = null;
            $(document).on('blur', '.update', function(){
                var elem    = $(this);
                newValue    = $(this).val();
                empId       = emp_id;
                colName     = clcolName;

                // var empId    = $(this).parent().attr('id');
                // var colName  = $(this).parent().attr('name');
                // console.log(elem,'-',empId,'-',colName);

                if(newValue != oldValue)
                {
                    $.ajax({
                        url : '{{ url("elm_portal/elmUpmasterInfo") }}',
                        method : 'post',
                        data :
                            {
                                empId    : empId,
                                colName  : colName,
                                newValue : newValue,
                                '_token' : '{{csrf_token()}}',
                            },
                        success : function(respone)
                        {
                            // console.log('Update Value = ',respone);
                            $(elem).parent().addClass('editable');
                            $(elem).parent().html(newValue);
                        }
                    });
                }
                else
                {
                    $(elem).parent().addClass('editable');
                    $(this).parent().html(newValue);
                }
            });
            // end inline editing
            jQuery('.toggle-btn').click(function () {
                table.fixedHeader.enable();
            });
        });

        $(function() {
            $('#elm_btn').on('click',function(e){
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ url('elm_portal/insElmMasterInfo') }}",
                    data: $('#elm_emp').serialize(),
                    success: function(response) {
                        // alert(response.success);
                        if(response.success){
                            toastr.success(response.success, '', {timeOut: 5000});
                            $('input[type="text"], textarea').val('');
                            $('#myModal').modal('hide');
                        }else{
                            toastr.error(response.error, '', {timeOut: 5000});
                        }
                    },
                    error: function() {
                        toastr.error(response.error, '', {timeOut: 5000});
                        alert('Error');
                    }
                });
                return false;
            });
        });
    </script>
@endsection