@extends('_layout_shared._master')
@section('title','Employee Rating Entry')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{url('public/site_resource/css/salert/sweetalert2.min.css')}}">

    <link rel="stylesheet" href="{{url('public/site_resource/spinner-btn/ladda-themeless.min.css')}}">


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


        .overlaypageload{
            background-color: #333;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.5;
            /*position: fixed;*/
            /*top: 0;*/
            /*left: 0;*/
            /*width: '100&#37;';*/
            /*height: $(window).height() + 'px';*/
            /*background: 'white url(img/loading.gif) no-repeat center'*/
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }

        /* 12.03.2018 */
        .alert-view-modi{
            padding:0px;
            margin-bottom:0px;
        }

        .notice {
            padding: 5px;
            background-color: #fafafa;
            border-left: 6px solid #7f7f84;
            margin-bottom: 0px;
            -webkit-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            -moz-box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
            box-shadow: 0 5px 8px -6px rgba(0,0,0,.2);
        }
        .notice-sm {
            padding: 10px;
            font-size: 80%;
        }
        .notice-lg {
            padding: 35px;
            font-size: large;
        }
        .notice-success {
            border-color: #80D651;
        }
        .notice-success>strong {
            color: #80D651;
        }
        .notice-info {
            border-color: #45ABCD;
        }
        .notice-info>strong {
            color: #45ABCD;
        }
        .notice-warning {
            border-color: #FEAF20;
        }
        .notice-warning>strong {
            color: #FEAF20;
        }
        .notice-danger {
            border-color: #d73814;
        }
        .notice-danger>strong {
            color: #d73814;
        }

        /*.first_w_upper_clss{
           
             text-transform: capitalize;
        }*/

        a{
            color:#0000f0;
        }


    </style>
