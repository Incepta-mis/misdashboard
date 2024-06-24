@extends('_layout_shared._master')
@section('title','Team Growth%')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

    <style>

        table.dataTable tbody th,
        table.dataTable tbody td {
            white-space: nowrap;
            padding: 2px;
        }
        table.dataTable tfoot th {
            padding: 2px;
        }

        th {
            white-space: nowrap;
            overflow: hidden;
            color: #003399;
            font-size: 10px;
        }

        td {
            white-space: nowrap;
            overflow: hidden;
            color: #0c0c0c;
            font-size: 10px;
        }

        header.panel-heading {
            color: #003399;
        }

        .dataTables_filter {
            display: none;
        }

        .dt-buttons {
            float: right;
        }

        table {
            margin: 0 auto;
            /*width: 100%;*/
            clear: both;
            border-collapse: collapse;
            table-layout: fixed;
        / / * * * * * * * * * * * add this word-wrap: break-word;
        / / * * * * * * * * * * * and this
        }

        .month {
            width: 55%;
        }

        .pgr {
            width: 50%;
            font-weight: bold;
        }

        .fixed {
            position: fixed;
            z-index: 1;
            top: 50px
        }

        .cmColor {
            background-color: #FDE9D9;
            color: darkblue;
        }

        .hColor {
            background-color: #CCFFCC;
        }

        .dataTables_scroll {
            overflow: auto;
        }

        .my-sticky-element.stuck {
            position: fixed;
            top: 50px;
            /*box-shadow:0 2px 4px rgba(0, 0, 0, .3);*/
        }

        .my-sticky-element {
            z-index: 1;
        }

        #task_flyout {
            top: 50px;
        }

        /*//////////////////////*/

        .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
            color: #fff;
            background-color: #337ab7;
        }

        .nav-pills>li>a {
            border-radius: 4px;
        }
        .nav-pills>li>a {
            border-radius: 4px;
        }
        .nav>li>a {
            position: relative;
            display: block;
            padding: 10px 15px;
        }
        a:focus, a:hover {
            color: #23527c;
            text-decoration: underline;
        }

        .panel-heading .nav > li.active > a, .panel-heading .nav > li > a:hover {
            color: #fff;
            background-color: #337ab7;
        }

        /*///////////////////////////*/
        .style_right_align{
            text-align:right
        }
        /*table#sumry .pgr{*/
            /*text-transform: lowercase;*/
        /*}*/

        .style_mid_align{
            text-align:center
        }

        .style_totst_align{
            text-align:right;
            font-weight: bold;
            background-color: #ffd5cc;
        }

        .month{
            font-weight: bold;
        }

        /*table#sumrynw tbody tr td[title]:hover:after {
              content: attr(title);
              padding: 4px 8px;
              color: #333;
              background-color: green;
        }


        .panel-heading .nav > li > a {
            color: #080808;
        }*/
        /*//10.4.2019*/
        .wrapper {
            padding-top: 0px;
        }
        .panel{
            margin-bottom: 5px;
        }


    </style>
@endsection

