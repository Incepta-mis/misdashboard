@extends('_layout_shared._master')
@section('title','Finance Miscellaneous')
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
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                       Finance Miscellaneous
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form method="post" action="" class="form-horizontal" role="form">
                                    {{csrf_field()}}

                                    <div class="row">

                                        <div class="col-md-8">

                                            <div class="form-group">
                                                <label for="inf_of"
                                                       class="col-md-3 control-label"><b>Pending Data</b></label>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bgt_month"
                                                               class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                        <div class="col-md-8">
                                                            <select name="bgt_month" id="bgt_month"  class="form-control input-sm">
                                                                <option value="">Select</option>
                                                                {{--                                                        <option value="ALL">ALL</option>--}}
                                                                @foreach($month_name as $mn)
                                                                    <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


{{--                                                <div class="col-md-1">--}}
{{--                                               --}}
{{--                                                    <button type="button" id="pending_data" class="btn btn-default btn-sm" formaction="{{url('donation/pending_data')}}">--}}
{{--                                                        <i class="fa fa-check"></i> <b>Download</b></button>--}}
{{--                                             --}}
{{--                                                </div>--}}



                                                <div class="col-md-4" >

                                                    <a id="pending_data" href="#">Download here</a><span>&nbsp;&nbsp;</span>
                                                    <span class="loader" style="display: none"><i class="fa fa-spinner fa-spin"></i><span>&nbsp;&nbsp;</span>Generating file ...Please wait</span>

                                                </div>


                                            </div>

                                        </div>



                                    </div>

                                </form>

                                    <div class="row">

                                        <div class="col-md-8">

                                            <div class="form-group">
                                                <label for="inf_of"
                                                       class="col-md-3 control-label"><b>Processed Data</b></label>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="proc_month"
                                                               class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                        <div class="col-md-8">
                                                            <select name="proc_month" id="proc_month"  class="form-control input-sm">
                                                                <option value="">Select</option>
                                                                {{--                                                        <option value="ALL">ALL</option>--}}
                                                                @foreach($month_name as $mn)
                                                                    <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" >

                                                    <a id="processed_data" href="#">Download here</a><span>&nbsp;&nbsp;</span>
                                                    <span class="loader_proc" style="display: none"> <i class="fa fa-spinner fa-spin"></i><span>&nbsp;&nbsp;</span>Generating file ...Please wait</span>

                                                </div>

{{--                                                <div class="col-md-1">--}}
{{--                                             --}}
{{--                                                    <button type="button" id="processed_data" class="btn btn-default btn-sm">--}}
{{--                                                        <i class="fa fa-check"></i> <b>Display</b></button>--}}
{{--                                             --}}
{{--                                                </div>--}}


                                            </div>

                                        </div>


                                    </div>




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



    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

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

            var pending_data = "{{url('donation/pending_data')}}";
            var processed_data = "{{url('donation/processed_data')}}";

            _csrf_token = '{{csrf_token()}}';


            // $('#pending_data').attr('formtarget', '_blank');

            $('#pending_data').click(function () {

                var month = '';
                month = $('#bgt_month').val();
                console.log(month);

                if( $('#bgt_month').val() == ''){
                    alert('Month can not be empty !!! ');
                }

                else
                {
                    $('.loader').show();
                    $.ajax({
                        type: "post",
                        url: pending_data,
                        dataType: 'json',
                        data: {
                            month: month,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response.path);
                            let path = response.path;
                            // console.log(path);
                            location.href = path;
                            $('.loader').hide();

                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error("Error updating Infavor Of");
                        }
                    });

                }

            });

            $('#processed_data').click(function () {

                var month = '';
                month = $('#proc_month').val();
                console.log(month);

                if( $('#proc_month').val() == ''){
                    alert('Month can not be empty !!! ');
                }

                else
                {
                    $('.loader_proc').show();
                    $.ajax({
                        type: "post",
                        url: processed_data,
                        dataType: 'json',
                        data: {
                            month: month,
                            _token: _csrf_token
                        },
                        success: function (response) {
                            console.log(response);
                            let path = response.path;
                            // console.log(path);
                            location.href = path;

                            $('.loader_proc').hide();


                        },
                        error: function (data) {
                            console.log(data);
                            // toastr.error("Error updating Infavor Of");
                        }
                    });

                }

            });


            }
        );

    </script>

@endsection