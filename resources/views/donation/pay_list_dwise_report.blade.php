<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <title>Pay List</title>
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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
@foreach($depots as $d)
<div class="row" style="font-size: 12px;">
    <div class="col-xs-2">
        <p style="padding-top: 25px;">Fin Date: {{$rdata[0]->cd}}</p>
    </div>
    <div class="col-xs-5">
        <center>
            <span style="font-weight: bold;font-size: 16px;color: #285e8e;">Incepta Pharmaceuticals Ltd.</span><br>
            40 Shahid Tajuddin Ahmed Sarani Tejgaon I/A<br>
            Dhaka-1208<br>
        </center>
    </div>
    <div class="col-xs-1">
    <p style="padding-top: 25px;">Sum ID: {{$rdata[0]->summ_id}}</p>
    </div>
    @foreach($count as $c)
        @if ($d->d_id === $c->d_id && $d->rm_terr_id === $c->rm_terr_id)
            <div class="col-xs-1">
                <p style="padding-top: 25px;">Total: {{$c->total_request}}</p>
            </div>
        @endif
    @endforeach
    <div class="col-xs-3">
        <p style="padding-top: 25px;"> Date: {{\Carbon\Carbon::now()->format('d-m-Y')}}</p>
    </div>
</div>
<br>
<div class="row" style="font-size: 9px;">
    <table border="1" width="100%">
        <tbody>
        <tr style="border: 1px solid #000000;">
            <td style="text-align: center;font-weight: bold;">REF NO</td>
            <td style="text-align: center;font-weight: bold;">SL</td>
            <td style="text-align: center;font-weight: bold;">IN FAVOUR OF</td>
            <td style="text-align: center;font-weight: bold;">DOCTOR ID</td>
            <td style="text-align: center;font-weight: bold;">AMOUNT</td>
            <td style="text-align: center;font-weight: bold;">EXPENSE TYPE</td>
            <td style="text-align: center;font-weight: bold;">BRAND</td>
            <td style="text-align: center;font-weight: bold;">TERR ID</td>
            {{--<td style="text-align: center;font-weight: bold;">RM TERR ID</td>--}}
            <td style="text-align: center;font-weight: bold;">AM NAME</td>
            <td style="text-align: center;font-weight: bold;">DEPOT</td>
        </tr>

        @forelse($rdata as $data)
            @if ($d->d_id === $data->d_id && $d->rm_terr_id === $data->rm_terr_id)
            <tr style="border: 1px solid #000000;">
                <td style="text-align: center">{{$data->ref_no}}</td>
                <td style="text-align: center">{{$data->sl}}</td>
                <td>{{$data->in_favour_of}}</td>
                <td style="text-align: center">{{$data->doctor_id}}</td>
                <td style="text-align: right">{{number_format($data->amount)}}</td>
                <td style="text-align: center">{{$data->dtype}}</td>
                <td style="text-align: center">{{$data->brand_region}}</td>
                <td style="text-align: center">{{$data->terr_id}}</td>
                {{--<td style="text-align: center">{{$data->rm_terr_id}}</td>--}}
                <td style="text-align: center">{{$data->am_name}}</td>
                <td style="text-align: center">{{$data->d_name}}</td>
            </tr>
            @endif
        @empty
            <tr>
                <td colspan="10" style="text-align: center;font-size: 15px;">
                    No Data found
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@if($loop->index < count($depots)-1)
    <div class="page-break"></div>
@endif
@endforeach
</body>
</html>