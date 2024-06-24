@extends('_layout_shared._master')
@section('title','Update Purchase Requisition')
@section('styles')

    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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
        .flex-dis{
            display: flex !important;
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label class="text-default">
                                    Update Purchase Requisition
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6">
                                            <label for="plant_id"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant ID</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant_id" name="plant_id"
                                                        class="form-control input-sm filter-option pull-left">
                                                    @if(count($req_data) > 0)
                                                        <option value="" selected disabled>Select Plant ID</option>
                                                        <option value="All">All</option>
                                                        @foreach($req_data as $r)
                                                            <option value="{{$r->plant_id}}">{{$r->plant_id}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No data found</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <label for="mat_group"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Material Group</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="mat_group" name="mat_group" class="form-control input-sm filter-option pull-left">
                                                        <option value="" selected disabled>Select Material Group</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-6" >
                                            <button type="button" id="btn_submit" class="btn btn-warning btn-sm" style="float: right;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b>
                                            </button>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left: 0px;">
                                            <div id="export_buttons" style="float: left">
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
    <div class="row">
        <div id="showTable" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="req_report" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead style="background-color: #b2d3f3;">
                                <tr>
                                    <th>Plant ID</th>
                                    <th>Purch Req</th>
                                    <th>Material</th>
                                    <th>Material Desc.</th>
                                    <th>Material Group</th>
                                    <th>PR Quantity</th>
                                    <th>Unit</th>
                                    <th>Categories</th>
                                    <th>Req Date</th>
                                    <th>Requisnr</th>
                                    <th>Tracking No</th>
                                    <th>Action</th>
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

        $('#plant_id').select2();
        $('#mat_group').select2();

        $(document).ready(function () {

            $("#plant_id").on('change',function (){
                var plant_id = $("#plant_id").val();
                $.ajax({
                    type: 'post',
                    url: '{{  url('scm_portal/getMatGroups') }}',
                    data: {'plant_id':plant_id, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        if(data.length > 0){
                            var html = '';
                            html += '<option value="" selected disabled>Select Material Group</option>';
                            html += '<option value="All">All</option>';
                            for (var i=0; i<data.length; i++){
                                html += '<option value="'+data[i]['material_group']+'">'+data[i]['material_group']+'</option>';
                            }
                            $('#mat_group').html(html);
                        }else{
                            $('#mat_group').html("<option value='' selected disabled>No data found</option>");
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
            $('#btn_submit').on('click', function (e) {
                e.preventDefault();
                var plant_id = $('#plant_id').val();
                var mat_group = $('#mat_group').val();

                if(plant_id === null && mat_group === null){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input at least one data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $("#loader").show();
                    var table = null;

                    $.ajax({
                        type: 'post',
                        url: '{{  url('scm_portal/getReqReport') }}',
                        data: {
                            'plant_id': plant_id,'mat_group': mat_group, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            $("#showTable").show();
                            $("#loader").hide();
                            $("#req_report").DataTable().destroy();

                            table = $("#req_report").DataTable({
                                dom: 'Bfrtip',
                                buttons: [],
                                data: data,
                                columns: [
                                    {data: "plant_id"}, 
                                    {data: "purch_req"},
                                    {data: "material"},
                                    {data: "material_desc"},
                                    {data: "material_group"},
                                    {data: "quantity"},
                                    {data: "unit"},
                                    {data: "categories"},
                                    {data: "req_date"},
                                    {data: "requisnr"},
                                    {data: "tracking_no"},
                                    {
                                        data: null,
                                        orderable: false,
                                        'render': function (data, type, row) {
                                            return '<button class=\"btn btn-sm btn-primary editButton row-edit ' +
                                                'dt-center\" id="' + row.id +'" ' +
                                                'onclick="editThis(this)" data-purchreq = "'+row.purch_req+'" data-material =' +
                                                ' "'+row.material+'">EDIT</button> <button class=\"btn btn-sm btn-success saveButton row-remove ' +
                                                'dt-center\" id="' + row.id +'" ' +
                                                'onclick="saveThis(this)" data-purchreq = "'+row.purch_req+'" data-material =' +
                                                ' "'+row.material+'" style="margin-left:5px">SAVE</button>'
                                        }
                                    }
                                ],
                                columnDefs: [
                                    {className: "quantity", targets: 5},{className: "flex-dis", targets: 11}
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
                                                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                                                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
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
                }
            });
        });

        function editThis (obj) {
            var row_index = $(obj).closest("tr").index();
            $(obj).closest("tr").each(function( index ) {
                var quantity = $(this).find(".quantity").text();
                $(this).find(".quantity").html("<input type='number' min='1' class= 'form-control' style='width: " +
                    "90px;' " +
                    "name='row_Idx_"+row_index+"' " +
                    "id='row_Idx_"+row_index+"' value='"+quantity+"'> ");
            });
        }
        function saveThis (obj) {

            var purchreq = $(obj).attr("data-purchreq");
            var material = $(obj).attr("data-material");
            var row_index = $(obj).closest("tr").index();
            var qty = $("#row_Idx_"+row_index).val();

            $.ajax({
                type: 'post',
                url: '{{  url('scm_portal/qtyUpdate') }}',
                data: { 'purchreq': purchreq, 'material':material, 'qty': qty,'row_index':row_index,
                    '_token':
                        "{{ csrf_token
                    () }}"},
                success: function (data) {
                    if(data.status == 1 || data.status == true){
                        Swal.fire({
                            title: 'Data successfully updated!',
                            text: '',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                        $(data.eleID).parent().text(data.quantity);
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