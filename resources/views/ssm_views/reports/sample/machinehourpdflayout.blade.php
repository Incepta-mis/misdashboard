<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>machinehour</title>
    <style>
        body{
            font-family: "Times New Roman", "Courier New", sans-serif;
        }
        table > thead > tr > th {
            border: 1px solid #000000;
            padding: 5px;
        }
        table > tbody > tr > td {
            border: 1px solid #000000;
            padding: 5px;
            font-size: 12px;
        }
        table > tfoot > tr > td {
            border: 1px solid #000000;
        }
        table{
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Product Name</th>
        <th>Batch</th>
        <th>Assay Method</th>
        <th>Total Products</th>
        <th>Total Sample</th>
        <th>Sample Analysis Time</th>
        <th>Sample<br> Analysis<br>Time<br>(Average)</th>
        <th>Calculated Hour</th>
        <th>Calculated Hour<br>(Average)</th>
        <th>Actual Machine Hour</th>
        <th>Actual Machine <br> Hour (Average)/ <br> Required <br> Machine Hour</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    @php
        $pname = null;
        $batch = null;
        $tp = 0;
        $ts = 0;
        $satavg = 0;
        $chavg = 0;
        $amhavg = 0;
    @endphp
    @foreach($pdata1 as  $p)
        <tr>
            <td style="text-align: center;">{{$loop->index + 1}}</td>
            @if($pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->pname}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->pname}}</td>
            @endif
            @if($p->total_sample>1 && $pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->batch_number}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->batch_number}}</td>
            @endif
            @if($p->total_sample>1 && $pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->assay_method}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->assay_method}}</td>
            @endif
            @if($p->total_sample>1 && $pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->total_product}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->total_product}}</td>
            @endif
            @if($p->total_sample>1 && $pname != $p->pname)
                @php
                    $tp += $p->total_product;
                    $ts += $p->total_sample;
                @endphp
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->total_sample}}
                </td>
            @elseif($batch != $p->batch_number)
                @php
                    $tp += $p->total_product;
                    $ts += $p->total_sample;
                @endphp
                <td style="text-align: center;">{{$p->total_sample}}</td>
            @endif
            <td style="text-align: center;">{{$p->sample_analysis_time}}</td>
            @if($p->total_sample>1 && $pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->sample_analysis_time_average}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->sample_analysis_time_average}}</td>
            @endif
            @if($p->total_sample>1 && $pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->calculate_mhoure}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->calculate_mhoure}}</td>
            @endif
            @if($loop->index == 0)
                <td rowspan="{{count($pdata1)}}" style="vertical-align: middle;text-align: center;">
                    {{$p->calculated_hour_average}}
                </td>
            @endif
            @if($p->total_sample>1 && $pname != $p->pname)
                <td rowspan="{{$p->total_sample}}" style="vertical-align: middle;text-align: center;">
                    {{$p->actual_mhoure}}
                </td>
            @elseif($batch != $p->batch_number)
                <td style="text-align: center;">{{$p->actual_mhoure}}</td>
            @endif
            @if($loop->index == 0)
                <td rowspan="{{count($pdata1)}}" style="vertical-align: middle;text-align: center;">
                    {{$p->actual_machine_hour_average}}
                </td>
            @endif
            <td>{{$p->remarks}}</td>
        </tr>
        @php
            $pname = $p->pname;
            $batch = $p->batch_number;
        @endphp
    @endforeach
    </tbody>
    <tfoot>
    <tr style="text-align: center;">
        <td colspan="4" style="text-align: center;background-color: #05B1FC;">Grand Total</td>
        <td style="background-color: #05B1FC;">{{$tp}}</td>
        <td style="background-color: #05B1FC;">{{$ts}}</td>
        <td style="background-color: #05B1FC;"></td>
        <td style="background-color: #05B1FC;">{{$pdata1[0]->sample_analysis_time_average}}</td>
        <td style="background-color: #05B1FC;"></td>
        <td style="background-color: #05B1FC;">{{$pdata1[0]->calculated_hour_average}}</td>
        <td style="background-color: #05B1FC;"></td>
        <td style="background-color: #05B1FC;">{{$pdata1[0]->actual_machine_hour_average}}</td>
        <td style="background-color: #05B1FC;"></td>
    </tr>
    </tfoot>
</table>
</body>
</html>