@endsection
@section('right-content')

    <div class="row">


        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Employee Rating Entry Form
                    </label>
                </header>
                <div class="panel-body mainbodyrow">
                    <div class="form-horizontal">




                        @if(empty($user_infos))
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-danger">
                                    <span>
                                        You don't have supervisor assigned yet.Please Contact with the Department Head.
                                    </span>
                                    </div>
                                </div>
                            </div>

                        @endif

                        @if(!empty($user_infos))

                            <form method="post" id="frmempratingentry">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                        <b>Company Name:</b></label>
                                    <div class="col-md-4 col-sm-4 col-xs-6">

                                        <input type="text" readonly name="u_comp_name" id="u_comp_name_id" class="form-control input-sm" value="{{$user_infos[0]->company_name}}">
                                        <input type="hidden"  name="u_comp_code" id="u_comp_code_id" class="form-control input-sm" value="{{$user_infos[0]->company_code}}">
                                       <!--  <input type="hidden"  name="login_udesig" id="login_udesig_id" class="form-control input-sm" value="{{$login_moreinfo[0]->desig_name}}"> -->
                                          <input type="hidden"  name="login_udesig" id="login_udesig_id" class="form-control input-sm" value="{{$login_moreinfo[0]->design_nam_1st_upper}}">

                                    </div>

                                    <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                        <b>Dept Name:</b></label>
                                    <div class="col-md-3 col-sm-3 col-xs-6">

                                        <input type="text" readonly name="u_dept_name" id="u_dept_name_id" class="form-control input-sm" value="{{$user_infos[0]->dept_name}}">
                                        <input type="hidden"  name="u_dept_id" id="u_dept_id" class="form-control input-sm" value="{{$user_infos[0]->dept_id}}">
                                        <input type="hidden"  name="u_plant_id" id="u_plant_id" class="form-control input-sm" value="{{$user_infos[0]->plant_id}}">
                                        <input type="hidden"  name="u_plant_name" id="u_plant_name" class="form-control input-sm" value="{{$user_infos[0]->plant_name}}">
                                    </div>




                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                        <b>Emp Code/Name:</b></label>
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <select name="u_emp" id="u_emp_id" class="form-control input-sm">
                                            {{--<option disabled selected>Select Company Name</option>--}}
                                            @forelse($user_infos as $emp_name)
                                                <option value="{{$emp_name->emp_id}}" data-designame="{{$emp_name->desig_name}}" data-empname="{{$emp_name->emp_name}}" data-empid="{{$emp_name->emp_id}}">{{$emp_name->emp_id}} {{$emp_name->emp_name}}</option>

                                            @empty
                                                <option>No Data Found</option>
                                            @endforelse
                                            @if($hh=='notmatch')
                                                <option value="{{Auth::user()->user_id}}" data-empid="{{Auth::user()->user_id}}">{{Auth::user()->user_id}} {{Auth::user()->name}}</option>

                                            @endif
                                        </select>
                                        <input type="hidden" id="ownid" value="{{$hh}}">


                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-sm-offset-4 col-md-4 col-sm-4 col-xs-6" style="margin-left: 3.666667%;">
                                            <center>
                                                {{--<button type="submit" id="btn_display_u" class="btn btn-success btn-bg ladda-button" data-style="zoom-in">--}}
                                                    {{--<span class="ladda-label"><i class="fa fa-check"></i> <b>Submit</b></span> </button>--}}


                                                <button type="submit" class="btn btn-success btn-bg ladda-button" id="btn_display_u" data-style="zoom-in">
                                                    <span class="ladda-label"><i class=" fa fa-check"></i>  <b>Submit</b></span>
                                                </button>


                                                {{--<button type="submit" class="btn btn-success btn-bg ladda-button" id="btn_display_u" data-style="zoom-in">--}}
                                                    {{--<span class="ladda-label">--}}
                                                        {{--<i class=" fa fa-check"></i>--}}
                                                        {{--<b>Submit</b>--}}
                                                    {{--</span>--}}
                                                {{--</button>--}}

                                            </center>


                                        </div>
                                    </div>
                                </div>


                            </form>

                        @endif

                    </div>
                </div>
            </section>
        </div>

    </div>

    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 55px;padding-bottom: 55px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}" width="35px" height="35px"
                     alt="Loading Report Please wait..."><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-sm-12 notmatchmsg" style="display: none; margin-top: 12px;padding-bottom: 12px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <div class="alert alert-danger">
                                    <span>
                                        You don't have supervisor assigned yet.Please Contact with the Department Head.
                                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12" id="ratingContainer" style="display: none;">
            <section class="panel" id="data_table">

                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 table-responsive" id="search_div_id">
                                    <form method="post" id="frmevatuate">
                                        <table id='dvsr_data' class='table table-condensed table-striped table-bordered' width='100%'>
                                            <thead style='white-space:nowrap;' id="ihsearch1">

                                            </thead>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div display="none" class="col-md-12 col-sm-12" id="ratingnewdata">
                    </div>
                    <div class="col-md-12 col-sm-12" id="ratingtable">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 table-responsive">
                                    <table class="table table-condensed table-bordered table-striped" id="tabRating">
                                        <thead>
                                        <tr>
                                            <th colspan="2" style="text-align: center;">Competencies/Rating Criteria</th>
                                            <!-- <th>Poor</th> -->
                                            <th>Unable to Demonstrate</th>
                                            <th>To Be Developed</th>
                                            <th>Developing</th>
                                            <th>Well Developed</th>
                                            <th>Master</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ratingData">

                                        </tbody>
                                    </table>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-md-offset-5 col-md-6">
                                            {{--<button type="button" id="btnSave" class="btn btn-success"><i class=" fa fa-floppy-o"></i> Save</button>--}}
                                            <button type="button" class="btn btn-success ladda-button" id="btnSave" data-style="zoom-in">
                                                <span class="ladda-label"><i class=" fa fa-floppy-o"></i><span style="color:white;"> Save</span></span>
                                            </button>

                                            <button type="button" class="btn btn-success ladda-button" id="btnEdit" data-style="zoom-in">
                                                <span class="ladda-label"><i class=" fa fa-floppy-o"></i><span style="color:white;"> Save</span></span>
                                            </button>

                                            {{--<button type="button" id="btnNextRating" class="btn btn-primary"><i class=" fa fa-pencil"></i><span style="color:darkblue;font-weight:bold"> NextRating</span></button>--}}
                                            <button type="button" class="btn btn-primary ladda-button" id="btnNextRating" data-style="zoom-in">
                                                <span class="ladda-label"><i class="fa fa-pencil"></i><span style="color:white;"> NextRating </span></span>
                                            </button>


                                            <a href="{{URL::to('emp_comp/get_emprating_entry')}}">
                                                <button type="button" class="btn btn-primary ladda-button" id="btnExist">
                                                    <span style="color:black"><i class="fa fa-sign-out"></i><span style="color:white;"> Exist</span></span>
                                                </button>


                                            </a>

                                            <button type="button" class="btn btn-warning ladda-button" id="btnClear" data-style="zoom-in">
                                                <span class="ladda-label"><i class="fa fa-eraser"></i><span style="color:white;"> Clear</span></span>
                                            </button>
                                            {{--<button type="button" id="btnClear" class="btn btn-wrong"><i class="fa fa-eraser"></i> Clear</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    {{--var l = Ladda.create(document.querySelector('#btn_display_u'));--}}
    {{--l.start();--}}
    {{--l.stop();--}}
    <div class="overlay">
        <div id="loading-img"></div>
    </div>


    @include('expense.modal.edit_expense_verify_data')
    @include('expense.modal.remove_expense_verify_data')
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/jquery-dateFormat.min.js')}}
    <script src="{{url('public/site_resource/js/salert/sweetalert2.min.js')}}"></script>



    {{--<script src="{{url('public/site_resource/spinner-btn/spin.min.js')}}"></script>--}}
    {{--<script src="{{url('public/site_resource/spinner-btn/ladda.min.js')}}"></script>--}}

    <script src="{{url('public/site_resource/spinner-btn/spin.min.js')}}"></script>
    <script src="{{url('public/site_resource/spinner-btn/ladda.min.js')}}"></script>

   <!--  <script type="text/javascript">
         
    </script> -->





    <script type="text/javascript">


        $(document).ready(function() {

            var editor_text;

            var ecrm_id;
            var g_ecrm_id_done;
            var g_ecrm_id_done_super;
            var g_rating_date;

            var global_Nextstatus='no_nextRating';
            empinfo_arr = new Array();

            doneprevable_arr = new Array();
            doneprevable_arr_new= new Array();
            totalcheckedtr_arr = new Array();
            doneprevable_arr_userown=new Array();
            owncheckarr=new Array();

            var g_login_emp_id;
            var g_emp_id;

            //31.10

            var g_six_monthnow='not_sixmon';

            ////click on btn_display_u
            $(document).on('submit', '#frmempratingentry', function (event) {


                event.preventDefault();


                var l = Ladda.create(document.querySelector('#btn_display_u'));
                l.start();

                var ownid=$('#ownid').val();
                console.log(ownid);

                var selected = $('#u_emp_id option:selected');
                var empid = selected.data('empid');
                var g_emp_id=empid;

                $('.notmatchmsg').hide();
                if(ownid=='notmatch'&&empid=='{{Auth::user()->user_id}}'){

                    /////
//                    console.log("not match");
                    var marchmsg = " ";
                    marchmsg += '<div class="col-md-12 col-sm-12">';
                    marchmsg += '<div class="alert alert-danger">';
                    marchmsg += '<strong></strong> <span style="color: darkgreen"></span> You do not have supervisor assigned yet.Please Contact with the Depterment Head.';
                    marchmsg += '</div>';
                    marchmsg += '</div>';

                    $('#ratingtable').hide();

                    $('#ratingnewdata').hide();
                    $('#search_div_id').hide();
                    $('#ratingtable').hide();

//                    $('#ratingnewdata').show();

                    $('.notmatchmsg').show();


                    //////


                }else{




                $('#loader').show();


                var div = $(this).parent().parent().parent().parent().parent().parent();

                var form = $('#frmempratingentry');
                var formData = form.serialize();

                //submit button click

                var url = "{{URL::to('emp_comp/get_srch_rating_entry')}}";
                var type = 'post';

                var plant_id = $('#u_plant_id').val();


                var ser_comp_code = $('#u_comp_code_id').val();
                var ser_comp_name = $('#u_comp_name_id').val();


                var ser_dept_name = $('#u_dept_name_id').val();
                var ser_dept_code = $('#u_dept_id').val();



                var selected = $('#u_emp_id option:selected');
                var empid = selected.data('empid');
                var g_emp_id=empid;
;

                var empname = selected.data('empname');


                var designame = selected.data('designame');



                var plant_name = $('#u_plant_name').val();


                var login_emp_id = '{{Auth::user()->user_id}}';
                g_login_emp_id=login_emp_id;
                var login_emp_name = '{{Auth::user()->name}}';


                // 20.11.2018
                var login_emp_desig=$('#login_udesig_id').val();

                empinfo_arr = [];
                var hud = new Date();
                var month = hud.getMonth() + 1;
                var day = hud.getDate();



                var outputfinal = (month < 10 ? '0' : '') + month + '/' + (day < 10 ? '0' : '') + day + '/' + hud.getFullYear();

//                    console.log("outputfinal"+outputfinal);

                var arr_empinfo = {
                    'trrating_date': outputfinal,
                    'trcompanycode': ser_comp_code,
                    'trcompanyname': ser_comp_name,
                    'trplant_id': plant_id,
                    'trplant_name': plant_name,
                    'trempid': empid,
                    'trempname': empname,
                    'trdeptcode': ser_dept_code,
                    'trdeptname': ser_dept_name,
                    'trdesigname': designame,
                    'trcreateuserid': login_emp_id,
                    'trcreateusername': login_emp_name
                };

                empinfo_arr.push(arr_empinfo);

//                    console.log("ppp"+empinfo_arr[0]['trrating_date']);


                $.ajax({
                    type: type,
                    url: url,
                    data: formData,

                    success: function (value) {


                        if (value.olddata_superviser_ecrmid != 'no_prev_edit_id') {

                        }


                        ecrm_id = value.form_data[0]['ecrm_id'];


                        var selectedtwo = $('#u_emp_id option:selected');
                        var empidtwo = selectedtwo.data('empid');


                        if (value.form_data.length > 0 && value.cc_data.length > 0) {


                            if (value.previousvalue == 'no_prev') {

//                                console.log("fdgf fdgfsyu fdshf");

                                $('#btnNextRating').hide();

                                if (empid != login_emp_id) {


                                    

                                    /////
                                    var newDataview = " ";
                                    newDataview += '<div class="col-md-12 col-sm-12">';
                                        newDataview += '<div class="alert alert-danger">';
                                        newDataview += '<strong></strong> <span style="color: darkgreen"><b>' + empname + '</b></span> do not rating his/her rating yet. Please inform this person to rating first  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       <button class="btn btn-primary btn-md view_pg_div"> <span><i class="fa fa-envelope"> Click here to notify this employee</i></span></button><input type="hidden" id="selected_emp_mail_id" value="' + value.selected_emp_mail + '">';
                                        newDataview += '</div>';
                                    newDataview += '</div>';




                                    //mail part----


                                    newDataview += '<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 send_mail_div_area_tot" style="display:none">';
                                        newDataview += '<div class="send_mail_div_area" style="background-color:#ffffcc;">';
                                                newDataview += '<div class="form-group" style="padding:10px">';
                                                    newDataview += '<label for="to" class="control-label">Dear ' + empname + ',</label>';
                                                   


                                                    newDataview += '<textarea type="text" id="message_editor" class="form-control mailbodyid" name="message" rows="3" style="color:#101010;background: #ffffff !important;z-index: auto; position: relative; line-height: 20px; font-size: 14px;">';
                                                    newDataview += 'Self-assessment in employee competency portal is not yet to be done from your end. Would you please assess yourself by clicking the below link as early as possible.';
                                                    newDataview += '<br><br> <a href="http://web.inceptapharma.com:5031/misdashboard/emp_comp/get_emprating_entry">http://web.inceptapharma.com:5031/misdashboard/emp_comp/get_emprating_entry</a>';
                                                    // newDataview += '<br> <a>Click Here </a>';
                                                    newDataview += '</textarea>';
                                                     

                                                    newDataview += '<label for="to" class="control-label">Regards,<br>'+login_emp_name+'<br><span class="first_w_upper_clss">'+login_emp_desig+'</span></label>';
                                                newDataview += '</div>';
                                        newDataview += '</div>';

                                        newDataview += '<div class="col-md-8 col-md-offset-2 text-center">';

                                                newDataview += '<button type="button" class="btn btn-success btn-sm ladda-button final_sentmail" data-style="zoom-in">';
                                                newDataview += '<span style="color:white" class="ladda-label"><i class="fa fa-envelope"></i><b> Send Mail</b></span>';
                                                newDataview += '</button>';

                                        newDataview += '</div>';

                                    newDataview += '</div>';



// <button type="button" class="btn btn-success ladda-button" id="btnSave" data-style="zoom-in">
//                                                 <span class="ladda-label"><i class=" fa fa-floppy-o"></i><span style="color:white;"> Save</span></span>
//                                             </button>

                                    //mail part end----



//edit_ty
                                    $('#ratingtable').hide();
//editty

                                    $('#ratingnewdata').show();
                                    $('#search_div_id').hide();
                                    $('#ratingtable').hide();





                                    $('#ratingnewdata').empty().append(newDataview);

                                  
                                     ClassicEditor
                                    .create( document.querySelector( '#message_editor' ),{                                      
        
                                        toolbar: [ 
                                        'Heading','bold','italic', 'BulletedList', 'NumberedList','FontSize','TextColor',                                       
                                        'Underline','undo','Redo' 
                                        ]
                                    } )
                                    .then( editor => {

                                        editor_text=editor;


                                    } )                                   
                                    .catch( error => {
                                        console.error( error );
                                    } );








                                    // console.log(ClassicEditor.config);

                                    



                                    //////

                                }else if(empid == login_emp_id){
//                                    console.log("venes");


                                    $('#ratingnewdata').hide();
                                    $('#search_div_id').show();
                                    $('#ratingtable').show();





                                    console.log("lili");


                                    $('#btnEdit').hide();
                                    $('#btnSave').show();
                                    $('#btnExist').hide();
                                    $('#btnNextRating').hide();
                                    var tabData = '';
                                    var cnt = 1;
                                    var ii = 1;
                                    value.cc_data.forEach(function (cdata) {
                                        var ctg = cdata.ecompc;
                                        value.form_data.forEach(function (fdata) {
                                            if (cdata.ecompc == fdata.ecompc) {
                                                tabData += '<tr class="' + ii + '" data-deftr="' + ii + '">';
                                                if (ctg == fdata.ecompc) {
                                                    console.log("RED");
                                                    tabData += '<td > <input type="checkbox" class="optcheck finaluncked" name="' + fdata.ecompc + '" value="' + fdata.ecompc + '"> <input type="hidden" value="' + fdata.ecompc + '">' + fdata.ecompc + '</td>';
                                                }
                                                else {
                                                    tabData += '<td><input type="hidden" value="' + fdata.ecompc + '"><span></span></td>';
                                                }
                                                tabData += '<td ><input type="hidden" class="ecompc_desc" value="' + fdata.ecompc_desc + '">' + fdata.ecompc_desc + '</td>';
                                                tabData += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cnt + '[' + cnt + '][]' + '" value="1"></td>';
                                                tabData += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cnt + '[' + cnt + '][]' + '" value="2"></td>';
                                                tabData += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cnt + '[' + cnt + '][]' + '" value="3"></td>';
                                                tabData += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cnt + '[' + cnt + '][]' + '" value="4"></td>';
                                                tabData += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cnt + '[' + cnt + '][]' + '" value="5"></td>';
                                                tabData += '</tr>';
                                                ctg = '';
                                                cnt++;


                                            } else {
                                                console.log("do not match");
                                            }


                                        });
                                        ii++;
                                    });
                                    $('#ratingData').empty().append(tabData);
                                    ////

                                    //10march2018
                                    /////
                                    var newDataviewuu = " ";
                                    newDataviewuu += '<div class="col-md-12 col-sm-12 alert-view-modi">';
                                    newDataviewuu += '<div class="notice notice-danger" style="background-color: #ffffb3">';
                                    newDataviewuu += '<strong> <span style="color: darkblue"> Please Rate Any of the Five Categories of the following</span></strong>';
                                    newDataviewuu += '</div>';
                                    newDataviewuu += '</div>';

                                    $('#ratingnewdata').show();


                                    $('#ratingnewdata').empty().append(newDataviewuu);
                                    //10march2018
                                    ////

                                }

                            } else if (value.previousvalue == 'done_prev') {


                                // console.log("wanna find 6 months data"+value);  ///data have come here
// 

                                $('#ratingnewdata').hide();
                                $('#search_div_id').show();
                                $('#ratingtable').show();


                                $('#btnSave').hide();
                                $('#btnEdit').show();
                                $('#btnExist').hide();


                                g_rating_date=value.first_display_infos[0]['rating_date'];

//                                console.log("7.3.2019 done prev 12.3.2019");
//
//                                console.log("db master rating date");  ///data have come here
//
//                                console.log("db master rating date=============value");  ///data have come here
                                // console.log(value);
                                // console.log(g_rating_date);

                                // console.log("now day"+value.nmon);
                                // console.log("add day"+value);

                                //upto here


                                // console.log(value.add_month);


                                var total_diff_days=value.add_month;
//                                if(total_diff_days>=180){
                                //if rating period is 6 months then u can do next rating button



                                if(total_diff_days>=6){
//                                    console.log("yes u can show button");
                                    $('#btnNextRating').show();
                                    $('#btnExist').hide();
                                }else{

//                                    console.log("yes u can hide button 7.3.2019 12.3.2019");
                                    $('#btnNextRating').hide();
                                    $('#btnExist').hide();
                                }


                                var tabDatadone = '';
                                var cntdone = 1;
                                var iidone = 1;
                                var tku = 0;

                                doneprevable_arr = [];


                                doneprevable_arr_userown = [];

                                owncheckarr=[];

                                // console.log("value.first_display_infos[0]['ecrm_id'] "+value.first_display_infos[0]['ecrm_id']);//arse----


                                if (empid == login_emp_id){

//                                    console.log("empid == login_emp_id 12.3.2019"); //aslo submit-----------------


                                    g_ecrm_id_done=value.first_display_infos[0]['ecrm_id'];

                                    ///comment 12.11.2018---srat----

                                        /////////////////////////here checheking if emp id ===== login userid
                                        value.cc_data.forEach(function (cdatadone) {
                                            var ctgdone = cdatadone.ecompc;


                                            value.first_display_infos.forEach(function (fdatadone) {

                                                if (fdatadone.create_user_id == login_emp_id) {


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                    /////////////////////////////////////////////
                                                    if (cdatadone.ecompc.trim() == fdatadone.ecompc.trim()) {
                                                        tabDatadone += '<tr class="' + iidone + '" data-deftr="' + iidone + '">';
                                                        if (ctgdone.trim() == fdatadone.ecompc.trim()) {
                                                            console.log("heer 1");



                                                            if ((fdatadone.poor)||(fdatadone.to_be_developed)||(fdatadone.developing)||(fdatadone.well_developed)||(fdatadone.rmaster)){

                                                                tabDatadone += '<td > <input type="checkbox" checked class="optcheck finalcked" name="' + fdatadone.ecompc + '" value="' + fdatadone.ecompc + '"> <input type="hidden" value="' + fdatadone.ecompc + '">' + fdatadone.ecompc + '</td>';

                                                            }else{
//
                                                                tabDatadone += '<td > <input type="checkbox" class="optcheck finaluncked" name="' + fdatadone.ecompc + '" value="' + fdatadone.ecompc + '"> <input type="hidden" value="' + fdatadone.ecompc + '">' + fdatadone.ecompc + '</td>';

                                                            }

                                                           }
                                                        else {

                                                            tabDatadone += '<td><input type="hidden"   value="' + fdatadone.ecompc + '"><span></span></td>';
                                                        }
                                                        tabDatadone += '<td ><input type="hidden"  class="ecompc_desc" value="' + fdatadone.ecompc_desc + '">' + fdatadone.ecompc_desc + '</td>';

                                                        if (!(fdatadone.poor)) {

                                                            if (!(fdatadone.poor)&&!(fdatadone.to_be_developed)&&!(fdatadone.developing)&&!(fdatadone.well_developed)&& !(fdatadone.rmaster)){
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  class="insidechk"  disabled name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="1"></td>';
                                                            }else{
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="1"></td>';
                                                            }

                                                        }else {
                                                            tabDatadone += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="1"></td>';
                                                            var vv = 'cb' + cntdone + '[' + cntdone + '][]';
                                                            owncheckarr.push(vv);
                                                        }

                                                        if (!(fdatadone.to_be_developed)) {

                                                            if(!(fdatadone.poor)&&!(fdatadone.to_be_developed)&&!(fdatadone.developing)&&!(fdatadone.well_developed)&& !(fdatadone.rmaster)){
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  disabled class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="2"></td>';

                                                            }else{

                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="2"></td>';
                                                            }
                                                        } else {
                                                            tabDatadone += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="2"></td>';
                                                            var vv = 'cb' + cntdone + '[' + cntdone + '][]';
                                                            owncheckarr.push(vv);
                                                        }

                                                        if (!(fdatadone.developing)) {
                                                            if(!(fdatadone.poor)&&!(fdatadone.to_be_developed)&&!(fdatadone.developing)&&!(fdatadone.well_developed)&& !(fdatadone.rmaster)){
                                                                tabDatadone += '<td class="text-center"><input type="checkbox" disabled class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="3"></td>';

                                                            }else{
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="3"></td>';

                                                            }
                                                        } else {
                                                            tabDatadone += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="3"></td>';
                                                            var vv = 'cb' + cntdone + '[' + cntdone + '][]';
                                                            owncheckarr.push(vv);
                                                        }

                                                        if (!(fdatadone.well_developed)) {
                                                            if(!(fdatadone.poor)&&!(fdatadone.to_be_developed)&&!(fdatadone.developing)&&!(fdatadone.well_developed)&& !(fdatadone.rmaster)) {
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  disabled class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="4"></td>';

                                                            }else{
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="4"></td>';

                                                            }
                                                        } else {
                                                            tabDatadone += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="4"></td>';
                                                            var vv = 'cb' + cntdone + '[' + cntdone + '][]';
                                                            owncheckarr.push(vv);
                                                        }

                                                        if (!(fdatadone.rmaster)) {
                                                            if(!(fdatadone.poor)&&!(fdatadone.to_be_developed)&&!(fdatadone.developing)&&!(fdatadone.well_developed)&& !(fdatadone.rmaster)) {
                                                                tabDatadone += '<td class="text-center"><input type="checkbox" disabled class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="5"></td>';

                                                            }else{
                                                                tabDatadone += '<td class="text-center"><input type="checkbox"  class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="5"></td>';

                                                            }

                                                        } else {
                                                            tabDatadone += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk"  name="' + 'cb' + cntdone + '[' + cntdone + '][]' + '" value="5"></td>';
                                                            var vv = 'cb' + cntdone + '[' + cntdone + '][]';
                                                            owncheckarr.push(vv);
                                                        }



                                                        tabDatadone += '</tr>';
                                                        ctgdone = '';
                                                        cntdone++;


                                                    } else {

                                                    }
                                                    //////////////////////////////////////////////

                                                    ///////////////////////////////////////////////////////////////////
                                                }

                                            });
                                            iidone++;


                                        });

                                        $('#ratingData').empty().append(tabDatadone);


                                        //userown

                                    console.log("solvng 13.3.2019");
                                        for ($rr = 0; $rr < owncheckarr.length; $rr++) {

                                            var vv = owncheckarr[$rr];


                                            $("#tabRating tbody#ratingData tr input:checkbox[name='" + vv + "']").each(function () {

                                                $(this).parent().parent().css('background-color', '#bee4ea');

                                                if($(this).parent().parent().find('.finalcked')){

                                                    $(this).parent().parent().find('.finalcked').parent().parent().addClass('finalckedtr');
                                                }


                                            });
                                        }

                                        //userown


                                        //append the data view


                                        /////////////////////////////////////////////end here checking if emp id ======login userid
//                                    }
                                    ///comment 12.11.2018---end----
                                } else if (empid != login_emp_id) {
                                    /////////////////////////////////////////////end here checking if emp id NOT EQUAL login userid



                                    if (value.superedit_or_not == 'newdata_superviser') {


                                        var newDataview = " ";
                                        newDataview += '<div class="col-md-6 col-sm-6">';
                                        newDataview += '<div class="alert alert-danger">';
                                        newDataview += '<strong></strong> You do not rate  <span style="color: darkgreen">' + empname + '</span> before ,To rating please click the beside button';
                                        newDataview += '</div>';
                                        newDataview += '</div>';
                                        newDataview += '<div class="col-md-6 col-sm-6">';
                                        newDataview += '<button type="button" id="newratebtnsuper" class="btn btn-primary btn-lg">Create Rating</button>';
                                        newDataview += '</div>';

                                        $('#ratingnewdata').show();
                                        $('#search_div_id').hide();
                                        $('#ratingtable').hide();

                                        $('#ratingnewdata').empty().append(newDataview);


                                    } else if (value.superedit_or_not == 'olddata_superviser') {

                                        console.log("olddata_superviser");//upto

                                        $('#search_div_id').show();
                                        $('#ratingnewdata').show();


                                        $('#ratingtable').hide();


                                        if (value.editsuperecrm_id != 'no_ecrm_idforedit') {


                                            g_ecrm_id_done_super=value.editsuperecrm_id;


                                            $.ajax({
                                                type: 'get',
                                                url: '{!! URL::to('emp_comp/getolderEditdata') !!}',
                                                data:{editolde_ecrmid:value.editsuperecrm_id},
                                                success: function (newrate) {


                                                    /////////////////////////////////kela view//////////////////////////
                                                    ////////////////////////////////////////////////////////////////////////////////////////////Hellow its a new area//////////////////////////


                                                    var tabDatanewrate = '';
                                                    var cntnewrate = 1;
                                                    var iinewrate = 1;

                                                    doneprevable_arr_new = [];

                                                    /////////////////////////here checheking if emp id ===== login userid
                                                    newrate.cc_datanewrate.forEach(function (cdatanewrate) {
                                                        var ctgnewrate = cdatanewrate.ecompc;

                                                        newrate.first_display_infos.forEach(function (fdatanewrate) {


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                            /////////////////////////////////////////////
                                                            if (cdatanewrate.ecompc.trim() == fdatanewrate.ecompc.trim()) {
                                                                tabDatanewrate += '<tr class="' + iinewrate + '" data-deftr="' + iinewrate + '">';
                                                                if (ctgnewrate.trim() == fdatanewrate.ecompc.trim()) {
                                                                    tabDatanewrate += '<td ><input type="hidden" value="' + fdatanewrate.ecompc + '">' + fdatanewrate.ecompc + '</td>';

                                                                    $(this).css('background-color', '#f8d7da');
                                                                }
                                                                else {
                                                                    tabDatanewrate += '<td><input type="hidden" value="' + fdatanewrate.ecompc + '"><span></span></td>';
                                                                }
                                                                tabDatanewrate += '<td ><input type="hidden" class="ecompc_desc" value="' + fdatanewrate.ecompc_desc + '">' + fdatanewrate.ecompc_desc + '</td>';

                                                                if (!(fdatanewrate.poor)) {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="1"></td>';
                                                                } else {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="1"></td>';

                                                                    var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';

                                                                    doneprevable_arr_new.push(vv);


                                                                }

                                                                if (!(fdatanewrate.to_be_developed)) {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="2"></td>';
                                                                } else {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="2"></td>';
                                                                    var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';

                                                                    doneprevable_arr_new.push(vv);

                                                                }

                                                                if (!(fdatanewrate.developing)) {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="3"></td>';
                                                                } else {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="3"></td>';
                                                                    var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';

                                                                    doneprevable_arr_new.push(vv);

                                                                }

                                                                if (!(fdatanewrate.well_developed)) {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="4"></td>';
                                                                } else {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="4"></td>';
                                                                    var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';

                                                                    doneprevable_arr_new.push(vv);

                                                                }

                                                                if (!(fdatanewrate.rmaster)) {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="5"></td>';
                                                                } else {
                                                                    tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="5"></td>';
                                                                    var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';

                                                                    doneprevable_arr_new.push(vv);

                                                                }


                                                                                         tabDatanewrate += '</tr>';
                                                                ctgnewrate = '';
                                                                cntnewrate++;


                                                            } else {

                                                            }
                                                            //////////////////////////////////////////////

                                                            ///////////////////////////////////////////////////////////////////
//                                    }

                                                        });
                                                        iinewrate++;


                                                    });


                                                    $('#ratingnewdata').hide();
                                                    $('#ratingtable').show();

                                                    $('#ratingData').empty().append(tabDatanewrate);

                                                    for ($rr = 0; $rr < doneprevable_arr_new.length; $rr++) {

                                                        var vv = doneprevable_arr_new[$rr];

                                                        $("#tabRating tbody#ratingData tr input:checkbox[name='" + vv + "']").each(function () {

                                                            $(this).attr('disabled', false);
                                                            $(this).parent().parent().css('background-color', '#DEF3CA');
                                                            $(this).parent().parent().addClass('finalcheckedit');

//
                                                        });
                                                    }

                                                    /////////////////////////////////////////////////////kela view//////////////////////////
                                                },
                                                error: function (data) {
//                                                    console.log("fifi l");
                                                }
                                            });
                                        } else {
                                            console.log("older emp_id for edit hello mewkk");
                                        }

                                    }
                                }


                            }


//                            console.log(value.first_display_infos);
                            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];

                            var d = new Date();
                            var curr_half_yr = d.getFullYear().toString().substr(-2);
                            var rating_month = monthNames[d.getMonth()] + '-' + curr_half_yr;




                            var viewdata = " ";

                            viewdata += "<tr>";
                            viewdata += "<th colspan='3'>Rating Month: <span style='font-size: 11px;color:#885151'>" + rating_month + "</span></th>";
                            viewdata += "<th colspan='3'>Company Name: <span style='font-size: 11px;color:#885151'>" + ser_comp_name + "</span></th>";
                            viewdata += "<th colspan='3' bgcolor='#C4D79B'><center>Assesor</center></th>";
                            viewdata += "</tr>";

                            viewdata += "<tr>";
                            viewdata += "<th colspan='3'>Name: <span style='font-size: 11px;color:#885151'>" + empname + "</span></th>";
                            viewdata += "<th colspan='1'>Designation: <span style='font-size: 11px;color:#885151'>" + designame + "</span></th>";
                            viewdata += "<th colspan='2'>Plant Name: <span style='font-size: 11px;color:#885151'>" + plant_name + "</span></th>";
                            viewdata += "<th colspan='3' bgcolor='#C4D79B' >Assesor`s Name: <span style='font-size: 11px;color:#885151'>" + login_emp_name + "</span></th>";
                            viewdata += "</tr>";

                            viewdata += "<tr>";
                            viewdata += "<th colspan='3'>Employee Code:<span style='font-size: 11px;color:#885151'>" + empid + "</span></th>";
                            viewdata += "<th colspan='1'>Department: <span style='font-size: 11px;color:#885151'>" + ser_dept_name + "</span></th>";
                            viewdata += "<th colspan='2'>Plant ID:<span style='font-size: 11px;color:#885151'>" + plant_id + "</span></th>";
                            viewdata += "<th colspan='3' bgcolor='#C4D79B' >Employee Code:<span style='font-size: 11px;color:#885151'>" + login_emp_id + "</span></th>";
                            viewdata += "</tr>";

                            $('#ihsearch1').empty().append(viewdata);


                            $('#ratingContainer').show();
                            $('#loader').hide();
                        } else {
                            console.log("empty re vai empty");
                        }

                        //submit l.start();
                        l.stop();
                    },
                    error: function () {
                        console.log("wrong");
                        l.stop();
                    }
                });



                }//notmatch

                l.stop();
            });

            ////////////////////end of click on btn_display_u

             ////mail part///////////////////////////////////////////////////////////////////////////////////////////


            $(document).on('click', '.view_pg_div', function () {


                var sel_emp_mail=$('#selected_emp_mail_id').val();

                if(sel_emp_mail=='null'){
//                    console.log("empty");
                    swal(
                            'Warning...',
                            'This employees mail is not assigned'
                    )
                }else{
//                    console.log("notempty");
                    $('.send_mail_div_area_tot').show();
                }




            });


                //when click to send mail

            $(document).on('click', '.final_sentmail', function () {


                var selected_m = $('#u_emp_id option:selected');
                var empid_m = selected_m.data('empid');

                var login_emp_id = '{{Auth::user()->user_id}}';


                 let bodymail = editor_text.getData();


                var l = Ladda.create(document.querySelector('.final_sentmail'));
                l.start();


                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('emp_comp/notiEmpByMail')!!}',
                    data:{
                        selectempid:empid_m,
                        bodymail:bodymail
                    },
                    success:function(data) {



                        toastr["success"]("Successfully Send mail")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "timeOut": "0",
                            "extendedTimeOut": "0"
                        }


                        l.stop();
                    },
                    error: function (data) {
                        toastr.error("Error!Please send mail again",{
                            "timeOut": "0",
                            "extendedTImeout": "0"
                        });
                        l.stop();
                    }
                });
            });

            //////////////////////////////////////////mail part end//////////////////////////////////////////////////////////


            ////click on next rating
            $(document).on('click','#btnNextRating',function(){

                console.log("hmm now next rating click");

                var selected = $('#u_emp_id option:selected');
                var empid = selected.data('empid');
                var login_emp_id = '{{Auth::user()->user_id}}';


                if(empid==login_emp_id){
                    // console.log("hmm now next rating click iiiiiiiiiiiiii empid==login_emp_id");
                    // console.log(g_ecrm_id_done);
                }else if(empid!=login_emp_id){
                    // console.log("hmm now next rating click iiiiiiiiiiiiii empid!=login_emp_id");
                    // console.log(g_ecrm_id_done_super);
                    g_ecrm_id_done=g_ecrm_id_done_super;
                }




                var ser_comp_code = $('#u_comp_code_id').val();


                var selected = $('#u_emp_id option:selected');
                var empid = selected.data('empid');
                var g_emp_id=empid;


                global_Nextstatus='NextRatingforsave';


                var l = Ladda.create(document.querySelector('#btnNextRating'));
                l.start();

            $.ajax({
                    method:'get',
                    url:"{{URL::to('emp_comp/getNextRate')}}",
                    data:{ecrm_id:g_ecrm_id_done,u_comp_code:ser_comp_code,u_emp:empid},
                    success:function(value){

                        console.log("next1----------rating");
                        // console.log(value);

                        var selected = $('#u_emp_id option:selected');
                        var empid = selected.data('empid');
                        var g_emp_id=empid;
                        var login_emp_id='{{ Auth::user()->user_id }}';

                        //////////////////////////////////////next rate next page///////////////////////////////////////////////
//                        if (empid == login_emp_id) { //offf 7.11.2018

                            // console.log("next2=======================");
                            $('#btnSave').hide();
                            $('#btnEdit').show();

                            $('#btnNextRating').hide();
                            $('#btnExist').show();

                            var tabDatadonenextrate = '';
                            var cntdonenextrate = 1;
                            var iidonenextrate = 1;
                            var tkunextrate = 0;
//
                            doneprevable_arrnextrate = [];
                            doneprevable_arr_userownnextrate = [];
                            owncheckarrnextrate = [];


                            g_ecrm_id_donenextrate = value.first_display_infos[0]['ecrm_id'];

                            /////////////////////////here checheking if emp id ===== login userid
                            // if (fdatadone.create_user_id == login_emp_id) {  this line actually remove redundancy
//                            if (fdatadone.create_user_id == login_emp_id) {
                            value.cc_data.forEach(function (cdatadone) {
                                var ctgdonenextrate = cdatadone.ecompc;

                                //                                    console.log(value.first_display_infos);
                                value.first_display_infos.forEach(function (fdatadone) {

                                    // 24.11.2018-----------------------------------

                                    // if (fdatadone.create_user_id == login_emp_id) {
                                    if (fdatadone.create_user_id == empid) {


                                        //                                                    console.log("hello kitty3");
                                        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        /////////////////////////////////////////////
                                        if (cdatadone.ecompc.trim() == fdatadone.ecompc.trim()) {
                                            tabDatadonenextrate += '<tr class="' + iidonenextrate + '" data-deftr="' + iidonenextrate + '">';
                                            if (ctgdonenextrate.trim() == fdatadone.ecompc.trim()) {
                                                tabDatadonenextrate += '<td > <input type="checkbox" class="optcheck finaluncked" name="' + fdatadone.ecompc + '" value="' + fdatadone.ecompc + '"> <input type="hidden" value="' + fdatadone.ecompc + '">' + fdatadone.ecompc + '</td>';
                                            }
                                            else {
                                                tabDatadonenextrate += '<td><input type="hidden" value="' + fdatadone.ecompc + '"><span></span></td>';
                                            }
                                            tabDatadonenextrate += '<td ><input type="hidden" class="ecompc_desc" value="' + fdatadone.ecompc_desc + '">' + fdatadone.ecompc_desc + '</td>';

                                            if (!(fdatadone.poor)) {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="1"></td>';
                                            } else {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="1"></td>';
                                                var vv = 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]';
                                                owncheckarrnextrate.push(vv);
                                            }

                                            if (!(fdatadone.to_be_developed)) {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="2"></td>';
                                            } else {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="2"></td>';
                                                var vv = 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]';
                                                owncheckarrnextrate.push(vv);
                                            }

                                            if (!(fdatadone.developing)) {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="3"></td>';
                                            } else {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="3"></td>';
                                                var vv = 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]';
                                                owncheckarrnextrate.push(vv);
                                            }

                                            if (!(fdatadone.well_developed)) {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="4"></td>';
                                            } else {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="4"></td>';
                                                var vv = 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]';
                                                owncheckarrnextrate.push(vv);
                                            }

                                            if (!(fdatadone.rmaster)) {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="5"></td>';
                                            } else {
                                                tabDatadonenextrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]' + '" value="5"></td>';
                                                var vv = 'cb' + cntdonenextrate + '[' + cntdonenextrate + '][]';
                                                owncheckarrnextrate.push(vv);
                                            }

                                            tabDatadonenextrate += '</tr>';
                                            ctgdonenextrate = '';
                                            cntdonenextrate++;


                                        } else {

                                        }
                                        //////////////////////////////////////////////

                                        ///////////////////////////////////////////////////////////////////
                                    }

                                });
                                iidonenextrate++;
                                //                                        console.log(tabData);

                            });
