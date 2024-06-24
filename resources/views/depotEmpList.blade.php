@extends('_layout_shared._master')
@section('title','Depot Employee List')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .swal2-icon.swal2-warning {
            font-size: 14px;
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
        .unit_div .select2-container{
            margin-bottom: 8px;
        }
    </style>
@endsection
@section('right-content')
    @if(Auth::user()->user_id != "00")
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <section class="panel panel-info">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="text-default">
                                        Depot Employee Information Entry
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="padding-top: 2%">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="depot" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Depot</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                @if($urole == 1)
                                                    <select id="depot" name="depot" class="form-control input-sm
                                                    filter-option pull-left">
                                                        <option value="" selected disabled>Select a Depot</option>
                                                        @foreach($depots as $d)
                                                            <option value="{{$d->depot_name}}">{{$d->depot_name}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" class="form-control input-sm" value="{{ $name }}"
                                                           name="depot" id="depot" disabled>
                                                @endif
                                            </div>
                                            <input type="hidden" value="{{ $urole }}" id="urole_id">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="emp_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm" value=""
                                                       placeholder="Input an ID"
                                                       name="emp_id" id="emp_id" onkeyup="this.value = this.value.toUpperCase();">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="emp_name" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Emp. Name</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm" value=""
                                                       placeholder="Input a name"  name="emp_name" id="emp_name" onkeyup="this.value = this.value.toUpperCase();">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-8 col-sm-8">
                                            <label for="desig"
                                                   class="col-md-2 col-sm-2 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Designation</b></label>
                                            <div class="col-md-10 col-sm-10">
                                                <select id="desig" name="desig" class="form-control input-sm
                                                filter-option pull-left">
                                                    <option value="" selected>Select a designation</option>
                                                    <option value="custom">Other</option>
                                                    @if(count($desig) > 0)
                                                        @foreach($desig as $d)
                                                            <option value="{{$d->designation}}">{{$d->designation}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a designation" name="desig"
                                                       id="input_desig" onkeyup="this.value = this.value.toUpperCase();" style="margin-top: 10px;display: none">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="mob"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Mobile</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="text" class="form-control input-sm"
                                                       value="" placeholder="Input a mobile no." name="mob"
                                                       id="mob" onkeyup="this.value = this.value.toUpperCase();">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="ip_phone"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>IP Phone</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="number" class="form-control input-sm"
                                                       value="" placeholder="Input ip phone no." name="ip_phone"
                                                       id="ip_phone" min="1">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="tnt"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Ext./TNT Phone</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <input type="number" class="form-control input-sm"
                                                       value="" placeholder="Input TNT phone no." name="tnt"
                                                       id="tnt" min="1">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="group"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Work group</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select name="group" id="group" class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select work group</option>
                                                    <option value="DEPOT_IN_CHARGE">DEPOT IN CHARGE</option>
                                                    <option value="COMPUTER">COMPUTER</option>
                                                    <option value="STORE_IN_CHARGE">STORE IN CHARGE</option>
                                                    <option value="ACCOUNTS">ACCOUNTS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_submit" class="btn btn-success btn-sm"
                                                    style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Save</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" >
                <header class="panel-heading">
                    <label class="text-primary">
                        Depot Employee List
                    </label>
                </header>
                <div class="panel-body">
                    <div id="showTable">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <div class="panel-body">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <div id="export_buttons">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 table-responsive">
                                        <table id="tbl" width="100%" class="table table-bordered table-condensed
                                        table-striped">
                                            <thead style="background-color: skyblue;">
                                            <tr>
                                                <th>Depot ID</th>
                                                <th>Depot Name</th>
                                                <th>Employee ID</th>
                                                <th>Employee Name</th>
                                                <th>Designation</th>
                                                <th>Mobile Number</th>
                                                <th>IP Phone</th>
                                                <th>Ext./TNT Phone</th>
                                                <th>Work Group</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
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
            </section>
        </div>
    </div>
    <div id="editRecordModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Employee Information</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="e_depot" class="col-md-3 col-sm-3 control-label fnt_size"
                                   style="padding-right:0px;"><b>Depot</b></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" class="form-control input-sm" value=""
                                       name="e_depot" id="e_depot" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_emp_id" class="col-md-3 col-sm-3 control-label fnt_size"
                                   style="padding-right:0px;"><b>Employee ID</b></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" class="form-control input-sm" value=""
                                       name="e_emp_id" id="e_emp_id" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_emp_name" class="col-md-3 col-sm-3 control-label fnt_size"
                                   style="padding-right:0px;"><b>Emp. Name</b></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" class="form-control input-sm" value="" name="e_emp_name"
                                       id="e_emp_name" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_desig" class="col-md-3 col-sm-3 control-label fnt_size" style="padding-right:0px;"><b>Designation</b></label>
                            <div class="col-md-9 col-sm-9">
                                <select id="e_desig" name="e_desig" class="form-control input-sm
                                                filter-option pull-left">
                                    <option value="" selected>Select a designation</option>
                                    <option value="custom">Other</option>
                                    @if(count($desig) > 0)
                                        @foreach($desig as $d)
                                            <option value="{{$d->designation}}">{{$d->designation}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" class="form-control input-sm"
                                       value="" placeholder="Input a designation" name="e_desig"
                                       id="input_e_desig" onkeyup="this.value = this.value.toUpperCase();" style="margin-top: 10px;display: none">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_mob" class="col-md-3 col-sm-3 control-label fnt_size" style="padding-right:0px;"><b>Mobile</b></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="text" class="form-control input-sm" value="" name="e_mob" id="e_mob" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_ip" class="col-md-3 col-sm-3 control-label fnt_size" style="padding-right:0px;"><b>IP Phone</b></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="number" class="form-control input-sm"
                                       value="" name="e_ip" id="e_ip" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_tnt" class="col-md-3 col-sm-3 control-label fnt_size" style="padding-right:0px;"><b>Ext./TNT Phone</b></label>
                            <div class="col-md-9 col-sm-9">
                                <input type="number" class="form-control input-sm"
                                       value="" name="e_tnt" id="e_tnt" min="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="e_group"
                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                   style="padding-right:0px;"><b>Work group</b></label>
                            <div class="col-md-9 col-sm-9">
                                <select name="e_group" id="e_group" class="form-control input-sm filter-option pull-left">
                                    <option value="" selected disabled>Select work group</option>
                                    <option value="DEPOT_IN_CHARGE">DEPOT IN CHARGE</option>
                                    <option value="COMPUTER">COMPUTER</option>
                                    <option value="STORE_IN_CHARGE">STORE IN CHARGE</option>
                                    <option value="ACCOUNTS">ACCOUNTS</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" id="e_depot_id" value="">
                        <input type="hidden" id="edit_tbl_id" value="">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-info" id="edit_btn">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
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
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('#desig').select2();
            $('#e_desig').select2();

            if($('#urole_id').val() == 1){
                $('#depot').select2();
            }

            $('#desig').change(function () {
                if($('#desig').val() == 'custom'){
                    $('#input_desig').show();
                }else{
                    $('#input_desig').val('');
                    $('#input_desig').hide();
                }
            });
            $('#e_desig').change(function () {
                if($('#e_desig').val() == 'custom'){
                    $('#input_e_desig').show();
                }else{
                    $('#input_e_desig').val('');
                    $('#input_e_desig').hide();
                }
            });

            var date = new Date();
            var pdate = date.setDate(date.getDate()-1);

            $('#date_from,#date_to').datetimepicker({
                defaultDate: pdate,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });

            $('#group').select2();
            $('#s_group').select2();

            $.ajax({
                type: 'get',
                url: '{{  url('depot/getDepotEmpList') }}',
                success: function (res) {
                    // console.log(res);
                    $("#tbl").DataTable().destroy();

                    table = $("#tbl").DataTable({
                        data: res.data,
                        autoWidth: true,
                        columns: [
                            {data: "depot_id"},
                            {data: "depot_name"},
                            {data: "emp_id"},
                            {data: "emp_name"},
                            {data: "designation"},
                            {data: "mobile_number"},
                            {data: "ip_phone"},
                            {data: "tnt_phone"},
                            {data: "work_group"},
                            {data: "create_date"},
                            {data: "update_date"},
                            {
                                data: null,
                                orderable: false,
                                'render': function (data, type, row) {
                                    return '<button class=\"btn btn-sm btn-primary row-edit ' +
                                        'dt-center\" id="' + row.id +'" ' +
                                        'onclick="editThisRecord('+"'"+row.id+"','"+row.depot_id+"','"+row.emp_id+"','"+row.emp_name+"','"+row.designation+"','"+row.mobile_number+"','"+row.ip_phone+"','"+row.tnt_phone+"','"+row.work_group+"')" +
                                        ""+'">EDIT</button>'
                                }
                            },
                            {
                                data: null,
                                orderable: false,
                                'render': function (data, type, row) {
                                    return '<button class=\"btn btn-sm btn-danger row-remove ' +
                                        'dt-center\" id="' + row.id +'" ' +
                                        'onclick="deleteThisRecord('+"'"+row.id+"')"+'">Delete</button>'
                                }
                            }
                        ],
                        scrollCollapse: true,
                        info: true,
                    });

                    // table.fixedHeader.enable();
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
                                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                }
            });

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();

                var depot = $('#depot').val();
                var emp_id = $('#emp_id').val();
                var emp_name = $('#emp_name').val();
                var mob = $('#mob').val();
                var ip_phone = $('#ip_phone').val();
                var tnt = $('#tnt').val();
                var group = $('#group').val();

                if($('#desig').val() == 'custom'){
                    var desig = $('#input_desig').val();
                }else{
                    var desig = $('#desig').val();
                }

                // console.log(emp_id);
                // console.log(emp_name);
                // console.log(group);
                // console.log(desig);

                if(emp_id === "" || emp_name === "" || group === null || desig === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $("#loader").show();
                    $.ajax({
                        type: 'post',
                        url: '{{  url('depot/saveDepotEmp') }}',
                        data: { 'depot':depot, 'emp_id':emp_id, 'emp_name':emp_name,'desig':desig, 'mob':mob,
                            'ip_phone':ip_phone, 'tnt':tnt, 'group':group, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            $("#loader").hide();
                            if(data.res == true || data.res == 1){
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Depot employee information has been saved successfully!',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Please input all required data!',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            $("#loader").hide();
                        }
                    });
                }
            });
            $('#edit_btn').on('click', function (e) {
                e.preventDefault();
                var edit_tbl_id = $('#edit_tbl_id').val();
                var e_depot_id = $('#e_depot_id').val();
                var e_depot = $('#e_depot').val();
                var e_emp_id = $('#e_emp_id').val();
                var e_emp_name = $('#e_emp_name').val();
                var e_mob = $('#e_mob').val();
                var e_ip = $('#e_ip').val();
                var e_tnt = $('#e_tnt').val();
                var e_group = $('#e_group').val();

                if($('#e_desig').val() == 'custom'){
                    var e_desig = $('#input_e_desig').val();
                }else{
                    var e_desig = $('#e_desig').val();
                }

                if(edit_tbl_id === "" || e_depot_id === "" || e_depot === "" || e_emp_id === "" || e_emp_name === "" || e_group === null || e_desig === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('depot/editDepotEmpInfo') }}',
                        data: {'edit_tbl_id':edit_tbl_id, 'e_depot_id':e_depot_id,'e_depot':e_depot,
                            'e_emp_id':e_emp_id, 'e_emp_name':e_emp_name, 'e_desig':e_desig, 'e_mob':e_mob,
                            'e_ip':e_ip, 'e_tnt':e_tnt, 'e_group':e_group, '_token': "{{ csrf_token() }}"},
                        success: function (data) {
                            $("#editRecordModal").modal('hide');
                            if(data.response == 1 || data.response == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Information has been updated Successfully',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            }else if(data.response == 2){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Insufficient Input',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }else{
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to Update',
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
            });
        });
        function editThisRecord(id, depot_id, emp_id, emp_name, designation, mobile_number, ip_phone,
                                tnt_phone, work_group){
            $('#edit_tbl_id').val(id);
            $('#e_depot_id').val(depot_id);
            $('#e_depot').val($('#depot').val());
            $('#e_emp_id').val(emp_id);
            $('#e_emp_name').val(emp_name);
            $('#e_desig').val(designation);
            $('#e_desig').trigger('change');
            $('#e_mob').val(mobile_number);
            $('#e_ip').val(ip_phone);
            $('#e_tnt').val(tnt_phone);
            $('#e_group').val(work_group);

            $("#editRecordModal").modal('show');
        }
        function deleteThisRecord(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '{{  url('depot/deleteDepotEmpInfo') }}',
                        data: { 'id':id, '_token': "{{ csrf_token () }}"},
                        success: function (data) {
                            if(data.result == 1 || data.result == true){
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'Information has been deleted Successfully',
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
    </script>
@endsection
