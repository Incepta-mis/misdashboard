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
    @if(count($rs_data) > 0)
    <div>
        <center>
            <table>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td colspan="3" style="text-align: center;"><b>{{$rs_data[0]->company_name }}</b></td>
                    <td colspan="2">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td colspan="3" style="text-align: center;"><b>Payee List</b></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>
        </center>
    </div>
    <div>
        <table style="float: right;">
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="2" style="text-align: right;"><b>Summary ID: {{ $rs_data[0]->summ_id }}</b></td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="2" style="text-align: right;"><b>Month: {{\Carbon\Carbon::now()->format('d-m-Y')}}</b></td>
            </tr>
        </table>
    </div>
@endif
<?php $ar_count = count($rs_data); ?>
@if($ar_count<1)
    <span>There are no data in this table</span>

@else

    <div>
        <table  border="1">
            <thead>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th>Sl No</th>
                    <th>Name</th>
                    <th>Bank account no.</th>
                    <th>Bank name</th>
                    <th>Branch name</th>
                    <th>Routing Number</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rs_data as $plist)
                    <tr>
                        <td align="center">{{ $plist->sl }}</td>
                        <td>{{ $plist->beneficiaryname }}</td>
                        <td><span>{{ $plist->bankaccno }}</span></td>
                        <td>{{ $plist->bankname }}</td>
                        <td>{{ $plist->bankbranchname }}</td>
                        <td>{{ $plist->bankroutingnum }}</td>
                        <td>{{ number_format($plist->amount) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td></td>
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align:right"><b>{{ number_format($plist->total_amount) }}</b></td>
            </tr>
            </tfoot>
        </table>
    </div>
@endif
</body>
</html>
