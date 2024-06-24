<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payee List</title>
</head>
<body style="font-size: 15px;">
<div>
    <center>
        <table>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>{{$rs_data[0]->company_name }}</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>Payee List</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            {{--<tr>--}}
                {{--<td colspan="5">&nbsp;</td>--}}
                {{--<td colspan="4" style="text-align: center;"><b>MONTH: {{\Carbon\Carbon::parse($exp_mon)->format('F-Y')}}</b></td>--}}
                {{--<td colspan="3">&nbsp;</td>--}}
            {{--</tr>--}}
        </table>
    </center>
</div>
<div>
    <table style="float: right;">
    <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="10"></td>
        <td colspan="3"><b>Summary ID: {{ $rs_data[0]->summ_id }}</b></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="10"></td>
        <td colspan="3"><b>Month: {{\Carbon\Carbon::now()->format('d-m-Y')}}</b></td>
    </tr>
    </table>
</div>

<?php $ar_count = count($rs_data); ?>
@if($ar_count<1)
    <span>There are no data in this table</span>

@else

<div>
    <table  border="1">
        <thead>
{{--                <tr style="border: 1px solid #000000;text-align: center;">--}}
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th>Sl No</th>
                    <th>Name (Infavor of)</th>
                    <th>Amount</th>
                </tr>
{{--                </tr>--}}

        </thead>
        <tbody>
        @foreach($rs_data as $plist)
            <tr>
                <td align="center">{{ $plist->sl }}</td>
                <td>{{ $plist->in_favour_of }}</td>
                <td>{{ $plist->amount }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
{{--            <tr style="border: 1px solid #000000;">--}}
{{--            </tr>--}}
        </tfoot>
    </table>
</div>

@endif


</body>
</html>
