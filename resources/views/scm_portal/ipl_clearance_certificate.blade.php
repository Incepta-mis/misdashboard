@extends('_layout_shared._master')
@section('title','Clearance Entry')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

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

        .crazyFrog {
            background: url('http://e-cdn-images.deezer.com/images/artist/01eb92fc47bb8fb09adea9f763bb1c50/500x500.jpg');
            width: 500px;
            height: 500px;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Clearance Letter
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form">
                        <form class="form-horizontal" method="post" action="{{url('scm_portal/ipl_cc_pdf')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <!-- <div class="col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="lc_no" class="col-md-4 col-sm-4 control-label"><b>LC
                                                Number: </b></label>
                                        <div class="col-md-6 col-sm-6">
                                            {{--<input class="form-control lc_no" id="lc_no" name="lc_no" type="text" >--}}
                                            <select class="form-control lc_no" id="lc_no" name="lc_no"  ></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <div class="form-group">
                                        <label for="" class="control-label"><b>OR: </b></label>
                                    </div>
                                </div> -->
                                <div class="col-md-5 col-sm-5">
                                    <div class="form-group">
                                        <label for="inv_no" class="col-md-4 col-sm-4 control-label"><b>Invoice
                                                Number: </b></label>
                                        <div class="col-md-6 col-sm-6">                                            
                                            <select class="form-control inv_no " id="inv_no" name="inv_no"  ></select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="row">--}}

                                {{--<div class="col-md-12 col-sm-12">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="r" class="col-md-2 col-sm-2 control-label"><b>Reports: </b></label>--}}
                                        {{--<label class="radio-inline"><input type="radio" name="optradio" value="optradio1">IPL / IVL /ICL</label>--}}
                                        {{--<label class="radio-inline"><input type="radio" name="optradio" value="optradio2">IPL (DU) / IVL (AVD)</label>--}}
                                        {{--<label class="radio-inline"><input type="radio" name="optradio" value="optradio3">IHNL / IHHL</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="submit" id="btn_submit" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Display Report</b></button>
                                </div>
                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                    <div id="export_buttons">

                                    </div>
                                </div>
                            </div>

                        </form>
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{--{{Html::script('public/site_resource/js/jszip.min.js')}}--}}
    {{--{{Html::script('public/site_resource/js/pdfmake.min.js')}}--}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}



    <script type="text/javascript">

        $('#btn_submit').attr('formtarget', '_blank');


        $(function () {

            // $('.lc_no').select2({
            //     placeholder: 'Select LC No',
            //     ajax: {
            //         url: '{{url('scm_portal/lc_no')}}',
            //         dataType: 'json',
            //         delay: 250,
            //         processResults: function (data) {
            //             return {
            //                 results: $.map(data, function (item) {
            //                     return {
            //                         text: item.lc_no,
            //                         id: item.lc_no
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });


            // $('.inv_no').select2({
            //     placeholder: 'Select Invoice No',
            //     ajax: {
            //         url: '{{url('scm_portal/inv_no')}}',
            //         dataType: 'json',
            //         delay: 250,
            //         processResults: function (data) {
            //             return {
            //                 results: $.map(data, function (item) {
            //                     return {
            //                         text: item.inv_no,
            //                         id: item.inv_no
            //                     }
            //                 })
            //             };
            //         },
            //         cache: true
            //     }
            // });

             $(".inv_no").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{url('scm_portal/inv_no')}}',
                dataType: 'json',
                success: function (response) {
                    var selItems ='';
                    selItems += "<option value=''>Select Invoice Number</option>";
                    for (var l = 0; l< response.length; l++) {
                        var id = response[l]['inv_no'];
                        var val = response[l]['inv_no'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.inv_no').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });

            $(".inv_no").select2();


        });

    </script>


@endsection
