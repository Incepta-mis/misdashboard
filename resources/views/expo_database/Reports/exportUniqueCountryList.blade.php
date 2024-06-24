<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 17/01/2021
 * Time: 11:36 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Export country count of Incepta')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
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
                            Export country count of Incepta
                        </label>
                    </header>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form-horizontal" method="get" action="">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group">
                                            <label class="col-sm-4 col-sm-4 control-label input-sm">IM Team</label>
                                            <div class="col-md-6 col-sm-6">

                                                <select name="im_team" id="im_team"
                                                        class="form-control input-sm im_team" autocomplete="off">
                                                    <option value="" disabled>SELECT TEAM</option>
                                                    <option value="All" selected>All</option>
                                                    <option value="IM-1">IM-1</option>
                                                    <option value="IM-2">IM-2</option>
                                                    <option value="Tender">Tender</option>
                                                    <option value="B2B">B2B</option>
                                                    <option value="MAH">MAH/Other</option>
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
                                                        <option value="Rejected">Rejected</option>
                                                        <option value="Withdrawl">Withdrawal From RA Date</option>
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

            <div class="col-md-6">
                <div class="panel blue-bg">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Total Export Country  </span>
                                <h4>{{ $noOfCountry[0]->no_of_country }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel green-bg">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Total No. Export Product  </span>
                                <h4>{{ $noOfBrand[0]->brand_name }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row states-info st-info-2" style="display: none;">

            <div class="col-md-6">
                <div class="panel blue-bg">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Total Export Country  </span>
                                <h4 > <span id="no_of_expo_country"></span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel green-bg">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Total Number of Brand  </span>
                                <h4><span id="no_of_brand"></span></h4>
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
                                    </tr>
                                    </thead>
                                    <tbody style="white-space:nowrap;overflow:hidden;">
                                    @foreach ($rs as  $result)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $result->export_country }}</td>
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
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}


    <script type="text/javascript">

        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                     'excel'
                ]
            });
        } );



        $("#btn_display").click(function () {

            $("#loader").show();

            let im_team = $('.im_team').val();
            let curr_status = $('.curr_status').val();
            console.log(im_team);




            let data = {im_team: im_team, current_status :curr_status,  "_token": "{{ csrf_token() }}"};
            let table;
            $.ajax({
                type: "post",
                dataType: 'json',
                data: data,
                url: "{{ url('expo/report/getExpoCountryByGroup') }}",
                success: function (resp) {
                     console.log("Success Data : ", resp['result']);

                    $("#loader").hide();
                    $("#report-body").show();

                    $("#report-body-1").hide();
                    $(".st-info-1").hide();

                    $("#report-body-2").show();
                    $(".st-info-2").show();

                    if(resp['result'].length !== 0){
                        console.log(resp['noOfCountry'][0]['no_of_country']);
                        console.log(resp['noOfBrand'][0]['no_of_brand']);

                        $('#no_of_expo_country').html(resp['noOfCountry'][0]['no_of_country']);
                        $('#no_of_brand').html(resp['noOfBrand'][0]['no_of_brand']);
                    }
                    else{
                        $('#no_of_expo_country').html(0);
                        $('#no_of_brand').html(0);
                    }


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