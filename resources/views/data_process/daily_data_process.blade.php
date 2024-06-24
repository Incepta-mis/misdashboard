@extends('_layout_shared._master')
@section('title','Data Process')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/css/jquery-ui-1.9.2.custom.css')}}" rel="stylesheet"
          type="text/css"/>

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

        body{
            color: black;
        }
        input{
            color:black
        }

         #loading-img {
            background: url(http://preloaders.net/preloaders/360/Velocity.gif) center center no-repeat;
            height: 100%;
            z-index: 20;
        }

        .overlay {
            background: #e9e9e9;
            /*display: none;*/
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.5;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary" style="color:#37a024">
                        Daily Data Process
                    </label>


                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <span class="sale_report_shbtn">
                        <!-- <button class="btn btn-info">Hide the 'Sale report' module</button> -->
                         @if($menu_show_sta=='yes')
                            <button class="btn btn-info">Hide the 'Sale report' module</button>
                        @elseif($menu_show_sta=='no')
                            <button class="btn btn-primary">Display the 'Sale report' module</button>
                        @endif
                    </span>

                </header>
                

                @if($working_day_submit=='no')

             

                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">


                        <div class="col-md-2 col-sm-2" style="width:14%;">

                            <input type="checkbox" class="data-trans-btn" value="pdf" id="dt_chkid"> Data Transfer

                        </div>
                        

                        <div class="col-md-2 col-sm-2" style="width:14%;">

                            <input type="checkbox" class="target-btn"  value="pdf" id="pdf"> Product Target

                        </div>
                        <div class="col-md-2 col-sm-2" style="width:14%;">

                                    <input type="checkbox" class="daily-rep-btn"  value="pdf" id="pdf"> Daily Report

                        </div>
                        <div class="col-md-2 col-sm-2" style="width:14%;">

                            <input type="checkbox"  class="cls-rep-btn" value="pdf" id="pdf"> Closing Report

                        </div>
                        


                    </div>
                   

                    <br><br>

                    <div class="row" >

                        <div class="alert alert-success" id="messg" style="display: none;">
                            <p><i class="fa fa-check-circle"></i><b> Process Completed Successfully</b></p>
                        </div>


                        <form method="post" id="frmdailyproc">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                {{--data transfer div--}}
                                <div class="col-md-12 col-sm-12 data-trans-div" style="border: 1px solid #d8d2d2">
                                    <div class="form-group form-horizontal">
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: #3f87a6"><b>Data Transfer</b>

                                         {{--7.3.2019--}}
                                            &nbsp &nbsp&nbsp &nbsp
                                            <span>
                                                
                                                <input type="checkbox" disabled class="data-trans-clss working_multi_chk_dt" id="holiday_mul">
                                                <input type="hidden" id="working_multi_dt" name="working_multi_dt" class="data-trans-clss" value="">
                                                <span style="color:red"><b> If Multiple Working Day,then Check the checkbox</b> </span>
                                                
                                            </span>



                                       </span>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                                <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                    <b>First Day of Report Month:</b></label>
                                                <div class="col-md-2 col-sm-2 col-xs-6">
                                                    <input type="text" id="1st_day_rep_mon_dt" name="1st_day_rep_mon_dt" placeholder="01-Aug-18" disabled class="data-trans-clss">

                                                    <input type="hidden" id="sysdate1" value="{{$current_datedb[0]->sy_date}}">
                                                    <input type="hidden" id="sysdate2" value="{{$current_datedb[0]->sy_date2}}">
                                                    <input type="hidden" id="sysdate3" value="{{$current_datedb[0]->sy_date3}}">
                                                    <input type="hidden" id="sysdate4" value="{{$current_datedb[0]->sy_date4}}">
                                                    <input type="hidden" id="working_day_statusid" value="{{$current_monthly_wd[0]->working_day_status}}">
                                                    <input type="hidden" id="credit_date_hid" value="{{$credit_date}}">
                                                    <input type="hidden" id="prev_mont_wdate_hid" value="{{$info_baseday[0]->format_working_date}}">

                                                     {{--7.3.2019--}}

                                                    <input type="hidden" id="rep_mon_dt" name="rep_mon_dt" class="data-trans-clss" value="">


                                                </div>


                                                <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                    <b>Working Day:</b></label>
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <input type="text" id="work_day_dt" name="work_day_dt" disabled class="data-trans-clss">
                                                    <input type="hidden" id="work_day_dt_hd" value="{{$current_monthly_wd[0]->working_day}}">
                                                </div>

                                                <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" for="p_group">
                                                    <b>Report Date:</b></label>
                                                <div class="col-md-2 col-sm-2 col-xs-2" id="am_div_id">
                                                    <input type="text" disabled id="rep_date_dt" name="rep_date_dt" class="data-trans-clss">
                                                </div>

                                            </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled id="work_date_dt" name="work_date_dt" class="data-trans-clss">
                                            </div>


                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>2nd Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled id="2nd_work_day_dt" name="2nd_work_day_dt" class="data-trans-clss">
                                            </div>

                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" for="p_group">
                                                <b>Previous Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2" id="am_div_id">
                                                <input type="text" disabled id="prev_work_day_dt" name="prev_work_day_dt" class="data-trans-clss">
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Credit Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled id="credit_date_dt" name="credit_date_dt" class="data-trans-clss">
                                            </div>

                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>Report Type:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                {{--<input type="text" disabled id="rep_type_dt" name="rep_type_dt" class="data-trans-clss">--}}
                                                <select disabled id="rep_type_dt" name="rep_type_dt" style="width:100%;" class="data-trans-clss">
                                                    <option value="DAILY">DAILY</option>
                                                    <option value="CLOSING">CLOSING</option>
                                                </select>
                                            </div>

                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" for="terr_id">
                                                <b>Prev. Month Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled id="prev_month_work_day_dt" name="prev_month_work_day_dt" class="data-trans-clss">
                                            </div>

                                            {{--<label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" for="p_group">--}}
                                                {{--<b>Prev. Month Working Date:</b></label>--}}
                                            {{--<div class="col-md-2 col-sm-2 col-xs-2" id="am_div_id">--}}
                                                {{--<input type="text" disabled id="prev_work_day_dt" name="prev_work_day_dt" class="data-trans-clss">--}}
                                            {{--</div>--}}


                                        </div>


                                    </div>
                                </div>

                            

                            {{--Product Target div--}}
                                <div class="col-md-12 col-sm-12 target-div" style="border: 1px solid #d8d2d2">
                                    <div class="form-group form-horizontal">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: #3f87a6"><b>Product Target</b></span>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Target Month:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" id="target_mon_pt" name="target_mon_pt" placeholder="01-Aug-18" disabled class="target-clss">

                                            </div>




                                        </div>

                                    </div>
                                </div>


                                {{--daily report div--}}
                                <div class="col-md-12 col-sm-12 daily-rep-div" style="border: 1px solid #d8d2d2">
                                    <div class="form-group form-horizontal">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: #3f87a6"><b>Daily Report</b></span>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Report Type:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled id="rep_type_dr" name="rep_type_dr" name="" class="daily-rep-clss">
                                            </div>

                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="p_group">
                                                <b>Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled id="work_date_dr" name="work_date_dr" class="daily-rep-clss">
                                            </div>


                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>2nd Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled id="2nd_work_day_dr" name="2nd_work_day_dr" class="daily-rep-clss">
                                            </div>



                                            

                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Previous Report Month:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled id="prev_rep_mon_dr" name="prev_rep_mon_dr" class="daily-rep-clss">
                                            </div>



                                        </div>
                                    </div>
                                </div>
                               


                                {{--closing report div--}}
                                <div class="col-md-12 col-sm-12 cls-rep-div" style="border: 1px solid #d8d2d2">
                                    <div class="form-group form-horizontal">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="color: #3f87a6"><b>Closing Report</b></span>
                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Sale Year:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled name="closing_sale_year" id="closing_sale_year" class="cls-rep-clss">
                                            </div>


                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>Sales Month:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled name="closing_sale_month" onkeyup="this.value = this.value.toUpperCase();"  id="closing_sale_month" class="cls-rep-clss">
                                            </div>


                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>Previous Sales Month:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled name="closing_prev_sale_month" onkeyup="this.value = this.value.toUpperCase();"  id="closing_prev_sale_month" class="cls-rep-clss">
                                            </div>



                                        </div>

                                    </div>

                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Report Type:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled name="closing_rep_type" id="closing_rep_type" class="cls-rep-clss">
                                            </div>


                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>1st Day of Report Month:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled name="closing_report_month" onkeyup="this.value = this.value.toUpperCase();"  id="closing_report_month" class="cls-rep-clss">
                                            </div>


                                            <label class="control-label col-md-2 col-sm-2 col-xs-2 input-sm" style="width: 12%;" for="terr_id">
                                                <b>Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-2">
                                                <input type="text" disabled name="closing_working_date" onkeyup="this.value = this.value.toUpperCase();"  id="closing_working_date" class="cls-rep-clss">
                                            </div>

                                             <input type="hidden" id="last_wd_cr_hd" value="{{$cls_last_wrday[0]->wdword}}">



                                        </div>

                                    </div>
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-2 col-sm-2 col-xs-6 input-sm" for="p_group">
                                                <b>Second Working Date:</b></label>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <input type="text" disabled name="closing_2nd_working_date" id="closing_2nd_working_date" class="cls-rep-clss">
                                            </div>





                                        </div>

                                    </div>

                                </div>

                              

                                {{--//button click--}}
                                <div class="col-md-12 col-sm-12 buttonareasub">
                                    <center>
                                        <div class="col-md-4 col-sm-4"></div>
                                        <div class="col-md-4 col-sm-4">
                                            <br>
                                        

                                            <button type="submit" class="btn btn-success btn-bg ladda-button" id="btn_display_u" data-style="zoom-in">
                                                <span class="ladda-label"><i class=" fa fa-check"></i>  <b>Process</b></span>
                                            </button>


                                        </div>
                                        <div class="col-md-4 col-sm-4"></div>
                                    </center>

                                </div>

                                {{--//message area show for success or error area--}}
                                <div class="col-md-12 col-sm-12 suc-err-msg" >
                                    <center>
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-8 col-sm-8 msgdiv">
                                            <br>
                                        

                                            


                                        </div>
                                        <div class="col-md-2 col-sm-2"></div>
                                    </center>

                                </div>


                        </form>

                    </div>

                </div>

                @elseif($working_day_submit=='yes')
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
                                <div class="alert alert-danger">
                                    <span>
                                        Please go to  <a href="{{url('repprocess/monthly_working_day')}}" style="color: blue">'Daily Data Process > MONTHLY Working Day' </a>navigation  and create 'working day for current month'
                                    </span>
                                </div>
                            <!-- </div> -->
                         </div>
                    </div>
                </div>

                @endif


                <!-- <div class="col-md-12 col-sm-12" id="loader" style="margin-top: 5px;">
                    <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                        <div class="panel">
                            <img src="{{url('public/site_resource/images/preloader.gif')}}"
                                 alt="Loading Report Please wait..." width="35px" height="35px"><br>
                            <span><b><i>Please wait...</i></b></span>
                        </div>
                    </div>
                </div> -->

                <div class="overlay">
                    <div id="loading-img"></div>
                </div>

               
            </section>
        </div>
     </div>
@section('scripts')

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    <script src="{{url('public/site_resource/spinner-btn/spin.min.js')}}"></script>
    <script src="{{url('public/site_resource/spinner-btn/ladda.min.js')}}"></script>

    <script src="{{url('public/site_resource/js/toast/toastr.min.js')}}"></script>


    <script>
        $(document).ready(function(){

            console.log("loading end...here...");
             $('.overlay').hide();


             var l,s_inter;

            /////////////////GLOBALLY DEFINE START///////
            var arrmonth = new Array();
            arrmonth[1] = 'JAN';
            arrmonth[2] ='FEB';
            arrmonth[3] ='MAR';
            arrmonth[4] ='APR';
            arrmonth[5] ='MAY';
            arrmonth[6] ='JUN';
            arrmonth[7] ='JUL',
            arrmonth[8] ='AUG';
            arrmonth[9] ='SEP',
            arrmonth[10] ='OCT',
            arrmonth[11] ='NOV',
            arrmonth[12] ='DEC'

            var arrmonth2 = new Array();
            arrmonth2[01] = 'JAN';
            arrmonth2[02] ='FEB';
            arrmonth2[03] ='MAR';
            arrmonth2[04] ='APR';
            arrmonth2[05] ='MAY';
            arrmonth2[06] ='JUN';
            arrmonth2[07] ='JUL',
            arrmonth2[08] ='AUG';
            arrmonth2[09] ='SEP',
            arrmonth2[10] ='OCT',
            arrmonth2[11] ='NOV',
            arrmonth2[12] ='DEC'

            var arrdaybar =new Array();
            arrdaybar[0] ='Sunday';
            arrdaybar[1] ='Monday';
            arrdaybar[2] ='Tuesday';
            arrdaybar[3] ='Wednesday';
            arrdaybar[4] ='Thursday';
            arrdaybar[5] ='Friday';
            arrdaybar[6] ='Saturday';


            var todaydat=$('#sysdate1').val();
            var todayminus1=$('#sysdate2').val();
            var todayminus2=$('#sysdate3').val();
            var todayminus3=$('#sysdate4').val();


            //Return today's date and time
            var currentTime = new Date();
            //Returns the month (from 0 to 11)
            var month = currentTime.getMonth(); //current month-1
            //returns the day of the month (from 1 to 31)
            var day = currentTime.getDate();
            //returns the year (four digits)
            //yeartt=2019; yr=19
            var fullyear = currentTime.getFullYear();
            var year = currentTime.getFullYear().toString().substr(-2);

            if(month==1){
                year=year-1;
                month=12;
            }else{
                year=year;
                month=month;
            }

            var daybar_r = arrdaybar[currentTime.getDay()];

            //6/7/2019
            // var curr_month_day_bar = $.format.date("2009-12-18 10:54:50.546", "ddd");
            // console.log(curr_month_day_bar);

            /////

            $('.buttonareasub').hide();
            $('.msgdiv').html(" ");

            console.log("working_day_statusid: "+$('#working_day_statusid').val());

            /////////////////GLOBALLY DEFINE END///////

            // 1st when tick appear after click-------------------------------------------
            //data transfer--------------------------------------------------------------
            $(document).on('click','input:checkbox.data-trans-btn',function(){
                console.log("data transfer uncheaked");
//              $(this).parent().parent().parent().css('background-color','red');
                var divareatotal=$(this).parent().parent().parent();
//                divareatotal.css('background-color','green');
                $(this).removeClass('data-trans-btn').addClass('data-trans-btn-chk');
                divareatotal.find('.data-trans-clss').parent().parent().parent().parent().css('background-color','#e4f0f5');
                divareatotal.find('.data-trans-clss').removeAttr('disabled');
                $('.buttonareasub').show();

                console.log("date format");


                ///////////////
                //Return today's date and time
                var currentTime = new Date();
                // console.log("currentTime");
                // console.log(currentTime);


                if(daybar_r=='Saturday'){
                    var dateArr_r=todayminus2.split('-');
                    console.log("dateArr_r :"+dateArr_r);

                    var secend_wd=todayminus1.split('-');
                    var Prev_wd=todayminus3.split('-');


                }else if(daybar_r=='Sunday'){

                    var dateArr_r=todayminus1.split('-');
                    console.log("dateArr_r :"+dateArr_r);

                    var secend_wd=todayminus1.split('-');
                    var Prev_wd=todayminus3.split('-');
                }else{
                    var dateArr_r=todayminus1.split('-');
                    console.log("dateArr_r :"+dateArr_r);

                    var secend_wd=todayminus1.split('-');
                    var Prev_wd=todayminus2.split('-');

                }


                var newDate_r=dateArr_r[0]+'-'+arrmonth[parseInt(dateArr_r[1])]+'-'+dateArr_r[2];
                var seconddate_r=secend_wd[0]+'-'+arrmonth[parseInt(secend_wd[1])]+'-'+secend_wd[2];
                var prevdate_r=Prev_wd[0]+'-'+arrmonth[parseInt(Prev_wd[1])]+'-'+Prev_wd[2];



                // returns the month (from 0 to 11)
                var month = currentTime.getMonth()+1; //current month-1
                var year = currentTime.getFullYear().toString().substr(-2); //yr2019
                console.log(1+"-"+arrmonth[month]+"-"+year);

                var day = currentTime.getDate();
                console.log("day "+day);




                //PLACEHOLDER-----------------------------------------------
                $('#1st_day_rep_mon_dt').attr("placeholder","13-AUG-18");
                $('#work_day_dt').attr("placeholder","9");
                $('#work_date_dt').attr("placeholder","13-AUG-18");
                $('#credit_date_dt').attr("placeholder","25-AUG-18");
                $('#rep_date_dt').attr("placeholder","13-AUG-18");
                $('#2nd_work_day_dt').attr("placeholder","13-AUG-18");
                $('#prev_work_day_dt').attr("placeholder","13-AUG-18");

                //VALUE AGAIN-----------------------------------------------
                //suppose month er 1st day but sei case to 'sept' hobe current 01-oct-2018
                if(day==1){
                    // console.log("hmm day 1");
                    //now if the moth is january then how we get december 
                    if(month==1){

                        $('#rep_type_dt option[value=CLOSING]').attr('selected','selected');
                        // console.log("month is 1");
                        $('#1st_day_rep_mon_dt').val('0'+1+"-"+arrmonth[12]+"-"+year);

                        //7.3.2019
                        $('#rep_mon_dt').val(arrmonth[12]+"-"+year);

                    }else{
                        // console.log("month is not 1"+month);
                        // console.log(arrmonth[month-1]);
                        $('#1st_day_rep_mon_dt').val('0'+1+"-"+arrmonth[month-1]+"-"+year);
                         //7.3.2019
                        $('#rep_mon_dt').val(arrmonth[month-1]+"-"+year);

                    }
                   
                }else{
                    // console.log("hmm day not 1");
                    $('#1st_day_rep_mon_dt').val('0'+1+"-"+arrmonth[month]+"-"+year);
                    //7.3.2019
                    $('#rep_mon_dt').val(arrmonth[month]+"-"+year);
                }

               
                $('#work_day_dt').val($('#work_day_dt_hd').val());
                $('#work_date_dt').val(newDate_r);
                console.log("length day");
//                day=09;

                var dlen=day.toString().length;
                console.log(dlen);
                if(dlen==1){
                    $('#rep_date_dt').val('0'+day+"-"+arrmonth[month]+"-"+year);
                }else if(dlen>1){
                    $('#rep_date_dt').val(day+"-"+arrmonth[month]+"-"+year);
                }
//                $('#rep_date_dt').val('0'+day+"-"+arrmonth[month]+"-"+year);
                $('#2nd_work_day_dt').val(seconddate_r);

                //if working day 1 thne 1st_day_rep_month hobe prev_working_date

                if($('#work_day_dt_hd').val()==1){
                    $('#prev_work_day_dt').val($('#1st_day_rep_mon_dt').val());
                }else{
                        $('#prev_work_day_dt').val(prevdate_r);
                }
            


                if($('#credit_date_hid').val()==" "){
                    $('#credit_date_dt').val($('#credit_date_hid').val());
//                    $('#credit_date_dt').attr('disabled','disabled');

                }else{

                    $('#credit_date_dt').removeAttr('disabled');
                    $('#credit_date_dt').val($('#credit_date_hid').val());

                }


                $('#prev_month_work_day_dt').val($('#prev_mont_wdate_hid').val());

                //                7.3.2019



                if($('input#holiday_mul').is(":checked")){
                    $('#working_multi_dt').val("yes_multi_wd");
                }
                else if($('input#holiday_mul').is(":not(:checked)")){
                    $('#working_multi_dt').val("no_multi_wd");
                }

                console.log(" dekhi : ",$('#working_multi_dt').val());




//

            });

//                7.3.2019
            $('#holiday_mul').on('click',function(){

                console.log("holiday_mul change");

                if($(this).is(":checked")){
                    $('#working_multi_dt').val("yes_multi_wd");
                }
                else if($(this).is(":not(:checked)")){
                    $('#working_multi_dt').val("no_multi_wd");
                }

                console.log(" dekhi 45 : ",$('#working_multi_dt').val());

            });


            //closing data
            $(document).on('click','input:checkbox.cls-data-btn',function(){
                console.log("cd");
//                $(this).parent().parent().parent().css('background-color','red');
                var divareatotal=$(this).parent().parent().parent();
//                divareatotal.css('background-color','green');
                $(this).removeClass('cls-data-btn').addClass('cls-data-btn-chk');

//                 Return today's date and time
                var currentTime = new Date();

                // returns the month (from 0 to 11)
                var month =currentTime.getMonth(); //current month-1

//                 returns the day of the month (from 1 to 31)
                var day = currentTime.getDate();

//                 returns the year (four digits)

//                yeartt=2019;
                var year = currentTime.getFullYear().toString().substr(-2);
//                year=yeartt.toString().substr(-2);

//                month=12;
////                console.log("month"+month);
//                year=2019;
//                day=1;
                if(month==1){
                    year=year-1;
                    month=12;
                }else{
                    year=year;
                    month=month;
                }


                var arrmonth = new Array();
                arrmonth[1] = 'JAN';
                arrmonth[2] ='FEB';
                arrmonth[3] ='MAR';
                arrmonth[4] ='APR';
                arrmonth[5] ='MAY';
                arrmonth[6] ='JUN';
                arrmonth[7] ='JUL',
                arrmonth[8] ='AUG';
                arrmonth[9] ='SEP',
                arrmonth[10] ='OCT',
                arrmonth[11] ='NOV',
                arrmonth[12] ='DEC'



                divareatotal.find('#cls-data-saleyr').val((arrmonth[month])+"-"+ year);
//                divareatotal.find('.cls-data-clss').parent().parent().parent().parent().css('background-color','#e4f0f5');
                divareatotal.find('.cls-data-clss').removeAttr('disabled');
                $('.buttonareasub').show();



            });

            //product target
            $(document).on('click','input:checkbox.target-btn',function(){
               console.log("target uncheaked");
//                $(this).parent().parent().parent().css('background-color','red');
                var divareatotal=$(this).parent().parent().parent();
//                divareatotal.css('background-color','green');
                $(this).removeClass('target-btn').addClass('target-btn-chk');
                divareatotal.find('.target-clss').parent().parent().parent().parent().css('background-color','#e4f0f5');
                divareatotal.find('.target-clss').removeAttr('disabled');
                $('.buttonareasub').show();

                // if()

//                 var currentTime = new Date();

//                 var t_month =currentTime.getMonth(); //current month-1

//                 var t_day = currentTime.getDate();

//                 var t_year = currentTime.getFullYear().toString().substr(-2);
//                 if(t_month==1){
//                     t_year=t_year-1;
//                     t_month=12;
//                 }else{
//                     t_year=t_year;
//                     t_month=t_month;
//                 }

// //              returns the day of the month (from 1 to 31)
//                 var t_day = currentTime.getDate();

//                 console.log("day 11111009999: "+t_day);
//                 if(t_day==1){
//                         console.log("t_month"+t_month);

//                         $('#target_mon_pt').val('0'+1+'-'+arrmonth[t_month]+'-'+t_year);
//                 }else{
//                      $('#target_mon_pt').val('0'+1+'-'+arrmonth[month+1]+'-'+year);
//                 }


                var arrOfMonth = [
                    'JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC'
                ];

                var currentTime = new Date();
                var target_month = currentTime.getMonth();
                var target_year = currentTime.getFullYear().toString().substr(-2);
                $('#target_mon_pt').val('01-'+arrOfMonth[target_month]+"-"+target_year);
   

            });

            //daily report
            $(document).on('click','input:checkbox.daily-rep-btn',function(){
                console.log("daily report uncheaked 1234");
                 //Return today's date and time
                var currentTime = new Date();

                var divareatotal=$(this).parent().parent().parent();

                $(this).removeClass('daily-rep-btn').addClass('daily-rep-btn-chk');
                divareatotal.find('.daily-rep-clss').parent().parent().parent().parent().css('background-color','#e4f0f5');
                divareatotal.find('.daily-rep-clss').removeAttr('disabled');
                $('.buttonareasub').show();


                ///
                //PLACEHOLDER-----------------------------------------------
                $('#rep_type_dr').attr("placeholder","DAILY");
                $('#work_date_dr').attr("placeholder","13-AUG-18");
                $('#2nd_work_day_dr').attr("placeholder","13-AUG-18");
                $('#prev_rep_mon_dr').attr("placeholder","JUL-18");

                //VALUE AGAIN-----------------------------------------------

                if($("#dt_chkid").prop('checked') == true){
                    console.log("kerhe");
                    var work_date_dt =$('#work_date_dt').val();
                    var second_work_day_dt =$('#2nd_work_day_dt').val();


                }else{
                      var daybar_r = arrdaybar[currentTime.getDay()];
                    console.log("not "+daybar_r);
                    //work date
                    if(daybar_r=='Saturday'){
                        var dateArr_r=todayminus2.split('-');
                        console.log("dateArr_r rrtt:"+dateArr_r);

                        var secend_wd=todayminus1.split('-');


                    }else{
                        var dateArr_r=todayminus1.split('-');
                        console.log("dateArr_r tt :"+dateArr_r);
                        var secend_wd=todayminus1.split('-');

                    }
                    var work_date_dt=dateArr_r[0]+'-'+arrmonth[parseInt(dateArr_r[1])]+'-'+dateArr_r[2];
                    var second_work_day_dt=secend_wd[0]+'-'+arrmonth[parseInt(secend_wd[1])]+'-'+secend_wd[2];




                }

                $('#rep_type_dr').val("DAILY");


                //------------------
                
                //Returns the month (from 0 to 11)
                var month = currentTime.getMonth(); //current month-1
                //returns the day of the month (from 1 to 31)
                // console.log('current month'+currentTime.getMonth());
                var day = currentTime.getDate();
                //returns the year (four digits)
                //yeartt=2019; yr=19
                var fullyear = currentTime.getFullYear();
                var year = currentTime.getFullYear().toString().substr(-2);

                if(month==0){
                    year=year-1;
                    month=12;
                // }else if(){

                }else{
                    year=year;
                    month=month;
                }

                var daybar_r = arrdaybar[currentTime.getDay()];



                console.log("try to change "+arrmonth[month]+'-'+year+' month: '+month+" "+daybar_r);




                $('#prev_rep_mon_dr').val(arrmonth[month]+'-'+year);
                $('#work_date_dr').val(work_date_dt);
                $('#2nd_work_day_dr').val(second_work_day_dt);




            });

            $('#rep_type_dt').on('change',function(){
                var furl="{!! URL::to('repprocess/getWorkingDay') !!}";
                var rep_type=$(this).val();
                $.ajax({
                    url: furl,
                    data:{'text':$('#work_date_dt').val(),'rep_type':rep_type},
                    type: "get",
                    success: function (data) {

                        console.log("here working day change depend on working date");
//                        console.log(parseInt(data['cmwd'][0]['working_date']).split('-')[0]));
                        console.log(parseInt((data['cmwd'][0]['working_date']).split('-')[0]));

                        console.log("bfhdf");

                        console.log(data['infobaseday']);
                        console.log(data);

//                        if(rep_type=='DAILY'){
//                            console.log("daily if enter");
                        var dayy=parseInt((data['cmwd'][0]['working_date']).split('-')[0]);
                        var monn=(data['cmwd'][0]['working_date']).split('-')[1];
                        var yr=(data['cmwd'][0]['working_date']).split('-')[2];


                        var credit_date=" ";
                        if(dayy >= 25){
                            credit_date="25-"+monn+"-"+yr;
                            $('#credit_date_dt').removeAttr('disabled');


                        }else{
                            credit_date=" ";
                            $('#credit_date_dt').val(" ");
//                            $('#credit_date_dt').attr('disabled','disabled');
                        }


                        $('#work_day_dt').val(data['cmwd'][0]['working_day']);
                        $('#credit_date_dt').val(credit_date);

                        $('#prev_month_work_day_dt').val(data['infobaseday'][0]['working_date']);
//                        }else if(rep_type=='CLOSING'){
//                            console.log(data['infobaseday']);
//                            console.log("closing if enter");
//                            $('#prev_month_work_day_dt').val("fdsg");
//                        }
//


                    },
                    error: function () {

                    }
                });
            });

            $('#work_date_dt').datetimepicker({
                format:'DD-MMM-YY'

            }).on('dp.change',function(event){
                console.log("selectedDate"+$(this).val());
                var furl="{!! URL::to('repprocess/getWorkingDay') !!}";
               var rep_type=$('#rep_type_dt').val();
                $.ajax({
                    url: furl,
                    data:{'text':$(this).val(),'rep_type':rep_type},
                    type: "get",
                    success: function (data) {

                        console.log("here working day change depend on working date");
//                        console.log(parseInt(data['cmwd'][0]['working_date']).split('-')[0]));
                        // console.log(parseInt((data['cmwd'][0]['working_date']).split('-')[0]));

                        // console.log("bfhdf");

                        // console.log(data['infobaseday']);
                        // console.log(data);

//                        if(rep_type=='DAILY'){
//                            console.log("daily if enter");
                            var dayy=parseInt((data['cmwd'][0]['working_date']).split('-')[0]);
                            var monn=(data['cmwd'][0]['working_date']).split('-')[1];
                            var yr=(data['cmwd'][0]['working_date']).split('-')[2];


                            var credit_date=" ";
                            if(dayy >= 25){
                                credit_date="25-"+monn+"-"+yr;
                                $('#credit_date_dt').removeAttr('disabled');

                            }else{
                                credit_date=" ";
                                $('#credit_date_dt').val(" ");
//                                $('#credit_date_dt').attr('disabled','disabled');
                            }


                            $('#work_day_dt').val(data['cmwd'][0]['working_day']);
                            $('#credit_date_dt').val(credit_date);

                            $('#prev_month_work_day_dt').val(data['infobaseday'][0]['working_date']);
//                        }else if(rep_type=='CLOSING'){
//                            console.log(data['infobaseday']);
//                            console.log("closing if enter");
//                            $('#prev_month_work_day_dt').val("fdsg");
//                        }
//


                    },
                    error: function () {

                    }
                });




            });

            $('#2nd_work_day_dt,#1st_day_rep_mon_dt,#prev_work_day_dt,#rep_date_dt').datetimepicker({
                format:'DD-MMM-YY'

            });
          

            //closing report
              //closing report
            $(document).on('click','input:checkbox.cls-rep-btn',function(){
               console.log("closing report uncheaked");
//                $(this).parent().parent().parent().css('background-color','red');
                var divareatotal=$(this).parent().parent().parent();
//                divareatotal.css('background-color','green');
                $(this).removeClass('cls-rep-btn').addClass('cls-rep-btn-chk');
                divareatotal.find('#cls-rep-saleyr').val((new Date()).getFullYear());
                divareatotal.find('.cls-rep-clss').parent().parent().parent().parent().css('background-color','#e4f0f5');
                divareatotal.find('.cls-rep-clss').removeAttr('disabled');
                $('.buttonareasub').show();


                //PLACEHOLDER-----------------------------------------------
                $('#closing_sale_year').attr("placeholder","2018"); //NN
                $('#closing_sale_month').attr("placeholder","JUL-18");  //NN
                $('#closing_prev_sale_year').attr("placeholder","JUN-18");

                $('#closing_rep_type').attr("placeholder","CLOSING");
                $('#closing_report_month').attr("placeholder","01-JUL-18"); //NN
                $('#closing_working_date').attr("placeholder","11-AUG-18");

                $('#closing_2nd_working_date').attr("placeholder","11-AUG-18");


                //VALUE AGAIN-----------------------------------------------


//                    console.log("not");
                    var ss_wd_tot="";
                    //work date
                    if(daybar_r=='Saturday'){
                        var dateArr_r=todayminus2.split('-');
                        console.log("dateArr_r :"+dateArr_r);

                        var secend_wd=todayminus1.split('-');


                        var ss_wd_dd=parseInt(($('#last_wd_cr_hd').val().split('-'))[0])+1;
                        var ss_wd_mm=($('#last_wd_cr_hd').val().split('-'))[1];
                        var ss_wd_yy=($('#last_wd_cr_hd').val().split('-'))[2];
                        var ss_wd_tot=ss_wd_dd+'-'+ss_wd_mm+'-'+ss_wd_yy;


                    }else{
                        var dateArr_r=todayminus1.split('-');
                        console.log("dateArr_r :"+dateArr_r);
                        var secend_wd=todayminus1.split('-');

                        var ss_wd_tot=$('#last_wd_cr_hd').val();


                    }
                    var work_date_dt=dateArr_r[0]+'-'+arrmonth[parseInt(dateArr_r[1])]+'-'+dateArr_r[2];
                    var second_work_day_dt=secend_wd[0]+'-'+arrmonth[parseInt(secend_wd[1])]+'-'+secend_wd[2];

                    var  last_cls_wk_dt=$('#last_wd_cr_hd').val();
                    // var last_cls_2nd_wk_dt=ss_wd_tot;

                    console.log("last "+last_cls_wk_dt);


                $('#closing_sale_year').val(fullyear); //NN
                $('#closing_sale_month').val(arrmonth[month]+'-'+year);  //NN
                $('#closing_prev_sale_month').val(arrmonth[(month-1)]+'-'+year);

                $('#closing_rep_type').val("CLOSING");
                $('#closing_report_month').val('0'+1+'-'+arrmonth[month]+'-'+year) //NN

                // last_wd_cr_hd
                // $('#closing_working_date').val(work_date_dt);

                // $('#closing_2nd_working_date').val(second_work_day_dt);

                 $('#closing_working_date').val(last_cls_wk_dt);

                $('#closing_2nd_working_date').val(last_cls_wk_dt);






            });



            //year closing report
            $(document).on('click','input:checkbox.yrcls-rep-btn',function(){

                var divareatotal=$(this).parent().parent().parent();

                $(this).removeClass('yrcls-rep-btn').addClass('yrcls-rep-btn-chk');
                divareatotal.find('.yrcls-rep-clss').parent().parent().parent().parent().css('background-color','#e4f0f5');
                divareatotal.find('.yrcls-rep-clss').removeAttr('disabled');
                $('.buttonareasub').show();

            });

            //when tick appear----------------- before click----------------------------------------
            //data transfer

            $(document).on('click','input:checkbox.data-trans-btn-chk',function(){

                var indexsum=0;
                $('input:checkbox:checked').each(function(index,element){
                    indexsum=indexsum+1;
                });

                if(indexsum==0){
                    $('.buttonareasub').hide();
                    $('.msgdiv').html(" ");
                }

                var divareatotal=$(this).parent().parent().parent();
                $(this).removeClass('data-trans-btn-chk').addClass('data-trans-btn');
                divareatotal.find('.data-trans-clss').attr('disabled','disabled');
                $(".data-trans-div").css("background-color","white");

                //empty the input fields after uncheck
                $('#1st_day_rep_mon_dt').val("");
                $('#work_day_dt').val("");
                $('#work_date_dt').val("");
                $('#rep_date_dt').val("");
                $('#2nd_work_day_dt').val("");
                $('#prev_work_day_dt').val("");
                $('#prev_month_work_day_dt').val("");
                $('#credit_date_dt').val("");


            });
            //closing data
            $(document).on('click','input:checkbox.cls-data-btn-chk',function(){

                var indexsum=0;
                $('input:checkbox:checked').each(function(index,element){
                    indexsum=indexsum+1;

                });

                if(indexsum==0){
                    $('.buttonareasub').hide();
                    $('.msgdiv').html(" ");
                }

                var divareatotal=$(this).parent().parent().parent();
                $(this).removeClass('cls-data-btn-chk').addClass('cls-data-btn');
                divareatotal.find('.cls-data-clss').attr('disabled','disabled');
                divareatotal.find('.cls-data-clss').val(" ");
                $(".cls-data-div").css("background-color","white");

            });

            //product target
            $(document).on('click','input:checkbox.target-btn-chk',function(){

                var indexsum=0;
                $('input:checkbox:checked').each(function(index,element){
                    indexsum=indexsum+1;

                });

                if(indexsum==0){
                    $('.buttonareasub').hide();
                    $('.msgdiv').html(" ");
                }
                var divareatotal=$(this).parent().parent().parent();
                $(this).removeClass('target-btn-chk').addClass('target-btn');
                divareatotal.find('.target-clss').attr('disabled','disabled');
                $(".target-div").css("background-color","white");

                $('#target_mon_pt').val(" ");

            });
            //daily report
            $(document).on('click','input:checkbox.daily-rep-btn-chk',function(){

                var indexsum=0;
                $('input:checkbox:checked').each(function(index,element){
                    indexsum=indexsum+1;
                });

                if(indexsum==0){
                    $('.buttonareasub').hide();
                    $('.msgdiv').html(" ");
                }
                var divareatotal=$(this).parent().parent().parent();
                $(this).removeClass('daily-rep-btn-chk').addClass('daily-rep-btn');
                divareatotal.find('.daily-rep-clss').attr('disabled','disabled');
                $(".daily-rep-div").css("background-color","white");


                //PLACEHOLDER remove-----------------------------------------------
                $('#rep_type_dr').attr("placeholder"," ");
                $('#work_date_dr').attr("placeholder"," ");
                $('#2nd_work_day_dr').attr("placeholder","");
                $('#prev_rep_mon_dr').attr("placeholder","");

                //VALUE AGAIN remove-----------------------------------------------
                $('#rep_type_dr').val(" ");
                $('#work_date_dr').val(" ");
                $('#2nd_work_day_dr').val("");
                $('#prev_rep_mon_dr').val("");



            });

            //closing report
            //closing report
            $(document).on('click','input:checkbox.cls-rep-btn-chk',function(){
//                console.log("data transfer checked to unchecked");
                var indexsum=0;
                $('input:checkbox:checked').each(function(index,element){
                    indexsum=indexsum+1;

                });

                if(indexsum==0){
                    $('.buttonareasub').hide();
                    $('.msgdiv').html(" ");
                }

                var divareatotal=$(this).parent().parent().parent();
                $(this).removeClass('cls-rep-btn-chk').addClass('cls-rep-btn');
                divareatotal.find('.cls-rep-clss').attr('disabled','disabled');
                divareatotal.find('.cls-rep-clss').val(" ");
                $(".cls-rep-div").css("background-color","white");

            });


            //----------------PROCESS
            // process

            // 8.7.2019-------------------------------------------
            function ajaxCall() {
                //do your AJAX stuff here
                $.ajax({
                    type: 'POST',
                    data: {'_token':"{{csrf_token()}}"},
                    url:"{!! URL::to('repprocess/daily_data_process_dtstatus_post') !!}",
                    success: function (response) {

                        if(response.dtstatus=='done_suc'){
                            var msddd;

                            msddd='';
                            msddd+='<br><div class="alert alert-success">';
                            msddd+='<span>';
                            // msddd+=' Error! Please try to run the procedure again';
                            msddd+=' Sucessfully Done.';
                            msddd+='</span>';
                            msddd+='</div>';

                            $('.msgdiv').html(msddd);
                              l.stop();
                              clearInterval(s_inter);
                        }

                        // else if(response.dtstatus=='done_error'){
                        //     var msddd;

                        //     msddd='';
                        //     msddd+='<br><div class="alert alert-danger">';
                        //     msddd+='<span>';
                        //     // msddd+=' Error! Please try to run the procedure again';
                        //     msddd+=' Runtime Error! Please Contact with IT Dept.';
                        //     msddd+='</span>';
                        //     msddd+='</div>';

                        //     $('.msgdiv').html(msddd);
                        // }

                          

                    },
                    error: function () {

                    }
                });
            }


            ////click on btn_display_u
            $(document).on('submit', '#frmdailyproc', function (event) {

                event.preventDefault();

                console.log("submit");

                $('.msgdiv').html(" ");

                var status,tt;
                $('input[type=checkbox]:checked').each(function(){
                    ///////////////////////////////////////////
                    console.log($(this).attr('class').split('-btn-chk')[0]+'-div');
                    var divzone=$(this).attr('class').split('-btn-chk')[0]+'-div';


                    $('.'+divzone+' input').each(function(){
                        if($(this).val()==''){
                            console.log($(this).attr('id'));
                            if($(this).attr('id')!='prev_work_day_dt'){

                                status='empty';
                                console.log(status);
                                // return false;
                                $(this).css('border-color','red');
                            }
                        }


                    });


                    ////////////////////////////////////////////////////////////////////////////


                });


                if(status=='empty'){

                    // toastr["error"]("Plase fill up the all fields")
                    // toastr.options = {
                    // "closeButton": true,
                    // "debug": false,
                    // "newestOnTop": false,
                    // "progressBar": false,
                    // "positionClass": "toast-top-center",
                    // "preventDuplicates": false,
                    // "onclick": null,
                    // "showDuration": "300",
                    // "hideDuration": "1000",
                    // "timeOut": "10000",
                    // "extendedTimeOut": "1000",
                    // "showEasing": "swing",
                    // "hideEasing": "linear",
                    // "showMethod": "fadeIn",
                    // "hideMethod": "fadeOut"
                    // }

                    // make it not dissappear
                    toastr.error("Please fill up the all fields", {
                        "timeOut": "0",
                        "extendedTImeout": "0"
                    });


                }

                if(status!='empty'){

                    var form = $('#frmdailyproc');

                    var formData = form.serialize();

                    var url = "{{URL::to('repprocess/daily_data_process_post')}}";
                    var type = 'post';


                    var dt=pt=cd=dr=cr=ycr='no';

                    console.log("formData");
                    console.log(formData);

                    $("input[type=checkbox]:checked").each(function(){

                        var class_name=$(this).attr('class');
                        if(class_name=="data-trans-btn-chk"){
                            dt='yes';
                        }else if(class_name=="cls-data-btn-chk"){
                            cd='yes';
                        }else if(class_name=="target-btn-chk"){
                            pt='yes';
                        }else if(class_name=="daily-rep-btn-chk"){
                            dr='yes';
                        }else if(class_name=="cls-rep-btn-chk"){
                            cr='yes';
                        }else if(class_name=="yrcls-rep-btn-chk"){
                            ycr='yes';
                        }


                    });


                    l = Ladda.create(document.querySelector('#btn_display_u'));
                    l.start();


                    ///................

                    $('#messg').hide();

                    $.ajax({
                        type: type,
                        url: url,
                        data: {fd:formData,dt:dt,cd:cd,pt:pt,dr:dr,ycr:ycr,cr:cr,'_token':"{{csrf_token()}}"},

                        success: function (response) {
                            console.log("response");
                            console.log(response);


                            if(response.total_message == 'DTotal') {
                                console.log("DTotal");

                                // Set extendedTimeOut to 0 too. That will keep it sticky.

                                // toastr["success"]("Successfully Data Process Done")
                                // toastr.options = {
                                //     "closeButton": true,
                                //     "debug": false,
                                //     "newestOnTop": false,
                                //     "progressBar": false,
                                //     "positionClass": "toast-top-center",
                                //     "preventDuplicates": false,
                                //     "onclick": null,
                                //     "showDuration": "300",
                                //     "hideDuration": "1000",
                                //     "timeOut": "10000",
                                //     // "extendedTimeOut": "1000",
                                //      "extendedTimeOut": "0",
                                //     "showEasing": "swing",
                                //     "hideEasing": "linear",
                                //     "showMethod": "fadeIn",
                                //     "hideMethod": "fadeOut"
                                // }

                                 // make it not dissappear
                                // toastr.success("Successfully Data Process Done",{
                                //     "timeOut": "0",
                                //     "extendedTImeout": "0"
                                // });

                                 var msddd;

                            msddd='';
                            msddd+='<br><div class="alert alert-success">';
                            msddd+='<span>';
                            msddd+=' Successfully Data Process Done';
                            msddd+='</span>';
                            msddd+='</div>';
                            
                            $('.msgdiv').html(msddd);

                            l.stop();


                            }else if(response.total_message == 'NotDTotal'){
                                         console.log("notDTotal");

                                            // toastr["error"]("Error! Please try to run the procedure again")
                                            // toastr.options = {
                                            //     "closeButton": true,
                                            //     "debug": false,
                                            //     "newestOnTop": false,
                                            //     "progressBar": false,
                                            //     "positionClass": "toast-top-center",
                                            //     "preventDuplicates": false,
                                            //     "onclick": null,
                                            //     "showDuration": "300",
                                            //     "hideDuration": "1000",
                                            //     "timeOut": "10000",
                                            //     // "extendedTimeOut": "1000",
                                            //     "extendedTimeOut": "0",
                                            //     "showEasing": "swing",
                                            //     "hideEasing": "linear",
                                            //     "showMethod": "fadeIn",
                                            //     "hideMethod": "fadeOut"
                                            // }

                                            // make it not dissappear
                                // toastr.error("Error! Please try to run the procedure again",{
                                //     "timeOut": "0",
                                //     "extendedTImeout": "0"
                                // });

                                
                                //---------------------7.3.2019------------
                                

                                //8.7.2019---

                                s_inter=setInterval(ajaxCall, 60000); //300000 MS == 5 minutes




                                // var msddd;

                                // msddd='';
                                // msddd+='<br><div class="alert alert-danger">';
                                // msddd+='<span>';
                                // // msddd+=' Error! Please try to run the procedure again';
                                // msddd+=' Runtime Error! Please Contact with IT Dept.';
                                // msddd+='</span>';
                                // msddd+='</div>';
                                
                                // $('.msgdiv').html(msddd);

                            }




                            if(response.message_status == 'done') {
                                console.log("s1");
                            }
                            if(response.message_status2 == 'done') {
                                console.log("s2");

                                // toastr["success"]("Successfully Data Process Done")
                                // toastr.options = {
                                //     "closeButton": true,
                                //     "debug": false,
                                //     "newestOnTop": false,
                                //     "progressBar": false,
                                //     "positionClass": "toast-top-center",
                                //     "preventDuplicates": false,
                                //     "onclick": null,
                                //     "showDuration": "300",
                                //     "hideDuration": "1000",
                                //     "timeOut": "10000",
                                //      // "extendedTimeOut": "1000",
                                //      "extendedTimeOut": "0",
                                //     "showEasing": "swing",
                                //     "hideEasing": "linear",
                                //     "showMethod": "fadeIn",
                                //     "hideMethod": "fadeOut"
                                // }
                                 // make it not dissappear
                                // toastr.success("Successfully Data Process Done",{
                                //     "timeOut": "0",
                                //     "extendedTImeout": "0"
                                // });

                                var msddd;

                            msddd='';
                            msddd+='<br><div class="alert alert-success">';
                            msddd+='<span>';
                            msddd+=' Successfully Data Process Done';
                            msddd+='</span>';
                            msddd+='</div>';
                            
                            $('.msgdiv').html(msddd);

                            l.stop();



                            }

                            if(response.message_status3 == 'done') {
                                console.log("s3");
                            }
                            if(response.message_status4 == 'done') {
                                console.log("s4");
                            }
                            if(response.message_status5 == 'done') {
                                console.log("s5");
                            }
                            if(response.message_status6 == 'done') {
                                console.log("s6");
                            }
                            if(response.message_status7 == 'done') {
                                console.log("s7");
                            }
                            if(response.message_status8 == 'done') {
                                console.log("s8");
                            }
                            if(response.message_status9 == 'done') {
                                console.log("s9");
                            }

                            if(response.message_status37 == 'done') {
                                console.log("s37");
                            }



                            // l.stop();
                        },
                        error: function (error) {
                            console.log("wrong...............cr");
                            console.log(error);
                            console.log(error.status);

                            // toastr["error"]("Error!Please Run the process again");
                            //     toastr.options = {
                            //         "closeButton": true,
                            //         "debug": false,
                            //         "newestOnTop": false,
                            //         "progressBar": false,
                            //         "positionClass": "toast-top-center",
                            //         "preventDuplicates": false,
                            //         "onclick": null,
                            //         "showDuration": "300",
                            //         "hideDuration": "1000",
                            //         "timeOut": "0",
                            //          // "extendedTimeOut": "1000",
                            //          "extendedTimeOut": "0",
                            //         "showEasing": "swing",
                            //         "hideEasing": "linear",
                            //         "showMethod": "fadeIn",
                            //         "hideMethod": "fadeOut"
                            //     }

                                // make it not dissappear
                                // toastr.error("Error!Please Run the process again",{
                                //     "timeOut": "0",
                                //     "extendedTImeout": "0"
                                // });

                                                                //---------------------7.3.2019------------
                                // $.ajax({
                                //     type: 'POST',
                                //     data: {'_token':"{{csrf_token()}}"},
                                //     url:"{!! URL::to('repprocess/daily_data_process_dtstatus_post') !!}",
                                //     success: function (response) {

                                //         if(response.dtstatus=='done_suc'){
                                //             var msddd;

                                //             msddd='';
                                //             msddd+='<br><div class="alert alert-success">';
                                //             msddd+='<span>';
                                //             // msddd+=' Error! Please try to run the procedure again';
                                //             msddd+=' Sucessfully Done.';
                                //             msddd+='</span>';
                                //             msddd+='</div>';

                                //             $('.msgdiv').html(msddd);
                                //         }else if(response.dtstatus=='done_error'){
                                //             var msddd;

                                //             msddd='';
                                //             msddd+='<br><div class="alert alert-danger">';
                                //             msddd+='<span>';
                                //             // msddd+=' Error! Please try to run the procedure again';
                                //             msddd+=' Runtime Error! Please Contact with IT Dept.';
                                //             msddd+='</span>';
                                //             msddd+='</div>';

                                //             $('.msgdiv').html(msddd);
                                //         }



                                //     },
                                //     error: function () {

                                //     }
                                // });

                                s_inter=setInterval(ajaxCall, 60000); 


                                // var msddd;

                                // msddd='';
                                // msddd+='<br><div class="alert alert-danger">';
                                // msddd+='<span>';
                                // // msddd+=' Error! Please try to run the procedure again';
                                // msddd+=' Runtime Error! Please Contact with IT Dept.';
                                // msddd+='</span>';
                                // msddd+='</div>';
                                
                                // $('.msgdiv').html(msddd);



                            // l.stop();
                        }
                    });
                }





            });




            //validate start
            var validateDateString = (function() {
                var monthNamesString = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
                var monthNames = monthNamesString.toLowerCase().split("|");
                var dateValidateRex = new RegExp("^(\\d{1,2})-(" + monthNamesString + ")-(\\d{2})$", "i");
                var arbitraryCenturyCutoff = 30;

                function validateDateString(str) {
                    var match;
                    var day, month, year;
                    var dt;

                    match = dateValidateRex.exec(str);
                    if (!match) {
                        return false;
                    }
                    day   = parseInt(match[1]);
                    month = monthNames.indexOf(match[2].toLowerCase()); // You may need a shim on very old browsers for Array#indexOf
                    year  = parseInt(match[3], 10);
                    year += year > arbitraryCenturyCutoff ? 1900 : 2000;

                    dt = new Date(year, month, day);

                    console.log("Resulting date: " + dt.toString());
                    if (dt.getDate() !== day ||
                            dt.getMonth() !== month ||
                            dt.getFullYear() !== year) {
                        // The input was invalid; we know because the date object
                        // had to adjust something
                        return false;
                    }
                    return true;
                }

                return validateDateString;
            })();

            //validate end

            //when writing in
            $(document).on('keyup','input#work_date_dt',function(){
                var text = $(this).val();
                var valid = validateDateString(text);

                console.log(valid);
                if(valid==true){
                    var furl="{!! URL::to('repprocess/getWorkingDay') !!}";
                    $.ajax({
                        url: furl,
                        data:{'text':text},
                        type: "get",
                        success: function (data) {
                            console.log(data[0]['working_day']);

                            $('#work_day_dt').val(data[0]['working_day']);
                        },
                        error: function () {

                        }
                    });
                }

            });



            ////////////////////////sale report module show and hide...update menu_display table....28.11.2018
            $(document).on('click','.sale_report_shbtn',function(){



                $.ajax({
                    type: "GET",
                    url:"{!! URL::to('get_menu_display_datapro')!!}",
                    success: function (data){

                        console.log("get_menu_display_datapro");
                        console.log("get_menu_display_datapro "+data.menu_show_sta);



                        if(data.menu_show_sta=='no'){
                            $('.sale_report_shbtn').html(" ");
                            $('.sale_report_shbtn').html('<button class="btn btn-primary">Display the "Sale report" module</button>');
                        }else if(data.menu_show_sta=='yes'){
                            $('.sale_report_shbtn').html(" ");
                            $('.sale_report_shbtn').html('<button class="btn btn-info">Hide the "Sale report" module</button>');
                        }


                        toastr["success"]("Status Change")
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
                    error:function(data){
                        alert("error ");

                    }
                });

            });


            ////////////////////////END END sale report module show and hide...update menu_display table....28.11.2018

        });
    </script>
@endsection
@endsection