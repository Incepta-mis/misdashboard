@extends('_layout_shared._master')
@section('title','Item Transfer Receive')
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
        .select2-container--default .select2-selection--single {
            border-radius: 0px;
        }
        .btn-success.focus, .btn-success:focus {
            outline: none;
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
                                    Item Transfer Receive
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
                                            <label for="it_no" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Item Transfer No</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="it_no" name="it_no" class="form-control input-sm filter-option pull-left">
                                                    <option value="" selected disabled>Select Item Transfer No</option>
                                                    @foreach ( $mdata as $i )
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="hidden" id="it_date" value="">
                                            <input type="hidden" id="uid" value="{{$uid}}">
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
                <section class="panel panel-info" id="data_table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="text-default">
                                        Pending to be received before being repaired
                                    </label>
                                </div>
                                <input type="hidden" id = 'row_ids' value="">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="notReceivedData" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead>
                                <tr>
                                    <th>IT No</th>
                                    <th>Item Name</th>
                                    <th>Item Type</th>
                                    <th>CWIP ID</th>
                                    <th>Main ID</th>
                                    <th>PO Number</th>
                                    <th>PR Number</th>
                                    <th>GL</th>
                                    <th>Cost Center</th>
                                    <th>Transfer Reason</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Remarks</th>
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
                <section class="panel panel-success" id="data_table1">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="text-default">
                                        Pending to be received after being repaired
                                    </label>
                                </div>
                                <input type="hidden" id = 'row_ids' value="">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="notReceivedData1" width="100%" class="table table-bordered table-condensed
                            table-striped">
                                <thead>
                                <tr>
                                    <th>IT No</th>
                                    <th>Item Name</th>
                                    <th>Item Type</th>
                                    <th>CWIP ID</th>
                                    <th>Main ID</th>
                                    <th>PO Number</th>
                                    <th>PR Number</th>
                                    <th>GL</th>
                                    <th>Cost Center</th>
                                    <th>Transfer Reason</th>
                                    <th>Item Status</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Remarks</th>
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
        $(document).ready(function () {
            $('#it_no').select2();

            $('#btn_submit').on('click', function (e) {
                e.preventDefault();

                var it_no = $('#it_no').val();

                if(it_no === null){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Choose a Transfer Number!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }else{
                    $.ajax({
                        type: 'post',
                        url: '{{  url('stationery/form/getItemTransfers') }}',
                        data: {'it_no':it_no, '_token': "{{ csrf_token() }}"},
                        success: function (data) {
                            console.log(data);

                            if(data.it_date.length > 0){
                                $('#it_date').val(data.it_date[0]['it_date']);
                            }else{
                                $('#it_date').val("");
                            }

                            var mData = data.notRcvd;
                            var pData = data.pending2nd;
                            var html = '';
                            var ids = [];

                            if(mData.length > 0){
                                for (var i = 0; i < mData.length; i++){

                                    ids.push(mData[i]['id']);

                                    html += '<tr id="tableRow_id_'+mData[i]['id']+'" class="rowCount">';
                                    html += '<td>'+mData[i]['it_no']+'</td>';
                                    html += '<td>'+mData[i]['item_name']+'</td>';
                                    html += '<td id="it_name_'+mData[i]['id']+'">'+mData[i]['it_name']+'</td>';

                                    html += '<td><input class="form-control" type="text" id="cwip_'+mData[i]['id']+'"' +
                                        ' ' + 'name="cwip_'+mData[i]['id']+'" disabled value="'+mData[i]['cwip_id']+'" ' +
                                        'style="width: 70px" onkeyup="this.value = this.value' +
                                        '.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" type="text" value="'+mData[i]['main_id']+'" ' +
                                        'id="main_'+mData[i]['id']+'"' +
                                        ' ' + 'name="main_'+mData[i]['id']+'" disabled style="width: 70px" ' +
                                        'onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" value="'+mData[i]['po_number']+'" ' +
                                        'type="text" id="po_'+mData[i]['id']+'" ' +
                                        'name="po_'+mData[i]['id']+'" disabled style="width: 70px" onkeyup="this' +
                                        '.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" type="text" ' +
                                        'value="'+mData[i]['pr_number']+'" id="pr_'+mData[i]['id']+'" ' +
                                        'name="pr_'+mData[i]['id']+'" disabled style="width: 70px" onkeyup="this' +
                                        '.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" value="'+mData[i]['gl']+'" ' +
                                        'type="text" id="gl_'+mData[i]['id']+'" ' +
                                        'name="gl_'+mData[i]['id']+'" disabled style="width: 70px" onkeyup="this' +
                                        '.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" type="text" ' +
                                        'value="'+mData[i]['cost_center']+'" id="cc_'+mData[i]['id']+'" ' +
                                        'name="cc_'+mData[i]['id']+'" disabled style="width: 120px" onkeyup="this' +
                                        '.value = this.value.toUpperCase();"></td>';


                                    if(mData[i]['transfer_reason'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['transfer_reason']+'</td>';
                                    }

                                    if(mData[i]['qty'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['qty']+'</td>';
                                    }

                                    if(mData[i]['unit'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['unit']+'</td>';
                                    }

                                    if(mData[i]['remarks'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+mData[i]['remarks']+'</td>';
                                    }

                                    html += '<td><button type="button" class="btn btn-info btn_id_'+mData[i]['id']+'"' +
                                        ' ' +
                                        'onclick="receiveThis('+"'"+mData[i]['id']+"',"+"'first'"+')' +
                                        '">Receive</button></td>';

                                    html += '</tr>';
                                }
                                $('#data_table tbody').html(html);
                                var rowIds = JSON.stringify(ids);
                                $('#data_table #row_ids').val(rowIds);
                            }else{
                                $('#data_table tbody').html('<tr><td colspan="16" style="text-align: center; color: ' +
                                    'red; padding: 7px 0px;">There is no item ready to receive yet' +
                                    '.</td></tr>');
                                $('#data_table #row_ids').val("");
                            }
                            $('#showTable').show();

                            if(pData.length > 0){
                                for (var i = 0; i < pData.length; i++){

                                    ids.push(pData[i]['id']);

                                    html += '<tr id="tableRow_id_'+pData[i]['id']+'" class="rowCount">';
                                    html += '<td>'+pData[i]['it_no']+'</td>';
                                    html += '<td>'+pData[i]['item_name']+'</td>';
                                    html += '<td id="it_name_'+pData[i]['id']+'">'+pData[i]['it_name']+'</td>';

                                    html += '<td><input class="form-control" value="'+pData[i]['cwip_id']+'" ' +'type="text" ' +'id="cwip_'+pData[i]['id']+'"' +
                                        ' ' + 'name="cwip_'+pData[i]['id']+'" style="width: 70px" disabled onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control"  value="'+pData[i]['main_id']+'" ' +'type="text" ' + 'id="main_'+pData[i]['id']+'"' +
                                        ' ' + 'name="main_'+pData[i]['id']+'" style="width: 70px" disabled onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" value="'+pData[i]['po_number']+'" ' + 'type="text" ' + 'id="po_'+pData[i]['id']+'" ' +
                                        'name="po_'+pData[i]['id']+'" style="width: 70px" disabled onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" value="'+pData[i]['pr_number']+'" ' +'type="text" ' + 'id="pr_'+pData[i]['id']+'" ' +
                                        'name="pr_'+pData[i]['id']+'" style="width: 70px" disabled onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" value="'+pData[i]['gl']+'" ' +'type="text" ' +'id="gl_'+pData[i]['id']+'" ' +
                                        'name="gl_'+pData[i]['id']+'" style="width: 70px" disabled onkeyup="this.value = this.value.toUpperCase();"></td>';
                                    html += '<td><input class="form-control" value="'+pData[i]['cost_center']+'" ' +'type="text" ' + 'id="cc_'+pData[i]['id']+'" ' +
                                        'name="cc_'+pData[i]['id']+'" style="width: 120px" disabled onkeyup="this' +
                                            '.value = this.value.toUpperCase();"></td>';


                                    if(pData[i]['transfer_reason'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+pData[i]['transfer_reason']+'</td>';
                                    }


                                    if (pData[i]['cdmtransfer_reason'] === null) {
                                        html += '<td><input ' +
                                            'type="hidden" id="cdmtransfer_reason_'+pData[i]['id']+'" value=""></td>';
                                    } else {
                                        html += '<td>' + pData[i]['cdmtransfer_reason'] + '<input ' +
                                            'type="hidden" id="cdmtransfer_reason_'+pData[i]['id']+'" value="'+pData[i]['cdmtransfer_reason']+'"></td>';
                                    }


                                    if(pData[i]['qty'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+pData[i]['qty']+'</td>';
                                    }

                                    if(pData[i]['unit'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+pData[i]['unit']+'</td>';
                                    }

                                    if(pData[i]['remarks'] === null){
                                        html += '<td></td>';
                                    }else{
                                        html += '<td>'+pData[i]['remarks']+'</td>';
                                    }

                                    if(pData[i]['cdmtransfer_reason'] !== null && pData[i]['cdmtransfer_reason'] ===
                                        'REPAIRED'){
                                        html += '<td><button type="button" class="btn btn-info btn_id_'+pData[i]['id']+'"' +
                                            ' ' +
                                            'onclick="receiveThis('+"'"+pData[i]['id']+"',"+"'sec'"+')' +
                                            '">Receive</button></td>';
                                    }else{
                                        html += '<td><button type="button" class="btn ' +
                                            'btn-default" disabled>'+pData[i]['cdmtransfer_reason']+'</button></td>';
                                    }

                                    html += '</tr>';
                                }
                                $('#data_table1 tbody').html(html);
                                var rowIds = JSON.stringify(ids);
                                $('#data_table1 #row_ids').val(rowIds);
                            }else{
                                $('#data_table1 tbody').html('<tr><td colspan="16" style="text-align: center; color: ' +
                                    'red; padding: 7px 0px;">There is no item ready to receive yet' +
                                    '.</td></tr>');
                                $('#data_table1 #row_ids').val("");
                            }
                            $('#showTable1').show();
                        },
                        error: function (e) {
                            console.log(e);
                        }
                    });
                }
            });
        });
        function receiveThis(id,queue){
            var user_id = $('#uid').val();
            var it_no = $('#it_no').val();
            var it_date = $('#it_date').val();
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

            if($('#cdmtransfer_reason_'+id).val() != undefined){
                temp['cdmtransfer_reason'] = $('#cdmtransfer_reason_'+id).val();
            }else{
                temp['cdmtransfer_reason'] = '';
            }

            finalARr.push(temp);
            console.log(finalARr);

            $.ajax({
                type: 'post',
                url: '{{  url('stationery/form/updateTransferReceivedItems') }}',
                data: {'it_no':it_no, 'it_date':it_date, 'finalARr':finalARr, 'queue':queue,'_token': "{{ csrf_token
                () }}"},
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
                                if(queue == 'first'){
                                    if($('#notReceivedData tbody tr.rowCount').length == 0){
                                        window.location.reload();
                                    }
                                }else{
                                    if($('#notReceivedData1 tbody tr.rowCount').length == 0){
                                        window.location.reload();
                                    }
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
        }
    </script>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection