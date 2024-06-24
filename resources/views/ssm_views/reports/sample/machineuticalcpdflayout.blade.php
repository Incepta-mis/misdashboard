<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Machine Utilization Calculation</title>
    <style>
        table{
            border-collapse: collapse;
        }
        body{
            font-size: 12px;
        }
    </style>
</head>
<body>
<table width="100%" border="1">
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Machine ID</th>
        <th>Product Name</th>
        <th>Batch</th>
        <th>Machine Start Date Time</th>
        <th>Machine Stop Date Time</th>
        <th>Machine Run Time</th>
        <th>Remarks</th>
    </tr>
    </thead>
    <tbody>
    @php
        $thm = null;
        $tm = 0;
    $hours = 0;
    $min = 0;
    @endphp
    @foreach($pdata1 as  $s)
        <tr>

            <td>{{$loop->index+1}}</td>
            <td>{{$s->m_id}}</td>
            <td>{{$s->pname}}</td>
            <td>{{$s->batch_number}}</td>
            <td>{{$s->m_start_date_time}}</td>
            <td>{{$s->m_stop_date_time}}</td>
            <td>{{$s->tot_mh}}</td>
            <td>{{$s->remarks}}</td>
        </tr>
        @php
            $tm += $s->tot_min;


        @endphp
    @endforeach

    </tbody>
    <tfoot>
    @php
        $hours = floor($tm/60);
           $min = ($tm%60);
{{--           if ($tm>1)--}}
{{--           {--}}
{{--           $hours = floor($tm/60);--}}
{{--           $min = ($tm%60);--}}
{{--           }--}}

    @endphp
    <tr style="text-align: center;">
        <td></td>
        <td></td>
        <td style="background-color: #05B1FC;">Grand Total</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #05B1FC;">{{$hours}}:{{$min}}</td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>