<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 1/9/2019
 * Time: 4:09 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Block List Amendment information ')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        #further_rate_th{
            border: none !important;
            padding: 4px !important;
            text-align: center;
        }

        #amendment_table_css tr td{
            border: 1px solid grey;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
            vertical-align: top !important;
            border: 1px solid grey;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 12px;
        }

        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .bolded {
            font-weight:bold;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
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

        /* #blk_list > tbody > tr > td {
             word-break: break-all;
         }*/

        #blk_list.display {
            margin: 0 auto;
            width: 100%;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap:break-word;
        }

        #blk_list.dataTable tr.odd  { background-color: #E0FFFF; }
        #blk_list.dataTable tr.even  { background-color: #E6E6FA; }

        /* tr.highlighted td {
             background: yellow;
         }
 */

        .amendment_card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.4);
            transition: 0.3s;
            width: 100%;
        }
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Block List Amendment information
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12 col-sm-12">
                                <form action="" class="form-horizontal" role="form" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="cmp"
                                                       class="col-md-3 col-sm-3 control-label"><b>Company:</b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select name="cmp" id="cmp"
                                                            class="form-control input-sm cmp">
                                                        <option value="">Select Company</option>
                                                        @foreach($cmp_data as $c)
                                                            <option value="{{$c->plant}}">{{$c->company}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="blList" class="col-md-3 col-sm-3 control-label"><b>BlockList: </b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select class="form-control input-sm blList" id="blList"  name="blList">
                                                        <option value="">Select BlockList</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="materials"
                                                       class="col-md-3 col-sm-3 control-label"><b>Materials:</b></label>
                                                <div class="col-md-9 col-sm-9">
                                                    <select name="materials" id="materials"
                                                            class="form-control input-sm materials">
                                                        <option value="">Select Materials</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <div class="col-md-offset-1 col-sm-offset-1 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-check"></i> <b>Material Details</b></button>
                                                </div>
                                                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                    <div id="export_buttons">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" id="loader" style="display: none;margin-top: -10px;height: 5px">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="30px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 25px">
        <div></div>
        <div id="amendment_info" style="padding: 10px;text-align: center;justify-content: center" class="">

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

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Date--}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}
    {{Html::script('public/site_resource/js/jquery.formautofill.min.js')}}




    <script>


        $(document).ready(function () {
            var plant;

            function objectifyForm(formArray) {
                //serialize data function
                var returnArray = {};
                for (var i = 0; i < formArray.length; i++) {
                    returnArray[formArray[i]['name']] = formArray[i]['value'];
                }
                return returnArray;
            }


            /*Rate type onchange event*/
            $(document).on("change", "#rate_type" , function() {
                $(this).parent().parent().find("td:eq(8)").css('display','block');
                $('#further_rate_th').css('display','block');

            });
            /*Supplier name onchange event*/
            $(document).on("focus", "#supplier_name" , function() {

                $(this).parent().parent().find("td:eq(9) #supp_change").val('true');

            });

            /*Amendment Data Display Buttton*/
            $("#btn_display").click(function () {
                $('#clear_blk').hide();
                plant = $('#cmp').val();
                var blList = $('#blList').val();
                var materials = $('#materials').val();
                var dataxx;


                console.log("show plant_id");
                console.log(plant);


                var cnm =  $('.cmp').find(":selected").text();
                var blk =  $('.blList').find(":selected").text();

                $('#cname').text(cnm);
                $('#blklistno').text(blk);

                $("#loader").show();


                dataxx = {plant: plant, blList: blList, materialName : materials, "_token": "{{ csrf_token() }}"};
                var table;
                $.ajax({
                    type: "post",
                    dataType: 'json',
                    data: dataxx,
                    url: "{{ url('scm_portal/amendment_summary_data') }}",
                    success: function (resp) {
                        $("#loader").hide();
                        $("#amendment_info").empty();

                        let row = '';
                        for (let i = 0; i < resp.length; i++) {
                            row += '<tr id="amendment_data">' +
                                '<td id="blocklist_no" name="blocklist_no">' + resp[i].blocklist_no + '</td>' +
                                '<td  id="material_name" name="material_name" style="font-weight: bold">' + resp[i].material_name + '</td>' +
                                '<td id="price" name="price">' + resp[i].price + '</td>' +
                                '<td  id="manufacturer_name" name="manufacturer_name">' + resp[i].manufacturer_name + '</td>' +
                                '<td  id="supplier_name" name="supplier_name"><input  class="form-control" onfocus=this.value=null id="supplier_name" style="width: 100%" type = "text" value="'+ resp[i].supplier_name +'"></td>' +

                                '<td id="currency" name="currency" >' + resp[i].currency + '</td>' +
                                '<td ><input id="file_'+i+'"  name="file" type= "file" class="form-control"></td>' +
                                '<td><select  name="rate_type" id="rate_type" style="width: 100%" class="form-control">  ' +
                                '<option value="">Select Rate Type</option>'+
                                '<option value="by_air">By Air</option>' +
                                '<option value="by_road">By Road</option>   ' +
                                ' <option value="by_ship">By Ship</option>' +
                                '</select></td>' +
                                '<td  style="display: none"><input id="next_rate" name="next_rate" type = "text" class="form-control"></td>' +
                                '<td style="display: none"><input id="supp_change" name="supp_change" type ="hidden" class="form-control" value=""></td>' +

                                '</tr>';
                        }

                        let table = '<table class="table table-striped" id="amendment_table_css" style="border: 1px solid grey;width: 98%;margin-left: 1%;margin-right: 1%;margin-top: 20px">\n' +
                            '            <thead>\n' +
                            '            <tr style="border: 1px solid grey" class="bg-info">\n' +
                            '                <th style="text-align: center">Blocklist Number</th>\n' +
                            '                <th style="text-align: center">Material Name</th>\n' +
                            '                <th style="text-align: center">Current Price</th>\n' +
                            '                <th style="text-align: center">Manufacturer Name</th>\n' +
                            '                <th style="text-align: center">Supplier Name</th>\n' +
                            '                <th style="text-align: center">Currency</th>\n' +
                            '                <th style="text-align: center" id="pdf_upload">Upload Pdf</th>\n' +
                            '                <th style="border: 1px solid grey;text-align: center">Rate Type</th>\n' +
                            '                <th style="display: none" id="further_rate_th">Further Rate</th>\n' +
                            '            </tr>\n' +
                            '            </thead>\n' +
                            '            <tbody>\n' +
                            '            ' + row + '' +
                            '            </tbody>\n' +
                            '        </table>';
                        ;

                        let form_view = '<form method="post" id="amendment_form" enctype="multipart/form-data" class="amendment_card" >'+
                            '<div style="background-color: #5AB6DF;">'+

                            ' Company : <span id="cname" style="font-size: large; color: white">Incepta Pharmaceuticals Ltd. (IPL)</span>. &nbsp; And Selected Blocklist is: <span id="blklistno" style="font-size: large;  color: white">'+blList+'</span>'+

                            '</div>'

                            +table+
                            '<input id="amendment_submit_button"  type="submit" style="text-align: center;position: center;margin-bottom: 10px" class="btn btn-info" >'+

                            '<form>';

                        $('#amendment_info').append(form_view);


                    },
                    error: function (err) {
                        $("#loader").hide();
                        $("#loader").hide();
                    }
                });

            });

            /*Submit Amendment Data*/
            $(document).on("submit", "#amendment_form" , function(e) {
                e.preventDefault();
                var form_data = new FormData();

                var arrData=[];

                $("#loader").show();

                $('[id="amendment_data"]').each(function(value,key) {
                    form_data.append("files[]", document.getElementById('file_'+value).files[0]);

                    var blocklist_no = $(this).find("td:eq(0)").text();
                    var material_name = $(this).find("td:eq(1)").text();
                    var price = $(this).find("td:eq(2)").text();
                    var manufacturer_name = $(this).find("td:eq(3)").text();
                    var supplier_name = $(this).find("td:eq(4) #supplier_name").val();
                    var currency = $(this).find("td:eq(5)").text();
                    var rate_type = $(this).find("td:eq(7) option:selected").val();
                    var next_rate = $(this).find("td:eq(8) #next_rate").val();
                    var supp_change = $(this).find("td:eq(9) #supp_change").val();

                    var obj={};
                    obj.blocklist_no=blocklist_no;
                    obj.material_name=material_name;
                    obj.manufacturer_name=manufacturer_name;
                    obj.supplier_name=supplier_name;
                    obj.price=price;
                    obj.currency=currency;
                    obj.rate_type=rate_type;
                    obj.next_rate=next_rate;
                    obj.supp_change=supp_change;
                    obj.plant_id =plant;

                    if(document.getElementById('file_'+value).files.length > 0){
                        obj.filename = document.getElementById('file_'+value).files[0]['name'];
                    }else{
                        obj.filename = "";
                    }

                    arrData.push(obj);
                });


                let count=0;
                for(var i = 0;i<arrData.length;i++){
                    if(arrData[i]['next_rate'].length!=0 || arrData[i]['filename'].length!=0 || arrData[i]['supp_change'].length!=0){

                        count++;
                    }
                }

                if(count==0){
                    $("#loader").hide();
                    toastr.error('PLEASE INSERT SOME VALUE');
                    return false;
                }

                var finalJson = JSON.stringify(arrData);
                form_data.append('data', finalJson);
                form_data.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ url('scm_portal/submit_amendment_data') }}",
                    type: 'post',
                    data: form_data,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        toastr.info('Saved Successfully');
                        $("#loader").hide();
                    },
                    error: function (error) {
                        toastr.error('UNABLE TO SAVE');
                        $("#loader").hide();
                    }
                });
            });


            $('#clear_blk').hide();

            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#datetimepicker2').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: true
            });

            $('#cmp').on('change', function () {

                $(".blList").val('');
                var plant = $('#cmp').val();
                $(".blList").empty().append("<option value='loader'>Loading...</option>");
                $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/plant_blocklist')}}',
                    dataType: 'json',
                    data: {plant: plant,"_token":"{{ csrf_token() }}"},
                    success: function (response) {
                        var selbllist ='';
                        selbllist += "<option value=''>Select Item</option>";
                        selbllist += "<option value='All'>All</option>";
                        for (var k = 0; k< response.length; k++) {
                            var id = response[k]['blocklist_no'];
                            var val = response[k]['blocklist_no'];
                            selbllist += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('#blList').empty().append(selbllist);
                    },
                    error: function (response) {

                    }
                });

                $(".blList").select2();

            });


            $('#blList').on('change', function () {


                let plant = $('#cmp').val();
                let blList = $('#blList').val();


                $(".materials").empty().append("<option value='loader'>Loading...</option>");

                $.ajax({
                    type: "post",
                    url: '{{url('scm_portal/plantBlockListWiseMaterials')}}',
                    dataType: 'json',
                    data: {plant: plant, blckListNo: blList,"_token":"{{ csrf_token() }}"},
                    success: function (response) {

                        let selMaterialName ='';
                        selMaterialName += "<option value=''>Select Item</option>";
                        selMaterialName += "<option value='All'>All</option>";
                        for (let k = 0; k< response.length; k++) {
                            let id = response[k]['material_name'];
                            let val = response[k]['material_name'];
                            selMaterialName += "<option value='" + id + "'>" + val + "</option>";
                        }

                        $('#materials').empty().append(selMaterialName);
                    },
                    error: function (response) {

                    }
                });

                $(".materials").select2();

            });


            $('#blk_list tbody').on( 'click', 'tr', function () {
                $('#clear_blk').show();
                $('#blk_list tr').removeClass('highlighted');
                $(this).addClass('highlighted');
            } );


        });
    </script>

@endsection

