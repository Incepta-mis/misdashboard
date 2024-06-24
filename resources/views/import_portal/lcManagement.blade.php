@extends('_layout_shared._master')
@section('title','LC MANAGEMENT')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #btn_refresh {
            color: #fff;
            background-color: #4796ad !important;
            border-color: #4796ad !important;
        }
        #btn_refresh:focus {
            outline: none !important;
        }
        #btn_update {
            background-color: #ff4300d1 !important;
            border-color: #ff4300d1 !important;
            color: #FFFFFF;
        }
        #btn_update:focus {
            outline: none !important;
        }
        .main-content{
            height: 100% !important;
        }
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px
        }

        .select2 { text-transform: uppercase; }

        . {
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
            font-size: 12px;
        }

        body {
            color: black;
        }

        label {
            font-size: 12px;
        }

        input, select {
            color: #000000;
            padding: 3px;
            border: 1px solid #ccc;
        }

        .form-group {
            margin-bottom: 0px;
        }

        .select2-container .select2-selection--single {
            font-size: 12px;
            height: auto !important;
        }
        /*.select2-container{*/
        /*    width: 100% !important;*/
        /*}*/
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            /*color: #444;*/
            line-height: 24px !important;
            border-color: #ccc;
        }
        .select2-container--default .select2-selection--single{
            border-radius: 0px;
        }

        .field-h {
            font-size: 11px;
            resize: both;
            /*background: #ffd73e33;*/
            border-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='100' height='100' viewBox='0 0 100 100' fill='none' xmlns='http://www.w3.org/2000/svg' %3E %3Cstyle%3Epath%7Banimation:stroke 5s infinite linear%3B%7D%40keyframes stroke%7Bto%7Bstroke-dashoffset:776%3B%7D%7D%3C/style%3E%3ClinearGradient id='g' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='red' /%3E%3Cstop offset='25%25' stop-color='red' /%3E%3Cstop offset='50%25' stop-color='red' /%3E%3Cstop offset='100%25' stop-color='red' /%3E%3C/linearGradient%3E %3Cpath d='M1.5 1.5 l97 0l0 97l-97 0 l0 -97' stroke-linecap='square' stroke='url(%23g)' stroke-width='3' stroke-dasharray='388'/%3E %3C/svg%3E") 1;
        }

        .input-xs {
            height: 27px;
            padding: 1px 5px;
            font-size: 12px;
            line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 1px;
        }

        .input-group-xs > .form-control,
        .input-group-xs > .input-group-addon,
        .input-group-xs > .input-group-btn > .btn {
            height: 23px;
            padding: 2px 5px;
            font-size: 12px;
            /*line-height: 1.5;*/
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove #cc5495 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #cc5495;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #337AC7;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }

        .panel-heading label{
            font-size: 14px;
        }
        .custom1{
            border-radius: 0px;
            background-color: #226384;
            border-color: #226384;
            font-weight: 600;
            padding: 5px;
        }
        .custom1:focus{
            outline: none;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        LC MANAGEMENT
                    </label>
                </header>
                <div class="panel-body" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3">
                                    <label for="po_num"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PO Number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="po_num"
                                                name="po_num">
                                            <option value="">Select PO number</option>
                                            @if(count($poData) > 0)
                                                <option value="All">All</option>
                                                @foreach($poData as $po)
                                                    <option value="{{$po->po_num}}">{{$po->po_num}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="pr_num" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PR Number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select id="pr_num" name="pr_num"
                                                class="form-control input-xs filter-option pull-left">
                                            <option value="" selected>Select PR number</option>
                                            @if(count($prData) > 0)
                                                <option value="All">All</option>
                                                @foreach($prData as $pr)
                                                    <option value="{{$pr->pr_num}}">{{$pr->pr_num}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="line_item" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Line Item</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select class="form-control input-xs filter-option pull-left" id="line_item"
                                                name="line_item">
                                            <option value="" selected>Select line item</option>
                                            @if(count($lineItem) > 0)
                                                <option value="All">All</option>
                                                @foreach($lineItem as $item)
                                                    <option value="{{$item->line_item}}">{{$item->line_item}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="indent_num"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PI/Indent Number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="text" id="indent_num" name="indent_num" class="form-control"
                                               value="" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="indent_date"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>PI/Indent Date</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="date" id="indent_date" name="indent_date" class="form-control"
                                               value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 col-xs-6">
                            <button type="button" id="btn_display" class="btn btn-warning btn-sm" style="float: right;">
                                <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
                            <div id="export_buttons">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
                        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                            <div class="panel">
                                <img src="<?php echo e(url('public/site_resource/images/preloader.gif')); ?>"
                                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                                <span><b><i>Please wait...</i></b></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row" id="RawPAckTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        RAW PACK LAB
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="RawPAckTable">
                            <thead style="background-color: #98edf8;">
                            <tr>
                                <th class="text-center">ACTION</th>
                                <th class="text-center">PLANT</th>
                                <th class="text-center">PI/INDENT NUMBER</th>
                                <th class="text-center">PI/INDENT DATE</th>
                                <th class="text-center">MATERIAL DESCRIPTION</th>
                                <th class="text-center">MATERIAL HEADING</th>
                                <th class="text-center">SUPPLIER NAME</th>
                                <th class="text-center">ORDER QUANTITY</th>
                                <th class="text-center">UNIT</th>
                                <th class="text-center">UNIT PRICE</th>
                                <th class="text-center">CURRENCY</th>
                                <th class="text-center">PI VALUE</th>
                                <th class="text-center">BLOCK LIST/NOC STATUS</th>
                                <th class="text-center">BLOCK LIST/NOC NUMBER</th>
                                <th class="text-center">CONCERN PERSON(SCM)</th>
                                <th class="text-center">PRIORITY</th>
                                <th class="text-center">EXPECTED DELIVERY DATE</th>
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
    <div class="row" id="updateTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        UPDATE DATA
                    </label>
                </header>
                <div class="panel-body">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-sm-12 col-md-12" style="text-align: right;">
                            <button class="btn btn-success btn-sm rounded-0" id="update_btn" type="button"
                                    style="background-color: #003eff; border-color: #003eff;">Update Data</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="updateMyTable">
                            <input type="hidden" id = 'update_row_ids' value="">
                            <thead style="background-color: #d7f898;">
                            <tr>
                                <th class="text-center" colspan="11" style="background-color: #163800;
                                        color: white;border-color: #163800">LC TEAM</th>
                            </tr>
                            <tr>
                                <th class="text-center">PLANT</th>
                                <th class="text-center">PR NUMBER</th>
                                <th class="text-center">LINE ITEM</th>
                                <th class="text-center">PI RECEIVING DATE</th>
                                <th class="text-center">PO NUMBER</th>
                                <th class="text-center">TYPE OF PAYMENT MODE</th>
                                <th class="text-center">BANK NAME</th>
                                <th class="text-center">INSURANCE NAME</th>
                                <th class="text-center">INSURANCE NUMBER</th>
                                <th class="text-center">BANK DELIVERY DATE</th>
                                <th class="text-center">LC NUMBER</th>
                                <th class="text-center">LC DATE</th>
                                <th class="text-center">LDS DATE</th>
                                <th class="text-center">EXPIRY DATE</th>
                                <th class="text-center">HS CODE</th>
                                <th class="text-center">REMARKS</th>
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
    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/moment.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2@8.js')}}

    <script>
        $(document).ready(function () {
            $('#po_num').select2();
            $('#pr_num').select2();
            $('#line_item').select2();

            $('#btn_display').on('click', function () {

                if($('#po_num').val() === "" && $('#pr_num').val() === "" && $('#line_item').val() === "" && $('#indent_date').val() === "" && $('#indent_num').val() === ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose at least one data!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                }else{
                    $('#loader').show();
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/retrieveRawPackInfoForLC')}}',
                        data: {
                            po_num: $('#po_num').val(),
                            pr_num: $('#pr_num').val(),
                            indent_num: $('#indent_num').val(),
                            line_item: $('#line_item').val(),
                            indent_date: $('#indent_date').val(),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            // console.log(response);
                            var res = response.result;

                            if(res.length > 0){
                                var tr = '';

                                for(var i = 0; i < res.length; i++){

                                    tr += '<tr class="rowCount">';

                                    tr += '<td><button type="button" id="modifyBtn_'+res[i]['id']+'" class="btn btn-primary ' +
                                    'btn-xs custom1" onclick="modifyLCdata('+res[i]['id']+')">Click to ' +
                                        'modify</button></td>';

                                    tr += '<td>'+res[i]['plant']+'</td>';

                                    if(res[i]['pi_num'] != null){
                                        tr += '<td>'+res[i]['pi_num']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_date'] != null){
                                        tr += '<td>'+moment(res[i]['pi_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['mat_desc'] != null){
                                        tr += '<td>'+res[i]['mat_desc']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['mat_heading'] != null){
                                        tr += '<td>'+res[i]['mat_heading']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['supp_name'] != null){
                                        tr += '<td>'+res[i]['supp_name']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['order_qty'] != null){
                                        tr += '<td>'+res[i]['order_qty']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['unit'] != null){
                                        tr += '<td>'+res[i]['unit']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['unit_price'] != null){
                                        tr += '<td>'+res[i]['unit_price']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['currency'] != null){
                                        tr += '<td>'+res[i]['currency']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_value'] != null){
                                        tr += '<td>'+res[i]['pi_value']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['blocklist_status'] != null){
                                        tr += '<td>'+res[i]['blocklist_status']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['blocklist_num'] != null){
                                        tr += '<td>'+res[i]['blocklist_num']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['concern_person'] != null){
                                        tr += '<td>'+res[i]['concern_person']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['priorty'] != null){
                                        tr += '<td>'+res[i]['priorty']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['exp_delivery_date'] != null){
                                        tr += '<td>'+moment(res[i]['exp_delivery_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    tr += '</tr>';
                                }
                                $('#RawPAckTable tbody').html(tr);
                                $('#RawPAckTable').dataTable();
                                $('#RawPAckTableDiv').show();
                            }else{
                                var tr = '';
                                tr += '<tr style="text-align: center;color: red">';
                                tr += '<td colspan="17">There is no data available!</td>';
                                tr += '</tr>';
                                $('#RawPAckTable tbody').html(tr);
                                $('#RawPAckTableDiv').show();
                            }
                            $('#loader').hide();
                        },
                        error: function (error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Unable to fetch data!',
                                icon: 'error',
                                showConfirmButton: true,
                                confirmButtonText: 'Ok'
                            });
                            console.log(error);
                            $('#loader').hide();
                            $('#RawPAckTableDiv').hide();
                        }
                    })
                }
            });

            $('#update_btn').on('click', function () {
                var finalARr = [];
                var rowIDs = $('#updateMyTable #update_row_ids').val();
                rowIDs = JSON.parse(rowIDs);
                if(rowIDs.length > 0){

                    $('#update_btn').empty();
                    $('#update_btn').html('<i class="fa fa-spinner fa-spin"></i> Update Data');

                    for (var i = 0; i < rowIDs.length; i++){
                        var id = rowIDs[i];

                        var temp = {};
                        temp['id'] = id;
                        temp['pi_rcv_date'] = $('#updateMyTable #tableRow_id_'+id+' #pi_rcv_date').val();
                        temp['t_po_num'] = $('#updateMyTable #tableRow_id_'+id+' #t_po_num').val();
                        temp['type_of_pay_mode'] = $('#updateMyTable #tableRow_id_'+id+' #type_of_pay_mode').val();
                        temp['bank_name'] = $('#updateMyTable #tableRow_id_'+id+' #bank_name').val();
                        temp['insurance_name'] = $('#updateMyTable #tableRow_id_'+id+' #insurance_name').val();
                        temp['insurance_num'] = $('#updateMyTable #tableRow_id_'+id+' #insurance_num').val();
                        temp['bank_deli_date'] = $('#updateMyTable #tableRow_id_'+id+' #bank_deli_date').val();
                        temp['lc_number'] = $('#updateMyTable #tableRow_id_'+id+' #lc_number').val();
                        temp['lc_date'] = $('#updateMyTable #tableRow_id_'+id+' #lc_date').val();
                        temp['lds_date'] = $('#updateMyTable #tableRow_id_'+id+' #lds_date').val();
                        temp['expiry_date'] = $('#updateMyTable #tableRow_id_'+id+' #expiry_date').val();
                        temp['hs_code'] = $('#updateMyTable #tableRow_id_'+id+' #hs_code').val();
                        temp['t_remarks'] = $('#updateMyTable #tableRow_id_'+id+' #t_remarks').val();
                        finalARr.push(temp);
                    }
                    // console.log(finalARr);
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/updateLCData')}}',
                        data: {
                            finalData: JSON.stringify(finalARr),
                            _token: '{{csrf_token()}}'
                        },
                        success: function (res) {
                            // console.log(res);
                            if (res.result == 1 || res.result == true) {
                                Swal.fire({
                                    title: 'Success!',
                                    icon: 'success',
                                    text: 'LC data is updated successfully!',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Something was wrong! Data was not updated.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                })
                            }
                            $('#update_btn').empty();
                            $('#update_btn').html('Update Data');
                        },
                        error: function (error) {
                            toastr.info('Unable to update data');
                            console.log(error);

                            $('#update_btn').empty();
                            $('#update_btn').html('Update Data');
                        }
                    });
                }
            });
        });
        function ldsDateChange(row_id){
            var lds_date = $('#updateMyTable #tableRow_id_'+row_id+' #lds_date').val();
            var newDate = moment(lds_date, "YYYY-MM-DD").add(21, 'days');
            $('#updateMyTable #tableRow_id_'+row_id+' #expiry_date').val(moment(newDate).format('YYYY-MM-DD'));
        }
        function modifyLCdata(row_id){
            $('#modifyBtn_'+row_id).empty();
            $('#modifyBtn_'+row_id).html('<i class="fa fa-spinner fa-spin"></i> Click to modify');

            $.ajax({
                type: 'post',
                url: '{{url('import_management/getRawPackInfo')}}',
                data: {
                    row_id: row_id,
                    _token: '{{csrf_token()}}'
                },
                success: function (response) {
                    // console.log(response);
                    var res = response.result;

                    if(res.length > 0){
                        var tr = '';
                        var rowIds = [];

                        for(var i = 0; i < res.length; i++){

                            rowIds.push(res[i]['id']);

                            tr += '<tr id="tableRow_id_'+res[i]['id']+'" class="rowCount">';

                            tr += '<td><input type="text" class="form-control input-xs" id="t_plant" ' +
                                'name="t_plant" style="width: 130px;" value="'+res[i]['plant']+'" disabled></td>';

                            tr += '<td><input type="text" class="form-control input-xs" id="t_pr_num" name="t_pr_num" ' +
                                'value="'+res[i]['pr_num']+'" style="width: 100px" disabled></td>';

                            tr += '<td><input type="number" class="form-control input-xs" id="t_line_item" name="t_line_item" ' +
                                'value="'+res[i]['line_item']+'" style="width: 50px" disabled></td>';

                            if(res[i]['pi_rcv_date'] != null){
                                tr += '<td><input type="date" class="form-control input-xs" id="pi_rcv_date" name="pi_rcv_date" ' +
                                    'style="width: 120px" value="'+moment(res[i]['pi_rcv_date']).format('YYYY-MM-DD')+'"></td>';
                            }else{
                                tr += '<td><input type="date" class="form-control input-xs" id="pi_rcv_date" name="pi_rcv_date" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['po_num'] != null){
                                tr += '<td><input type="text" class="form-control input-xs" id="t_po_num" ' +
                                    'name="t_po_num" style="width: 120px" value="'+res[i]['po_num']+'"></td>';
                            }else{
                                tr += '<td><input type="text" class="form-control input-xs" id="t_po_num" name="t_po_num" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['pay_mode'] != null){
                                tr += '<td><select type="text" class="form-control input-xs" id="type_of_pay_mode" ' +
                                    'name="type_of_pay_mode" style="width:260px">' +
                                    '<option value="">Select payment mode</option><option ' +
                                    'value="LC" '+(res[i]['pay_mode'] === "LC" ? 'selected="selected"' : '')+'>LC</option>' +
                                    '<option value="TT" '+(res[i]['pay_mode'] === "TT" ? 'selected="selected"' : '')+'>TT</option>' +
                                    '<option value="CAD" '+(res[i]['pay_mode'] === "CAD" ? 'selected="selected"' : '')+'>CAD</option>' +
                                    '<option value="LC-LOCAL" '+(res[i]['pay_mode'] === "LC-LOCAL" ? 'selected="selected"' : '')+'>LC-LOCAL</option></select></td>';
                            }else{
                                tr += '<td><select type="text" class="form-control input-xs" id="type_of_pay_mode" ' +
                                    'name="type_of_pay_mode" style="width:260px">' +
                                    '<option value="">Select payment mode</option>' +
                                    '<option value="LC">LC</option>' +
                                    '<option value="TT">TT</option>' +
                                    '<option value="CAD">CAD</option>' +
                                    '<option value="LC-LOCAL">LC-LOCAL</option></select></td>';
                            }

                            if(res[i]['bank_name'] != null){
                                tr += '<td><select type="text" class="form-control input-xs" id="bank_name" ' +
                                    'name="bank_name" style="width: 270px;"><option value="">Select a ' +
                                    'bank</option>';
                                for(var x = 0; x < response.banks.length > 0; x++){
                                    if(res[i]['bank_name'] == response.banks[x]['id']){
                                        tr += '<option value="'+response.banks[x]['id']+'" ' +
                                            'selected>'+response.banks[x]['bank_name']+'</option>';
                                    }else{
                                        tr += '<option value="'+response.banks[x]['id']+'">'+response
                                            .banks[x]['bank_name']+'</option>';
                                    }
                                }
                                tr += '</select></td>';
                            }else{
                                tr += '<td><select type="text" class="form-control input-xs" id="bank_name" name="bank_name" ' +
                                    'style="width: 270px;"><option value="">Select a bank</option>';
                                for(var x = 0; x < response.banks.length > 0; x++){
                                    tr += '<option value="'+response.banks[x]['id']+'">'+response
                                        .banks[x]['bank_name']+'</option>';
                                }
                                tr += '</select></td>';
                            }

                            if(res[i]['insurance_name'] != null){
                                tr += '<td><select type="text" class="form-control input-xs" id="insurance_name" ' +
                                    'name="insurance_name" style="width: 270px;"><option value="">Select an ' +
                                    'insurance</option>';
                                for(var x = 0; x < response.insurances.length > 0; x++){
                                    if(res[i]['insurance_name'] == response.insurances[x]['id']){
                                        tr += '<option value="'+response.insurances[x]['id']+'" ' +
                                            'selected>'+response.insurances[x]['insurance_name']+'</option>';
                                    }else{
                                        tr += '<option value="'+response.insurances[x]['id']+'">'+response
                                            .insurances[x]['insurance_name']+'</option>';
                                    }
                                }
                                tr += '</select></td>';
                            }else{
                                tr += '<td><select type="text" class="form-control input-xs" id="insurance_name" name="insurance_name" ' +
                                    'style="width: 270px;"><option value="">Select an insurance</option>';
                                for(var x = 0; x < response.insurances.length > 0; x++){
                                    tr += '<option value="'+response.insurances[x]['id']+'">'+response
                                        .insurances[x]['insurance_name']+'</option>';
                                }
                                tr += '</select></td>';
                            }

                            if(res[i]['insurance_num'] != null){
                                tr += '<td><input type="text" class="form-control input-xs" id="insurance_num" ' +
                                    'name="insurance_num" style="width: 120px" value="'+res[i]['insurance_num']+'"></td>';
                            }else{
                                tr += '<td><input type="text" class="form-control input-xs" id="insurance_num" name="insurance_num" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['bank_deli_date'] != null){
                                tr += '<td><input type="date" class="form-control input-xs" id="bank_deli_date" name="bank_deli_date" ' +
                                    'style="width: 120px" value="'+moment(res[i]['bank_deli_date']).format('YYYY-MM-DD')+'"></td>';
                            }else{
                                tr += '<td><input type="date" class="form-control input-xs" id="bank_deli_date" name="bank_deli_date" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['lc_number'] != null){
                                tr += '<td><input type="text" class="form-control input-xs" id="lc_number" ' +
                                    'name="lc_number" ' +
                                    'style="width: 120px" value="'+res[i]['lc_number']+'"></td>';
                            }else{
                                tr += '<td><input type="text" class="form-control input-xs" id="lc_number" name="lc_number" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['lc_date'] != null){
                                tr += '<td><input type="date" class="form-control input-xs" id="lc_date" name="lc_date" ' +
                                    'style="width: 120px" value="'+moment(res[i]['lc_date']).format('YYYY-MM-DD')+'"></td>';
                            }else{
                                tr += '<td><input type="date" class="form-control input-xs" id="lc_date" name="lc_date" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['lds_date'] != null){
                                tr += '<td><input type="date" class="form-control input-xs" id="lds_date" name="lds_date" ' +
                                    'style="width: 120px" value="'+moment(res[i]['lds_date']).format('YYYY-MM-DD')+'"' +
                                    ' onchange="ldsDateChange('+res[i]['id']+')"></td>';
                            }else{
                                tr += '<td><input type="date" class="form-control input-xs" id="lds_date" name="lds_date" ' +
                                    'style="width: 120px" onchange="ldsDateChange('+res[i]['id']+')"></td>';
                            }

                            if(res[i]['expiry_date'] != null){
                                tr += '<td><input type="date" class="form-control input-xs" id="expiry_date" name="expiry_date" ' +
                                    'style="width: 120px" value="'+moment(res[i]['expiry_date']).format('YYYY-MM-DD')
                                    +'" disabled></td>';
                            }else{
                                if(res[i]['lds_date'] != null){
                                    var newDate = moment(res[i]['lds_date'], "YYYY-MM-DD").add(21, 'days');
                                    tr += '<td><input type="date" class="form-control input-xs" id="expiry_date" name="expiry_date" ' +
                                        'style="width: 120px" value = "'+newDate+'" disabled></td>';
                                }else{
                                    tr += '<td><input type="date" class="form-control input-xs" id="expiry_date" name="expiry_date" ' +
                                        'style="width: 120px" value = "" disabled></td>';
                                }
                            }

                            if(res[i]['hs_code'] != null){
                                tr += '<td><input type="text" class="form-control input-xs" id="hs_code" ' +
                                    'name="hs_code" style="width: 120px" value="'+res[i]['hs_code']+'"></td>';
                            }else{
                                tr += '<td><input type="text" class="form-control input-xs" id="hs_code" name="hs_code" ' +
                                    'style="width: 120px"></td>';
                            }

                            if(res[i]['remarks'] != null){
                                tr += '<td><input type="text" class="form-control input-xs" id="t_remarks" ' +
                                    'name="t_remarks" style="width: 220px" value="'+res[i]['remarks']+'"></td>';
                            }else{
                                tr += '<td><input type="text" class="form-control input-xs" id="t_remarks" name="t_remarks" ' +
                                    'style="width: 220px"></td>';
                            }

                            tr += '</tr>';
                        }

                        var finalRowIds = JSON.stringify(rowIds);
                        $('#updateMyTable #update_row_ids').val(finalRowIds);
                        $('#updateMyTable tbody').html(tr);
                        $('#updateTableDiv').show();
                        $('#update_btn').show();

                        $('#updateMyTable #type_of_pay_mode').select2();
                        $('#updateMyTable #bank_name').select2();
                        $('#updateMyTable #insurance_name').select2();

                        $('#modifyBtn_'+row_id).empty();
                        $('#modifyBtn_'+row_id).html('Click to modify');
                    }else{
                        var tr = '';
                        tr += '<tr style="text-align: center;color: red">';
                        tr += '<td colspan="16">There is no data available!</td>';
                        tr += '</tr>';

                        $('#updateMyTable tbody').html(tr);
                        $('#updateTableDiv').show();
                        $('#update_btn').hide();

                        $('#modifyBtn_'+row_id).empty();
                        $('#modifyBtn_'+row_id).html('Click to modify');
                    }
                    window.scrollTo(0, document.body.scrollHeight);
                },
                error: function (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Unable to fetch data!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                    console.log(error);
                    $('#updateTableDiv').hide();
                    $('#modifyBtn_'+row_id).empty();
                    $('#modifyBtn_'+row_id).html('Click to modify');
                }
            })
        }
    </script>
@endsection
