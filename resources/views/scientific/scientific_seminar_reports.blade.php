@extends('_layout_shared._master')
@section('title','Scientific Seminar Reports')

@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>

        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
            background-color: #46B8DA;
            border-color: #46B8DA;
            color: #fff;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 10px;
            overflow: visible !important
        }

        .table-responsive {
            overflow-x: inherit;
        }


        body {
            color: #000;
        }

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

        .tools a:hover {
            background: #337ab7;
        }

        .tools a {
            background: none;
            color: white;
        }

        caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: black;
            font: caption;
            text-align: center;
        }

    </style>

@endsection

@section('right-content')


    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary" style="color: white">
                        Scientific Seminar Reports
                    </label>
                </header>
                <form method="get" action="">
                    {{csrf_field()}}

                    <div class="panel-body">
                        @if(Auth::user()->desig === 'RM'||Auth::user()->desig === 'ASM'||Auth::user()->desig === 'DSM'||Auth::user()->desig === 'SM'||Auth::user()->desig === 'AM'||
                        Auth::user()->urole === '1'|| Auth::user()->urole == '46'|| Auth::user()->urole == '11'|| Auth::user()->urole == '32'|| Auth::user()->urole == '30')

                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bgt_month"
                                               class="control-label"><b>Program/Bill Month</b></label>
                                        <select name="bgt_month" id="bgt_month" class="form-control input-sm">
                                            <option value="">Select</option>
                                            @foreach($month_name as $mn)
                                                <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

{{--                                <div class=" col-md-2">--}}
{{--                                    <label></label><br>--}}
{{--                                    <button type="button" id="direct_bill" class="btn btn-default btn-sm">--}}
{{--                                        <i class="fa fa-check" aria-hidden="true"></i><b>Show</b>--}}
{{--                                        <i class="fa fa-spinner fa-spin" id="direct_bill_loader"--}}
{{--                                           style="font-size:20px; display:none;"></i>--}}
{{--                                    </button>--}}

{{--                                </div>--}}


                                <div class=" col-md-2">
                                    <label>Program No</label><br>
                                    <select name="program_no_for_report" id="program_no_for_report"
                                            class="form-control input-sm">
                                        <option value="">select program no</option>
                                        {{--                                        @foreach($program_no as $pn)--}}
                                        {{--                                            <option value="{{$pn->prog_no}}">{{$pn->prog_no}}</option>--}}
                                        {{--                                        @endforeach--}}
                                    </select>
                                </div>

                                <div class=" col-md-2">
                                    <label></label><br>
                                    <button type="submit" id="proposal_report" class="btn btn-default btn-sm"
                                            formaction="{{url('scientific/print_proposal_report')}}">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Print</b>
                                        <i class="fa fa-spinner fa-spin" id="program_bill_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>


                                </div>

                                <div class=" col-md-2">
                                    <label>Bill No</label><br>
                                    <select name="bill_no_for_report" id="bill_no_for_report"
                                            class="form-control input-sm">
                                        <option value="">select Bill no</option>
                                        {{--                                        @foreach($bill_no as $pn)--}}
                                        {{--                                            <option value="{{$pn->bill_no}}">{{$pn->bill_no}}</option>--}}
                                        {{--                                        @endforeach--}}
                                    </select>
                                </div>

                                <div class=" col-md-1">
                                    <label></label><br>
                                    <button type="submit" id="bill_report" class="btn btn-default btn-sm"
                                            formaction="{{url('scientific/print_bill_report')}}">
                                        <i class="fa fa-check" aria-hidden="true"></i><b>Print</b>
                                        <i class="fa fa-spinner fa-spin" id="verify_display_loader"
                                           style="font-size:20px; display:none;"></i>
                                    </button>
                                </div>


                            </div>

                        @endif

                    </div>

                </form>
            </section>
        </div>
    </div>

    <div id="direct_bill_form" style="display:;">


    </div>

    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection

