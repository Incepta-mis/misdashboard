<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>workload</title>
</head>
<body>
<table>
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Product Name</th>
        <th>Batch</th>
        <th>Kept on date</th>
        <th>Total products</th>
        <th>Total Sample</th>
        <th>Required Analysis Time/Product</th>
        <th>Required Analysis Time/Sample</th>
        <th>Total Analysis Time Required Monthly(Hr_products)</th>
        <th>Total Analysis Time Required Monthly (Hr) Sample</th>
        <th>Storage condition</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    @php
    $pname = null;
    $tp = 0;
    $ts = 0;
    $tatrm = 0;
    @endphp

    @foreach($pdata as  $s)
        <tr>

            <td>{{$loop->index+1}}</td>
            <td>{{$s->pname}}</td>
            <td>{{$s->batch_number}}</td>
            <td>{{$s->kept_on_date}}</td>
            @if($s->total_sample>1 && $pname != $s->pname)

                <td rowspan="{{$s->total_sample}}" style="vertical-align: middle;text-align: center;">{{$s->total_product}}</td>
             @elseif($s->total_sample==1)
                <td style="text-align: center;">{{$s->total_product}}</td>
            @endif
            @if($s->total_sample>1 && $pname != $s->pname)
                @php
                    $tp += $s->total_product;
                    $ts += $s->total_sample;
                    $tatrm += $s->tatps;
                @endphp

                <td rowspan="{{$s->total_sample}}" style="vertical-align: middle;text-align: center;">{{$s->total_sample}}</td>
                 @elseif($s->total_sample==1)
                @php
                    $tp += $s->total_product;
                    $ts += $s->total_sample;
                    $tatrm += $s->tatps;
                @endphp
                <td style="text-align: center;">{{$s->total_sample}}</td>
            @endif
            @if($s->total_sample>1 && $pname != $s->pname)
            <td rowspan="{{$s->total_sample}}" style="vertical-align: middle;text-align: center;">{{$s->ana_time_pro}}</td>
                 @elseif($s->total_sample==1)
                <td style="text-align: center;">{{$s->ana_time_pro}}</td>
            @endif
            @if($s->total_sample>1 && $pname != $s->pname)
            <td rowspan="{{$s->total_sample}}" style="vertical-align: middle;text-align: center;">{{$s->ana_time_nsb}}</td>
                 @elseif($s->total_sample==1)
                <td style="text-align: center;">{{$s->ana_time_nsb}}</td>
            @endif
            @if($s->total_sample>1 && $pname != $s->pname)
            <td rowspan="{{$s->total_sample}}" style="vertical-align: middle;text-align: center;">{{$s->tatpp}}</td>
                 @elseif($s->total_sample==1)
                <td style="text-align: center;">{{$s->tatpp}}</td>
            @endif
            @if($s->total_sample>1 && $pname != $s->pname)
            <td rowspan="{{$s->total_sample}}" style="vertical-align: middle;text-align: center;">{{$s->tatps}}</td>
                 @elseif($s->total_sample==1)
                <td style="text-align: center;">{{$s->tatps}}</td>
            @endif
            <td>{{$s->chamber_stor_cond}}</td>
            <td>{{$s->remarks}}</td>
        </tr>
        @php
            $pname = $s->pname;
        @endphp
    @endforeach
    </tbody>
    <tfoot>
    <tr style="text-align: center;">
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #05B1FC;">Grand Total</td>
        <td style="background-color: #05B1FC;">{{$tp}}</td>
        <td style="background-color: #05B1FC;">{{$ts}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #05B1FC;">{{$tatrm}}</td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>