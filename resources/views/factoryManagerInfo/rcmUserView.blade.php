@extends('_layout_shared._master')
@section('title','Factory Recommended User Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>

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
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Factory Recommended User Information
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
                                                    @foreach($companyData as $c)
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
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="button" id="btn_submit" class="btn btn-warning btn-sm" disabled="disabled">
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
                                <thead style="background-color: darkkhaki;">
                                <tr>
                                    <th>PLANT NAME</th>
                                    <th>EMP ID</th>
                                    <th>NAME</th>
                                    <th>DESIGNATION</th>
                                    <th>VALID</th>
                                    <th></th>
                                    <th></th>
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
    <div id="createModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Factory Recommended User Data Insert</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="fac_manger_data" method="get">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="sel_company" class="control-label col-sm-2" >Company:</label>
                            <div class="col-sm-10">
                                <select id="sel_company" name="sel_company" class="form-control input-sm filter-option">
                                    <option selected disabled>Select Company</option>
                                    @foreach($companyData as $c)
                                        <option value="{{$c->com_id}}">{{$c->com_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_plant" class="control-label col-sm-2" >Plant:</label>
                            <div class="col-sm-10">
                                <select id="sel_plant" name="sel_plant" class="form-control input-sm filter-option">
                                    <option value="">Select Plant</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_dept" class="control-label col-sm-2" >Department:</label>
                            <div class="col-sm-10">
                                <select id="sel_dept" name="sel_dept" class="form-control input-sm filter-option">
                                    <option value="">Select Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_emp" class="control-label col-sm-2" >Employee:</label>
                            <div class="col-sm-10">
                                <select id="sel_emp" name="sel_emp" class="form-control input-sm filter-option">
                                    <option value="">Select Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="emp_name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="emp_name" id="emp_name" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="emp_desig">Designation:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control input-sm" name="emp_desig" id="emp_desig" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info" id="Create_btn" disabled="disabled">Create</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            $('#comp').select2();
            $('#plant').select2();
            $('#dept').select2();
            $('#emp').select2();
            $('#sel_company').select2();
            $('#sel_plant').select2();
            $('#sel_dept').select2();
            $('#sel_emp').select2();

            //changing modal data
            $('#sel_company').change(function () {

                $('#sel_plant').empty();
                $('#sel_dept').empty();
                $('#sel_emp').empty();
                $('#sel_plant').append($('<option></option>').html('Loading...'));

                var sel_comp_id = $('#sel_company').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getAllPlants') }}',
                    data: {'sel_comp_id': sel_comp_id},
                    success: function (data) {
                        if(data.allPlants.length > 0){
                            var op = '';
                            op += '<option value="0" selected disabled>Select Plant</option>';
                            for (var i = 0; i < data.allPlants.length; i++) {
                                op += '<option value="' + data.allPlants[i]['plant_id'] + '">' + data.allPlants[i]['plant_name'] + '</option>';
                            }
                            $('#sel_plant').html("");
                            $('#sel_plant').append(op);
                        }else{
                            $('#sel_plant').html("");
                            $('#sel_plant').append('<option value="0" selected disabled>No Plant available in this Category' +
                                '</option>');
                        }
                    },
                    error: function () {

                    }
                });
            });
            $('#sel_plant').change(function () {
                $('#sel_dept').empty();
                $('#sel_emp').empty();
                $('#sel_dept').append($('<option></option>').html('Loading...'));

                var sel_plant_id = $('#sel_plant').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getAllDepts') }}',
                    data: {'sel_plant_id': sel_plant_id},
                    success: function (data) {
                        if ((data.allDepts.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.allDepts.length; i++) {
                                op += '<option value= " ' + data.allDepts[i]['dept_id'] + ' ">' + data.allDepts[i]['dept_name'] + '</option>';
                            }
                            $('#sel_dept').html("");
                            $('#sel_dept').append(op);

                        }
                        else {
                            $('#sel_dept').html("");
                            $('#sel_dept').append('<option value="0" selected disabled>No Department available in ' +
                                'this ' +
                                'Category</option>');
                            // console.log("no data found");
                        }
                    },
                    error: function () {
                    }
                });
            });
            $('#sel_dept').change(function () {
                $('#sel_emp').empty().append($('<option></option>').html('Loading...'));

                var sel_dept_id = $('#sel_dept').val();
                var sel_pl = $('#sel_plant').val();

                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getOtherDeptEmpData') }}',
                    data: {'sel_dept_id': sel_dept_id, 'sel_pl':sel_pl},
                    success: function (data) {
                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Employees</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['emp_id'] + ' ">' + data[i]['emp_id'] + '-' + data[i]['sur_name'] + '</option>';
                            }
                            $('#sel_emp').html("");
                            $('#sel_emp').append(em);
                        }
                        else {
                            $('#sel_emp').html("");
                            $('#sel_emp').append('<option value="0" selected disabled>No Employee available in this Category</option>');
                            // console.log("no data found");
                        }
                    },
                    error: function () {
                    }
                });
            });
            $('#sel_emp').change(function () {
                $('#emp_name').val('Loading...');
                $('#emp_desig').val('Loading...');

                var selemp_id = $('#sel_emp').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getEmployeeDataByID') }}',
                    data: {'selemp_id': selemp_id},
                    success: function (data) {
                        if(data.emp.length > 0){
                            var sur_name = data.emp[0]['sur_name'];
                            var desig = data.emp[0]['desig'];

                            $("#emp_name").val(sur_name);
                            $("#emp_desig").val(desig);

                            $('#Create_btn').removeAttr("disabled");
                        }
                    },
                    error: function () {
                    }
                });
            });

            //Changing company from option
            $('#comp').change(function () {

                $('#plant').empty();
                $('#dept').empty();
                $('#emp').empty();
                $('#plant').append($('<option></option>').html('Loading...'));

                var comp_id = $('#comp').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getRCMPlants') }}',
                    data: {'c_id': comp_id},
                    success: function (data) {
                        if(data.plant.length > 0){
                            var op = '';
                            op += '<option value="0" selected disabled>Select Plant</option>';
                            for (var i = 0; i < data.plant.length; i++) {
                                op += '<option value="' + data.plant[i]['plant_id'] + '">' + data.plant[i]['plant_name'] + '</option>';
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
                    url: '{{  url('elm_portal/getDepts') }}',
                    data: {'plant_id': plant_id},
                    success: function (data) {
                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.dept.length; i++) {
                                op += '<option value= " ' + data.dept[i]['dept_id'] + ' ">' + data.dept[i]['dept_name'] + '</option>';
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

                var pl = $('#plant').val();
                var dept_id = $('#dept').val();

                $.ajax({
                    type: 'get',
                    url: '{{  url('elm_portal/getRCMdeptEmpData') }}',
                    data: {'dept_id': dept_id, 'plant_id':pl},
                    success: function (data) {
                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="0" selected disabled>Select Employees</option>';
                            em += '<option value="All">All</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['emp_id'] + ' ">' + data[i]['emp_id'] + '-' + data[i]['sur_name'] + '</option>';
                            }
                            $('#emp').html("");
                            $('#emp').append(em);
                            $('#btn_submit').removeAttr("disabled");
                        }
                        else {
                            $('#emp').html("");
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

                var table = null;

                $.ajax({
                    type: 'post',
                    url: '{{  url('elm_portal/getFacRCMuserData') }}',
                    data: { 'plant_id': pl, 'dept_id':dpt, 'emp_id': emp, '_token': "{{ csrf_token
                    () }}"},
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
                                        $("#createModal").modal('show');
                                    }
                                }
                            ],
                            data: data,
                            columns: [
                                {data: "plant_name"},
                                {data: "user_id"},
                                {data: "name"},
                                {data: "desig"},
                                {data: "valid"},
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="editThis(this)" data-plantID = "'+row.plant_id+'" data-deptID =' +
                                            ' "'+row.dept_id+'" data-userID = "'+row.user_id+'">EDIT</button>'
                                    }
                                },
                                {
                                    data: null,
                                    orderable: false,
                                    'render': function (data, type, row) {
                                        return '<button class=\"btn btn-sm btn-success saveButton row-remove ' +
                                            'dt-center\" id="' + row.id +'" ' +
                                            'onclick="saveThis(this)" data-plantID = "'+row.plant_id+'" data-deptID =' +
                                            ' "'+row.dept_id+'" data-userID = "'+row.user_id+'">SAVE</button>'
                                    }
                                },
                            ],
                            columnDefs: [
                                {className: "valid", targets: 4},
                                {className: "empy_ID", targets: 1},
                                {className: "designation", targets: 3}
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
                                                columns: [0, 1, 2, 3, 4]
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
                                                columns: [0, 1, 2, 3, 4]
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
            $('#Create_btn').on('click', function (e) {
                e.preventDefault();
                $("#loader").show();

                var add_pl = $('#sel_plant').val();
                var add_emp = $('#sel_emp').val();

                $.ajax({
                    type: 'post',
                    url: '{{  url('elm_portal/createNewFacRCMuser') }}',
                    data: { 'sel_plant_id': add_pl, 'sel_emp_id': add_emp, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        $("#loader").hide();
                        $("#createModal").modal('hide');
                        if(data.status === '200'){
                            Swal.fire({
                                title: 'Data successfully added!',
                                text: '',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                        }else{
                            Swal.fire({
                                title: 'Something was wrong! Data was not saved.',
                                text: '',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
        });
        function editThis (obj) {
            var row_index = $(obj).closest("tr").index();
            $(obj).closest("tr").each(function( index ) {

                var valid_txt = $(this).find(".valid").text();
                var ySel = "";
                var nSel = "";

                if(valid_txt === 'YES'){
                    ySel = "selected";
                }else{
                    nSel = "selected";
                }
                $(this).find(".valid").html("<select class='form-control' name='valid_Idx_"+row_index+"' " +
                    "id='valid_Idx_"+row_index+"'> " +
                    "<option " +
                    "value='YES' "+ySel+">YES</option> <option value='NO' "+nSel+">NO</option> </select>");
            });
        }
        function saveThis (obj) {
            var plantID = $(obj).attr("data-plantID");
            var deptID = $(obj).attr("data-deptID");
            var userID = $(obj).attr("data-userID");

            var row_index = $(obj).closest("tr").index();
            var valid_txt = $("#valid_Idx_"+row_index).val();

            $.ajax({
                type: 'post',
                url: '{{  url('elm_portal/facRCMuserUpdate') }}',
                data: { 'plant_id': plantID, 'dept_id':deptID, 'emp_id': userID, 'valid_txt':valid_txt,
                    'row_index':row_index,
                    '_token':
                        "{{ csrf_token
                    () }}"},
                success: function (data) {

                    if(data.status == 1){
                        Swal.fire({
                            title: 'Data successfully updated!',
                            text: '',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                        $(data.eleID).parent().text(data.valid_txt);
                    }else{
                        Swal.fire({
                            title: 'Something was wrong!',
                            text: '',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                },
                error: function (e) {
                    console.log(e);
                    $("#loader").hide();
                    $("#showTable").show();
                }
            });
        }
    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection