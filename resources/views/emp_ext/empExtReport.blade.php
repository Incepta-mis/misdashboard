@extends('_layout_shared._master')
@section('title','Employee Extension Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/js/table-export/tableexport.min.css')}}" rel="stylesheet" type="text/css"/>

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

        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myTable {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            font-size: 18px;
        }

        #myTable th, #myTable td {
            text-align: left;
            padding: 12px;
        }

        #myTable tr {
            border-bottom: 1px solid #ddd;
        }

        #myTable tr.header, #myTable tr:hover {
            background-color: #f1f1f1;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Employee Extension Report
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
                                                <input type="text" id="comp" name="comp" class="form-control
                                                input-sm" value="{{$companyData[0]->com_name}}" disabled>
                                                <input type="hidden" id="comp_id" value="{{$companyData[0]->com_id}}">
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
                                                    <option value="All" selected>All</option>
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
                                                    <option value="All" selected>All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <button type="button" id="btn_submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                                            <div id="export_buttons">
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
            </div>
        </div>
    </div>

    <div class="row">
        <div id="showTable" style="display: none">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive" >
{{--                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">--}}

                            <table id="emp_table" class="display" style="width:100%;">

                            </table>
                        </div>
                    </div>
                </section>
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

    {{--for custom excel using tableexport.v3.travismclarke.com library--}}
    {{Html::script('public/site_resource/js/table-export/xls.core.min.js')}}
    {{Html::script('public/site_resource/js/table-export/FileSaver.min.js')}}
    {{Html::script('public/site_resource/js/table-export/tableexport.min.js')}}

    <script type="text/javascript">
        $(document).ready(function () {

            $('#plant').select2();
            $('#dept').select2();
            $('#emp').select2();

            var comp_id = $('#comp_id').val();

            $.ajax({
                type: 'post',
                url: '{{  url('employeeExtention/getPlantData') }}',
                data: {'c_id': comp_id,'_token': "{{ csrf_token () }}"},
                success: function (data) {
                    if(data.plant.length > 0){
                        var op = '';
                        op += '<option value="All" selected>All</option>';
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
                error: function (e) {
                    console.log(e);
                }
            });

            // Changing plant option started here
            $('#plant').change(function () {
                $('#dept').empty();
                $('#dept').append($('<option></option>').html('Loading...'));

                var plant_id = $('#plant').val();
                var comp_id = $('#comp_id').val();

                $.ajax({
                    type: 'post',
                    url: '{{  url('employeeExtention/getDepts') }}',
                    data: {'plant_id': plant_id, 'comp_id':comp_id, '_token': "{{ csrf_token () }}"},
                    success: function (data) {
                        // console.log(data.dept);
                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="All" selected>All</option>';
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
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            // Changing Dept option started here
            $('#dept').change(function () {
                $('#emp').empty().append($('<option></option>').html('Loading...'));

                var dept_id = $('#dept').val();
                var pl = $('#plant').val();

                $.ajax({
                    type: 'post',
                    url: '{{ url('employeeExtention/getDeptEmpDatas') }}',
                    data: { 'dept_id': dept_id, 'plant_id':pl, '_token': "{{ csrf_token () }}" },
                    success: function (data) {
                        if ((data.length) > 0) {
                            var em = '';
                            em += '<option value="All" selected>All</option>';
                            for (var i = 0; i < data.length; i++) {
                                em += '<option value= " ' + data[i]['emp_id'] + ' ">' + data[i]['emp_id'] + '-' + data[i]['sur_name'] + '</option>';
                            }
                            $('#emp').html("");
                            $('#emp').append(em);
                        }
                        else {
                            $('#emp').html("");
                            $('#emp').append('<option value="0" selected disabled>No Employee available in this Category</option>');
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            $('#btn_submit').on('click', function (e) {

                $("#loader").show();
                $("#showTable").hide();

                var pl = $('#plant').val();
                var dpt = $('#dept').val();
                var emp = $('#emp').val();
                var comp_id = $('#comp_id').val();

                $.ajax({
                    type: 'post',
                    url: '{{  url('employeeExtention/getEmpExtReport') }}',
                    data: { 'comp_id':comp_id, 'plant_id': pl, 'dept_id':dpt, 'emp_id': emp, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        // console.log(data);

                        var deptWiseArr = data.deptWiseArr;

                        var html = '';
                        if(deptWiseArr.length > 0){
                            for (var i = 0; i < deptWiseArr.length; i++){
                                html += '<thead>';
                                    html += '<tr style="background-color: aquamarine;">';
                                    html += '<th colspan="5" style="text-align: ' +
                                        'center;padding: 6px;">PLANT - '+deptWiseArr[i]['plant_name']+'</th>';
                                    html += '</tr>';
                                html += '</thead>';


                                var deptWiseEmps = deptWiseArr[i]['deptWiseEmps'];
                                for (var j = 0; j < deptWiseEmps.length; j++){
                                    html += '<thead>';
                                        html += '<tr style="background-color: #c6c5ff;">';
                                            html += '<th colspan="5" style="text-align: center">DEPARTMENT - ' +
                                                ''+deptWiseEmps[j]['dept_name']+'</th>';
                                        html += '</tr>';

                                        html += '<tr style="background-color: coral;">';
                                            html += '<th>Employee ID</th>';
                                            html += '<th>Employee Name</th>';
                                            html += '<th>IP Number</th>';
                                            html += '<th>PABX Number</th>';
                                        html += '</tr>';
                                    html += '</thead>';
                                    html += '<tbody>';
                                    var empList = deptWiseEmps[j]['empList'];
                                    for (var z = 0; z < empList.length; z++){
                                        html += '<tr>';
                                        html += '<td>'+empList[z]['employee_id']+'</td>';
                                        html += '<td>'+empList[z]['employee_name']+'</td>';
                                        if(empList[z]['ip_number'] == null){
                                            html += '<td></td>';
                                        }else{
                                            html += '<td>'+empList[z]['ip_number']+'</td>';
                                        }
                                        if(empList[z]['pabx_number'] == null){
                                            html += '<td></td>';
                                        }else{
                                            html += '<td>'+empList[z]['pabx_number']+'</td>';
                                        }
                                        html += '</tr>';
                                    }
                                    html += '</tbody>';
                                }
                            }
                        }
                        $("#loader").hide();
                        $('#emp_table').html(html);
                        $("#showTable").show();

                        $("#emp_table").tableExport({
                            formats: ["xls", "xlsx", "csv"],
                            fileName: "employeeExtList",
                            position: "top",
                        }).reset();



                        // $("#emp_table").DataTable();

                        // $("#emp_table").DataTable().destroy();
                        //
                        // table = $("#emp_table").DataTable({
                        //     autoWidth: true,
                        //     scrollCollapse: true,
                        //     info: true
                        // });
                        // new $.fn.dataTable.Buttons(table, {
                        //     buttons: [
                        //         {
                        //             extend: 'collection',
                        //             text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                        //             buttons: [
                        //                 {
                        //                     extend: 'excel',
                        //                     text: 'Save As Excel',
                        //                     footer: true,
                        //                     action: function (e, dt, node, config) {
                        //                         exportExtension = 'Excel';
                        //                         $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                        //                     }
                        //                 }, {
                        //                     extend: 'pdfHtml5',
                        //                     orientation: 'landscape',
                        //                     pageSize: 'LEGAL',
                        //                     text: 'Save As PDF',
                        //                     footer: true,
                        //                     action: function (e, dt, node, config) {
                        //                         exportExtension = 'PDF';
                        //                         $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                        //                     }
                        //                 }
                        //             ],
                        //             className: 'btn btn-sm btn-primary'
                        //         }
                        //     ]
                        // }).container().appendTo($('#export_buttons'));
                    },
                    error: function (e) {
                        console.log(e);
                        $("#loader").hide();
                        $("#showTable").hide();
                    }
                });
            });
        });

        // function myFunction() {
        //     var input, filter, table, tr, td, i, txtValue;
        //     input = document.getElementById("myInput");
        //     filter = input.value.toUpperCase();
        //     table = document.getElementById("emp_table");
        //     tr = table.getElementsByTagName("tr");
        //     for (i = 0; i < tr.length; i++) {
        //         td = tr[i].getElementsByTagName("td")[0];
        //         console.log(td);
        //         if (td) {
        //             txtValue = td.textContent || td.innerText;
        //
        //             if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //                 tr[i].style.display = "block";
        //             } else {
        //                 tr[i].style.display = "none";
        //             }
        //         }
        //     }
        // }
    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection