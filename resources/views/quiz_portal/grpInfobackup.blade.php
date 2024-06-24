<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 3/28/2019
 * Time: 11:35 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Quiz Group Info')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .tx_font {
            font-size: 11px;
        }

        body {
            color: black;
        }

        .red-color {
            background-color: red;
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


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Exam Group Information
                    </label>
                </div>
                <div class="panel-body" style="padding-top: 2%">

                    <div class="row">
                        <div class="form-horizontal">
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="grp_name"
                                                       class="col-md-4 col-sm-4 control-label tx_font"><b>Grp. Name:</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <input type="text" class="form-control input-sm" id="grp_name"
                                                           name="grp_name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="grp_mrks"
                                                       class="col-md-4 col-sm-4 control-label tx_font"><b>Remarks:</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <input type="text" class="form-control input-sm" id="grp_mrks"
                                                           name="grp_mrks">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="region"
                                                       class="col-md-3 col-sm-3 control-label tx_font"><b>Region
                                                        :</b></label>
                                                <div class="col-md-8 col-sm-8">
                                                    <select name="region" id="region"
                                                            class="form-control input-sm">
                                                        <option value="">Select Region</option>
                                                        @foreach($x as $r)
                                                            <option value="{{$r->rm_terr_id}}">{{$r->rm_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="region"
                                                       class="col-md-3 col-sm-3 control-label tx_font"><b>Category:</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <select name="sc" id="sc"
                                                            class="form-control input-sm">
                                                        <option value="">Select Category</option>
                                                        <option value="MPO">MPO</option>
                                                        <option value="AM">AM</option>
                                                        <option value="RM">RM/ASM</option>
                                                        <option value="DSM">DSM</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="region"
                                                       class="col-md-3 col-sm-3 control-label tx_font"><b>Terr Grp
                                                        :</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <select name="grp" id="grp"
                                                            class="form-control input-sm">
                                                        <option value="" disabled="disabled">Select Region</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="region"
                                                       class="col-md-3 col-sm-3 control-label tx_font"><b>EMP ID
                                                        :</b></label>
                                                <div class="col-md-7 col-sm-7">
                                                    <input type="text" id="emp_id" name="emp_id">
                                                    <input type="button" class="btn btn-warning btn-sm" name="ser_btn"
                                                           id="ser_btn" value="Add Emp">
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="row" style="display: none" id="actualTbl">
                        <form id="frm-fndata" method="post">
                            <div class="col-md-12 col-sm-12">
                                <table id="fntbl" class="display table table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>P_GROUP</th>
                                        <th>TERR_ID</th>
                                        <th>EMP_ID</th>
                                        <th>NAME</th>
                                        <th>DESIG</th>
                                        <th>DUPLICATE</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-6 col-sm-6">
                                    <button type="button" class="btn btn-primary" id="sendServer" name="sendServer">
                                        Create Group
                                    </button>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    {{--<button type="button" class="btn btn-primary" id="del_fntbl" name="sendServer">Delete Group</button>--}}
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






    <!-- Modal -->
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Employee List</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="elm_emp">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <table id="emptbl" class="display table table-bordered" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center"><input type="checkbox" class="selectAll">All</th>
                                        <th>P_GROUP</th>
                                        <th>TERR_ID</th>
                                        <th>EMP_ID</th>
                                        <th>NAME</th>
                                        <th>DESIG</th>
                                        <th>DUPLICATE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sv" data-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-warning">
                <div class="panel-heading">
                    <label class="text-default">
                        Verify Group
                    </label>
                </div>
                <div class="panel-body" style="padding-top: 2%">

                    <form method="post" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">

                                <div class='col-sm-4 col-md-4'>
                                    <div class="form-group">
                                        <label for="region"
                                               class="col-md-2 col-sm-2 control-label"><b>Group:</b></label>
                                        <div class="col-md-10 col-sm-10">
                                            <select name="v_grp" id="v_grp"
                                                    class="form-control input-sm v_grp">
                                                <option value="">Select Group</option>
                                                @foreach($grpInfo as $l)
                                                    <option value="{{$l->group_id}}">{{$l->group_id}}
                                                        - {{$l->group_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-5 col-sm-5">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                        <button type="button" id="btn-verifyexm" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> <b>Display Group</b></button>
                                    </div>
                                    <div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 col-xs-4">
                                        <div id="new_export_buttons">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>


    <div class="col-md-12 col-sm-12" id="loader_new" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                <div id="new_export_buttons">

                </div>
            </div>
        </div>
    </div>



    <div class="row" id="rls" style="display: none">

        <div class="col-md-12">
            <div class="panel panel-success">
                <header class="panel-heading">
                    Group Details
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive">
                        <table class="table table-bordered" id="lvs">
                            <thead>
                            <tr>
                                <th>GROUP_ID</th>
                                <th>GROUP_NAME</th>
                                <th>GROUP_REMARK</th>
                                <th>EMP_ID</th>
                                <th>EMP_NAME</th>
                                <th>TERR_ID</th>
                                <th>TERR_GROUP</th>
                                <th>DESIG</th>
                                <th>Mobile</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>

                        </table>
                    </div>
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

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script type="text/javascript">


        var newArray = [];
        var tArray = [];
        var deldata = [];
        var vxtable;
        var table;
        var xxtable;
        $(document).ready(function () {

            $('.grp').select2();
            $('.v_grp').select2();

            //Changing company from option
            $('#region').change(function () {
                $('#grp').empty();
                $('#sc').empty().append($('<option></option>').html('Loading...'));
                var op = '';
                op += '<option value="0" selected disabled>Select Category</option>';
                op += '<option value="MPO">MPO</option>';
                op += '<option value="AM">AM</option>';
                op += '<option value="RM">RM/ASM</option>';
                op += '<option value="DSM">DSM</option>';
                $('#sc').empty().append(op);


            });

            $('#sc').change(function () {
                $('#grp').empty().append($('<option></option>').html('Loading...'));
                var rm_terr_id = $('#region').val();
                var sc = $('#sc').val();
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('quiz/get_grpName') !!}',
                    data: {'rm_terr_id': rm_terr_id, sc: sc},
                    success: function (data) {
                        console.log(data[0].p_group);
                        var op = '';
                        op += '<option value="0" selected disabled>Select Group</option>';
                        op += '<option value="All">All</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i]['p_group'] + '">' + data[i]['p_group'] + '</option>';
                        }
                        $('#grp').empty().append(op);
                    },
                    error: function (e) {
                        console.log('error = ', e);
                    }
                });
            });

            $('#grp').on('change', function () {

                console.log('Group = ', $('#grp').val());
                console.log('Region = ', $('#region').val());

                $('#myModal').modal('show');
                var grp = $('#grp').val();
                var reg = $('#region').val();
                var sc = $('#sc').val();
                var url = "{{URL::to('quiz/get_listOfEmp')}}";

                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        grp: grp, reg: reg, sc: sc,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (data) {
                        console.log('Answer data is fff: ', data);
                        $('#emptbl').DataTable().destroy();
                        table = $('#emptbl').DataTable({
                            data: data,
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    text: '<i class="btn btn-info btn-xs dt-save"><span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save </i>',
                                    action: function (e, dt, node, config) {
                                        // data table row select
                                        // $('input:checkbox').removeAttr('checked');

                                        var tblData = table.rows('.selected').data();
                                        var tmpData = '';

                                        deldata.length = 0;

                                        $.each(tblData, function (i, val) {
                                            tmpData = tblData[i];
                                            deldata.push(tmpData);
                                            
                                            // console.log('Temp Data=',tmpData);

                                            //alert(tmpData);
                                        });

                                        if (deldata.length !== 0) {
                                            tArray.concat(newArray);
                                            tArray = deldata.concat(newArray);
                                            $('#actualTbl').show();
                                            $('#fntbl').DataTable().destroy();
                                            vxtable = $('#fntbl').DataTable({
                                                data: tArray,
                                                columns: [
                                                    {data: "p_group"},
                                                    {data: "terr_id"},
                                                    {data: "emp_id"},
                                                    {data: "emp_name"},
                                                    {data: "emp_desig"},
                                                    {data: "duplicate"},
                                                    {
                                                        data: "emp_id",
                                                        mRender: function (data, type, full) {
                                                            return '<a class="btn btn-info btn-sm del_emp" href=#/' + data[0] + '>' + 'Delete' + '</a>';
                                                        }
                                                    },
                                                ],
                                            });

                                            newArray = newArray.concat(deldata.slice());

                                        } else {
                                            $('#actualTbl').hide();
                                        }

                                    }
                                }
                            ],
                            columns: [
                                {data: null},
                                {data: "p_group"},
                                {data: "terr_id"},
                                {data: "emp_id"},
                                {data: "emp_name"},
                                {data: "emp_desig"},
                                {data: "duplicate"}                                
                            ],

                            columnDefs: [
                                {
                                    orderable: false,
                                    className: 'select-checkbox',
                                    targets: 0,
                                    render: function (data, type, full, meta) {
                                        return '';
                                    },                                
                                },
                                {
                                "targets": [2],
                                "visible": true,
                                "searchable": false
                                },
                                {
                                    targets: 6, // this means controlling cells in column 1
                                    render: function(data, type, row, meta) { 

                                        if (data === 'YES') { // here is your condition
                                            return '<div class="red-color">' + data + '</div>';
                                        } else {
                                            return data;
                                        }
                                    }
                                }
                            ],
                            select: {
                                style: 'multi',
                                selector: 'td:first-child'
                            },
                            order: [
                                [1, 'asc']
                            ],

                            language: {
                                "emptyTable": "No Matching Records Found."
                            },

                            info: true,
                            paging: false,
                            filter: true
                        });

                    },
                    error: function (e) {
                        console.log(e);
                    }
                });


                $('.selectAll').on('click', function () {

                    if (table.rows('.selected').any()) {
                        table.rows().deselect();
                        $(".selectAll").prop("checked", false);
                    } else {
                        table.rows().select();
                    }
                });

            });

            $('#fntbl').on('click', '.del_emp', function () {
                var $button = $(this);
                vxtable.row($button.parents('tr')).remove().draw();
            });

            //EMP Add using btn
            $('#ser_btn').on('click', function () {
                var emp_id = $('#emp_id').val();

                $.ajax({
                    type: "get",
                    url: "{{ url('quiz/ser_emp') }}",
                    data: {
                        empID: emp_id
                    },
                    success: function (data) {
                        console.log(data[0].p_group);
                        //data table if not exist checked
                        if (!$.fn.DataTable.isDataTable('#fntbl')) {


                            $('#actualTbl').show();
                            $('#fntbl').DataTable().destroy();
                            $('#fntbl').DataTable({
                                data: data,
                                columns: [
                                    {data: "p_group"},
                                    {data: "terr_id"},
                                    {data: "emp_id"},
                                    {data: "emp_name"},
                                    {data: "emp_desig"},
                                    {data: null},
                                    {
                                        data: "mpo_emp_id",
                                        mRender: function (data, type, full) {
                                            return '<a class="btn btn-info btn-sm del_emp" href=#/' + data[0] + '>' + 'Delete' + '</a>';
                                        }
                                    },


                                ],
                            });

                            data.status = 'Employee added';
                            toastr.success(data.status);
                        } else {

                            console.log('Test....', data);

                            vxtable = $('#fntbl').DataTable();
                            vxtable.rows.add(data).draw();
                            data.status = 'Employee added';
                            toastr.success(data.status);
                        }

                    },
                    error: function () {
                    }
                });

            });

            $(function () {


                $('#sendServer').click(function () {


                    var gp_name = $('#grp_name').val();

                    if (gp_name === "") {
                        toastr.error('please select group name');
                        return false;
                    } else {
                        var xxtable = $('#fntbl').DataTable();
                        var data = xxtable.rows().data();
                        // delete data.context;
                        // //delete data.length;   // Do not delete this one! Needed for the loop below.
                        // delete data.selector;
                        // delete data.ajax;
                        //
                        // // // console.log( JSON.stringify(data) );

                        // Make the resulting "striped" object an array.
                        var dataAsArray = [];
                        // console.log(data.length);

                        for (var i = 0; i < data.length; i++) {
                            dataAsArray.push(data[i]);
                        }

                        // console.log(JSON.stringify(dataAsArray));
                        // console.log(dataAsArray);

                        var group_name = $('#grp_name').val();
                        var grp_mrks = $('#grp_mrks').val();
                        $.ajax({
                            type: "post",
                            url: "{{ url('quiz/save_group') }}",
                            data: {
                                content: dataAsArray,
                                _token: '{{csrf_token()}}',
                                grpName: group_name,
                                grpMrks: grp_mrks
                            },
                            success: function (data) {
                                console.log(data.status);// alert the data from the server
                                toastr.success(data.status);
                                setTimeout(function () {
                                    location.reload();
                                }, 3000);
                            },
                            error: function () {
                            }
                        });
                    }


                });
            });


        });

        //Group Details Veiw
        $('#btn-verifyexm').on('click', function (e) {
            //console.log('Yes Clicked');
            e.preventDefault();
            $("#loader").show();
            var v_grp = $('#v_grp').val();
            var xtable = null;

            $.ajax({
                type: "post",
                url: "{{ url('quiz/groupDetails') }}",
                data: {
                    v_grp: v_grp,
                    '_token': '{{csrf_token()}}'
                },
                success: function (data) {
                    $('#rls').show();
                    $("#loader").hide();

                    $("#lvs").DataTable().destroy();
                    xtable = $("#lvs").DataTable({
                        data: data,
                        columns: [
                            {data: "group_id"},
                            {data: "group_name"},
                            {data: "group_remark"},
                            {data: "emp_id"},
                            {data: "emp_name"},
                            {data: "terr_id"},
                            {data: "terr_group"},
                            {data: "desig"},
                            {data: "emp_contact_no"}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: false,
                        paging: false,
                        filter: false
                    });

                    xtable.fixedHeader.enable();
                    new $.fn.dataTable.Buttons(xtable, {
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
                    }).container().appendTo($('#new_export_buttons'));

                },
                error: function (data) {
                    toastr.error(data, 'Contact Your administrator', {timeOut: 2000});
                }
            });
        });


    </script>
@endsection
