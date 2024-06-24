@extends('_layout_shared._master')
@section('title','Factory Managers Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>

        .swal2-icon.swal2-warning {
            font-size: 14px;
        }

        .swal2-html-container{
            font-size: 1.5em !important;
        }
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
        .odd{
            background-color: #FFF8FB !important;
        }
        .even{
            background-color: #DDEBF8 !important;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }
    </style>
@endsection
@section('right-content')

    {{-- Filter Option--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        View Employee Extention Information
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
                                                   style="padding-right:0px;"><b>Company:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="comp" name="comp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled>Select Company</option>
                                                    @foreach($companyData as $c)
                                                        <option value="{{$c->sap_com_id}}">{{$c->com_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant" name="plant"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Plant</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Department:</b></label>
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
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee:</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="emp" name="emp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Employee</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_submit" class="btn btn-warning btn-sm" disabled="disabled">
                                                    <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">
                                                </div>
                                            </div>
                                        </div>

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

    {{--show datatable--}}
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                <thead style="background-color: #454790; color: white;">
                                <tr>
                                    <th>Company Code</th>
                                    <th>Company Name</th>
                                    <th>Department ID</th>
                                    <th>Department Name</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>PABX Number</th>
                                    <th>IP Number</th>
                                    <th>Plant ID</th>
                                    <th>Plant Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>

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

    {{--Modal for update--}}
    <div id="editTypeSubtypeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Item</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="edit_comp_code" class="control-label col-sm-2">Company Code.:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_comp_code" value="" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_comp_name" class="control-label col-sm-2">Company Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_comp_name" value="" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="edit_dept_name" class="control-label col-sm-2">Department Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_dept_name" value="" disabled="disabled">
                            </div>


                            {{--
                             <label for="edit_dept_name" class="control-label col-sm-2"
                                    style="padding-right:0px;">Department Name:<span class='cls-req'>*</span></label>
                             <div class="col-md-9 col-sm-9">
                                 <select id="edit_dept_name" name="edit_dept_name"
                                         class="form-control input-sm filter-option pull-left">
                                     <option value="">Select Dept</option>
                                 </select>
                             </div>--}}
                        </div>

                        <div class="form-group">
                            <label for="edit_emp_name" class="control-label col-sm-2">Employee Name:<span class='cls-req'>*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="edit_emp_name" value="" disabled="disabled">
                            </div>

                            {{-- <label for="edit_emp_name" class="control-label col-sm-2"
                                    style="padding-right:0px;">Employee Name:<span class='cls-req'>*</span></label>
                             <div class="col-md-9 col-sm-9" >
                                 <select disabled="disabled" id="edit_emp_name" name="edit_emp_name"
                                         class="form-control input-sm filter-option pull-left">
                                     <option value="">Select Emmnuhoiuolipoiployee</option>
                                 </select>
                             </div>--}}
                        </div>

                        <div class="form-group">
                            <label for="edit_pabx_num" class="control-label col-sm-2">PABX Number:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_pabx_num" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_ip_num" class="control-label col-sm-2">IP Number:</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" class="form-control" id="edit_ip_num" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="update_emp_ext">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                        <input type="hidden"  id="table_id">
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{--  Employee Form--}}
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <label class="text-default">
                                    Employee Extention Information
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="panel-body" style="padding-top: 2%">
                        <div style="color: red;font-weight: bold">
                            <p>*(Fields are required)</p>
                        </div>
                    </div>
                    <form action="#" method="post" id="item_issue_form">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">Employee Name<span class='cls-req'>*</span></th>
                                    <th class="text-center">Company Name<span class='cls-req'>*</span></th>
                                    <th class="text-center">Company Code<span class='cls-req'>*</span></th>
                                    <th class="text-center">Plant Name</th>
                                    <th class="text-center">Plant Id</th>
                                    <th class="text-center">Department Name</th>
                                    <th class="text-center">Department ID</th>
                                    <th class="text-center">PABX Number</th>
                                    <th class="text-center">IP Number</th>
                                </tr>


                                </thead>
                                <tbody id="tbody">
                                <tr>
                                    <td>
                                        <select id="employee_name_form" name="employee_name_form" class="form-control input-sm filter-option">
                                            <option selected disabled>Select Employee</option>
                                            @foreach($allEmp as $allEmps)
                                                <option value="{{$allEmps->emp_id}}">{{$allEmps->emp_id}}-{{$allEmps->sur_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>

                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="company_name_form"
                                               placeholder="" name="company_name_form" min="1" value="{{$companyData[0]->com_name}}" readonly>

                                    </td>

                                    <td>

                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="company_code_form" placeholder="" name="company_code_form" min="1"
                                               value="{{$companyData[0]->sap_com_id}}" readonly>

                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                   class="form-control input-xs" id="plant_name_form" min="1"
                                                   placeholder="" name="plant_name_form" readonly>

                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                   class="form-control input-xs" id="plant_id_form" min="1"
                                                   placeholder="" name="plant_id_form" readonly>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group">
                                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                                   class="form-control input-xs" id="dept_name_form" min="1"
                                                   placeholder="" name="dept_name_form" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="dept_id_form"
                                               placeholder="" name="dept_id_form" min="1" readonly>
                                    </td>

                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="pabx_number" min="1"
                                               placeholder="" name="pabx_number" >
                                        <div id="pr_qty_div"></div>
                                    </td>
                                    <td>
                                        <input type="number" onkeyup="this.value = this.value.toUpperCase();"
                                               class="form-control input-xs" id="ip_number"
                                               placeholder="" name="ip_number"  min="1">
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <input type="button" class="btn btn-info"  id="submit_form" value="submit">
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection

@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

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
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            //Form Info//
            $('#employee_name_form').select2();

            $('#employee_name_form').change(function () {

                var employee_id = $('#employee_name_form').val();
                

                $.ajax({
                    type: 'get',
                    url: '{{  url('employeeExtention/getEmpInfo') }}',
                    data: {'employee_id': employee_id},
                    success: function (data) {

                        

                        if(data.allEmpData.length > 0){

                            $('#plant_name_form').val(data.allEmpData[0].plant_name);
                            $('#plant_id_form').val(data.allEmpData[0].plant_id);
                            $('#dept_id_form').val(data.allEmpData[0].dept_id);
                            $('#dept_name_form').val(data.allEmpData[0].dept_name);

                            /*
                                                        $('#plant_name_form').attr('readonly', true);
                                                        $('#plant_id_form').attr('readonly', true);
                                                        $('#dept_id_form').attr('readonly', true);
                                                        $('#dept_name_form').attr('readonly', true);
                            */
                        }else{
                            /* $('#plant_name_form').html("");
                             $('#plant_name_form').append('<option value="0" selected disabled>No Plant available in this Category' +
                                 '</option>');*/
                        }
                    },
                    error: function () {
                    }
                });
            });

            $('#submit_form').on('click', function (e) {
                e.preventDefault();
            
                
                $("#loader").show();


                
                
                var company_name = $('#company_name_form').val();
                var company_code = $('#company_code_form').val();


                var plant_name = $('#plant_name_form').val();
                var plant_id = $('#plant_id_form').val();


                var dept_id = $('#dept_id_form').val();
                var dept_name = $('#dept_name_form').val();


                var employee_name_full =  $('#employee_name_form :selected').text();
                var temp = employee_name_full.split("-");
                var employee_name = temp[1];


                var employee_id = $('#employee_name_form').val();


                var pabx_number = $('#pabx_number').val();
                var ip_number = $('#ip_number').val();

                var employeeList = {};

                employeeList.company_code=company_code;
                employeeList.company_name=company_name;

                employeeList.plant_name=plant_name;
                employeeList.plant_id=plant_id;

                employeeList.department_id=dept_id;
                employeeList.department_name=dept_name;

                employeeList.employee_name=employee_name;
                employeeList.employee_id=employee_id;

                employeeList.pabx_number=pabx_number;
                employeeList.ip_number=ip_number;


                var employeeObject = JSON.stringify(employeeList);

                if(employee_name_full==''||employee_name_full=='Select Employee')
                {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Please Select an Employee!!',
                        icon: 'warning',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    })

                    $("#loader").hide();
                    return 0;
                }else{

                    $.ajax({
                        type: 'post',
                        url: '{{  url('employeeExtention/saveEmployee') }}',
                        data: { 'employeeObject': employeeObject, '_token': "{{ csrf_token
                    () }}"},
                        success: function (data) {


                            $("#loader").hide();

                            if(data.result=='exists'){

                                Swal.fire({
                                    title: 'Warning!',
                                    text: 'Opps!!..Employee Already Exists..',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })

                            }else if(data.result=='success'){
                                Swal.fire({

                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item saved successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'

                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                                $("#item_issue_form").trigger('reset');
                                item_id = $('#item_id').val('');

                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Failed to save.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            console.log("in error")
                        }
                    });
                }
            });

            $('#comp').select2();
            $('#plant').select2();
            $('#dept').select2();
            $('#emp').select2();
            //Changing company from option
            $('#comp').change(function () {

                $('#plant').empty();
                $('#dept').empty();
                $('#emp').empty();
                $('#plant').append($('<option></option>').html('Loading...'));

                var comp_id = $('#comp').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('employeeExtention/getPlant') }}',
                    data: {'c_id': comp_id},
                    success: function (data) {

                        if(data.plant.length > 0){
                            var op = '';
                            op += '<option value="0" selected disabled>Select Plant</option>';
                            for (var i = 0; i < data.plant.length; i++) {
                                op += '<option value="'+ data.plant[i]['plant_id'] +'">' + data.plant[i]['plant_name'] + '</option>';
                            }
                            $('#plant').html("");
                            $('#plant').append(op);
                        }else{
                            $('#plant').html("");
                            $('#plant').append('<option value="0" selected disabled>No employee tagged under any ' +
                                'plant of the selected company.' +
                                'Category</option>');
                        }
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
                    url: '{{  url('employeeExtention/getDept') }}',
                    data: {'plant_id': plant_id},
                    success: function (data) {
                        

                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.dept.length; i++) {
                                op += '<option value= "'+ data.dept[i]['department_id'] +'">' + data.dept[i]['department_name'] + '</option>';
                            }
                            $('#dept').html("");
                            $('#dept').append(op);

                        }
                        else {
                            $('#dept').html("");
                            $('#dept').append('<option value="0" selected disabled>No employee tagged under any ' +
                                'department of the selected plant. ' +
                                'Category</option>');
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
                var pl = $('#plant').val();

                $.ajax({
                    type: 'get',
                    url: '{{  url('employeeExtention/getDeptEmpDatas') }}',
                    data: {'dept_id': dept_id, 'plant_id':pl},
                    success: function (data) {


                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Employees</option>';
                            em += '<option value="All">All</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['employee_id'] + ' ">' + data[i]['employee_name'] + '</option>';
                            }
                            $('#emp').html("");
                            $('#emp').append(em);
                            $('#btn_submit').removeAttr("disabled");
                        }
                        else {
                            $('#emp').html("");
                            $('#emp').append('<option value="0" selected disabled>No Employee available in this Category</option>');
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

                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{{  url('employeeExtention/getFacManagerData') }}',
                    data: { 'plant_id': pl, 'dept_id':dpt, 'emp_id': emp, '_token': "{{ csrf_token
                    () }}"},
                    success: function (data) {
                        
                        
                        $("#showTable").show();
                        $("#loader").hide();

                        $("#elr").DataTable().destroy();

                        table = $("#elr").DataTable({

                            data: data,
                            columns: [
                                {data: "company_code"},
                                {data: "company_name"},
                                {data: "department_id"},
                                {data: "department_name"},
                                {data: "employee_id"},
                                {data: "employee_name"},
                                {data: "pabx_number"},
                                {data: "ip_number"},
                                {data: "plant_id"},
                                {data: "plant_name"},

                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="editThisRecord('+"'"+row.id+"','"+row.company_code+"','"+row.company_name+"','"+row.department_id+"','"
                                            +row.department_name+"','"+row.employee_id+"','"+row.employee_name+"','"+row.pabx_number+"','"+row.ip_number+"','"+row.plant_id+"','"+row.plant_name+"')"+'">EDIT</button>'
                                    }
                                },

                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="deleteThisRecord('+"'"+row.id+"','"+row.company_code+"')"+'">DELETE</button>'
                                    }
                                },
                            ],
                            columnDefs: [
                                {
                                    "defaultContent": " ",
                                    "targets": "_all"
                                }
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: false,
                            filter: true,

                            select: {
                                style: 'os',
                                selector: 'td:first-child'
                            }
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
                                            exportOptions: {
                                                columns: [0, 1, 2, 3, 4,5,6,7]
                                            },
                                            action: function (e, dt, node, config) {
                                                exportExtension = 'Excel';
                                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                            }
                                        }, {
                                            extend: 'pdf',
                                            text: 'Save As PDF',
                                            orientation: 'landscape',
                                            footer: true,
                                            exportOptions: {
                                                columns: [0, 1, 2, 3, 4,5,6,7]
                                            },
                                            customize : function(doc){
                                                doc.content[1].table.widths =
                                                    Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                            },
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


            //Update Record
            $("#update_emp_ext").on('click',function (){

                var table_id= $("#table_id").val();

                /*  var edit_comp_code =  $("#edit_comp_code").val();
                  var edit_comp_name = $("#edit_comp_name").val();
  
                  var edit_dept_id = $('#edit_dept_name').val();
  
                  var edit_dept_name = $('#edit_dept_name').find(":selected").text();
  
                  var edit_emp_id = $('#edit_emp_name').val();
                  var edit_emp_name =$('#edit_emp_name').find(":selected").text();*/

                var edit_pabx_num  = $("#edit_pabx_num").val();
                var edit_ip_num  = $("#edit_ip_num").val();

                var employeeList = {};

                /*employeeList.company_code=edit_comp_code;
                employeeList.company_name=edit_comp_name;

                employeeList.department_id=edit_dept_id;
                employeeList.department_name=edit_dept_name;

                employeeList.employee_name=edit_emp_name;
                employeeList.employee_id=edit_emp_id;*/

                employeeList.pabx_number=edit_pabx_num;
                employeeList.ip_number=edit_ip_num;

                var itemArrayData = JSON.stringify(employeeList)
                
                // console.log(itemArrayData);

                // if(edit_pabx_num==''||edit_ip_num=='') {

                //     Swal.fire({
                //         title: 'Warning!',
                //         text: 'Please Input Required Field',
                //         icon: 'warning',
                //         showConfirmButton: true,
                //         confirmButtonText: 'Ok'
                //     })
                //     return 0;
                // }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('employeeExtention/updateEmpExtData') }}',
                        data: { 'id':table_id, 'itemArray':itemArrayData, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            console.log("in update Success")

                            if(data.result == 1 || data.result == "success"){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been updated Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }
                        },
                        error: function (e) {

                            console.log(e);

                        }
                    });
                // }
            })
        });

        function deleteThisRecord(id,company_code){

            console.log(id);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete  it!'
            }).then((result) => {
                
                if (result.isConfirmed) {
                    

                    $.ajax({
                        type: 'delete',
                        url: '{{  url('employeeExtention/deleteEmpExtRecord') }}',
                        data: { 'id':id,'company_code':company_code, '_token': "{{ csrf_token () }}"},
                        success: function (data) {

                            if(data.status == "success"){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Item has been deleted Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Delete',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }
                        },

                        error: function (e) {

                            console.log(e);
                        }
                    });
                }
            })
        }


        function editThisRecord(id,company_code,company_name,department_id,department_name,employee_id,employee_name,pabx_number,ip_number,plant_id,plant_name){
            $("#table_id").val(id);

            if(company_code=='null'){
                $("#edit_comp_code").val("");
            }else{
                $("#edit_comp_code").val(company_code);
            }

            if(company_name=='null'){
                $("#edit_comp_name").val("");
            }else{
                $("#edit_comp_name").val(company_name);
            }

            if(department_name=='null'){
                $("#edit_dept_name").val("");
            }else{
                $("#edit_dept_name").val(department_name);
            }

            if(employee_name=='null'){
                $("#edit_emp_name").val("");
            }else{
                $("#edit_emp_name").val(employee_name);
            }

            if(pabx_number=='null'){
                $("#edit_pabx_num").val("");
            }else{
                $("#edit_pabx_num").val(pabx_number);
            }

            if(ip_number=='null'){
                $("#edit_ip_num").val("");
            }else{
                $("#edit_ip_num").val(ip_number);
            }

            $.ajax({
                type: 'get',
                url: '{{  url('employeeExtention/getDept') }}',
                data: {'plant_id': plant_id},
                success: function (data) {
                    
                    if ((data.dept.length) > 0) {
                        var op = '';
                        op += '<option value="0" selected disabled>Select Department</option>';
                        for (var i = 0; i < data.dept.length; i++) {
                            op += '<option value= "'+ data.dept[i]['department_id'] +'">' + data.dept[i]['department_name'] + '</option>';
                        }
                        $('#edit_dept_name').html("");
                        $('#edit_dept_name').append(op);
                    }
                    else {
                        $('#edit_dept_name').html("");
                        $('#edit_dept_name').append('<option value="0" selected disabled>No employee tagged under any ' +
                            'department of the selected plant. ' +
                            'Category</option>');
                      
                    }
                },
                error: function () {
                }
            });

            $('#edit_dept_name').change(function () {
                var dept_id = $("#edit_dept_name option:selected").val();
                var pl = plant_id;

                $.ajax({
                    type: 'get',
                    url: '{{  url('employeeExtention/getDeptEmpDatas') }}',
                    data: {'dept_id': dept_id, 'plant_id':pl,'_token': "{{ csrf_token() }}"},
                    success: function (data) {
                       

                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Employees</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= "'+ data[i]['employee_id'] +'">' + data[i]['employee_id'] + '-' + data[i]['employee_name'] + '</option>';
                            }
                            $("#edit_emp_name").prop("disabled", false);
                            $('#edit_emp_name').html("");
                            $('#edit_emp_name').append(em);

                        }
                        else {
                            $('#edit_emp_name').html("");
                            $('#edit_emp_name').append('<option value="0" selected disabled>No Employee available in this Category</option>');
                        }
                    },
                    error: function () {
                    }
                });
            });
            $("#editTypeSubtypeModal").modal('show');
        }

    </script>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection