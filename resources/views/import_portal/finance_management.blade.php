@extends('_layout_shared._master')
@section('title','FINANCE')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .custom1 {
            border-radius: 0px;
            background-color: #226384;
            border-color: #226384;
            font-weight: 600;
            padding: 5px;
        }
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
        #lc_numList {
            width: 100%;
            margin: 0em auto 0em auto;
            margin-top: 10px ;
        }

        #lc_numList ul {
            padding: 0;
        }

        #lc_numList ul li {
            display: inline-block;
            padding: 0.5em;
            background-color: navy;
            color: white;
            font-size: 0.9em;
            cursor: pointer;
            border-radius: 0.8em;
            margin: 2px;
        }

        @keyframes appear {
            from {
                transform: scale(0.6, 0.6);
            }

            to {
                transform: scale(1, 1);

            }
        }

        #lcNumJson {
            margin: 0.1em auto 0.1em auto;
            width: 80%;
            text-align: left;
            color: white;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        FINANCE
                    </label>
                </header>
                <div class="panel-body" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3">
                                    <label for="plant"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Plant</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="plant"
                                                name="plant">
                                            <option value="">Select Plant</option>
                                            @if(count($plants) > 0)
                                                <option value="All">All</option>
                                                @foreach($plants as $plant)
                                                    <option value="{{$plant->plant_id}}">{{$plant->plant_id}}
                                                        - {{$plant->plant_name}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <label for="lc_num"
                                           class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>LC number</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <select type="text" class="form-control input-xs filter-option pull-left" id="lc_num"
                                                name="lc_num">
                                            <option value="">Select LC</option>
                                            @if(count($lcNo) > 0)
                                                <option value="All">All</option>
                                                @foreach($lcNo as $lc)
                                                    <option value="{{$lc->lc_number}}">{{$lc->lc_number}}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled style="text-align: center">There is no data</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
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
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3">
                                    <label for="amount" class="col-md-3 col-sm-3 control-label fnt_size"
                                           style="padding-right:0px;"><b>Amount</b></label>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="number" id="amount" name="amount" class="form-control input-xs"
                                               value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12" style="text-align: center">
                            <button type="button" id="btn_display" class="btn btn-warning btn-sm"> <i class="fa fa-chevron-circle-up"></i> <b>Display Report</b></button>
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
    <div class="row" id="DisplayTableDiv" style="display: none">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        UPDATE DATA
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="DisplayTable">
                            <thead style="background-color: #c4c5ff;">
                            <tr>
                                <th class="text-center">ACTION</th>
                                <th class="text-center">PR NUMBER</th>
                                <th class="text-center">PO NUMBER</th>
                                <th class="text-center">PI/INDENT NUMBER</th>
                                <th class="text-center">PI DATE</th>
                                <th class="text-center">LC OPEN DATE</th>
                                <th class="text-center">LC NO</th>
                                <th class="text-center">BANK</th>
                                <th class="text-center">MATERIAL TYPE</th>
                                <th class="text-center">MATERIAL DESCRIPTION</th>
                                <th class="text-center">CURRENCY</th>
                                <th class="text-center">PI/LC VALUE</th>
                                <th class="text-center">BENEFICIARY/VENDOR NAME</th>
                                <th class="text-center">DELIVERY DATE (MATERIAL)</th>
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
                        <div class="col-sm-6 col-md-6" style="text-align: left;">
                            <button class="btn btn-primary btn-sm rounded-0" id="add_row" type="button">Split
                                amount</button>
                            <button class="btn btn-danger btn-sm rounded-0" id="delete_selected" type="button">Delete</button>
                        </div>
                        <div class="col-sm-6 col-md-6" style="text-align: right;">
                            <button class="btn btn-success btn-sm rounded-0" id="update_btn" type="button"
                                    style="background-color: #003eff; border-color: #003eff;">Update Data</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 table-responsive scrollbar" id="style-7">
                        <table class="table table-bordered table-condensed table-striped" id="updateMyTable">
                            <input type="hidden" id = 'update_row_ids' value="">
                            <thead style="background-color: #d7f898;">
                            <tr>
                                <th class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="SelectAll">
                                    </div>
                                </th>
                                <th class="text-center">PRODUCT TYPE</th>
                                <th class="text-center">YEAR</th>
                                <th class="text-center">MONTH</th>
                                <th class="text-center">PI DECISION DATE</th>
                                <th class="text-center">PR NUMBER</th>
                                <th class="text-center">PO NUMBER</th>
                                <th class="text-center">COUNTRY OF ORIGIN</th>
                                <th class="text-center">PI/INDENT NUMBER</th>
                                <th class="text-center">PI DATE</th>
                                <th class="text-center">LC OPEN YEAR</th>
                                <th class="text-center">LC OPEN MONTH</th>
                                <th class="text-center">LC OPEN DATE</th>
                                <th class="text-center">LC NO</th>
                                <th class="text-center">BANK</th>
                                <th class="text-center">LC OPEN STATUS</th>
                                <th class="text-center">COMPANY/FACILITY</th>
                                <th class="text-center">DIVISION</th>
                                <th class="text-center">MATERIAL TYPE</th>
                                <th class="text-center">MATERIAL DESCRIPTION</th>
                                <th class="text-center">TERMS OF PAYMENT</th>
                                <th class="text-center">LC TYPE</th>
                                <th class="text-center">CURRENCY</th>
                                <th class="text-center">PI/LC VALUE</th>
                                <th class="text-center">BDT VALUE</th>
                                <th class="text-center">BDT IN MILLION</th>
                                <th class="text-center">BENEFICIARY/VENDOR NAME</th>
                                <th class="text-center">PAYMENT TERMS</th>
                                <th class="text-center">MATERIAL RECEIVE STATUS</th>
                                <th class="text-center">TENTATIVE RECEIVED MONTH</th>
                                <th class="text-center">DELIVERY DATE (MATERIAL)</th>
                                <th class="text-center">TENTATIVE DUE MONTH</th>
                                <th class="text-center">ACCEPTANCE VALUE</th>
                                <th class="text-center">PAYMENT VALUE</th>
                                <th class="text-center">ACCEPTANCE/PAYMENT VALUE IN BDT</th>
                                <th class="text-center">ACCEPTANCE DATE</th>
                                <th class="text-center">DUE DATE ACTUAL</th>
                                <th class="text-center">DUE MONTH ACTUAL</th>
                                <th class="text-center">PAYMENT DATE</th>
                                <th class="text-center">PAYMENT MONTH</th>
                                <th class="text-center">STATUS</th>
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
        const ShortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];
        $(document).ready(function () {
            $('#plant').select2();
            $('#po_num').select2();
            $('#line_item').select2();
            $('#lc_num').select2();

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
                        temp['main_table_row_id'] = $('#updateMyTable #tableRow_id_'+id+' #main_table_row_id').val();
                        temp['pro_type'] = $('#updateMyTable #tableRow_id_'+id+' #pro_type').val();
                        temp['plant'] = $('#updateMyTable #tableRow_id_'+id+' #plantNo').val();
                        temp['lc_number'] = $('#updateMyTable #tableRow_id_'+id+' #LcNo').val();
                        temp['po_num'] = $('#updateMyTable #tableRow_id_'+id+' #PoNum').val();
                        temp['line_item'] = $('#updateMyTable #tableRow_id_'+id+' #LineItem').val();
                        temp['pi_dec_date'] = $('#updateMyTable #tableRow_id_'+id+' #pi_dec_date').val();
                        temp['origin_country'] = $('#updateMyTable #tableRow_id_'+id+' #origin_country').val();
                        temp['com_facility'] = $('#updateMyTable #tableRow_id_'+id+' #com_facility').val();
                        temp['division'] = $('#updateMyTable #tableRow_id_'+id+' #division').val();
                        temp['terms_of_pay'] = $('#updateMyTable #tableRow_id_'+id+' #terms_of_pay').val();
                        temp['pay_terms'] = $('#updateMyTable #tableRow_id_'+id+' #pay_terms').val();
                        temp['pi_value'] = $('#updateMyTable #tableRow_id_'+id+' #pi_value').val();
                        temp['accept_val'] = $('#updateMyTable #tableRow_id_'+id+' #accept_val').val();
                        temp['payment_val'] = $('#updateMyTable #tableRow_id_'+id+' #payment_val').val();
                        temp['accept_date'] = $('#updateMyTable #tableRow_id_'+id+' #accept_date').val();
                        temp['due_date_actual'] = $('#updateMyTable #tableRow_id_'+id+' #due_date_actual').val();
                        temp['payment_date'] = $('#updateMyTable #tableRow_id_'+id+' #payment_date').val();
                        temp['payment_status'] = $('#updateMyTable #tableRow_id_'+id+' #payment_status').val();
                        finalARr.push(temp);
                    }
                    // console.log(finalARr);
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/updateFinanceData')}}',
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
                                    text: 'Finance data is updated successfully!',
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
                                });
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

            $('#btn_display').on('click', function () {
                if($('#plant').val() === "" && $('#po_num').val() === "" && $('#line_item').val() === "" && $('#lc_num').val() === ""
                    && $('#amount').val() === ""){
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
                        url: '{{url('import_management/getDataForFinance')}}',
                        data: {
                            plant: $('#plant').val(),
                            po_num: $('#po_num').val(),
                            line_item: $('#line_item').val(),
                            lc_num: $('#lc_num').val(),
                            amount: $('#amount').val(),
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
                                        'btn-xs custom1" onclick="modifyData('+res[i]['id']+')">Click to ' +
                                        'modify</button></td>';

                                    if(res[i]['pr_num'] != null){
                                        tr += '<td>'+res[i]['pr_num']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['po_num'] != null){
                                        tr += '<td>'+res[i]['po_num']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_num'] != null){
                                        tr += '<td><p style="width: 120px">'+res[i]['pi_num']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_date'] != null){
                                        tr += '<td><p style="width: 65px;">'+moment(res[i]['pi_date']).format('YYYY-MM-DD')
                                            +'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_date'] != null){
                                        tr += '<td><p style="width: 65px;">'+moment(res[i]['lc_date']).format
                                        ('YYYY-MM-DD')+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_number'] != null){
                                        tr += '<td>'+res[i]['lc_number']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['bank_name'] != null){
                                        tr += '<td><p style="width: 120px">'+res[i]['bank_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['mat_heading'] != null){
                                        tr += '<td><p style="width:  200px;">'+res[i]['mat_heading']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['mat_desc'] != null){
                                        tr += '<td><p style="width:  200px;">'+res[i]['mat_desc']+'</p></td>';
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

                                    if(res[i]['vendor_name'] != null){
                                        tr += '<td><p style="width:200px;">'+res[i]['vendor_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['bank_deli_date'] != null){
                                        tr += '<td>'+moment(res[i]['bank_deli_date']).format('YYYY-MM-DD')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    tr += '</tr>';
                                }

                                $('#DisplayTable tbody').html(tr);
                                $('#DisplayTableDiv').show();
                                $('#DisplayTable').dataTable();
                            }else{
                                var tr = '';
                                tr += '<tr style="text-align: center;color: red">';
                                tr += '<td colspan="14">There is no data available!</td>';
                                tr += '</tr>';
                                $('#DisplayTable tbody').html(tr);
                                $('#DisplayTableDiv').show();
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
                            $('#DisplayTableDiv').hide();
                        }
                    })
                }
            });

            $('#add_row').click(function() {
                var rowIDs = $('#updateMyTable #update_row_ids').val();
                rowIDs = JSON.parse(rowIDs);
                var main_table_row_id = 0;
                var totalPIval = 0 ;
                var totalAccPayVal = 0;

                for(var c = 0; c < rowIDs.length; c++){
                    if($('#updateMyTable #tableRow_id_'+rowIDs[c]+' #row_type').val() === 'main'){
                        main_table_row_id = $('#updateMyTable #tableRow_id_'+rowIDs[c]+' #main_table_row_id')
                            .val();
                        totalPIval = parseFloat($('#updateMyTable #tableRow_id_'+rowIDs[c]+' #pi_value').val());
                        break;
                    }
                }

                if(totalPIval != 0){
                    for(var c = 0; c < rowIDs.length; c++){
                        if($('#updateMyTable #tableRow_id_'+rowIDs[c]+' #accept_val').val() != ''){
                            totalAccPayVal += parseFloat($('#updateMyTable #tableRow_id_'+rowIDs[c]+' #accept_val').val());
                        }
                        if($('#updateMyTable #tableRow_id_'+rowIDs[c]+' #payment_val').val() != ''){
                            totalAccPayVal += parseFloat($('#updateMyTable #tableRow_id_'+rowIDs[c]+' #payment_val').val());
                        }
                    }
                }

                if(totalPIval < totalAccPayVal || totalPIval === totalAccPayVal){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Total of split amount must be less than PI value!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                }else{
                    if(main_table_row_id !== 0){
                        if(rowIDs.length > 0){
                            var max_val = Math.max.apply(Math, rowIDs);
                            max_val++;
                        }else{
                            var max_val = 1;
                        }
                        rowIDs.push(max_val);
                        var rowIds = JSON.stringify(rowIDs);
                        $('#updateMyTable #update_row_ids').val(rowIds);

                        $.ajax({
                            type: 'post',
                            data: {
                                main_table_row_id: main_table_row_id,
                                _token: '{{csrf_token()}}'
                            },
                            url: '{{url('import_management/getFinanceMainRowData')}}',
                            success: function (data) {
                                // console.log(data);
                                var response = data.result;
                                var countryList = data.countryList;

                                if(response.length > 0){

                                    var tr = '';
                                    tr += '<tr id="tableRow_id_'+max_val+'" class="rowCount">';

                                    tr += '<td class=""><div class="form-check text-center"><input class="form-check-input row-item" ' +
                                        'type="checkbox"></div></td>';

                                    tr += '<input type="hidden" id="row_type" value="splitted">';
                                    tr += '<input type="hidden" id="main_table_row_id" value="'+response[0]['id']+'">';
                                    tr += '<input type="hidden" id="plantNo" value="'+response[0]['plant']+'">';
                                    tr += '<input type="hidden" id="LcNo" value="'+response[0]['lc_number']+'">';
                                    tr += '<input type="hidden" id="PoNum" value="'+response[0]['po_num']+'">';
                                    tr += '<input type="hidden" id="LineItem" value="'+response[0]['line_item']+'">';

                                    tr += '<td><select type="text" class="form-control input-xs" id="pro_type" ' +
                                        'name="pro_type" style="width:260px" onchange="changeProType('+max_val+')">' +
                                        '<option value="">Select product type</option>' +
                                        '<option value="RAW-PACK(ACCEPTANCE)">RAW-PACK(ACCEPTANCE)</option>' +
                                        '<option value="RAW-PACK(SIGHT)">RAW-PACK(SIGHT)</option>' +
                                        '<option value="CAPEX(ACCEPTANCE)">CAPEX(ACCEPTANCE)</option>' +
                                        '<option value="CAPEX(SIGHT)">CAPEX(SIGHT)</option></select></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="year" name="year" ' +
                                        'style="width: 70px" disabled></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="month" name="month" ' +
                                        'style="width: 70px" disabled></td>';

                                    tr += '<td><input type="date" class="form-control input-xs" id="pi_dec_date" name="pi_dec_date" ' +
                                        'style="width: 120px" value="" onchange="changePIdecDate('+max_val+')"></td>';

                                    tr += '<td>'+response[0]['pr_num']+'</td>';

                                    tr += '<td>'+response[0]['po_num']+'</td>';

                                    tr += '<td><select type="text" class="form-control input-xs" id="origin_country" name="origin_country" ' +
                                        'style="width: 170px;"><option value="">Select a country</option>';
                                    for(var y = 0; y < countryList.length > 0; y++){
                                        tr += '<option value="'+countryList[y]['country_name']+'">'+countryList[y]['country_name']+'</option>';
                                    }
                                    tr += '</select></td>';

                                    if(response[0]['pi_num'] == null){
                                        tr += '<td></td>';
                                    }else{
                                        tr += '<td><p style="width: 120px">'+response[0]['pi_num']+'</p></td>';
                                    }

                                    if(response[0]['pi_date'] == null){
                                        tr += '<td></td>';
                                    }else{
                                        tr += '<td><p style="width: 65px;">'+moment(response[0]['pi_date']).format
                                        ('YYYY-MM-DD')+'</p></td>';
                                    }

                                    if(response[0]['lc_date'] != null){
                                        tr += '<td>'+moment(response[0]['lc_date']).format('YYYY')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['lc_date'] != null){
                                        tr += '<td>'+moment(response[0]['lc_date']).format('MMM')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['lc_date'] != null){
                                        tr += '<td><p style="width: 65px;">'+moment(response[0]['lc_date']).format
                                        ('YYYY-MM-DD')+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['lc_number'] != null){
                                        tr += '<td>'+response[0]['lc_number']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['bank_name'] != null){
                                        tr += '<td><p style="width: 120px">'+response[0]['bank_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['lc_number'] != null){
                                        tr += '<td>Opened</td>';
                                    }else{
                                        tr += '<td>Not Opened</td>';
                                    }

                                    tr += '<td><input type="text" class="form-control input-xs" id="com_facility" ' +
                                        'name="com_facility" style="width: 160px" value=""></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="division" ' +
                                        'name="division" style="width: 160px"></td>';

                                    if(response[0]['mat_heading'] != null){
                                        tr += '<td><p style="width:  200px;">'+response[0]['mat_heading']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['mat_desc'] != null){
                                        tr += '<td><p style="width:  200px;">'+response[0]['mat_desc']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    tr += '<td><input type="text" class="form-control input-xs" id="terms_of_pay" ' +
                                        'name="terms_of_pay" style="width: 160px" onchange="changeTermsOfPayment('+max_val+')"></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="lc_type" ' +
                                        'name="lc_type" style="width: 100px" ' +
                                        'value="" disabled></td>';

                                    if(response[0]['currency'] != null){
                                        tr += '<td>'+response[0]['currency']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(response[0]['pi_value'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" ' +
                                            'name="pi_value" style="width: 150px" ' +
                                            'value="'+response[0]['pi_value']+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" ' +
                                            'name="pi_value" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(response[0]['currency_rate'] != '' && response[0]['pi_value'] != null){
                                        var curr_rate = response[0]['currency_rate'];
                                        var getBDTval = parseFloat(response[0]['pi_value'])*parseFloat
                                        (response[0]['currency_rate']);
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="bdt_value_pi_value" name="bdt_value_pi_value" style="width: 150px" ' +
                                            'value="'+getBDTval+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="bdt_value_pi_value" ' +
                                            'name="bdt_value_pi_value" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(response[0]['currency_rate'] != '' && response[0]['pi_value'] != null){
                                        var curr_rate = response[0]['currency_rate'];
                                        var getBDTvalinMill = (parseFloat(response[0]['pi_value'])*parseFloat
                                        (response[0]['currency_rate']))/1000000;
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="bdt_value_pi_value_in_mill" name="bdt_value_pi_value_in_mill" style="width: ' +
                                            '150px" ' +
                                            'value="'+getBDTvalinMill+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="bdt_value_pi_value_in_mill" ' +
                                            'name="bdt_value_pi_value_in_mill" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(response[0]['vendor_name'] != null){
                                        tr += '<td><p style="width:200px;">'+response[0]['vendor_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    tr += '<td><input type="number" class="form-control input-xs" id="pay_terms" ' +
                                        'name="pay_terms" style="width: 70px" value="" onchange="changePayTerms('+max_val+')"></td>';

                                    if(response[0]['bank_deli_date'] != null){
                                        tr += '<td>Rec</td>';
                                    }else{
                                        tr += '<td>Not Rec</td>';
                                    }

                                    if(response[0]['bank_deli_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="tent_recevd_month" name="tent_recevd_month" style="width: 150px" ' +
                                            'value="'+moment(response[0]['bank_deli_date']).format('MMM-YY')+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="tent_recevd_month" name="tent_recevd_month" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(response[0]['bank_deli_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="bank_deli_date" name="bank_deli_date" style="width: 150px" ' +
                                            'value="'+moment(response[0]['bank_deli_date']).format('YYYY-MM-DD')+'" ' +
                                            'disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="bank_deli_date" name="bank_deli_date" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    tr += '<td><input type="text" class="form-control input-xs" ' +
                                        'id="tent_due_months" ' +
                                        'name="tent_due_months" style="width: 150px" ' +
                                        'value="" disabled></td>';

                                    tr += '<input type="hidden" id="currency_rate" value="'+response[0]['currency_rate']+'">';

                                    tr += '<td><input type="number" class="form-control input-xs" id="accept_val" ' +
                                        'name="accept_val" style="width: 130px" onchange="changeAccpOrPayBDTinMill' +
                                        '('+max_val+')"></td>';

                                    tr += '<td><input type="number" class="form-control input-xs" id="payment_val" ' +
                                        'name="payment_val" style="width: 130px" onchange="changeAccpOrPayBDTinMill('+max_val+')"></td>';

                                    tr += '<td><input type="number" class="form-control input-xs" ' +
                                        'id="accp_pr_pay_BDT_in_Mill" name="accp_pr_pay_BDT_in_Mill" value="" disabled></td>';

                                    tr += '<td><input type="date" class="form-control input-xs" id="accept_date" name="accept_date" ' +
                                        'style="width: 120px"></td>';

                                    tr += '<td><input type="date" class="form-control input-xs" id="due_date_actual" name="due_date_actual" ' +
                                        'style="width: 120px" onchange="changeDueDateActu('+max_val+')"></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" ' +
                                        'id="due_month_actual" name="due_month_actual" style="width: 120px" ' +
                                        'value="" disabled></td>';

                                    tr += '<td><input type="date" class="form-control input-xs" id="payment_date" name="payment_date" ' +
                                        'style="width: 120px" onchange="changePaymentDate('+max_val+')"></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="payment_month" ' +
                                        'name="payment_month" disabled></td>';

                                    tr += '<td><input type="text" class="form-control input-xs" id="payment_status" name="payment_status" ' +
                                        'style="width: 100px" value="DUE" disabled></td>';

                                    tr += '</tr>';

                                    $('#updateMyTable tbody').append(tr);
                                    $('#updateMyTable #pro_type').select2();
                                    $('#updateMyTable #origin_country').select2();
                                }else{
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to fetch finance data!',
                                        icon: 'error',
                                        showConfirmButton: true,
                                        confirmButtonText: 'Ok'
                                    });
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                }
                // Row Item Change Event Listener

                $('tr').find('.row-item').change(function() {
                    if ($(".row-item").length == $(".row-item:checked").length) {
                        $('#SelectAll').prop('checked', true)
                    } else {
                        $('#SelectAll').prop('checked', false)
                    }
                })
            });

            $('#delete_selected').click(function() {
                var count = $('.row-item:checked').length
                if (count <= 0) {
                    Swal.fire({
                        title: 'Warning!',
                        icon: 'warning',
                        text: 'Please select at least one row to remove first.',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                } else {
                    $('.row-item:checked').closest('tr').remove();

                    var rem_ids = [];

                    $('#updateMyTable tbody tr').each(function() {
                        var myID = $(this).attr('id').split("_").pop();
                        myID = parseInt(myID);
                        rem_ids.push(myID);
                    });
                    var rowIds = JSON.stringify(rem_ids);
                    $('#updateMyTable #update_row_ids').val(rowIds);
                }
            })

            $('#SelectAll').change(function() {
                if ($(this).is(':checked') == true) {
                    $('.row-item').prop("checked", true)
                } else {
                    $('.row-item').prop("checked", false)

                }
            })

            $('.row-item').change(function() {
                if ($(".row-item").length == $(".row-item:checked").length) {
                    $('#SelectAll').prop('checked', true)
                } else {
                    $('#SelectAll').prop('checked', false)
                }
            })
        });
        function modifyData(row_id){
            $('#modifyBtn_'+row_id).empty();
            $('#modifyBtn_'+row_id).html('<i class="fa fa-spinner fa-spin"></i> Click to modify');

            $.ajax({
                type: 'post',
                url: '{{url('import_management/getFinanceInfo')}}',
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

                            if(res[i]['finance_data'].length > 0){
                                var financeData = res[i]['finance_data'];

                                for(var z = 0; z < financeData.length; z++){

                                    rowIds.push(parseInt(z+1));
                                    var tableRow_id = parseInt(z+1);

                                    tr += '<tr id="tableRow_id_'+tableRow_id+'" class="rowCount">';

                                    tr += '<td class=""><div class="form-check text-center"><input class="form-check-input row-item" ' +
                                        'type="checkbox"></div></td>';

                                    tr += '<input type="hidden" id="row_type" value="main">';
                                    tr += '<input type="hidden" id="main_table_row_id" value="'+financeData[z]['scm_mat_row_id']+'">';
                                    tr += '<input type="hidden" id="plantNo" value="'+res[i]['plant']+'">';
                                    tr += '<input type="hidden" id="LcNo" value="'+res[i]['lc_number']+'">';
                                    tr += '<input type="hidden" id="PoNum" value="'+res[i]['po_num']+'">';
                                    tr += '<input type="hidden" id="LineItem" value="'+res[i]['line_item']+'">';


                                    if(financeData[z]['pro_type'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="pro_type" ' +
                                            'name="pro_type" style="width:260px" onchange="changeProType('+tableRow_id+')">' +
                                            '<option value="">Select product type</option>' +
                                            '<option value="RAW-PACK(ACCEPTANCE)" '+(financeData[z]['pro_type'] === "RAW-PACK(ACCEPTANCE)" ? 'selected="selected"' : '')+'>RAW-PACK(ACCEPTANCE)</option>' +
                                            '<option value="RAW-PACK(SIGHT)" '+(financeData[z]['pro_type'] === "RAW-PACK(SIGHT)" ? 'selected="selected"' : '')+'>RAW-PACK(SIGHT)</option>' +
                                            '<option value="CAPEX(ACCEPTANCE)" '+(financeData[z]['pro_type'] === "CAPEX(ACCEPTANCE)" ? 'selected="selected"' : '')+'>CAPEX(ACCEPTANCE)</option>' +
                                            '<option value="CAPEX(SIGHT)" '+(financeData[z]['pro_type'] === "CAPEX(SIGHT)" ? 'selected="selected"' : '')+'>CAPEX(SIGHT)</option>' +
                                            '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="pro_type" ' +
                                            'name="pro_type" style="width:260px" onchange="changeProType('+tableRow_id+')">' +
                                            '<option value="">Select product type</option>' +
                                            '<option value="RAW-PACK(ACCEPTANCE)">RAW-PACK(ACCEPTANCE)</option>' +
                                            '<option value="RAW-PACK(SIGHT)">RAW-PACK(SIGHT)</option>' +
                                            '<option value="CAPEX(ACCEPTANCE)">CAPEX(ACCEPTANCE)</option>' +
                                            '<option value="CAPEX(SIGHT)">CAPEX(SIGHT)</option></select></td>';
                                    }

                                    if(financeData[z]['pi_dec_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="year" ' +
                                            'name="year" style="width: 70px" value="'+moment
                                            (financeData[z]['pi_dec_date']).format('YYYY')+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="year" name="year" ' +
                                            'style="width: 70px" disabled></td>';
                                    }

                                    if(financeData[z]['pi_dec_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="month" ' +
                                            'name="month" style="width: 70px" value="'+moment
                                            (financeData[z]['pi_dec_date']).format('MMM')+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="month" name="month" ' +
                                            'style="width: 70px" disabled></td>';
                                    }

                                    if(financeData[z]['pi_dec_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="pi_dec_date" name="pi_dec_date" ' +
                                            'style="width: 120px" value="'+moment(financeData[z]['pi_dec_date'])
                                                .format('YYYY-MM-DD')+'" onchange="changePIdecDate('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="pi_dec_date" name="pi_dec_date" ' +
                                            'style="width: 120px" onchange="changePIdecDate('+tableRow_id+')"></td>';
                                    }

                                    tr += '<td>'+res[i]['pr_num']+'</td>';

                                    tr += '<td>'+res[i]['po_num']+'</td>';

                                    if(financeData[z]['origin_country'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="origin_country" name="origin_country" ' +
                                            'style="width: 170px;"><option value="">Select a country</option>';
                                        for(var y = 0; y < response.countryList.length > 0; y++){
                                            if(financeData[z]['origin_country'] == response.countryList[y]['country_name']){
                                                tr += '<option value="'+response.countryList[y]['country_name']+'" ' +
                                                    'selected>'+response.countryList[y]['country_name']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.countryList[y]['country_name']+'">'+response
                                                    .countryList[y]['country_name']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="origin_country" name="origin_country" ' +
                                            'style="width: 170px;"><option value="">Select a country</option>';
                                        for(var y = 0; y < response.countryList.length > 0; y++){
                                            tr += '<option value="'+response.countryList[y]['country_name']+'">'+response
                                                .countryList[y]['country_name']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['pi_num'] == null){
                                        tr += '<td></td>';
                                    }else{
                                        tr += '<td><p style="width: 120px">'+res[i]['pi_num']+'</p></td>';
                                    }

                                    if(res[i]['pi_date'] == null){
                                        tr += '<td></td>';
                                    }else{
                                        tr += '<td><p style="width: 65px;">'+moment(res[i]['pi_date']).format('YYYY-MM-DD')
                                            +'</p></td>';
                                    }

                                    if(res[i]['lc_date'] != null){
                                        tr += '<td>'+moment(res[i]['lc_date']).format('YYYY')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_date'] != null){
                                        tr += '<td>'+moment(res[i]['lc_date']).format('MMM')+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_date'] != null){
                                        tr += '<td><p style="width: 65px;">'+moment(res[i]['lc_date']).format
                                        ('YYYY-MM-DD')+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_number'] != null){
                                        tr += '<td>'+res[i]['lc_number']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['bank_name'] != null){
                                        tr += '<td><p style="width: 120px">'+res[i]['bank_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_number'] != null){
                                        tr += '<td>Opened</td>';
                                    }else{
                                        tr += '<td>Not Opened</td>';
                                    }

                                    if(financeData[z]['com_facility'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="com_facility" ' +
                                            'name="com_facility" style="width: 160px" value="'+financeData[z]['com_facility']+'"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="com_facility" ' +
                                            'name="com_facility" style="width: 160px"></td>';
                                    }

                                    if(financeData[z]['division'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="division" ' +
                                            'name="division" style="width: 160px" value="'+financeData[z]['division']+'"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="division" ' +
                                            'name="division" style="width: 160px"></td>';
                                    }

                                    if(res[i]['mat_heading'] != null){
                                        tr += '<td><p style="width:  200px;">'+res[i]['mat_heading']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['mat_desc'] != null){
                                        tr += '<td><p style="width:  200px;">'+res[i]['mat_desc']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(financeData[z]['terms_of_pay'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="terms_of_pay" ' +
                                            'name="terms_of_pay" style="width: 160px" ' +
                                            'value="'+financeData[z]['terms_of_pay']+'" onchange="changeTermsOfPayment('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="terms_of_pay" ' +
                                            'name="terms_of_pay" style="width: 160px" onchange="changeTermsOfPayment('+tableRow_id+')"></td>';
                                    }

                                    if(financeData[z]['terms_of_pay'] != null){
                                        var lc_type_val = '';
                                        if(financeData[z]['terms_of_pay'].toUpperCase() == 'UPAS-180'){
                                            lc_type_val = 'DP';
                                        }else if(financeData[z]['terms_of_pay'].toUpperCase() == 'UPAS-360'){
                                            lc_type_val = 'DP';
                                        }else if(financeData[z]['terms_of_pay'].toUpperCase() == 'UPAS-270'){
                                            lc_type_val = 'DP';
                                        }else if(financeData[z]['terms_of_pay'].toUpperCase() == 'SIGHT'){
                                            lc_type_val = 'S';
                                        }else{
                                            lc_type_val = 'S';
                                        }
                                        tr += '<td><input type="text" class="form-control input-xs" id="lc_type" ' +
                                            'name="lc_type" style="width: 100px" ' +
                                            'value="'+lc_type_val+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="lc_type" ' +
                                            'name="lc_type" style="width: 100px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(res[i]['currency'] != null){
                                        tr += '<td>'+res[i]['currency']+'</td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_value'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" ' +
                                            'name="pi_value" style="width: 150px" ' +
                                            'value="'+res[i]['pi_value']+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" ' +
                                            'name="pi_value" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                        var curr_rate = res[i]['currency_rate'];
                                        var getBDTval = parseFloat(res[i]['pi_value'])*parseFloat
                                        (res[i]['currency_rate']);
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="bdt_value_pi_value" name="bdt_value_pi_value" style="width: 150px" ' +
                                            'value="'+getBDTval+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="bdt_value_pi_value" ' +
                                            'name="bdt_value_pi_value" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                        var curr_rate = res[i]['currency_rate'];
                                        var getBDTvalinMill = (parseFloat(res[i]['pi_value'])*parseFloat
                                        (res[i]['currency_rate']))/1000000;
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="bdt_value_pi_value_in_mill" name="bdt_value_pi_value_in_mill" style="width: ' +
                                            '150px" ' +
                                            'value="'+getBDTvalinMill+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="bdt_value_pi_value_in_mill" ' +
                                            'name="bdt_value_pi_value_in_mill" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(res[i]['vendor_name'] != null){
                                        tr += '<td><p style="width:200px;">'+res[i]['vendor_name']+'</p></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(financeData[z]['pay_terms'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="pay_terms" name="pay_terms" style="width: 70px" ' +
                                            'value="'+financeData[z]['pay_terms']+'" onchange="changePayTerms('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="pay_terms" ' +
                                            'name="pay_terms" style="width: 70px" onchange="changePayTerms('+tableRow_id+')"></td>';
                                    }

                                    if(res[i]['bank_deli_date'] != null){
                                        tr += '<td>Rec</td>';
                                    }else{
                                        tr += '<td>Not Rec</td>';
                                    }

                                    if(res[i]['bank_deli_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="tent_recevd_month" name="tent_recevd_month" style="width: 150px" ' +
                                            'value="'+ moment(res[i]['bank_deli_date']).format('MMM-YY')+'" ' +
                                            'disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="tent_recevd_month" name="tent_recevd_month" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(res[i]['bank_deli_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="bank_deli_date" name="bank_deli_date" style="width: 150px" ' +
                                            'value="'+moment(res[i]['bank_deli_date']).format('YYYY-MM-DD')+'" ' +
                                            'disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="bank_deli_date" name="bank_deli_date" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    if(res[i]['bank_deli_date'] != null && financeData[z]['pay_terms'] != null){
                                        var payterms = parseInt(financeData[z]['pay_terms']);
                                        var tentDueMonths = moment(res[i]['bank_deli_date']).add(payterms,'days');

                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="tent_due_months" name="tent_due_months" style="width: 150px" ' +
                                            'value="'+ moment(tentDueMonths).format('MMM-YY')+'" ' +
                                            'disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="tent_due_months" ' +
                                            'name="tent_due_months" style="width: 150px" ' +
                                            'value="" disabled></td>';
                                    }

                                    tr += '<input type="hidden" id="currency_rate" value="'+res[i]['currency_rate']+'">';

                                    if(financeData[z]['accept_val'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="accept_val" name="accept_val" style="width: 130px" ' +
                                            'value="'+financeData[z]['accept_val']+'" onchange="changeAccpOrPayBDTinMill('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="accept_val" ' +
                                            'name="accept_val" style="width: 130px" onchange="changeAccpOrPayBDTinMill('+tableRow_id+')"></td>';
                                    }

                                    if(financeData[z]['payment_val'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="payment_val" name="payment_val" style="width: 130px" ' +
                                            'value="'+financeData[z]['payment_val']+'" onchange="changeAccpOrPayBDTinMill('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="payment_val" ' +
                                            'name="payment_val" style="width: 130px" onchange="changeAccpOrPayBDTinMill('+tableRow_id+')"></td>';
                                    }

                                    if(financeData[z]['accept_val'] != null){
                                        if(res[i]['currency_rate'] != ''){
                                            var curr_rate = res[i]['currency_rate'];
                                            var getAccBDTvalinMill = (parseFloat(financeData[z]['accept_val'])*parseFloat
                                            (res[i]['currency_rate']))/1000000;
                                            tr += '<td><input type="number" class="form-control input-xs" ' +
                                                'id="accp_pr_pay_BDT_in_Mill" name="accp_pr_pay_BDT_in_Mill" value="'+getAccBDTvalinMill+'" disabled></td>';
                                        }else{
                                            tr += '<td><input type="number" class="form-control input-xs" ' +
                                                'id="accp_pr_pay_BDT_in_Mill" name="accp_pr_pay_BDT_in_Mill" value="" disabled></td>';
                                        }
                                    }else{
                                        if(res[i]['currency_rate'] != ''){
                                            var curr_rate = res[i]['currency_rate'];
                                            var getPayBDTvalinMill = (parseFloat(financeData[z]['payment_val'])
                                                *parseFloat(res[i]['currency_rate']))/1000000;
                                            tr += '<td><input type="number" class="form-control input-xs" ' +
                                                'id="accp_pr_pay_BDT_in_Mill" name="accp_pr_pay_BDT_in_Mill" value="'+getPayBDTvalinMill+'" disabled></td>';
                                        }else{
                                            tr += '<td><input type="number" class="form-control input-xs" ' +
                                                'id="accp_pr_pay_BDT_in_Mill" name="accp_pr_pay_BDT_in_Mill" value="" disabled></td>';
                                        }
                                    }

                                    if(financeData[z]['accept_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="accept_date" name="accept_date" ' +
                                            'style="width: 120px" value="'+moment(financeData[z]['accept_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="accept_date" name="accept_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(financeData[z]['due_date_actual'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="due_date_actual" name="due_date_actual" ' +
                                            'style="width: 120px" value="'+moment(financeData[z]['due_date_actual'])
                                                .format('YYYY-MM-DD')+'" onchange="changeDueDateActu('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="due_date_actual" name="due_date_actual" ' +
                                            'style="width: 120px" onchange="changeDueDateActu('+tableRow_id+')"></td>';
                                    }

                                    if(financeData[z]['due_date_actual'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="due_month_actual" name="due_month_actual" ' +
                                            'style="width: 120px" value="'+moment(financeData[z]['due_date_actual'])
                                                .format('MMM-YY')+'"></td>';
                                    }else{
                                        if(res[i]['bank_deli_date'] != null && financeData[z]['pay_terms'] != null){
                                            var payterms = parseInt(financeData[z]['pay_terms']);
                                            var tentDueMonths = moment(res[i]['bank_deli_date']).add(payterms,'days');

                                            tr += '<td><input type="text" class="form-control input-xs" ' +
                                                'id="due_month_actual" name="due_month_actual" style="width: 120px" ' +
                                                'value="'+ moment(tentDueMonths).format('MMM-YY')+'" ' +
                                                'disabled></td>';
                                        }else{
                                            tr += '<td><input type="text" class="form-control input-xs" ' +
                                                'id="due_month_actual" ' +
                                                'name="due_month_actual" style="width: 120px" ' +
                                                'value="" disabled></td>';
                                        }
                                    }

                                    if(financeData[z]['payment_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="payment_date" name="payment_date" ' +
                                            'style="width: 120px" value="'+moment(financeData[z]['payment_date'])
                                                .format('YYYY-MM-DD')+'" onchange="changePaymentDate('+tableRow_id+')"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="payment_date" name="payment_date" ' +
                                            'style="width: 120px" onchange="changePaymentDate('+tableRow_id+')"></td>';
                                    }

                                    if(financeData[z]['payment_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="payment_month" ' +
                                            'name="payment_month" value="'+moment(financeData[z]['payment_date']).format('MMM')+'" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="payment_month" name="payment_month" disabled></td>';
                                    }

                                    if(financeData[z]['payment_date'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" ' +
                                            'id="payment_status" ' +
                                            'name="payment_status" style="width: 100px" value="PAID" disabled></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="payment_status" name="payment_status" ' +
                                            'style="width: 100px" value="DUE" disabled></td>';
                                    }

                                    tr += '</tr>';
                                }
                            }
                            else{
                                rowIds.push(parseInt(i+1));
                                var tableRow_id = parseInt(i+1);

                                tr += '<tr id="tableRow_id_'+tableRow_id+'" class="rowCount">';

                                tr += '<td class=""><div class="form-check text-center"><input class="form-check-input row-item" ' +
                                    'type="checkbox"></div></td>';

                                tr += '<input type="hidden" id="row_type" value="main">';
                                tr += '<input type="hidden" id="main_table_row_id" value="'+res[i]['id']+'">';
                                tr += '<input type="hidden" id="plantNo" value="'+res[i]['plant']+'">';
                                tr += '<input type="hidden" id="LcNo" value="'+res[i]['lc_number']+'">';
                                tr += '<input type="hidden" id="PoNum" value="'+res[i]['po_num']+'">';
                                tr += '<input type="hidden" id="LineItem" value="'+res[i]['line_item']+'">';

                                tr += '<td><select type="text" class="form-control input-xs" id="pro_type" ' +
                                    'name="pro_type" style="width:260px" onchange="changeProType('+tableRow_id+')">' +
                                    '<option value="">Select product type</option>' +
                                    '<option value="RAW-PACK(ACCEPTANCE)">RAW-PACK(ACCEPTANCE)</option>' +
                                    '<option value="RAW-PACK(SIGHT)">RAW-PACK(SIGHT)</option>' +
                                    '<option value="CAPEX(ACCEPTANCE)">CAPEX(ACCEPTANCE)</option>' +
                                    '<option value="CAPEX(SIGHT)">CAPEX(SIGHT)</option></select></td>';

                                tr += '<td><input type="text" class="form-control input-xs" id="year" name="year" ' +
                                    'style="width: 70px" disabled></td>';

                                tr += '<td><input type="text" class="form-control input-xs" id="month" name="month" ' +
                                    'style="width: 70px" disabled></td>';

                                tr += '<td><input type="date" class="form-control input-xs" id="pi_dec_date" name="pi_dec_date" ' +
                                    'style="width: 120px" value="" onchange="changePIdecDate('+tableRow_id+')"></td>';

                                tr += '<td>'+res[i]['pr_num']+'</td>';

                                tr += '<td>'+res[i]['po_num']+'</td>';

                                tr += '<td><select type="text" class="form-control input-xs" id="origin_country" name="origin_country" ' +
                                    'style="width: 170px;"><option value="">Select a country</option>';
                                for(var y = 0; y < response.countryList.length > 0; y++){
                                    tr += '<option value="'+response.countryList[y]['country_name']+'">'+response
                                        .countryList[y]['country_name']+'</option>';
                                }
                                tr += '</select></td>';

                                if(res[i]['pi_num'] == null){
                                    tr += '<td></td>';
                                }else{
                                    tr += '<td><p style="width: 120px">'+res[i]['pi_num']+'</p></td>';
                                }

                                if(res[i]['pi_date'] == null){
                                    tr += '<td></td>';
                                }else{
                                    tr += '<td><p style="width: 65px;">'+moment(res[i]['pi_date']).format('YYYY-MM-DD')
                                        +'</p></td>';
                                }

                                if(res[i]['lc_date'] != null){
                                    tr += '<td>'+moment(res[i]['lc_date']).format('YYYY')+'</td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['lc_date'] != null){
                                    tr += '<td>'+moment(res[i]['lc_date']).format('MMM')+'</td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['lc_date'] != null){
                                    tr += '<td><p style="width: 65px;">'+moment(res[i]['lc_date']).format
                                    ('YYYY-MM-DD')+'</p></td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['lc_number'] != null){
                                    tr += '<td>'+res[i]['lc_number']+'</td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['bank_name'] != null){
                                    tr += '<td><p style="width: 120px">'+res[i]['bank_name']+'</p></td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['lc_number'] != null){
                                    tr += '<td>Opened</td>';
                                }else{
                                    tr += '<td>Not Opened</td>';
                                }

                                tr += '<td><input type="text" class="form-control input-xs" id="com_facility" ' +
                                    'name="com_facility" style="width: 160px" value=""></td>';

                                tr += '<td><input type="text" class="form-control input-xs" id="division" ' +
                                    'name="division" style="width: 160px"></td>';

                                if(res[i]['mat_heading'] != null){
                                    tr += '<td><p style="width:  200px;">'+res[i]['mat_heading']+'</p></td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['mat_desc'] != null){
                                    tr += '<td><p style="width:  200px;">'+res[i]['mat_desc']+'</p></td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                tr += '<td><input type="text" class="form-control input-xs" id="terms_of_pay" ' +
                                    'name="terms_of_pay" style="width: 160px" onchange="changeTermsOfPayment('+tableRow_id+')"></td>';

                                tr += '<td><input type="text" class="form-control input-xs" id="lc_type" ' +
                                    'name="lc_type" style="width: 100px" ' +
                                    'value="" disabled></td>';

                                if(res[i]['currency'] != null){
                                    tr += '<td>'+res[i]['currency']+'</td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                if(res[i]['pi_value'] != null){
                                    tr += '<td><input type="number" class="form-control input-xs" id="pi_value" ' +
                                        'name="pi_value" style="width: 150px" ' +
                                        'value="'+res[i]['pi_value']+'" disabled></td>';
                                }else{
                                    tr += '<td><input type="number" class="form-control input-xs" id="pi_value" ' +
                                        'name="pi_value" style="width: 150px" ' +
                                        'value="" disabled></td>';
                                }

                                if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                    var curr_rate = res[i]['currency_rate'];
                                    var getBDTval = parseFloat(res[i]['pi_value'])*parseFloat
                                    (res[i]['currency_rate']);
                                    tr += '<td><input type="number" class="form-control input-xs" ' +
                                        'id="bdt_value_pi_value" name="bdt_value_pi_value" style="width: 150px" ' +
                                        'value="'+getBDTval+'" disabled></td>';
                                }else{
                                    tr += '<td><input type="number" class="form-control input-xs" id="bdt_value_pi_value" ' +
                                        'name="bdt_value_pi_value" style="width: 150px" ' +
                                        'value="" disabled></td>';
                                }

                                if(res[i]['currency_rate'] != '' && res[i]['pi_value'] != null){
                                    var curr_rate = res[i]['currency_rate'];
                                    var getBDTvalinMill = (parseFloat(res[i]['pi_value'])*parseFloat
                                    (res[i]['currency_rate']))/1000000;
                                    tr += '<td><input type="number" class="form-control input-xs" ' +
                                        'id="bdt_value_pi_value_in_mill" name="bdt_value_pi_value_in_mill" style="width: ' +
                                        '150px" ' +
                                        'value="'+getBDTvalinMill+'" disabled></td>';
                                }else{
                                    tr += '<td><input type="number" class="form-control input-xs" id="bdt_value_pi_value_in_mill" ' +
                                        'name="bdt_value_pi_value_in_mill" style="width: 150px" ' +
                                        'value="" disabled></td>';
                                }

                                if(res[i]['vendor_name'] != null){
                                    tr += '<td><p style="width:200px;">'+res[i]['vendor_name']+'</p></td>';
                                }else{
                                    tr += '<td></td>';
                                }

                                tr += '<td><input type="number" class="form-control input-xs" id="pay_terms" ' +
                                    'name="pay_terms" style="width: 70px" value="" onchange="changePayTerms('+tableRow_id+')"></td>';

                                if(res[i]['bank_deli_date'] != null){
                                    tr += '<td>Rec</td>';
                                }else{
                                    tr += '<td>Not Rec</td>';
                                }

                                if(res[i]['bank_deli_date'] != null){
                                    tr += '<td><input type="text" class="form-control input-xs" ' +
                                        'id="tent_recevd_month" name="tent_recevd_month" style="width: 150px" ' +
                                        'value="'+moment(res[i]['bank_deli_date']).format('MMM-YY')+'" disabled></td>';
                                }else{
                                    tr += '<td><input type="text" class="form-control input-xs" ' +
                                        'id="tent_recevd_month" name="tent_recevd_month" style="width: 150px" ' +
                                        'value="" disabled></td>';
                                }

                                if(res[i]['bank_deli_date'] != null){
                                    tr += '<td><input type="text" class="form-control input-xs" ' +
                                        'id="bank_deli_date" name="bank_deli_date" style="width: 150px" ' +
                                        'value="'+moment(res[i]['bank_deli_date']).format('YYYY-MM-DD')+'" ' +
                                        'disabled></td>';
                                }else{
                                    tr += '<td><input type="text" class="form-control input-xs" ' +
                                        'id="bank_deli_date" name="bank_deli_date" style="width: 150px" ' +
                                        'value="" disabled></td>';
                                }

                                tr += '<td><input type="text" class="form-control input-xs" ' +
                                    'id="tent_due_months" ' +
                                    'name="tent_due_months" style="width: 150px" ' +
                                    'value="" disabled></td>';

                                tr += '<input type="hidden" id="currency_rate" value="'+res[i]['currency_rate']+'">';

                                tr += '<td><input type="number" class="form-control input-xs" id="accept_val" ' +
                                    'name="accept_val" style="width: 130px" onchange="changeAccpOrPayBDTinMill' +
                                    '('+tableRow_id+')"></td>';

                                tr += '<td><input type="number" class="form-control input-xs" id="payment_val" ' +
                                    'name="payment_val" style="width: 130px" onchange="changeAccpOrPayBDTinMill('+tableRow_id+')"></td>';

                                tr += '<td><input type="number" class="form-control input-xs" ' +
                                    'id="accp_pr_pay_BDT_in_Mill" name="accp_pr_pay_BDT_in_Mill" value="" disabled></td>';

                                tr += '<td><input type="date" class="form-control input-xs" id="accept_date" name="accept_date" ' +
                                    'style="width: 120px"></td>';

                                tr += '<td><input type="date" class="form-control input-xs" id="due_date_actual" name="due_date_actual" ' +
                                    'style="width: 120px" onchange="changeDueDateActu('+tableRow_id+')"></td>';

                                tr += '<td><input type="text" class="form-control input-xs" ' +
                                    'id="due_month_actual" name="due_month_actual" style="width: 120px" ' +
                                    'value="" disabled></td>';

                                tr += '<td><input type="date" class="form-control input-xs" id="payment_date" name="payment_date" ' +
                                    'style="width: 120px" onchange="changePaymentDate('+tableRow_id+')"></td>';

                                tr += '<td><input type="text" class="form-control input-xs" id="payment_month" ' +
                                    'name="payment_month" disabled></td>';

                                tr += '<td><input type="text" class="form-control input-xs" id="payment_status" name="payment_status" ' +
                                    'style="width: 100px" value="DUE" disabled></td>';

                                tr += '</tr>';
                            }
                        }

                        var finalRowIds = JSON.stringify(rowIds);
                        $('#updateMyTable #update_row_ids').val(finalRowIds);
                        $('#updateMyTable tbody').html(tr);
                        $('#updateTableDiv').show();
                        $('#update_btn').show();

                        $('#updateMyTable #origin_country').select2();
                        $('#updateMyTable #pro_type').select2();

                        $('#modifyBtn_'+row_id).empty();
                        $('#modifyBtn_'+row_id).html('Click to modify');
                    }else{
                        var tr = '';
                        tr += '<tr style="text-align: center;color: red">';
                        tr += '<td colspan="40">There is no data available!</td>';
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
            });
        }
        function changeTermsOfPayment(row_id){
            var terms_of_pay = $('#updateMyTable #tableRow_id_'+row_id+' #terms_of_pay').val();
            if(terms_of_pay.toUpperCase() == 'UPAS-180'){
                $('#updateMyTable #tableRow_id_'+row_id+' #lc_type').val('DP');
            }else if(terms_of_pay.toUpperCase() == 'UPAS-360'){
                $('#updateMyTable #tableRow_id_'+row_id+' #lc_type').val('DP');
            }else if(terms_of_pay.toUpperCase() == 'UPAS-270'){
                $('#updateMyTable #tableRow_id_'+row_id+' #lc_type').val('DP');
            }else if(terms_of_pay.toUpperCase() == 'SIGHT'){
                $('#updateMyTable #tableRow_id_'+row_id+' #lc_type').val('S');
            }else if(terms_of_pay.toUpperCase() == 'CAD'){
                $('#updateMyTable #tableRow_id_'+row_id+' #lc_type').val('S');
            }else{
                $('#updateMyTable #tableRow_id_'+row_id+' #lc_type').val('');
            }
        }
        function changePayTerms(row_id){
            var pay_terms = parseInt($('#updateMyTable #tableRow_id_'+row_id+' #pay_terms').val());
            var bank_deli_date = $('#updateMyTable #tableRow_id_'+row_id+' #bank_deli_date').val();
            if(pay_terms !== '' && bank_deli_date !== ''){
                var tentDueMonths = moment(bank_deli_date).add(pay_terms,'days');
                $('#updateMyTable #tableRow_id_'+row_id+' #tent_due_months').val(moment(tentDueMonths).format('MMM-YY'));

                if($('#updateMyTable #tableRow_id_'+row_id+' #due_date_actual').val() === ''){
                    $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val(moment(tentDueMonths).format('MMM-YY'));
                }else{
                    var due_date_actual = $('#updateMyTable #tableRow_id_'+row_id+' #due_date_actual').val();
                    $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val(moment(due_date_actual).format('MMM-YY'));
                }
            }else{
                $('#updateMyTable #tableRow_id_'+row_id+' #tent_due_months').val('');
                if($('#updateMyTable #tableRow_id_'+row_id+' #due_date_actual').val() === ''){
                    $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val('');
                }else{
                    var due_date_actual = $('#updateMyTable #tableRow_id_'+row_id+' #due_date_actual').val();
                    $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val(moment(due_date_actual).format('MMM-YY'));
                }
            }
        }
        function changeAccpOrPayBDTinMill(row_id){
            var accept_val = $('#updateMyTable #tableRow_id_'+row_id+' #accept_val').val();
            var payment_val = $('#updateMyTable #tableRow_id_'+row_id+' #payment_val').val();
            var currency_rate = $('#updateMyTable #tableRow_id_'+row_id+' #currency_rate').val();
            if(accept_val !== '' && currency_rate !== ''){
                var getAccBDTvalinMill = (parseFloat(accept_val)*parseFloat
                (currency_rate))/1000000;
                $('#updateMyTable #tableRow_id_'+row_id+' #accp_pr_pay_BDT_in_Mill').val(getAccBDTvalinMill);
            }else if(payment_val !== '' && currency_rate !== ''){
                var getAccBDTvalinMill = (parseFloat(payment_val)*parseFloat
                (currency_rate))/1000000;
                $('#updateMyTable #tableRow_id_'+row_id+' #accp_pr_pay_BDT_in_Mill').val(getAccBDTvalinMill);
            }else{
                $('#updateMyTable #tableRow_id_'+row_id+' #accp_pr_pay_BDT_in_Mill').val('');
            }
        }
        function changeProType(row_id){
            var pro_type = $('#updateMyTable #tableRow_id_'+row_id+' #pro_type').val();
            if(pro_type === 'RAW-PACK(ACCEPTANCE)' || pro_type === 'CAPEX(ACCEPTANCE)'){
                $('#updateMyTable #tableRow_id_'+row_id+' #accept_val').prop('disabled', false);
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_val').prop('disabled', true);
            }else if(pro_type === 'RAW-PACK(SIGHT)' || pro_type === 'CAPEX(SIGHT)'){
                $('#updateMyTable #tableRow_id_'+row_id+' #accept_val').prop('disabled', true);
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_val').prop('disabled', false);
            }else{
                $('#updateMyTable #tableRow_id_'+row_id+' #accept_val').prop('disabled', false);
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_val').prop('disabled', false);
            }
            $('#updateMyTable #tableRow_id_'+row_id+' #accept_val').val('');
            $('#updateMyTable #tableRow_id_'+row_id+' #payment_val').val('');
            $('#updateMyTable #tableRow_id_'+row_id+' #accp_pr_pay_BDT_in_Mill').val('');
        }
        function changeDueDateActu(row_id){
            if($('#updateMyTable #tableRow_id_'+row_id+' #due_date_actual').val() === ''){
                $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val('');
                var pay_terms = parseInt($('#updateMyTable #tableRow_id_'+row_id+' #pay_terms').val());
                var bank_deli_date = $('#updateMyTable #tableRow_id_'+row_id+' #bank_deli_date').val();
                if(pay_terms !== '' && bank_deli_date !== ''){
                    var tentDueMonths = moment(bank_deli_date).add(pay_terms,'days');
                    $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val(moment(tentDueMonths).format('MMM-YY'));
                }
            }else{
                var due_date_actual = $('#updateMyTable #tableRow_id_'+row_id+' #due_date_actual').val();
                $('#updateMyTable #tableRow_id_'+row_id+' #due_month_actual').val(moment(due_date_actual).format('MMM-YY'));
            }
        }
        function changePaymentDate(row_id){
            var payment_date = $('#updateMyTable #tableRow_id_'+row_id+' #payment_date').val();
            if(payment_date !== ''){
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_month').val(moment(payment_date).format('MMM-YY'));
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_status').val('PAID');
            }else{
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_month').val('');
                $('#updateMyTable #tableRow_id_'+row_id+' #payment_status').val('DUE');
            }
        }
        function changePIdecDate(row_id){
            var check = moment($('#updateMyTable #tableRow_id_'+row_id+' #pi_dec_date').val(), 'YYYY/MM/DD');
            var month = check.format('M');
            var year  = check.format('YYYY');
            $('#updateMyTable #tableRow_id_'+row_id+' #year').val(year);
            $('#updateMyTable #tableRow_id_'+row_id+' #month').val(ShortMonthNames[month-1]);
        }
    </script>
@endsection