//                            }//end if

                            g_six_monthnow='six_monthnow';

                            $('#ratingData').empty().append(tabDatadonenextrate);

                            // console.log(owncheckarrnextrate.length);


                            //userown
                            for ($rr = 0; $rr < owncheckarrnextrate.length; $rr++) {

                                var vv = owncheckarrnextrate[$rr];

                                $("#tabRating tbody#ratingData tr input:checkbox[name='" + vv + "']").each(function () {

                                    // console.log("killty pitty");

                                    $(this).parent().parent().css('background-color','#bbdad7');
//                                    $(this).parent().parent().css('background-color', '#DEF3CA');
//                                    $(this).parent().parent().addClass('finalcheckedit');

                                });
                            }

                            //userown


                            //append the data view


                            /////////////////////////////////////////////end here checking if emp id ======login userid

//                        }  //offf 7.11.2018

                        // ////////////////////////////////////////////////////////////////////////////////

                        l.stop();
                    },
                    error:function(data){
                        console.log("error");
                    }
                });//end of Ajax of nextrating

            });

            ////////////////////end of click on next rating





/////////////////////////////////////////supervisior new rate///////////////////////////////


            $(document).on('click', '#newratebtnsuper', function () {
                console.log('oppcv');
//                console.log(empinfo_arr);

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('emp_comp/newratesupervisor') !!}',
                    data: {empinfo_arr: empinfo_arr},
                    success: function (newrate) {


                        ////////////////////////////////////////////////////////////////////////////////////////////Hellow its a new area//////////////////////////

//                        console.log("hello u here new rate start by supervisor");
                        var tabDatanewrate = '';
                        var cntnewrate = 1;
                        var iinewrate = 1;

                        doneprevable_arr = [];
                        totalcheckedtr_arr = [];

//                            console.log("hello kitty");
                        /////////////////////////here checheking if emp id ===== login userid
                        newrate.cc_datanewrate.forEach(function (cdatanewrate) {
                            var ctgnewrate = cdatanewrate.ecompc;

                            newrate.first_display_infos.forEach(function (fdatanewrate) {


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                /////////////////////////////////////////////
                                if (cdatanewrate.ecompc.trim() == fdatanewrate.ecompc.trim()) {
                                    tabDatanewrate += '<tr class="' + iinewrate + '" data-deftr="' + iinewrate + '">';
                                    if (ctgnewrate.trim() == fdatanewrate.ecompc.trim()) {
                                        tabDatanewrate += '<td ><input type="hidden" value="' + fdatanewrate.ecompc + '">' + fdatanewrate.ecompc + '</td>';
                                        // $(this).css('background-color', 'red');
                                         $(this).css('background-color', '#f8d7da');
                                       
                                    }
                                    else {
                                        tabDatanewrate += '<td><input type="hidden" value="' + fdatanewrate.ecompc + '"><span></span></td>';
                                    }
                                    tabDatanewrate += '<td ><input type="hidden" class="ecompc_desc" value="' + fdatanewrate.ecompc_desc + '">' + fdatanewrate.ecompc_desc + '</td>';

                                    if (!(fdatanewrate.poor)) {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="1"></td>';
                                    } else {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="1"></td>';

                                        var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';
                                        var cncn = cntnewrate;
                                        totalcheckedtr_arr.push(cncn);
                                        doneprevable_arr.push(vv);


                                    }

                                    if (!(fdatanewrate.to_be_developed)) {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="2"></td>';
                                    } else {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="2"></td>';
                                        var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';
                                        var cncn = cntnewrate;
                                        totalcheckedtr_arr.push(cncn);
                                        doneprevable_arr.push(vv);
//                                                trbordertop.push(cntnewrate);
                                    }

                                    if (!(fdatanewrate.developing)) {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="3"></td>';
                                    } else {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="3"></td>';
                                        var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';
                                        var cncn = cntnewrate;
                                        totalcheckedtr_arr.push(cncn);
                                        doneprevable_arr.push(vv);

                                    }

                                    if (!(fdatanewrate.well_developed)) {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="4"></td>';
                                    } else {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="4"></td>';
                                        var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';
                                        var cncn = cntnewrate;
                                        totalcheckedtr_arr.push(cncn);
                                        doneprevable_arr.push(vv);

                                    }

                                    if (!(fdatanewrate.rmaster)) {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="5"></td>';
                                    } else {
                                        tabDatanewrate += '<td class="text-center"><input type="checkbox"  checked="true" class="insidechk" disabled name="' + 'cb' + cntnewrate + '[' + cntnewrate + '][]' + '" value="5"></td>';
                                        var vv = 'cb' + cntnewrate + '[' + cntnewrate + '][]';
                                        var cncn = cntnewrate;
                                        totalcheckedtr_arr.push(cncn);
                                        doneprevable_arr.push(vv);

                                    }



                                    tabDatanewrate += '</tr>';
                                    ctgnewrate = '';
                                    cntnewrate++;


                                } else {

                                }
                                //////////////////////////////////////////////

                                ///////////////////////////////////////////////////////////////////
//                                    }

                            });
                            iinewrate++;

                        });
                        // console.log("tabData append data");

                        $('#ratingnewdata').hide();
                        $('#search_div_id').show();
                        $('#ratingtable').show();
                        $('#ratingData').empty().append(tabDatanewrate);

                        for ($rr = 0; $rr < doneprevable_arr.length; $rr++) {

                            var vv = doneprevable_arr[$rr];

                            $("#tabRating tbody#ratingData tr input:checkbox[name='" + vv + "']").each(function () {
                                // console.log("lili jiki");

                                $(this).attr('disabled', false);
                                $(this).parent().parent().css('background-color', '#DEF3CA');
                                $(this).parent().parent().addClass('finalcheckedit');


                            });
                        }




                        /////////////////////////////////////////////////////////////////////////////////////////////////////////hellow end here mnew area///////
                    },
                    error: function (value) {
                        console.log('error');

                    }
                });


            });

            ///////////////////////////////////supervisor new rate///////////////////////

            $(document).on('submit', '#frmevatuate', function (event) {
                event.preventDefault();

            });


            var div_tr_name;
            var g_count_tr = 0;
            var six_tr = 0;
            $(document).on('click', 'input:checkbox.insidechk', function () {
                var _cb = $(this);

                if (_cb.is(":checked")) {
                    var group = "input:checkbox[name='" + _cb.attr("name") + "']";
                    $(group).prop("checked", false);
                    _cb.prop("checked", true);
                } else {
                    _cb.prop("checked", false);
                }
            });


            $(document).on('click', 'input:checkbox.finaluncked', function () {

                console.log("yellow");

                $(this).removeClass("finaluncked").addClass("finalcked");
                $(this).parent().parent().removeClass("finalunckedtr").addClass("finalckedtr");

                six_tr = check_categoriessize();

                g_count_tr++;

                if (six_tr > 5) {

                    $(this).prop("checked", false);

                    // console.log("if checkkk "+global_Nextstatus);

                    if(global_Nextstatus=='NextRatingforsave') {
                        console.log("yellow < 5");
                    }else{
                        $(this).removeClass("finalcked").addClass("finaluncked ");

                    }
                    $(this).parent().parent().removeClass("finalckedtr").addClass("finalunckedtr");
                    swal(
                            'Warning...',
                            'You have already checked Five Categories.To select new option,please uncheck any of selected checkbox'
                    )

                } else {

                    var divv = $(this).parent().parent();
                    div_tr_name = divv.data('deftr');
                    var div_td = divv.find(("td input[name]")).val();
                    find_areatr(div_tr_name);
                }

            });

            $(document).on('click', 'input:checkbox.finalcked', function () {

                console.log("checking 13.3.2019 finalcked");

                console.log("checking 13.3.2019 six_tr"+six_tr);
                six_tr--;


                $(this).removeClass("finalcked").addClass("finaluncked ");
                $(this).parent().parent().removeClass("finalckedtr").addClass("finalunckedtr");
                g_count_tr--;


                var divv = $(this).parent().parent();
                div_tr_name = divv.data('deftr');
                var div_td = divv.find(("td input[name]")).val();
                find_areatr_uncheck(div_tr_name);
            });
            //globally define
            s_evalu_arr = new Array();
            s_evalu_arrrating = new Array();


            function find_areatr(div_tr_name) {
                var tr_class_name = div_tr_name;
                $('#tabRating tbody#ratingData tr.' + div_tr_name).each(function (index, element) {
                    $(this).find('.insidechk').removeAttr("disabled");
                    $(this).css('background-color', '#DEF3CA');

                });
            }

            //end of clear
            function find_areatr_uncheck(div_tr_name) {
                var tr_class_name = div_tr_name;

                $('#tabRating tbody#ratingData tr.' + div_tr_name).each(function (index, element) {

                    $(this).find('.insidechk').attr("disabled", true);
                    $(this).find('.insidechk').attr('checked', false);
                    s_evalu_arr = [];
                    $(this).css('background-color','white');

                });
            }

            function check_categoriessize() {
                $i = 0;
                $('#tabRating tbody#ratingData tr td input.finalcked').each(function (index, element) {
                    $i++;
                });

                return $i;

            }

            var kk;
            var totallyemp;

            ///--------------------data save-----------------after click on save button---------------------------------------------------------
            $('#btnSave').click(function () {


                // alert("six_tr"+six_tr);
                console.log("six_tr 6.3.2019"+six_tr)
//20.09.20188888888888
                if (six_tr < 5) {

                    console.log("what happen here 6.3.2019 "+six_tr < 5);
                    swal(
                            'Please Select Five Categories'
                    )
                } else {


                    kk = 0;

                    $('#tabRating tbody tr.finalckedtr').each(function (index, element) {
                        var classnametr = this.className.split('')[0];

                        $('#tabRating tbody tr.' + classnametr).each(function (index, element) {


                            console.log("findcheck tyt");
                            console.log("getting error here 3.6.2019");
                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                            console.log("findcheck");

                            } else {
                                kk = 1;
//                            console.log(kk);

                                return false;
                            }
                        });
                    });


//                    console.log(kk);
                    if (kk == 0) {

                        ///////////////////////////////////
                        //i write or define this here 6.3.2019
                        totallyemp = 'empty';

                        $('#tabRating tbody tr').each(function (index, element) {

                            var classnametr = this.className.split('')[0];


                            //19.09.2018
                            if (classnametr == 1) {
                                ecompc = 'LEADERSHIP';
                            } else if (classnametr == 2) {
                                ecompc = 'STRATEGIC THINKING';
                            } else if (classnametr == 3) {
                                ecompc = 'INNOVATION';
                            } else if (classnametr == 4) {
                                ecompc = 'TEAM-WORK ABILITY';
                            } else if (classnametr == 5) {
                                ecompc = 'ENTREPRENEURIAL MINDSET';
                            } else if (classnametr == 6) {
                                ecompc = 'COMMUNICATION';
                            } else if (classnametr == 7) {
                                ecompc = 'LIVING THE VALUES OF THE COMPANY';
                            } else if (classnametr == 8) {
                                ecompc = 'CUSTOMER CENTRICITY';
                            }



                            var ecompc_desc = $(this).find('.ecompc_desc').val();

                            console.log(" totallyemp 6.3.2018 assign 1 "+totallyemp);
                            console.log(" $(this).find('.insidechk:checkbox:checked').length "+$(this).find('.insidechk:checkbox:checked').length);

                            //i comment this below comment and write ---6.3.2019
                            // totallyemp = 'empty';

                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                var tr_checked_val = $(this).find('.insidechk:checkbox:checked').val();
                                totallyemp = 'notempty';

                                console.log(" 6.3.2019 if inside");
                                console.log(" totallyemp 6.3.2018 assign 2 "+totallyemp);

                            }else{
                                var tr_checked_val = 'nocheck';
//                                $(this).css('background-color','red');
                            }

                            console.log(" totallyemp 6.3.2018 assign 3 "+totallyemp);


                            var arr_new = {
                                'trecrm_id': ecrm_id,
                                'trecompc': ecompc,
                                'trecompc_desc': ecompc_desc,
                                'trevaluation_val': tr_checked_val
                            };

                            s_evalu_arr.push(arr_new);


                        });
                        ////////////////////////////////////////


                        /////////////////////////////////////////////

                        console.log(" totallyemp 6.3.2018 here finally"+totallyemp);

                        if (totallyemp == 'notempty') {
                            ///////////////////////here its go to url for save//////////////

                    console.log("gfgsf 6.3.2019 "+s_evalu_arr);
                    console.log("gfgsf 6.3.2019 "+s_evalu_arr.length);
                            if (s_evalu_arr.length > 0) {

                                ///i just uncomment ajax .......

                                //after click loading start
                                console.log(" s_evalu_arr.length > 0 6.3.2019");
                                var l = Ladda.create(document.querySelector('#btnSave'));
                                l.start();
                                $('#overlay').show();


                                $.ajax({
                                method: 'post',
                                url: '{!! URL::to('emp_comp/empinsert') !!}',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    s_evalu_arr: s_evalu_arr,
                                    empinfo_arr: empinfo_arr,
                                    global_Nextstatus:global_Nextstatus
                                },
                                success: function (data) {

                                    // console.log("insert save data  "+data.ttuu);
                                    // console.log("fdf fdf : "+data.employeeedate);

                                    //2020-02-09


                                    l.stop();
                                    $('#overlay').hide();

                                    $('#btnSave').hide();
                                $('#btnEdit').show();



                                    ///to stop the error

                                    $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                        // console.log("pass red err 1");

//                            kk_lenrating = kk_lenrating + 1;
                                        var classnametrrating = this.className.split('')[0];
                                        // console.log("classnametrrating--" + classnametrrating);

                                        $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                            // console.log("findcheck tyt classnametrrating");
                                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                // console.log("findcheck1111111111111classnametrrating");
                                                $(this).css('background-color',"#def3ca");


                                            } else {
//                                    kk_len_error2rating = 1;
                                                // console.log("1111111111111111111classnametrrating");
                                                // $(this).css('background-color', 'red');
                                                $(this).css('background-color', '#f8d7da');

//                                    return false;
                                            }//endif
                                        });
                                    });

                                    ///to stop the error

                                toastr["success"]("Successfully Done")
                                toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": false,
                                "positionClass": "toast-top-center",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "10000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                                }

                                },
                                error: function (value) {
                                console.log('error');
                                    l.stop();
                                    $('#overlay').hide();
                                }
                                });
                            } else {
                                s_evalu_arr = [];

                                swal(
                                        "you don't Select any category"
                                )
                            }
                            ////////////////////////////
                        } else {

                            console.log("6.3.2019 error msg 1");
                            swal(
                                    'Please Select Five Categories'
                            )


                        }


                        /////////////////////////////////////
                    } else if (kk == 1) {




                        swal(
                                'Error',
                                'Please check all the categories that you select'
                        )

                        console.log("loggggggggggggggggggg here");

//////////////////////////////////////////red error brnsave////////////////////////////////////////
                        //finalcheckedit  finalcheckedit
                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                            console.log("pass red err 1");

//                            kk_lenrating = kk_lenrating + 1;
                            var classnametrrating = this.className.split('')[0];
                            // console.log("classnametrrating--" + classnametrrating);

                            $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                // console.log("findcheck tyt classnametrrating");
                                if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                    console.log("findcheck1111111111111classnametrrating");
                                    $(this).css('background-color',"#def3ca");


                                } else {
//                                    kk_len_error2rating = 1;
                                    // console.log("1111111111111111111classnametrrating");
                                    // $(this).css('background-color', 'red');
                                    $(this).css('background-color', '#f8d7da');

//                                    return false;
                                }//endif
                            });
                        });






                        //////////////////////////////////////////red error brnsave////////////////////////////////////////
                    }


                    //or can send as form stringify


                    s_evalu_arr = [];

                }//end of else
                s_evalu_arr = [];
