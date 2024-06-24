<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 07/07/2020
 * Time: 11:34 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Export Product Status')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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
            padding: 2px;
            font-size: 10px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 10px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 10px;
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

        input {
            color: black;
            font-size: x-small;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .modal-dialog {
            width: 98%;
            height: 92%;
            padding: 0;
        }

        .modal-content {
            height: 99%;
        }

        .btn.disabled {
            pointer-events: none;
        }

        @media print {
            .header-print {
                display: table-header-group;
            }
        }

    </style>
@endsection
@section('right-content')


    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" >
                <header class="panel-heading">
                    <label class="text-default">
                        Export Product Status
                    </label>
                </header>

                <div class="panel-body">


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-sm-4 control-label input-sm">Year</label>
                                            <div class="col-md-6 col-sm-6">
                                                <select name="year" id="year"
                                                        class="form-control input-sm m-bot15 year">
                                                    <option value="" disabled>Select Year</option>
                                                    <option value="All">All</option>
                                                    @foreach($rs as $c)
                                                        <option value="{{$c->year}}">{{$c->year}}</option>
                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-sm-4 control-label input-sm">Export Country</label>
                                            <div class="col-md-6 col-sm-6">

                                                <select name="allCountry" id="allCountry" class="form-control input-sm allCountry" autocomplete="off">
                                                    <option value="" disabled>Select Status</option>
                                                    <option value="All">All</option>
                                                    @foreach($allCountry as $cn)
                                                        <option value="{{$cn->export_country}}">{{$cn->export_country}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-4 col-xs-4">

                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                                            </div>
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


    <div class="row cnt_status-1">

        <div class="col-md-4 col-md-offset-2">
            <div class="panel" style="background-color: #C39BD3">
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Export Country  </span>
                            <h4 style="color: whitesmoke">{{ $noOfCountry[0]->no_of_country }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel " style="background-color: #4F9FCF">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Number of Brand  </span>
                            <h4 style="color: whitesmoke">{{ $noOfBrand[0]->brand_name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row cnt_status-2" style="display: none;">

        <div class="col-md-4 col-md-offset-2" >
            <div class="panel" style="background-color: #C39BD3">
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Export Country  </span>
                            <h4 style="color: whitesmoke"><span id="noOfCountry"></span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel " style="background-color: #4F9FCF">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Number of Brand  </span>
                            <h4 style="color: whitesmoke"><span id="noOfBrand"></span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row states-info st-info-1">

        @foreach($cstatus as $st)

            <div @if($loop->index == 0) class="col-md-2" @else class="col-md-2" @endif >
                <div  @if($st->current_status == 'Registered') class="panel blue-bg"
                      @elseif($st->current_status == 'Permitted')  class="panel turquoise-bg"
                      @elseif($st->current_status == 'In-Process')  class="panel green-bg"
                      @elseif($st->current_status == 'Dropped')  class="panel yellow-bg"
                      @elseif($st->current_status == 'Rejected')  class="panel red-bg"
                      @elseif($st->current_status == 'Withdrawl')  class="panel turquoise-bg"
                        @endif>
                    <div class="panel-body">
                        <div class="row">
                            @if($st->current_status == 'Registered')
                                <div class="col-xs-4">
                                    <i class="fa fa-pencil"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Registered </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @elseif($st->current_status == 'Permitted')
                                <div class="col-xs-4">
                                    <i class="fa fa-check-circle"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Permitted </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>

                            @elseif($st->current_status == 'In-Process')
                                <div class="col-xs-4">
                                    <i class="fa fa-tag"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> In-Process </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>

                            @elseif($st->current_status == 'Dropped')
                                <div class="col-xs-4">
                                    <i class="fa fa-trash-o"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title">Dropped</span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>



                            @elseif($st->current_status == 'Rejected')
                                <div class="col-xs-4">
                                    <i class="fa fa-trello"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Rejected </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @elseif($st->current_status == 'Withdrawl')
                                <div class="col-xs-4">
                                    <i class="fa fa-external-link-square"></i>
                                </div>

                                <div class="col-xs-8">
                                    <span class="state-title"> Withdrawl </span>
                                    <h4><span> {{ $st->status }} </span></h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
    <div class="row states-info st-info-2" style="display: none;">

        <div class="col-md-12">
            <div class="row states-info">
                <div class="col-md-2">
                    <div class="panel blue-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Register </span>
                                    <h4><span id="reg"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Permitted  </span>
                                    <h4><span id="permitted"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel green-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  In-Process  </span>
                                    <h4><span id="inp"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel yellow-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-trash-o"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">Dropped</span>
                                    <h4><span id="drp"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel red-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-trello"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Rejected  </span>
                                    <h4><span id="rej"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-external-link-square"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Withdrawal </span>
                                    <h4> <span id="wid"> 0 </span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row" id="report-body-1" >
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>SL</th>
                                    <th>YEAR</th>
                                    <th>BULK_CODE</th>
                                    <th>EXPORT COUNTRY</th>
                                    <th>PRODUCT_NAME</th>
                                    <th>EXP_PRODUCT_NAME</th>
                                    <th>CURRENT_STATUS</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;">
                                @foreach ($result as  $da)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $da->year }}</td>
                                        <td>{{ $da->product_code }}</td>
                                        <td>{{ $da->export_country }}</td>
                                        <td>{{ $da->brand_name }}</td>
                                        <td>{{ $da->expo_product_name }}</td>
                                        <td>{{ $da->current_status }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="row" id="report-body-2" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>SL</th>
                                    <th>YEAR</th>
                                    <th>BULK_CODE</th>
                                    <th>EXPORT_COUNTRY</th>
                                    <th>PRODUCT_NAME</th>
                                    <th>EXP_PRODUCT_NAME</th>
                                    <th>CURRENT_STATUS</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}



    <script type="text/javascript">

        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                   'excel'
                ]
            });
        } );

        $(document).ready(function () {

            $('.year').select2();
            $('.allCountry').select2();


            $("#btn_display").click(function () {

                $("#loader").show();
                $("#report-body-1").hide();
                $(".st-info-1").hide();
                $(".st-info-2").show();

                $(".cnt_status-1").hide();
                $(".cnt_status-2").show();


                $('#noOfCountry').html(0);
                $('#noOfBrand').html(0);

                $('#reg').html(0);
                $('#inp').html(0);
                $('#permitted').html(0);
                $('#rej').html(0);
                $('#drp').html(0);
                $('#wid').html(0);

                var year = $('.year').val();
                var expo_country = $('#allCountry').val();

                var data = { year : year , expo_country:expo_country, "_token": "{{ csrf_token() }}"};

                var table;

                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: data,
                    url: "{{ url('expo/report/getQABulkProductStatus') }}",
                    success: function (resp) {
                        console.log("Success Data : ", resp);
                        $("#loader").hide();
                        $("#report-body-2").show();


                        $('#noOfCountry').html(resp['noOfCountry'][0]['no_of_country']);
                        $('#noOfBrand').html(resp['noOfBrand'][0]['brand_name']);

                        $.each(resp['ssStatus'], function (i,j) {
                            console.log(i,'=>',j);
                            if(j.current_status === 'Registered'){
                                $('#reg').html(j.status);
                            }else if(j.current_status === 'Permitted') {
                                $('#permitted').html(j.status);
                            }else if(j.current_status === 'In-Process'){
                                $('#inp').html(j.status);
                            }else if(j.current_status === 'Dropped'){
                                $('#drp').html(j.status);
                            }else if(j.current_status === 'Rejected'){
                                $('#rej').html(j.status);
                            }else if(j.current_status === 'Withdrawl'){
                                $('#wid').html(j.status);
                            }

                        });

                        $("#blk_list").DataTable().destroy();
                        $('#blk_list').DataTable({
                            data: resp['rs'],
                            dom: 'Bfrtip',
                            buttons: [
                                'excel'
                            ],
                            columns: [
                                {
                                    data: null,
                                    render: function (data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                    }
                                },
                                {data: "year"},
                                {data: "product_code"},
                                {data: "export_country"},
                                {data: "brand_name"},
                                {data: "expo_product_name"},
                                {data: "current_status"},
                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            info: true,
                            paging: true,
                            filter: true
                        });


                    },
                    error: function (err) {
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });

            });
        });
    </script>

@endsection