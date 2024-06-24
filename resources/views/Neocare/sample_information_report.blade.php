@extends('_layout_shared._master')
@section('title','Newborn Baby Diaper Sample Information Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

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

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

        body {
            counter-reset: Serial; /* Set the Serial counter to 0 */
        }

        table {
            border-collapse: separate;
        }

        /*table tbody tr td:nth-child(2):before {*/
        /*    counter-increment: Serial; */
        /*    content: "" counter(Serial);*/
        /*}*/

        /* Display the counter */


    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Newborn Baby Diaper Sample Information Report
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                                    @if(Auth::user()->desig === 'HO' )

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
                                                            @foreach($rm_terr as $rt)
                                                                <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm"
                                                        >
                                                            <option value="">Select Territory</option>
{{--                                                            @foreach($am_terr as $terr)--}}
{{--                                                                <option value="{{$terr->am_terr_id}}">--}}
{{--                                                                    {{$terr->am_terr_id}}</option>--}}
{{--                                                            @endforeach--}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>TSO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option data-mpo_emp_id ="" value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

{{--                                            <div class="col-md-2 " style="padding: 0px;">--}}
{{--                                                <div class="button-group">--}}
{{--                                                    <button id="add-row" value="Add Row"><i--}}
{{--                                                                class="fa fa-plus"></i></button>--}}
{{--                                                    <span>&nbsp;&nbsp;</span>--}}
{{--                                                    <button id="remove_row" class="button danger"><i--}}
{{--                                                                class="fa fa-minus"></i>--}}
{{--                                                    </button>--}}

{{--                                                </div>--}}
{{--                                            </div>--}}


                                        </div>


                                    @endif

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" readonly="">
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($am_terr as $terr)
                                                                <option value="{{$terr->am_terr_id}}">
                                                                    {{$terr->am_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>TSO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    @endif

                                    @if(Auth::user()->desig === 'AM')

                                        <div class="row">

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" disabled>
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm" disabled>
                                                            @foreach($am_terr as $terr)
                                                                <option value="{{$terr->am_terr_id}}">
                                                                    {{$terr->am_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>TSO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($mpo_terr as $terr)
                                                                <option value="{{$terr->mpo_terr_id}}">
                                                                    {{$terr->mpo_terr_id}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>



                                    @endif

                                    @if(Auth::user()->desig === 'TSO'||Auth::user()->desig === 'Sr. TSO'||Auth::user()->desig === 'MPO'||Auth::user()->desig === 'Sr. MPO')

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>RM
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" disabled>
                                                                @foreach($rm_terr as $rt)
                                                                    <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="emp_month"
                                                           class="col-md-4 col-sm-6 control-label"><b>Am
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm" disabled>
                                                            @foreach($am_terr as $terr)
                                                                <option value="{{$terr->am_terr_id}}">
                                                                    {{$terr->am_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 bs-month">
                                                <div class="form-group">
                                                    <label for="mpo_terr"
                                                           class="col-md-4 col-sm-6 control-label"><b>TSO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            @foreach($mpo_terr as $terr)
                                                                <option value="{{$terr->mpo_terr_id}}">
                                                                    {{$terr->mpo_terr_id}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    @endif

{{--                                    <div class="row">--}}

{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="market"--}}
{{--                                                       class="col-md-4 col-sm-6 control-label"><b>Market</b></label>--}}
{{--                                                <div class="col-md-8">--}}
{{--                                                    <select name="market" id="market"--}}
{{--                                                            class="form-control input-sm" >--}}
{{--                                                        <option value="">Select Hospital</option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}


{{--                                        <div class="col-md-3">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="hospital"--}}
{{--                                                       class="col-md-4 col-sm-6 control-label"><b>Hospital</b></label>--}}
{{--                                                <div class="col-md-8">--}}
{{--                                                    <select name="hospital" id="hospital"--}}
{{--                                                            class="form-control input-sm">--}}
{{--                                                        <option value="">Select Hospital</option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}


{{--                                        <div class="col-md-4">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="chemist"--}}
{{--                                                       class="col-md-4 col-sm-6 control-label"><b>Chemist</b></label>--}}
{{--                                                <div class="col-md-8">--}}
{{--                                                    <select name="chemist" id="chemist"--}}
{{--                                                            class="form-control input-sm">--}}
{{--                                                        <option value="">Select Chemist</option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-2 " style="padding: 0px;">--}}
{{--                                            <div class="button-group">--}}

{{--                                                <button id="add-row" value="Add Row"><i--}}
{{--                                                            class="fa fa-plus"></i></button>--}}
{{--                                                <span>&nbsp;&nbsp;</span>--}}

{{--                                                <button type="button" id="add-multiple-row" ><i--}}
{{--                                                            class="fa fa-plus"></i></button>--}}
{{--                                                <span>&nbsp;&nbsp;</span>--}}

{{--                                                <button id="remove_row" class="button danger"><i--}}
{{--                                                            class="fa fa-minus"></i>--}}
{{--                                                </button>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        --}}


{{--                                    </div>--}}

                                    <div class="row">


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date"
                                                       class="col-md-4 col-sm-6 control-label"><b>Date From</b></label>
                                                <div class="col-md-8">
                                               <input class="form-control input-sm" type="date"  id="input_day_from"  />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="day"
                                                       class="col-md-4 col-sm-6 control-label"><b>Date To</b></label>
                                                <div class="col-md-8">
                                                        <input id="input_day_to" class="form-control input-sm" type="date"  />

                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-2 " style="padding: 0px;">
                                            <div class="button-group">
                                                <button id="display_button" type="button" ><i
                                                            class="fa fa-check"></i>Display</button>
                                                <span>&nbsp;&nbsp;</span>

                                                {{--                                                <button id="remove_row" class="button danger"><i--}}
                                                {{--                                                            class="fa fa-minus"></i>--}}
                                                {{--                                                </button>--}}

                                            </div>
                                        </div>


                                    </div>


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

    <section class="panel">
        <div class="panel-body">
            <div class="col-md-12 table-responsive" style="padding-left: 5px;padding-right: 5px;">


                <table class="table table-condensed table-striped table-bordered"
                       width="100%" id="display_table" style="display: none">
                    <thead>
                    <tr>
                        <th >TERR ID</th>
                        <th >MPO EMP ID</th>
                        <th >SAMPLE DATE</th>
                        <th >MARKET NAME</th>
                        <th>Hospital</th>
{{--                        <th >CHEMIST CODE</th>--}}
{{--                        <th>Chemist Name</th>--}}
                        <th >DAY</th>
{{--                        <th>Sample</th>--}}
                        <th>Customer Nmae</th>
                        <th>Contact</th>
{{--                        <th >PRESENT SALES</th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>


                </table>


            </div>


        </div>

    </section>


    {{--This code area is for showing loader image--}}
    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>
    {{--This code area is for showing loader image ends here--}}

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

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}



    <script type="text/javascript">
        $(document).ready(function () {

            Date.prototype.toDateInputValue = (function() {
                var local = new Date(this);
                local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
                return local.toJSON().slice(0,10);
            })
            $('#datePicker').val(new Date().toDateInputValue());


            servloc_tid = "{{url('dmr/getMpoTerr_DMR')}}";

            servloc_rm = "{{url('donation/regWTerrAmList')}}";

            servloc_am = "{{url('dmr/regWTerrAmList')}}";


            let display_query= "{{url('nc/display_query_sample_report')}} ";

            _csrf_token = '{{csrf_token()}}';

            $("#rm_terr").on('change', function () {
                //$("#rm_terr").live("change", function() {
                var rm_terr = $("#rm_terr").val();
                $("#mpo_terr").html('');

                console.log(rm_terr);

                if (rm_terr == 'ALL') {
                    console.log('In Loop');

                    $('#smrm_name').empty().append("<option value='ALL'>ALL</option>");
                    $('#am_terr').empty().append("<option value='ALL'>ALL</option>");
                    $('#mpo_terr').empty().append("<option value='ALL'>ALL</option>");
                }

                else {
                    $.ajax({
                        type: "GET",
                        // url: '{{url('rm_portal/regwTerrListSmRmNameId')}}',
                        url: servloc_rm,
                        dataType: 'json',
                        data: {rmTerr: rm_terr},
                        success: function (response) {
                            console.log("response in rm")
                            console.log(response);

                            var selOptsAM = "";
                            // selOptsAM += "<option value=''>Select Territory</option>";
                            selOptsAM += "<option value='ALL'>ALL</option>";
                            for (var i = 0; i < response.length; i++) {
                                var id = response[i]['am_terr_id'];
                                var val = response[i]['am_terr_id'];

                                selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#am_terr').html(selOptsAM);
                            $('#mpo_terr').empty().append("<option value='ALL'>ALL</option>");

                            var selOptsRM = "";
                            for (var d = 0; d < 1; d++) {
                                var idj = response[d]['rmsm_name'];
                                var valj = response[d]['rmsm_name'];

                                selOptsRM += "<option value='" + idj + "'>" + valj + "</option>";
                            }

                            $('#smrm_name').html(selOptsRM);


                            var selOptsRMid = "";
                            for (var l = 0; l < response.length; l++) {
                                var idl = response[l]['rmsm_id'];
                                var vall = response[l]['rmsm_id'];

                                selOptsRMid += "<option value='" + idl + "'>" + vall + "</option>";
                            }
                            $('#smrm_id').html(selOptsRMid);

                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }


            });



            $("#display_button").click(function () {

                if ($("#mpo_terr").val() == '' ) {
                    toastr.info('Please select a territory');
                }
                else if ($("#am_terr").val() == '' ) {
                    toastr.info('Please select AM territory');
                }
                else if ($("#rm_terr").val() == '' ) {
                    toastr.info('Please select RM territory');
                }
                else if ($("#input_day_from").val() == '') {
                    toastr.info('Please eneter date range');
                }
                else if ($("#input_day_to").val() == '') {
                    toastr.info('Please enter date range');
                }
                else{

                    let mpo_terr = $("#mpo_terr").val();
                    let am_terr = $("#am_terr").val();
                    let rm_terr = $("#rm_terr").val();
                    let input_day_from = $("#input_day_from").val();
                    let input_day_to = $("#input_day_to").val();

                    console.log(input_day_from);
                    console.log(input_day_to);


                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: _csrf_token,
                            mpo_terr:mpo_terr,
                            am_terr:am_terr,
                            rm_terr:rm_terr,
                            input_day_from:input_day_from,
                            input_day_to:input_day_to
                        },
                        url: display_query,
                        beforeSend: function () {
                            $("#loader").show();
                        },
                        success: function (data) {

                            console.log(data);
                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }

                            $("#loader").hide();

                            $('#display_table').DataTable().destroy();
                            let table = $('#display_table').DataTable({
                                data: data,
                                dom: 'Bfrtip',

                                buttons: [

                                    {
                                        extend: 'excelHtml5', className: "btn-warning",
                                        exportOptions: {
                                            columns: [0, 1, 2, 3, 4, 5,6,7]
                                        }
                                    }

                                ],



                                columns: [
                                    {data: "terr_id"},
                                    {data: "mpo_emp_id"},
                                    {data: "sample_date"},
                                    {data: "market_name"},
                                    {data: "hospital_name"},
                                    {data: "day"},
                                    // {data: "1"},
                                    {data: "customer_name"},
                                    {data: "contact_no"}

                                ],
                                // ordering:false,
                                // paging:false,
                                // filtering:false,
                                // info:false,
                                // searching:false,
                                // fixedHeader: true,
                                // "scrollY": "450px",
                                // "scrollX": true,
                                // "scrollCollapse": true
                            });


                            $("#display_table").show();

                        },
                        complete: function (data) {
                            $("#loader_submit").hide();
                            $("#loader").hide();
                        },
                        error: function (err) {
                            console.log(err);
                            $("#loader").hide();
                        }
                    });
                }
            });


            $("#am_terr").on('change', function () {
                $('#depo').empty();
                $('#docid').empty();
                var am_terr = $("#am_terr").val();
                var smrm_id = $("#rm_terr").val();
                console.log(am_terr);
                console.log(smrm_id);
                $("#mpo_terr").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "GET",
                    url: servloc_tid,
                    dataType: 'json',
                    data: {amTerr: am_terr, rmTerrId: smrm_id},
                    success: function (response) {
                        console.log(response);

                        var selOptsMPO = "";
                        selOptsMPO += "<option value='ALL'>ALL</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['mpo_terr_id'];
                            var val = response[j]['mpo_emp_id'];
                            selOptsMPO += "<option data-mpo_emp_id ='" + val + "'  value='" + id + "'>" + id + "</option>";
                        }
                        // $('#mpo_terr').html(selOptsMPO);
                        $('#mpo_terr').empty().append(selOptsMPO);


                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#mpo_terr").on('change', function () {

                var mpo_terr = $("#mpo_terr").val();

                console.log(mpo_terr);

                $("#market").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: market_retrieve,
                    dataType: 'json',
                    data: {
                        mpo_terr: mpo_terr,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);

                        var selOptsDOC = "";
                        selOptsDOC += "<option value='' >Select Market</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['market_name'];
                            var val = response[j]['market_name'] ;
                            selOptsDOC += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#market').empty().append(selOptsDOC);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#market").on('change', function () {

                let market = $("#market").val();
                console.log(market);

                $("#hospital").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: hospital_retrieve,
                    dataType: 'json',
                    data: {
                        market: market,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);

                        var selOptsDOC = "";
                        selOptsDOC += "<option value='' >Select Hospital</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['hospital_name'];
                            var val = response[j]['hospital_name'] ;
                            selOptsDOC += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#hospital').empty().append(selOptsDOC);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#hospital").on('change', function () {

                let hospital = $("#hospital").val();

                console.log(hospital);

                $("#chemist").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: chemist_retrieve,
                    dataType: 'json',
                    data: {
                        hospital: hospital,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        console.log(response);

                        var selOptsDOC = "";
                        selOptsDOC += "<option value='' >Select Chemist</option>";
                        for (var j = 0; j < response.length; j++) {
                            var id = response[j]['chemist_code'];
                            var val = response[j]['chemist_name'] ;
                            selOptsDOC += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('#chemist').empty().append(selOptsDOC);

                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

        });


    </script>



@endsection