//                empinfo_arr=[];
            }); //end btnSave
            var empstatus;


            ///-------------------------------------after click on edit button---------------------------------------------------------

            var ResultArr=[];
            var ResultArrRating=[];
            function unique(list) {
                var result = [];
                $.each(list, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }

            var g_legn_length;

            //update-----------------------------------------------------

            var ggcount;

            $('#btnEdit').click(function () {


                // console.log(g_six_monthnow);

                // console.log("edit button click");  //nr e upto this
                ResultArr=[];
                ResultArrRating=[];

                var result;

                var result2,result_five;

                    if(global_Nextstatus=='NextRatingforsave') {


                        var ddresult;


                        $('#tabRating tbody tr').each(function (index, element) {

                            $(this).css('background-color'," ");
                            if ($(this).hasClass('finalckedtr')) {
                                ddresult = 'pass';
                                //ekhane test korte hobe
                            } else {
                                ggcount=ggcount+1;
                                ddresult = 'fail';
                                console.log("what msg: " + result);
                                return false;
                            }

                        });

//                        alert(ddresult);



                        //////
                        var rat_kk=0;
                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                            rat_kk++;
                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                        $(this).className()
                                var classnametr = this.className.split('')[0];
                                // console.log(classnametr);


                                ResultArrRating.push(classnametr);


                                if (jQuery.inArray(classnametr, ResultArrRating)) {// doesnt work
                                    // do nothing
                                } else {
                                    ResultArrRating.push(classnametr);
                                }
//                        return false;
                            }
                        });

                        console.log("rat_kk "+rat_kk);


                        var legnrating = unique(ResultArrRating);
                        var selectedrating = $('#u_emp_id option:selected');
                        var empid = selectedrating.data('empid');
                        g_legn_lengthrating = legnrating.length;

                        // console.log("reddd "+g_legn_lengthrating);



                        ////


                        if(ddresult=='fail'&&rat_kk<5){
                            // console.log("ggcount: "+ggcount);
                            swal(
                                    'Error',
                                    'Please Select Five Categories'
                            )

                        }else{
//                            alert('hmm u select some');



                            ///////////////////////////////////////////////////////////////////////////////////// 5 ta select


                            var kk_len_error2rating = 0;
                            var kk_lenrating=0;
                            //finalcheckedit  finalcheckedit
                            $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                // console.log("pass gate1 edit===========================loop1 rating ");

                                kk_lenrating = kk_lenrating + 1;
                                var classnametrrating = this.className.split('')[0];
                                console.log("classnametrrating--" + classnametrrating);

                                $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                    // console.log("findcheck tyt classnametrrating");
                                    if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                        // console.log("findcheck1111111111111classnametrrating");
                                        $(this).css('background-color',"#def3ca");


                                    } else {
                                        kk_len_error2rating = 1;
                                        // console.log("1111111111111111111classnametrrating");
                                        // $(this).css('background-color', 'red');
                                        $(this).css('background-color', '#f8d7da');

//                                        return false;
                                    }//endif
                                });
                            });


                            // console.log("kk_len_error2rating "+kk_len_error2rating);

                            if(kk_len_error2rating==1){
                                swal(
                                        'Error',
                                        'Please check all the categories that you select'
                                )



                                ///stop error all edit

                                $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                    // console.log("pass red err 1");

                                    //   kk_lenrating = kk_lenrating + 1;
                                    var classnametrrating = this.className.split('')[0];
                                    // console.log("classnametrrating--" + classnametrrating);

                                    $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                        console.log("findcheck tyt classnametrrating");
                                        if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                            console.log("findcheck1111111111111classnametrrating");
                                            $(this).css('background-color',"#def3ca");


                                        }else{
//                                    kk_len_error2rating = 1;
                                            console.log("1111111111111111111classnametrrating");
                                            // $(this).css('background-color', 'red');
                                            $(this).css('background-color', '#f8d7da');

//                                    return false;
                                        }//endif
                                    });
                                });

                                //stop error all edit
                            }else{
                                // console.log("hmm...is well===========================0000000000================="+ResultArrRating);
                                //here finally rating will go to datatbase


                                ///////////////////////////////////////////////////------------------------------------

                                totallyemp = 'empty';


                                //////////////loop ...then make array which ic checked/////////////////////
                                $('#tabRating tbody tr').each(function (index, element) {

                                    var classnametrrating = this.className.split('')[0];
                                    // console.log("classnametrrating "+classnametrrating);

                                    //19.09.2018
                                    if (classnametrrating == 1) {
                                        ecompc = 'LEADERSHIP';
                                    } else if (classnametrrating == 2) {
                                        ecompc = 'STRATEGIC THINKING';
                                    } else if (classnametrrating == 3) {
                                        ecompc = 'INNOVATION';
                                    } else if (classnametrrating == 4) {
                                        ecompc = 'TEAM-WORK ABILITY';
                                    } else if (classnametrrating == 5) {
                                        ecompc = 'ENTREPRENEURIAL MINDSET';
                                    } else if (classnametrrating == 6) {
                                        ecompc = 'COMMUNICATION';
                                    } else if (classnametrrating == 7) {
                                        ecompc = 'LIVING THE VALUES OF THE COMPANY';
                                    } else if (classnametrrating == 8) {
                                        ecompc = 'CUSTOMER CENTRICITY';
                                    }


                                    var ecompc_desc = $(this).find('.ecompc_desc').val();

                                    // console.log("ecompc_desc :"+ecompc_desc);


//                                    console.log("skyflyer :"+$(this).find('.insidechk:checkbox:checked').prop( "disabled",false));


//                                    if ($(this).find('.insidechk:checkbox:checked').prop( "disabled",false).length > 0) {
                                            if($(this).find('.insidechk:enabled:checkbox:checked').length > 0){
                                        var tr_checked_val = $(this).find('.insidechk:checkbox:checked').val();

                        console.log("ke emptyoooo no");
                                    } else {
                                        var tr_checked_val = 'nocheck';
                                        totallyemp = 'empty';
                        console.log("ke empty");

                                    }

                                    // console.log("ecrm_id 454646  -- "+ecrm_id);
                                    // console.log("eching biching "+g_ecrm_id_done);

                                    var arr_newrating = {
                                        'trecrm_id':g_ecrm_id_done,
//                                        ecrm_id,
                                        'trecompc': ecompc,
                                        'trecompc_desc': ecompc_desc,
                                        'trevaluation_val': tr_checked_val
                                    };


                                    // console.log("arr_newrating "+arr_newrating);

                                    // console.log(" before s_evalu_arrrating "+s_evalu_arrrating);

                                    s_evalu_arrrating.push(arr_newrating);
                                    // console.log(" after s_evalu_arrrating "+s_evalu_arrrating);


                                });
                                ////////////////////////////////////////

                                // console.log(" whole s_evalu_arrrating "+s_evalu_arrrating);


                                ////////////////////////////////////////////////////////////////////////////////

                                // console.log(" global_Nextstatus 215215 "+global_Nextstatus);
                                if (global_Nextstatus == 'NextRatingforsave') {
                                    console.log("u r doing nextrating here by edit phase rating 215215"); //ei porjo arse

                                    // console.log("s_evalu_arr " + s_evalu_arrrating);
                                    // console.log("empinfo_arr " + empinfo_arr);


                                    var l = Ladda.create(document.querySelector('#btnEdit'));
                                    l.start();

                                    $.ajax({
                                        method: 'post',
                                        url: '{!! URL::to('emp_comp/nextratingfirstsave') !!}',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            s_evalu_arr: s_evalu_arrrating,
                                            empinfo_arr: empinfo_arr
                                        },
                                        success: function (data) {


                                            // console.log("we need this one"); //ei porjo arse
                                            // console.log(data);


                                            //stop the error ---btnedit

                                            $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                                // console.log("pass red err 1");

//                            kk_lenrating = kk_lenrating + 1;
                                                var classnametrrating = this.className.split('')[0];
                                                // console.log("classnametrrating--" + classnametrrating);

                                                $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                                    // console.log("findcheck tyt classnametrrating");
                                                    if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                        // console.log("findcheck1111111111111classnametrrating");
                                                        $(this).css('background-color',"#def3ca");


                                                    } else {
//                                    kk_len_error2rating = 1;
                                                        // console.log("1111111111111111111classnametrrating");
                                                        // $(this).css('background-color', 'red');
                                                        $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                    }//endif
                                                });
                                            });


                                            //stop the error --btnedit


                                            toastr["success"]("Successfully Done")
                                            toastr.options = {
                                                "closeButton": true,
                                                "debug": false,
                                                "newestOnTop": false,
                                                "progressBar": false,
                                                "positionClass": "toast-top-center",
                                                "preventDuplicates": false,
                                                "onclick": null,
                                                "showDuration": "1000",
                                                "hideDuration": "0",
                                                "timeOut": "0",
                                                "extendedTimeOut": "0",
                                                "showEasing": "swing",
                                                "hideEasing": "linear",
//                                                "showMethod": "fadeIn",
//                                                "hideMethod": "fadeOut"
                                            }

                                            l.stop();

                                        },
                                        error: function (value) {
                                            console.log('error');
                                        }
                                    });


                                }


                                //////////////////////////////////////////////
                            }





                            /////////////////////////////////////////////////////////////
                        }
                    }else{

//                        console.log("error come here 12.3.2019");//eta aslo



                        $('#tabRating tbody tr.finalcheckedit').each(function (index, element) {
                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                result = 'pass';
                                //ekhane test korte hobe
                            } else {
                                result = 'fail';
//                                console.log("what msg 12.3.2019: " + result);//aslo eta
                                return false;
                            }

                        });


