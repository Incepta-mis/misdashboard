@extends('_layout_shared._master')
@section('title','Attendance Status Daily')
@section('styles')
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>

        fieldset.scheduler-border {
            border: 2px groove #337AC7 !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        fieldset.scheduler-border2 {
            border: 2px groove orangered !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: #337AC7;
        }

        legend.scheduler-border2 {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
            color: orangered;
        }

        legend {
            /*color: #337AC7;*/
            margin: 0 auto;
            margin-bottom: 10px;
        }

        .swal2-icon.swal2-warning {
            font-size: 14px;
        }

        .swal2-html-container{
            font-size: 1.5em !important;
        }
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;

        }

        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
        }
        .odd{
            background-color: #FFF8FB !important;
        }
        .even{
            background-color: #DDEBF8 !important;
        }
        .select2-container{
            width: 100%!important;
        }
        .select2-search--dropdown .select2-search__field {
            width: 98%;
        }

        .cls-req{
            color: red;
            font-weight: bold;
        }

        .font_color{
            color: #2E2E2E;
            font-weight: bold;
        }

        /* Style for chart */
        #chartdiv{
            height: 800px;

        }
        .audio, canvas, progress, video {
            position: relative !important;
        }

        .element.style {
            position: relative !important;
        }

        #chartdiv > div > div:nth-child(1) > div > canvas:nth-child(2){
            display: none !important;
        }


        #chartdivTwo > div > div:nth-child(1) > div > canvas:nth-child(2){
            display: none !important;
        }


        #am5-tooltip-container> div {
            position: relative;
            width: 91px;
            height: 46px;
            overflow: hidden;
            clip: rect(1px, 1px, 1px, 1px);
            pointer-events: none;
        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Select Employee
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="comp"
                                                   class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px"><b>Company</b></label>

                                            <div class="col-md-8 col-sm-8">
                                                <select id="comp" name="comp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled>Select Company</option>
                                                    @foreach($companyData as $c)
                                                        <option value="{{$c->com_id}}">{{$c->com_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <label for="plant" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="plant" name="plant"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Plant</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Department</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="dept" name="dept"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Department</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row" style="margin-bottom: -50px">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">

                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Section</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="sec" name="sec"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Section</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Work Center</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="wc" name="wc"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Work Center</option>
                                                    {{--  @foreach($workCenter as $wc)
                                                          <option value="{{$wc->work_center_id}}">{{$wc->work_center_id}}-{{$wc->work_center_name}}</option>
                                                      @endforeach--}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <label for="dept" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Emp Type</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="type" name="type"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Emp Type</option>
                                                    {{-- @foreach($empType as $empTypes)
                                                         <option value="{{$empTypes->emp_type}}">{{$empTypes->emp_type}}</option>
                                                     @endforeach--}}
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">

                                        <div class="col-md-4 col-sm-4">
                                            <label for="emp" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Employee</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="emp" name="emp" class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Employee</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-4">
                                            <label class="col-md-4 col-sm-4 control-label fnt_size" for="date_from">
                                                <b>Date</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" id="date_from" class="form-control input-sm">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <label for="emp" class="col-md-4 col-sm-4 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Absent/Late In</b></label>
                                            <div class="col-md-8 col-sm-8">
                                                <select id="abs" name="abs" class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select (Absent/Late In)</option>
                                                    <option value="absent">Absent</option>
                                                    <option value="lateIn">Late In</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="text-align: center">

                                <div class="col-md-12 col-sm-12">
                                    <button type="button" id="btn_submit" class="btn btn-warning btn-sm" style="width: 120px  !important" disabled="disabled">
                                        <i class="fa fa-chevron-circle-up"></i> <b>Display</b></button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
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

    <div class="div" style="padding: 15px;text-align: center">
        <div class="row">
            <div class="col-md-2 font_color" style="background-color: #8FBE69;font-weight: bold">
                <p>Start to End Time </p>
            </div>
            <div class="col-md-2 font_color" style="background-color: #F48A9F;font-weight: bold">
                <p>Snacks Time </p>
            </div>
            <div class="col-md-2 font_color" style="background-color: #ECE77E;font-weight: bold">
                <p>Lunch Time </p>

            </div>
            <div class="col-md-2 font_color" style="background-color: #D473E8;font-weight: bold">
                <p>Over Time </p>
            </div>
            <div class="col-md-2" style="background-color: #2E2EFE;font-weight: bold;color: #151515">
                <p>Late In</p>
            </div>
            <div class="col-md-2" style="background-color: #7401DF;font-weight: bold;color: #1C1C1C">
                <p>Early Out</p>
            </div>
        </div>
        <div class="row"  style="margin-top: 10px">
            <div class="col-md-3 font_color" style="background-color: #EA9D3A;font-weight: bold">
                <p>Out Station Duty </p>
            </div>
            <div class="col-md-2 font_color" style="background-color: #AEF05F;font-weight: bold">
                <p>LEAVE </p>
            </div>
            <div class="col-md-2 font_color" style="background-color: #3AC2EA;font-weight: bold">
                <p>HOLIDAY </p>
            </div>
            <div class="col-md-2 font_color" style="background-color: #DC3E28;font-weight: bold">
                <p>ABSENT</p>
            </div>

            <div class="col-md-3 font_color" style="background-color:#e9967a;font-weight: bold">
                <p>Absent But Informed</p>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 7px">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Attendance Summary
                    </label>
                </header>
                <div  id="chartdiv" style="position: relative !important"></div>
                <div  id="chartdivTwo"  style="height: 2000px;position: relative !important"></div>

            </section>
        </div>
    </div>

@endsection

@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
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
    {{Html::script('public/site_resource/js/salert/sweetalert2@11.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


    <!-- Resources for chart-->
    <script src="//cdn.amcharts.com/lib/5/themes/Responsive.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/locales/de_DE.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/germanyLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/fonts/notosans-sc.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#comp').select2();
            $('#plant').select2();
            $('#dept').select2();
            $('#emp').select2();
            $('#sec').select2();
            $('#type').select2();
            $('#wc').select2();
            $('#abs').select2();

            var date = new Date();
            var pdate = date.setDate(date.getDate()-1);

            $('#date_from').datetimepicker({
                defaultDate: pdate,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });
            $('#date_to').datetimepicker({
                defaultDate: pdate,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });

            //Changing company from option
            $('#comp').change(function () {

                $('#plant').empty();
                $('#dept').empty();
                $('#emp').empty();
                $('#sec').empty();
                $('#type').empty();
                $('#wc').empty();
                $('#plant').append($('<option></option>').html('Loading...'));

                var comp_id = $('#comp').val();
                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getPlants') }}',
                    data: {'c_id': comp_id},
                    success: function (data) {
                        if(data.plant.length > 0){
                            var op = '';
                            op += '<option value="0" selected disabled>Select Plant</option>';
                            for (var i = 0; i < data.plant.length; i++) {
                                op += '<option value="' + data.plant[i]['plant_id'] + '">' + data.plant[i]['plant_name'] +data.plant[i]['plant_id'] + '</option>';
                            }
                            $('#plant').html("");
                            $('#plant').append(op);

                            $("#btn_submit").prop('disabled', true);


                        }else{
                            $('#plant').html("");
                            $('#plant').append('<option value="0" selected disabled>No plant available here </option>');
                        }
                    },
                    error: function () {

                    }
                });
            });

            // Changing plant option started here
            $('#plant').change(function () {


                $('#dept').empty();
                $('#emp').empty();
                $('#sec').empty();
                $('#type').empty();
                $('#wc').empty();
                $('#dept').append($('<option></option>').html('Loading...'));


                var plant_id = $('#plant').val();

                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getDepts') }}',
                    data: {'plant_id': plant_id},
                    success: function (data) {

                        if ((data.dept.length) > 0) {
                            var op = '';
                            op += '<option value="0" selected disabled>Select Department</option>';
                            for (var i = 0; i < data.dept.length; i++) {
                                op += '<option value= " ' + data.dept[i]['dept_id'] + ' ">' + data.dept[i]['dept_name'] + '</option>';
                            }

                            $('#dept').html("");
                            $('#dept').append(op);
                            $("#btn_submit").prop('disabled', true);

                        }
                        else {
                            $('#dept').html("");
                            $('#dept').append('<option value="0" selected disabled>No dept under this plant</option>');

                        }
                    },
                    error: function () {
                    }
                });
            });

            // Changing Dept option started here
            $('#dept').change(function () {

                $('#sec').empty();
                $('#wc').empty();
                $('#type').empty();
                $('#emp').empty();

                $('#sec').empty().append($('<option></option>').html('Loading...'));
                var dept_id = $('#dept').val();


                if (dept_id =='ALL'){

                    $("#sec").empty().append("<option value='ALL'>ALL</option>");

                }
                else{

                    $.ajax({
                        type: 'get',
                        url: '{{  url('attendenceManagementSys/attendence/getSections') }}',
                        data: {'dept_id': dept_id},
                        success: function (data) {
                            var section = data.sections;

                            if ((section.length) > 0) {

                                var em = '';
                                em += '<option value="0" selected disabled>Select Section</option>';
                                em += '<option value="ALL">ALL</option>';
                                for (var i = 0; i < section.length; i++) {
                                    em += '<option value= " ' + section[i]['section_id'] + ' ">' + section[i]['section_name'] + section[i]['section_id']+'</option>';
                                }


                                $('#sec').html("");
                                $('#sec').append(em);
                                $("#btn_submit").prop('disabled', true);
                            }

                            else {
                                $('#sec').html("");
                                $('#sec').append('<option value="0" selected disabled>No Section is available</option>')
                            }
                        },
                        error: function () {
                        }
                    });

                }



            });

            // Changing Dept option started here
            $('#sec').change(function () {


                $('#wc').empty();
                $('#type').empty();
                $('#emp').empty();

                $('#wc').empty().append($('<option></option>').html('Loading...'));

                var sec_id = $('#sec').val();
                var plant_id = $('#plant').val();
                var dept_id = $('#dept').val();


                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getWorkCenters') }}',
                    data: {'sec_id': sec_id,'plant_id': plant_id,'dept_id': dept_id},
                    success: function (data) {

                        var workc = data.workCenter;

                        if ((workc.length) > 0) {

                            var wc = '';
                            wc += '<option value="0" selected disabled>Select Work Center</option>';
                            wc += '<option value="ALL">ALL</option>';
                            for (var i = 0; i < workc.length; i++) {
                                wc += '<option value= " ' + workc[i]['work_center_id'] + ' ">' + workc[i]['work_center_id'] + '-' + workc[i]['work_center_name'] + '</option>';
                            }

                            $('#wc').html("");
                            $('#wc').append(wc);
                            $("#btn_submit").prop('disabled', true);
                        }
                        else {

                            $('#wc').html("");
                            $('#wc').append('<option value="0" selected disabled>No Work Center available in this Section</option>');

                        }
                    },
                    error: function () {
                    }



                });
            });

            // Changing Dept option started here
            $('#wc').change(function () {

                $('#type').empty();
                $('#emp').empty();


                $('#type').empty().append($('<option></option>').html('Loading...'));

                var wc_id = $('#wc').val();
                var sec_id = $('#sec').val();
                var dept_id = $('#dept').val();



                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getEmpType') }}',
                    data: {'wc_id': wc_id,
                        'sec_id': sec_id,
                        'dept_id': dept_id,

                    },
                    success: function (data) {

                        var emp_type= data.emp_type;

                        if ((emp_type.length) > 0) {
                            var type = '';
                            type += '<option value="0" selected disabled>Select Emp Type</option>';
                            type += '<option value="ALL">All</option>';
                            for (var i = 0; i < emp_type.length; i++) {
                                type += '<option value= " ' + emp_type[i]['emp_type'] + ' ">' + emp_type[i]['emp_type'] + '</option>';
                            }

                            $('#type').html("");
                            $('#type').append(type);
                            $("#btn_submit").prop('disabled', true);

                        }
                        else {

                            $('#type').html("");
                            $('#type').append('<option value="0" selected disabled>No Type Available</option>');

                        }
                    },
                    error: function () {
                    }
                });
            });


            // Changing Dept option started here
            $('#type').change(function () {

                $('#emp').empty();

                $('#emp').empty().append($('<option></option>').html('Loading...'));
                var type = $('#type').val();

                var wc_id = $('#wc').val();
                var sec_id = $('#sec').val();
                var dept_id = $('#dept').val();
                var type = $('#type').val();



                $.ajax({
                    type: 'get',
                    url: '{{  url('attendenceManagementSys/attendence/getEmployee') }}',
                    data: {
                        'type': type,
                        'wc_id': wc_id,
                        'sec_id': sec_id,
                        'dept_id': dept_id,
                    },
                    success: function (data) {

                        var emp_info= data.emp;

                        if ((emp_info.length) > 0) {

                            var emp = '';
                            emp += '<option value="0" selected disabled>Select Emp</option>';
                            emp += '<option value="ALL">ALL</option>';
                            for (var i = 0; i < emp_info.length; i++) {
                                emp += '<option value= " ' + emp_info[i]['emp_id'] + ' ">'+ emp_info[i]['emp_id'] +'-'+ emp_info[i]['sur_name'] + '</option>';
                            }


                            $('#emp').html("");
                            $('#emp').append(emp);
                            $("#btn_submit").prop('disabled', true);

                        }
                        else {

                            $('#emp').html("");
                            $('#emp').append(em);


                        }
                    },
                    error: function () {
                    }
                });
            });


            $('#emp').change(function () {

                $('#btn_submit').removeAttr("disabled");

            });


            /*
            * or nor either nor neither nor not only but also
            *
            * */

            $("#loader").show();
            var rootTwo;
            am5.ready(function() {

                // Create root element
                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                rootTwo = am5.Root.new("chartdivTwo")
            });


            /* main chart */

            $.ajax({

                type: 'get',
                url: '{{  url('attendenceManagementSys/attendence/getAlldata') }}',

                success: function (result) {

                    data = JSON.parse(result.allEmpJson);
                    empName = JSON.parse(result.allEmpNameJson);

                    $("#loader").hide();

                    am5.ready(function () {

                        // Create root element
                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                        var root = am5.Root.new("chartdiv");
                        root.dateFormatter.setAll({
                            dateFormat: "yyyy-MM-dd",
                            dateFields: ["valueX", "openValueX"]
                        });


                        // Set themes
                        // https://www.amcharts.com/docs/v5/concepts/themes/
                        root.setThemes([
                            am5themes_Animated.new(root)
                        ]);

                        // Create chart
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                        var chart = root.container.children.push(am5xy.XYChart.new(root, {
                            panX: false,
                            panY: false,
                            /*  wheelX: "panX",
                              wheelY: "zoomX",*/
                            layout: root.verticalLayout
                        }));

                        // Add legend
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                        var legend = chart.children.push(am5.Legend.new(root, {
                            centerX: am5.p90,
                            x: am5.p90
                        }))


                        // Create axes
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                        var yAxis = chart.yAxes.push(
                            am5xy.CategoryAxis.new(root, {
                                categoryField: "category",
                                renderer: am5xy.AxisRendererY.new(root, {inversed: true}),
                                tooltip: am5.Tooltip.new(root, {
                                    themeTags: ["axis"],
                                    animationDuration: 200
                                })
                            })
                        );

                        yAxis.data.setAll(empName);

                        var xAxis = chart.xAxes.push(
                            am5xy.DateAxis.new(root, {

                                baseInterval: {timeUnit: "minute", count: 1},
                                gridIntervals: [
                                    {timeUnit: "hour", count: 1},
                                    {timeUnit: "minute", count: 60}
                                ],
                                renderer: am5xy.AxisRendererX.new(root, {strokeOpacity: 0.1, opposite: true})
                            })
                        );

                        // Add series
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                            xAxis: xAxis,
                            yAxis: yAxis,
                            openValueXField: "fromDate",
                            valueXField: "toDate",
                            categoryYField: "category",
                            sequencedInterpolation: true
                        }));

                        series.columns.template.setAll({
                            templateField: "columnSettings",
                            strokeOpacity: 0.4,
                            tooltipText: "{category}: {openValueX.formatDate('yyyy-MM-dd HH:mm')} - {valueX.formatDate('yyyy-MM-dd HH:mm')}"
                        });


                        series.data.processor = am5.DataProcessor.new(root, {
                            dateFields: ["fromDate", "toDate"],
                            dateFormat: "yyyy-MM-dd HH:mm"
                        });

                        series.data.setAll(data);


                        // Make stuff animate on load
                        // https://www.amcharts.com/docs/v5/concepts/animations/
                        series.appear();
                        chart.appear(1000, 100);

                    });

                },
                error: function (e) {

                    $("#loader").hide();
                    $("#showTable").show();
                }
            });

            var myChart;

            //filter
            $('#btn_submit').on('click', function (e) {

                var plant_id =   $('#plant').val();
                var dept_id =   $('#dept').val();
                var sec_id =   $('#sec').val();
                var wc_id =   $('#wc').val();
                var type_id =   $('#type').val();
                var emp_id =   $('#emp').val();
                var abs =   $('#abs').val();

                var date_from =   $('#date_from').val();
                var date_to =   $('#date_to').val();

                if(plant_id == "" ||dept_id == "" ||sec_id == "" ||wc_id == "" ||type_id == "" ||emp_id == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please choose all required data!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })

                }else{
                    $("#loader").show();
                    var table = null;

                    $.ajax({
                        type: 'post',
                        url: '{{  url('attendenceManagementSys/attendence/getDataDeptWise') }}',
                        data: {
                            'plant_id':plant_id,
                            'dept_id':dept_id,
                            'sec_id':sec_id,
                            'wc_id':wc_id,
                            'type_id':type_id,
                            'emp_id':emp_id,
                            'date_from':date_from,
                            'date_to':date_to,
                            'type_id':type_id,
                            'abs':abs,
                            '_token': "{{ csrf_token() }}" },

                        success: function (result) {
                            console.log(result)

                            rootTwo.container.children.clear();

                            $("#loader").hide();

                            $('#chartdiv').css('display','none');


                            data = JSON.parse(result.allEmpDataJson);
                            empName = JSON.parse(result.allEmpNameJson);

                            myChart =   am5.ready(function() {
                                // Set cell size in pixels

                                // Create root element
                                // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                                rootTwo.dateFormatter.setAll({
                                    dateFormat: "yyyy-MM-dd",
                                    dateFields: ["valueX", "openValueX"]
                                });

                                // Set themes
                                // https://www.amcharts.com/docs/v5/concepts/themes/
                                rootTwo.setThemes([
                                    am5themes_Animated.new(rootTwo)
                                ]);

                                // Create chart
                                // https://www.amcharts.com/docs/v5/charts/xy-chart/
                                var chart = rootTwo.container.children.push(am5xy.XYChart.new(rootTwo, {
                                    panX: false,
                                    panY: false,
                                    /*  wheelX: "panX",
                                      wheelY: "zoomX",*/
                                    layout: rootTwo.verticalLayout
                                }));


                                // Add legend
                                // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                                var legend = chart.children.push(am5.Legend.new(rootTwo, {
                                    centerX: am5.p90,
                                    x: am5.p90
                                }));


                                // Create axes
                                // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                                var yAxis = chart.yAxes.push(
                                    am5xy.CategoryAxis.new(rootTwo, {
                                        categoryField: "category",
                                        renderer: am5xy.AxisRendererY.new(rootTwo, { inversed: true }),
                                        tooltip: am5.Tooltip.new(rootTwo, {
                                            themeTags: ["axis"],
                                            animationDuration: 200
                                        })
                                    })
                                );

                                yAxis.data.setAll(empName);
                                var xAxis = chart.xAxes.push(
                                    am5xy.DateAxis.new(rootTwo, {

                                        baseInterval: { timeUnit: "minute", count: 1 },
                                        gridIntervals: [
                                            { timeUnit: "hour", count: 1 },
                                            { timeUnit: "minute", count: 60 }
                                        ],

                                        renderer: am5xy.AxisRendererX.new(rootTwo, {strokeOpacity: 0.1,opposite:true})
                                    })
                                );

                                // Add series
                                // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                                var series = chart.series.push(am5xy.ColumnSeries.new(rootTwo, {
                                    xAxis: xAxis,
                                    yAxis: yAxis,
                                    openValueXField: "fromDate",
                                    valueXField: "toDate",
                                    categoryYField: "category",
                                    sequencedInterpolation: true
                                }));

                                series.columns.template.setAll({
                                    templateField: "columnSettings",
                                    strokeOpacity: 0,
                                    tooltipText: "{category}: {openValueX.formatDate('yyyy-MM-dd HH:mm')} - {valueX.formatDate('yyyy-MM-dd HH:mm')}"
                                });

                                series.data.processor = am5.DataProcessor.new(rootTwo, {
                                    dateFields: ["fromDate", "toDate"],
                                    dateFormat: "yyyy-MM-dd HH:mm"
                                });

                                var cellSize = 20;
                                series.events.on("datavalidated", function(ev) {

                                    var series = ev.target;
                                    var chart = series.chart;
                                    var xAxis = chart.xAxes.getIndex(0);

                                    // Calculate how we need to adjust chart height
                                    var chartHeight = series.data.length * cellSize + xAxis.height() + chart.get("paddingTop", 0) + chart.get("paddingBottom", 0);

                                    // Set it on chart's container
                                    chart.root.dom.style.height = chartHeight + "px";

                                });

                                series.data.setAll(data);

                                // Make stuff animate on load
                                // https://www.amcharts.com/docs/v5/concepts/animations/
                                series.appear();
                                chart.appear(1000, 100);
                            });
                        },
                        error: function (e) {
                            $("#loader").hide();
                            $("#showTable").show();
                        }
                    });
                }
            });

        });

    </script>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection