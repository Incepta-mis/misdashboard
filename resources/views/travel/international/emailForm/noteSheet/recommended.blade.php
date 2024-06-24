<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 08/09/2020
 * Time: 3:06 PM
 */
?>
@extends('_layout_shared._master')
@section('title','NoteSheet Recommended By - International Approved ')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>



    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
            font-size: x-small;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 2px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 2px;
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

        input {
            color: black;
        }

        .cnt {
            text-align: center;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .modal {

        }

        .modal-dialog {
            width: 90%;
            height: 90%;

        }

        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
        }

        .vertical-align-center {
            /*To center vertically */
            display: table-cell;
            vertical-align: middle;
        }

        .modal-content {
            height: auto;
            /*min-height: 100%;*/
            border-radius: 0;
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
        }

        .form-control {
            height: 24px;

        }

        table {
            border-collapse: collapse;
        }
        table td {
            border: 1px solid black;
            font-size: 10px;
        }
        table th {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-size: 11px;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" >
                <header class="panel-heading">
                    <label class="text-default">
                        Travel Note Sheet Recommended
                    </label>
                </header>

                <div class="panel-body">

                    <p class="cnt" style="font-size: 25px;"><b>Incepta Pharmaceuticals Ltd.</b></p>
                    <p class="cnt" style="font-size: 15px;"><u> <b>NOTE SHEET</b> </u></p>

                    <span style="float: left"> {{ date('F d,Y') }} </span>   <span style="float:right;">Group ID: {{ $tvM[0]->group_no }} </span>
                    <input type="hidden" id="group_id" value="{{ $tvM[0]->group_no }}">

                    <br>
                    <br>


                    <table  class="display table table-bordered table-striped"  style="width:100%; border: 1px solid black; ">
                        <thead>
                        <tr>
                            <th>Doc No</th>
                            <th>Name</th>
                            <th>Emp ID</th>
                            <th>Designation</th>
                            <th>GL</th>
                            <th>CC</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tvReq as $r)
                            <tr>
                                <td>{{ $r->document_no }}<a target="_blank" style="padding-left: 2px" href="{{ route('international.noteSheetDetailsView', $r->document_no) }}">
                                        <button type="submit" class="btn btn-danger btn-xs">Details</button>
                                    </a>
                                </td>
                                <td>{{ $r->emp_name }}</td>
                                <td>{{ $r->emp_id }}</td>
                                <td>{{ $r->desig_name }}</td>
                                <td>{{ $r->gl_code }}</td>
                                <td>{{ $r->cost_center_id }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <h3>Route & Time Information</h3>

                    <table  class="display table table-bordered table-striped"  style="width:100%; border: 1px solid black; ">
                        <thead>
                        <tr>
                            <th colspan="2" class="textcntr">Route</th>
                            <th colspan="2" class="textcntr">Date</th>
                            <th colspan="2" class="textcntr">BD Local Time</th>
                            <th colspan="2" class="textcntr">Local Time Of Visiting Country</th>
                        </tr>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>From</th>
                            <th>To</th>
                            <th>From</th>
                            <th>To</th>
                            <th>From</th>
                            <th>To</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tvM as $m)
                            <tr>
                                <td>{{ $m->from_loc_text }}, {{ $m->from_loc }}</td>
                                <td>{{ $m->to_loc_text }}, {{ $m->to_loc }}</td>
                                <td>{{ date('d-m-Y', strtotime($m->from_date))  }}</td>
                                <td>{{ date('d-m-Y', strtotime($m->to_date))  }}</td>
                                <td>{{ $m->bd_from_time }}</td>
                                <td>{{ $m->bd_to_time }}</td>
                                <td>{{ $m->fg_from_time }}</td>
                                <td>{{ $m->fg_to_time }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                    <h3>Expenditure Information</h3>
                    <p></p>

                    <table  class="display table table-bordered table-striped"  style="width:100%; border: 1px solid black; ">
                        <thead>
                        <tr>
                            <th>Air Fare</th>
                            <th>Hotel</th>
                            <th>Meals</th>
                            <th>Incidentals</th>
                            <th>Daily Allowance</th>
                            <th>Other</th>
                            <th>Total (BDT)</th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($tvAms as $m)
                                <td>{{ $m->air_fare }}</td>
                                <td>{{ $m->hotel }}</td>
                                <td>{{ $m->meals }}</td>
                                <td>{{ $m->incidentals }}</td>
                                <td>{{ $m->daily_allowance }}</td>
                                <td>{{ $m->other }}</td>
                                <td>{{ $m->total }}</td>
                            @endforeach
                        </tr>
                        </tbody>
                    </table>

                    <div class="row" style="padding-top: 5px;"><br>
                        <div class="row" style="padding-top: 60px;">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="col-md-3 col-sm-3" style="float: left">
                                    <button type="button" class="btn btn-info btn-sm" disabled> Prepared </button>
                                    <p>------------------------------</p>
                                    Prepared By<br>
                                    Rahnuma Momtaj<br>
                                    Sr. officer, HR
                                </div>
                                <div class="col-md-3 col-sm-3" style="float: left">
                                    <button type="button" class="btn btn-info btn-sm" disabled > <i class="ico-file-check"> Checked </i>  </button>                                   
                                    <p>------------------------------</p>Checked By<br>
                                    Md. Anayet Hossain<br>
                                    Senior Manager, HR
                                </div>
                                <div class="col-md-3 col-sm-3" style="float: left">
                                    @if(empty($apprs[0]->recommended_id))                               
                                        <button type="button" class="btn btn-info btn-sm accept" > <i class="ico-file-check"> Verify </i>  </button>
                                        <button type="button" class="btn btn-danger btn-sm reject" > <i class="ico-alarm-plus"> Not Verify </i>  </button>
                                    @else
                                        <button type="button" class="btn btn-info btn-sm" disabled > <i class="ico-file-check"> Verify </i>  </button>
                                        <button type="button" class="btn btn-danger btn-sm reject" disabled > <i class="ico-alarm-plus"> Not Verify </i>  </button>
                                    @endif
                                    <p>------------------------------</p>Recommended By<br>
                                    Naimul Huda<br>
                                    General Manager, F&A
                                </div>
                                <div class="col-md-3 col-sm-3" style="float: right">
                                    <button type="button" class="btn btn-warning btn-sm " disabled > <i class="ico-file-check"> Pending </i>  </button>
                                    <p>------------------------------</p>Approved By<br>
                                    Vice Chairman

                                </div>
                            </div>
                        </div>
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

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">

        // $("#example").DataTable({});

        //for accpt button
        $(document).on("click",".accept",function() {
            var group_id  = $('#group_id').val();
            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {group_id: group_id},
                url: "{{ route('international.intlTravelNoteSheetRecommAppr') }}",
                success: function (resp) {
                    console.log(resp);
                    if (resp.success) {

                        $(".accept"). attr("disabled", true);

                        toastr.success(resp.success, '', {timeOut: 2000});
                        location.reload();
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function (e) {
                    console.log('Error - ',e);
                }
            });



        });


        //for reject button
        $(document).on("click",".reject",function() {
            var group_id  = $('#group_id').val();
            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {group_id: group_id},
                url: "{{ route('international.intlTravelNoteSheetRecommNotAppr') }}",
                success: function (resp) {
                    console.log(resp);
                    if (resp.success) {

                        $(".reject"). attr("disabled", true);

                        toastr.success(resp.success, '', {timeOut: 2000});
                        location.reload();
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function (e) {
                    console.log('Error - ',e);
                }
            });



        });


                @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch (type) {

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif


    </script>

@endsection