//                        console.log("what msg2 12.3.2019: " + result);


                        $('#tabRating tbody tr').each(function (index, element) {
                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                        $(this).className()
                                var classnametr = this.className.split('')[0];
//                        console.log(classnametr);


                                ResultArr.push(classnametr);


                                if (jQuery.inArray(classnametr, ResultArr)) {// doesnt work
                                    // do nothing
                                } else {
                                    ResultArr.push(classnametr);
                                }
//                        return false;
                            }
                        });


                        var legn = unique(ResultArr);
                        var selected = $('#u_emp_id option:selected');
                        var empid = selected.data('empid');
                        g_legn_length = legn.length;


                        if(empid == g_login_emp_id){
                            ///////////////////////////////////////////////////////////do so/////////////////////////////////////////////////////////////////////////

//                             console.log("yes we here ResultArr empid == g_login_emp_id 12.3.2019");///12 here 3
                            //19.09.2018
//                          console.log("12 32019 legn.length"+legn.length);//aslo to2
                            if (legn.length < 5) {

                                result = 'fail';
                                if (result == 'fail'||ddresult == 'fail') {


                                    ///19.09 totally new add--------------------------------------
                                    console.log("fail fail fail");
                                    var kk_len = 0;
                                    var kk_len_error = 0;
                                    $('#tabRating tbody tr.finalckedtr').each(function(index, element){

                                        kk_len = kk_len + 1;
                                        var classnametr = this.className.split('')[0];

                                        $('#tabRating tbody tr.' + classnametr).each(function (index, element) {


                                            // console.log("findcheck tyt");
                                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                // console.log("findcheck 10.11 p1");

                                            } else {
                                                kk_len_error = 1;
                                                // console.log("10.11 p2"); //sumit aslo

                                                return false;
                                            }
                                        });
                                    });


                                    ///////////////end

                                    // console.log("kk_len"+kk_len);
                                    // console.log(kk_len_error);


                                    ///
                                    var ttlenall=0;
                                    $('#tabRating tbody tr.finalckedtr').each(function (index, element) {
                                        ttlenall=ttlenall+1;
                                    });

                                    //
//                                    console.log("ttlenall 12.3.2019 "+ttlenall);
                                    //neew--------------

                                    if(ttlenall<5) {

                                        swal(
                                                'Error',
                                                'Please select Five Categories'
                                        )

                                    }else{




                                    if (kk_len + legn.length == 5 || kk_len_error == 1) {
                                        swal(
                                                'Error',
                                                'Please check all the categories that you select'
                                        )

                                        // console.log("findcheck 10.11 p3");

                                        ///stop error all edit

                                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                            console.log("pass red err 1p4");

                                            //   kk_lenrating = kk_lenrating + 1;
                                            var classnametrrating = this.className.split('')[0];
                                            // console.log("classnametrrating--" + classnametrrating);

                                            $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                                // console.log("findcheck tyt classnametrrating");
                                                if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                    // console.log("findcheck1111111111111classnametrrating  p4");
                                                    $(this).css('background-color', "#def3ca");


                                                } else {
//                                    kk_len_error2rating = 1;
                                                    // console.log("1111111111111111111classnametrrating  p4");
                                                    // $(this).css('background-color', 'red');
                                                    $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                }//endif
                                            });
                                        });

                                        //stop error all edit


                                    } else if (kk_len + legn.length > 5) {

                                        // console.log("kk_len"+kk_len);
                                        // console.log("kk_len rer gdg"+legn.length);
                                        swal(
                                                'Error',
                                                'You have select categories more than Five'
                                        )

                                        //its come here 5.17

                                        // console.log("findcheck 10.11 p4");


//                                        ///stop error all edit
//
//                                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {
//
//                                            console.log("pass red err 1p4");
//
//                                            //   kk_lenrating = kk_lenrating + 1;
//                                            var classnametrrating = this.className.split('')[0];
//                                            console.log("classnametrrating--" + classnametrrating);
//
//                                            $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {
//
//
//                                                console.log("findcheck tyt classnametrrating");
//                                                if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                                                    console.log("findcheck1111111111111classnametrrating  p4");
//                                                    $(this).css('background-color', "#def3ca");
//
//
//                                                } else {
////                                    kk_len_error2rating = 1;
//                                                    console.log("1111111111111111111classnametrrating  p4");
//                                                    $(this).css('background-color', 'red');
//
////                                    return false;
//                                                }//endif
//                                            });
//                                        });
//
//                                        //stop error all edit



                                        console.log("findcheck 10.11 p4");
                                    }else {
                                        swal(
                                                'Error',
                                                'Please select Five Categories'
                                        )
                                        //aslo
                                        console.log("findcheck 10.11 p5");
                                    }



                                    }//neew


                                }
                            }else {

                                // console.log("pass gate1 edit");  //nr e upto this

                                var kk_len_error2 = 0;
//                        finalcheckedit  finalcheckedit
                                var kk_len=0;
//                                $('#tabRating tbody tr.finalcheckedit').each(function (index, element) {
//                                    $('#tabRating tbody tr.finalcheckedit').each(function (index, element) {
//
//                                    console.log("pass gate1 edit===========================loop1 n  yhty " + classnametr); ///keekaa
//
//                                    kk_len = kk_len + 1;
//                                    var classnametr = this.className.split('')[0];
//                                    console.log("classnametr--keekaa--" + classnametr);
//
//                                    $('#tabRating tbody tr.' + classnametr).each(function (index, element) {
//
//
//                                        console.log("findcheck tyt keekaa");
//                                        if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                                            console.log("findcheck111111111111 keekaa");
//
//                                            //do something heree for error
//
//
//                                        } else {
//                                            kk_len_error2 = 1;
//                                            console.log("11111111111116666666666666111111 keekaa");
//                                            $(this).css('background-color', 'red');
//
//                                            //10/11/18--5.02
//
////                                            return false;
//                                        }//endif
//                                    });
//                                });


                                ///
                                var ttlen=0;
                                $('#tabRating tbody tr.finalckedtr').each(function (index, element) {
                                            ttlen=ttlen+1;
                                });

                                //


                                 console.log("legn.length more than 2019 "+ttlen+" === "+legn.length);


                                //i comment here 13.3.2019------------

                                legn.length=ttlen;

                                if (legn.length> 5) {
                                    result = 'fail2';
                                    swal(
                                            'Error',
                                            'You have select categories more than Five'
                                    )
                                    //



//                                    console.log("may be here 12.3.2019");
                                }else {
//                                     console.log("pass gate2    " + legn.length + " --->>> 12.03.2019 " + kk_len_error2);  //nr e upto this

                                    //aslo

                                    if (result == 'fail2') {
                                        swal(
                                                'Error',
                                                'Please check all the categories that you select'
                                        )

                                        ///to stop the error

                                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                            // console.log("pass red err 1");

//                            kk_lenrating = kk_lenrating + 1;
                                            var classnametrrating = this.className.split('')[0];
                                            // console.log("classnametrrating--" + classnametrrating);

                                            $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                                console.log("findcheck tyt classnametrrating");
                                                if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                                                    console.log("findcheck1111111111111classnametrrating");
                                                    $(this).css('background-color',"#def3ca");


                                                } else {
//                                    kk_len_error2rating = 1;
//                                                    console.log("1111111111111111111classnametrrating");
                                                    // $(this).css('background-color', 'red');
                                                    $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                }//endif
                                            });
                                        });

                                        ///to stop the error


                                        ResultArr = [];
                                    } else if (kk_len_error2 == 1) {
                                        swal(
                                                'Error',
                                                'Please check all the categories that you select'
                                        )

                                        ///to stop the error

                                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                            console.log("pass red err 1");

//                                         kk_lenrating = kk_lenrating + 1;
                                            var classnametrrating = this.className.split('')[0];
                                            // console.log("classnametrrating--" + classnametrrating);

                                            $('#tabRating tbody tr.' + classnametrrating).each(function (index, element) {


                                                // console.log("findcheck tyt classnametrrating");
                                                if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                    // console.log("findcheck1111111111111classnametrrating");
                                                    $(this).css('background-color',"#def3ca");


                                                } else {
//                                    kk_len_error2rating = 1;
                                                    console.log("1111111111111111111classnametrrating");
                                                    // $(this).css('background-color', 'red');
                                                    $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                }//endif
                                            });
                                        });

                                        ///to stop the error


                                        ResultArr = [];
                                    } else {
                                        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//                                console.log("pass gate3");

                                        totallyemp = 'empty';


                                        //////////////loop ...then make array which ic checked/////////////////////
                                        $('#tabRating tbody tr').each(function (index, element) {

                                            var classnametr = this.className.split('')[0];


                                            //19.09.2018
                                            if (classnametr == 1) {
                                                ecompc = 'LEADERSHIP';
                                            } else if (classnametr == 2) {
                                                ecompc = 'STRATEGIC THINKING';
                                            } else if (classnametr == 3) {
                                                ecompc = 'INNOVATION';
                                            } else if (classnametr == 4) {
                                                ecompc = 'TEAM-WORK ABILITY';
                                            } else if (classnametr == 5) {
                                                ecompc = 'ENTREPRENEURIAL MINDSET';
                                            } else if (classnametr == 6) {
                                                ecompc = 'COMMUNICATION';
                                            } else if (classnametr == 7) {
                                                ecompc = 'LIVING THE VALUES OF THE COMPANY';
                                            } else if (classnametr == 8) {
                                                ecompc = 'CUSTOMER CENTRICITY';
                                            }


                                            var ecompc_desc = $(this).find('.ecompc_desc').val();


                                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                var tr_checked_val = $(this).find('.insidechk:checkbox:checked').val();

//                        console.log("ke emptyoooo");
                                            } else {
                                                var tr_checked_val = 'nocheck';
                                                totallyemp = 'empty';
//                        console.log("ke empty");

                                            }


                                            var arr_new = {
                                                'trecrm_id': ecrm_id,
                                                'trecompc': ecompc,
                                                'trecompc_desc': ecompc_desc,
                                                'trevaluation_val': tr_checked_val
                                            };

                                            s_evalu_arr.push(arr_new);


                                        });
                                        ////////////////////////////////////////


                                        ////////////////////////////save the data to detals n master(edit option)///////////////////////

