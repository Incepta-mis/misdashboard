@extends('_layout_shared._master')
@section('title','Newborn Baby Diaper Sample Information')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

        #dre tbody tr td:nth-child(2):before {
            counter-increment: Serial;
            content: "" counter(Serial);
        }

        /* Display the counter */


    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Newborn Baby Diaper Sample Information Entry
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
                                                                class="form-control input-sm" >
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
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
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
                                                                class="form-control input-sm"
                                                        >
                                                            <option value="">Select Territory</option>
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
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
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
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>
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
                                                           class="col-md-4 col-sm-6 control-label"><b>MPO
                                                            Terr</b></label>
                                                    <div class="col-md-8">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            @foreach($mpo_terr as $terr)
                                                                <option data-mpo_emp_id ="{{Auth::user()->user_id}}" value="{{$terr->mpo_terr_id}}">
                                                                    {{$terr->mpo_terr_id}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                    @endif

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="market"
                                                       class="col-md-4 col-sm-6 control-label"><b>Market</b></label>
                                                <div class="col-md-8">
                                                    <select name="market" id="market"
                                                            class="form-control input-sm" >
                                                        <option value="">Select Market</option>
                                                        @if(Auth::user()->desig === 'TSO'||Auth::user()->desig === 'MPO'||Auth::user()->desig === 'Sr. MPO')
                                                            @foreach($market as $mr)
                                                                <option value="{{$mr->market_name}}">
                                                                    {{$mr->market_name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hospital"
                                                       class="col-md-4 col-sm-6 control-label"><b>Hospital</b></label>
                                                <div class="col-md-8">
                                                    <select name="hospital" id="hospital"
                                                            class="form-control input-sm">
                                                        <option value="">Select Hospital</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


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

                                        <div class="col-md-2 " style="padding: 0px;">
                                            <div class="button-group">

{{--                                                <button id="add-row" value="Add Row"><i--}}
{{--                                                            class="fa fa-plus"></i></button>--}}
                                                <span>&nbsp;&nbsp;</span>

                                                <button type="button" id="add-multiple-row" ><i
                                                            class="fa fa-plus"></i></button>
                                                <span>&nbsp;&nbsp;</span>

                                                <button id="remove_row" class="button danger"><i
                                                            class="fa fa-minus"></i>
                                                </button>

                                            </div>
                                        </div>


{{--                                        <div class="col-md-2 " style="padding: 0px;">--}}
{{--                                            <div class="button-group">--}}
{{--                                                <button id="display_button" type="button" ><i--}}
{{--                                                            class="fa fa-check"></i>Display</button>--}}

{{--                                            </div>--}}
{{--                                        </div>--}}


                                    </div>

                                    <div class="row">


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date"
                                                       class="col-md-4 col-sm-6 control-label"><b>Date</b></label>
                                                <div class="col-md-8">
                                               <input class="form-control input-sm" type="date"  id="datePicker"  readonly/>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="day"
                                                       class="col-md-4 col-sm-6 control-label"><b>Day</b></label>
                                                <div class="col-md-8">
                                                    @foreach($day as $day)
                                                        <input id="input_day" class="form-control input-sm" type="text"  value=" {{$day->dd}}" readonly/>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-2 " style="padding: 0px;">
                                            <div class="button-group">
                                                <button id="display_button" type="button" ><i
                                                            class="fa fa-check"></i>Display</button>
                                                <span>&nbsp;&nbsp;</span>

                                                <button id="insert_button" type="button"  style="display: none;"><i
                                                            class="fa fa-check"></i>Save
                                                </button>

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


                <table class="table table-res table-condensed table-bordered" id="dre" style="display: none">
                    <thead>
                    <tr>
                        <th></th>
                        <th>SL No.</th>
                        <th> Customer Name </th>
                        <th>   CONTACT   NUMBER  </th>
                        <th>Hospital</th>
                        <th style='display: none'>Chemist Name</th>
                        <th>Sample</th>
                        <th style="display: none">TERR ID</th>
                        <th style="display: none">MPO EMP ID</th>
                        <th style="display: none">CHEMIST CODE</th>
                        <th style="display: none">MARKET NAME</th>
                        <th style="display: none">DAY</th>
                        <th style="display: none">PRESENT SALES</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>


                </table>

                <div class="col-md-11 " style="padding: 0px;" >
                    <div class="button-group">

                        <button id="update_button" type="button" class="pull-right" style="display: none;">Update
                        </button>

{{--                        <button id="insert_button" type="button" class="pull-right" style="display: none;">Save--}}
{{--                        </button>--}}

                    </div>
                </div>

                <div class="col-md-11 " style="padding: 0px;" >
                    <span>&nbsp;&nbsp;</span>
                    <span>&nbsp;&nbsp;</span>
                </div>


                <table class="table table-condensed table-bordered" id="display_table" style="display: none">
                    <thead>
                    <tr>
                        <th></th>
                        <th >TERR ID</th>
                        <th >MPO EMP ID</th>
                        <th >MARKET NAME</th>
                        <th>Hospital</th>
                        <th style="display: none">CHEMIST CODE</th>
                        <th style="display: none">Chemist Name</th>
                        <th >DAY</th>
                        <th>Sample</th>
                        <th>Customer Nmae</th>
                        <th>Contact</th>
                        <th style="display: none" >PRESENT SALES</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="col-md-11 " style="padding: 0px;" >
                    <div class="button-group">

                        <button id="delete_button" type="button" class="pull-right" style="display: none;">Delete
                        </button>

                    </div>
                </div>


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


    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}



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

            let insert_row = "{{url('nc/insert_row_sample')}}";

            let delete_row = "{{url('nc/delete_row_sample_info')}}";

            let multiple_row_retrieve = "{{url('nc/multiple_row_retrieve')}}";

            let market_retrieve = "{{url('nc/market_name')}} ";

            let hospital_retrieve= "{{url('nc/hospital_name')}} ";

            let chemist_retrieve= "{{url('nc/chemist_name')}} ";

            let display_query= "{{url('nc/display_query_sample')}} ";

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
                            console.log(response);

                            var selOptsAM = "";
                            selOptsAM += "<option value=''>Select Territory</option>";
                            // selOptsAM += "<option value='ALL'>ALL</option>";
                            for (var i = 0; i < response.length; i++) {
                                var id = response[i]['am_terr_id'];
                                var val = response[i]['am_terr_id'];

                                selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#am_terr').html(selOptsAM);
                            $('#mpo_terr').empty().append("<option value=''>Select Territory</option>");

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

            // $("#add-row").click(function () {
            //     console.log('add button clicked');
            //     event.preventDefault();
            //     let hospital = $("#hospital").val();
            //     let chemist = $("#chemist").val();
            //
            //     if ($("#hospital").val() == '' ) {
            //         toastr.info('Please select a Hospital');
            //     }
            //     else if ($("#chemist").val() == '' ) {
            //         toastr.info('Please select a Chemist');
            //     }
            //     else {
            //             let markup = "<tr>" +
            //                 "<td><input type='checkbox' name='record'></td>" +
            //                 "<td >" + hospital + "</td>" +
            //                 "<td>" + chemist + "</td>" +
            //                 "<td>1</td>" +
            //                 "<td><input type='text' name='customer_name' onkeyup='this.value = this.value.toUpperCase();' class=' form-control' autocomplete='off' ></td>" +
            //                 "<td><input type='text' name='contact' onkeyup='this.value = this.value.toUpperCase();' class=' form-control' autocomplete='off' ></td>" +
            //                 "</tr>";
            //
            //         // $("table tbody tr").remove();
            //
            //             $("#dre tbody").prepend(markup);
            //
            //         $("#insert_button").show();
            //
            //     }
            //
            // });

            $("#add-multiple-row").click(function () {

                let mpo_terr = $("#mpo_terr").val();
                let day = $("#input_day").val();
                let mpo_emp_id =$("#mpo_terr option:selected").data('mpo_emp_id');

                if ($("#mpo_terr").val() == '' ) {
                    toastr.info('Please select a territory');
                }
                else if ($("#input_day").val() == '') {
                    toastr.info('Please select day');
                }
                else{

                    $("#insert_button").show();

                    // $("#display_table ").hide();

                    // $("#display_table tbody tr").remove();

                    console.log(mpo_emp_id);

                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: _csrf_token,
                            mpo_terr:mpo_terr,
                            day:day
                        },
                        url: multiple_row_retrieve,
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
                            let markup = '';
                            for (let i=0; i<data.length; i++){

                                markup += "<tr>" +
                                    "<td><input type='checkbox' name='record'></td>" +
                                    "<td style='white-space: nowrap;'> </td>" +
                                    "<td><input  type='text' name='customer_name' onkeyup='this.value = this.value.toUpperCase();' class=' form-control' autocomplete='off' ></td>" +
                                    "<td><input   placeholder='e.g: 017XXXXXXXX' type='text' name='contact' onkeyup='this.value = this.value.toUpperCase();' class=' form-control' autocomplete='off' ></td>" +
                                    "<td>" + data[i].hospital_name + "</td>" +
                                    "<td style='display: none'>" + data[i].chemist_name + "</td>" +
                                    "<td>1</td>" +
                                    "<td style='display: none'>" + data[i].terr_id + "</td>" +
                                    "<td style='display: none'>" + mpo_emp_id + "</td>" +
                                    "<td style='display: none'>" + data[i].chemist_code + "</td>" +
                                    "<td style='display: none'>" + data[i].market_name + "</td>" +
                                    "<td style='display: none'>" + data[i].day + "</td>" +
                                    "<td style='display: none'>" + data[i].present_sales + "</td>" +
                                    "</tr>";

                            }

                            $("#dre tbody ").prepend(markup);
                            $("#dre").show();

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

            // Find and remove selected table rows
            $("#remove_row").click(function () {
                console.log('remove button clicked');
                event.preventDefault();
                $("table tbody").find('input[name="record"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });

            });

            $("#display_button").click(function () {

                let mpo_terr = $("#mpo_terr").val();
                let market = $("#market").val();
                let hospital = $("#hospital").val();
                // let chemist_code = $("#chemist").val();

                if ($("#mpo_terr").val() == '' ) {
                    toastr.info('Please select a territory');
                }
                else if ($("#market").val() == '') {
                    toastr.info('Please select market');
                }
                else if ($("#hospital").val() == '') {
                    toastr.info('Please select hospital');
                }
                // else if ($("#chemist").val() == '') {
                //     toastr.info('Please select chemist');
                // }
                else{
                    // $("#insert_button").hide();

                    $("#display_table tbody tr").remove();

                    // $("#dre ").hide();

                    // $("#dre tbody tr").remove();

                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: _csrf_token,
                            mpo_terr:mpo_terr,
                            market:market,
                            hospital:hospital
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
                            let markup = '';
                            for (let i=0;i<data.length;i++){

                                markup += "<tr>" +
                                    "<td><input type='checkbox' name='record'></td>" +
                                "<td >" + data[i].terr_id + "</td>" +
                                "<td>" + data[i].mpo_emp_id + "</td>" +
                                "<td>" + data[i].market_name + "</td>" +
                                "<td>" + data[i].hospital_name + "</td>" +
                                "<td style='display: none'>" + data[i].chemist_code + "</td>" +
                                "<td style='display: none'>" + data[i].chemist_name + "</td>" +
                                "<td >" + data[i].day + "</td>" +
                                "<td >1</td>" +
                                "<td >" + data[i].customer_name + "</td>" +
                                "<td>" + data[i].contact_no + "</td>" +
                                "<td style='display: none'>" + data[i].present_sales + "</td>" +
                                "</tr>";

                            }

                            $("#display_table tbody").prepend(markup);
                            $("#display_table").show();
                            $("#delete_button").show();

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

            $("#delete_button").click(function () {

                var myTab = document.getElementById('display_table');

                console.log('insert button clicked');
                var tblData = myTab.rows;
                console.log(tblData);
                let insertdata = [];

                function getAllValues() {

                    $("#display_table tbody tr").each(function() {

                        if ($(this).find('input[name="record"]').is(":checked")){

                            // $(this).parents("tr").remove();

                            $(this).remove();

                            console.log('looks  checked');


                            let customerId = $(this).find("td").eq(1).html();
                            let mark = $(this).find("td").eq(3).html();
                            let dy = $(this).find("td").eq(7).html();
                            let hopital = $(this).find("td").eq(4).html();
                            let chcode = $(this).find("td").eq(5).html();
                            let chn = $(this).find("td").eq(6).html();
                            let prs = $(this).find("td").eq(11).html();
                            let csn = $(this).find("td").eq(9).html();
                            let contact = $(this).find("td").eq(10).html();

                            let allValues = {};

                            allValues['terr'] = customerId;
                            allValues['market'] = mark;
                            allValues['day'] = dy;
                            allValues['hospital'] = hopital;
                            allValues['chemist'] = chcode;
                            allValues['chname'] = chn;
                            allValues['psale'] = prs;
                            allValues['csn'] = csn;
                            allValues['contact'] = contact;

                            insertdata.push(allValues);
                        }

                    })

                    console.log(insertdata);

                }

                getAllValues();

                if (insertdata.length !== 0) {

                    console.log('write ajax code here');
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        data: {
                            insertdata: JSON.stringify(insertdata),
                            _token: _csrf_token
                        },
                        url: delete_row,
                        beforeSend: function () {
                            $("#loader").show();
                        },
                        success: function (data) {

                            // $("table tbody tr").remove();
                            console.log("data " + data);
                            if (data.error) {
                                toastr.error(data.error, '', {timeOut: 5000});
                            } else if (data.success) {
                                toastr.success(data.success, '', {timeOut: 5000});
                            }
                            $("#loader").hide();
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

            $("#insert_button").click(function () {

                  var myTab = document.getElementById('dre');
                  // var myTab = $("document #myTable");
                  console.log('insert button clicked');
                  var tblData = myTab.rows;
                  console.log(tblData);
                  let insertdata = [];
                  var tmpData = new Array();
                  // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.

                function getAllValues() {


                    $("#dre tbody tr").each(function() {

                        let hospital_name = $(this).find("td").eq(4).html();
                        let chemist_name = $(this).find("td").eq(5).html();
                        let trerId = $(this).find("td").eq(7).html();

                        let mpo_id = $(this).find("td").eq(8).html();
                        let chemist_code = $(this).find("td").eq(9).html();
                        let market = $(this).find("td").eq(10).html();
                        let day = $(this).find("td").eq(11).html();
                        let pr_sales = $(this).find("td").eq(12).html();

                        console.log(chemist_code);

                        // let customerId = $(this).find(".pr_code").html();
                        console.log(trerId);
                        var allValues = {};
                        let input_flag = true;

                        $(this).find("input").each(function( index ) {

                            const fieldName = $(this).attr("name");
                            if($(this).val() == ''){
                                input_flag =false;
                            }
                            allValues[fieldName] = $(this).val().trim();
                        });

                        allValues['terr'] = trerId;
                        allValues['hospital_name'] = hospital_name;
                        allValues['chemist_name'] = chemist_name;
                        allValues['mpo_id'] = mpo_id;
                        allValues['chemist_code'] = chemist_code;
                        allValues['market'] = market;
                        allValues['day'] = day;
                        allValues['pr_sales'] = pr_sales;

                        if(input_flag){
                            insertdata.push(allValues);
                        }
                    })
                    console.log(insertdata);

                }

                getAllValues();

                  if (insertdata.length !== 0) {
                      console.log('write ajax code here');
                      $.ajax({
                          type: "POST",
                          dataType: 'json',
                          data: {
                              insertdata: JSON.stringify(insertdata),
                              _token: _csrf_token
                          },
                          url: insert_row,
                          beforeSend: function () {
                              $("#loader").show();
                          },
                          success: function (data) {

                              $("#dre tbody tr").remove();

                              console.log("data " + data);
                              if (data.error) {
                                  toastr.error(data.error, '', {timeOut: 5000});
                              } else if (data.success) {
                                  toastr.success(data.success, '', {timeOut: 5000});
                              }

                              $("#loader").hide();

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
                        selOptsMPO += "<option value=''>Select Territory</option>";
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