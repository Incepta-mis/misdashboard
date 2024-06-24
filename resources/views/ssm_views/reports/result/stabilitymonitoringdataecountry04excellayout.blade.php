<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stability Monitoring Data</title>
    <style>
        table > thead > tr > th {
            border: 1px solid #0a0a0a;
        }
    </style>
</head>
<body>

<br>
<br>
<br>
<br>
<table>
    <tbody>
    <tr>
        <td colspan="12" style="text-align: center">
            <h4>
                Summary of Stability Monitoring Data
            </h4>
        </td>
    </tr>
    <tr>
        <td colspan="12" style="text-align: center">
            <h4>
                R&DA Department
            </h4>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table>
    <tbody>
    <tr>
        <td colspan="3">Product Name: {{$pname}} </td>
        <td colspan="3"></td>
        <td colspan="3">Batch No.: {{$batch_number}}</td>
    </tr>
    <tr> <td colspan="3">CONTAINER CLOSURE SYSTEM:</td>
        <td colspan="3"> </td>
        <td colspan="3">DATE OF MFG :</td>
    </tr>
    <tr>
        <td colspan="3">Method of test :</td>
        <td colspan="3"></td>
        <td colspan="3"></td>
    </tr>

    <tr>
        <td colspan="4">STUDY CONDITIONS :</td>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>

    </tbody>
</table>
<table>
    <thead>
    <tr>
                   <th style="border: 1px solid #0a0a0a"></th>
                   <th style="border: 1px solid #0a0a0a"></th>
                   <th style="border: 1px solid #0a0a0a" colspan="7" class="text-center">RESULTS OF ANALYSIS</th>
               </tr>
   <tr>
                   <th style="border: 1px solid #0a0a0a" rowspan="2" style="text-align: center;vertical-align: middle">Tests</th>
                   <th style="border: 1px solid #0a0a0a" rowspan="2" style="text-align: center;vertical-align: middle">Limits</th>
                   <th class="text-center">Starting</th>
                   <th class="text-center">3 months</th>
                   <th class="text-center">6 months</th>
                   <th class="text-center">9 months</th>
                   <th class="text-center">12 months</th>
                   <th class="text-center">18 months</th>
                   <th class="text-center">24 months</th>
               </tr>
    <tr>
        <th>

        </th>
        <th></th>
        <th class="text-center">Date:1</th>
        <th class="text-center">Date 2:</th>
        <th class="text-center">Date 3:</th>
        <th class="text-center">Date 4:</th>
        <th class="text-center">Date 5:</th>
        <th class="text-center">Date 6:</th>
        <th class="text-center">Date 7:</th>
    </tr>
    <tr>
        <th style="border: 1px solid #0a0a0a"style="text-align: center;vertical-align: middle">Test Parameters</th>
        <th style="border: 1px solid #0a0a0a"  style="text-align: center;vertical-align: middle">Acceptance Criteria</th>
                   <th class="text-center">Initial /Zero Result</th>
                   <th class="text-center">30 condition result data</th>
                   <th class="text-center">30 condition result data</th>
                   <th class="text-center">30 condition result data</th>
                   <th class="text-center">30 condition result data</th>
                   <th class="text-center">30 condition result data</th>
                   <th class="text-center">30 condition result data</th>
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
        <td ></td>
        <td ></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>
<table>
    <tbody>
    <tr>
        <td>
           Discussion:
        </td>
       </tr>
    <tr>
        <td>
            Conclusion:
        </td>

    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr style="background-color: #a9a2a2">

        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3" >Approved By:</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3">Nasreen Jahan</td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td colspan="3"></td>
        <td colspan="3">General Manager, QA</td>
    </tr>
    </tbody>
</table>
<table>
    <tbody>
    <tr style="background-color: #a9a2a2">
        <td colspan="4">Format No.:</td>
        <td colspan="4"></td>
        <td colspan="3"></td>
    </tr>
    </tbody>
</table>
</body>
</html>