@extends('_layout_shared._master')
@section('title','Travel Advice Details')
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Travel Advice Details
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form">
                        <form class="form-horizontal" method="post" action="{{ route('local.companyWiseAdvice') }}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-5 col-sm-5">
                                    <div class="form-group">
                                        <label for="advice_no" class="col-md-4 col-sm-4 control-label"><b>Advice No: </b></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control advice_no " id="advice_no" name="advice_no"  ></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5 col-sm-5">
                                    <div class="form-group">
                                        <label for="company_id" class="col-md-4 col-sm-4 control-label"><b>Company: </b></label>
                                        <div class="col-md-6 col-sm-6">
                                            <select class="form-control company_id " id="company_id" name="company_id">
                                                <option value="">Select Company</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="submit" id="btn_submit" class="btn btn-warning btn-sm">
                                        <i class="fa fa-check"></i> <b>Display Aadvice Detials</b></button>
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

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Travel Advice Letter
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form">
                        <form class="form-horizontal" method="post" action="{{ route('local.comAdviceLetter') }}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="advice_no" class="col-md-4 col-sm-4 control-label"><b>Advice No: </b></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select class="form-control advice_no_letter " id="advice_no_letter" name="advice_no_letter"  ></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="company_id" class="col-md-3 col-sm-3 control-label"><b>Company: </b></label>
                                        <div class="col-md-9 col-sm-9">
                                            <select class="form-control company_name" id="company_name" name="company_name">
                                                <option value="">Select Company</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="company_id" class="col-md-2 col-sm-2 control-label"><b>Bank: </b></label>
                                        <div class="col-md-10 col-sm-10">
                                            <select class="form-control bank_name" id="bank_name" name="bank_name">
                                                <option value="">Select Company</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label for="advice_no" class="col-md-4 col-sm-4 control-label"><b>Branch: </b></label>
                                        <div class="col-md-8 col-sm-8">
                                            <select class="form-control branch " id="branch" name="branch">
                                                <option value="">Select Branch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="company_id" class="col-md-2 col-sm-2 control-label"><b>Account: </b></label>
                                        <div class="col-md-10 col-sm-10">
                                            <select class="form-control acc_no" id="acc_no" name="acc_no">
                                                <option value="">Select Account</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                        <button type="submit" id="btn_bank_advice" class="btn btn-info btn-sm">
                                            <i class="fa fa-check"></i> <b>Display Bank Letter</b></button>
                                    </div>
                                    <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                        <div id="export_buttons">

                                        </div>
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
        $('#btn_bank_advice').attr('formtarget', '_blank');

        $(function () {
            $(".advice_no").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{route('local.getDocumentNo')}}',
                dataType: 'json',
                success: function (response) {
                    var selItems ='';
                    selItems += "<option value=''>Select Advice Number</option>";
                    for (var l = 0; l< response.length; l++) {
                        var id = response[l]['advice_no'];
                        var val = response[l]['advice_no'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.advice_no').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".advice_no").select2();

            $(".advice_no").on('change',function () {
                var advice_no = $('.advice_no').val();
                $(".company_id").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "get",
                    url: '{{route('local.getDocumentCmpId')}}',
                    data: { 'advice_no': advice_no},
                    dataType: 'json',
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Company</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['company_id'];
                            var val = response[l]['company_name'];
                            selItems += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('.company_id').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            });

            $(".company").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{route('local.getAdviceCompany')}}',
                dataType: 'json',
                success: function (response) {
                    var selItems ='';
                    selItems += "<option value=''>Select Company</option>";
                    for (var l = 0; l< response.length; l++) {
                        var id = response[l]['company_id'];
                        var val = response[l]['company_name'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.company').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".company").select2();
        });

        $(function () {
            $(".advice_no_letter").empty().append("<option value='loader'>Loading...</option>");
            var advice_no = $('.advice_no_letter').val();
            $.ajax({
                type: "get",
                url: '{{route('local.getDocumentNo')}}',
                dataType: 'json',
                success: function (response) {
                    var selItems ='';
                    selItems += "<option value=''>Select Advice Number</option>";
                    for (var l = 0; l< response.length; l++) {
                        var id = response[l]['advice_no'];
                        var val = response[l]['advice_no'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.advice_no_letter').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".advice_no_letter").select2();

            $('#advice_no_letter').on('change',function () {

                $(".company_name").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "get",
                    url: '{{route('local.getAdviceCompany')}}',
                    dataType: 'json',
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Company</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['company_id'];
                            var val = response[l]['company_name'];
                            selItems += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('.company_name').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
                $(".company_name").select2();

            });


            $(".company_name").on('change',function () {
                $(".bank_name").empty().append("<option value='loader'>Loading...</option>");
                var company_id = $('.company_name').val();
                $.ajax({
                    type: "get",
                    url: '{{route('local.getAdviceBankName')}}',
                    data: { 'company_id':company_id },
                    dataType: 'json',
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Bank</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['bank_name'];
                            var val = response[l]['bank_name'];
                            selItems += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('.bank_name').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".bank_name").select2();
            });

            $(".bank_name").on('change',function () {
                $(".branch").empty().append("<option value='loader'>Loading...</option>");
                var bank_name = $('.bank_name').val();
                var company_id = $('.company_name').val();
                $.ajax({
                    type: "get",
                    url: '{{route('local.getAdviceBranch')}}',
                    data: { 'bank_name':bank_name , 'company_id':company_id},
                    dataType: 'json',
                    success: function (response) {
                        var selItems ='';
                        selItems += "<option value=''>Select Branch</option>";
                        for (var l = 0; l< response.length; l++) {
                            var id = response[l]['branch'];
                            var val = response[l]['branch'];
                            selItems += "<option value='" + id + "'>" + val + "</option>";
                        }
                        $('.branch').empty().append(selItems);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });

                $(".branch").select2();


                $(".branch").on('change',function () {
                    $(".acc_no").empty().append("<option value='loader'>Loading...</option>");
                    var branch = $('.branch').val();
                    var company_id = $('.company_name').val();
                    var acc = '';

                    // console.log('yes company ',company_id);

                    $.ajax({
                        type: "get",
                        url: '{{route('local.getAdviceAccNo')}}',
                        data: { 'branch':branch,'company_id':company_id },
                        dataType: 'json',
                        success: function (response) {
                            var acc = '';
                            acc += "<option value=''>Select Account</option>";
                            for (var x = 0; x< response.length; x++) {
                                var idx = response[x]['acc_no'];
                                var valx = response[x]['acc_no'];
                                acc += "<option value='" + idx + "'>" + valx + "</option>";
                            }
                            $('.acc_no').empty().append(acc);
                        },
                        error: function (response) {
                            console.log(response);
                        }
                    });

                    $(".acc_no").select2();
                });


            });

        });






    </script>


@endsection
