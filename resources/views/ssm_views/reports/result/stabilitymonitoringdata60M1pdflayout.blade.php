<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stability Monitoring Data</title>
</head>
<body>

<table>
    <tbody>
    <tr>
        <td>
            <?php
            $path =public_path('site_resource/images/INCEPTALOGO.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
            <div style="margin-left: 350px"><img src="{{$base64}}" alt="" width="600px" height="100px"></div>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%">
    <tbody>
    <tr>
        <td colspan="12" style="text-align: center;padding: 0;margin: 0">
            <p>Summary of Stability Monitoring Data</p>
        </td>
    </tr>
    <tr>
        <td colspan="12" style="text-align: center; padding: 0;margin: 0">
            <p>R&DA Department</p>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table  width="100%">
    <tbody>
    <tr>
        <td colspan="10">Product Name: {{$pname}}</td>

        <td colspan="1" ><span style="margin-left: 300px">Batch size:</span> </td>
    </tr>
    <tr> <td colspan="10">Batch No.: {{$batch_number}}</td>

        <td colspan="1"><span style="margin-left: 300px">Pack size: {{$PS}}</span></td>
    </tr>
    <tr>
        <td colspan="10">Kept on Date: {{$KOD}}</td>

        <td colspan="1"><span style="margin-left: 300px">Mode of packing: {{$MOP}}</span></td>
    </tr>
    <tr>
        <td colspan="10">Label claim:</td>

        <td colspan="1"></td>
    </tr>
    </tbody>
</table>
<table width="100%" style="border-collapse: collapse">
    <thead>
    <tr>
        <th rowspan="3" style="text-align: center;border: 1px solid #0a0a0a">Tests</th>
        <th rowspan="3" style="text-align: center;border: 1px solid #0a0a0a">Accept Criteria</th>
        <th colspan="10" style="text-align: center ;border: 1px solid #0a0a0a">Stability Time Points (months)</th>
    </tr>
    <tr>
        <th colspan="10" style="text-align: center;border: 1px solid #0a0a0a">Long Term Stability Data <br> (30 °C ± 2 °C/65% RH ± 5% RH)</th>
    </tr>
    <tr>
        <th style="text-align: center ;border: 1px solid #0a0a0a">initial</th>
        <th style="text-align: center ;border: 1px solid #0a0a0a">6</th>
        <th style="text-align: center ;border: 1px solid #0a0a0a">12</th>
        <th style="text-align: center ;border: 1px solid #0a0a0a">24</th>
        <th style="text-align: center ;border: 1px solid #0a0a0a">36</th>
        <th style="text-align: center ;border: 1px solid #0a0a0a">48</th>
        <th style="text-align: center ;border: 1px solid #0a0a0a">60</th>
    </tr>
    </thead>
    <tbody>
    {{--    @php--}}
    {{--        $mrtt = null;--}}
    {{--        $mit = null;--}}
    {{--    @endphp--}}

    @foreach($pdata1 as  $s)
        <tr>


            <td style="border: 1px solid #0a0a0a">{{$s->test_parameters}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->accept_criteria}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->a}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->b}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->c}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->d}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->e}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->f}}</td>
            <td style="border: 1px solid #0a0a0a">{{$s->g}}</td>
        </tr>
        {{--        @php--}}
        {{--            $mrtt = $s->m_r_time_total;--}}
        {{--                $mit = $s->m_idle_time;--}}

        {{--        @endphp--}}
    @endforeach
    {{--    @php--}}
    {{--        $hours = floor($mrtt/60);--}}
    {{--        $min = ($mrtt%60);--}}
    {{--    --}}{{--               if ($mit>1)--}}
    {{--    --}}{{--               {--}}
    {{--    --}}{{--               $hours = floor($mrtt/60);--}}
    {{--    --}}{{--               $min = ($mit%60);--}}
    {{--    --}}{{--               }--}}
    {{--         $hours1 = floor($mit/60);--}}
    {{--        $min1 = ($mit%60);--}}
    {{--    --}}{{--               if ($tm>1)--}}
    {{--    --}}{{--               {--}}
    {{--    --}}{{--               $hours1 = floor($tm/60);--}}
    {{--    --}}{{--               $min1 = ($tm%60);--}}
    {{--    --}}{{--               }--}}

    {{--    @endphp--}}
    </tbody>
    <tfoot>


    <tr style="text-align: center;">
        <td></td>
        <td></td>
        <td></td>
        <td ></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
    </tfoot>
</table>
<table width="100%">
    <tbody>
    <tr>
        <td>
            REMARKS:
        </td>
        <td colspan="10">

        </td>
    </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
    <tr style="background-color: #a9a2a2">
        <td colspan="2" >Prepared By:</td>
        <td colspan="3">Reviewed By:</td>
        <td colspan="3">Reviewed By:</td>
        <td colspan="3" >Approved By:</td>
    </tr>
    <tr>
        <td colspan="2">Atiara Parvin</td>
        <td colspan="3">Alimuzzaman</td>
        <td colspan="3">A.K.M. Zakaria</td>
        <td colspan="3">Nasreen Jahan</td>
    </tr>
    <tr>
        <td colspan="2">Executive Officer, R&DA</td>
        <td colspan="3">Sr. Executive Officer, R&DA</td>
        <td colspan="3">General Manager, R&DF</td>
        <td colspan="3">General Manager, QA</td>
    </tr>
    </tbody>
</table>
<table width="100%">
    <tbody>
    <tr style="background-color: #a9a2a2">
        <td colspan="4">Format No.: </td>
        <td colspan="4"></td>
        <td colspan="3">Page no.:</td>
    </tr>
    </tbody>
</table>
</body>
</html>