//
                                        // console.log(global_Nextstatus + " global_Nextstatus"); ///here the pp
                                        if(global_Nextstatus == 'NextRatingforsave') {
                                            // console.log("u r doing nextrating here by edit phase"); //ei porjo arse

                                            // console.log("s_evalu_arr " + s_evalu_arr);
                                            // console.log("empinfo_arr " + empinfo_arr);


                                            var l = Ladda.create(document.querySelector('#btnEdit'));
                                            l.start();

                                            $.ajax({
                                                method: 'post',
                                                url: '{!! URL::to('emp_comp/nextratingfirstsave') !!}',
                                                data: {
                                                    "_token": "{{ csrf_token() }}",
                                                    s_evalu_arr: s_evalu_arr,
                                                    empinfo_arr: empinfo_arr
                                                },
                                                success: function (data) {


                                                    // console.log("we need this one"); //ei porjo arse

                                                    // console.log(data);


                                                    toastr["success"]("Successfully Done nr")
                                                    toastr.options = {
                                                        "closeButton": true,
                                                        "debug": false,
                                                        "newestOnTop": false,
                                                        "progressBar": false,
                                                        "positionClass": "toast-top-center",
                                                        "preventDuplicates": false,
                                                        "onclick": null,
                                                        "showDuration": "300",
                                                        "hideDuration": "1000",
                                                        "timeOut": "10000",
                                                        "extendedTimeOut": "1000",
                                                        "showEasing": "swing",
                                                        "hideEasing": "linear",
                                                        "showMethod": "fadeIn",
                                                        "hideMethod": "fadeOut"
                                                    }

                                                    l.stop();

                                                },
                                                error: function (value) {
                                                    console.log('error');
                                                }
                                            });


                                        }else{

                                            ///


                                            // error check--------------10.11.2018
                                            var ddresult_ggtt, ggcount_ggtt;


                                            $('#tabRating tbody tr').each(function (index, element) {

                                                $(this).css('background-color', " ");
                                                if ($(this).hasClass('finalckedtr')) {
                                                    ddresult_ggtt = 'pass';
                                                    //ekhane test korte hobe
                                                } else {
                                                    ggcount_ggtt = ggcount_ggtt + 1;
                                                    ddresult_ggtt = 'fail';
//                                                    console.log("what msg: " + result);
                                                    return false;
                                                }

                                            });

//                        alert(ddresult);


                                            //////
                                            var rat_kk_ggtt = 0;
                                            $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                                rat_kk_ggtt++;

                                            });

                                            // console.log("rat_kk_ggtt " + rat_kk_ggtt); //pp here 5


                                            ////


                                            if (ddresult_ggtt == 'fail' && rat_kk_ggtt < 5) {
                                                // console.log("ggcount_ggtt: " + ggcount_ggtt); //ailo eta//first click here 514


                                                swal(
                                                        'Error',
                                                        'Please Select Five Categories'
                                                )

                                                ///stop error all edit

                                                $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                                    // console.log("pass red err 1");

                                                    //   kk_lenrating = kk_lenrating + 1;
                                                    var classnametrrating = this.className.split('')[0];
                                                    // console.log("classnametrrating--" + classnametrrating);

                                                    $('#tabRating tbody tr.'+classnametrrating).each(function (index, element) {


                                                        // console.log("findcheck tyt classnametrrating");
                                                        if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                            // console.log("findcheck1111111111111classnametrrating");
                                                            $(this).css('background-color', "#def3ca");


                                                        } else {
//                                    kk_len_error2rating = 1;
                                                            // console.log("1111111111111111111classnametrrating");
                                                            // $(this).css('background-color', 'red');
                                                            $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                        }//endif
                                                    });
                                                });

                                                //stop error all edit



                                            } else {
//                            alert('hmm u select some rat_kk_ggtt');  //aslo to




                                                ///////////////////////////////////////////////////////////////////////////////////// 5 ta select


                                                var kk_len_error2rating_ggtt = 0;
                                                var kk_lenrating_ggtt = 0;
                                                //finalcheckedit  finalcheckedit
                                                $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                                    // console.log("pass_ggtt"); //pp here

                                                    kk_lenrating_ggtt = kk_lenrating_ggtt + 1;
                                                    var classnametrrating_ggtt = this.className.split('')[0];
                                                    // console.log("classnametrrating_ggtt EUro--" + classnametrrating_ggtt);

                                                    $('#tabRating tbody tr.' + classnametrrating_ggtt).each(function (index, element) {


                                                        // console.log("findcheck tyt classnametrrating_ggtt EUro");
                                                        if ($(this).find('.insidechk:checkbox:checked').length > 0) {
//                                                            console.log("findcheck1111111111111classnametrrating");
                                                            $(this).css('background-color', "#def3ca");


                                                        } else {
                                                            kk_len_error2rating_ggtt = 1;
//                                                            console.log("1111111111111111111classnametrrating");
                                                            // $(this).css('background-color', 'red');
                                                            $(this).css('background-color', '#f8d7da');

//                                        return false;
                                                        }//endif
                                                    });
                                                });


                                                // console.log("kk_len_error2rating_ggtt " + kk_len_error2rating_ggtt);

                                                if (kk_len_error2rating_ggtt == 1) {
                                                    swal(
                                                            'Error',
                                                            'Please check all the categories that you select'
                                                    )


                                                    ///stop error all edit

                                                    $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

                                                        // console.log("pass red err 1");

                                                        //   kk_lenrating = kk_lenrating + 1;
                                                        var classnametrrating = this.className.split('')[0];
                                                        // console.log("classnametrrating--try hard bb--" + classnametrrating);

                                                        $('#tabRating tbody tr.'+classnametrrating).each(function (index, element) {


                                                            // console.log("findcheck tyt classnametrrating");
                                                            if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                                // console.log("findcheck1111111111111classnametrrating----9080");
                                                                $(this).css('background-color', "#def3ca");


                                                            }else{
//                                    kk_len_error2rating = 1;
                                                                // console.log("1111111111111111111classnametrrating---9087");
                                                                // $(this).css('background-color', 'red');
                                                                $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                            }//endif
                                                        });
                                                    });

                                                    //stop error all edit
                                                } else {
                                                    console.log("_ggtthmm...is "); //aslo to 2

                                                // error check--------------10.11.2018
                                                    console.log("u r doing edit gate 4"); //aslo to 2


                                                    var l=Ladda.create(document.querySelector('#btnEdit'));
                                                    l.start();




                                                    ///need to make annoter array for modified edit
                                                    s_evalu_arr = [];



                                                    //////////////loop ...then make array which ic checked/////////////////////
                                                    $('#tabRating tbody tr').each(function (index, element) {

                                                        var classnametrother = this.className.split('')[0];


                                                        //19.09.2018
                                                        if (classnametrother == 1) {
                                                            ecompcother = 'LEADERSHIP';
                                                        } else if (classnametrother == 2) {
                                                            ecompcother = 'STRATEGIC THINKING';
                                                        } else if (classnametrother == 3) {
                                                            ecompcother = 'INNOVATION';
                                                        } else if (classnametrother == 4) {
                                                            ecompcother = 'TEAM-WORK ABILITY';
                                                        } else if (classnametrother == 5) {
                                                            ecompcother = 'ENTREPRENEURIAL MINDSET';
                                                        } else if (classnametrother == 6) {
                                                            ecompcother = 'COMMUNICATION';
                                                        } else if (classnametrother == 7) {
                                                            ecompcother = 'LIVING THE VALUES OF THE COMPANY';
                                                        } else if (classnametrother == 8) {
                                                            ecompcother = 'CUSTOMER CENTRICITY';
                                                        }

                                                        var tr_checked_valother;


                                                        var ecompc_descother = $(this).find('.ecompc_desc').val();

//                                                        $('#tabRating tbody tr.finalckedtr').each(function (index, element) {

//

//                                                            if ($(this).find('.insidechk:checkbox:checked').prop( "disabled",false).length > 0) {
//                                                                var tr_checked_valother = $(this).find('.insidechk:checkbox:checked').val();
//
////
//                                                            }else{
//                                                                var tr_checked_valother = 'nocheck';
//
//                                                            }


                                                        if ($(this).find('.insidechk:enabled:checkbox:checked').length > 0) {
                                                            var tr_checked_valother =$(this).find('.insidechk:checkbox:checked').val();

                                                            console.log("ke emptyoooo no hhjjuu");
                                                        } else {
                                                            var tr_checked_valother = 'nocheck';
                                                            totallyemp = 'empty';
                                                            console.log("ke empty hhjjuu");

                                                        }

//                                                        });





                                                        var arr_newother = {
                                                            'trecrm_id': ecrm_id,
                                                            'trecompc': ecompcother,
                                                            'trecompc_desc': ecompc_descother,
                                                            'trevaluation_val': tr_checked_valother
                                                        };

                                                        s_evalu_arr.push(arr_newother);


                                                    });
                                                    ////////////////////////////////////////




                                                    ///need to make annoder array for modified edit


                                                    console.log("s_evalu_arr gate4"+JSON.stringify(s_evalu_arr)); //aslo to


                                                    $.ajax({
                                                        method: 'post',
                                                        url: '{!! URL::to('emp_comp/newratebysupervisor') !!}',
                                                        data: {
                                                            "_token": "{{ csrf_token() }}",
                                                            s_evalu_arr: s_evalu_arr,
                                                            empinfo_arr: empinfo_arr
                                                        },
                                                        success: function (data) {

                                                            //here it come----------
//                                                            toastr["success"]("Successfully Done next rating")//aslo to
                                                            toastr["success"]("Successfully Done")
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "newestOnTop": false,
                                                                "progressBar": false,
                                                                "positionClass": "toast-top-center",
                                                                "preventDuplicates": false,
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "10000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            }

                                                            l.stop();

                                                        },
                                                        error: function (value) {
                                                            console.log('error');
                                                        }
                                                    });


                                                    console.log("u r doing edit gate 4"); //aslo to 2 enddi

                                                }
                                            }

                                        }




                                        s_evalu_arr = [];

                                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    }//end idf fail or pass





                                }
                            }
                            /////////////////////////////////////////////////////////////////////////do so////////////////////////////////////////////////////////
                        } else {

                            console.log("yes we here ResultArr2"); //its here teacher
                            //////////////////////////////////////////////////////////////////////eslee    melas///

                            if (result == 'fail') {
                                swal(
                                        'Error',
                                        'Please check all the categories that you select'
                                )


                                //for error--------------
                                ///stop error all edit

                                $('#tabRating tbody tr.finalcheckedit').each(function (index, element) {

                                    console.log("pass red err 1 for err");

                                    //   kk_lenrating = kk_lenrating + 1;
                                    var classnametrrating = this.className.split('')[0];
                                    console.log("classnametrrating--try hard bb--" + classnametrrating);

                                    $('#tabRating tbody tr.'+classnametrrating).each(function (index, element) {


                                        console.log("findcheck tyt classnametrrating");
                                        if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                            console.log("findcheck1111111111111classnametrrating----5060");
                                            $(this).css('background-color', "#def3ca");


                                        }else{
//                                    kk_len_error2rating = 1;
                                            console.log("1111111111111111111classnametrrating---5060");
                                            // $(this).css('background-color', 'red');
                                            $(this).css('background-color', '#f8d7da');

//                                    return false;
                                        }//endif
                                    });
                                });

                                //stop error all edit


                                ///for error----------------
                                ResultArr = [];
                            }else{
                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////


                                totallyemp = 'empty';


                                //////////////loop ...then make array which ic checked/////////////////////
                                $('#tabRating tbody tr').each(function (index, element) {

                                    var classnametr = this.className.split('')[0];


                                    //19.09.2018
                                    if (classnametr == 1) {
                                        ecompc = 'LEADERSHIP';
                                    } else if (classnametr == 2) {
                                        ecompc = 'STRATEGIC THINKING';
                                    } else if (classnametr == 3) {
                                        ecompc = 'INNOVATION';
                                    } else if (classnametr == 4) {
                                        ecompc = 'TEAM-WORK ABILITY';
                                    } else if (classnametr == 5) {
                                        ecompc = 'ENTREPRENEURIAL MINDSET';
                                    } else if (classnametr == 6) {
                                        ecompc = 'COMMUNICATION';
                                    } else if (classnametr == 7) {
                                        ecompc = 'LIVING THE VALUES OF THE COMPANY';
                                    } else if (classnametr == 8) {
                                        ecompc = 'CUSTOMER CENTRICITY';
                                    }


                                    var ecompc_desc = $(this).find('.ecompc_desc').val();


                                    if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                        var tr_checked_val = $(this).find('.insidechk:checkbox:checked').val();
//                        totallyemp='notempty';
//                        console.log("ke emptyoooo");
                                    } else {
                                        var tr_checked_val = 'nocheck';
                                        totallyemp = 'empty';
//                        console.log("ke empty");

                                    }

//                            console.log("trcheckedval");
//                            console.log(tr_checked_val);
//                                console.log(totallyemp);

                                    var arr_new = {
                                        'trecrm_id': ecrm_id,
                                        'trecompc': ecompc,
                                        'trecompc_desc': ecompc_desc,
                                        'trevaluation_val': tr_checked_val
                                    };

                                    s_evalu_arr.push(arr_new);


                                });
                                ////////////////////////////////////////

                                console.log("Edit array");