@section('right-content')


    <div class="row">

        <div>
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="padding-top: 5px;padding-bottom: 0px;">
                        <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3 text-center">Team wise Sales 
                        </div>
                        {{--<div class="col-md-12 col-sm-12">--}}
                            {{--<hr style="margin: 0px;">--}}
                        {{--</div>--}}
                        <div class="col-sm-4 col-md-4 col-md-offset-4 col-sm-offset-4 text-center">Figures in <span style="color:green">Crore</span>&nbsp;&nbsp;&nbsp;&nbsp; <span style="color:purple">BDT</span>
                        </div>
                        <br>
                        <br>
                    </header>
                </section>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="task_flyout" class="my-sticky-element">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="padding-top: 0px;padding-bottom: 0px;">
                        <div>
                            <div class="col-sm-5 col-md-5">
                                <div class="col-sm-9 col-md-9">
                                    <table class="display table  table-bordered table-striped table-responsive">
                                        <tr>
                                            <th class="cmColor" width="45%"></th>
                                            <th class="cmColor"><!-- {{ date('Y') -2 }} --> {{$maxyearminus2}}</th>
                                            <th class="cmColor"><!-- {{ date('Y') -1 }} --> {{$maxyearminus1}}</th>
                                            <th class="cmColor"><!-- {{ date('Y')  }} --> {{$maxyear}}</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-3 col-md-3" style="padding-left:  3px;">
                                    <table class="display table table-bordered table-striped table-responsive">
                                        <tr>
                                            <tr>
                                             <td colspan="2" style="padding: 0px;text-align: center;" class="cmColor">Growth%</td>
                                        </tr>
                                            <tr>
                                                <th style="text-align: center; padding: 2px;" class="cmColor"><!-- {{ date('Y') -1 }} -->{{$maxyearminus1}}</th>
                                                <th style="text-align: center; padding: 2px;" class="cmColor"><!-- {{ date('Y') }} -->{{$maxyear}}</th>
                                            </tr>

                                        </tr>
                                    </table>
                                </div>

                            </div>

                        </div>
                        <br>
                        <br>
                    </header>
                </section>
            </div>
        </div>
    </div>
    {{--Summary--}}

    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #fde9d9;">
                        <label style="margin-bottom:0;">Summary: Total Sales Growth Analysis</label>
                    </header>

                   <!--  <header class="panel-heading">
                        <label style="margin-bottom: 0; background-color: #FFFF00;">Summary: Total Sales Growth Analysis</label>
                    </header>
                     -->


                    <div class="panel-body" style="padding-top: 16px;">


                          <span style="margin-left:16px;margin-bottom: 0;font-weight:bold;color:black; background-color:#7DEE8;">Team wise total depot sales</span>


                        <div class="col-sm-9 col-md-9 table-responsive">


                            <table id="sumry" class="display table table-condensed table-bordered table-striped"
                                   width="40%">
                                <thead style="display: none">

                                </thead>

                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;">Sub-Total</th>
                                    <th class="teamwtotal_1styear" style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_2ndyear" style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_3rdyear" style="background-color: #CCFFCC;"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-sm-3 col-md-3 table-responsive">
                            <table id="sumry1" class="display table table-condensed table-bordered table-striped">
                                <thead style="display: none">

                                </thead>

                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_calcugwt" style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_calcugwt2" style="background-color: #CCFFCC;"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>

            </div>
            {{--<br><br>--}}
            <div class="col-sm-7 col-md-7">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color:#ddf6ff">
                        <label style="margin-bottom: 0px;">
                            <ul class="nav nav-pills">
                                <li class="active"><a data-toggle="pill" href="#home"><!-- {{ date('Y') }} --> {{$maxyear}}</a></li>
                                <li><a data-toggle="pill" href="#menu1"><!-- {{ date('Y')-1 }} --> {{$maxyearminus1}}</a></li>
                                <li><a data-toggle="pill" href="#menu2">Growth %</a></li>
                                
                            </ul>
                        </label>
                       


                    </header>

                    <div class="adv-table table-responsive">

                     

                        {{--///////////////////////////////--}}
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">

                                <table id="month_sum" class=" table table-condensed table-bordered table-striped">
                                    <thead>

                                    <tr>
                                        <th></th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>May</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Tot</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="jan_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="feb_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="mar_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="apr_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="may_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="jun_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="jul_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="aug_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="sep_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="oct_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="nov_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="dec_2018_tot1" style="background-color: #CCFFCC;"></th>
                                        <th class="tot_2018_tot1" style="background-color: #ffd5cc;"></th>
                                    </tr>
                                    </tfoot>
                                </table>

                                {{--</p>--}}
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                {{--<h3>Menu 1</h3>--}}
                                <table id="sum2017_abovefirst" class=" table table-condensed table-bordered table-striped">
                                <thead>

                                <tr>
                                <th></th>
                                <th>Jan</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Apr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Aug</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dec</th>
                                <th>Tot</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;"></th>


                                    <th class="jan_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="feb_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="mar_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="apr_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="may_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="jun_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="jul_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="aug_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="sep_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="oct_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="nov_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="dec_2017_tot1" style="background-color: #CCFFCC;"></th>
                                    <th class="tot_2017_tot1" style="background-color: #ffd5cc;"></th>
                                </tr>
                                </tfoot>
                                </table>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                {{--<h3>Menu 2</h3>--}}
                                <table id="sumgwth_abovefirst" class=" table table-condensed table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Apr</th>
                                            <th>May</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Aug</th>
                                            <th>Sep</th>
                                            <th>Oct</th>
                                            <th>Nov</th>
                                            <th>Dec</th>
                                            <th>Tot</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th style="background-color: #CCFFCC;"></th>

                                            <th class="jan_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="feb_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="mar_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="apr_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="may_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="jun_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="jul_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="aug_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="sep_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="oct_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="nov_gwt_tot1" style="background-color: #CCFFCC;"></th>
                                            <th class="dec_gwt_tot1" style="background-color: #CCFFCC;"></th>

                                            <th class="tot_gwt_tot1" style="background-color: #ffd5cc;"></th>
                                          
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                        {{--///////--}}

                    </div>

                </section>
            </div>



        </div>
    </div>
    {{--Summary-2--}}

    <!-- start here -->
  @if( Auth::user()->user_id=='1000085' || $status_admin=='full')
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                     <!--    {{--<label style="margin-bottom: 0px; background-color: #FFFF00;">Summary</label>--}}
<label style="margin-bottom: 0px;">Team wise total institute & export sales</label> -->
                    </header>
                    <div class="panel-body" style="padding-top: 36px;">
                        <!-- <span style="margin-left:16px;margin-bottom: 0px;font-weight: bold;
    color: black; background-color: #B7DEE8;">Team wise total institute & export sales</span> -->
     <span style="margin-left:16px;margin-bottom: 0;font-weight:bold;color:black; background-color:#7DEE8;">Team wise total institute & export sales</span>
                        <div class="col-sm-9 col-md-9 table-responsive">
                            <table id="sumrynw" class="display table table-condensed table-bordered table-striped"
                                   width="40%">
                                <thead style="display: none;">
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;">Sub-Total</th>
                                    <th class="teamwtotal_1styear2" style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_2ndyear2" style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_3rdyear2" style="background-color: #CCFFCC;"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-sm-3 col-md-3 table-responsive">
                            <table id="sumrynw1" class="display table table-condensed table-bordered table-striped">
                                <thead style="display: none;">

                                </thead>

                                <tfoot>
                                <tr>
                                    <th style="background-color: #CCFFCC;"></th>                        
                                    <th class="teamwtotal_calcugwt02" style="background-color: #CCFFCC;"></th>
                                    <th class="teamwtotal_calcugwt202" style="background-color: #CCFFCC;"></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>

            </div>

            <div class="col-sm-7 col-md-7">
                <section class="panel" id="data_table">

                    <header class="panel-heading" style="background-color: #ddf6ff;">

                        <label style="margin-bottom: 0px;">
                            <ul class="nav nav-pills">
                                <!-- <li class="active"><a data-toggle="pill" href="#hometot">{{ date('Y') }}</a></li>
                                <li><a data-toggle="pill" href="#menu1tot">{{ date('Y')-1 }}</a></li>
                                <li><a data-toggle="pill" href="#menu2tot">Growth %</a></li> -->

                                <li class="active"><a data-toggle="pill" href="#hometot">{{$maxyear}}</a></li>
                                <li><a data-toggle="pill" href="#menu1tot">{{$maxyearminus1}}</a></li>
                                <li><a data-toggle="pill" href="#menu2tot">Growth %</a></li>

                            </ul>
                        </label>
                    </header>


                    <div class="adv-table table-responsive">


                        {{--///////////////////////////////--}}
                        <div class="tab-content">
                            <div id="hometot" class="tab-pane fade in active">
                               
                                <table id="month_sum2" class=" table table-condensed table-bordered table-striped">
                                    <thead>

                                    <tr>
                                        <th></th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>May</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Tot</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="jan_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="feb_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="mar_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="apr_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="may_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="jun_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="jul_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="aug_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="sep_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="oct_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="nov_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="dec_2018_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="tot_2018_tot2" style="background-color: #ffd5cc;"></th>



                                    </tr>
                                    </tfoot>
                                </table>

                            </div>



                            <div id="menu1tot" class="tab-pane fade">

                                <table id="sum2017_downfirst" class=" table table-condensed table-bordered table-striped">
                                    <thead>

                                    <tr>
                                        <th></th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>May</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Tot</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>

                                        <th class="jan_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="feb_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="mar_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="apr_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="may_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="jun_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="jul_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="aug_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="sep_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="oct_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="nov_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="dec_2017_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="tot_2017_tot2" style="background-color: #ffd5cc;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div id="menu2tot" class="tab-pane fade">

                                <table id="sumgwth_downfirst" class=" table table-condensed table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Jan</th>
                                        <th>Feb</th>
                                        <th>Mar</th>
                                        <th>Apr</th>
                                        <th>May</th>
                                        <th>Jun</th>
                                        <th>Jul</th>
                                        <th>Aug</th>
                                        <th>Sep</th>
                                        <th>Oct</th>
                                        <th>Nov</th>
                                        <th>Dec</th>
                                        <th>Tot</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="jan_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="feb_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="mar_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="apr_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="may_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="jun_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="jul_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="aug_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="sep_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="oct_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="nov_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="dec_gwt_tot2" style="background-color: #CCFFCC;"></th>
                                        <th class="tot_gwt_tot2" style="background-color: #ffd5cc;"></th>
                                       
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>

                    </div>




                </section>
            </div>

        </div>
    </div>
    {{--summary-total--}}




    {{--//summary total fooetr --}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color:#ddf6ff">
                        <label style="margin-bottom: 0px;">Total sales</label>
                    </header>
                    <!-- <div class="panel-body" style="padding-top: 20px;"> -->
                    <div class="panel-body" style="padding: 0px;">
                        <div class="col-sm-9 col-md-9 table-responsive">
                            <table class="display table  table-bordered table-striped table-responsive">
                                <tr>
                                    <th class="cmColor" style="padding: 2px;" width="45%">Total Sales</th>
                                    @foreach($gtotal as $tval)
                                        <th class="cmColor style_right_align" id="totalsyear" style="padding:2px;">
                                             <?php echo number_format( $tval->syear , 2, '.', ','); ?>

                                        </th>
                                        <th class="cmColor style_right_align" id="totalsyear1" style="padding:2px;">
                                             <?php echo number_format( $tval->syear1 , 2, '.', ','); ?>
                                        </th>
                                        <th class="cmColor style_right_align" id="totalsyear2" style="padding:2px;">
                                            <?php echo number_format( $tval->syear2 , 2, '.', ','); ?>
                                        </th>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 col-md-3 table-responsive">
                            <table class="display table table-bordered table-striped table-responsive">
                                <tr>
                                    @foreach($gtotal as $tval)
                                        <th style="text-align: center; padding: 2px;" id="totalsummaryoldyr" class="cmColor style_right_align">{{ $tval->syear1g }}</th>
                                        <th style="text-align: center; padding: 2px;" id="totalsummarynewyr" class="cmColor style_right_align">{{ $tval->syear2g }}</th>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

            </div>

            <div class="col-sm-7 col-md-7">
                <section class="panel" id="data_table">

                    <header class="panel-heading" style="background-color: #ddf6ff;">

                        <label style="margin-bottom: 0px;">
                            <ul class="nav nav-pills">
                                <!-- <li class="active"><a data-toggle="pill" href="#hometotalfinal">{{ date('Y') }}</a></li>
                                <li><a data-toggle="pill" href="#menu1totalfinal">{{ date('Y')-1 }}</a></li>
                                <li><a data-toggle="pill" href="#menu2totalfinal">Growth</a></li> -->

                                <li class="active"><a data-toggle="pill" href="#hometotalfinal">{{$maxyear}}</a></li>
                                <li><a data-toggle="pill" href="#menu1totalfinal">{{$maxyearminus1}}</a></li>
                                <li><a data-toggle="pill" href="#menu2totalfinal">Growth %</a></li>
                                
                            </ul>
                        </label>
                    </header>


                    <div class="adv-table table-responsive">
                        <div class="tab-content">
                            <div id="hometotalfinal" class="tab-pane fade in active">
                                <table class="display table table-bordered table-striped table-responsive">
                                    <tr>
                                        @foreach($gtotal as $tval)
                                            <th class="cmColor text-center gtotal_jan style_right_align" style="padding: 2px;">
                                                
                                            <?php echo number_format( $tval->jan , 2, '.', ',');?>
                                            </th>
                                            
                                            <th class="cmColor text-center gtotal_feb style_right_align" style="padding: 2px;">
                                           
                                              <?php echo number_format( $tval->feb , 2, '.', ',');?>
                                              </th>
                                            </th>
                                            <th class="cmColor text-center gtotal_mar style_right_align" style="padding: 2px;">
                                           
                                              <?php echo number_format( $tval->mar , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_apr style_right_align" style="padding: 2px;">
                                          
                                              <?php echo number_format( $tval->apr , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_may style_right_align" style="padding: 2px;">
                                        
                                              <?php echo number_format( $tval->may , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_jun style_right_align" style="padding: 2px;">
                                           
                                              <?php echo number_format( $tval->jun , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_jul style_right_align" style="padding: 2px;">
                                            
                                              <?php echo number_format( $tval->jul , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_aug style_right_align" style="padding: 2px;">
                                         
                                              <?php echo number_format( $tval->aug , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_sep style_right_align" style="padding: 2px;">
                                         
                                              <?php echo number_format( $tval->sep , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_oct style_right_align" style="padding: 2px;">
                                           
                                            <?php echo number_format( $tval->oct , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_nov style_right_align" style="padding: 2px;">
                                         
                                            <?php echo number_format( $tval->nov , 2, '.', ',');?>
                                            </th>
                                            <th class="cmColor text-center gtotal_dec style_right_align" style="padding: 2px;">
                                        
                                              <?php echo number_format( $tval->dec , 2, '.', ',');?></th>
                                            </th>
                                            <th  class="cmColor text-center gtotal_tot style_right_align" style="padding: 2px;background-color: #ffd5cc">
                                            <?php echo number_format( $tval->tot , 2, '.', ','); ?> 
                                        
                                                
                                            </th>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>

                            <div id="menu1totalfinal" class="tab-pane fade">
                                <table class="table table-bordered table-striped table-responsive">
                                    <tr>
                                        @foreach($gtotal1 as $tval)
                                            <th class="cmColor text-center gtotal1_jan style_right_align" style="padding: 2px;">{{$tval->jan}}</th>
                                            <th class="cmColor text-center gtotal1_feb style_right_align" style="padding: 2px;">{{$tval->feb}}</th>
                                            <th class="cmColor text-center gtotal1_mar style_right_align" style="padding: 2px;">{{$tval->mar}}</th>
                                            <th class="cmColor text-center gtotal1_apr style_right_align" style="padding: 2px;">{{$tval->apr}}</th>
                                            <th class="cmColor text-center gtotal1_may style_right_align" style="padding: 2px;">{{$tval->may}}</th>
                                            <th class="cmColor text-center gtotal1_jun style_right_align" style="padding: 2px;">{{$tval->jun}}</th>
                                            <th class="cmColor text-center gtotal1_jul style_right_align" style="padding: 2px;">{{$tval->jul}}</th>
                                            <th class="cmColor text-center gtotal1_aug style_right_align" style="padding: 2px;">{{$tval->aug}}</th>
                                            <th class="cmColor text-center gtotal1_sep style_right_align" style="padding: 2px;">{{$tval->sep}}</th>
                                            <th class="cmColor text-center gtotal1_oct style_right_align" style="padding: 2px;">{{$tval->oct}}</th>
                                            <th class="cmColor text-center gtotal1_nov style_right_align" style="padding: 2px;">{{$tval->nov}}</th>
                                            <th class="cmColor text-center gtotal1_dec style_right_align" style="padding: 2px;">{{$tval->dec}}</th>
                                            <th class="cmColor text-center gtotal1_tot style_right_align" style="padding: 2px;background-color: #ffd5cc"><?php echo number_format( $tval->tot , 2, '.', ','); ?> <!-- {{$tval->tot}} --></th>
                                        @endforeach
                                    </tr>

                                    </table>
                            </div>
                            <div id="menu2totalfinal" class="tab-pane fade">

                                <table class="table table-bordered table-striped table-responsive">
                                    <tr>

                                            <th id="" class="cmColor text-center gtotal2_jan style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_feb style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_mar style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_apr style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_may style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_jun style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_jul style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_aug style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_sep style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_oct style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_nov style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_dec style_right_align" style="padding: 2px;"></th>
                                            <th id="" class="cmColor text-center gtotal2_tot style_right_align" style="padding: 2px;"></th>

                                    </tr>
                                    </table>
                            </div>
                        </div>


                    </div>




                </section>
            </div>

        </div>
    </div>

    <!-- end here -->
    @endif
{{--/////////////////////////////////////////////////////////////////////////////////--}}
{{--//////////////////month wise--}}

    {{--month wise depot sales gwt excld+incd diaper and animal --}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="hColor" style="margin-bottom: 0px;">Month wise depot sales growth analysis (<span style="background-color: #a9ff00;">Excluding</span> Diaper & Animal Products)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_monexcld" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="mon_excld_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="mon_excld_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="mon_excld_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_monexcld" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="mon_excld_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="mon_excld_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        {{--//summary total fooetr  month wise depot sales gwt excld+incd diaper and animal --}}

                        <div class="col-sm-9 col-md-9 table-responsive">
                            <table class="display table  table-bordered table-striped table-responsive">
                                <tr>
                                    <th class="cmColor" style="padding: 2px;" width="45%" text="Cumulative sales growth %">Cumulative sales grwth %</th>
                                    @foreach($mon_excl_da_gwth as $tval)
                                        <!-- <th class="cmColor style_right_align" id="cum" style="padding: 2px;"> -->
                                            <th class="cmColor style_right_align" id="cum" style="padding: 2px;">
                                            <?php 
                                                echo number_format( $tval->syear , 2, '.', ',');
                                            ?>
                                             
                                         </th>
                                         <th class="cmColor style_right_align" id="m" style="padding: 2px;">
                                            <?php 
                                                echo number_format( $tval->syear1 , 2, '.', ',');
                                            ?>
                                             
                                         </th>
                                         <th class="cmColor style_right_align" id="m" style="padding: 2px;">
                                            <?php 
                                                echo number_format( $tval->syear2 , 2, '.', ',');
                                            ?>
                                             
                                         </th>

                                         <!-- {{ $tval->syear }}</th> -->
                                       <!--  <th class="cmColor style_right_align" id="m" style="padding: 2px;">{{ $tval->syear1 }}</th>
                                        <th class="cmColor style_right_align" id="m" style="padding: 2px;">{{ $tval->syear2 }}</th> -->
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 col-md-3 table-responsive">
                            <table class="display table table-bordered table-striped table-responsive">
                                <tr>
                                    @foreach($mon_excl_da_gwth as $tval)
                                        <th style="text-align: center; padding: 2px;" id="m" class="cmColor style_right_align">{{ $tval->syear1g }}</th>
                                        <th style="text-align: center; padding: 2px;" id="m" class="cmColor style_right_align">{{ $tval->syear2g }}</th>
                                    @endforeach
                                </tr>
                            </table>
                        </div>


                    </div>
                </section>


            </div>


        </div>


    </div>

    {{--//summary total fooetr  month wise depot sales gwt excld+incd diaper and animal --}}
    

    {{--month wise depot sales gwt excld+incd diaper and animal --}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="hColor" style="margin-bottom: 0px;">Month wise depot sales growth analysis (<span style="background-color: #a9ff00;">Including</span> Diaper & Animal Products)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_monincld" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="mon_incld_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="mon_incld_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="mon_incld_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_monincld" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="mon_incld_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="mon_incld_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        {{--//summary total fooetr  month wise depot sales gwt incd diaper and animal --}}

                        <div class="col-sm-9 col-md-9 table-responsive">
                            <table class="display table  table-bordered table-striped table-responsive">
                                <tr>
                                    <th class="cmColor" style="padding: 2px;" width="45%" text="Cumulative sales growth %">Cumulative sales grwth %</th>
                                    @foreach($mon_incl_da_gwth as $tval)
                                        <!-- <th class="cmColor style_right_align" id="cum" style="padding: 2px;">{{ $tval->syear }}</th> -->
                                         <th class="cmColor style_right_align" id="cum" style="padding: 2px;">
                                            <?php 
                                                echo number_format( $tval->syear , 2, '.', ',');
                                            ?>
                                             
                                         </th>
                                        <th class="cmColor style_right_align" id="m" style="padding: 2px;">
                                             <?php 
                                                echo number_format( $tval->syear1 , 2, '.', ',');
                                            ?>
                                        </th>
                                        <th class="cmColor style_right_align" id="m" style="padding: 2px;"><?php 
                                                echo number_format( $tval->syear2 , 2, '.', ',');
                                            ?>
                                         </th>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-3 col-md-3 table-responsive">
                            <table class="display table table-bordered table-striped table-responsive">
                                <tr>
                                    @foreach($mon_incl_da_gwth as $tval)
                                        <th style="text-align: center; padding: 2px;" id="m" class="cmColor style_right_align">{{ $tval->syear1g }}</th>
                                        <th style="text-align: center; padding: 2px;" id="m" class="cmColor style_right_align">{{ $tval->syear2g }}</th>
                                    @endforeach
                                </tr>
                            </table>
                        </div>



                    </div>
                </section>


            </div>


        </div>



    </div>
    {{--//summary total fooetr  month wise depot sales gwt incd diaper and animal --}}
    

{{--///month wise end--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #FFFFCC;">
                        <label style="margin-bottom: 0px;">Individual team wise depot sales growth analysis</label>
                    </header>
                </section>
            </div>
        </div>
    </div>


    {{--astergyrus--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px;">Aster-Gyrus</label>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="col-sm-9 col-md-9 table-responsive" >
                                <table id="team_growth_table"
                                       class="display table-condensed table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="aster_gyrusoldyear" style="background-color: #CCFFCC;"></th>
                                        <th class="aster_gyrusnewyear" style="background-color: #CCFFCC;"></th>
                                        <th class="aster_gyrussecnewyear" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_aster"
                                       class="display table-condensed table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="aster_gyrus_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="aster_gyrus_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>


            </div>


            <div class="col-sm-7 col-md-7">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-4" style="border: 1px solid black;background-color:#CCFFCC; "><center>Aster</center></div>
                            <div class="col-md-4 col-sm-4" style="border: 1px solid black;background-color:#CCFFCC; "><center>Gyrus</center></div>
                            <div class="col-md-4 col-sm-4" style="border: 1px solid black;background-color:#CCFFCC; " ><center>Total</center></div>

                        </div>

                        <br>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <div class="col-sm-12 col-md-12  table-responsive">
                                <table id="team_AG" class="display table table-bordered table-striped">
                                    <thead style="display:none">

                                    <tr>
                                        <th></th>
                                        <th>Aster</th>
                                        <th>Gyrus</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    {{--ope xen--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px;">OPE-XEN (incl. Hormone)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_OXtable" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th style="background-color: #CCFFCC;"></th>
                                            <th style="background-color: #CCFFCC;">Total</th>
                                            <th class="op_xen_1styear" style="background-color: #CCFFCC;"></th>
                                            <th class="op_xen_2ndyear" style="background-color: #CCFFCC;"></th>
                                            <th class="op_xen_3rdyear" style="background-color: #CCFFCC;"></th>

                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_operon" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="op_xen_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="op_xen_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>


            </div>

           
        </div>
    </div>
    {{--Special Team--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color:#FDE9D9">
                        <label class="cmColor" style="margin-bottom: 0px; ">Special Team</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_sps" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #FDE9D9;"></th>
                                        <th style="background-color: #FDE9D9;">Total</th>
                                        <th class="specialteam_1styear" style="background-color: #FDE9D9;"></th>
                                        <th class="specialteam_2ndyear" style="background-color: #FDE9D9;"></th>
                                        <th class="specialteam_3rdyear" style="background-color: #FDE9D9;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_spt" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #FDE9D9;"></th>
                                        <th style="background-color: #FDE9D9;"></th>
                                        <th class="specialteam_calcugwt" style="background-color: #FDE9D9;"></th>
                                        <th class="specialteam_calcugwt2" style="background-color: #FDE9D9;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>


            </div>

        </div>
    </div>
    {{--Cellbiotics--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Cellbiotics (incl. Human Vaccine)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_CLtable" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="cellbiotic_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="cellbiotic_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="cellbiotic_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_CL" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="cellbiotic_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="cellbiotic_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>


            </div>

        </div>
    </div>
    {{--Kinetix--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Kinetix (incl. Hospicare)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_KL" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="kinetix_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>

                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_KL" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    {{--Zymos--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px;">Zymos (incl. Herbal & Nutricare)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_ZY" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="zymos_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="zymos_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="zymos_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_ZY" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="zymos_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="zymos_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>

            </div>

        </div>
    </div>

    {{--General Team--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color:#FDE9D9 ">
                        <label class="cmColor" style="margin-bottom: 0px;">General Team</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_gn" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #FDE9D9;"></th>
                                        <th style="background-color: #FDE9D9;">Total</th>
                                        <th class="generalteam_1styear" style="background-color: #FDE9D9;"></th>
                                        <th class="generalteam_2ndyear" style="background-color: #FDE9D9;"></th>
                                        <th class="generalteam_3rdyear" style="background-color: #FDE9D9;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_gns" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #FDE9D9;"></th>
                                        <th style="background-color: #FDE9D9;"></th>
                                        <th class="generalteam_calcugwt" style="background-color: #FDE9D9;"></th>
                                        <th class="generalteam_calcugwt2" style="background-color: #FDE9D9;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            </div>

        </div>
    </div>
    {{--hygiene (Diaper)--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px;">HYGIENE (Diaper)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_TSO" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="hdiaper_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="hdiaper_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="hdiaper_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_TSO" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="hdiaper_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="hdiaper_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>

    {{--Animal Health--}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Animal Health</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_AH" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="animal_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="animal_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="animal_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>

                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_AH" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="animal_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="animal_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </div>
    {{--Animal vaccine----------------------------------------}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Animal Vaccine</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_AV" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="animalv_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="animalv_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="animalv_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>

                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_AV" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="animalv_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="animalv_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </div>
    {{--Kinetix inter company--------------------------------------}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Inter Company Sales (Hospicare)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_KLINTER" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="kinetix_inter_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>

                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_KLINTER" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    {{--HYGIENE company--------------------------------------}}
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Inter Company Sales/Intra Company Transfer (HYGIENE)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_hygiene" class="display table table-bordered table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="kinetix_inter_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>

                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_hygiene" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-5 col-md-5">
                <section class="panel" id="data_table">
                    <header class="panel-heading" style="background-color: #CCFFCC">
                        <label class="hColor" style="margin-bottom: 0px; ">Inter Company Sales (Herbal Nutricare)</label>

                    </header>
                    <div class="panel-body">
                        <div class="adv-table">

                            <div class="col-sm-9 col-md-9 table-responsive">
                                <table id="team_table_herbalNutricare" class="display table table-bordered
                                table-striped"
                                       style="table-layout: fixed">
                                    <thead style="display: none;">

                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;">Total</th>
                                        <th class="kinetix_inter_1styear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_2ndyear" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_3rdyear" style="background-color: #CCFFCC;"></th>

                                    </tr>
                                    </tfoot>
                                </table>

                            </div>

                            <div class="col-sm-3 col-md-3  table-responsive">
                                <table id="team_herbalNutricare" class="display table table-bordered table-striped">
                                    <thead style="display: none">


                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_calcugwt" style="background-color: #CCFFCC;"></th>
                                        <th class="kinetix_inter_calcugwt2" style="background-color: #CCFFCC;"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    {{--Skin Products (Transferred)--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="col-sm-5 col-md-5">--}}
                {{--<section class="panel" id="data_table">--}}
                    {{--<header class="panel-heading" style="background-color: #CCFFCC">--}}
                        {{--<label class="hColor" style="margin-bottom: 0px;">Skin Products</label>--}}

                    {{--</header>--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="adv-table">--}}

                            {{--<div class="col-sm-9 col-md-9 table-responsive">--}}
                                {{--<table id="team_table_sk" class="display table table-bordered table-striped"--}}
                                       {{--style="table-layout: fixed">--}}
                                    {{--<thead style="display: none;">--}}

                                    {{--</thead>--}}

                                    {{--<tfoot>--}}
                                    {{--<tr>--}}
                                        {{--<th style="background-color: #CCFFCC;"></th>--}}
                                        {{--<th style="background-color: #CCFFCC;">Total</th>--}}
                                        {{--<th style="background-color: #CCFFCC;"></th>--}}
                                        {{--<th style="background-color: #CCFFCC;"></th>--}}
                                        {{--<th style="background-color: #CCFFCC;"></th>--}}

                                    {{--</tr>--}}
                                    {{--</tfoot>--}}
                                {{--</table>--}}

                            {{--</div>--}}
                           {{--<!--  <div class="col-sm-3 col-md-3  table-responsive" style="background-color: #FDE9D9;">--}}
                                {{----}}
                                {{--<span style="color: red">--}}
                                    {{--** From June 2016, Sales of skin products has included with the sales of respective product groups.--}}
                                {{--</span>--}}
                            {{--</div> -->--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</section>--}}


            {{--</div>--}}

            {{--<div class="col-sm-4 col-md-4">--}}

                {{--<section class="panel" id="data_table">--}}
                    {{--<header class="panel-heading">--}}
                        {{--<label class="hColor" style="margin-bottom: 0px;"></label>--}}

                    {{--</header>--}}
                    {{--<!-- <div class="panel-body" style="background-color: #FDE9D9;"> -->--}}
                    {{--<div class="panel-body" style="background-color:#f2dede;"> --}}


                        {{--<!-- <div class="row">--}}
                            {{--<div class="col-lg-12"> -->--}}
                              {{--<div class="alert alert-danger" role="alert">--}}
                                {{--<div class="row vertical-align">--}}
                                  {{--<div class="col-xs-1 text-center">--}}
                                    {{--<i class="fa fa-exclamation-triangle fa-2x"></i> --}}
                                  {{--</div>--}}
                                  {{--<div class="col-xs-11">--}}
                                    {{--<strong>Note:</strong> ** From June 2016, Sales of skin products has included with the sales of respective product groups.--}}
                                  {{--</div>--}}
                                {{--</div>--}}
                              {{--</div>      --}}
                          {{--<!--   </div>--}}
                          {{--</div> -->--}}


                    {{--<!-- ///////////////////////// -->--}}
                    {{--</div>--}}
                {{--</section>--}}

               {{--<!-- <div class="col-sm-3 col-md-3  table-responsive" style="background-color: #FDE9D9;"> -->--}}
                   {{----}}
                {{--</div>--}}
            {{--</div>--}}
    {{--</div>--}}





    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/custom/script_tgp.js')}}

    <script>

        /////




        //////
        $(window).load(function () {
            $.ajax({
                url: "{{url('srep/resp_tgp_data')}}",
                type: "GET",
                success: function (response) {
                    console.log("response[16]");
                    console.log( response);
//                    console.log("response[17]");
//                    console.log(response[17]);
                    load_tables(response[0], response[1], response[2], response[3], response[4], response[5],
                        response[6], response[7], response[8], response[9], response[10], response[11],
                        response[12], response[13], response[14], response[15], response[16], response[17],
                        response[18], response[19], response[20], response[21], response[22], response[23],
                        response[24],response[25],response[26],response[27],response[28],response[29],
                            response[30],response[31],response[32],response[33],response[34],response[35]
                            ,response[36],response[37],response[38],response[39],response[40],response[41],
                        response[42],response[43]
                    );


//                    $(".pgr").attr("data-popover",true);
//                    $(".pgr").attr("data-html",true);
//                    $(".pgr").attr("data-content","try not to disappear");



                    //summary total footer

                    var totalsyear = parseFloat($('#totalsyear').html().replace(/,/g, ""));
                    var totalsyear1 = parseFloat($('#totalsyear1').html().replace(/,/g, ""));
                    var totalsyear2 = parseFloat($('#totalsyear2').html().replace(/,/g, ""));


                    var totalsummaryoldyr=(((totalsyear1-totalsyear)/totalsyear)*100).toFixed(2);

                    var totalsummarynewyr=(((totalsyear2-totalsyear1)/totalsyear1)*100).toFixed(2);

//                    if(totalsummarynewyr==0){
//
//                    }else{
//                        var jan_gwt_tot1=(((jan_2018_tot1-jan_2017_tot1)/jan_2017_tot1)*100).toFixed(2);

                    $('#totalsummaryoldyr').html(totalsummaryoldyr);
                    $('#totalsummarynewyr').html(totalsummarynewyr)

//                    if(totalsummarynewyr<0){
//                        $('#totalsummarynewyr').html("-");
//                    }else{
//                        $('#totalsummarynewyr').html(totalsummarynewyr)
//                    }


//                    console.log(totalsyear);
//                    console.log(totalsyear1);
//                    console.log(totalsyear2);

                    //////////////////////////////////////////////////////////////////////////////////////////////





                    ////jan current year
                    var gtotal_jan = parseFloat($('.gtotal_jan').html().replace(/,/g, ""));

//                    console.log(gtotal_jan);
                    var gtotal1_jan = parseFloat($('.gtotal1_jan').html().replace(/,/g, ""));
//                    console.log(gtotal1_jan);
                        var gtotal2_jan=(((gtotal_jan-gtotal1_jan)/gtotal1_jan)*100).toFixed(2);
                        $('.gtotal2_jan').html(gtotal2_jan+"%");



                    ////feb current year
                    var gtotal_feb = parseFloat($('.gtotal_feb').html().replace(/,/g, ""));
                    var gtotal1_feb = parseFloat($('.gtotal1_feb').html().replace(/,/g, ""));
                        var gtotal2_feb=(((gtotal_feb-gtotal1_feb)/gtotal1_feb)*100).toFixed(2);
                        $('.gtotal2_feb').html(gtotal2_feb+"%");


                    ////mar current year
                    var gtotal_mar = parseFloat($('.gtotal_mar').html().replace(/,/g, ""));
                    var gtotal1_mar = parseFloat($('.gtotal1_mar').html().replace(/,/g, ""));
                        var gtotal2_mar=(((gtotal_mar-gtotal1_mar)/gtotal1_mar)*100).toFixed(2);
                        $('.gtotal2_mar').html(gtotal2_mar+"%");


                    ////apr current year
                    var  gtotal_apr = parseFloat($('.gtotal_apr').html().replace(/,/g, ""));
                    var  gtotal1_apr = parseFloat($('.gtotal1_apr').html().replace(/,/g, ""));

                        var gtotal2_apr=((( gtotal_apr- gtotal1_apr)/gtotal1_apr)*100).toFixed(2);
                        $('.gtotal2_apr').html( gtotal2_apr+"%");



                    ////may current year
                    var gtotal_may = parseFloat($('.gtotal_may').html().replace(/,/g, ""));
                    var gtotal1_may = parseFloat($('.gtotal1_may').html().replace(/,/g, ""));

                        var gtotal2_may=(((gtotal_may-gtotal1_may)/gtotal1_may)*100).toFixed(2);
                        $('.gtotal2_may').html(gtotal2_may+"%");

                    ////jun current year
                    var gtotal_jun = parseFloat($('.gtotal_jun').html().replace(/,/g, ""));
                    var gtotal1_jun = parseFloat($('.gtotal1_jun').html().replace(/,/g, ""));
                        var gtotal2_jun=(((gtotal_jun-gtotal1_jun)/gtotal1_jun)*100).toFixed(2);
                        $('.gtotal2_jun').html(gtotal2_jun+"%");


                    ////jul current year
                    var gtotal_jul = parseFloat($('.gtotal_jul').html().replace(/,/g, ""));
                    var gtotal1_jul = parseFloat($('.gtotal1_jul').html().replace(/,/g, ""));
                       var gtotal2_jul=(((gtotal_jul-gtotal1_jul)/gtotal1_jul)*100).toFixed(2);
                        $('.gtotal2_jul').html(gtotal2_jul+"%");





                    ///aug
                    var gtotal_aug = parseFloat($('.gtotal_aug').html().replace(/,/g, ""));
                    var gtotal1_aug = parseFloat($('.gtotal1_aug').html().replace(/,/g, ""));

                        var gtotal2_aug=(((gtotal_aug-gtotal1_aug)/gtotal1_aug)*100).toFixed(2);
                        $('.gtotal2_aug').html(gtotal2_aug+"%");



                    ////sept current year
                    var gtotal_sep = parseFloat($('.gtotal_sep').html().replace(/,/g, ""));
                    var gtotal1_sep = parseFloat($('.gtotal1_sep').html().replace(/,/g, ""));

                        var gtotal2_sep=(((gtotal_sep-gtotal1_sep)/gtotal1_sep)*100).toFixed(2);
                       
                        if(parseInt(gtotal2_sep)==parseInt(-100.00)){
                            console.log("ENTER DIVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");
                            $('.gtotal2_sep').html(parseFloat(0.00).toFixed(2));
                        }else{
                             $('.gtotal2_sep').html(gtotal2_sep+"%");
                        }

                    ////oct current year
                    var  gtotal_oct = parseFloat($('.gtotal_oct').html().replace(/,/g, ""));
                    var  gtotal1_oct = parseFloat($('.gtotal1_oct').html().replace(/,/g, ""));

                        var  gtotal2_oct=((( gtotal_oct- gtotal1_oct)/ gtotal1_oct)*100).toFixed(2);
                        console.log("--1000000 data "+gtotal2_oct);

                        if(parseInt(gtotal2_oct)==parseInt(-100.00)){
                            console.log("ENTER DIVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");
                            $('.gtotal2_oct').html(parseFloat(0.00).toFixed(2));
                        }else{
                            $('.gtotal2_oct').html( gtotal2_oct+"%");
                        }
                        

                    ////nov current year
                    var gtotal_nov=parseFloat($('.gtotal_nov').html().replace(/,/g, ""));
                    var gtotal1_nov=parseFloat($('.gtotal1_nov').html().replace(/,/g, ""));

                        var gtotal2_nov=(((gtotal_nov-gtotal1_nov)/gtotal1_nov)*100).toFixed(2);
                       

                         if(parseInt(gtotal2_nov)==parseInt(-100.00)){
                            console.log("ENTER DIVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");
                            $('.gtotal2_nov').html(parseFloat(0.00).toFixed(2));
                        }else{
                             $('.gtotal2_nov').html(gtotal2_nov+"%");
                        }



                    ////dec current year
                    var gtotal_dec = parseFloat($('.gtotal_dec').html().replace(/,/g, ""));
                    var gtotal1_dec =parseFloat($('.gtotal1_dec').html().replace(/,/g, ""));

                        var gtotal2_dec=(((gtotal_dec-gtotal1_dec)/gtotal1_dec)*100).toFixed(2);
                       

                         if(parseInt(gtotal2_dec)==parseInt(-100.00)){
                            console.log("ENTER DIVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");
                            $('.gtotal2_dec').html(parseFloat(0.00).toFixed(2));
                        }else{
                            $('.gtotal2_dec').html(gtotal2_dec+"%");
                        }

                    ////tot grwth year
                    var gtotal_tot = parseFloat($('.gtotal_tot').html().replace(/,/g, ""));
                    var gtotal1_tot =parseFloat($('.gtotal1_tot').html().replace(/,/g, ""));

                    var gtotal2_tot=(((gtotal_tot-gtotal1_tot)/gtotal1_tot)*100).toFixed(2);
                   

                     if(parseInt(gtotal2_tot)==parseInt(-100.00)){
                            console.log("ENTER DIVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV");
                            $('.gtotal2_tot').html(parseFloat(0.00).toFixed(2));
                        }else{
                             $('.gtotal2_tot').html(gtotal2_tot+"%");
                        }




                    /////*********end
                    // ////////////////////////////////////////////
                    ////////////////////////Team wise total sales

                    var teamwtotal_1styear = parseFloat($('.teamwtotal_1styear').html().replace(/,/g, ""));
                    var teamwtotal_2ndyear = parseFloat($('.teamwtotal_2ndyear').html().replace(/,/g, ""));
                    var teamwtotal_3rdyear = parseFloat($('.teamwtotal_3rdyear').html().replace(/,/g, ""));

                    var teamwtotal_calcugwt=(((teamwtotal_2ndyear-teamwtotal_1styear)/teamwtotal_1styear)*100).toFixed(2);

                    var teamwtotal_calcugwt2=(((teamwtotal_3rdyear-teamwtotal_2ndyear)/teamwtotal_2ndyear)*100).toFixed(2);



                    $('.teamwtotal_calcugwt').html(teamwtotal_calcugwt);
                    $('.teamwtotal_calcugwt2').html(teamwtotal_calcugwt2);

                    ////jan current year
                    var jan_2018_tot1 = parseFloat($('.jan_2018_tot1').html().replace(/,/g, ""));
                    var jan_2017_tot1 = parseFloat($('.jan_2017_tot1').html().replace(/,/g, ""));

                        var jan_gwt_tot1=(((jan_2018_tot1-jan_2017_tot1)/jan_2017_tot1)*100).toFixed(2);
                        

                         if(parseInt(feb_gwt_tot1)==parseInt(-100)){
                            
                            $('.jan_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                            $('.jan_gwt_tot1').html(jan_gwt_tot1+"%");

                        }



                    ////feb current year
                    var feb_2018_tot1 = parseFloat($('.feb_2018_tot1').html().replace(/,/g, ""));
                    var feb_2017_tot1 = parseFloat($('.feb_2017_tot1').html().replace(/,/g, ""));

                        var feb_gwt_tot1=(((feb_2018_tot1-feb_2017_tot1)/feb_2017_tot1)*100).toFixed(2);
                      

                         if(parseInt(feb_gwt_tot1)==parseInt(-100)){
                            
                            $('.feb_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                            $('.feb_gwt_tot1').html(feb_gwt_tot1+"%");

                        }


                    ////mar current year
                    var mar_2018_tot1 = parseFloat($('.mar_2018_tot1').html().replace(/,/g, ""));
                    var mar_2017_tot1 = parseFloat($('.mar_2017_tot1').html().replace(/,/g, ""));

                        var mar_gwt_tot1=(((mar_2018_tot1-mar_2017_tot1)/mar_2017_tot1)*100).toFixed(2);
                        

                        if(parseInt(mar_gwt_tot1)==parseInt(-100)){
                            
                            $('.mar_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                            $('.mar_gwt_tot1').html(mar_gwt_tot1+"%");

                        }


                    ////apr current year
                    var apr_2018_tot1 = parseFloat($('.apr_2018_tot1').html().replace(/,/g, ""));
                    var apr_2017_tot1 = parseFloat($('.apr_2017_tot1').html().replace(/,/g, ""));

                        var apr_gwt_tot1=(((apr_2018_tot1-apr_2017_tot1)/apr_2017_tot1)*100).toFixed(2);
                        
                        if(parseInt(apr_gwt_tot1)==parseInt(-100)){
                            
                            $('.apr_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                              $('.apr_gwt_tot1').html(apr_gwt_tot1+"%");

                        }

                    ////may current year
                    var may_2018_tot1 = parseFloat($('.may_2018_tot1').html().replace(/,/g, ""));
                    var may_2017_tot1 = parseFloat($('.may_2017_tot1').html().replace(/,/g, ""));


                        var may_gwt_tot1=(((may_2018_tot1-may_2017_tot1)/may_2017_tot1)*100).toFixed(2);
                        

                        if(parseInt(may_gwt_tot1)==parseInt(-100)){
                            
                            $('.may_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                              $('.may_gwt_tot1').html(may_gwt_tot1+"%");


                        }


                    ////jun current year
                    var jun_2018_tot1 = parseFloat($('.jun_2018_tot1').html().replace(/,/g, ""));
                    var jun_2017_tot1 = parseFloat($('.jun_2017_tot1').html().replace(/,/g, ""));

                        var jun_gwt_tot1=(((jun_2018_tot1-jun_2017_tot1)/jun_2017_tot1)*100).toFixed(2);
                       
                        if(parseInt(jun_gwt_tot1)==parseInt(-100)){
                            
                            $('.jun_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                         }else{
                              $('.jun_gwt_tot1').html(jun_gwt_tot1+"%");


                         }


                    ////jul current year
                    var jul_2018_tot1 = parseFloat($('.jul_2018_tot1').html().replace(/,/g, ""));
                    var jul_2017_tot1 = parseFloat($('.jul_2017_tot1').html().replace(/,/g, ""));

                    var jul_gwt_tot1=(((jul_2018_tot1-jul_2017_tot1)/jul_2017_tot1)*100).toFixed(2);
                    

                        if(parseInt(jul_gwt_tot1)==parseInt(-100)){
                            
                            $('.jul_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                         }else{
                             $('.jul_gwt_tot1').html(jul_gwt_tot1+"%");

                         }


                    ////aug current year
                    var aug_2018_tot1 = parseFloat($('.aug_2018_tot1').html().replace(/,/g, ""));
                    var aug_2017_tot1 = parseFloat($('.aug_2017_tot1').html().replace(/,/g, ""));


                        var aug_gwt_tot1=(((aug_2018_tot1-aug_2017_tot1)/aug_2017_tot1)*100).toFixed(2);
                       

                        if(parseInt(aug_gwt_tot1)==parseInt(-100)){
                            
                            $('.aug_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                         }else{
                             $('.aug_gwt_tot1').html(aug_gwt_tot1+"%");

                         }



                    ////sept current year
                    var sep_2018_tot1 = parseFloat($('.sep_2018_tot1').html().replace(/,/g, ""));
                    var sep_2017_tot1 = parseFloat($('.sep_2017_tot1').html().replace(/,/g, ""));


                        var sep_gwt_tot1=(((sep_2018_tot1-sep_2017_tot1)/sep_2017_tot1)*100).toFixed(2);
                       
                        if(parseInt(sep_gwt_tot1)==parseInt(-100)){
                            
                            $('.sep_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                            $('.sep_gwt_tot1').html(sep_gwt_tot1+"%");

                        }

                    ////oct current year
                    var oct_2018_tot1 = parseFloat($('.oct_2018_tot1').html().replace(/,/g, ""));
                    var oct_2017_tot1 = parseFloat($('.oct_2017_tot1').html().replace(/,/g, ""));

                        var oct_gwt_tot1=(((oct_2018_tot1-oct_2017_tot1)/oct_2017_tot1)*100).toFixed(2);
                       
                        if(parseInt(oct_gwt_tot1)==parseInt(-100)){
                            
                            $('.oct_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                        }else{
                             $('.oct_gwt_tot1').html(oct_gwt_tot1+"%");

                        }

                    ////nov current year
                    var nov_2018_tot1 = parseFloat($('.nov_2018_tot1').html().replace(/,/g, ""));
                    var nov_2017_tot1 = parseFloat($('.nov_2017_tot1').html().replace(/,/g, ""));



                        var nov_gwt_tot1=(((nov_2018_tot1-nov_2017_tot1)/nov_2017_tot1)*100).toFixed(2);
                        
                        if(parseInt(nov_gwt_tot1)==parseInt(-100)){
                            // console.log("enter");
                            $('.nov_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.nov_gwt_tot1').html(nov_gwt_tot1+"%");

                         }

                    ////dec current year
                    var dec_2018_tot1 = parseFloat($('.dec_2018_tot1').html().replace(/,/g, ""));
                    var dec_2017_tot1 = parseFloat($('.dec_2017_tot1').html().replace(/,/g, ""));

                        var dec_gwt_tot1=(((dec_2018_tot1-dec_2017_tot1)/dec_2017_tot1)*100).toFixed(2);
                        

                        if(parseInt(dec_gwt_tot1)==parseInt(-100)){
                            
                            $('.dec_gwt_tot1').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.dec_gwt_tot1').html(dec_gwt_tot1+"%");

                         }



                    var tot_2018_tot1 = parseFloat($('.tot_2018_tot1').html().replace(/,/g, ""));
                    
                    var tot_2017_tot1 = parseFloat($('.tot_2017_tot1').html().replace(/,/g, ""));
                    

                    var tot_gwt_tot1=(((tot_2018_tot1-tot_2017_tot1)/tot_2017_tot1)*100).toFixed(2);
                    $('.tot_gwt_tot1').html(tot_gwt_tot1+"%");
//                    }



                    /////////////////////////////////////**********************************team wise total institute & export sale***********//////
                    ////////////////////////Team wise total sales

                    var teamwtotal_1styear2 = parseFloat($('.teamwtotal_1styear2').html().replace(/,/g, ""));
                    var teamwtotal_2ndyear2 = parseFloat($('.teamwtotal_2ndyear2').html().replace(/,/g, ""));
                    var teamwtotal_3rdyear2 = parseFloat($('.teamwtotal_3rdyear2').html().replace(/,/g, ""));

                    var teamwtotal_calcugwt02=(((teamwtotal_2ndyear2-teamwtotal_1styear2)/teamwtotal_1styear2)*100).toFixed(2);

                    var teamwtotal_calcugwt202=(((teamwtotal_3rdyear2-teamwtotal_2ndyear2)/teamwtotal_2ndyear2)*100).toFixed(2);




                    $('.teamwtotal_calcugwt02').html(teamwtotal_calcugwt02);
                    $('.teamwtotal_calcugwt202').html(teamwtotal_calcugwt202);

                    ////jan current year
                    var jan_2018_tot2 = parseFloat($('.jan_2018_tot2').html().replace(/,/g, ""));
                    var jan_2017_tot2 = parseFloat($('.jan_2017_tot2').html().replace(/,/g, ""));

                        var jan_gwt_tot2=(((jan_2018_tot2-jan_2017_tot2)/jan_2017_tot2)*100).toFixed(2);
                       
                        if(parseInt(jan_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.jan_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.jan_gwt_tot2').html(jan_gwt_tot2+"%");
                         }
//                    }


                    ////feb current year
                    var feb_2018_tot2 = parseFloat($('.feb_2018_tot2').html().replace(/,/g, ""));
                    var feb_2017_tot2 = parseFloat($('.feb_2017_tot2').html().replace(/,/g, ""));

                        var feb_gwt_tot2=(((feb_2018_tot2-feb_2017_tot2)/feb_2017_tot2)*100).toFixed(2);
                       
                        if(parseInt(feb_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.feb_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                             $('.feb_gwt_tot2').html(feb_gwt_tot2+"%");
                         }


                    ////mar current year
                    var mar_2018_tot2 = parseFloat($('.mar_2018_tot2').html().replace(/,/g, ""));
                    var mar_2017_tot2 = parseFloat($('.mar_2017_tot2').html().replace(/,/g, ""));


                        var mar_gwt_tot2=(((mar_2018_tot2-mar_2017_tot2)/mar_2017_tot2)*100).toFixed(2);
                        
                        if(parseInt(mar_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.mar_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.mar_gwt_tot2').html(mar_gwt_tot2+"%");
                         }


                    ////apr current year
                    var apr_2018_tot2 = parseFloat($('.apr_2018_tot2').html().replace(/,/g, ""));
                    var apr_2017_tot2 = parseFloat($('.apr_2017_tot2').html().replace(/,/g, ""));


                        var apr_gwt_tot2=(((apr_2018_tot2-apr_2017_tot2)/apr_2017_tot2)*100).toFixed(2);
                        
                        if(parseInt(apr_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.apr_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.apr_gwt_tot2').html(apr_gwt_tot2+"%");
                         }

                    ////may current year
                    var may_2018_tot2 = parseFloat($('.may_2018_tot2').html().replace(/,/g, ""));
                    var may_2017_tot2 = parseFloat($('.may_2017_tot2').html().replace(/,/g, ""));


                        var may_gwt_tot2=(((may_2018_tot2-may_2017_tot2)/may_2017_tot2)*100).toFixed(2);
                       
                        if(parseInt(may_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.may_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.may_gwt_tot2').html(may_gwt_tot2+"%");
                         }
                   
                    ////jun current year
                    var jun_2018_tot2 = parseFloat($('.jun_2018_tot2').html().replace(/,/g, ""));
                    var jun_2017_tot2 = parseFloat($('.jun_2017_tot2').html().replace(/,/g, ""));


                        var jun_gwt_tot2=(((jun_2018_tot2-jun_2017_tot2)/jun_2017_tot2)*100).toFixed(2);
                       
                        if(parseInt(jun_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.jun_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.jun_gwt_tot2').html(jun_gwt_tot2+"%");
                         }



                    ////jul current year
                    var jul_2018_tot2 = parseFloat($('.jul_2018_tot2').html().replace(/,/g, ""));
                    var jul_2017_tot2 = parseFloat($('.jul_2017_tot2').html().replace(/,/g, ""));


                    var jul_gwt_tot2=(((jul_2018_tot2-jul_2017_tot2)/jul_2017_tot2)*100).toFixed(2);
                    
                    if(parseInt(jul_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.jul_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.jul_gwt_tot2').html(jul_gwt_tot2+"%");
                         }



                    ////aug current year
                    var aug_2018_tot2 = parseFloat($('.aug_2018_tot2').html().replace(/,/g, ""));
                    var aug_2017_tot2 = parseFloat($('.aug_2017_tot2').html().replace(/,/g, ""));

                        var aug_gwt_tot2=(((aug_2018_tot2-aug_2017_tot2)/aug_2017_tot2)*100).toFixed(2);
                        
                        if(parseInt(aug_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.aug_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.aug_gwt_tot2').html(aug_gwt_tot2+"%");
                         }




                    ////sept current year
                    var sep_2018_tot2 = parseFloat($('.sep_2018_tot2').html().replace(/,/g, ""));
                    var sep_2017_tot2 = parseFloat($('.sep_2017_tot2').html().replace(/,/g, ""));


                        var sep_gwt_tot2=(((sep_2018_tot2-sep_2017_tot2)/sep_2017_tot2)*100).toFixed(2);
                        
                        if(parseInt(sep_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.sep_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.sep_gwt_tot2').html(sep_gwt_tot2+"%");
                         }

                    ////oct current year
                    var oct_2018_tot2 = parseFloat($('.oct_2018_tot2').html().replace(/,/g, ""));
                    var oct_2017_tot2 = parseFloat($('.oct_2017_tot2').html().replace(/,/g, ""));

                        var oct_gwt_tot2=(((oct_2018_tot2-oct_2017_tot2)/oct_2017_tot2)*100).toFixed(2);

                        // console.log(parseInt(oct_gwt_tot2)+"    compare with  "+parseInt(-100));
                        //  console.log(parseInt(oct_gwt_tot2)==parseInt(-100));

                         if(parseInt(oct_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.oct_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.oct_gwt_tot2').html(oct_gwt_tot2+"%");
                         }
                        

                    var nov_2018_tot2 = parseFloat($('.nov_2018_tot2').html().replace(/,/g, ""));
                    var nov_2017_tot2 = parseFloat($('.nov_2017_tot2').html().replace(/,/g, ""));


                        var nov_gwt_tot2=(((nov_2018_tot2-nov_2017_tot2)/nov_2017_tot2)*100).toFixed(2);
                        

                          if(parseInt(nov_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.nov_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.nov_gwt_tot2').html(nov_gwt_tot2+"%");
                         }


                    ////dec current year
                    var dec_2018_tot2 = parseFloat($('.dec_2018_tot2').html().replace(/,/g, ""));
                    var dec_2017_tot2 = parseFloat($('.dec_2017_tot2').html().replace(/,/g, ""));

                        var dec_gwt_tot2=(((dec_2018_tot2-dec_2017_tot2)/dec_2017_tot2)*100).toFixed(2);
                        
                         if(parseInt(dec_gwt_tot2)==parseInt(-100)){
                            // console.log("enter");
                            $('.dec_gwt_tot2').html(parseFloat(0.00).toFixed(2));
                         }else{
                            $('.dec_gwt_tot2').html(dec_gwt_tot2+"%");
                         }



                    var tot_2018_tot2 = parseFloat($('.tot_2018_tot2').html().replace(/,/g, ""));
                    var tot_2017_tot2 = parseFloat($('.tot_2017_tot2').html().replace(/,/g, ""));


                    var tot_gwt_tot2=(((tot_2018_tot2-tot_2017_tot2)/tot_2017_tot2)*100).toFixed(2);
                    $('.tot_gwt_tot2').html(tot_gwt_tot2+"%");


                    /////*********end

                    ////////////////////////astergyrus
                    var aster_gyrus_old = parseFloat($('.aster_gyrusoldyear').html().replace(/,/g, ""));
                    var aster_gyrus_new = parseFloat($('.aster_gyrusnewyear').html().replace(/,/g, ""));

                    var final_aster_gyrus=(((aster_gyrus_new-aster_gyrus_old)/aster_gyrus_old)*100).toFixed(2);

                    $('.aster_gyrus_calcugwt').html(final_aster_gyrus);

                    var aster_gyrus_secnewyear = parseFloat($('.aster_gyrussecnewyear').html().replace(/,/g, ""));
                    var final_aster_gyrus2=(((aster_gyrus_secnewyear-aster_gyrus_new)/aster_gyrus_new)*100).toFixed(2);

                    $('.aster_gyrus_calcugwt2').html(final_aster_gyrus2);


                    ///ope xen

                    var op_xen_1styear = parseFloat($('.op_xen_1styear').html().replace(/,/g, ""));
                    var op_xen_2ndyear = parseFloat($('.op_xen_2ndyear').html().replace(/,/g, ""));
                    var op_xen_3rdyear = parseFloat($('.op_xen_3rdyear').html().replace(/,/g, ""));

                    var op_xen_calcugwt=(((op_xen_2ndyear-op_xen_1styear)/op_xen_1styear)*100).toFixed(2);

                    var op_xen_calcugwt2=(((op_xen_3rdyear-op_xen_2ndyear)/op_xen_2ndyear)*100).toFixed(2);

                    $('.op_xen_calcugwt').html(op_xen_calcugwt);
                    $('.op_xen_calcugwt2').html(op_xen_calcugwt2);


                    //cellbiotics

                    var cellbiotic_1styear = parseFloat($('.cellbiotic_1styear').html().replace(/,/g, ""));
                    var cellbiotic_2ndyear = parseFloat($('.cellbiotic_2ndyear').html().replace(/,/g, ""));
                    var cellbiotic_3rdyear = parseFloat($('.cellbiotic_3rdyear').html().replace(/,/g, ""));

                    var cellbiotic_calcugwt=(((cellbiotic_2ndyear-cellbiotic_1styear)/cellbiotic_1styear)*100).toFixed(2);

                    var cellbiotic_calcugwt2=(((cellbiotic_3rdyear-cellbiotic_2ndyear)/cellbiotic_2ndyear)*100).toFixed(2);

                    $('.cellbiotic_calcugwt').html(cellbiotic_calcugwt);
                    $('.cellbiotic_calcugwt2').html(cellbiotic_calcugwt2);

                    //kinetix

                    var kinetix_1styear = parseFloat($('.kinetix_1styear').html().replace(/,/g, ""));
                    var kinetix_2ndyear = parseFloat($('.kinetix_2ndyear').html().replace(/,/g, ""));
                    var kinetix_3rdyear = parseFloat($('.kinetix_3rdyear').html().replace(/,/g, ""));

                    var kinetix_calcugwt=(((kinetix_2ndyear-kinetix_1styear)/kinetix_1styear)*100).toFixed(2);

                    var kinetix_calcugwt2=(((kinetix_3rdyear-cellbiotic_2ndyear)/kinetix_2ndyear)*100).toFixed(2);


                    $('.kinetix_calcugwt').html(kinetix_calcugwt);
                    $('.kinetix_calcugwt2').html(kinetix_calcugwt2);

                    //zymos

                    var zymos_1styear = parseFloat($('.zymos_1styear').html().replace(/,/g, ""));
                    var zymos_2ndyear = parseFloat($('.zymos_2ndyear').html().replace(/,/g, ""));
                    var zymos_3rdyear = parseFloat($('.zymos_3rdyear').html().replace(/,/g, ""));

                    var zymos_calcugwt=(((zymos_2ndyear-zymos_1styear)/zymos_1styear)*100).toFixed(2);

                    var zymos_calcugwt2=(((zymos_3rdyear-zymos_2ndyear)/zymos_2ndyear)*100).toFixed(2);

                    $('.zymos_calcugwt').html(zymos_calcugwt);
                    $('.zymos_calcugwt2').html(zymos_calcugwt2);

                    //animal

                    var animal_1styear = parseFloat($('.animal_1styear').html().replace(/,/g, ""));
                    var animal_2ndyear = parseFloat($('.animal_2ndyear').html().replace(/,/g, ""));
                    var animal_3rdyear = parseFloat($('.animal_3rdyear').html().replace(/,/g, ""));

                    var animal_calcugwt=(((animal_2ndyear-animal_1styear)/animal_1styear)*100).toFixed(2);

                    var animal_calcugwt2=(((animal_3rdyear-animal_2ndyear)/animal_2ndyear)*100).toFixed(2);

                    $('.animal_calcugwt').html(animal_calcugwt);
                    $('.animal_calcugwt2').html(animal_calcugwt2);

                    //special team


                    var specialteam_1styear = parseFloat($('.specialteam_1styear').html().replace(/,/g, ""));
                    var specialteam_2ndyear = parseFloat($('.specialteam_2ndyear').html().replace(/,/g, ""));
                    var specialteam_3rdyear = parseFloat($('.specialteam_3rdyear').html().replace(/,/g, ""));

                    var specialteam__calcugwt=(((specialteam_2ndyear-specialteam_1styear)/specialteam_1styear)*100).toFixed(2);

                    var specialteam__calcugwt2=(((specialteam_3rdyear-specialteam_2ndyear)/specialteam_2ndyear)*100).toFixed(2);

                    $('.specialteam_calcugwt').html(specialteam__calcugwt);
                    $('.specialteam_calcugwt2').html(specialteam__calcugwt2);

                    //general team

                    var generalteam_1styear = parseFloat($('.generalteam_1styear').html().replace(/,/g, ""));
                    var generalteam_2ndyear = parseFloat($('.generalteam_2ndyear').html().replace(/,/g, ""));
                    var generalteam_3rdyear = parseFloat($('.generalteam_3rdyear').html().replace(/,/g, ""));

                    var generalteam__calcugwt=(((generalteam_2ndyear-generalteam_1styear)/generalteam_1styear)*100).toFixed(2);

                    var generalteam__calcugwt2=(((generalteam_3rdyear-generalteam_2ndyear)/generalteam_2ndyear)*100).toFixed(2);

                    $('.generalteam_calcugwt').html(generalteam__calcugwt);
                    $('.generalteam_calcugwt2').html(generalteam__calcugwt2);

                    //hiagen diaper team

                    var hdiaper_1styear = parseFloat($('.hdiaper_1styear').html().replace(/,/g, ""));
                    var hdiaper_2ndyear = parseFloat($('.hdiaper_2ndyear').html().replace(/,/g, ""));
                    var hdiaper_3rdyear = parseFloat($('.hdiaper_3rdyear').html().replace(/,/g, ""));

                    var hdiaper_calcugwt=(((hdiaper_2ndyear-hdiaper_1styear)/hdiaper_1styear)*100).toFixed(2);

                    var hdiaper_calcugwt2=(((hdiaper_3rdyear-hdiaper_2ndyear)/hdiaper_2ndyear)*100).toFixed(2);

                    $('.hdiaper_calcugwt').html(hdiaper_calcugwt);
                    $('.hdiaper_calcugwt2').html(hdiaper_calcugwt2);

                    ////animal vacinne


                    //mon_excld_calcugwt

                    var mon_excld_1styear = parseFloat($('.mon_excld_1styear').html().replace(/,/g, ""));
                    var mon_excld_2ndyear = parseFloat($('.mon_excld_2ndyear').html().replace(/,/g, ""));
                    var mon_excld_3rdyear = parseFloat($('.mon_excld_3rdyear').html().replace(/,/g, ""));

                    var mon_excld_calcugwt=(((mon_excld_2ndyear-mon_excld_1styear)/mon_excld_1styear)*100).toFixed(2);

                    var mon_excld_calcugwt2=(((mon_excld_3rdyear-mon_excld_2ndyear)/mon_excld_2ndyear)*100).toFixed(2);

                    $('.mon_excld_calcugwt').html(mon_excld_calcugwt);
                    $('.mon_excld_calcugwt2').html(mon_excld_calcugwt2);


                    //mon_inld_calcugwt

                    var mon_incld_1styear = parseFloat($('.mon_incld_1styear').html().replace(/,/g, ""));
                    var mon_incld_2ndyear = parseFloat($('.mon_incld_2ndyear').html().replace(/,/g, ""));
                    var mon_incld_3rdyear = parseFloat($('.mon_incld_3rdyear').html().replace(/,/g, ""));

                    var mon_incld_calcugwt=(((mon_incld_2ndyear-mon_incld_1styear)/mon_incld_1styear)*100).toFixed(2);

                    var mon_incld_calcugwt2=(((mon_incld_3rdyear-mon_incld_2ndyear)/mon_incld_2ndyear)*100).toFixed(2);

                    $('.mon_incld_calcugwt').html(mon_incld_calcugwt);
                    $('.mon_incld_calcugwt2').html(mon_incld_calcugwt2);


                    //////////////////////////////

                    ///////


                    $('#sumgwth_abovefirst > tbody  > tr > td').each(function() {

                        // console.log("heloow bd");

                        // console.log($(this).text());

                        var maintxt= $(this).text();

                        if(maintxt!='0'&& maintxt!=''){
                            $(this).html(maintxt+"%");
                        }

//                        $(this).text().append("%");
                    });


                    $('#sumgwth_downfirst > tbody  > tr > td').each(function() {

                        // console.log("heloow bd");

                        // console.log($(this).text());

                        var maintxt= $(this).text();

                        if(maintxt!='0'&& maintxt!=''){
                            $(this).html(maintxt+"%");
                        }

//                        $(this).text().append("%");
                    });



                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        var $cache = $('.my-sticky-element');

        //store the initial position of the element
        var vTop = $cache.offset().top - parseFloat($cache.css('margin-top').replace(/auto/, 0));
        $(window).scroll(function (event) {
            // what the y position of the scroll is
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= vTop) {
                // if so, ad the fixed class
                $cache.addClass('stuck');
            } else {
                // otherwise remove it
                $cache.removeClass('stuck');
            }
        });





    </script>

@endsection