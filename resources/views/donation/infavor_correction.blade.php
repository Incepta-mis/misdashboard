@extends('_layout_shared._master')
@section('title','Infavor Of Correction')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

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

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: #000;
        }
        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/

        }
        /*div.dt-buttons{*/
        /*position:relative;*/
        /*float:right;*/

        /*}*/
    </style>
@endsection

@section('right-content')
    @if(Auth::user()->desig === 'HO')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Infavor Of Correction
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    {{--@if(Auth::user()->desig === 'All'|| Auth::user()->desig === 'HO'|| Auth::user()->desig === 'GM')--}}

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dcid"
                                                           class="col-md-5 col-sm-6 control-label"><b>Req ID</b></label>
                                                    <div class="col-md-7">
                                                        <input name="dcid" id="dcid" class="form-control input-sm" autocomplete="off"  type="number">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-1">
                                                {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display</b></button>
                                                {{--</div>--}}
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                                                <div id="export_buttons">

                                                </div>
                                            </div>


                                        </div>

                                    {{--@endif--}}

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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
    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Req ID</th>
                                    <th>Doctor Id</th>
                                    <th>Infavor Of</th>
{{--                                    <th>Corrected Infavor Of</th>--}}
                                    <th>Doctor Name</th>
                                    <th>Payment Month</th>
                                    <th>Beneficiary Group</th>
{{--                                    <th>Amount</th>--}}
{{--                                    <th>Donation Type </th>--}}
{{--                                    <th>Brand/Region</th>--}}
                                    <th>Payment Mode</th>
{{--                                    <th>Terr Id</th>--}}
{{--                                    <th>Emp Id</th>--}}
{{--                                    <th>Emp Name</th>--}}
                                    <th>Sum id</th>
                                    <th>Ref No</th>
{{--                                    <th>AM Check</th>--}}
{{--                                    <th>RM Check</th>--}}
{{--                                    <th>BE Check</th>--}}
{{--                                    <th>DSM Check</th>--}}
{{--                                    <th>SM Check</th>--}}
                                    <th>SSD Check</th>
                                    <th>Head Check</th>
                                    <th>GM Sales Check</th>
                                    <th>GM MSD Check</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="inf_of"
                                   class="col-md-3 control-label"><b>Infavor of Correction</b></label>
                            <div class="col-md-9">
                                <input name="inf_of" id="inf_of" class="form-control input-sm" autocomplete="off" >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2" style="display: none;">
                        <div class="form-group">
                            <label for="req_id"
                                   class="col-md-5 col-sm-6 control-label"><b>req_id</b></label>
                            <div class="col-md-7">
                                <input name="req_id" id="req_id" class="form-control input-sm" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-1">
                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                        <button type="button" id="btn_update" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Save</b></button>
                        {{--</div>--}}
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                        <div id="export_buttons">

                        </div>
                    </div>


                </div>

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="doctor_name"
                                   class="col-md-3 control-label"><b>Doctor Name Correction</b></label>
                            <div class="col-md-9">
                                <input name="doctor_name" id="doctor_name" class="form-control input-sm" autocomplete="off" >
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2" style="display: none;">
                        <div class="form-group">
                            <label for="req_id"
                                   class="col-md-5 col-sm-6 control-label"><b>req_id</b></label>
                            <div class="col-md-7">
                                <input name="req_id" id="req_id" class="form-control input-sm" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-1">
                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                        <button type="button" id="btn_update_doc_name" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Save</b></button>
                        {{--</div>--}}
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                        <div id="export_buttons">

                        </div>
                    </div>


                </div>

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="doctor_name"
                                   class="col-md-3 control-label"><b>Payment Mode Correction</b></label>
                            <div class="col-md-9">
                                <select name="mop" id="mop"
                                        class="form-control input-sm filter-option pull-left tol">
                                    <option value="">Select</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="CASH">CASH</option>

                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2" style="display: none;">
                        <div class="form-group">
                            <label for="req_id"
                                   class="col-md-5 col-sm-6 control-label"><b>req_id</b></label>
                            <div class="col-md-7">
                                <input name="req_id" id="req_id" class="form-control input-sm" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-1">
                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                        <button type="button" id="btn_update_pom" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Save</b></button>
                        {{--</div>--}}
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                        <div id="export_buttons">

                        </div>
                    </div>


                </div>

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="doctor_name"
                                   class="col-md-3 control-label"><b>Payment Month Correction</b></label>
                            <div class="col-md-9">
                                <select name="bgt_month" id="bgt_month"
                                        class="form-control input-sm">
                                    <option value="">Select</option>
                                    @foreach($month_name as $mn)
                                        <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2" style="display: none;">
                        <div class="form-group">
                            <label for="req_id"
                                   class="col-md-5 col-sm-6 control-label"><b>req_id</b></label>
                            <div class="col-md-7">
                                <input name="req_id" id="req_id" class="form-control input-sm" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-1">
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                        <button type="button" id="btn_update_pay_month" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Save</b></button>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                        <div id="export_buttons">

                        </div>
                    </div>


                </div>

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="ben_group"
                                   class="col-md-3 control-label"><b>Beneficiary Correction</b></label>
                            <div class="col-md-9">
                                <select name="ben_group" id="ben_group"
                                        class="form-control input-sm">
                                    <option value="">Select Group</option>
                                    <option value="INSTITUTE SINGLE">INSTITUTE SINGLE</option>
                                    <option value="INSTITUTE COMBINED">INSTITUTE COMBINED</option>
                                    <option value="DOCTOR">DOCTOR</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-2" style="display: none;">
                        <div class="form-group">
                            <label for="req_id"
                                   class="col-md-5 col-sm-6 control-label"><b>req_id</b></label>
                            <div class="col-md-7">
                                <input name="req_id" id="req_id" class="form-control input-sm" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-1">
                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                        <button type="button" id="btn_update_bengroup" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Save</b></button>
                        {{--</div>--}}
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                        <div id="export_buttons">

                        </div>
                    </div>


                </div>

                <div class="row">
                    &nbsp;
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="doctor_name"
                                   class="col-md-4 control-label"><b>SSD Check date removal</b></label>

                        </div>
                    </div>


                    <div class="col-md-1">
                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                        <button type="button" id="btn_remove_ssd_check_date" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Apply</b></button>
                        {{--</div>--}}
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-2 col-xs-6" style="float: right">
                        <div id="export_buttons">

                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

@endif
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

    {{----}}
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

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}



    <script type="text/javascript">

        servloc = "{{url('donation/infavor_correction')}}";
        update_row = "{{url('donation/infavor_update')}}";
        update_row_name = "{{url('donation/doctor_name_update')}}";
        update_pom = "{{url('donation/update_pom')}}";
        update_pay_month = "{{url('donation/update_pay_month')}}";
        update_bengroup = "{{url('donation/update_bengroup')}}";
        ssd_check_date_remove = "{{url('donation/ssd_check_date_remove')}}";
        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function () {

$('#btn_display').click(function () {


        if ($("#dcid").val() === "") {
        toastr.info("Please input Doctor ID");
    }
    else {
        var mont = $("#bgt_month").val();
        var doctor = $("#dcid").val();
            var selMop = "";

        $("#loader").show();

        console.log(mont);
        console.log(doctor);

        $("#inf_of").val('');
        $("#req_id").val('');

        $.ajax({
            method:'post',
            url:servloc,
            data: {
                mont: mont,
                doctor:doctor,
                _token: _csrf_token
            },
            success: function (resp) {

                console.log(resp);

                console.log($('#fix').height());
                $("#loader").hide();
                $("#report-body").show();


                $("#req_ccwise").DataTable().destroy();
                var table = $("#req_ccwise").DataTable({
                    data: resp.resp_data,
                    columns: [
                        {data: "req_id"},
                        {data: "doctor_id"},
                        {data: "in_favour_of"},
                        // {data: "in_favour_of"},
                        {data: "doctor_name"},
                        {data: "payment_month"},
                        {data: "beneficiary_group"},
                        // {data: "approved_amount"},
                        // {data: "donation_type"},
                        // {data: "group_brand_region_name"},
                        {data: "payment_mode"},
                        //
                        // {data: "terr_id"},
                        // {data: "emp_id"},
                        // {data: "emp_name"},
                        {data: "summ_id"},
                        {data: "ref_no"},

                        //
                        // {data: "am_checked_date"},
                        // {data: "rm_checked_date"},
                        // {data: "be_checked_date"},
                        // {data: "dsm_checked_date"},
                        // {data: "sm_checked_date"},
                        {data: "ssd_checked_date"},
                        {data: "group_head_checked_date"},
                        {data: "gm_sales_checked_date"},
                        {data: "gm_msd_checked_date"}
                    ],


                    language: {
                        "emptyTable": "No Matching Records Found."
                    },

                    info: false,
                    paging: false,
                    filter: false,



                });

                $("#inf_of").val(resp.resp_data[0]['in_favour_of']);
                $("#doctor_name").val(resp.resp_data[0]['doctor_name']);
                $("#req_id").val(resp.resp_data[0]['req_id']);

                if(resp.exists){
                    selMop += "<option value=''>Select</option>";
                    selMop += "<option value='BEFTN'>BEFTN</option>";
                    selMop += "<option value='CASH'>CASH</option>";
                    selMop += "<option value='CHEQUE'>CHEQUE</option>";

                    $("#mop").empty().append(selMop);
                }
                else{
                    selMop += "<option value=''>Select</option>";
                    selMop += "<option value='CASH'>CASH</option>";
                    selMop += "<option value='CHEQUE'>CHEQUE</option>";
                    $("#mop").empty().append(selMop);
                }
            },
            error: function (err) {
                // console.log(err);
                $("#loader").hide();
                $("#report-body").show();
            }

        });


    }



});

            $('#btn_update').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                var req_no = '';

                var inf_of = '';

                req_no = $('#req_id').val();

                inf_of = $('#inf_of').val();

                console.log(req_no);

                console.log(inf_of);

             if( $('#inf_of').val() == ''){
                    alert('Infavor of can not be empty !!! ');
                }

               else  if( $('#req_id').val() == ''){
                    alert(' empty !!! ');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: update_row,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            inf_of: inf_of,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            // location.reload();
                            // updateTable();
                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            //Code for closing modal on click of update button of modal ends here

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating Infavor Of");
                        }
                    });

                }


            });

            $('#btn_update_doc_name').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                var req_no = '';

                var doc_name = '';

                req_no = $('#req_id').val();

                doc_name = $('#doctor_name').val();

                console.log(req_no);

                console.log(doc_name);

                if( $('#doctor_name').val() == ''){
                    alert('Doctor name can not be empty !!! ');
                }

                else  if( $('#req_id').val() == ''){
                    alert(' empty !!! ');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: update_row_name,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            doctor_name: doc_name,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            // location.reload();
                            // updateTable();
                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            //Code for closing modal on click of update button of modal ends here

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating Doctor name");
                        }
                    });

                }


            });

            $('#btn_update_pom').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                var req_no = '';

                var pom = '';

                req_no = $('#req_id').val();

                pom = $('#mop').val();

                console.log(req_no);

                console.log(pom);

                if( $('#mop').val() == ''){
                    alert('Payment mode can not be empty !!! ');
                }

                else  if( $('#req_id').val() == ''){
                    alert(' empty !!! ');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: update_pom,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            pay_mode: pom,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            // location.reload();
                            // updateTable();
                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            //Code for closing modal on click of update button of modal ends here

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating Pay mode");
                        }
                    });

                }


            });

            $('#btn_update_pay_month').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                var req_no = '';

                var pay_month = '';

                req_no = $('#req_id').val();

                pay_month = $('#bgt_month').val();

                console.log(req_no);

                console.log(pay_month);

                if( $('#bgt_month').val() == ''){
                    alert('Payment month can not be empty !!! ');
                }

                else  if( $('#req_id').val() == ''){
                    alert(' empty !!! ');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: update_pay_month,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            pay_month: pay_month,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            // location.reload();
                            // updateTable();
                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            //Code for closing modal on click of update button of modal ends here

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating Pay month");
                        }
                    });

                }


            });

            $('#btn_update_bengroup').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                var req_no = '';

                var pay_month = '';

                req_no = $('#req_id').val();

                let bengroup = $("#ben_group").val();

                console.log(req_no);

                console.log(pay_month);

                if( $('#ben_group').val() == ''){
                    alert('Please select beneficiary !!! ');
                }

                else  if( $('#req_id').val() == ''){
                    alert(' empty !!! ');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: update_bengroup,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            bengroup: bengroup,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            // location.reload();
                            // updateTable();
                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            //Code for closing modal on click of update button of modal ends here

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating Beneficiary");
                        }
                    });

                }


            });

            $('#btn_remove_ssd_check_date').click(function () {

                var req_no = '';
                req_no = $('#req_id').val();
                console.log(req_no);

              if( $('#req_id').val() == ''){
                    alert('Reqest Id  empty !!! ');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: ssd_check_date_remove,
                        dataType: 'json',
                        data: {
                            req_no: req_no,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            // location.reload();
                            // updateTable();
                            toastr.success("updated successfully");
                            //Code for closing modal on click of update button of modal
                            //Code for closing modal on click of update button of modal ends here

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error removing check date");
                        }
                    });

                }


            });


        });



    </script>


@endsection