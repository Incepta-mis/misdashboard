@extends('_layout_shared._master')
@section('title','NeoCare')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12">
            <section class="panel">
                <header class="panel-heading" style="text-transform: none;">
                    NeoCare Customer Information
                </header>
                <div class="panel-body">
                    {{-- <div class="col-lg-4 col-lg-offset-4"> --}}
                        <form role="form" id="neocare">
                            <div class="form-group">
                                <label for="name">Parent's Name</label>
                                <input type="text" class="form-control input-sm" id="name" name="name"
                                       placeholder="Enter name">
                            </div>

                            <div class="form-group">
                                <label for="babyname">Baby's Name</label>
                                <input type="text" class="form-control input-sm" id="babyname" name="baby_name"
                                       placeholder="Enter name">
                            </div>


                            <div class="form-group">
                                <label for="babyage">Baby's Age</label>

                                <div class="input-group date emplo_from_datebir_id">
                                    <input type="text" class="form-control input-sm" id="babyage" name="age"
                                           placeholder="Enter age" maxlength="2">
                                    <span class="input-group-addon">
                                        months
                                                                    </span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="samplesize">Sample Size</label>
                                <select name="sample_size" id="samplesize"
                                        class="form-control input-sm">

                                    {{--                                    <option value="" selected readonly="">Select Size</option>--}}

                                    @foreach($s_size as $ss)
                                        <option value="{{$ss->sample_size}}">
                                            {{$ss->sample_size}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phonenumber">Contact No:</label>
                                <input type="text" class="form-control input-sm" id="phonenumber" name="contact_no"
                                       placeholder="Enter phone number" maxlength="11">
                            </div>
                            <div class="form-group">
                                <label for="babyage">Email</label>
                            <div class="input-group" style="display: inline-block;width: 100%;">
                                <input type="text" name="emailpart1" id="emailpart1" style="width: 50%;"
                                      placeholder="username"
                                       class="form-control">
                                <Select class="form-control input-group-addon" name = "emailpart2" id="emailpart2" style="width: 50%;">

                                    <option value="@gmail.com" selected>@gmail.com &nbsp;&nbsp;&nbsp;</option>
                                    <option value="@yahoo.com">@yahoo.com</option>
                                </Select>

                            </div>
                            </div>


                            <button type="button" id="save" class="btn btn-block btn-sm btn-primary">
                                <i class="fa fa-save"></i> Save
                            </button>

                        </form>
                    {{-- </div> --}}
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
    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    <script>
        var url_report_output = '{{url('nc/save')}}';


        $("#save").click(function (e) {
            
            if ($('#name').val().length > 0 && $('#babyname').val().length > 0
                && $('#babyage').val().length > 0 && $('#samplesize').val().length > 0
                && $('#phonenumber').val().length > 0) {

                if (isNaN($('#babyage').val()) || isNaN($('#phonenumber').val())) {
                    toastr.info('age and phone-number must be number');
                    return;
                }
                if ($('#phonenumber').val().length < 11) {
                    toastr.info('please check your phone number');
                    return;
                }
                console.log($('#neocare').serialize());
                $.ajax({
                    method: "POST",
                    url: url_report_output,
                    data: {
                        _token: '{{csrf_token()}}',
                        param: $('#neocare').serialize()
                    },
                    // beforeSend: function () {
                    //     $("#loader").show();
                    // },
                    success: function (data) {
                        if (data.status) {
                            console.log(data);
                            toastr.info('record saved');
                            $('#neocare').find("input[type=text]").val("");
                        } else {
                            toastr.info('unable to save record');
                        }

                    },
                    error: function () {

                    },
                    // complete: function () {
                    //     $("#loader").hide();
                    // }
                })
            } else {
                toastr.info('please enter required fields');
            }


        })


    </script>


@endsection
