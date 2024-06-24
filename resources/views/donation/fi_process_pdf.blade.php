<!doctype html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FI Process</title>
    <style media="all">
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

        #lst, #lst th, #lst td {
            /*border: 1px solid black;*/
            font-size: 12px;
        }

        #sum_table, #sum_table th, #sum_table td {
            /*border: 1px solid black;*/
            font-size: 12px;
        }

        #rst, #rst th, #rst td {
            /*border: 1px solid black;*/
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            max-width: 100%;
            background-color: transparent;
        }

        table {
            border-collapse: collapse;
        }

        .row:before,
        .row:after {
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

        #footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }

    </style>
</head><body>

{{--main body start--}}

<div class="row">
    <div class="col-xs-10 col-xs-offset-1">

        <div class="col-xs-12 col-xs-offset-1" style="text-align: center; padding-left: 5px;">
            <span class="text-primary" style="font-size: 33px;"><b>{{$rs_data[0]->company_name }}</b></span>
            <br>
            <span style="font-size: 11px;"><b> Head Office:</b>40 Shahid Tajuddin Ahmed Sarani, Tejgaon I/A Dhaka - 1208, Bangladesh.

                <br> <span style="margin-left: -40px;">Phone : 880-02-8891688-703,Fax : + 88-02-8891190, E-mail : incepta@inceptapharma.com, Web :www.inceptapharma.com</span>
                    <br><b> Factory :</b> Dewan Idris Road, Bara Rangamatia, Zirabo, Savar, Dhaka
                </span>

        </div>
    </div>
</div>

<div class="row">
    <hr>
</div>


<br>

<?php
$ar_count = count($rs_data);
?>

{{--@if($pa_val[0]->print_pl=='1')--}}
{{--<span style="font-size: 25px;">This document has already been printed</span>--}}

{{--@elseif($ar_count<1)--}}
{{--<span style="font-size: 25px;">There are no data to be processed</span>--}}

{{--@else--}}
<div class="row" style="text-align: center; font-size: 33px;">
    @if($fi_val[0]->fi_print=='1')
        Duplicate Copy
    @endif
</div>
Summary ID: {{ $rs_data[0]->summ_id }}
{{--<div style="float: right;" > Date : {{$rs_data[0]->cd}} </div>--}}

<br>
<br>

<div class="row">
    <div class="col-xs-12">

        <table width="100%" id="lst" align="">
            <thead>
            <tr>
                <th>GL</th>
                <th>COST CENTER ID</th>
                <th>COST CENTER NAME</th>
                <th>REQ</th>
                <th align="right">TOTAL REQ Amt</th>
                <th align="right">TOTAL BUDGET</th>
                <th align="right">EXPENSE BUDGET</th>
                <th align="right">AVAILABLE BUDGET</th>
            </tr>
            </thead>

            @foreach($rs_data as $plist)
                <tr>
                    <td>{{ $plist->gl }}</td>
                    <td>{{ $plist->cost_center_id }}</td>
                    <td>{{ $plist->cost_center_name }}</td>
                    <td>{{ $plist->no_of_req }}</td>
                    <td align="right">{{ number_format($plist->total_req_amount) }}</td>
                    <td align="right">{{ number_format($plist->total_budget) }}</td>
                    <td align="right">{{ number_format($plist->expense_budget) }}</td>
                    <td align="right">{{ number_format($plist->available_budget) }}</td>
                </tr>

            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td align="center"><b>Total</b></td>
                <td align=""><b>{{ number_format($sub[0]->tot_nor) }}</b></td>
                <td align="right"><b>{{ number_format($sub[0]->total_amt) }}</b></td>
                <td align="right"><b>{{ number_format($sub[0]->total_bud) }}</b></td>
                <td align="right"><b>{{ number_format($sub[0]->tot_expense) }}</b></td>
                <td align="right"><b>{{ number_format($sub[0]->tot_available) }}</b></td>


            </tr>

        </table>
    </div>

</div>

<div clas="row">
    &nbsp;&nbsp;
</div>
<div clas="row">
    &nbsp;&nbsp;
</div>

<div class="row">


    <div class="col-xs-12">
        <table id="sum_table" width="70%">
            <thead>
            <tr>
                <th align="right">Total req</th>
                <th align="right">Total Req Amount</th>
                <th align="right">Cheque Req</th>
                <th align="right">Cheque Amount</th>
                <th align="right">Cash Req</th>
                <th align="right">Cash Amount</th>
                <th align="right">BEFTN Req</th>
                <th align="right">BEFTN Amount</th>
            </tr>
            </thead>
            @foreach($dis_sum as $plist)
                <tr>
                    <td align="right"><b>{{ $plist->total_no_req }}</b></td>
                    <td align="right"><b>{{ number_format($plist->apv_amount) }}</b></td>
                    <td align="right"><b>{{ $plist->tot_cheq_req }}</b></td>
                    <td align="right"><b>{{ number_format($plist->tot_cheq_req_amt) }}</b></td>
                    <td align="right"><b>{{ $plist->tot_cash_req }}</b></td>
                    <td align="right"><b>{{ number_format($plist->tot_cash_req_amt) }}</b></td>
                    <td align="right"><b>{{ $plist->tot_beftn_req }}</b></td>
                    <td align="right"><b>{{ number_format($plist->tot_beftn_req_amt) }}</b></td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<div clas="row">
    &nbsp;&nbsp;
</div>
<div clas="row">
    &nbsp;&nbsp;
</div>
<div clas="row">
    &nbsp;&nbsp;
</div>

<div clas="row">

    The above expenses have been approved by the concern authority in Research Expenses Processing Software.

</div>


{{--@endif--}}

<footer id="footer">

    <div class="row" style=" margin-bottom: 0px; ">


        <br>
        <br>

        <div class="col-xs-3">_____________________________</div>
        <div class="col-xs-3">_____________________________</div>
        <div class="col-xs-3">_____________________________</div>
        <br>
        <div class="col-xs-3">Prepared by</div>
        <div class="col-xs-3">Verified by</div>
        <div class="col-xs-3">Approved by</div>
        <br>


    </div>
    {{--<div class="row">--}}


    {{--<div class="col-xs-4" style="margin-bottom: 0px;"> <hr> </div>--}}
    {{--<div class="col-xs-3" style="margin-bottom: 0px; font-size: x-small"> <u> Innovative concept into practice</u></div>--}}
    {{--<div class="col-xs-4" style="margin-bottom: 0px; padding-right: 5px;"> <hr> </div>--}}

    {{--</div>--}}

</footer>
</body></html>