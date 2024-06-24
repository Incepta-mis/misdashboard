@extends('_layout_shared._master')
@section('title','Control Item Receipt')
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
        .select2-container--default .select2-selection--single {
            border-radius: 0px;
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
                                    Control Item Receipt
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
                                        <div class="col-md-6 col-sm-6" style="padding-bottom: 12px;">
                                            <label for="ir_no"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Requisition No</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="ir_no" name="ir_no" class="form-control input-sm
                                                filter-option pull-left">
                                                    <option value="" selected disabled>Select Requisition No</option>
                                                    @foreach($mdata as $i)
                                                        <option value="{{$i->ir_no}}">{{$i->ir_no}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" id="pr_date" value="">
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <button type="button" id="btn_submit" class="btn btn-warning btn-sm"
                                                    style="float: left;margin-left: 14px;">
                                                <i class="fa fa-chevron-circle-up"></i> <b>Display</b>
                                            </button>
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
                <section class="panel panel-success" id="data_table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="text-default">
                                        Issued Items
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" id = 'row_ids' value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="notReceivedData" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Item Type</th>
                                    <th>CWIP ID</th>
                                    <th>Main ID</th>
                                    <th>PO Number</th>
                                    <th>PR Number</th>
                                    <th>GL</th>
                                    <th>Cost Center</th>
                                    <th>Required Qty</th>
                                    <th>Approved Qty</th>
                                    <th>Issued Qty</th>
                                    <th>Received Qty</th>
                                    <th>Receivable Qty</th>
                                    <th>Pending Qty</th>
                                    <th>Remarks</th>
                                    <th>Issue Date</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
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
    <div class="row">
        <div id="showTable1" style="display: none;">
            <div class="col-sm-12 col-md-12">
                <section class="panel panel-default" id="data_table1">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="text-default">
                                        Items Waiting to be Issued
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Required Qty</th>
                                    <th>Approved Qty</th>
                                    <th>Issued Qty</th>
                                    <th>Received Qty</th>
                                    <th>Pending Qty</th>
                                    <th>Remarks</th>
                                    <th>Issue Date</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
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
        $(document).ready(function () {
            $('#ir_no').select2();

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();

                var ir_no = $('#ir_no').val();

                if(ir_no === null){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Choose a Requisition Number!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/getItemRequisitions') }}',
                        data: { 'ir_no':ir_no, '_token': "{{ csrf_token() }}" },
                        success: function (data) {
                            console.log(data);
                            if(data.prDate.length > 0){
                                $('#pr_date').val(data.prDate[0]['pr_date']);
                            }else{
                                $('#pr_date').val("");
                            }

                            var mData = data.mData;
                            var dData = data.dData;
                            var html = '';
                            var html1 = '';
                            var ids = [];

                            if(mData.length > 0){
                                for (var i = 0; i < mData.length; i++){

                                    ids.push(mData[i]['id']);

                                    html += '<tr id="tableRow_id_'+mData[i]['id']+'" class="rowCount">';
                                    html += '<td>'+mData[i]['item_id']+'</td>';
                                    html += '<td>'+mData[i]['item_name']+'</td>';
                                    html += '<td id="it_name_'+mData[i]['id']+'">'+mData[i]['it_name']+'</td>';
                                    html += '<td><input class="form-control" type="text" id="cwip_'+mData[i]['id']+'"' +
                                        ' ' +
                                        'name="cwip_'+mData[i]['id']+'" style="width: 70px"></td>';
                                    html += '<td><input class="form-control" type="text" id="main_'+mData[i]['id']+'"' +
                                        ' ' +
                                        'name="main_'+mData[i]['id']+'" style="width: 70px"></td>';

                                    html += '<td><input class="form-control" type="text" id="po_'+mData[i]['id']+'" ' +
                                        'name="po_'+mData[i]['id']+'" style="width: 70px"></td>';
                                    html += '<td><input class="form-control" type="text" id="pr_'+mData[i]['id']+'" ' +
                                        'name="pr_'+mData[i]['id']+'" style="width: 70px"></td>';

                                    html += '<td><input class="form-control" type="text" id="gl_'+mData[i]['id']+'" ' +
                                        'name="gl_'+mData[i]['id']+'" value="'+mData[i]['gl']+'" style="width: ' +
                                        '70px"></td>';
                                    html += '<td><input class="form-control" type="text" id="cc_'+mData[i]['id']+'" ' +
                                        'name="cc_'+mData[i]['id']+'" value="'+mData[i]['cc']+'" ' +
                                        'style="width: 120px" disabled></td>';

                                    html += '<td>'+mData[i]['req_qty']+'</td>';
                                    html += '<td>'+mData[i]['aprv_qty']+'</td>';

                                    if(mData[i]['issu_qty'] === null){
                                        html += '<td id="issu_qty_'+mData[i]['id']+'"></td>';
                                    }else{
                                        html += '<td id="issu_qty_'+mData[i]['id']+'">'+mData[i]['issu_qty']+'</td>';
                                    }
                                    if(mData[i]['received_qty'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['received_qty']+'</td>';
                                    }
                                    if(mData[i]['receivable_qty'] === null){
                                        html += '<td id="receivable_qty_'+mData[i]['id']+'"></td>';
                                    }else{
                                        html += '<td id="receivable_qty_'+mData[i]['id']+'">'+mData[i]['receivable_qty']+'</td>';
                                    }

                                    if(mData[i]['pen_qty'] === null){
                                        html += '<td id="pen_qty_'+mData[i]['id']+'"></td>';
                                    }else{
                                        html += '<td id="pen_qty_'+mData[i]['id']+'">'+mData[i]['pen_qty']+'</td>';
                                    }

                                    if(mData[i]['remarks'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['remarks']+'</td>';
                                    }

                                    if(mData[i]['issue_date'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['issue_date']+'</td>';
                                    }

                                    html += '<td>'+mData[i]['create_date']+'</td>';

                                    if(mData[i]['update_date'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['update_date']+'</td>';
                                    }

                                    html += '<td><button type="button" class="btn btn-info btn_id_'+mData[i]['id']+'"' +
                                        ' ' +'onclick="receiveThis('+"'"+mData[i]['id']+"','"+mData[i]['recev_d_row_id']+"'"+')' +
                                        '">Receive</button></td>';

                                    html += '</tr>';
                                }

                                $('#data_table tbody').html(html);

                                var rowIds = JSON.stringify(ids);
                                $('#data_table #row_ids').val(rowIds);
                                $("#receiveBtn").show();

                            }else{
                                $('#data_table tbody').html('<tr><td colspan="20" style="text-align: center; color: ' +
                                    'red; padding: 7px 0px;">There is no data to display!</td></tr>');
                                $('#data_table #row_ids').val("");
                                $("#receiveBtn").hide();
                            }
                            if(dData.length > 0){

                                for (var i = 0; i < dData.length; i++){
                                    html1 += '<tr>';
                                    html1 += '<td>'+dData[i]['item_id']+'</td>';
                                    html1 += '<td>'+dData[i]['item_name']+'</td>';
                                    html1 += '<td>'+dData[i]['req_qty']+'</td>';
                                    html1 += '<td>'+dData[i]['aprv_qty']+'</td>';

                                    if(dData[i]['issu_qty'] === null){
                                        html1 += '<td></td>';
                                    }else{
                                        html1 += '<td>'+dData[i]['issu_qty']+'</td>';
                                    }
                                    if(dData[i]['recev_qty'] === null){
                                        html1 += '<td></td>';
                                    }else{
                                        html1 += '<td>'+dData[i]['recev_qty']+'</td>';
                                    }
                                    if(dData[i]['pen_qty'] === null){
                                        html1 += '<td></td>';
                                    }else{
                                        html1 += '<td>'+dData[i]['pen_qty']+'</td>';
                                    }
                                    if(dData[i]['remarks'] === null){
                                        html1 += '<td></td>';
                                    }else{
                                        html1 += '<td>'+dData[i]['remarks']+'</td>';
                                    }
                                    if(dData[i]['issue_date'] === null){
                                        html1 += '<td></td>';
                                    }else{
                                        html1 += '<td>'+dData[i]['issue_date']+'</td>';
                                    }
                                    html1 += '<td>'+dData[i]['create_date']+'</td>';
                                    if(dData[i]['update_date'] === null){
                                        html1 += '<td></td>';
                                    }else{
                                        html1 += '<td>'+dData[i]['update_date']+'</td>';
                                    }
                                    // html1 += '<td><button class="btn btn-primary"></button></td>';
                                    html1 += '</tr>';
                                }
                                $('#data_table1 tbody').html(html1);
                            }else{
                                $('#data_table1 tbody').html('<tr><td colspan="8" style="text-align: center; color: ' +
                                    'red; padding: 7px 0px;">There is no data to display!</td></tr>');
                            }
                            $('#showTable').show();
                            $('#showTable1').show();
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
        });
        function receiveThis(id,recev_d_row_id){
            var ir_no = $('#ir_no').val();
            var pr_date = $('#pr_date').val();
            var data = $('#data_table #row_ids').val();
            var finalARr = [];

            var it_name = $('#it_name_'+id)[0].innerHTML;

            var temp = {};
            temp['id'] = id;
            temp['it_name'] = it_name;
            temp['cwip'] = $('#cwip_'+id).val();
            temp['main'] = $('#main_'+id).val();
            temp['po'] = $('#po_'+id).val();
            temp['pr'] = $('#pr_'+id).val();
            temp['gl'] = $('#gl_'+id).val();
            temp['cc'] = $('#cc_'+id).val();
            temp['issu_qty'] = $('#issu_qty_'+id)[0].innerHTML;
            temp['receivable_qty'] = $('#receivable_qty_'+id)[0].innerHTML;
            temp['pen_qty'] = $('#pen_qty_'+id)[0].innerHTML;
            temp['recev_d_row_id'] = recev_d_row_id;

            finalARr.push(temp);
            console.log(finalARr);
            console.log(id);

            if(data != "" && finalARr.length > 0){
                $.ajax({
                    type: 'post',
                    url: '{{  url('stationery/form/updateReceivedItem') }}',
                    data: {'rowID':id, 'ir_no':ir_no, 'pr_date':pr_date, 'finalARr':finalARr, '_token': "{{ csrf_token() }}"},
                    success: function (res) {
                        if (res.response == 1 || res.response == true) {
                            var rowId = res.row_id;

                            $('.btn_id_'+rowId).removeClass('btn-info');
                            $('.btn_id_'+rowId).addClass('btn-success');

                            $('.btn_id_'+rowId)[0].innerHTML = '<i class="fa fa-check"></i> Received';
                            $('.btn_id_'+rowId).css('outline','none');

                            Swal.fire({
                                title: 'Success!',
                                icon: 'success',
                                text: 'Data has been updated successfully',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#tableRow_id_'+rowId).remove();
                                    if($('#notReceivedData tbody tr.rowCount').length == 0){
                                        window.location.reload();
                                    }
                                }
                            })
                        } else if(res.response == 5){
                            Swal.fire({
                                title: 'Error!',
                                text: 'Please fill up all required fields.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            })
                        }else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something was wrong! Data was not saved.',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            })
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: 'Something was wrong!',
                    icon: 'error',
                    showConfirmButton: true,
                    confirmButtonText: 'Ok'
                })
            }
        }
    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection