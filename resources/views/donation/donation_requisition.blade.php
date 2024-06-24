<?php
/**
 * Created by PhpStorm.
 * User: sahadat
 * Date: 18-Dec-18
 * Time: 2:10 PM
 */
?>

@extends('_layout_shared._master')
@section('title','Requisition')
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
        #inf{text-transform: uppercase;}

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Requisition
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" id="don_req" class="form-horizontal" role="form">
                                    {{--                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    @if(Auth::user()->desig === 'GM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'Sr. TSO' ||
                                                Auth::user()->desig === 'TSO' || Auth::user()->desig === 'All'||
                                                Auth::user()->desig === 'HO'||Auth::user()->desig === 'MPO'||Auth::user()->desig === 'Sr. MPO')


                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="docid"
                                                           class="col-md-6 col-sm-6 control-label"><b>Beneficiary Id
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <select name="docid" id="docid"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            @foreach($docid as $doc)
                                                                {{--                                                                <option value="{{$docid->terr_id}}">{{$docid->terr_id}}</option>--}}
                                                                <option value="{{$doc->doctor_id}}">{{$doc->doctor_id}}<span> - </span>{{$doc->doctor_name}}</option>
                                                            @endforeach

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
                                                            @foreach($depo as $dpo)
                                                                {{--                                                                <option value="{{$docid->terr_id}}">{{$docid->terr_id}}</option>--}}
                                                                <option value="{{$dpo->depot_id}}" data-dpn="{{$dpo->depot_name}}">{{$dpo->depot_name}}</option>
                                                            @endforeach

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
                                                                       data-tpn="{{$tm->type_name}}" data-brn="{{$tm->type}}"data-gl="{{$tm->gl}}">{{$tm->type_mct}}</option>
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
                                                            <option value="">Select </option>

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
                                                            <option value="DOCTOR">DOCTOR</option>
{{--                                                            <option value="ASSOCIATION">ASSOCIATION</option>--}}
                                                           <!--  @foreach($dbt as $db)
                                                                <option value="{{$db->dbt_description}}">{{$db->dbt_description}}</option>
                                                            @endforeach -->
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
                                                           class="col-md-6 col-sm-6 control-label"><b>Payment Month :</b></label>
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
                                                        <input type="number"  class="form-control input-sm" id="amount" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="inf"
                                                           class="col-md-6 col-sm-6 control-label"><b>Requested in favour of
                                                            :</b></label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control input-sm" id="inf" autocomplete="off">
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
                                                        <input type="text" class="form-control input-sm" id="commitment" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        {{-- Doctor Details--}}
                                        <div class="form-group " id="doc_info" style="display: none" >
                                            <div class="col-md-offset-1 col-sm-offset-1 col-md-10 col-sm-10 col-xs-6 table-responsive">
                                                <table  id="docinfo" width="100%" class="table table-bordered table-condensed table-striped">
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

        $(document).ready(function () {

            $('#inf').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            $("#docid").select2();
            var dn='';
            var np='';
            var cno='';
            var infav='';
            var adr='';
            var specs='';
            var scn='';
            var ccid='';
            var sccid='';
            var ccn= '';
            var inf_original ='';
            var dnt = '';

            $("#inf").change(function(){
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

                    sccid= '';
                    scn= '';
                    ccid = '';

                    $("#gbrn").html('');

                    // $('#gbrn').append($('<option></option>').html('Loading...'));
                     ccn = $("#don_type").val();                     // Cost center name
                    var dntype = $("#don_type option:selected").text();  // Donation type
                    var rnbd = $("#don_type option:selected").data('brn');  //
                    var type_name = $("#don_type option:selected").data('tpn');

                    console.log(dntype);
                    console.log(ccn);
                    console.log(rnbd);

                    if (ccn == 'MSD') {
                            console.log('hey MSD');
                         $.ajax({
                             method: "post",
                             url: '{{url('donation/brand_region_post')}}',
                             data: {
                                 _token: '{{csrf_token()}}',
                                 rnbd: rnbd
                             },
                             success: function (data) {
                                 console.log(data);
                                 console.log(data.length);

                                     if ((data.length) > 0) {
                                         var op = '';
                                         if(rnbd== 'BRAND'){
                                             op += '<option value="" selected disabled>Select Brand</option>';
                                         }
                                         else if(rnbd== 'REGION'){
                                             op += '<option value="" selected disabled>Select Region</option>';
                                         }

                                         for (var i = 0; i < data.length; i++) {
                                             op += '<option value= " ' + data[i]['cost_center_id'] + ' "   data-sccid= " ' + data[i]['sub_cost_center_id'] + ' " >' + data [i]['sub_cost_center_name'] + '</option>';
                                         }
                                         $('#gbrn').html(" ");
                                         $('#gbrn').append(op);

                                     }

                             },
                             error: function () {
                                 console.log('fail');
                             }
                         });

                    }

                    else {

                        console.log('hey SALES');

                    //    Retrieving cost center for Sales
                        $.ajax({
                        method: "post",
                        url: '{{url('donation/cost_center_sales')}}',
                        data: {
                            type_name:type_name,
                        _token: '{{csrf_token()}}'
                        },
                        success: function (data) {

                            if(type_name=='BRAND RESEARCH SALES'){
                                if ((data.length) > 0) {
                                    var op = '';
                                    op += '<option value="" selected disabled>Select Brand</option>';

                                    for (var i = 0; i < data.length; i++) {
                                        op += '<option value= " ' + data[i]['cost_center_id'] + ' "   data-sccid= " ' + data[i]['sub_cost_center_id'] + ' " >' + data [i]['sub_cost_center_name'] + '</option>';
                                    }
                                    $('#gbrn').html(" ");
                                    $('#gbrn').append(op);

                                }
                            }
                            else if(type_name=='REGION DEVELOPMENT'){
                                if ((data.length) > 0) {
                                    var op = '';
                                    op += '<option value="" selected disabled>Select Region</option>';

                                    for (var i = 0; i < data.length; i++) {
                                        op += '<option value= " ' + data[i]['cost_center_id'] + ' "   data-sccid= " ' + data[i]['sub_cost_center_id'] + ' " >' + data [i]['sub_cost_center_name'] + '</option>';
                                    }
                                    $('#gbrn').html(" ");
                                    $('#gbrn').append(op);

                                }
                            }
                            else{
                                $('#gbrn').html(" ");
                                $('#gbrn').append($('<option>No option available</option>'));
                                console.log(data[0]['cost_center_id']);
                                console.log(data[0]['cost_center_description']);
                                console.log(data.length);
                                ccid = data[0]['cost_center_id'];
                                sccid ='';
                                scn ='';
                            }

                        },
                        error: function () {
                        console.log('fail');
                        }
                        });

                    //    here ends the ajax request
                    }

                });

                $("#gbrn").on('change', function () {
                                      ccid = $('#gbrn').val();
                                      sccid= $("#gbrn option:selected").data('sccid');
                                      scn= $("#gbrn option:selected").text();

                                     console.log(ccid);
                                         console.log(sccid);
                                         console.log(scn);


                                 });

            $("#docid").on('change', function () {
                var dcid= $("#docid").val();
                console.log(dcid);
                var table = "";
                $.ajax({
                    method:'post',
                    url:'{{url('donation/doc_info_post')}}',
                    data: {
                        dcid:dcid,
                        _token: '{{csrf_token()}}'
                    },
                    success:function (data) {
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
                         dn=data[0]['doctor_name'];

                         np=data[0]['no_of_patient'];
                         cno=data[0]['mobile'];
                         // infav=data[0]['in_favour_of'] ;
                         adr=data[0]['address'];
                         specs=data[0]['speciality'];

                        $('#inf').val(data[0]['in_favour_of']);
                        $("#inf").css("color", "black");
                        inf_original = data[0]['in_favour_of'];


                        $("#docinfo tbody").empty();
                        var markup = "";
                        var markup = "<tr><td> " + data[0]['doctor_id'] + "</td><td> " + data[0]['doctor_name'] + "</td>" +
                            "<td>" + data[0]['no_of_patient'] + "</td>" + "<td>" + data[0]['mobile'] + "</td>" +
                        "<td>" + data[0]['in_favour_of'] + "</td>"+"<td>" + data[0]['address'] + "</td>"+"<td>" + data[0]['speciality'] + "</td>"
                            "</tr>";


                        $("#docinfo tbody").append(markup);

                        $("#doc_info").show();
                        // table.columns.adjust();
                    },
                    error:function () {
                        console.log('fail');
                    }

                });

            });

            $(document).on('submit', '#don_req', function (event) {
                dnt = $("#don_type option:selected").data('tpn');
                    event.preventDefault();
                    console.log('Save button clicked');
                    console.log(dnt);
                console.log(scn);
                console.log(ccn);

                    // checking input value
                if ($("#don_type").val() === "") {
                    toastr.info("Please select Research Expense Type");
                }
                else if ($("#depo").val() === "") {
                    toastr.info("Please select Depot Name");
                }
                // (scn == null) &&
                else if ( (ccn == 'MSD') && (scn =="")    ) {
                    console.log(ccn);
                    toastr.info("Please select Brand or Region ");
                }

                else if ( (dnt === 'BRAND RESEARCH SALES') && (scn ==="")    ) {
                    console.log(ccn);
                    toastr.info("Please select Brand ");
                }
                else if ( (dnt === 'REGION DEVELOPMENT') && (scn ==="")    ) {
                    console.log(ccn);
                    toastr.info("Please select Region");
                }

                 else if ( (dnt == 'DPGPE') && (sccid !='')    ) {
                    console.log(ccn);
                    console.log(sccid);
                    toastr.info("Something Went wrong!! Please refresh your browser ");
                }

                else if ( (dnt == 'RESEARCH EXPENSE') && (sccid !='')    ) {
                    console.log(ccn);
                    console.log(sccid);
                    toastr.info("Something Went wrong!! Please refresh your browser ");
                }
                else if (ccid === "") {
                    toastr.info("No Territory Assigned !!  Please, Contact with your RM");
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
                    toastr.info("Please select payment month");
                }
                else if ($("#amount").val() === "") {
                    toastr.info("Please enter amount");
                }
                else if ($("#docid").val() === "") {
                    toastr.info("Please select Doctor");
                }
                else if (dn === "") {
                    toastr.info("Doctor Name can not be null");
                }

                  else if ($("#inf").val() === ""){
                    toastr.info("Infavour of can not be null");
                }

                else{
                    var don_type=$("#don_type option:selected").data('tpn');
                    var gl = $("#don_type option:selected").data('gl');
                    // var group=$("#gbrn option:selected").text();
                    var beneficiary=$("#ben_type").val();
                    var pay_mode=$("#pay_mode").val();
                    var purpose= $("#purpose").val();
                    var freq=$("#freq").val();
                    var pay_dt=$("#date1").val();
                    var amount=$("#amount").val();
                    var doc_id=$("#docid").val();
                    var comment=$("#commitment").val();
                    var dpid=$("#depo").val();
                    var dpname=$("#depo option:selected").text();

                    infav = $('#inf').val();
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
                        method:'post',
                        url:'{{url('donation/insert_data')}}',
                        data:{
                            _token: '{{csrf_token()}}',inf_ori:inf_original,dpid:dpid,dpname:dpname,don_type: don_type,gl:gl,group :scn , beneficiary:beneficiary, pay_mode:pay_mode,purpose:purpose,
                            freq:freq, pay_dt:pay_dt,amount:amount,doc_id:doc_id,dn:dn, np:np,cno:cno, infav:infav ,adr:adr,specs:specs,comment:comment,ccid:ccid, sccid:sccid
                        },
                        success:function(data){

                            console.log(data);
                            // console.log(data[0]['req_npm']);
                            if(data){

                                toastr.info('This Beneficiary is not eligible in this month');
                            }
                            else{

                                toastr.success('Data has been saved successfully ');
                                document.getElementById("don_req").reset();
                                $("#doc_info").hide();
                                $("#docid").select2('val','All');
                            }

                        },
                        error:function (){
                            toastr.error('Failed to save Data ');

                        }

                    });
                }


            });


            }
        );

    </script>
@endsection