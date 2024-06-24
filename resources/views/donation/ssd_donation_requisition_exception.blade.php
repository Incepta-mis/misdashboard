<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 20-Aug-19
 * Time: 3:10 PM
 */
?>

@extends('_layout_shared._master')
@section('title','Requisition Exception')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


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

        #inf {
            text-transform: uppercase;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Requisition Form
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" id="don_req" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    @if(Auth::user()->desig === 'HO')


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Rm Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            @foreach($rm_terr as $rt)
                                                                <option value="{{$rt->rm_terr_id}}">{{$rt->rm_terr_id}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-6 col-sm-6 control-label"><b>Am Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="am_terr" id="am_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-6 col-sm-6 control-label"><b>MPO Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="mpo_terr" id="mpo_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select Territory</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-6 col-sm-6 control-label"><b>Doctor Id
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="docid" id="docid"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="depo"
                                                           class="col-md-6 col-sm-6 control-label"><b>Depot Name
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="depo" id="depo"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>


                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="don_type" class="col-md-6 col-sm-6 control-label"><b>Expense
                                                            Type:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="don_type" id="don_type"
                                                                class="form-control input-sm">
                                                            <option value="">Select Expense Type</option>
                                                            @foreach($dtm as $tm)
                                                                <option value="{{$tm->main_cost_center_name}}"
                                                                        data-tpn="{{$tm->type_name}}"
                                                                        data-brn="{{$tm->type}}"
                                                                        data-gl="{{$tm->gl}}">{{$tm->type_mct}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gbrn"
                                                           class="col-md-6 col-sm-6 control-label"><b>Group/Brand/Region
                                                            Name :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="gbrn" id="gbrn"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ben_type"
                                                           class="col-md-6 col-sm-6 control-label"><b>Beneficiary Type
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="ben_type" id="ben_type"
                                                                class="form-control input-sm">
                                                            <option value="">Select Beneficiary</option>
                                                            @foreach($dbt as $db)
                                                                <option value="{{$db->dbt_description}}">{{$db->dbt_description}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pay_mode"
                                                           class="col-md-6 col-sm-6 control-label"><b>Payment Mode :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="pay_mode" id="pay_mode"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="CASH">CASH</option>
                                                            <option value="CHEQUE">CHEQUE</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="purpose"
                                                           class="col-md-6 col-sm-6 control-label"><b>Purpose
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="purpose" id="purpose"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            @foreach($dpm as $dp)
                                                                <option value="{{$dp->purpose_name}}">{{$dp->purpose_name}}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="freq"
                                                           class="col-md-6 col-sm-6 control-label"><b>Frequency
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="freq" id="freq"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            @foreach($freq as $frq)
                                                                <option value="{{$frq->df_description}}">{{$frq->df_description}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pay_dt"
                                                           class="col-md-6 col-sm-6 control-label"><b>Payment Month
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select class="form-control input-sm" name="date1"
                                                                style="padding-right: 0px;" id="date1">
                                                            <option value="">Select</option>
                                                            @foreach($month_name as $mont)
                                                                <option value="{{$mont->monthname}}">{{$mont->monthname}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="amount"
                                                           class="col-md-6 col-sm-6 control-label"><b>Proposed Amount
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control input-sm" id="amount"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inf"
                                                           class="col-md-6 col-sm-6 control-label"><b>Requested in
                                                            favour of
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control input-sm" id="inf"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="commitment"
                                                           class="col-md-6 col-sm-6 control-label"><b>Remarks
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control input-sm" id="commitment"
                                                               autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        {{-- Doctor Details--}}
                                        <div class="form-group " id="doc_info" style="display: none">
                                            <div class="col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10 col-xs-6 table-responsive">
                                                <table id="docinfo" width="100%"
                                                       class="table table-bordered table-condensed table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Name</th>
                                                        <th>No of Patient</th>
                                                        <th>Contact No</th>
                                                        <th>Infavour of</th>
                                                        <th>Address</th>
                                                        <th>Speciality</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-sm-offset-3 col-md-2 col-sm-2 col-xs-6">
                                                <button type="submit" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Save</b></button>
                                            </div>

                                        </div>


                                    @else
                                        <p style="color: red;"><b>Sorry! You're not authorised to access the content of
                                                this module</b></p>
                                    @endif

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
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

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script>
        am_fetch_ssd = "{{url('donation/am_fetch_ssd')}}";
        servloc_tid = "{{url('donation/regwMpoTerrList')}}";
        depo_and_doc = "{{url('donation/depo_and_doc')}} ";
        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function () {

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
                            type: "post",
                            url: am_fetch_ssd,
                            dataType: 'json',
                            data: {rmTerr: rm_terr, _token: _csrf_token},
                            success: function (response) {
                                console.log(response);

                                var selOptsAM = "";
                                selOptsAM += "<option value=''>Select Territory</option>";
                                selOptsAM += "<option value='ALL'>ALL</option>";


                                for (var i = 0; i < response.length; i++) {
                                    var id = response[i]['am_terr_id'];
                                    var val = response[i]['am_terr_id'];

                                    selOptsAM += "<option value='" + id + "'>" + val + "</option>";
                                }
                                $('#am_terr').html(selOptsAM);


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

                $("#am_terr").on('change', function () {
                    $('#docid').empty();
                    $("#doc_info").hide();
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
                                var val = response[j]['mpo_terr_id'];
                                selOptsMPO += "<option value='" + id + "'>" + val + "</option>";
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
                    $("#doc_info").hide();
                    var mpo_terr = $("#mpo_terr").val();

                    console.log(mpo_terr);

                    $("#docid").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        type: "post",
                        url: depo_and_doc,
                        dataType: 'json',
                        data: {
                            mpo_terr: mpo_terr,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (response) {
                            console.log(response);

                            var selOptsDOC = "";
                            selOptsDOC += "<option value=''>Select Doctor</option>";
                            for (var j = 0; j < response['docid'].length; j++) {
                                var id = response['docid'][j]['doctor_id'];
                                var val = response['docid'][j]['doctor_id'] + '-' + response['docid'][j]['doctor_name'];
                                selOptsDOC += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#docid').empty().append(selOptsDOC);


                            // for Depot


                            var selOptsDEPOT = "";
                            selOptsDEPOT += "<option value=''>Select Depot</option>";
                            for (var j = 0; j < response['depo'].length; j++) {
                                var id = response['depo'][j]['depot_id'];
                                var val = response['depo'][j]['depot_name'];
                                selOptsDEPOT += "<option value='" + id + "'>" + val + "</option>";
                            }
                            $('#depo').empty().append(selOptsDEPOT);


                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                });

                $('#inf').keyup(function () {
                    $(this).val($(this).val().toUpperCase());
                });
                $("#docid").select2();
                var dn = '';
                var np = '';
                var cno = '';
                var infav = '';
                var adr = '';
                var specs = '';
                var scn = '';
                var ccid = '';
                var sccid = '';
                var ccn = '';
                var inf_original = '';

                $("#inf").change(function () {
                    // $("#inf").css("color", "red");
                    // console.log(inf_original);
                    if (document.getElementById('inf').value.toUpperCase() != inf_original) {
                        $("#inf").css("color", "red");
                        console.log(inf_original);
                        console.log($("#inf").val());
                        // console.log($("#inf").val().toUpperCase());
                        // $("#inf").css("color", "red");
                    }
                    else {
                        $("#inf").css("color", "black");
                    }

                    // alert("The text has been changed.");
                });

                $("#don_type").on('change', function () {

                    $("#gbrn").html('');
                    scn = '';
                    // $('#gbrn').append($('<option></option>').html('Loading...'));
                    ccn = $("#don_type").val();                     // Cost center name
                    var dntype = $("#don_type option:selected").text();  // Donation type
                    var rnbd = $("#don_type option:selected").data('brn');  // Donation type

                    var mpo_terr = $("#mpo_terr").val();

                    console.log(dntype);
                    console.log(ccn);
                    console.log(rnbd);

                    if (ccn == 'MSD') {
                        console.log('hey MSD');
                        $.ajax({
                            method: "post",
                            url: '{{url('donation/brand_region_post_exception')}}',
                            data: {
                                _token: '{{csrf_token()}}',
                                rnbd: rnbd,
                                mpo_terr: mpo_terr
                            },
                            success: function (data) {
                                console.log(data);
                                console.log(data.length);
                                if ((data.length) > 0) {
                                    var op = '';
                                    if (rnbd == 'BRAND') {
                                        op += '<option value="" selected disabled>Select Brand</option>';
                                    }
                                    else if (rnbd == 'REGION') {
                                        op += '<option value="" selected disabled>Select Region</option>';
                                    }

                                    for (var i = 0; i < data.length; i++) {
                                        op += '<option value= " ' + data[i]['cost_center_id'] + ' "   data-sccid= " ' + data[i]['sub_cost_center_id'] + ' " >' + data [i]['sub_cost_center_name'] + '</option>';
                                    }
                                    $('#gbrn').html(" ");
                                    $('#gbrn').append(op);

                                }


                                $("#gbrn").on('change', function () {
                                        ccid = $('#gbrn').val();
                                        sccid = $("#gbrn option:selected").data('sccid');
                                        scn = $("#gbrn option:selected").text();

                                        console.log(ccid);
                                        console.log(sccid);
                                        console.log(scn);


                                    }
                                );


                            },
                            error: function () {
                                console.log('fail');
                            }
                        });


                    }
                    else {
                        var mpo_terr = $("#mpo_terr").val();
                        console.log('hey SALES');
                        $('#gbrn').append($('<option>No option available</option>'));

                        //    Retrieving cost center for Sales
                        $.ajax({
                            method: "post",
                            url: '{{url('donation/cost_center_sales_exception')}}',
                            data: {
                                _token: '{{csrf_token()}}',
                                mpo_terr: mpo_terr
                            },
                            success: function (data) {
                                console.log(data[0]['cost_center_id']);
                                console.log(data[0]['cost_center_description']);
                                console.log(data.length);
                                ccid = data[0]['cost_center_id'];
                                sccid = '';
                                scn = '';

                            },
                            error: function () {
                                console.log('fail');
                            }
                        });

                        //    here ends the ajax request
                    }

                });

                $("#docid").on('change', function () {
                    var dcid = $("#docid").val();
                    var mpo_terr = $("#mpo_terr").val();
                    console.log(dcid);
                    console.log(mpo_terr);
                    var table = "";
                    if (dcid != '') {
                        $.ajax({
                            method: 'post',
                            url: '{{url('donation/doc_info_post_exception')}}',
                            data: {
                                dcid: dcid,
                                mpo_terr: mpo_terr,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (data) {
                                console.log(data);
                                // console.log(data[0]['in_favour_of']);
                                // $('#docinfo').DataTable().destroy();
                                //
                                // table= $('#docinfo').DataTable({
                                //     data: data,
                                //     columns:[
                                //         {data:"doctor_id"},
                                //         {data:"doctor_name"},
                                //         {data:"no_of_patient"},
                                //         {data:"mobile"},
                                //         {data:"address"},
                                //         {data:"in_favour_of"},
                                //         {data:"speciality"},
                                //
                                //     ]
                                // });
                                dn = data[0]['doctor_name'];

                                np = data[0]['no_of_patient'];
                                cno = data[0]['mobile'];
                                // infav=data[0]['in_favour_of'] ;
                                adr = data[0]['address'];
                                specs = data[0]['speciality'];

                                $('#inf').val(data[0]['in_favour_of']);
                                $("#inf").css("color", "black");
                                inf_original = data[0]['in_favour_of'];


                                $("#docinfo tbody").empty();
                                var markup = "";
                                var markup = "<tr><td> " + data[0]['doctor_id'] + "</td><td> " + data[0]['doctor_name'] + "</td>" +
                                    "<td>" + data[0]['no_of_patient'] + "</td>" + "<td>" + data[0]['mobile'] + "</td>" +
                                    "<td>" + data[0]['in_favour_of'] + "</td>" + "<td>" + data[0]['address'] + "</td>" + "<td>" + data[0]['speciality'] + "</td>"
                                "</tr>";


                                $("#docinfo tbody").append(markup);

                                $("#doc_info").show();
                                // table.columns.adjust();
                            },
                            error: function () {
                                console.log('fail');
                            }

                        });
                    }

                });

                $(document).on('submit', '#don_req', function (event) {
                    event.preventDefault();
                    console.log('Save button clicked');
                    console.log(ccn);
                    console.log(scn);


                    // checking input value
                    if ($("#don_type").val() === "") {
                        toastr.info("Please select Research Expense Type");
                    }
                    else if ($("#depo").val() === "") {
                        toastr.info("Please select Depot Name");
                    }
                    // (scn == null) &&
                    else if ((ccn == 'MSD') && (scn == "")) {
                        console.log(ccn);
                        toastr.info("Please select Brand or Region ");
                    }

                    else if ($("#ben_type").val() === "") {
                        toastr.info("Please select Beneficiary type");
                    }

                    else if ($("#pay_mode").val() === "") {
                        toastr.info("Please select payment mode");
                    }

                    else if ($("#purpose").val() === "") {
                        toastr.info("Please select purpose");
                    }

                    else if ($("#freq").val() === "") {
                        toastr.info("Please select frequency");
                    }
                    else if ($("#date1").val() === "") {
                        toastr.info("Please select payment date");
                    }
                    else if ($("#amount").val() === "") {
                        toastr.info("Please enter amount");
                    }
                    else if ($("#docid").val() === "") {
                        toastr.info("Please select Doctor");
                    }
                    else if (ccid === "") {
                        toastr.info("No Territory Assigned !!  Please, Contact with your RM");
                    }
                    else {
                        var don_type = $("#don_type option:selected").data('tpn');
                        var gl = $("#don_type option:selected").data('gl');
                        // var group=$("#gbrn option:selected").text();
                        var beneficiary = $("#ben_type").val();
                        var pay_mode = $("#pay_mode").val();
                        var purpose = $("#purpose").val();
                        var freq = $("#freq").val();
                        var pay_dt = $("#date1").val();
                        var amount = $("#amount").val();
                        var doc_id = $("#docid").val();
                        var comment = $("#commitment").val();
                        var dpid = $("#depo").val();
                        var dpname = $("#depo option:selected").text();
                        var mpo_terr = $("#mpo_terr").val();

                        infav = $('#inf').val();
                        console.log(mpo_terr);
                        console.log(dpid);
                        console.log(dpname);
                        console.log(don_type);
                        console.log(gl);
                        console.log(ccn);
                        console.log(scn);
                        console.log(ccid);
                        console.log(sccid);
                        console.log(beneficiary);
                        console.log(pay_mode);
                        console.log(purpose);
                        console.log(freq);
                        console.log(pay_dt);
                        console.log(amount);
                        console.log(doc_id);
                        console.log(dn);
                        console.log(np);
                        console.log(cno);
                        console.log(infav);
                        console.log(adr);
                        console.log(specs);
                        console.log(comment);

                        $.ajax({
                            method: 'post',
                            url: '{{url('donation/ssd_insert_data_exception')}}',
                            data: {
                                _token: '{{csrf_token()}}',
                                inf_ori: inf_original,
                                dpid: dpid,
                                dpname: dpname,
                                don_type: don_type,
                                gl: gl,
                                group: scn,
                                beneficiary: beneficiary,
                                pay_mode: pay_mode,
                                purpose: purpose,
                                freq: freq,
                                pay_dt: pay_dt,
                                amount: amount,
                                doc_id: doc_id,
                                dn: dn,
                                np: np,
                                cno: cno,
                                infav: infav,
                                adr: adr,
                                specs: specs,
                                comment: comment,
                                ccid: ccid,
                                sccid: sccid,
                                mpo_terr: mpo_terr
                            },
                            success: function (data) {
                                // console.log(data[0]['req_id']);
                                toastr.success('Data has been saved successfully ');
                                document.getElementById("don_req").reset();
                                $("#doc_info").hide();
                                // $("#docid").val('');
                                $("#docid").select2('val', 'All');
                            },
                            error: function () {
                                toastr.error('Failed to save Data ');

                            }

                        });
                    }


                });


            }
        );

    </script>
@endsection