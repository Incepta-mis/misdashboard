
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Depot Cash report</title>

    <style media="all">
        {{--<style type="text/css" media="screen"></style>--}}

    {{--<style type="text/css" media="print">--}}
        .textcntr {
            text-align: center;
            font-size: 11px;
        }

        /*---------BOOTSTRAP STYLES----------*/

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }
        .col-xs-12 {
            width: 100%;
        }
        .col-xs-11 {
            width: 91.66666667%;
        }
        .col-xs-10 {
            width: 83.33333333%;
        }
        .col-xs-9 {
            width: 75%;
        }
        .col-xs-8 {
            width: 66.66666667%;
        }
        .col-xs-7 {
            width: 58.33333333%;
        }
        .col-xs-6 {
            width: 50%;
        }
        .col-xs-5 {
            width: 41.66666667%;
        }
        .col-xs-4 {
            width: 33.33333333%;
        }
        .col-xs-3 {
            width: 25%;
        }
        .col-xs-2 {
            width: 16.66666667%;
        }
        .col-xs-1 {
            width: 8.33333333%;
        }
        .col-xs-pull-12 {
            right: 100%;
        }
        .col-xs-pull-11 {
            right: 91.66666667%;
        }
        .col-xs-pull-10 {
            right: 83.33333333%;
        }
        .col-xs-pull-9 {
            right: 75%;
        }
        .col-xs-pull-8 {
            right: 66.66666667%;
        }
        .col-xs-pull-7 {
            right: 58.33333333%;
        }
        .col-xs-pull-6 {
            right: 50%;
        }
        .col-xs-pull-5 {
            right: 41.66666667%;
        }
        .col-xs-pull-4 {
            right: 33.33333333%;
        }
        .col-xs-pull-3 {
            right: 25%;
        }
        .col-xs-pull-2 {
            right: 16.66666667%;
        }
        .col-xs-pull-1 {
            right: 8.33333333%;
        }
        .col-xs-pull-0 {
            right: 0;
        }
        .col-xs-push-12 {
            left: 100%;
        }
        .col-xs-push-11 {
            left: 91.66666667%;
        }
        .col-xs-push-10 {
            left: 83.33333333%;
        }
        .col-xs-push-9 {
            left: 75%;
        }
        .col-xs-push-8 {
            left: 66.66666667%;
        }
        .col-xs-push-7 {
            left: 58.33333333%;
        }
        .col-xs-push-6 {
            left: 50%;
        }
        .col-xs-push-5 {
            left: 41.66666667%;
        }
        .col-xs-push-4 {
            left: 33.33333333%;
        }
        .col-xs-push-3 {
            left: 25%;
        }
        .col-xs-push-2 {
            left: 16.66666667%;
        }
        .col-xs-push-1 {
            left: 8.33333333%;
        }
        .col-xs-push-0 {
            left: 0;
        }
        .col-xs-offset-12 {
            margin-left: 100%;
        }
        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-xs-offset-9 {
            margin-left: 75%;
        }
        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-xs-offset-6 {
            margin-left: 50%;
        }
        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-xs-offset-3 {
            margin-left: 25%;
        }
        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-xs-offset-0 {
            margin-left: 0;
        }

        .col-xs-offset-12 {
            margin-left: 100%;
        }
        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-xs-offset-9 {
            margin-left: 75%;
        }
        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-xs-offset-6 {
            margin-left: 50%;
        }
        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-xs-offset-3 {
            margin-left: 25%;
        }
        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-xs-offset-0 {
            margin-left: 0;
        }
        #lst,#lst th,#lst td {
            /*border: 1px solid black;*/
            font-size: 11px;
        }

        table {
            max-width: 100%;
            background-color: transparent;
        }

        table {
            border-collapse: collapse;
        }

        .row:before,
        .row:after{
            display: table;
            content: " ";
            clear: both;
        }

        .inlineTable {
            display: inline-block;
        }

        /*--------End BStyles------------- */


        .table > thead > tr > th,
        .table > tbody > tr > td {
            padding: 2px;
            color: #000000;

        }

        /*#footer{*/
        /*position:absolute;*/
        /*bottom:20px;*/
        /*width:100%;*/
        /*}*/
        /*page[size="A4"][layout="landscape"] {*/
        /*width: 29.7cm;*/
        /*height: 21cm;*/
        /*}*/

        /*@media print{@page {size: landscape}}*/
        /*@page {*/
        /*size: landscape;*/
        /*}*/
        /*body {*/
        /*width: 29.7cm;*/
        /*height: 21cm;*/
        /*!*writing-mode: tb-rl;*!*/
        /*}*/

        /*body {*/
        /*page-break-before: avoid;*/
        /*width:100%;*/
        /*height:100%;*/
        /*-webkit-transform: rotate(-90deg) scale(.68,.68);*/
        /*-moz-transform:rotate(-90deg) scale(.58,.58);*/
        /*zoom: 200%    }*/


        /*---- This portion has been added later for showing header and footer */
        @page {
            margin: 0cm 0cm 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 4.5cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 3cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0.5cm;
            left: 0.7cm;
            right: 0.7cm;
            height: 4cm;

            /** Extra personal styles **/
            /*background-color: #03a9f4;*/
            /*color: white;*/
            /*text-align: center;*/
            /*line-height: 1.5cm;*/
        }

        /** Define the footer rules **/
        footer {
            position: absolute;
            bottom: 0.5cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            font-size: 12px;

            /** Extra personal styles **/
            /*background-color: #03a9f4;*/
            /*color: white;*/
            /*text-align: center;*/
            /*line-height: 1.5cm;*/
        }

        .pagenum:before {
            content: counter(page);
        }

        /*footer .pagenum:before {*/
            /*content: counter(page);*/
        /*}*/
        /*---- This portion has been added later for showing header and footer */

        .page-break {
            page-break-after: always;
        }

    </style>

