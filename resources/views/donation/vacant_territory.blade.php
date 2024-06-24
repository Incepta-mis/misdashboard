@extends('_layout_shared._master')
@section('title','Vacant Territory')
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
        @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM'||Auth::user()->desig === 'HO')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Vacant Territory
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


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="emp_month"
                                                       class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                        Id</b></label>
                                                <div class="col-md-6">
                                                    <select name="am_terr" id="am_terr"
                                                            class="form-control input-sm"
                                                    >
                                                        <option value="">Select Territory</option>
{{--                                                        <option value='ALL'>ALL</option>--}}
                                                        @foreach($am_terr as $terr)
                                                            <option value="{{$terr->am_terr_id}}">
                                                                {{$terr->am_terr_id}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

{{--                                        <div class="col-md-4 bs-month">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <label for="emp_month"--}}
{{--                                                       class="col-md-6 col-sm-6 control-label"><b>MPO Terr--}}
{{--                                                        Id</b></label>--}}
{{--                                                <div class="col-md-6">--}}
{{--                                                    <select name="mpo_terr" id="mpo_terr"--}}
{{--                                                            class="form-control input-sm">--}}
{{--                                                        <option value="">Select Territory</option>--}}

{{--                                                    </select>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="col-md-3 col-sm-2 ">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
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

                                        <div class="col-md-2">
                                            {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                            <button type="button" id="re_verify" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Research Expense verify</b></button>
                                            {{--</div>--}}
                                        </div>

                                        <div class="col-md-1">
                                            {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                            <button type="button" id="medicine_verify" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Medicine verify</b></button>
                                            {{--</div>--}}
                                        </div>


                                    </div>





</form>
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

        verify_donation = "{{url('donation/verify_donation')}}";
        verify_medicine = "{{url('donation/verify_medicine')}}";

        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function () {


            $('#re_verify').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                let month = '';

                let am_terr = '';

                month = $('#bgt_month').val();

                am_terr = $('#am_terr').val();

                console.log(month);

                console.log(am_terr);

                if( $('#bgt_month').val() == ''){
                    alert('Month can not be empty !!! ');
                }

                else  if( $('#am_terr').val() == ''){
                    alert(' AM Territory can not be empty');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: verify_donation,
                        dataType: 'json',
                        data: {
                            month: month,
                            am_terr: am_terr,
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
                            toastr.error("Error updating ");
                        }
                    });

                }


            });

            $('#medicine_verify').click(function () {
                // e.preventDefault();
                // $( "#update").unbind( "click" );

                let month = '';

                let am_terr = '';

                month = $('#bgt_month').val();

                am_terr = $('#am_terr').val();

                console.log(month);

                console.log(am_terr);

                if( $('#bgt_month').val() == ''){
                    alert('Month can not be empty !!! ');
                }

                else  if( $('#am_terr').val() == ''){
                    alert(' AM Territory can not be empty');
                }

                else
                {
                    $.ajax({
                        type: "post",
                        url: verify_medicine,
                        dataType: 'json',
                        data: {
                            month: month,
                            am_terr: am_terr,
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
                            toastr.error("Error updating ");
                        }
                    });

                }


            });


        });



    </script>


@endsection