//                        console.log(g_legn_length);
//                            console.log(totallyemp);

                                ////////////////////////////save the data to detals n master///////////////////////
                                ///uncomment ajax 20.09.2018

                                var l = Ladda.create(document.querySelector('#btnEdit'));
                                l.start();

                                $.ajax({
                                    method: 'post',
                                    url: '{!! URL::to('emp_comp/newratebysupervisor') !!}',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        s_evalu_arr: s_evalu_arr,
                                        empinfo_arr: empinfo_arr
                                    },
                                    success: function (data) {


                                        toastr["success"]("Successfully Done")
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "newestOnTop": false,
                                            "progressBar": false,
                                            "positionClass": "toast-top-center",
                                            "preventDuplicates": false,
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "10000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        }


                                        //for error--------------
                                        ///stop error all edit

                                        $('#tabRating tbody tr.finalcheckedit').each(function (index, element) {

                                            console.log("pass red err 1 for err");

                                            //   kk_lenrating = kk_lenrating + 1;
                                            var classnametrrating = this.className.split('')[0];
                                            // console.log("classnametrrating--try hard bb--" + classnametrrating);

                                            $('#tabRating tbody tr.'+classnametrrating).each(function (index, element) {


                                                console.log("findcheck tyt classnametrrating");
                                                if ($(this).find('.insidechk:checkbox:checked').length > 0) {
                                                    console.log("findcheck1111111111111classnametrrating----5060");
                                                    $(this).css('background-color', "#def3ca");


                                                }else{
//                                    kk_len_error2rating = 1;
                                                    console.log("1111111111111111111classnametrrating---5060");
                                                    // $(this).css('background-color', 'red');
                                                    $(this).css('background-color', '#f8d7da');

//                                    return false;
                                                }//endif
                                            });
                                        });

                                        //stop error all edit


                                        ///for error----------------


                                        l.stop();

                                    },
                                    error: function (value) {
                                        console.log('error');
                                    }
                                });


                                s_evalu_arr = [];

                                /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            }//end idf fail or pass


                            ///////////////////////////////////////////////else felse//////////////////////////
                        }

//                    }



                }//major if else



            });///end edit btn

            $(document).on('click','#btnClear',function(){
                // console.log("click on clear");

                $('#tabRating tbody#ratingData tr input:checkbox:checked').each(function(index, element){

                    $(this).parent().find('.insidechk').removeAttr('checked');

                });


            });

            /////////////////////
        });

        //        }
    </script>

@endsection