</head>
{{--<page size="A4" layout="landscape">--}}
<body>
{{--<body class="page" data-size="A4">--}}

{{--main body start--}}


<header>


<div class="row">
    {{--<div class="col-xs-10 ">--}}
    @if(!empty($rs_data))
        <div class="col-xs-12 " style="text-align: center;">
            <span style="float: left;"><span class="pagenum"></span></span>
            <span class="text-primary" style="font-size: 20px;"><b>{{$rs_data[0]->company_name}}</b></span> <span style="font-size: 10px;float: right">print Date time:  <b><?php echo " ".date("d-m-Y h:i:sa");   ?> </b> </span> <br>
            <span style="font-size: 11px;"><b> RESEARCH EXPENSES</b></span><br>
            <span style="font-size: 11px;"><b> <?php echo " ".date("d-m-Y h:i:sa");   ?> </b> </span><br>
            <span style="">Payment GL : 15910160 </span><br>
            <span style="float: left"><b>CASH Ref No: {{$rs_data[0]->ref_no}}</b></span><span style="font-size: 15px;"><b>Depot Cash report</b></span> <span style="float: right"><b>Summary ID : <span style="border: ridge">{{$rs_data[0]->summ_id}}</span></b></span><br><br>
            <span style="float: right"><b>Donation Month : <span style="border: ridge">{{$rs_data[0]->payment_month}}</span></b></span>
        </div>
    @endif
    {{--</div>--}}
</div>
<br>
</header>

@foreach($am_territory as $at)

@if(!empty($rs_data))

    <div class="col-xs-12">
        {{--style="align:left";--}}
        <table  width="100%" id="lst" border="1 px;">

            <thead>
            <tr>
                <th>SL</th>
                <th>Month</th>
                <th>DNT ID</th>
                <th>Name</th>
                <th>In favor of</th>
                <th>Frequency</th>
                <th>Donation Amount</th>
                <th>Purpose</th>
                <th>Budget owner</th>
                <th>Depot</th>
                <th>Territory Id</th>
                <th>AM</th>
                <th>RM/ASM</th>
                <th>Assigned</th>
            </tr>
            </thead>
            <tbody>

            @foreach($rs_data as $rd)
                @if ($at->am_terr_id === $rd->am_terr_id)
                <tr>
                    <td align="center">{{ $rd->sl }}</td>
                    <td>{{ $rd->payment_month }}</td>
                    <td>{{ $rd->fi_doc_no }}</td>
                    <td >{{ $rd->doctor_name }}</td>
                    <td>{{ $rd->in_favour_of }}</td>
                    <td>{{ $rd->frequency }}</td>
                    <td >{{ $rd->donation_amount }}</td>
                    <td>{{ $rd->purpose }}</td>
                    <td >{{ $rd->budget_owner }}</td>
                    <td>{{ $rd->d_id }}</td>
                    <td >{{ $rd->terr_id }}</td>
                    <td>{{ $rd->am_name }}</td>
                    <td >{{ $rd->rm_asm }}</td>
                    <td>{{ $rd->rm_assigned_person }}</td>
                </tr>
                @endif
            @endforeach

            <tr style="border: none"><td></td><td></td><td></td><td></td><td> </td><td>Total:</td><td>{{number_format($at->total_amount)}}</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
{{--<<tr style="border: none"><td></td><td></td><td></td><td>Total: </td><td>{{number_format($rs_data[0]->total_amount)}}</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>--}}

        </table>

    </div>
