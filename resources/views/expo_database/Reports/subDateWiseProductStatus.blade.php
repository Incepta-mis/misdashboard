<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 17/01/2021
 * Time: 11:36 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Submission Date Wise Product Status')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

        .form-group.required .control-label:after {
            content: "*";
            color: red;
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

        .table > thead > tr > th {
            padding: 2px;
            font-size: 9px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 9px;
        }


    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Submission Date Wise Product Status
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="get" action="">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">

                                                <label class="col-sm-4 col-sm-4 control-label input-sm">Export Country</label>
                                                <div class="col-md-8 col-sm-8">
                                                    <select name="expo_country" id="expo_country"
                                                            class="form-control input-sm m-bot15 expo_country">
                                                        <option value="" disabled>Select Country</option>
                                                        <option value="All">All</option>
                                                        @foreach ($country as  $cn)
                                                            <option value="{{ $cn->export_country }}">{{ $cn->export_country }}</option>
                                                        @endforeach

                                                    </select>

                                                </div>

                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">

                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Product Name</label>
                                        <div class="col-md-8 col-sm-8">
                                            <select name="expo_country" id="expo_product_name"
                                                    class="form-control input-sm m-bot15 expo_product_name">
                                                <option value="" disabled>Select Product</option>
                                                <option value="All">All</option>
                                                @foreach ($products as  $p)
                                                    <option value="{{ $p->expo_product_name }}">{{ $p->expo_product_name }}</option>
                                                @endforeach

                                            </select>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label for="curr_status"
                                               class="col-lg-6 col-sm-6 col-md-6 control-label control-label">Current Status</label>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <select class="form-control input-sm m-bot15 curr_status" autocomplete="off" name="curr_status" id="curr_status">
                                                <option value="" >Select Status</option>
                                                <option value="All" selected>All</option>
                                                <option value="Registered">Registered</option>
                                                <option value="Permitted">Permitted</option>
                                                <option value="In-Process">In-Process</option>
                                                <option value="Dropped">Dropped by Agent/MAH</option>
                                                <option value="Withdrawl">Withdrawal From RA Date</option>
                                                <option value="Rejected">Rejected</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4 pull-right">

                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </form>
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
                                    <span class="state-title"> Permitted </span>
                                    <h4><span id="per"> 0 </span></h4>
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
                                    <th>EXPORT_COUNTRY</th>
                                    <th>PRODUCT_NAME</th>
                                    <th>PACK_SIZE</th>
                                    <th>SUBMISSION_DATE</th>
                                    <th>CURRENT_STATUS</th>
                                    <th>REGISTRATION_DATE</th>
                                    <th>EXPIRY_RENEWAL_DATE</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;">
                                @foreach ($rs as  $result)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $result->export_country }}</td>
                                        <td>{{ $result->expo_product_name }}</td>
                                        <td>{{ $result->pack_size }}</td>
                                        <td>{{ $result->submission_date     }}</td>
                                        <td>{{ $result->current_status     }}</td>
                                        <td>{{ $result->registration_date     }}</td>
                                        <td>{{ $result->expiry_renewal_date     }}</td>
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

    <div class="row" id="report-body-2" style="display: none" >
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="blk_list" class="table table-striped table-bordered" style="width:100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>SL</th>
                                    <th>EXPORT_COUNTRY</th>
                                    <th>PRODUCT_NAME</th>
                                    <th>PACK_SIZE</th>
                                    <th>SUBMISSION_DATE</th>
                                    <th>CURRENT_STATUS</th>
                                    <th>REGISTRATION_DATE</th>
                                    <th>EXPIRY_RENEWAL_DATE</th>
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

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}


    <script type="text/javascript">

        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ],
            });
        } );

        $('.expo_country').select2();
        $('.expo_product_name').select2();

        $("#btn_display").click(function () {

            $("#loader").show();

            let expo_country = $('.expo_country').val();
            let expo_product_name = $('.expo_product_name').val();
            let current_status = $('.curr_status').val();

            console.log(expo_country);
            console.log(expo_product_name);

            $('#reg').html(0);
            $('#per').html(0);
            $('#inp').html(0);
            $('#rej').html(0);
            $('#drp').html(0);
            $('#wid').html(0);


            let data = { expo_country: expo_country, expo_product_name:expo_product_name, current_status: current_status, "_token": "{{ csrf_token() }}"};
            let table;
            $.ajax({
                type: "post",
                dataType: 'json',
                data: data,
                url: "{{ url('expo/report/getSubDateWPStatus') }}",
                success: function (resp) {
                     // console.log("Success Data : ", resp['result']);
                     console.log("Success Data : ", resp['ssStatus']);

                    $("#loader").hide();
                    $("#report-body").show();

                    $("#report-body-1").hide();
                    $(".st-info-1").hide();

                    $("#report-body-2").show();
                    $(".st-info-2").show();




                   $.each(resp['ssStatus'], function (i,j) {
                        console.log(i,'=>',j);
                       if(j.current_status === 'Registered'){
                           $('#reg').html(j.status);
                       }else if(j.current_status === 'Permitted'){
                           $('#per').html(j.status);
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



                    // console.log(resp['ssStatus']);



                    // if(resp['ssStatus'][0]['current_status'][''] === 'Dropped By Agent')  $('#drp').html(resp['ssStatus'][0]['status']); else  $('#drp').html('');
                    // if(resp['ssStatus'][3]['status']['current_status'] === 'Registered')  $('#reg').html(resp['ssStatus'][3]['status']); else  $('#reg').html('');


                    // $('#drp').html(resp['ssStatus'][0]['status']);
                    // $('#reg').html(resp['ssStatus'][3]['status']);
                    // $('#inp').html(resp['ssStatus'][1]['status']);
                    // $('#no_of_brand').html(resp['noOfBrand'][0]['no_of_brand']);

                    $("#blk_list").DataTable().destroy();
                    table = $('#blk_list').DataTable({
                        data: resp['result'],
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
                            {data: "export_country"},
                            {data: "expo_product_name"},
                            {data: "pack_size"},
                            {data: "submission_date"},
                            {data: "current_status"},
                            {data: "registration_date"},
                            {data: "expiry_renewal_date"},
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







    </script>
@endsection