@extends('_layout_shared._master')
@section('title','SURVEY SMS')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
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
    <section class="panel">
        <header class="panel-heading custom-tab ">
            <ul class="nav nav-tabs">
                <li class="active" style="text-transform: none;">
                    <a href="#send_sms" data-toggle="tab"><i class="fa fa-envelope"></i> Send Sms To Customer</a>
                </li>
                <li class="" style="text-transform: none;">
                    <a href="#create_grp" data-toggle="tab"> <i class="fa fa-users"></i> Create Group</a>
                </li>
            </ul>
        </header>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane active" id="send_sms">
                    <div class="">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <div class="panel-body table-responsive">
                                    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12">
                                        <div class="alert alert-dismissable" id="alert" style="display: none;">
                                            <a href="#" class="close" data-dismiss="alert"
                                               aria-label="close">&times;</a>
                                            <p id="message">
                                                <i class="fa fa-check-circle"></i>
                                                <b><span id="message_text"></span></b>
                                            </p>
                                            <p id="loader">
                                                <i class="fa fa-spinner fa-spin"></i> <b>Sending SMS.don't close the
                                                    browser tab.....</b>
                                            </p>
                                        </div>
                                        <div class="alert alert-info fade in text-center">
                                            <label class="radio-inline">
                                                <input type="radio" name="smstype" value="M" checked>Group SMS
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="smstype" value="S">Single
                                                SMS
                                            </label>
                                            <br>
                                            <strong>N.B. Choose send type by selecting the radio button.</strong>
                                        </div>
                                        <div class="form-group" id="s_group">
                                            <label for="sgroup">SELECT GROUP</label>
                                            <select name="s_group" id="group_list"
                                                    class="form-control input-sm" placeholder="Enter name">
                                            </select>
                                        </div>

                                        <div class="form-group" style="display: none;" id="s_numb">
                                            <label for="sgroup">Enter Numbers</label>
                                            <input type="text" class="form-control" id="numbers"
                                                   placeholder="e.g: 017XXXXXXXX,017XXXXXXXX">
                                            <p class="text-warning">
                                                <b>Multiple number must be seperated by comma(,)</b>
                                            </p>
                                        </div>

                                        <div class="form-group">
                                            <label for="message" class="control-label" rows="9">SMS BODY</label>
                                            <textarea type="text" id="sms_text_mess" class="form-control" name="message"
                                                      rows="9">Dear parents, we are eagerly waiting to know your feedback about our NeoCare baby diaper. Please take a moment to do a small survey so that we can provide the best quality to you. http://web.inceptapharma.com:5031/misdashboard/survey
                                        </textarea>

                                        </div>
                                        <button type="button" class="btn btn-success btn-sm" id="btnSendSms">
                                            <span><i class="fa fa-envelope-o"></i> Send Sms</span>
                                        </button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="create_grp">
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
                                        <select name="rm_terr_id" id="rm_terr_id" class="form-control input-sm"
                                                readonly="">
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
                                <div class="col-md-2 text-center"><label class="control-label "
                                                                         for="date_to">
                                        <b>Age From:</b></label></div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="text" id="from" name="from" size="4" value="2">
                                        <b> To: </b>
                                        <input type="text" size="4" id="to" name="to" value="4">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 text-center">
                                    <label class="control-label " for="size">
                                        <b>Size:</b>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <select name="size" id="size" class="form-control input-sm">
                                        <option value="" disabled>SELECT SIZE</option>
                                        @foreach($sample as $sm)
                                            <option value="{{$sm->size1}}"
                                                    @if($sm->size1 == 'MEDIUM') selected @endif>{{$sm->size1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Display List</b></button>
                                </div>
                            </div>
                        </div>

                    </form>
                    <hr>
                    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
                        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center alert alert-info">
                                <img src="{{url('public/site_resource/images/profile-load.svg')}}" width="35px"
                                     height="35px"
                                     alt="Loading Report Please wait...">
                                <span ><b><i>Please wait...</i></b></span>
                        </div>
                    </div>
                    <div class="row" id="report-body">
                        <div class="">
                            <div class="col-sm-12 col-md-12">
                                <section class="panel" id="data_table">
                                    <div class="panel-body table-responsive">
                                        <table id="final_tab" class="table table-condensed table-striped table-bordered"
                                               width="100%">
                                            <thead style="white-space:nowrap;">
                                            <tr>
                                                <th></th>
                                                <th>MPO_TERR_ID</th>
                                                <th>USER_ID</th>
                                                <th>EMPLOYEE_NAME</th>
                                                <th>PARENTS_NAME</th>
                                                <th>BABY_NAME</th>
                                                <th>AGE</th>
                                                <th>SAMPLE_SIZE</th>
                                                <th>CONTACT_NO</th>
                                            </tr>
                                            </thead>
                                            <tbody style="white-space:nowrap;"></tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Customer Survey Data</h4>
                </div>
                <div class="modal-body">

                    <table id="ci_tab" class="table table-condensed table-striped table-bordered"
                           width="100%">
                        <thead style="white-space:nowrap;">
                        <tr>
                            <th></th>
                            <th>MPO_TERR_ID</th>
                            <th>USER_ID</th>
                            <th>EMPLOYEE_NAME</th>
                            <th>PARENTS_NAME</th>
                            <th>BABY_NAME</th>
                            <th>AGE</th>
                            <th>SAMPLE_SIZE</th>
                            <th>CONTACT_NO</th>
                        </tr>
                        </thead>
                        <tbody style="white-space:nowrap;"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                </div>
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
    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/select2/select2.min.js')}}

    <script>

        var url_report_amterr = '{{url('nc/getamid')}}';
        var url_report_mpoterr = '{{url('nc/getmpoid')}}';
        var url_report_output = '{{url('nc/reportview1')}}';

        $(document).ready(function () {

            var date = new Date();
            var pdate = date.setDate(date.getDate() - 1);

            var table = null;
            var table2 = null;
            var s_rows = [];
            var r_rows = [];
            var groupRowsLimit = 350;
            var timer = null;
            var duration = 20000;

            //initialize datepicker
            $('#date_from,#date_to').datetimepicker({
                defaultDate: pdate,
                format: 'DD/MM/YYYY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });

            //initialize dropdownlist for group selection
            function rowFormat(data) {
                return $('<span><i class="fa fa-users"></i> ' + data.text + '</span>');
            }

            $('#group_list').select2({
                placeholder: '   Select Groups From List',
                minimumResultsForSearch: -1,
                multiple: true,
                allowClear: true,
                maximumSelectionLength: 4,
                templateSelection: rowFormat,
                templateResult: rowFormat,
                ajax: {
                    url: '{{url('nc/getGroupList')}}'
                }
            });

            //select smstype
            $('input:radio').change(function () {
                 //console.log($(this).val());
                 if($(this).val() === 'M'){
                     $('#s_group').show();
                     $('#s_numb').hide();
                 }else{
                     $('#s_group').hide();
                     $('#s_numb').show();
                 }
            });

            //console.log($('input[name="smstype"]:checked').val());

            var sadun = function () {
                // console.log('rm_terr_id changed');
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
                        // console.log(data);
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
            sadun();

            $("#rm_terr_id").change(function () {
                // console.log('rm_terr_id changed');

                var am_terr = '<option value="" disabled selected>LOADING...</option>';
                $('#am_terr_id').empty().append(am_terr);
                sadun();
            });

            var sadun1 = function () {
                // console.log('am_terr_id changed');
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
                        // console.log(data);
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

            table = $('#ci_tab').DataTable({
                data: [],
                dom: 'Bftrip',
                paging: true,
				pageLength: 50,
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                columns: [
                    {
                        orderable: false,
                        data: null,
                        targets: 0,
                        defaultContent: '',
                        className: 'select-checkbox'
                    },
                    {data: "terr_id", className: 'day'},
                    {data: "user_id", className: 'day'},
                    {data: "name", className: 'day'},
                    {data: "pname", className: 'day'},
                    {data: "baby_name", className: 'wds'},
                    {data: "age", className: 'wday'},
                    {data: "sample_size", className: 'twd'},
                    {data: "contact_no", className: 'wd'},
                    // {data: "email", className: 'day'}
                ],
                buttons: [
                    {
                        text: 'Add',
                        className: 'btn btn-info btn-sm',
                        action: function () {
                            if (table2.rows().data().length <= groupRowsLimit) {
                                var rows_selected = table.rows({selected: true}).data();
                                if (rows_selected.length > 0) {
                                    console.log(table2.rows().data().length);
                                    if (table2.rows().data().length > 0) {
                                        console.log(groupRowsLimit - table2.rows().data().length);
                                        if (rows_selected.length < (groupRowsLimit - table2.rows().data().length)) {
                                            //var status = true;
                                            var table2data = table2.rows().data();
                                            console.log(table2data);
                                            for (var i = 0; i < rows_selected.length; i++) {

                                                var status = true;
                                                for (var j = 0; j < table2.rows().data().length; j++) {
                                                    if (rows_selected[i].contact_no === table2.rows().data()[j].contact_no
                                                    ) {
                                                        status = false;
                                                        break;
                                                    }
                                                }
                                                if (status) {
                                                    table2data.push(rows_selected[i]);
                                                }
                                            }
                                            table2.clear();
                                            table2.rows.add(table2data);
                                        } else {
                                            alert('Total records allowed for a group is ' + groupRowsLimit);
                                        }
                                    } else {
                                        if (rows_selected.length < groupRowsLimit) {
                                            table2.rows.add(rows_selected);
                                        } else {
                                            alert('Total records allowed for a group is ' + groupRowsLimit);
                                        }
                                    }
                                    table2.draw();
                                } else {
                                    alert('Please select rows to add');
                                }
                            } else {
                                alert('Total records allowed for a group is ' + groupRowsLimit);
                            }
                        }
                    }, {
                        text: 'Select All',
                        className: 'btn-sm',
                        action: function () {
                            table.rows().select();
                        }
                    },
                    {
                        text: 'Select All (Current Page)',
                        className:'btn-sm',
                        action:function(){
                            table.rows({page:'current'}).select();
                            // var p = table.rows({page:'current'}).select();
                            // console.log(p);
                        } 
                    },
                    {
                        text: 'Deselect',
                        className: 'btn-sm',
                        action: function () {
                            table.rows().deselect();
                        }
                    }
                ]
            });

            table2 = $('#final_tab').DataTable({
                data: s_rows,
                dom: 'Bftrip',
                "paging": true,
				pageLength: 50,
                columns: [
                    {
                        orderable: false,
                        className: 'select-checkbox',
                        targets: 0,
                        data: null,
                        defaultContent: ''
                    },
                    {data: "terr_id", className: 'day'},
                    {data: "user_id", className: 'day'},
                    {data: "name", className: 'day'},
                    {data: "pname", className: 'day'},
                    {data: "baby_name", className: 'wds'},
                    {data: "age", className: 'wday'},
                    {data: "sample_size", className: 'twd'},
                    {data: "contact_no", className: 'wd'},
                    // {data: "email", className: 'day'}
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                buttons: [
                    {
                        text: '<i class="fa fa-trash-o"></i> Remove Selected',
                        className: 'btn btn-warning btn-sm',
                        action: function () {
                            if (table2.rows().data().length > 0) {
                                if(table2.rows({selected: true}).data().length > 0){
                                    table2.rows({selected: true}).remove().draw();
                                }else{
                                    alert('Please select records to remove!');
                                }

                            }
                        }
                    },
                    {
                        text: '<i class="fa fa-trash-o"></i> Remove All',
                        className: 'btn btn-danger btn-sm',
                        action: function () {
                            if (table2.rows().data().length > 0) {
                                var r = confirm("Remove all record ?");
                                if (r) {
                                    table2.clear();
                                    table2.draw();
                                }
                            }
                        }
                    },
                    {
                        text: '<i class="fa fa-users"></i> Create Group',
                        className: 'btn btn-success btn-sm',
                        action: function () {
                            if (table2.rows().data().length > 0) {
                                var group_name = prompt('Enter group name:');
                                console.log(group_name);
                                if (group_name.length > 0) {
                                    $('#loader').show();
                                    var data = [];
                                    for (var i = 0; i < table2.rows().data().length; i++) {
                                        data.push(table2.rows().data()[i]);
                                    }
                                    $.post('{{url('nc/save_group')}}', {
                                        _token: '{{csrf_token()}}',
                                        tab_data: data,
                                        gname: group_name
                                    })
                                        .done(function (response) {
                                            if (response.status === 'I') {
                                                alert('record saved successfully');
                                                table2.clear();
                                                table2.draw();
                                                $('#loader').hide();
                                            }
                                            console.log(response);
                                        });
                                    //console.log(table2.rows().data());

                                } else {
                                    alert('Please enter group name');
                                }
                            } else {
                                alert('No records available to save');
                            }
                        }
                    }
                ]
            });

            $("#btn_display").click(function () {
                // console.log($("#ciform").serialize());
                if ($('#am_terr_id').val() && $('#terr_id').val()) {
                    //$("#report-body").hide();
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
                            //console.log(data);
                            table.clear();
                            table.rows.add(data);
                            table.draw();
                            $('#myModal').modal('show');
                            //$("#report-body").show();
                        },
                        error: function () {

                        },
                        complete: function () {
                            $("#loader").hide();
                        }
                    });

                }else{
                    alert('Please select AM/MPO territory');
                }
            });

            function display_alert_message(message) {
                $('#alert').show().removeClass('alert-warning').addClass('alert-success');
                $('#message').show();
                $('#message_text').html(message);
                $('#loader').hide();
            }

            function display_alert_loader() {
                $('#alert').show().removeClass('alert-success').addClass('alert-warning');
                $('#message').hide();
                $('#loader').show();
            }

            function hide_alert() {
                $('#alert').hide();
            }

            function stopCheck() {
                clearInterval(timer);
                timer = null;
            }

            function startCheck() {
                console.log('inside check');
                if (timer !== null) return;
                timer = setTimeout(function () {
                    $.get('{{url('nc/check_stat')}}').done(function (data) {
                        console.log(data);
                        if (data.status === 'Y') {
                            display_alert_message('SMS send success|Total SMS Sent (' + data.count + ')');
                            stopCheck();
                            $("#btnSendSms").attr('disabled', false);
                        } else if (data.error.length > 0) {
                            display_alert_message('An Error Occured');
                            setTimeout(function () {
                                hide_alert();
                            }, 6000);
                            $("#btnSendSms").attr('disabled', false);
                        }
                    });
                }, duration);
            }

            $('#btnSendSms').click(function () {
                if($('input[name="smstype"]:checked').val() === 'M'){
                    console.debug($('#group_list').select2('data'));
                    var selectedGroups = $('#group_list').select2('data');
                    if (selectedGroups.length > 0) {
                        $('#btnSendSms').attr('disabled', true);
                        display_alert_loader();
                        var groups = [];
                        for (var i = 0; i < selectedGroups.length; i++) {
                            groups.push(selectedGroups[i].id);
                        }
                        $.post('{{url('nc/neo_send_sms')}}', {
                            _token: '{{csrf_token()}}',
                            sgroup: groups,
                            mtext: $('#sms_text_mess').val().trim()
                        })
                        .done(function (response) {
                            startCheck();
                            console.log(response);
                        });
                    } else {
                        alert('Please select Group first');
                    }
                }else{

                    try {
                        display_alert_loader();
                        $("#btnSendSms").attr('disabled', true);

                        $.post('{{url('nc/neo_single_sms')}}', {
                            _token: '{{csrf_token()}}',
                            sms_numb: $('#numbers').val().trim(),
                            mtext: $('#sms_text_mess').val().trim()
                        })
                            .done(function (response) {
                                hide_alert();
                                console.log(response);
                                $("#btnSendSms").attr('disabled', false);
                            });
                    }catch (e) {
                        console.log(e);
                        alert('An error Occured '+e.message);
                        $("#btnSendSms").attr('disabled', false);
                    }

                }

            });

        })
    </script>
@endsection