<br>
<br>

<div class="row">
    <div  class="col-xs-12"><span>&nbsp;&nbsp;&nbsp;In words ( taka ) :
            <?php

            $currency = new \App\Currency_To_Word();
            $spell = $currency->get_bd_amount_in_text($at->total_amount);
            echo ''.$spell.' only';

            // $spell = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            // echo 'IN WORDS: ' . strtoupper($spell->format($dt_exp_app));
            ?>

        </span></div>

</div>

{{--</div>--}}

    <footer>

        <div class="row" style=" margin-bottom: 0px; ">


            {{--<br>--}}
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            @if($rs_data[0]->prepared_by =='1015738')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/01. Anika Tabasum Neela.jpg')}}" width="70px" height="40px"></div>
            @elseif($rs_data[0]->prepared_by =='1014536')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/02. Md. Shajedul Kabir.jpg')}}" width="70px" height="40px"></div>
            @elseif($rs_data[0]->prepared_by =='1018266')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/03. Md. Tarekul Islam.jpg')}}" width="70px" height="40px"></div>
            @endif
            @if($rs_data[0]->verified_by =='1007284')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/04. Khan Mohsin Subhan.jpg')}}" width="70px" height="40px"></div>
            @elseif($rs_data[0]->verified_by =='1004184')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/05. Md. Ziaur Rahman Mollick.jpg')}}" width="70px" height="40px"></div>
            @elseif($rs_data[0]->verified_by =='1000234')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/06. Syed Md.Asaduzzaman.jpg')}}" width="70px" height="40px"></div>
            @endif
            @if($rs_data[0]->approved_by =='1000081')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/07. Naimul Huda.jpg')}}" width="70px" height="40px"></div>
            @elseif($rs_data[0]->approved_by =='1012377')
            <div class="col-xs-2"><img src="{{url('public/site_resource/images/donation_signatures/08. Mohiuddin Ahmed.jpg')}}" width="70px" height="40px"></div>
            @endif
            <br>
            <br>
            <br>
{{--            <br>--}}
            <div  class="col-xs-2">_____________________________</div>   <div  class="col-xs-2">_____________________________</div>  <div  class="col-xs-2">_____________________________</div>   <div  class="col-xs-2">_____________________________</div> <div  class="col-xs-2">_____________________________</div><br>
            <div class="col-xs-2">Prepared & checked by</div>    <div class="col-xs-2">Verified by</div>       <div class="col-xs-2">Approved by </div> <div class="col-xs-2">  Payment Made by </div>  <div class="col-xs-2">  Posted by Accounts </div> <br>
            <div class="col-xs-2">{{$rs_data[0]->prepared_name}}</div>  <div class="col-xs-2">{{$rs_data[0]->verified_name}}</div>
            <div class="col-xs-2">{{$rs_data[0]->approved_name}} </div>  <div class="col-xs-2">{{$rs_data[0]->depot_incharge}} </div> <div class="col-xs-2"> </div> <br>
{{--            <div class="col-xs-3">{{$rs_data[0]->desig}}</div>  <div class="col-xs-3">{{$verified[0]->desig}}</div>--}}
{{--            <div class="col-xs-3">{{$rs_data[0]->desig}} </div>  <div class="col-xs-3"> </div> <br>--}}
{{--            <div class="col-xs-3">{{$rs_data[0]->dept_name}}</div>  <div class="col-xs-3">{{$verified[0]->dept_name}}</div>--}}
{{--            <div class="col-xs-3">{{$rs_data[0]->dept_name}} </div>  <div class="col-xs-3"> </div> <br>--}}
{{--            <div class="col-xs-3">{{$rs_data[0]->com_name}}</div>  <div class="col-xs-3">{{$verified[0]->com_name}}</div>--}}
{{--            <div class="col-xs-3">{{$rs_data[0]->com_name}} </div>  <div class="col-xs-3"> </div> <br>--}}

        </div>
        {{--<div class="row">--}}
        {{--<div class="col-xs-4" style="margin-bottom: 0px;"> <hr> </div>--}}
        {{--<div class="col-xs-3" style="margin-bottom: 0px; font-size: x-small"> <u> Innovative concept into practice</u></div>--}}
        {{--<div class="col-xs-4" style="margin-bottom: 0px; padding-right: 5px;"> <hr> </div>--}}

        {{--</div>--}}

    </footer>

    @else
    <div class="row">
        <div  class="col-xs-12"><span>Please Process the data first</span></div>

    </div>

@endif
@if($loop->index < count($am_territory)-1)
    <div class="page-break"></div>
@endif

 @endforeach

</body>

{{--</page>--}}
</html>

