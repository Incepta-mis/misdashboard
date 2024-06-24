<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense Verify-Approve Report</title>
    <style>
        /*---------BOOTSTRAP STYLES----------*/

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2,
        .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4,
        .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6,
        .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7,
        .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9,
        .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11,
        .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6,
        .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
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

        /*--------End BStyles------------- */

        .table > thead > tr > th,
        .table > tbody > tr > td {
            padding: 0px;
        }

        #footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
        }
    </style>

</head>
<body>
<div class="row" style="font-size: 12px;">
    <div class="col-xs-2">
        <p style="padding-top: 25px;">Region: {{$region}}</p>
    </div>
    <div class="col-xs-7">
        <center>
            <span style="font-weight: bold;font-size: 16px;color: #285e8e;">Incepta Pharmaceuticals Ltd.</span><br>
            40 Shahid Tajuddin Ahmed Sarani Tejgaon I/A<br>
            Dhaka-1208<br>
            Expense Month: {{\Carbon\Carbon::parse($emonth)->format('F-Y')}}<br>
        </center>
    </div>
    <div class="col-xs-2">
        <p style="padding-top: 25px;">Report Date: {{\Carbon\Carbon::now()->format('d-m-Y')}}</p>
    </div>
</div>
<br>
<div class="row" style="font-size: 9px;">
<table border="1" width="100%">
    <tbody>
    <tr style="border: 1px solid #000000;">
        <td style="text-align: center;font-weight: bold;">EXPENSE<br>MONTH</td>
        <td style="text-align: center;font-weight: bold;">DEPOT NAME</td>
        <td style="text-align: center;font-weight: bold;">EMP ID</td>
        <td style="text-align: center;font-weight: bold;">EMP NAME</td>
        <td style="text-align: center;font-weight: bold;">DESIG</td>
        <td style="text-align: center;font-weight: bold;">TEAM</td>
        <td style="text-align: center;font-weight: bold;">TERR_ID</td>
        <td style="text-align: center;font-weight: bold;">VERIFIED <br> STATUS</td>
        <td style="text-align: center;font-weight: bold;">APPROVED <br> STATUS</td>
        <td style="text-align: center;font-weight: bold;">TOTAL <br> AMOUNT</td>
    </tr>
    @forelse($rdata as $data)
        <tr style="border: 1px solid #000000;">
            <td style="text-align: center;">{{\Carbon\Carbon::parse($data->exp_month)->format('d-m-Y')}}</td>
            <td>{{$data->depot_name}}</td>
            <td>{{$data->eid}}</td>
            <td>{{$data->emp_name}}</td>
            <td>{{$data->desig}}</td>
            <td>{{$data->team}}</td>
            <td style="text-align: center;">{{$data->terr}}</td>
            <td style="text-align: center;">{{$data->verified_status}}</td>
            <td style="text-align: center;">{{$data->approved_status}}</td>
            <td @if($data->total_amount > 10000) style="background-color: #a6e1ec;text-align: right;" @else style="text-align: right;" @endif>
                {{number_format($data->total_amount)}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="10" style="text-align: center;font-size: 15px;">
                No Data found for month {{\Carbon\Carbon::parse($emonth)->format('F-Y')}} region {{$region}}
            </td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr style="border: 1px solid #000000;">
        <td colspan="9" style="text-align: right;font-weight: bold;">Total </td>
        @php $total = 0;
               foreach ($rdata as $dt){
                   $total += $dt->total_amount;
               }
        @endphp
        <td style="font-weight: bold;text-align: right;">{{number_format($total)}}</td>
    </tr>
    </tfoot>
</table></div>

</body>
</html>