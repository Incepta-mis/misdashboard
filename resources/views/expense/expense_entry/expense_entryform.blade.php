@extends('_layout_shared._master')
@section('title','Doctor Visit Summary Report')
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
        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 12px;
            color: #1fb5ac;
            font-weight: bold;
        }

        body{
            color: black;
        }

        .table-bordered>thead>tr>th{
            border: 1px solid #0e0d0d;
        }
        .table-bordered>tbody>tr>td{
            border: 1px solid #0e0d0d;
        }
        .table-bordered{
            border: 1px solid #0e0d0d;
        }
        .table-bordered > tfoot > tr > td {
            border: 1px solid #0e0d0d;
        }
        #loading-img {
            background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;
            height: 100%;
            z-index: 20;
        }

        .overlay {
            /*background: #e9e9e9;*/
            display: none;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.5;
        }

        .form-control{
            padding:1px 0px;

        }

        #dvsr_data button,input,select,textarea{
            font-size:10px;
            color:black
        }
        #dvsr_data th{
            font-size:13px;
            background-color: #CDC1A7;
        }

        textarea{
            margin: 1px 1px;
            width: 81px;
            height: 33px;
        }

        .error {
            border: solid 2px #FF0000;
        }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-10 col-md-10">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Expense Entry Form
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">

                        <form method="post" id="frmexpense">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                    <b>Expense Month:</b></label>
                                <div class="col-md-2 col-sm-2 col-xs-6">
                                    <select name="e_month" id="e_month_id" class="form-control input-sm">
                                        @foreach($expense_months as $expense_mon)
                                            <option value="{{$expense_mon->month}}">{{$expense_mon->month}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                    <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;"
                                           for="terr_id">
                                        <b>Region_Terr:</b></label>
                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                        <select name="e_rm_terr_id" id="e_rm_terr_id" class="form-control input-sm">

                                            @foreach($datas as $dd)
                                                <option value="{{$dd->rm_terr_id}}">{{$dd->rm_terr_id}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" for="p_group">
                                        <b>AM_Terr:</b></label>
                                    <div class="col-md-2 col-sm-2 col-xs-2" id="am_div_id">
                                        <select name="e_am_terr_id" id="e_am_terr_id"  class="form-control input-sm">

                                        </select>
                                    </div>

                            </div>
                            <div class="form-group">

                                    <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                        <b>Emp Code:</b></label>
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        <select name="e_emp_id" id="e_emp_id" class="form-control input-sm">

                                        </select>
                                    </div>

                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                    <button type="submit" id="btn_display_u" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Submit</b></button>
                                </div>




                            </div>



                        </form>

                    </div>
                </div>
            </section>
        </div>
        <div class="col-sm-2 col-md-2">
            <section class="panel" id="data_table">

                <div class="panel-body" id="summary_tour_table">

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
    <div class="row" id="report-body">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive" id="search_div_id">

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
    {{--<div class="row" id="form-button-submit">--}}

    {{--<div class="col-sm-12 col-md-12">--}}
    {{----}}
    {{--</div>--}}

    {{--</div>--}}

    @include('expense.modal.edit_expense_verify_data')
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    <script type="text/javascript">

//        $("#e_emp_id").select2({
//            placeholder: "Select a Name",
//            allowClear: true
//        });

        $(document).ready(function(){




                    var log_name='{{Auth::user()->name}}';
                    var log_id='{{Auth::user()->user_id}}';
                    var log_desig='{{Auth::user()->desig}}';
                    var exp_id_g;



            $('#e_rm_terr_id').change(function(){


                $('#e_am_terr_id').empty();
                $('#e_am_terr_id').append($('<option></option>').html('Loading...'));

                var sc_rm_id=$('#e_rm_terr_id').val();
                var log_desigg='{{Auth::user()->desig}}';
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('expense/getAMTerr')!!}',
                    data:{'rm_id':sc_rm_id,'desig':log_desigg},
                    success:function(data){
                        $('#e_am_terr_id').empty();
                        if((data.rm_data.length)>0){
                            var op='';
                            op+='<option value="0" selected disabled>Select AM</option>';
                            for(var i=0;i<data.rm_data.length;i++){
                                op+='<option value="'+data.rm_data[i]['am_terr_id']+'">'+data.rm_data[i]['am_terr_id']+'</option>';
                            }
//
                            $('#e_am_terr_id').html(" ");
                            $('#e_am_terr_id').html(op);
                        }else{
                            console.log("no data found");
                        }



                    },
                    error:function(){

                    }
                });});



            $('#e_am_terr_id').change(function(){

                $('#e_emp_id').empty();
                $('#e_emp_id').append($('<option></option>').html('Loading...'));

                var log_desigg='{{Auth::user()->desig}}';
                var sc_am_id=$('#e_am_terr_id').val();
                var sc_rmm_id=$('#e_rm_terr_id').val();
                var exp_mon=$('#e_month_id').val();

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('expense/getEmpId')!!}',
                    data:{'rm_id':sc_rmm_id,'am_id':sc_am_id,'desig':log_desigg,'exp_mon':exp_mon},
                    success:function(data){
                        $('#e_emp_id').empty();

                        var op='';
                        for(var i=0;i<data.am_data.length;i++){
                            op+='<option value="'+data.am_data[i]['emp_id']+'">'+data.am_data[i]['emp_id']+'</option>';
                        }
                        $('#e_emp_id').html(" ");
                        $('#e_emp_id').append(op);
                    },
                    error:function(){

                    }
                });});
{{--////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////--}}

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            function convertNumberToWords(amount) {
                var words = new Array();
                words[0] = '';
                words[1] = 'One';
                words[2] = 'Two';
                words[3] = 'Three';
                words[4] = 'Four';
                words[5] = 'Five';
                words[6] = 'Six';
                words[7] = 'Seven';
                words[8] = 'Eight';
                words[9] = 'Nine';
                words[10] = 'Ten';
                words[11] = 'Eleven';
                words[12] = 'Twelve';
                words[13] = 'Thirteen';
                words[14] = 'Fourteen';
                words[15] = 'Fifteen';
                words[16] = 'Sixteen';
                words[17] = 'Seventeen';
                words[18] = 'Eighteen';
                words[19] = 'Nineteen';
                words[20] = 'Twenty';
                words[30] = 'Thirty';
                words[40] = 'Forty';
                words[50] = 'Fifty';
                words[60] = 'Sixty';
                words[70] = 'Seventy';
                words[80] = 'Eighty';
                words[90] = 'Ninety';
                amount = amount.toString();
                var atemp = amount.split(".");
                var number = atemp[0].split(",").join("");
                var n_length = number.length;
                var words_string = "";
                if (n_length <= 9) {
                    var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                    var received_n_array = new Array();
                    for (var i = 0; i < n_length; i++) {
                        received_n_array[i] = number.substr(i, 1);
                    }
                    for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                        n_array[i] = received_n_array[j];
                    }
                    for (var i = 0, j = 1; i < 9; i++, j++) {
                        if (i == 0 || i == 2 || i == 4 || i == 7) {
                            if (n_array[i] == 1) {
                                n_array[j] = 10 + parseInt(n_array[j]);
                                n_array[i] = 0;
                            }
                        }
                    }
                    value = "";
                    for (var i = 0; i < 9; i++) {
                        if (i == 0 || i == 2 || i == 4 || i == 7) {
                            value = n_array[i] * 10;
                        } else {
                            value = n_array[i];
                        }
                        if (value != 0) {
                            words_string += words[value] + " ";
                        }
                        if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Crores ";
                        }
                        if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Lakhs ";
                        }
                        if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                            words_string += "Thousand ";
                        }
                        if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                            words_string += "Hundred and ";
                        } else if (i == 6 && value != 0) {
                            words_string += "Hundred ";
                        }
                    }
                    words_string = words_string.split("  ").join(" ");
                }
                return words_string;
            }
            $(document).on('submit','#frmexpense',function(event){

                $("#report-body").hide();
                $("#loader").show();
                var div=$(this).parent().parent().parent().parent().parent().parent();

                event.preventDefault();

                var form=$('#frmexpense');
                var formData=form.serialize();
                var url="{{URL::to('expense/post_searchexpense_entry')}}";
                var type='post';

                $.ajax({
                    type:type,
                    url:url,
                    data:formData,
                    success:function(data)
                    {

                       $("#report-body").show();
                        $("#loader").hide();
//                        
//                        console.log(data.expense);
//                        console.log(data.expense.length);
//
//                        console.log(data.table_tour_type);
//                        console.log(data.table_allow_type);

                        var len=data.expense.length;
                        if(len<=0){
                            $('#summary_tour_table').html(" ");
                            div.find('#search_div_id').empty("");

                            if(log_desig=='MPO'){
                                div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong> RM Already Verified this Expense.</div>");
                            }else if(log_desig=='RM'){
                                div.find('#search_div_id').html("<div class='alert alert-danger'><strong>Note:</strong>Head Office  Already Approved this Expense.</div>");
                            }else{
                                div.find('#search_div_id').html("No Data Found");
                            }

                        }else{



                            var viewdata=" ";

                            viewdata+="<table id='dvsr_data' border='1' width='100%'>";
                            viewdata+="<thead style='white-space:nowrap;'>";


                            viewdata+="<tr>";
                            viewdata+="<th colspan='3' style='text-align: center;font-size: 11px;'>DEPOT_NAME: <span style='font-size: 11px;color:#885151'>"+data.expense[0]['depot_name']+"</span></th>";
                            viewdata+="<th colspan='2' style='text-align: center;font-size: 11px;'>EMP_ID: <span style='font-size: 11px;color:#885151'>"+data.expense[0]['emp_id']+"</span></th>";
                            viewdata+="<th colspan='3' style='text-align: center;font-size: 11px;'>EMP_NAME: <span style='font-size: 11px;color:#885151'>"+data.expense[0]['emp_name']+"</span></th>";
                            viewdata+="<th colspan='2' style='text-align: center;font-size: 11px;'>DESIG: <span style='font-size: 11px;color:#885151'>"+data.expense[0]['desig']+"</span></th>";
                            viewdata+="<th colspan='2' style='text-align: center;font-size: 11px;'>Team: <span style='font-size: 11px;color:#885151'>"+data.expense[0]['team']+"</span></th>";
                            viewdata+="<th colspan='3' style='text-align: center;font-size: 11px;'>TERR_ID: <span style='font-size: 11px;color:#885151'>"+data.expense[0]['terr_id']+"</span></th>";
                            viewdata+="</tr>";

                            viewdata+="<tr>";
                            viewdata+="<th rowspan='2' style='text-align: center;font-size: 11px;'>Exp_Date</th>";
                            viewdata+="<th rowspan='2' style='text-align: center;font-size: 11px;'>Tour<br>Type</th>";
                            viewdata+="<th rowspan='2' style='text-align: center;font-size: 11px;'>Tour<br>Details</th>";
                            viewdata+="<th rowspan='2' style='text-align: center;font-size: 11px;'>Daily<br>Allowance</th>";
                            viewdata+="<th colspan='2' style='text-align: center;font-size: 11px;'>City/Fare Allowance</th>";

                            viewdata+="<th colspan='3' style='text-align: center;font-size: 11px;'>Travel Allowance</th>";

                            viewdata+="<th colspan='3' style='text-align: center;font-size: 11px;'>Other Expense</th>";

                            viewdata+="<th rowspan='2' style='text-align: center;font-size: 11px;'>Add.<br>Amount</th>";
                            viewdata+="<th rowspan='2' style='text-align: center;font-size: 11px;'>Total</th>";
                            viewdata+="<th rowspan='2' ><a href='#' style='margin-left: 3px;' class='btn btn-success addRow'><i class='glyphicon glyphicon-plus'></i></a></th>";
                            viewdata+="</tr>";


                            viewdata+="<tr>";

                            viewdata+="<th style='text-align: center;font-size: 11px;'>Type</th>";
                            viewdata+="<th style='text-align: center;font-size: 11px;'>Allowance</th>";

                            viewdata+="<th style='text-align: center;font-size: 11px;'>Description</th>";
                            viewdata+="<th style='text-align: center;font-size: 11px;'>Amount</th>";
                            viewdata+="<th style='text-align: center;font-size: 11px;'>Image</th>";

                            viewdata+="<th style='text-align: center;font-size: 11px;'>Description</th>";
                            viewdata+="<th style='text-align: center;font-size: 11px;'>Amount</th>";
                            viewdata+="<th style='text-align: center;font-size: 11px;'>Image</th>";

                            viewdata+="</tr>";
                            viewdata+="</thead>";

                            viewdata+="<tbody>";

                            $.each(data.expense, function (index, value) {



                                if(!(data.expense[index]['tour_type'])){
                                    data.expense[index]['tour_type']='HQ';

                                }else{
                                    data.expense[index]['tour_type']=data.expense[index]['tour_type'];


                                }


                                var ttyy=data.expense[index]['tour_type'];

                                viewdata += "<tr class='" + data.expense[0]['exp_id'] + "'>";


                                viewdata += "<td style='width:90px' ><input type='text' value='"+data.expense[index]['exp_date']+"' style='width: 58px;margin: 0px 1px 2px 2px;' class='dateinp'></td>";

                                viewdata += "<td>";
                                    viewdata +="<select class='chg_tour_ty'  name='tour_type' id='tour_type'>";
                                            var index_no;
                                            $.each(data.table_tour_type,function(index,v){
//                                                console.log(data.table_tour_type[index]['tour_type_desc'] == ttyy ? 'selected' : '');
                                                var rrcheck=data.table_tour_type[index]['tour_type_desc'] == ttyy ? 'selected' : '';

//                                                var nn=rrcheck=='selected'?index:

                                                        if(rrcheck=='selected'){
                                                            index_no=index;
                                                        }
//                                                console.log(index_no);

                                                viewdata +="<option "+rrcheck+" value='"+data.table_tour_type[index]['tour_type_desc']+"'>"+data.table_tour_type[index]['tour_type_desc']+"</option>";
                                            });
                                    viewdata +="<select>";
                                viewdata += "</td>";
//                                console.log("index_no");
//                                console.log(index_no);
//                                console.log(data.table_tour_type[2]['amount']);

                                viewdata += "<td><input type='text' value='"+data.expense[index]['tour_details']+"' style='width: 81px;margin: 0px 1px 2px 2px;'></td>";
                                viewdata += "<td><input type='text' readonly class='chg_daily_allow' value='"+data.table_tour_type[index_no]['amount']+"' style='width: 41px;margin: 0px 1px 2px 2px;'></td>";

                                viewdata += "<td>";
                                        viewdata +="<select class='chg_allow_ty' name='allow_type' id='allow_type'>";

                                        var index_non;
                                        var cckk;
                                        var atyread;
                                var atyval;
        //                                CITY_FARE_ALLOWANCE_TYPE
//                                        console.log("data.expense[index]['exp_id']");
//                                        console.log(data.expense[index]['city_fare_allowance_type']);
                                        if(!(data.expense[index]['city_fare_allowance_type'])){
                                            cckk='Fare Allowance';
                                        }else{
                                            cckk= data.expense[index]['city_fare_allowance_type'];
                                        }

                                        var allow_typp=cckk;
//

                                        $.each(data.table_allow_type,function(index,v){
                                            var atycheck=data.table_allow_type[index]['allowance_type_desc'] == allow_typp ? 'selected' : '';
                                            atyread=allow_typp=='City Allowance'? 'readonly' :'';

//                                            console.log(allow_typp);
//                                            console.log(atyread);
                                            if(atycheck=='selected'){
                                                index_non=index;
                                            }


                                            viewdata +="<option "+atycheck+"  value='"+data.table_allow_type[index]['allowance_type_desc']+"'>"+data.table_allow_type[index]['allowance_type_desc']+"</option>";
                                        });
                                viewdata +="</td>";
//                                console.log("index_non");
                                var ttyyuu=data.table_allow_type[index_non]['amount'];
                                atyval=allow_typp=='Fare Allowance'? 0 :ttyyuu;
//                                console.log(atyval);
//                                console.log(data.expense[0]['oe_amount']);
                                viewdata += "<td><input type='text' "+atyread+" class='chg_city_fare_allow' value='"+atyval+"' style='width:56px;margin: 0px 1px 2px 2px;'>" +
                                        "<input type='hidden' value='"+data.table_allow_type[0]['amount']+"' class='max_fare' ></td></td>";

                                viewdata += "<td><textarea >"+data.expense[index]['ta_description']+"</textarea></td>";
                                viewdata += "<td><input type='text' class='ta_amount_tr' value='"+data.expense[index]['ta_amount']+"' style='width: 81px;margin: 0px 1px 2px 2px;'></td>";
                                viewdata += "<td><input type='file' style='width:119px;margin: 0px 1px 2px 2px;'></td>";
                                viewdata += "<td><textarea></textarea></td>";

                                viewdata += "<td><input type='text' class='oe_amount_tr' value='"+data.expense[index]['oe_amount']+"' style='width: 46px;margin: 0px 1px 2px 2px;'></td>";
                                viewdata += "<td><input type='file' style='width: 119px;margin: 0px 1px 2px 2px;'></td>";
                                viewdata += "<td><input type='text' class='add_amount_tr' value='"+data.expense[index]['additional_amount']+"' style='width: 41px;margin: 0px 1px 2px 2px;'></td>";
                                var sum_frow_vv=0;

//                                console.log(data.table_tour_type[index_no]['amount']);
//                                console.log(data.table_allow_type[index_non]['amount']);
//                                console.log(data.expense[index]['ta_amount']);
//                                console.log(data.expense[index_non]['oe_amount']);
//                                console.log(data.expense[index_no]['additional_amount']);
//                                console.log(data.table_allow_type[index_non]['amount']);
//                                ta_amount_tr  atyval
//                                sum_frow_vv=parseInt(data.table_tour_type[index_no]['amount'])+parseInt(data.table_allow_type[index_non]['amount'])+parseInt(data.expense[index]['ta_amount'])+parseInt(data.expense[index]['oe_amount'])+parseInt(data.expense[index]['additional_amount'])+sum_frow_vv;
                                sum_frow_vv=parseInt(data.table_tour_type[index_no]['amount'])+parseInt(atyval)+parseInt(data.expense[index]['ta_amount'])+parseInt(data.expense[index]['oe_amount'])+parseInt(data.expense[index]['additional_amount'])+sum_frow_vv;


                                viewdata += "<td><span class='trtotalclass' style='font-size:10px'>"+sum_frow_vv+"</span></td>";
//                                viewdata += "<td>4353</td>";

                                viewdata += "<td><a href='#' style='margin-left: 3px;' class='btn btn-danger remove'><i class='glyphicon glyphicon-remove'></i></a></td>";
                                viewdata += "</tr>";

                            });


                            viewdata+="</tbody>";

                            viewdata+="<tfoot>";

                            viewdata+="<tr>";
                            viewdata+="<td colspan='5' style='padding: 4px;font-size: 12px;color: #1fb5ac;font-weight: bold;'>Grand Total:</td>";
                            viewdata+="<td colspan='8'></td>";
                            viewdata+="<td><span id='total_sum_final' style='padding: 4px;font-size: 12px;color: #1fb5ac;font-weight: bold;'></span></td>";
                            viewdata+="<td></td>";

                            viewdata+=" </tr>";

                            viewdata+=" <tr>";
                            viewdata+=" <td colspan='5' style='padding: 4px;font-size: 12px;color: #1fb5ac;font-weight: bold;'>Grand Total In Amount (Tk.) :</td>";
                            viewdata+="<td colspan='8'><span id='total_sum_final_inword' style='padding: 4px;font-size: 12px;color: #1fb5ac;font-weight: bold;'>Take Only</span></td>";
                            viewdata+="<td colspan='2'></td>";

                            viewdata+="</tr>";

                            viewdata += " <tr>";
                            viewdata += " <td colspan='20'><center>" +
                                    "<button type='button' style='margin:1px 1px' class='btn btn-primary btn-lg' id='final_whole_sub_btnid'><span style='color:white;font-weight: bold'>Submit</span></button>" +
                                    "</center></td>";

                            viewdata += "</tr>";
                            viewdata+=" </tfoot>";


                            viewdata+="</table>";


                            div.find('#search_div_id').empty("");
                            div.find('#search_div_id').html(viewdata);


                            $('.addRow').on('click',function(){

                                addRow();
                            });
// --                       ----------------add row function---------------------------------------------------------
                            function addRow()
                            {



                                var tr=" ";

                                tr += "<tr>";
                                tr += "<td style='width:90px' ><input type='text' style='width: 58px;margin: 0px 1px 2px 2px;' class='dateinp'></td>";

                                tr += "<td>";
                                tr +="<select class='chg_tour_ty'  name='tour_type' id='tour_type'>";
                                $.each(data.table_tour_type,function(index,v){
                                    tr +="<option value='"+data.table_tour_type[index]['tour_type_desc']+"'>"+data.table_tour_type[index]['tour_type_desc']+"</option>";
                                });
                                tr +="<select>";
                                tr += "</td>";


                                tr += "<td><input type='text' style='width: 81px;margin: 0px 1px 2px 2px;'></td>";
                                tr += "<td><input type='text' readonly class='chg_daily_allow' value='"+data.table_tour_type[0]['amount']+"' style='width: 41px;margin: 0px 1px 2px 2px;'></td>";
                                tr += "<td>";
                                tr +="<select class='chg_allow_ty' name='allow_type' id='allow_type'>";
                                var rrval;
                                $.each(data.table_allow_type,function(index,v){

                                    var ttyy=data.table_allow_type[index]['allowance_type_desc'];
                                    var rrcheck=ttyy == 'Fare Allowance' ? 'selected' : '';

                                    var ttyamnt=data.table_allow_type[index]['amount'];

                                    rrval=ttyy =='Fare Allowance' ? 0 : ttyamnt;

                                    tr +="<option "+rrcheck+" value='"+data.table_allow_type[index]['allowance_type_desc']+"'>"+data.table_allow_type[index]['allowance_type_desc']+"</option>";
                                });
                                tr +="</td>";

                                tr += "<td><input class='chg_city_fare_allow' value='"+rrval+"' type='text' style='width:56px;margin: 0px 1px 2px 2px;'>" +
                                        "<input type='hidden' value='"+data.table_allow_type[1]['amount']+"' class='max_fare' ></td>";

                                tr += "<td><textarea ></textarea></td>";
                                tr += "<td><input type='text' class='ta_amount_tr' value='0' style='width: 81px;margin: 0px 1px 2px 2px;'></td>";
                                tr += "<td><input type='file' style='width: 119px;margin: 0px 1px 2px 2px;'></td>";
                                tr += "<td><textarea></textarea></td>";

                                tr += "<td><input type='text' value='0' class='oe_amount_tr' style='width: 46px;margin: 0px 1px 2px 2px;'></td>";
                                tr += "<td><input type='file' style='width: 119px;margin: 0px 1px 2px 2px;'></td>";
                                tr += "<td><input type='text' value='0' class='add_amount_tr' style='width: 41px;margin: 0px 1px 2px 2px;'></td>";

                                var sum_frow=0;
                                sum_frow=parseInt(data.table_tour_type[0]['amount'])+sum_frow;


                                tr += "<td><span class='trtotalclass' style='font-size:10px'>"+sum_frow+"</span></td>";

                                tr += "<td><a href='#' style='margin-left: 3px;' class='btn btn-danger remove'><i class='glyphicon glyphicon-remove'></i></a></td>";
                                tr += "</tr>";

                                div.find('tbody').prepend(tr);

                                div.find('.dateinp').datetimepicker({
                                    format: 'DD/MM/YYYY',
                                    showTodayButton: true,
                                    showClose: true,
                                    showClear: true
                                });

                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element
                                    total += amount;

                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");

                                });


                            }
                            /////////date picker


                            div.find('.dateinp').datetimepicker({
                                format: 'DD/MM/YYYY',
                                showTodayButton: true,
                                showClose: true,
                                showClear: true
                            });

                            $(document).on('keyup keydown',".chg_city_fare_allow",function(){

                                var divmax= $(this).parent();
//                                $(this).parent().parent().css('background-color','green');
                                var maxamnt=divmax.find('.max_fare').val();
                                    if (parseInt($(this).val()) > parseInt(maxamnt) ) {
                                        $(this).addClass("error");
                                    } else{
                                        $(this).removeClass("error");
                                    }
                                trtotal($(this).parent().parent());


                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element

                                    total += amount;

                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");

                                });

                            });


                            $(document).on('change',".chg_tour_ty",function(){

                                var div_da=$(this).parent().parent();
                                var gtt=$(this).val();

                                $.each(data.table_tour_type,function(i,v){
                                    if(gtt==data.table_tour_type[i]['tour_type_desc']){
                                        div_da.find('.chg_daily_allow').val(data.table_tour_type[i]['amount']);
                                    }
                                });

                                trtotal(div_da);

                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element
                                    total += amount;
                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");

                                });

                            });

                            $(document).on('change',".chg_allow_ty",function(){

                                var div_da=$(this).parent().parent();

                                var gtt=$(this).val();

                                $.each(data.table_allow_type,function(i,v){
                                    if(gtt==data.table_allow_type[i]['allowance_type_desc']){
//
                                        if(data.table_allow_type[i]['allowance_type_desc']=='City Allowance'){

                                            div_da.find('.chg_city_fare_allow').attr('readonly',true);
                                            div_da.find('.chg_city_fare_allow').val(data.table_allow_type[i]['amount']);

                                        }else if(data.table_allow_type[i]['allowance_type_desc']=='Fare Allowance'){

                                            div_da.find('.chg_city_fare_allow').attr('readonly',false);
                                            div_da.find('.chg_city_fare_allow').val(0);
                                            div_da.find('.max_fare').val(data.table_allow_type[i]['amount']);

                                        }

                                    }

                                    trtotal(div_da);
//                                    console.log(data.table_allow_type[i]['allowance_type_desc']);
                                });

                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element
                                    total += amount;
                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");

                                });

                            });

                            $(document).on('change paste keyup','.ta_amount_tr',function(){
                                var div_da=$(this).parent().parent();
//                                div_da.css('background-color','yellow');
                                trtotal(div_da);
                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element
                                    total += amount;
                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);


                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");

                                });
                            });
                            $(document).on('change paste keyup','.oe_amount_tr',function(){
                                var div_da=$(this).parent().parent();
//                                div_da.css('background-color','yellow');
                                trtotal(div_da);
                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element
                                    total += amount;
                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");


                                });
                            });
                            $(document).on('change paste keyup','.add_amount_tr',function(){
                                var div_da=$(this).parent().parent();
//                                div_da.css('background-color','yellow');
                                trtotal(div_da);
                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element
                                    total += amount;
                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");


                                });
                            });




                            $(document).on('click',".remove",function(){
//                            $('.remove').on("click",function(){
                                console.log("remove click ");



                                $(this).parent().parent().remove();

                                var total=0;
                                $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                    var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element

                                    total += amount;

                                    $('#total_sum_final').html(" ");
                                    $('#total_sum_final').html(total);

                                    var wrd;
                                    wrd=convertNumberToWords(total);

                                    $('#total_sum_final_inword').html(wrd+" Taka Only");


                                });

                                // message
                                    toastr["error"]("Successfully row deleted")
                                      toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "newestOnTop": false,
                                        "progressBar": false,
                                        "positionClass": "toast-top-center",
                                        "preventDuplicates": false,
                                        "onclick": null,
                                        "showDuration": "100",
                                        "hideDuration": "300",
                                        "timeOut": "1000",
                                        "extendedTimeOut": "700",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    }
                                // message
                            });

                            function trtotal(div_da){

                                var daily_allow=div_da.find('.chg_daily_allow').val();
                                console.log(daily_allow);

                                var ca_allow=div_da.find('.chg_city_fare_allow').val();
                                console.log(ca_allow);

                                if(!ca_allow){
                                    ca_allow=0;
                                }

                                var ta_amnt=div_da.find('.ta_amount_tr').val();

//                                ta_amnt=' ' ? '0':ta_amnt;
                                console.log(ta_amnt);

                                if(!ta_amnt){
                                    ta_amnt=0;
                                }

                                var oe_amnt=div_da.find('.oe_amount_tr').val();
                                console.log(oe_amnt);

                                if(!oe_amnt){
                                    oe_amnt=0;
                                }

                                var add_amnt=div_da.find('.add_amount_tr').val();
                                console.log(add_amnt);

                                if(!add_amnt){
                                    add_amnt=0;
                                }

                                var summr;

                                summr=parseInt(daily_allow)+parseInt(ca_allow)+parseInt(ta_amnt)+parseInt(oe_amnt)+parseInt(add_amnt);

//                                console.log(summr);

//                                div_da.find('.trtotalclass').css('background-color','yellow');
                                div_da.find('.trtotalclass').empty(" ");
                                div_da.find('.trtotalclass').html(summr);

                            }

                            var total=0;
                            $('table#dvsr_data tbody tr .trtotalclass').each(function (index, element) {

                                var amount = parseInt($(this).text()) - 0;//current je value ta ta nibe here i holo index no r e holo element

                                total += amount;

                                $('#total_sum_final').html(" ");
                                $('#total_sum_final').html(total);

                                var wrd;
                                wrd=convertNumberToWords(total);

                                $('#total_sum_final_inword').html(wrd+" Taka Only");


                            });


                        }

                    },
                    error:function(data){
                        console.log("fail");
                    }
                });



            });




        });


    </script>

@endsection
