@extends('_layout_shared._master')
@section('title','Clearance Entry')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>



    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
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
            font-size: 11px;
        }

        body {
            color: black;
        }

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
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

        input{
            color: black;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Clearance Entry
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form">
                        <form class="form-horizontal" name="cl-form" method="post" action="{{url('scm_portal/ipl_cc_pdf')}}">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lc_no" class="col-md-6 col-sm-6 control-label"><b>LC
                                                Number: </b></label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="lc_no" name="lc_no" type="text"
                                                   required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="lc_dt" class="col-md-4 col-sm-4 control-label"><b>LC
                                                Date: </b></label>
                                        <div class="col-md-8">
                                            <div class='input-group date' id='datetimepicker1'>
                                                <input type='text' name="lc_dt" id="lc_dt" 
                                                       class="form-control"/>
                                                <span class="input-group-addon">
                                                   <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="crtf_dt" class="col-md-6 col-sm-6 control-label" style="color: darkred;"><b>Certificate Date: </b></label>
                                        <div class="col-md-6">
                                            <div class='input-group date' id='datetimepicker3'>
                                                {{--<input type='text' style="background-color: #9cf264; color: darkred;" name="crtf_dt" id="crtf_dt" required   class="form-control"/>--}}
                                                <input type='text' style="background-color: #fffa70; color: darkred;" name="crtf_dt" id="crtf_dt" required   class="form-control"/>
                                                <span class="input-group-addon">
                                                   <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inv_no" class="col-md-6 col-sm-6 control-label"><b>Invoice
                                                Number: </b></label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="inv_no" name="inv_no" type="text"
                                                   required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inv_dt" class="col-md-6 col-sm-6 control-label"><b>Invoice
                                                Date: </b></label>
                                        <div class="col-md-6">
                                            <div class='input-group date' id='datetimepicker2'>
                                                <input type='text' name="inv_dt" id="inv_dt" required
                                                       class="form-control"/>
                                                <span class="input-group-addon">
                                                   <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="blk_no" class="col-md-6 col-sm-6 control-label"><b>Block List
                                                Number: </b></label>
                                        <div class="col-md-6 col-sm-6">

                                            <select class="itemName form-control" name="itemName"
                                                    id="itemName"></select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="nof_mat" class="col-md-3 col-sm-3 control-label" style="text-align: center;"><b>Name Of
                                                Material: </b></label>
                                        <div class="col-md-9">

                                            <select class="matName form-control" name="matName" id="matName"></select>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    {{--<div class="col-md-6 col-sm-6">--}}
                                    <div class="form-group">
                                        <label for="qty"
                                               class="col-md-6 col-sm-6 control-label"><b>Quantity: </b></label>
                                        <div class="col-md-4 col-md-4">
                                            <input class="form-control" id="qty" name="qty" type="text" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="uom" class="col-md-3 col-sm-3 control-label" style="text-align: left"><b>UOM: </b></label>
                                        <div class="col-md-6">
                                            <select class="form-control m-bot15" name="uom" id="uom" required>
                                                <option value="">Select UOM ...</option>
                                                {{--<option value="A">Ampere (A)</option>--}}
                                                {{--<option value="CD">Candela (CD)</option>--}}
                                                <option value="KG">Kilogram (KG)</option>
                                                <option value="GM">Gram (GM)</option>
                                                <option value="MG">Milligram (MG)</option>
                                                <option value="MIU">Million IU (MIU)</option>
                                                <option value="ML">Mole (ML)</option>
                                                <option value="L">Litres (L)</option>
                                                <option value="ROLL">ROLL</option>
                                                <option value="BOTTLE">Bottle</option>
                                                <option value="MLf">MLf</option>
                                                <option value="DOSE">DOSE</option>
                                                <option value="MILLION DOSE">MILLION DOSE</option>
                                                <option value="MILLION LF ">MILLION LF</option>
                                                <option value="MT">Metric Ton (MT)</option>
                                                <option value="Per TH">Per Thousand (Per TH)</option>
                                                <option value="Per HUN">Per Hundred (Per HUN)</option>
                                                <option value="Per LAC">Per Lac (Per LAC)</option>
                                                <option value="MM">Millimetre (MM)</option>
                                                <option value="MIC">Micron (MIC)</option>
                                                <option value="M">Meter (M)</option>
                                                <option value="PCS">Piece (PCS)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-4 col-sm-4">

                                    <div class="form-group">
                                        <label for="avl_qty"
                                               class="col-md-5 col-sm-5 control-label" style="text-align: right;"><b>Available. Qty: </b></label>
                                        <div class="col-md-4 col-md-4">
                                            <input class="form-control" id="avl_qty" name="val_qty" type="text"
                                                   disabled>
                                            <input type="hidden" id="rate" name="rate">
                                            <input type="hidden" id="currency" name="currency">
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="mnf"
                                               class="col-md-2 col-sm-2 control-label"><b>Manufacturer: </b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select class="manufactName form-control" id="manufactName"
                                                    name="manufactName"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" id="sv" type="submit"><span
                                                class="glyphicon glyphicon-floppy-save"></span> Save
                                    </button>
                                    <button class="col-lg-offset-2 btn btn-danger" id="fn" type="submit"><span
                                                class="glyphicon glyphicon-saved"></span> Done
                                    </button>
                                    <button class="col-lg-offset-2 btn btn-info btn_submit_clr" id="btn_submit" type="submit"><span
                                                class="glyphicon glyphicon-print"></span> Print
                                    </button>
                                    <button class="col-lg-offset-2 btn btn-primary" id="reset" type="button"><span
                                                class="glyphicon glyphicon-refresh"></span> Refresh
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" id="lc_fnl_blk" style="display: none;">
            <section class="panel">
                <div class="panel-body">
                    <form id="frm-example" action="" method="POST">

                        <div class="table-responsive">
                            <table id="cl_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    {{--<th>SL</th>--}}
                                    <th>Block List Number</th>
                                    <th>Name Of Material</th>
                                    <th>Manufacturer</th>
                                    <th>Quantity</th>
                                    <th>UOM</th>
                                    <th>Rate</th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;" id="cl_fn_list"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{--validation--}}
    {{Html::script('public/site_resource/js/jquery.validate.min.js')}}
    {{Html::script('public/site_resource/js/validation-init.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script>

        $('#btn_submit').attr('formtarget', '_blank');
        $('.btn_submit_clr').on('click',function () {
            setTimeout(function () {// wait for 3 secs
                window.location.reload(); // then reload the page
            }, 2000);
        });


        $(function () {

            var qtystatus = true;
            var blkl = '';
            var mtnam = '';

            var msum_qty = 0;

            var dataArray = [];


            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#datetimepicker3').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });


            //refresh
            $("#reset").on('click', function () {
                $(this).closest('form').find("input[type=text], textarea").val("");
                $(".matName").select2('val', 'All');
                $(".itemName").select2('val', 'All');
                $(".manufactName").select2('val', 'All');
                $(".uom").val('');
                location.reload(true);
            });


            // $(".inputNum").keydown(function (e) {
            //     // Allow: backspace, delete, tab, escape, enter and .
            //     if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            //         // Allow: Ctrl+A, Command+A
            //         (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            //         // Allow: home, end, left, right, down, up
            //         (e.keyCode >= 35 && e.keyCode <= 40)) {
            //         // let it happen, don't do anything
            //         return;
            //     }
            //     // Ensure that it is a number and stop the keypress
            //     if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            //         e.preventDefault();
            //     }
            // });


            {{--$('.itemName').select2({--}}
            {{--placeholder: 'Select block List No',--}}
            {{--ajax: {--}}
            {{--url: '{{url('scm_portal/blk_list_no')}}',--}}
            {{--dataType: 'json',--}}
            {{--delay: 250,--}}
            {{--processResults: function (data) {--}}
            {{--return {--}}
            {{--results: $.map(data, function (item) {--}}
            {{--return {--}}
            {{--text: item.blocklist_no,--}}
            {{--id: item.blocklist_no--}}
            {{--}--}}
            {{--})--}}
            {{--};--}}
            {{--},--}}
            {{--cache: true--}}
            {{--}--}}
            {{--});--}}

            $.ajax({
                type: "get",
                url: '{{url('scm_portal/blk_list_no')}}',
                dataType: 'json',
                success: function (response) {
                    var sel ='';
                    sel += "<option value=''>Select Item</option>";
                    for (var l = 0; l< response.length; l++) {
                        var id = response[l]['blocklist_no'];
                        var val = response[l]['blocklist_no'];
                        sel += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.itemName').empty().append(sel);
                },
                error: function (response) {
                    console.log(response);
                }
            });

            $(".itemName").select2();





            $('#itemName').on('change', function () {
                $('#matName').val('');
                $('#avl_qty').val('');
                $('#manufactName').val('');

                blkl = $('#itemName').val();


                {{--$('.matName').select2({--}}
                {{--placeholder: 'Select Material',--}}
                {{--ajax: {--}}
                {{--url: '{{url('scm_portal/mat_name')}}',--}}
                {{--dataType: 'json',--}}
                {{--data: {blkl: blkl},--}}
                {{--delay: 250,--}}
                {{--processResults: function (data) {--}}
                {{--return {--}}
                {{--results: $.map(data, function (item) {--}}
                {{--return {--}}
                {{--text: item.material_name,--}}
                {{--id: item.material_name--}}
                {{--}--}}
                {{--})--}}
                {{--};--}}
                {{--},--}}
                {{--cache: true--}}
                {{--}--}}
                {{--});--}}


                $(".matName").val('');
                $(".matName").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/mat_name')}}',
                    dataType: 'json',
                    data: {blkl: blkl,"_token":"{{ csrf_token() }}"},
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Material</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['material_name'];
                            var val = response[l]['material_name'];
                            selItems += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('.matName').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".matName").select2();

            });



            $('.matName').on('change', function () {
                var smatname = $('.matName').val();
                var tbkln = $('#itemName').val();
                var mat_qty = '';
                $('#avl_qty').val('');
                $('#manufactName').val('');
                $.ajax({
                    type: "post",
                    url: "{{url('scm_portal/get_avl_qty')}}",
                    data: {_bkl_no: tbkln, _mName: smatname, '_token': '{{csrf_token()}}'},
                    success: function (data) {
                        mat_qty = data[0].qty;
                        $('#avl_qty').val(mat_qty);
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Please Contact Your Administrator. Method get avail quantity error !',
                        });
                    }
                });

                $.ajax({
                    type: "get",
                    url: "{{url('scm_portal/get_rate_cur')}}",
                    data: {_bkl_no: tbkln, _mName: smatname},
                    success: function (data) {
                        var rate = data[0].rate;
                        var currency = data[0].currency;
                        $('#rate').val(rate);
                        $('#currency').val(currency);
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Please Contact Your Administrator.!',
                        });

                    }
                });


                {{--$('.manufactName').select2({--}}

                {{--placeholder: 'Select Manufacturer Name',--}}
                {{--ajax: {--}}
                {{--url: '{{url('scm_portal/manu_fact_name')}}',--}}
                {{--dataType: 'json',--}}
                {{--data: {smatname: smatname, tbkln: tbkln},--}}
                {{--delay: 250,--}}
                {{--processResults: function (data) {--}}
                {{--console.log(data);--}}
                {{--return {--}}
                {{--results: $.map(data, function (item) {--}}
                {{--return {--}}
                {{--text: item.manufacturer_name,--}}
                {{--id: item.manufacturer_name--}}
                {{--}--}}
                {{--})--}}
                {{--};--}}
                {{--},--}}
                {{--cache: true--}}
                {{--}--}}
                {{--});--}}



                $(".manufactName").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "get",
                    url: '{{url('scm_portal/manu_fact_name')}}',
                    dataType: 'json',
                    data: {smatname: smatname, tbkln: tbkln},
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Manufacturer Name</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['manufacturer_name'];
                            var val = response[l]['manufacturer_name'];
                            selItems += '<option value="' + id + '">' + val + '</option>';
                        }
                        $('#manufactName').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".manufactName").select2();


            });


            $('#qty').on('change keyup', function () {

                var tqty = $('#qty').val();
                var tmn = $('#matName').val();
                var tbkln = $('#itemName').val();
                var left_qty = '';


                $.ajax({
                    type: "post",
                    url: "{{url('scm_portal/get_avl_qty')}}",
                    data: {_bkl_no: tbkln, _mName: tmn, '_token': '{{csrf_token()}}'},
                    success: function (data) {

                        console.log(data);

                        var xqty = data[0].qty;
                        $('#avl_qty').val(xqty);

                        left_qty = $('#avl_qty').val();

                        if (parseInt(tqty) > parseInt(left_qty)) {
                            qtystatus = false;
                            swal({
                                type: 'error',
                                text: 'Quantity not grater than block list no quantity.!',
                            })
                        } else {
                            qtystatus = true;
                        }
                    },
                    error: function () {
                        swal({
                            type: 'error',
                            text: 'Please Check Your Entry.!',
                        });

                    }
                });


            });


            $("#lc_fnl_blk").hide();

            var t = $('#cl_list').DataTable({
                "paging": false,
                "ordering": false,
                "info": false,
                "searching": false
            });

            $("#lc_fnl_blk").find('tbody').empty(); //add this line

            $('#sv').on('click', function (e) {
                e.preventDefault();
                console.log('save button clickde');
                var _itemName = $('#itemName').val();
                var _matName = $('#matName').val();
                var _qty = $('#qty').val();
                var _uom = $('#uom').val();
                var _mnf = $('#manufactName').val();

                if (_qty === '' || _uom === '' || _itemName === null || _matName === null || _mnf == null) {
                    swal({
                        type: 'error',
                        text: 'Block List,Material,Manufacturer, Quantity, Unit of Measure can\'t be null!',
                    })
                } else {

                    console.log('All passed');
                    $("#lc_fnl_blk").show();

                    var duplicateFound = false;
                    var dupData = '';
                    $("#cl_list > tbody > tr").each(function () {
                        var blkno = $(this).closest('tr').find('.b_name').val();
                        var matno = $(this).closest('tr').find('.m_name').val();

                        console.log('inside loop',blkno,matno);

                        if(_itemName === blkno && _matName === matno){
                            console.log('inside loop');
                            duplicateFound = true;
                            console.log(_itemName+"|"+_matName);
                            dupData = _itemName+' | '+_matName;
                        }
                    });

                    if(duplicateFound){
                        swal({
                            type: 'error',
                            text: 'Duplicate record found.Please check! \n'+dupData,
                        })
                    }else{
                        $("#cl_fn_list").append('<tr valign="top">' +
                            '<td><input type="text"  class="b_name" name="bkln_list" value="' + $('.itemName').val() + '" readonly/> </td>' +
                            '<td><input type="text"  class="m_name" name="nof_mat" value="' + $('.matName').val() + '" readonly/> </td>' +
                            '<td><input type="text"  name="manufact" value="' + $('.manufactName').val() + '" readonly/> </td>' +
                            '<td><input type="text"  class="mat_qty" name="mat_qty" value="' + $('#qty').val() + '" readonly/> </td>' +
                            '<td><input type="text"  name="mat_uom" value="' + $('#uom').val() + '" readonly/> </td>' +
                            '<td><input type="text"  name="rate" value="' + $('#rate').val() + '" readonly/> </td>' +
                            '<td><input type="text"  name="currency" value="' + $('#currency').val() + '" readonly/> </td>' +
                            '<td><a href="javascript:void(0);" class="remCF">Remove</a></td>' +
                            '</tr>');
                        duplicateFound = false;
                    }

                }


            });

            $("#cl_fn_list").on('click', '.remCF', function () {
                $(this).parent().parent().remove();
            });


            $('#fn').on('click', function (ef) {
                ef.preventDefault();
                var datastring = getFormData();

                var lc = $('#lc_no').val();
                var lcdt = $('#lc_dt').val();
                var invno = $('#inv_no').val();
                var invdt = $('#inv_dt').val();
                var crtf = $('#crtf_dt').val();

                if (lc === '' || invno === '' || invdt === '' || crtf ==='') {
                    swal({
                        type: 'error',
                        text: 'lc number,  invoice number, invoice date, certificate date can\'t be null!',
                    })
                }
                else {

                    $.ajax({
                        type: "POST",
                        url: "{{url('scm_portal/cr_fn_data')}}",
                        data: {
                            cr_data: datastring,
                            _token: '{{csrf_token()}}',
                            lc_no: $('#lc_no').val(),
                            lc_dt: $('#lc_dt').val(),
                            inv_no: $('#inv_no').val(),
                            inv_dt: $('#inv_dt').val(),
                            crtf_dt: $('#crtf_dt').val()
                        },
                        success: function (data) {
                            // var obj = jQuery.parseJSON(data); //if the dataType is not specified as json uncomment this
                            // do what ever you want with the server response
                            console.log(data,'Yes am i inside')

                            if (data.success) {
                                $("#frm-example tr").remove();
                                $("#lc_fnl_blk tr").remove();
                                $("#frm-example").hide();
                                $(this).closest('form').find("input[type=text], textarea").val("");
                                toastr.success(data.success, '', {timeOut: 2000});
                            } else {
                                toaster.error(data.error, '', {timeOut: 2000});
                            }

                            // setTimeout(function () {// wait for 3 secs
                            //     window.location.reload(); // then reload the page
                            // }, 2000);
                        },
                        error: function () {
                            swal({
                                type: 'error',
                                text: 'Please Check Your Entry.!',
                            });

                        }
                    });
                }
                //
                //     }
                //
            });
        });

        function getFormData() {
            var unindexed_array = $("#frm-example").serializeArray();
            var indexed_array = [];
            var j = 1;
            var str = '';
            $.map(unindexed_array, function (n, i) {
                str += '"' + n['name'] + '":"' + n['value'].toString().trim() + '",';
                if (j === 7) {   //column name must be count
                    var data = str.substr(0, str.length - 1);
                    // console.log(data);
                    indexed_array.push('{' + data + '}');
                    str = '';
                    j = 0;
                }
                j++;
            });
            return indexed_array;
        }


    </script>

@endsection
