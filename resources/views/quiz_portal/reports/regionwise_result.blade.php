<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 29/11/2020
 * Time: 11:39 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Region Wise Results')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!--pickers css-->
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>

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
        .blue {
            background-color: #a6e1ec !important;
        }
        .red {
            background-color: yellow !important;
        }
        .gray {
            background-color: #F0F0F0 !important;
        }
        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 2px;
            font-size: 9px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 9px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 9px;
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

        #custom-tab {
          text-transform: uppercase;
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
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Region Wise Quiz Result Report
                    </label>
                </header>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Region:</label>
                                        <div class="col-md-8 col-sm-8">
                                            <select name="region_id" id="region_id"
                                                    class="form-control input-sm m-bot15 region_id">
                                                <option value="">Select Region</option>
                                                <option value="All">All</option>
                                                @foreach($region as $ei)
                                                    <option value="{{$ei->rm_terr_id}}">{{$ei->rm_terr_id}}</option>
                                                @endforeach
                                            </select>                                            
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="col-md-4 col-sm-4 col-xs-4">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Category:</label>--}}
{{--                                        <div class="col-md-8 col-sm-8">                                             --}}
{{--                                            --}}
{{--                                            <select name="sc" id="sc" class="form-control input-sm m-bot15 sc">--}}
{{--                                                <option value="">Select Category</option>--}}
{{--                                                <option value="MPO">MPO</option>--}}
{{--                                                <option value="AM">AM</option>--}}
{{--                                                <option value="RM">RM/ASM</option>--}}
{{--                                                <option value="DSM">DSM</option>--}}
{{--                                              </select>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-md-4 col-sm-4 col-xs-4">--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label class="col-sm-4 col-sm-4 control-label input-sm">Terr Group:</label>--}}
{{--                                        <div class="col-md-8 col-sm-8">                                             --}}
{{--                                            --}}
{{--                                            <select name="terr_grp" id="terr_grp" class="form-control input-sm m-bot15 terr_grp">--}}
{{--                                                <option value="">Select Group</option>--}}
{{--                                               --}}
{{--                                              </select>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label input-sm">From Date:</label>
                                    <div class="col-md-8 col-sm-8">
                                            <div class="input-group date datetimepicker1">
                                                <input type="text" autocomplete="off" class="form-control date_from" name="date_from[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                         
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label input-sm">To Date:</label>
                                    <div class="col-md-8 col-sm-8">
                                            <div class="input-group date datetimepicker2">
                                                <input type="text" autocomplete="off" class="form-control date_to" name="date_to[]">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>                                         
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <button type="button" id="btn_display" class="btn btn-warning btn-sm">
                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                            </div>

                        </div>
                    </div>   

                </div>

            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                        alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive" id="table-content">
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
    {{Html::script('public/site_resource/js/bootstrap-lightbox.min.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/updatedatatablesJS/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/updatedatatablesJS/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/updatedatatablesJS/jszip.min.js')}}
    {{Html::script('public/site_resource/updatedatatablesJS/pdfmake.min.js')}}
    {{Html::script('public/site_resource/updatedatatablesJS/vfs_fonts.js')}}

    {{Html::script('public/site_resource/updatedatatablesJS/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">

        $('.region_id').select2();
        $('.sc').select2();
        $('.terr_grp').select2();


        $('.datetimepicker1').datetimepicker({
            format: 'DD-MM-YY'
        });

        $('.datetimepicker2').datetimepicker({
            format: 'DD-MM-YY'
        });

        var table = null;
        $("#btn_display").click(function () {

            $("#loader").show();
            $('#report-body').hide();
            var region_id = $('#region_id').val();
            var from_date = $('.date_from').val();
            var to_date = $('.date_to').val();
            var data = {
                rm_terr_id: region_id,
                from_date:from_date,
                to_date:to_date,
                "_token": "{{ csrf_token() }}"
            };

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: "{{ url('quiz/getRegionWiseAchievement') }}",
                data : data,
                success: function(data) {
                     //console.log(data);
                     var objectValue = data[0];
                     // console.log(objectValue);
                    $("#loader").hide();
                    $("#report-body").show();
                    var columns = [];
                    columns.push({'title':'SL','data':null});
                    for(var keys in objectValue){
                        if(keys !== '1' && keys !== '2' && keys !== '3' && keys !== '4' && keys !== '5' && keys !== '6'
                            && keys !== '7' && keys !== '8' && keys !== '9' && keys !== '10' && keys !== '11' && keys !== '12'&& keys !== 'p_ach'&& keys !== 't_ach' ){

                            if(keys === 'emp_id'){
                                columns.push({'title':'EMP_ID','data':keys});
                            }else if(keys === 'emp_name'){
                                columns.push({'title':'EMP_NAME','data':keys});
                            }else if(keys === 'emp_desig'){
                                columns.push({'title':'EMP_DESIG','data':keys});
                            }else if(keys === 'terr_id'){
                                columns.push({'title':'TERR_ID','data':keys});
                            }else if(keys === 'p_group'){
                                columns.push({'title':'TEAM','data':keys});
                            }
                            
                            // columns.push({'title':'SEP-20','data':keys});
                        }
                    }
                    for(var keys in objectValue){

                        if(keys !== 'emp_id' && keys !== 'emp_name' && keys !== 'emp_desig' && keys !== 'terr_id'
                            && keys !== 'p_group'&& keys !== 't_ach'&& keys !== 'p_ach' ){

                            if(keys === '1'){
                                columns.push({'title':'JAN','data':keys});
                            }else if(keys === '2'){
                                columns.push({'title':'FEB','data':keys});
                            }else if(keys === '3'){
                                columns.push({'title':'MAR','data':keys});
                            }else if(keys === '4'){
                                columns.push({'title':'APR','data':keys});
                            }else if(keys === '5'){
                                columns.push({'title':'MAY','data':keys});
                            }else if(keys === '6'){
                                columns.push({'title':'JUN','data':keys});
                            }else if(keys === '7'){
                                columns.push({'title':'JUL','data':keys});
                            }else if(keys === '8'){
                                columns.push({'title':'AUG','data':keys});
                            }else if(keys === '9'){
                                columns.push({'title':'SEP','data':keys});
                            }else if(keys === '10'){
                                columns.push({'title':'OCT','data':keys});
                            }else if(keys === '11'){
                                columns.push({'title':'NOV','data':keys});
                            }else if(keys === '12'){
                                columns.push({'title':'DEC','data':keys});
                            }
                        }

                    }
                    for(var keys in objectValue){
                        if(keys === 'p_ach' || keys === 't_ach' ){
                            if(keys === 'p_ach'){
                                columns.push({'title':'P_ACH%','data':keys});
                            }else if(keys === 't_ach'){
                                columns.push({'title':'AVG_ACH%','data':keys});
                            }
                            
                        }
                    }

                    var table_struc = ' <table id="custom-tab" class="table table-striped table-bordered" width="100%"></table>';
                    $('#table-content').empty().append(table_struc);

                        var table = $('#custom-tab').DataTable({
                        data:data,
                        paging: false,
                        columns:columns,
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                exportOptions: { orthogonal: 'export' },
                                title: 'Incepta Pharmaceuticals Ltd.',
                                message: "Region wise Result From: "+from_date+ " To: "+ to_date +" \n"
                            }
                        ],
                        columnDefs: [{
                            "render": function(datax, type, full, meta) {
                                 data[meta.row].id = meta.row + 1; // adds id to dataset
                                 return meta.row + 1; // adds id to serial no
                            },
                            "targets": 0
                        }]

/*                        fnRowCallback : function(nRow, aData, iDisplayIndex){
                            $("td:first", nRow).html(iDisplayIndex +1);
                            return nRow;
                        }*/

                    });

                }
            });

        });
    </script>

@endsection

