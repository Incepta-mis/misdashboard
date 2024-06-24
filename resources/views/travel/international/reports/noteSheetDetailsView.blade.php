<!doctype html>
<html lang="en"><head>{{--    <meta http-equiv="content-type" content="text/html" charset="UTF-8">--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Note Sheet Details Report</title>
    <style> .textcntr {
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

        .col-xs-cusoffset-1 {
            margin-left: 7.33333333%;
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

        table {
            border-collapse: collapse;
        }
        table td {
            border: 1px solid black;
            font-size: 10px;
        }
        table th {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-size: 11px;
        }


        .row:before, .row:after {
            display: table;
            content: " ";
            clear: both;
        }

        /*--------End BStyles------------- */
        #footer {
            position: absolute;
            bottom: 0px; /*width:100%;*/
            font-size: 13px;
            font-family: "Times New Roman";
        }

        @page {
            margin: 0px 60px 0px 60px;
        }

        .ud {
            border-bottom: 1px dotted #000;
            font-weight: bold;
            text-decoration: none;
        }

        body {
            font-size: 13px;
            font-family: "Times New Roman";
        }


        .amt {
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }</style>
</head><body>

<p class="textcntr" style="font-size: 25px;"><b>Incepta Pharmaceuticals Ltd.</b></p>
<p class="textcntr" style="font-size: 15px;"><u> <b>NOTE SHEET DETAILS</b> </u></p>

<span style="float: left"> {{ date('F d,Y') }} </span>   <span style="float:right;">Group ID: {{ $tvM[0]->group_no }} </span>

<br>
<br>


<table  class="display table table-bordered table-striped"  style="width:100%; border: 1px solid black; ">
    <thead>
    <tr>
        <th>Doc No</th>
        <th>Name</th>
        <th>Emp ID</th>
        <th>Designation</th>
        <th>GL</th>
        <th>CC</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tvReq as $r)
        <tr>
            <td>{{ $r->document_no }}</td>
            <td>{{ $r->emp_name }}</td>
            <td>{{ $r->emp_id }}</td>
            <td>{{ $r->desig_name }}</td>
            <td>{{ $r->gl_code }}</td>
            <td>{{ $r->cost_center_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Route & Time Information</h3>

<table  class="display table table-bordered table-striped"  style="width:100%; border: 1px solid black; ">
    <thead>
    <tr>
        <th colspan="2" class="textcntr">Route</th>
        <th colspan="2" class="textcntr">Date</th>
        <th colspan="2" class="textcntr">BD Local Time</th>
        <th colspan="2" class="textcntr">Local Time Of Visiting Country</th>
    </tr>
    <tr>
        <th>From</th>
        <th>To</th>
        <th>From</th>
        <th>To</th>
        <th>From</th>
        <th>To</th>
        <th>From</th>
        <th>To</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tvM as $m)
        <tr>
            <td>{{ $m->from_loc_text }}, {{ $m->from_loc }}</td>
            <td>{{ $m->to_loc_text }}, {{ $m->to_loc }}</td>
            <td>{{ date('d-m-Y', strtotime($m->from_date))  }}</td>
            <td>{{ date('d-m-Y', strtotime($m->to_date))  }}</td>
            <td>{{ $m->bd_from_time }}</td>
            <td>{{ $m->bd_to_time }}</td>
            <td>{{ $m->fg_from_time }}</td>
            <td>{{ $m->fg_to_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Expenditure Information</h3>


    <table class="display table table-bordered table-striped"  style="width:100%; border: 1px solid black; ">
        <tr style="background-color: #d6a7a7">
            <td><b>Particulars</b></td>
            <td><b>Rate</b></td>
            <td><b>Day</b></td>
            <td><b>Night</b></td>
            <td><b>Conversion Rate</b></td>
            <td><b>Amount (BDT)</b></td>
        </tr>
        @for ($i = 0; $i < count($tvD); $i++)
        <tr>
            <td>Air Fare</td>
            <td colspan="3"> {{$tvD[$i]->air_fare}} </td>
            <td> {{ $tvD[$i]->conversion_rate }}</td>
            <td> {{ number_format(($tvD[$i]->air_fare  * $tvD[$i]->conversion_rate ),2) }}</td>
        </tr>
        <tr>
            <td>Hotel</td>
            <td> {{$tvD[$i]->hotel}} </td>
            <td>  </td>
            <td> {{$tvD[$i]->hotel_night}} </td>
            <td> {{ $tvD[$i]->conversion_rate }}</td>
            <td> {{ number_format(($tvD[$i]->hotel * ( $tvD[$i]->hotel_night ) * $tvD[$i]->conversion_rate ),2) }}</td>
        </tr>
        <tr>
            <td>Meal</td>
            <td> {{$tvD[$i]->meals}} </td>
            <td> {{$tvD[$i]->meals_day}} </td>
            <td>  </td>
            <td> {{ $tvD[$i]->conversion_rate }}</td>
            <td> {{ number_format(($tvD[$i]->meals * $tvD[$i]->meals_day  * $tvD[$i]->conversion_rate ),2) }}</td>
        </tr>
        <tr>
            <td>Incidental</td>
            <td> {{$tvD[$i]->incidentals}} </td>
            <td> {{$tvD[$i]->incidentals_day}} </td>
            <td>  </td>
            <td> {{ $tvD[$i]->conversion_rate }}</td>
            <td> {{ number_format(($tvD[$i]->incidentals * $tvD[$i]->incidentals_day * $tvD[$i]->conversion_rate  ),2) }}</td>
        </tr>
        <tr>
            <td>Daily Allowance</td>
            <td> {{$tvD[$i]->da}} </td>
            <td>  </td>
            <td> {{$tvD[$i]->da_night}} </td>
            <td> {{ $tvD[$i]->conversion_rate }}</td>
            <td> {{ number_format(($tvD[$i]->da * $tvD[$i]->da_night * $tvD[$i]->conversion_rate  ),2) }}</td>
        </tr>
        <tr>
            <td>Other</td>
            <td colspan="3"> {{$tvD[$i]->others}} </td>
            <td> @if(!empty($tvD[$i]->others)) {{ $tvD[$i]->conversion_rate }} @endif</td>
            <td> {{ number_format(($tvD[$i]->others * $tvD[$i]->conversion_rate),2) }}</td>
        </tr>
        <tr>
            <td colspan="5" style="background-color: #a6e1ec;"> <span style="float: right;"> BDT TAKA </span></td>
            <td style="background-color: #a6e1ec"> {{ $tvD[$i]->linetotal }} </td>
        </tr>
        @endfor
        <tr>
            <td colspan="5" style="background-color: #d0e9c6;"> <span style="float: right;">TOTAL BDT TAKA </span></td>
            <td style="background-color: #d0e9c6;"> {{ $tvAms[0]->total }} </td>
        </tr>
    </table>
    <br><br>
    <?php $f = new NumberFormatter("en", NumberFormatter::SPELLOUT); ?>
    <b>In Word:</b> <i><?php echo ucwords($f->format($tvAms[0]->total));  ?> Taka. </i>





</body></html>