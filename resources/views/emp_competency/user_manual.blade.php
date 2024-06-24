@extends('_layout_shared._master')
@section('title','User Manual')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
       

        body{
            color: black;
        }
      

        div {
            text-align: justify;
            text-justify: inter-word;
        }

        .w3-note {
            background-color: #ffffcc;
            border-left: 6px solid #ffeb3b;
        }

        .w3-panel {
            margin-top: 16px;
            margin-bottom: 16px;
        }

        .w3-container, .w3-panel {
            padding: 0.01em 16px;
        }

        li.mli:hover {
            /*background: #eee;*/
            background: #E7F0F9;
            cursor: pointer;
        }
        .panel-body {
            padding: 15px;
            padding-top: 0px;
        }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                {{--<header class="panel-heading">--}}
                    {{--<label class="text-primary">--}}
                        {{--Rating Definition--}}
                    {{--</label>--}}
                {{--</header>--}}
                <div class="panel-body">
                    <span style="font-weight: bold;color:#03a87c">
                        {{--<h2>Incepta Pharmaceuticals Ltd.<br>--}}
                        {{--Competency Mapping Worksheet</h2>--}}
                    </span>

                    <span style="font-weight: bold"><h2 align="center">User Guideline</h2></span>
                    <div class="">
                        <p>
                           <b>1.</b>  There are four working sheets in this file -  A) User Manual  B) Rating Defination C) Data Entry D) Graph
                        </p></div><br>

                    {{-- The table containing one Row--}}
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <section class="panel" id="data_table">
                                <div class="panel-body">
                                    <table class="table table-responsive table-bordered">

                                        <tbody>

                                        <tr>
                                            <td colspan="2"><center><h4 ><b>User Manual</b>
                                                        </h4>It contains the user guideline of the worksheet.
                                                    </center></td>
                                            <td colspan="2"><center><h4><b>Rating Defination
                                                        </b></h4>It contains all the defination of rating scale.
                                                    </center></td>
                                            <td colspan="2"><center><h4><b>Data Entry
                                                        </b></h4>It contains the worksheet where all the users can input their data.
                                                    </center></td>
                                            <td colspan="2"><center><h4><b>Graph
                                                        </b></h4>it cointains the graphical presentation which represent the data input by the users.
                                                    </center></td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </div>

                    </div>

                    <div class="">
                        <p>
                            <b> 2.</b>  The definition of the Ratings scale is given in the "Rating Definition" sheet.

                        </p>
                        <p>
                            <b> 3.</b>  Both employee and his/her supervisor will fill up the "Data Entry" sheet.

                        </p>
                        <p>
                            <b> 4.</b>  Both the users must fill up their personal identity information which is given at the top of  both "Data  Entry" and "Graph" sheet.

                        </p>
                        <p>
                            <b> 5.</b>  At first the employee or assesse shall the fill up the "Self Assessment" part. After completion of "Self  Assessement", the supervisor or assessor shall fill up the "Management Assessment" part  in the  "Data Entry"  sheet.

                        </p>
                        <p>
                            <b> 6.</b>  To fill up the Data Entry sheet, all the user must use " * " sign. Any other usage of sign will not generate any graphical presentaiton the "Graph" sheet.

                        </p>
                    </div>



                    {{--<h2>General Guidelines:</h2>--}}
                    {{--<br>--}}

                    {{--<ol>--}}
                        {{--<li class="mli"> The user will log on in this page by entering her/his log in ID and password which will be allocated by the HR department.</li>--}}
                        {{--<li class="mli"> After entering this section, you will see four pages in this section -  <ol type="A"><li>User Manual</li><li>Rating scale Definition</li><li>Data Entry</li><li>Graph</li></ol></li>--}}
                        {{--<li class="mli"> Description of the pages:--}}
                            {{--<ol type="a">--}}
                                {{--<li>User Manual: This page contains the user guideline of the worksheet.</li>--}}
                                {{--<li>Rating Scale Definition: This page contains all the definition of rating scale.</li>--}}
                                {{--<li>Data Entry: This page contains the worksheet where both the users can input their assessment.</li>--}}
                                {{--<li>Graph: This page contains the graphical presentation which represent the data input by the users.</li>--}}
                            {{--</ol>--}}
                        {{--</li>--}}
                        {{--<br>--}}
                        {{--<li class="mli"> Every user must read the user manual and rating scale definition very carefully to enter the data efficiently.</li>--}}
                        {{--<li class="mli"> Both the users must fill up their personal identity information which is given at the top of both "Data Entry" page.</li>--}}
                        {{--<li class="mli"> After reading the user manual and rating scale definition the employee will fill up the "Data Entry" sheet as self-assessment and save the page accordingly.</li>--}}
                        {{--<li class="mli"> After saving the page, the system will send a notification through mail to her/his immediate supervisor for her/his assessment and save the page accordingly.</li>--}}
                        {{--<li class="mli"> After saving the page, the system will send a notification through mail to the department head (if any) for viewing the both assessment. Only employee and her/his n+1 that is immediate supervisor can only assess and n+2 and above can only view the assessment.</li>--}}
                    {{--</ol>--}}


                </div>
            </section>
        </div>
        {{--<div class="col-sm-2 col-md-2">--}}
            {{--<section class="panel" id="data_table">--}}

                {{--<div class="panel-body" id="summary_tour_table">--}}

                {{--</div>--}}
            {{--</section>--}}
        {{--</div>--}}
    </div>

    {{--<div class="row" id="report-body">--}}
        {{--<div class="">--}}
            {{--<div class="col-sm-12 col-md-12">--}}
                {{--<section class="panel" id="data_table">--}}
                    {{--<div class="panel-body">--}}
                        {{--<div class="table-responsive" id="search_div_id">--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</section>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="overlay">--}}
    {{--<div id="loading-img"></div>--}}
    {{--</div>--}}
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

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>--}}
    {{--{{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}--}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    <script type="text/javascript">

        $(document).ready(function(){ });

    </script>

@endsection
