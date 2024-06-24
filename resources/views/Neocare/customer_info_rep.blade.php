@extends('_layout_shared._master')
@section('title','Customer Information Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Customer Information Report
                    </label>
                </header>
                <div class="panel-body">
                    <form action="" id="ciform">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-2 text-center"><label class="control-label"
                                                                         for="terr_id">
                                        <b>RM TERR ID:</b></label>
                                </div>
                                <div class="col-md-2">
                                    @if(Auth::user()->desig == 'AM' || Auth::user()->desig == 'Sr. AM' ||Auth::user()->desig == 'TSO' || Auth::user()->desig == 'Sr. TSO' )
                                        <select name="rm_terr_id" id="rm_terr_id" class="form-control input-sm"
                                                readonly="">
                                            @foreach($rm_terr as $tr)
                                                <option value="{{$tr->rm_terr_id}}">{{$tr->rm_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="rm_terr_id" id="rm_terr_id" class="form-control input-sm" readonly="">

                                            {{--                                        @if(Auth::user()->desig == 'HO')--}}
                                            {{--                                            <option value="all">ALL</option>--}}
                                            {{--                                        @endif--}}
                                            @foreach($rm_terr as $tr)
                                                <option value="{{$tr->rm_terr_id}}">{{$tr->rm_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                </div>
                                <div class="col-md-2 text-center"><label class="control-label"
                                                                         for="terr_id">
                                        <b>AM TERR ID:</b></label>
                                </div>
                                <div class="col-md-2">
                                    @if(Auth::user()->desig == 'AM' || Auth::user()->desig == 'Sr. AM' ||Auth::user()->desig == 'TSO' || Auth::user()->desig == 'Sr. TSO')
                                        <select name="am_terr_id" id="am_terr_id" class="form-control input-sm"
                                                readonly="">
                                            @foreach($am_terr as $tr)
                                                <option value="{{$tr->am_terr_id}}">{{$tr->am_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="am_terr_id" id="am_terr_id" class="form-control input-sm">
                                            {{--                                        @if(Auth::user()->desig == 'HO')--}}
                                            {{--                                            <option value="all">ALL</option>--}}
                                            {{--                                        @endif--}}
                                            <option value="" disabled selected>SELECT TERR_ID</option>

                                            @foreach($am_terr as $tr)
                                                <option value="{{$tr->am_terr_id}}">{{$tr->am_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                </div>
                                <div class="col-md-2 text-center"><label class="control-label"
                                                                         for="terr_id">
                                        <b>MPO TERR ID:</b></label>
                                </div>
                                <div class="col-md-2">
                                    @if(Auth::user()->desig == 'TSO' || Auth::user()->desig == 'Sr. TSO')
                                        <select name="terr_id" id="terr_id" class="form-control input-sm" readonly="">
                                            @foreach($mpo_terr as $tr)
                                                <option value="{{$tr->mpo_emp_id}}">{{$tr->mpo_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="terr_id" id="terr_id" class="form-control input-sm">
{{--                                                                                    @if(Auth::user()->desig == 'HO')--}}
{{--                                                                                        <option value="all">ALL</option>--}}
{{--                                                                                    @endif--}}
                                            <option value="" disabled selected>SELECT TERR_ID</option>
                                            @foreach($mpo_terr as $tr)

                                                <option value="{{$tr->mpo_emp_id}}">{{$tr->mpo_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 text-center"><label class="control-label " for="date_from">
                                        <b>Date From:</b></label></div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group">
                                        <input type="text" id="date_from" name="datefrom"
                                               class="form-control input-sm">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center"><label class="control-label "
                                                                         for="date_to">
                                        <b>Date To:</b></label></div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group">
                                        <input type="text" id="date_to" name="dateto" class="form-control input-sm">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Display</b></button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>

            </section>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}" width="35px" height="35px"
                     alt="Loading Report Please wait..."><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>
    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body table-responsive">
                        <table id="ci_tab" class="table table-condensed table-striped table-bordered"
                               width="100%">
                            <thead style="white-space:nowrap;">
                            <tr>
                                <th>MPO_TERR_ID</th>
                                <th>USER_ID</th>
                                <th>EMPLOYEE_NAME</th>
                                <th>PARENTS_NAME</th>
                                <th>BABY_NAME</th>
                                <th>AGE</th>
                                <th>SAMPLE_SIZE</th>
                                <th>CONTACT_NO</th>
                                <th>EMAIL</th>

                            </tr>
                            </thead>
                            <tbody style="white-space:nowrap;"></tbody>
                            <tfoot>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            </tfoot>
                        </table>
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

    <script>
        var date = new Date();
        var usr = '{{Auth::user()->desig}}';
        var pdate = date.setDate(date.getDate() - 1);
        $('#date_from,#date_to').datetimepicker({
            defaultDate: pdate,
            format: 'DD/MM/YYYY',
            showTodayButton: true,
            showClose: true,
            showClear: true
        });
        var url_report_amterr = '{{url('nc/getamid')}}';

        var url_report_mpoterr = '{{url('nc/getmpoid')}}';


        var url_report_output = '{{url('nc/getreportdata')}}';
        $(document).ready(function () {
            var sadun = function () {
                console.log('rm_terr_id changed');
                $.ajax({
                    method: "POST",
                    url: url_report_amterr,
                    data: {
                        _token: '{{csrf_token()}}',
                        rm_terr: $('#rm_terr_id').val()
                    },
                    beforeSend: function () {

                    },
                    success: function (data) {
                        console.log(data);
                        var am_terr = '<option value="" disabled selected>SELECT TERR_ID</option><option value="all" >ALL</option>';
                        for (var i = 0; i < data.length; i++) {
                            am_terr += '<option value="' + data[i].am_terr_id + '">' + data[i].am_terr_id + '</option>';
                        }
                        $('#am_terr_id').empty().append(am_terr);

                    },
                    error: function () {

                    },
                    complete: function () {

                    }
                })
            };
            
            if(usr !== 'TSO' && usr !== 'Sr. TSO'){
               sadun();
            }

            $("#rm_terr_id").change(function () {
                console.log('rm_terr_id changed');

                var am_terr = '<option value="" disabled selected>LOADING...</option>';
                $('#am_terr_id').empty().append(am_terr);
                sadun();
            });
            var sadun1 = function () {
                console.log('am_terr_id changed');
                $.ajax({
                    method: "POST",
                    url: url_report_mpoterr,
                    data: {
                        _token: '{{csrf_token()}}',
                        am_terr: $(am_terr_id).val()
                    },
                    beforeSend: function () {

                    },
                    success: function (data) {
                        console.log(data);
                        var mpo_terr = '<option value="" disabled selected>SELECT TERR_ID</option><option value="all" >ALL</option>';
                        for (var i = 0; i < data.length; i++) {
                            mpo_terr += '<option value="' + data[i].mpo_emp_id + '">' + data[i].mpo_terr_id + '(' + data[i].mpo_emp_id + ')</option>';
                        }
                        $('#terr_id').empty().append(mpo_terr);

                    },
                    error: function () {

                    },
                    complete: function () {

                    }
                })
            };
            // sadun1();
            $("#am_terr_id").change(function () {
                var mpo_terr = '<option value="" disabled selected>LOADING...</option>';
                $('#terr_id').empty().append(mpo_terr);
                sadun1();
            });

            $("#btn_display").click(function () {
                console.log($("#ciform").serialize());
                $("#report-body").hide();
                $.ajax({
                    method: "POST",
                    url: url_report_output,
                    data: {
                        _token: '{{csrf_token()}}',
                        formdata: $("#ciform").serialize()
                    },
                    beforeSend: function () {
                        $("#loader").show();
                    },
                    success: function (data) {
                        console.log(data);
                        $('#ci_tab').dataTable().fnDestroy();
                        var table = $('#ci_tab').dataTable({
                            data: data,
                            // "scrollY": 300,
                            // "scrollX": true,
                            "paging": true,


                            columns: [
                                // {data: "sales_area_code", className: 'wd'},
                                {data: "terr_id", className: 'day'},
                                {data: "user_id", className: 'day'},
                                {data: "name", className: 'day'},
                                {data: "pname", className: 'day'},
                                {data: "baby_name", className: 'wds'},
                                {data: "age", className: 'wday'},
                                {data: "sample_size", className: 'twd'},
                                {data: "contact_no", className: 'wd'},
                                {data: "email", className: 'day'}],

                            // "bLengthChange": true,

                            dom: 'Bfrtip',
                            buttons: [
                                'excelHtml5',
                            ]
                        });
                        $("#report-body").show();
                    },
                    error: function () {

                    },
                    complete: function () {
                        $("#loader").hide();
                    }
                })


            });

        })
    </script>
@endsection
