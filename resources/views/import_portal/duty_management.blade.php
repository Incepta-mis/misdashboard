@extends('_layout_shared._master')
@section('title','CUSTOMS DUTY PAYMENT STATUS')
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

        #updateMyTable {
            max-height: 500px;
            box-sizing: border-box;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        CUSTOMS DUTY PAYMENT STATUS
                    </label>
                </header>
                <div class="panel-body" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6">
                                    <label for="lc_num" class="form-label"><b>LC number</b></label>
                                    <input class="form-control" value=""
                                           placeholder="Input LC number" type="text" id="lc_num">
                                    <div id="lc_numList">
                                        <ul>
                                        </ul>
                                    </div>
                                    <p class="card-title-desc">Hit Enter or type , or hit space after you
                                        type a LC number. If needed, click to remove.</p>
                                    <textarea id="lcNumJson" value="" style="display: none">[]</textarea>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <label for="po_num" class="form-label"><b>PO Number</b></label>
                                    <input class="form-control" value=""
                                           placeholder="Input PO number" type="text" id="po_num" name="po_num">
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
                            <thead style="background-color: #c4c5ff;">
                            <tr>
                                <th class="text-center">PLANT</th>
                                <th class="text-center">PO NUMBER</th>
                                <th class="text-center">LC NUMBER</th>
                                <th class="text-center">PI/LC VALUE</th>
                                <th class="text-center">MATERIAL NAME</th>
                                <th class="text-center">PAYMENT MODE</th>
                                <th class="text-center">CUSTOMS HOUSE</th>
                                <th class="text-center">B/E NO.</th>
                                <th class="text-center">B/E DATE</th>
                                <th class="text-center">C&F</th>
                                <th class="text-center">DECLARANT NO.</th>
                                <th class="text-center">AMOUNT (BDT.)</th>
                                <th class="text-center">DUTY DATE</th>
                                <th class="text-center">DUTY TIME</th>
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
            var addLcNums = new AddLCnums();
            addLcNums.init();

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
                        temp['duty_pay_mode'] = $('#updateMyTable #tableRow_id_'+id+' #duty_pay_mode').val();
                        temp['customs_house'] = $('#updateMyTable #tableRow_id_'+id+' #customs_house').val();
                        temp['b_e_no'] = $('#updateMyTable #tableRow_id_'+id+' #b_e_no').val();
                        temp['b_e_date'] = $('#updateMyTable #tableRow_id_'+id+' #b_e_date').val();
                        temp['c_and_f'] = $('#updateMyTable #tableRow_id_'+id+' #c_and_f').val();
                        temp['declarant_no'] = $('#updateMyTable #tableRow_id_'+id+' #declarant_no').val();
                        temp['duty_amount'] = $('#updateMyTable #tableRow_id_'+id+' #duty_amount').val();
                        temp['duty_date'] = $('#updateMyTable #tableRow_id_'+id+' #duty_date').val();
                        temp['duty_time'] = $('#updateMyTable #tableRow_id_'+id+' #duty_time').val();
                        finalARr.push(temp);
                    }
                    // console.log(finalARr);
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/updateDutyData')}}',
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
                                    text: 'Duty payment status is updated successfully!',
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

            $('#btn_display').on('click', function () {

                var lcNum = JSON.parse($('#lcNumJson').val());

                if($('#po_num').val() === "" &&  lcNum.length === 0){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input at least one data!',
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'Ok'
                    });
                }else{
                    $('#loader').show();
                    $.ajax({
                        type: 'post',
                        url: '{{url('import_management/retrieveAllInfo')}}',
                        data: {
                            po_num: $('#po_num').val(),
                            lc_num: $('#lcNumJson').val(),
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

                                    if(res[i]['po_num'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="t_po_num" ' +
                                            'name="t_po_num" ' +
                                            'value="'+res[i]['po_num']+'" style="width: 100px" disabled></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['lc_number'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="t_lc_num" name="t_lc_num" ' +
                                            'style="width: 130px" value="'+res[i]['lc_number']+'" disabled></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['pi_value'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" id="pi_value" name="pi_value" ' +
                                            'style="width: 150px" value="'+res[i]['pi_value']+'" disabled></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['mat_heading'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="mat_heading" name="mat_heading" ' +
                                            'style="width: 220px" value="'+res[i]['mat_heading']+'" disabled></td>';
                                    }else{
                                        tr += '<td></td>';
                                    }

                                    if(res[i]['duty_pay_mode'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="duty_pay_mode" name="duty_pay_mode" ' +
                                            'style="width:180px"><option value="">Select a payment mode</option>' +
                                            '<option value="RTGS" '+(res[i]['duty_pay_mode'] === "RTGS" ? 'selected="selected"' : '')+'>RTGS</option>' +
                                            '<option value="CASH" '+(res[i]['duty_pay_mode'] === "CASH" ? 'selected="selected"' : '')+'>CASH</option>' +
                                            '<option value="PAYORDER" '+(res[i]['duty_pay_mode'] === "PAYORDER" ? 'selected="selected"' : '')+'>PAYORDER</option>' +
                                            '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="duty_pay_mode" name="duty_pay_mode" ' +
                                            'style="width:180px"><option value="">Select a payment mode</option>' +
                                            '<option value="RTGS">RTGS</option>' +
                                            '<option value="CASH">CASH</option>' +
                                            '<option value="PAYORDER">PAYORDER</option>' +
                                            '</select></td>';
                                    }

                                    if(res[i]['customs_house'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="customs_house" name="customs_house" ' +
                                            'style="width:180px"><option value="">Select customs house</option>' +
                                            '<option value="DHAKA CUSTOMS HOUSE" '+(res[i]['customs_house'] === "DHAKA CUSTOMS HOUSE" ? 'selected="selected"' : '')+'>DHAKA CUSTOMS HOUSE</option>' +
                                            '<option value="CTG CUSTOMS HOUSE" '+(res[i]['customs_house'] === "CTG CUSTOMS HOUSE" ? 'selected="selected"' : '')+'>CTG CUSTOMS HOUSE</option>' +
                                            '<option value="BENAPOLE CUSTOMS HOUSE" '+(res[i]['customs_house'] === "BENAPOLE CUSTOMS HOUSE" ? 'selected="selected"' : '')+'>BENAPOLE CUSTOMS HOUSE</option>' +
                                            '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="customs_house" name="customs_house" ' +
                                            'style="width:180px"><option value="">Select customs house</option>' +
                                            '<option value="DHAKA CUSTOMS HOUSE">DHAKA CUSTOMS HOUSE</option>' +
                                            '<option value="CTG CUSTOMS HOUSE">CTG CUSTOMS HOUSE</option>' +
                                            '<option value="BENAPOLE CUSTOMS HOUSE">BENAPOLE CUSTOMS HOUSE</option>' +
                                            '</select></td>';
                                    }

                                    if(res[i]['b_e_no'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="b_e_no" ' +
                                            'name="b_e_no" value="'+res[i]['b_e_no']+'" style="width: 120px"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="b_e_no" ' +
                                            'name="b_e_no" value="" style="width: 120px"></td>';
                                    }

                                    if(res[i]['b_e_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="b_e_date" ' +
                                            'name="b_e_date" style="width: 120px" value="'+moment(res[i]['b_e_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="b_e_date" ' +
                                            'name="b_e_date" style="width: 120px"></td>';
                                    }

                                    if(res[i]['c_nd_f'] != null){
                                        tr += '<td><select type="text" class="form-control input-xs" id="c_and_f" ' +
                                            'name="c_and_f" ' +
                                            'style="width: 180px;">' +
                                            '<option value="">Select C&F</option>';
                                        for(var x = 0; x < response.c_nd_f.length > 0; x++){
                                            if(res[i]['c_nd_f'] == response.c_nd_f[x]['c_and_f']){
                                                tr += '<option value="'+response.c_nd_f[x]['c_and_f']+'" ' +
                                                    'selected>'+response.c_nd_f[x]['c_and_f']+'</option>';
                                            }else{
                                                tr += '<option value="'+response.c_nd_f[x]['c_and_f']+'">'+response.c_nd_f[x]['c_and_f']+'</option>';
                                            }
                                        }
                                        tr += '</select></td>';
                                    }else{
                                        tr += '<td><select type="text" class="form-control input-xs" id="c_and_f" name="c_and_f" ' +
                                            'style="width: 180px;"><option value="">Select C&F</option>';
                                        for(var x = 0; x < response.c_nd_f.length > 0; x++){
                                            tr += '<option value="'+response.c_nd_f[x]['c_and_f']+'">'+response.c_nd_f[x]['c_and_f']+'</option>';
                                        }
                                        tr += '</select></td>';
                                    }

                                    if(res[i]['declarant_no'] != null){
                                        tr += '<td><input type="text" class="form-control input-xs" id="declarant_no" ' +
                                            'name="declarant_no" style="width: 150px" ' +
                                            'value="'+res[i]['declarant_no']+'"></td>';
                                    }else{
                                        tr += '<td><input type="text" class="form-control input-xs" id="declarant_no" name="declarant_no" ' +
                                            'style="width: 150px"></td>';
                                    }

                                    if(res[i]['duty_amount'] != null){
                                        tr += '<td><input type="number" class="form-control input-xs" ' +
                                            'id="duty_amount" ' +
                                            'name="duty_amount" style="width: 150px" ' +
                                            'value="'+res[i]['duty_amount']+'" min="0"></td>';
                                    }else{
                                        tr += '<td><input type="number" class="form-control input-xs" id="duty_amount" name="duty_amount" ' +
                                            'style="width: 150px"></td>';
                                    }

                                    if(res[i]['duty_date'] != null){
                                        tr += '<td><input type="date" class="form-control input-xs" id="duty_date" name="duty_date" ' +
                                            'style="width: 120px" value="'+moment(res[i]['duty_date']).format('YYYY-MM-DD')+'"></td>';
                                    }else{
                                        tr += '<td><input type="date" class="form-control input-xs" id="duty_date" name="duty_date" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    if(res[i]['duty_time'] != null){
                                        tr += '<td><input type="time" class="form-control input-xs" id="duty_time" ' +
                                            'name="duty_time" ' +
                                            'style="width: 120px" value="'+res[i]['duty_time']+'"></td>';
                                    }else{
                                        tr += '<td><input type="time" class="form-control input-xs" id="duty_time" ' +
                                            'name="duty_time" ' +
                                            'style="width: 120px"></td>';
                                    }

                                    tr += '</tr>';
                                }

                                var finalRowIds = JSON.stringify(rowIds);
                                $('#updateMyTable #update_row_ids').val(finalRowIds);
                                $('#updateMyTable tbody').html(tr);
                                $('#updateTableDiv').show();
                                $('#update_btn').show();

                                $('#updateMyTable #c_and_f').select2();
                                $('#updateMyTable #duty_pay_mode').select2();
                                $('#updateMyTable #customs_house').select2();

                            }else{
                                var tr = '';
                                tr += '<tr style="text-align: center;color: red">';
                                tr += '<td colspan="14">There is no data available!</td>';
                                tr += '</tr>';
                                $('#updateMyTable tbody').html(tr);
                                $('#updateTableDiv').show();
                                $('#update_btn').hide();
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
                            $('#updateTableDiv').hide();
                        }
                    })
                }
            });
        });
        class AddLCnums {
            constructor() {
                this.emailInput = document.getElementById("lc_num");
                this.emailListContainer = document.querySelector("div#lc_numList ul");
            }

            getEmails() {
                var emails = [];
                document.querySelectorAll("div#lc_numList ul li").forEach((ele) => {
                    emails.push(ele.innerHTML.replace(/ /g, ""));
                });
                $('#lcNumJson').val(JSON.stringify(emails));
            }

            init() {
                this.emailInput.onkeyup = (e) => {
                    if (e.keyCode == 0 || e.keyCode == 32 || e.keyCode == 13 || e.keyCode == 188) {

                        let val = e.target.value.trim().replace(/ /g, "").replace(/,/g, "");

                        if(val != ''){

                            var dupemails = [];
                            document.querySelectorAll("div#lc_numList ul li").forEach((ele) => {
                                dupemails.push(ele.innerHTML.replace(/ /g, ""));
                            });

                            var dupExists = 0;
                            for (var z = 0; z < dupemails.length; z++){
                                if(val == dupemails[z]){
                                    dupExists = 1;
                                }
                            }

                            if(dupExists == 1){
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This LC number is already added.',
                                    icon: 'error',
                                    showConfirmButton: true,
                                    confirmButtonText: 'Ok'
                                });
                                $('#lc_num').val('');
                            }else{
                                let li = document.createElement('li');
                                li.innerHTML = val;
                                this.emailListContainer.appendChild(li);
                                this.emailInput.value = "";

                                // removing email from the list
                                li.addEventListener("click", function (e) {
                                    e.target.parentNode.removeChild(e.target);

                                    var liemails = [];
                                    document.querySelectorAll("div#lc_numList ul li").forEach((ele) => {
                                        liemails.push(ele.innerHTML.replace(/ /g, ""));
                                    });
                                    $('#lcNumJson').val(JSON.stringify(liemails));
                                });
                                this.getEmails();
                            }
                        }
                    }
                }
            }
        }
    </script>
@endsection
