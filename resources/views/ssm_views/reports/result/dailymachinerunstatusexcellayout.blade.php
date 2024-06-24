<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily machine Run Status</title>
</head>
<body>
<table>
    <thead>
    <tr style="background-color: #FFB093;">
        <th>SL No.</th>
        <th>Machine ID</th>
        <th>Machine Name</th>
        <th>Machine Assign To</th>
        <th>Product Name</th>
        <th>Machine Start Date Time</th>
        <th>Machine Stop Date Time</th>
        <th>Machine Run Time Total</th>
        <th>Machine Idle Time</th>
        <th>Justification Of Machine Idle Time</th>
    </tr>
    </thead>
    <tbody>
    @php
    $mrtt = null;
    $mit = null;
    @endphp

    @foreach($pdata1 as  $s)
        <tr>

            <td>{{$loop->index+1}}</td>
            <td>{{$s->m_id}}</td>
            <td>{{$s->m_name}}</td>
            <td>{{$s->m_a_to}}</td>
            <td>{{$s->pname}}</td>
            <td>{{$s->m_start_date_time}}</td>
            <td>{{$s->m_stop_date_time}}</td>
            <td>{{$s->m_r_time_total}}</td>
            <td>{{$s->m_idle_time}}</td>
            <td>{{$s->jomi_time}}</td>
        </tr>
@php
    $mrtt += $s->m_r_time_total;
        $mit += $s->m_idle_time;

@endphp
    @endforeach
    @php
    $hours = floor($mrtt/60);
    $min = ($mrtt%60);
{{--               if ($mit>1)--}}
{{--               {--}}
{{--               $hours = floor($mrtt/60);--}}
{{--               $min = ($mit%60);--}}
{{--               }--}}
     $hours1 = floor($mit/60);
    $min1 = ($mit%60);
{{--               if ($tm>1)--}}
{{--               {--}}
{{--               $hours1 = floor($tm/60);--}}
{{--               $min1 = ($tm%60);--}}
{{--               }--}}

               @endphp
    </tbody>
    <tfoot>

    <tr style="text-align: center;">
        <td></td>
        <td></td>
        <td ></td>
        <td style="background-color: #05B1FC;">Grand Total</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="background-color: #05B1FC;">{{$hours}}:{{$min}}</td>
        <td style="background-color: #05B1FC;">{{$hours1}}:{{$min1}}</td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>