<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <title>RM wise report</title>
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

        /* #footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
        } */

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;

            /** Extra personal styles **/
            /*background-color: #03a9f4;*/
            /*color: white;*/
            /*text-align: center;*/
            /*line-height: 1.5cm;*/
        }


        .page-break {
            page-break-after: always;
        }

        /*tbody {*/
            /*counter-reset: Serial; !* Set the Serial counter to 0 *!*/
        /*}*/


        /*table tbody tr td:nth-child(1):after {*/
            /*counter-increment: Serial; !* Increment the Serial counter *!*/
            /*content: "" counter(Serial);*/
        /*}*/
        /*---- This portion has been added later for showing header and footer */
        /*@page {*/
            /*margin: 0cm 0cm 0cm 0cm;*/
        /*}*/


    </style>
</head>
<body>
@foreach($rm_terr as $d)
    <div class="row" style="font-size: 12px;">
        <div class="col-xs-2">
            {{--<p style="padding-top: 25px;">Fin Date: {{$rdata[0]->cd}}</p>--}}
        </div>
        <div class="col-xs-6">
            <center>
                <span style="font-weight: bold;font-size: 16px;color: #285e8e;">Incepta Pharmaceuticals Ltd.</span><br>
                Doctors Requisition For Personal Use<br>
                SAMPLE
                <br>
                <br>
            </center>
        </div>
        <div class="row" style=" margin-left: 3%;margin-right: 3%;">
        {{--<div class="col-xs-8">--}}
            <span style="float: left;">RM Name: {{$d->rm_name}} </span> <span style="float: right;"> Team : {{$d->cost_center_name}}</span> <br>
            <span style="float: left;">RM Territory ID: {{$d->rm_terr_id}} </span><span style="float: right;"> Region : {{$d->region_name}}</span><br>
            <span style="float: left;">AM Territory ID: {{$rdata[0]->am}} </span> <br>
            <span style="float: left;">MPO Territory ID: {{$rdata[0]->mpo}}</span> <span style="float: right;"> Month: : {{$rdata[0]->req_month}}</span><br>

            {{--<p style="padding-top: 25px;">RM Name: {{$d->rm_terr_id}}</p>--}}
        {{--</div>--}}
        </div>
        <div class="col-xs-3">
            {{--<p style="padding-top: 25px;"> Date: {{\Carbon\Carbon::now()->format('d-m-Y')}}</p>--}}
        </div>
    </div>
    <br>
    <div class="row" style=" font-size: 11px;margin-left: 1%;margin-right: 1%;">
        <table border="1" width="100%">
            <tr style="border: 1px solid #000000;">
                <td style="text-align: center;font-weight: bold;">Sl No</td>
                <td style="text-align: center;font-weight: bold;">Did</td>
                <td style="text-align: center;font-weight: bold;">Code</td>
                <td style="text-align: center;font-weight: bold;">Product Name</td>
                <td style="text-align: center;font-weight: bold;">Pack Size</td>
                <td style="text-align: center;font-weight: bold;">Quantity</td>
                <td style="text-align: center;font-weight: bold;">Unit Price </td>
                <td style="text-align: center;font-weight: bold;">Total </td>
            </tr>

            <tbody>

            @forelse($rdata as $data)
                @if ($d->rm_terr_id === $data->rm_terr_id)
                    <tr style="border: 1px solid #000000;">
                        {{--<td style='white-space: nowrap;'></td>--}}
                        <td style="text-align: center">{{$data->sl}}</td>
                        <td style="text-align: center">{{$data->d_id}}</td>
                        <td style="text-align: center">{{$data->p_code}}</td>
                        <td style="text-align: center">{{$data->product_name}}</td>
                        <td style="text-align: center">{{$data->pack_size}}</td>
                        <td style="text-align: center">{{$data->total_qty}}</td>
                        <td style="text-align: center">{{$data->unit_price}}</td>
                        <td style="text-align: center">{{$data->total_value}}</td>
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

    <footer>

{{--<div class="row" style=" margin-bottom: 0px; float: right;">--}}

<div class="row">


    <div class="col-xs-3" style="margin-bottom: 0px;"> <hr> </div>
    <div class="col-xs-5" style="margin-bottom: 0px; font-size: x-small">  Prepared by IT division, Incepta Pharmaceuticals Ltd </div>
    <div class="col-xs-3" style="margin-bottom: 0px; padding-right: 5px;"> <hr> </div>

</div>

</footer>

    @if($loop->index < count($rm_terr)-1)
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>