<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-size: 15px;">
<div>
    <center>
        <table>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>INCEPTA PHARMACEUTICALS LTD.</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>RESEARCH EXPENSES</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>SUMMARY REPORT</b></td>
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
        <td colspan="3"><b>Donation Month: {{\Carbon\Carbon::now()->format('d-m-Y')}}</b></td>
    </tr>
    </table>
</div>
<div>
    <table  border="1">
        <thead>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th>SL</th>
                    <th>DNT ID</th>
                    <th>Name</th>
                    <th>In favour of</th>
                    <th>Donation Amount</th>
                    <th>Purpose</th>
                    <th>Budget owner</th>
                    <th>Depot</th>
                    <th>Territory Id</th>
                    <th>AM</th>
                    <th>RM/ASM</th>
                </tr>

        </thead>
        <tbody>
        @foreach($rs_data as $rd)
            <tr>
                <td align="center">{{ $rd->sl }}</td>
                <td>{{ $rd->fi_doc_no }}</td>
                <td >{{ $rd->doctor_name }}</td>
                <td>{{ $rd->in_favour_of }}</td>
                <td >{{ $rd->amount }}</td>
                <td>{{ $rd->purpose }}</td>
                <td >{{ $rd->budget_owner }}</td>
                <td>{{ $rd->depot_id }}</td>
                <td >{{ $rd->terr_id }}</td>
                <td>{{ $rd->am_name }}</td>
                <td >{{ $rd->rm_name }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr style="border: 1px solid #000000;">

                <td></td>
                <td></td>
                <td></td>
                <td>TOTAL</td>
                <td style="text-align: right;">{{number_format($rs_data[0]->total_amount)}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                {{--<td style="text-align: right;">{{number_format($ts->s10)}}</td>--}}
                {{--<td style="text-align: right;">{{number_format($ts->s11)}}</td>--}}
                {{--<td style="text-align: right;">{{number_format($ts->s12)}}</td>--}}
                {{--<td style="text-align: right;">{{number_format($ts->s13)}}</td>--}}

            {{--</tr>--}}
        </tfoot>
    </table>
</div>
<div>
    <br>
    <br>
    <table>
        <tr>
            <td></td>
            <td></td>
            <td style="font-weight: bold;"><b><?php
                    $currency = new \App\Currency_To_Word();
                    $spell = $currency->get_bd_amount_in_text($rs_data[0]->total_amount);
                    echo 'IN WORDS: '.$spell;
                    
//                     $spell = new NumberFormatter('en', NumberFormatter::SPELLOUT);
//                     echo 'IN WORDS: ' . strtoupper($spell->format($rs_data[0]->amount));
                    ?></b></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <br>
    <table>
        <tr>
            <td></td>
            <td>------------------------</td>
            <td></td>
            <td></td>
            <td>------------------------</td>
            <td></td>
            <td></td>
            <td>------------------------</td>
            <td></td>
            <td></td>
            <td>------------------------</td>
        </tr>
        <tr>
            <td></td>
            <td>Prepared & checked by</td>
            <td></td>
            <td></td>
            <td>Verified by</td>
            <td></td>
            <td></td>
            <td>Approved by</td>
            <td></td>
            <td></td>
            <td>Posted by Accounts</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

</div>
</body>
</html>
