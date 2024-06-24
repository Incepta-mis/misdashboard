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
                <td colspan="4" style="text-align: center;"><b>DHAKA</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>STATEMENT OF MONTHLY FIELD EXPENSES</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>MONTH: {{\Carbon\Carbon::parse($exp_mon)->format('F-Y')}}</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
        </table>
    </center>
</div>
<div>
    <table style="float: right;">
    <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="10"></td>
        <td colspan="3"><b>SL#8</b></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="10"></td>
        <td colspan="3"><b>REPORT DATE: {{\Carbon\Carbon::now()->format('d-m-Y')}}</b></td>
    </tr>
    </table>
</div>
<div>
    <table  border="1">
        <thead>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th>NAME OF</th>
                    <th>NOS</th>
                    <th>NOS</th>
                    <th>NOS</th>
                    <th>NOS</th>
                    <th>NOS</th>
                    <th>NOS</th>
                    <th>TOTAL</th>
                    <th>FIELD EXP</th>
                    <th>FIELD EXP</th>
                    <th>FIELD EXP</th>
                    <th>FIELD EXP</th>
                    <th>FIELD EXP</th>
                    <th>FIELD EXP</th>
                    <th>TOTAL</th>
                    <th>PREVIOUS</th>
                    <th>INCR</th>
                </tr>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th>DEPOT</th>
                    <th>GM-1</th>
                    <th>GM-2</th>
                    <th>GM-AST</th>
                    <th>GYR</th>
                    <th>GM-OP-XEN</th>
                    <th>OTH</th>
                    <th></th>
                    <th>GM-1</th>
                    <th>GM-2</th>
                    <th>GM-SP(AST)</th>
                    <th>GM-SP(GYR)</th>
                    <th>GM-OP-XEN</th>
                    <th>CREDIT</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>(1000101204)</th>
                    <th>(1000101205)</th>
                    <th colspan="2">(1000101202)</th>
                    <th>(1000101203)</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
        </thead>
        <tbody>
            @foreach($sdata as $data)
                <tr style="border: 1px solid #000000;">
                    <td>{{$data->depot_name}}</td>
                    <td style="text-align: right;">{{number_format($data->gm1_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm2_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_ast_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_gyr_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_op_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_oth_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->total_noe)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm1_noe_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm2_noe_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_ast_noe_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_gyr_noe_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_op_noe__value)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm_oth_noe_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->total_noe_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->total_noe_prev_value)}}</td>
                    <td style="text-align: right;">{{number_format($data->incr_decr)}}</td>
                </tr>
            @endforeach    
        </tbody>
        <tfoot>
        <tr>&nbsp;</tr>
        @foreach($tdata as $ts)
            <tr style="border: 1px solid #000000;">
                <td>TOTAL</td>
                <td style="text-align: right;">{{number_format($ts->s1)}}</td>
                <td style="text-align: right;">{{number_format($ts->s2)}}</td>
                <td style="text-align: right;">{{number_format($ts->s3)}}</td>
                <td style="text-align: right;">{{number_format($ts->s4)}}</td>
                <td style="text-align: right;">{{number_format($ts->s5)}}</td>
                <td style="text-align: right;">{{number_format($ts->s6)}}</td>
                <td style="text-align: right;">{{number_format($ts->s7)}}</td>
                <td style="text-align: right;">{{number_format($ts->s8)}}</td>
                <td style="text-align: right;">{{number_format($ts->s9)}}</td>
                <td style="text-align: right;">{{number_format($ts->s10)}}</td>
                <td style="text-align: right;">{{number_format($ts->s11)}}</td>
                <td style="text-align: right;">{{number_format($ts->s12)}}</td>
                <td style="text-align: right;">{{number_format($ts->s13)}}</td>
                <td style="text-align: right;">{{number_format($ts->s14)}}</td>
                <td style="text-align: right;"></td>
                <td style="text-align: right;"></td>
            </tr>
        @endforeach
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
                    $spell = $currency->get_bd_amount_in_text($tdata[0]->s14);
                    echo 'IN WORDS: '.$spell;
                    
                    // $spell = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                    // echo 'IN WORDS: ' . strtoupper($spell->format($tdata[0]->s14));
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
            <td></td>
            <td></td>
            <td>------------------------</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>------------------------</td>
        </tr>
        <tr>
            <td></td>
            <td>Prepared by</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Verified by</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Approved by</td>
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