@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    <script type="text/javascript">

        create_program = "{{url('scientific/create_bill')}}";
        am_change = "{{url('scientific/am_change')}}";
        update_button = "{{url('scientific/update_button')}}";
        save_button_direct_bill = "{{url('scientific/save_button_direct_bill')}}";
        save_button_program_bill = "{{url('scientific/save_button_program_bill')}}";
        program_bill = "{{url('scientific/program_bill')}}";
        insert_cost = "{{url('scientific/insert_cost')}}";
        verify_data = "{{url('scientific/verify_data_show')}}";
        verify_update = "{{url('scientific/verify_update')}}";
        program_and_bill = "{{url('scientific/program_and_bill')}}";
        _csrf_token = '{{csrf_token()}}';
        var table;

        $(document).ready(function () {

                $('#proposal_report').attr('formtarget', '_blank');

                $('#bill_report').attr('formtarget', '_blank');

                $('#bgt_month').on('change', function () {
                    console.log('month changed');

                    var month = $('#bgt_month').val();
                    $("#program_no_for_report").empty().append("<option value='loader'>Loading...</option>");
                    $("#bill_no_for_report").empty().append("<option value='loader'>Loading...</option>");
                    $.ajax({
                        method: "post",
                        url: program_and_bill,
                        data: {
                            _token: _csrf_token,
                            mon: month
                        },
                        success: function (data) {
                            console.log(data);
                            var proposal = data['proposal'];
                            var bill = data['bill'];
                            // console.log(data.length);
                            // if ((data.length) > 0) {
                            var pr = '';

                            for (var i = 0; i < proposal.length; i++) {
                                pr += '<option value= " ' + proposal[i]['prog_no'] + ' " >' + proposal [i]['prog_no'] + '</option>';
                            }
                            $("#program_no_for_report").empty().append(pr);

                            var bl = '';

                            for (var i = 0; i < bill.length; i++) {
                                bl += '<option value= " ' + bill[i]['bill_no'] + ' " >' + bill [i]['bill_no'] + '</option>';
                            }
                            $("#bill_no_for_report").empty().append(bl);

                            // }

                        },
                        error: function () {
                            console.log('fail');
                        }
                    });
                });

                $("#direct_bill").click(function () {

                    document.getElementById("emp_info_form").reset();
                    document.getElementById("program_info_form").reset();
                    document.getElementById("budget_cost").reset();
                    $('#save_button_direct_bill').show();
                    $('#save_button_program_bill').hide();
                    $('#verify_button').hide();
                    $("#direct_bill_loader").show();
                    $('#budget_table_div_bill').hide();
                    $('#cost_table_div_bill').hide();
                    $('#budget_table_div').show();
                    $('#cost_table_div').show();
                    $('#direct_bill_form').hide();

                    $('#nop').prop("disabled", true);
                    $('#nop_attended').prop("disabled", false);
                    $('#cp').prop("disabled", false);
                    $('#mobile').prop("disabled", false);
                    $('#program_team').prop("disabled", false);
                    $('#program_type').prop("disabled", false);
                    $('#program_venue').prop("disabled", false);
                    $('#timing').prop("disabled", false);
                    $('#advance_budget').prop("disabled", true);

                    $('#program_feedback').prop("disabled", false);
                    $('#payable').prop("disabled", true);
                    $('#actual_expenditure').prop("disabled", false);


                    console.log($("#timing").val());

                    console.log('Create Program button clicked');

                    if ($("#bgt_month").val() === "") {
                        alert("Please select Program Month");
                    } else {
                        var brand_name = $("#brand_name").val();
                        console.log(brand_name);
                        var mon = $('#bgt_month').val();

                        $.ajax({
                            url: create_program,
                            method: "post",
                            dataType: 'json',

                            data: {
                                _token: _csrf_token,
                                mon: mon
                            },

                            success: function (resp) {

                                $("#brand_name_program_bill").hide();
                                $("#brand_name_direct_bill").show();
                                $("#direct_bill_loader").hide();
                                $('#direct_bill_form').show();
                                $('#prog_month').val(mon);
                                console.log(resp);
                                var designation = resp.designation;
                                console.log(designation);
                                var emp_info = resp.emp_info[0];
                                var am_info = resp.am;
                                var budget_data = resp.budget_details;
                                var cost_data = resp.cost_details;
                                if ((resp.length) < 1) {
                                    // $("#loader").hide();
                                    toastr.info('Please reload the page');
                                } else {

                                    if (designation == 'RM') {

                                        $("#gm").val(emp_info['gm_name']);
                                        $("#sm").val(emp_info['sm_name']);
                                        $("#dsm").val(emp_info['dsm_name']);
                                        $("#rm_terr").val(emp_info['rm_terr_id']);
                                        $("#rm_name").val(emp_info['rm_asm_name']);

                                        var am = "";
                                        am += "<option value=''>Select Territory</option>";
                                        for (var l = 0; l < am_info.length; l++) {
                                            var idl = am_info[l]['am_terr_id'];
                                            var vall = am_info[l]['am_name'];

                                            am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";
                                        }

                                        $('#am_terr').html(am);

                                    }

                                    if (designation == 'AM') {
                                        console.log('am form fields have been accessed');

                                        $("#gm").val(emp_info['gm_name']);
                                        $("#sm").val(emp_info['sm_name']);
                                        $("#dsm").val(emp_info['dsm_name']);
                                        $("#rm_terr").val(emp_info['rm_terr_id']);
                                        $("#rm_name").val(emp_info['rm_asm_name']);

                                        var am = "";
                                        var idl = emp_info['am_terr_id'];
                                        var vall = emp_info['am_name'];
                                        am += "<option value='" + idl + "' data-am_name ='" + vall + "'>" + idl + ' ' + vall + "</option>";
                                        $('#am_terr').html(am);

                                        var selOptsMPO = "";
                                        selOptsMPO += "<option value=''>Select Territory</option>";
                                        for (var j = 0; j < am_info.length; j++) {
                                            var id = am_info[j]['mpo_terr_id'];
                                            var val = am_info[j]['mpo_name'];
                                            var pgroup = am_info[j]['p_group'];
                                            var depot_id = am_info[j]['d_id'];
                                            var depot_name = am_info[j]['depot_name'];
                                            selOptsMPO += "<option value='" + id + "' data-mpo_name = '" + val + "' " +
                                                " data-mpo_team = '" + pgroup + "' data-depot_id = '" + depot_id + "'  " +
                                                " data-depot_name = '" + depot_name + "'>" + id + ' ' + val + '-' + pgroup + "</option>";
                                        }

                                        $('#mpo_terr').empty().append(selOptsMPO);

                                    }


                                    var markup = "";
                                    for (var l = 0; l < budget_data.length; l++) {
                                        var cct = budget_data[l]['cc_team_name'];
                                        var ccn = budget_data[l]['cost_center_id'];
                                        var gl = budget_data[l]['gl'];

                                        markup += "<tr>" +
                                            "<td>" + cct + "</td>" +
                                            "<td>" + ccn + "</td>" +
                                            "<td>" + gl + "</td>" +
                                            "<td><input type='number' name='total' style='text-transform: uppercase;' class='each_budget form-control' id='total'  autocomplete='off'></td>" +
                                            "</tr>";
                                    }

                                    $("#budget_details tbody").empty().append(markup);

                                    var markup_cost_table = "";
                                    for (var l = 0; l < cost_data.length; l++) {
                                        var cct = cost_data[l]['ci_name'];

                                        markup_cost_table += "<tr>" +
                                            "<td>" + cct + "</td>" +
                                            "<td><input type='number' name='cost_amount' style='text-transform: uppercase;' class='each_cost form-control' id='cost_amount'  autocomplete='off'></td>" +
                                            "</tr>";
                                    }

                                    $("#cost_details tbody").empty().append(markup_cost_table);


                                }
                            },
                            error: function (err) {
                                // console.log(err);
                                $("#direct_bill_loader").hide();
                            }
                        });

                    }

                });


            }
        );


    </script>

@endsection