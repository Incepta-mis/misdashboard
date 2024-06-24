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
                <td colspan="3">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>INCEPTA PHARMACEUTICALS LTD.</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>DHAKA</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td colspan="4" style="text-align: center;"><b>STATEMENT OF MONTHLY FIELD EXPENSES</b></td>
                <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
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
        <td colspan="4"></td>
        <td colspan="3"><b>SL#8</b></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
        <td colspan="4"></td>
        <td colspan="3"><b>REPORT DATE: {{\Carbon\Carbon::now()->format('d-m-Y')}}</b></td>
    </tr>
    </table>
</div>
<div>
    <table  border="1">
        <thead>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th>SL</th>
                    <th>NAME OF DEPOT</th>
                    <th colspan="4">No of People</th>
                    <th colspan="4">Amount</th>
                </tr>
                <tr style="border: 1px solid #000000;text-align: center;">
                    <th></th>
                    <th></th>
                    <th>General Team</th>
                    <th>Aster-Gyrus</th>
                    <th>Operon-Xenv</th>
{{--                    <th>Animal Health</th>--}}
                    <th>Human Vaccine</th>
{{--                    <th>Hospicare</th>--}}
{{--                    <th>Hygiene</th>--}}
                    <th>General Team</th>
                    <th>Aster-Gyrus</th>
                    <th>Operon-Xenv</th>
{{--                    <th>Animal Health</th>--}}
                    <th>Human Vaccine</th>
{{--                    <th>Hospicare</th>--}}
{{--                    <th>Hygiene</th>--}}
                </tr>
                <tr style="border: 1px solid #000000;text-align: center;">
{{--                    <th></th>--}}
{{--                    <th></th>--}}
{{--                    <th></th>--}}
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>(1000101204)</th>
                    <th>(1000101202)</th>
                    <th>(1000101203)</th>
{{--                    <th>(1000801205)</th>--}}
                    <th>2000301201</th>
{{--                    <th>5000701205</th>--}}
{{--                    <th>5000501205</th>--}}

                </tr>
        </thead>
        <tbody>

        @foreach($sdata as $data)
                <tr style="border: 1px solid #000000;">
                    <td>{{$data->depot_id}}</td>
                    <td>{{$data->depot_name}}</td>
                    <td style="text-align: right;">{{number_format($data->gm1_general)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm2_agl)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm2_opexen)}}</td>
{{--                    <td style="text-align: right;">{{number_format($data->gm3_ahv)}}</td>--}}
                    <td style="text-align: right;">{{number_format($data->gm1_hvc)}}</td>
{{--                    <td style="text-align: right;">{{number_format($data->gm1_hosp)}}</td>--}}
{{--                    <td style="text-align: right;">{{number_format($data->gm3_hygiene)}}</td>--}}
                    <td style="text-align: right;">{{number_format($data->gm1_general_val)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm2_agl_val)}}</td>
                    <td style="text-align: right;">{{number_format($data->gm2_opexen_val)}}</td>
{{--                    <td style="text-align: right;">{{number_format($data->gm3_ahv_val)}}</td>--}}
                    <td style="text-align: right;">{{number_format($data->gm1_hvc_val)}}</td>
{{--                    <td style="text-align: right;">{{number_format($data->gm1_hosp_val)}}</td>--}}
{{--                    <td style="text-align: right;">{{number_format($data->gm3_hygiene_val)}}</td>--}}
                </tr>
            @endforeach    
        </tbody>
        <tfoot>
        <tr>&nbsp;</tr>
        @foreach($tdata as $ts)
            <?php
            $total_exp_app = 0;
            $total_exp_app += $ts->gm1_general_val + $ts->gm2_agl_val + $ts->gm2_opexen_val + $ts->gm1_hvc_val;
            ?>
            <tr style="border: 1px solid #000000;">
                <td colspan="2">TOTAL</td>
                <td style="text-align: right;">{{number_format($ts->gm1_general)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_agl)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_opexen)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm3_ahv)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_hvc)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm1_hosp)}}</td>--}}
{{--                <td style="text-align: right;">{{number_format($ts->gm3_hygiene)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_general_val)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_agl_val)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_opexen_val)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm3_ahv_val)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_hvc_val)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm1_hosp_val)}}</td>--}}
{{--                <td style="text-align: right;">{{number_format($ts->gm3_hygiene_val)}}</td>/--}}
                <td style="text-align: right;">{{number_format($total_exp_app)}}</td>
            </tr>
        @endforeach
        @foreach($pdt as $ts)
            <?php
            $total_exp_prev = 0;
            $total_exp_prev += $ts->gm1_general_val + $ts->gm2_agl_val + $ts->gm2_opexen_val + $ts->gm1_hvc_val;
            ?>
            <tr style="border: 1px solid #000000;">
                <td colspan="2">PREVIOUS</td>
                <td style="text-align: right;">{{number_format($ts->gm1_general)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_agl)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_opexen)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm3_ahv)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_hvc)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm1_hosp)}}</td>--}}
{{--                <td style="text-align: right;">{{number_format($ts->gm3_hygiene)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_general_val)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_agl_val)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_opexen_val)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm3_ahv_val)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_hvc_val)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm1_hosp_val)}}</td>--}}
{{--                <td style="text-align: right;">{{number_format($ts->gm3_hygiene_val)}}</td>--}}
                <td style="text-align: right;">{{number_format($total_exp_prev)}}</td>
            </tr>
        @endforeach
        @foreach($incr as $ts)
            <?php
            $total_exp_incr = 0;
            $total_exp_incr += $ts->gm1_general_val + $ts->gm2_agl_val + $ts->gm2_opexen_val + $ts->gm1_hvc_val;
            ?>
            <tr style="border: 1px solid #000000;">
                <td colspan="2">Incr/Dcr</td>
                <td style="text-align: right;">{{number_format($ts->gm1_general)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_agl)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_opexen)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm3_ahv)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_hvc)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm1_hosp)}}</td>--}}
{{--                <td style="text-align: right;">{{number_format($ts->gm3_hygiene)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_general_val)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_agl_val)}}</td>
                <td style="text-align: right;">{{number_format($ts->gm2_opexen_val)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm3_ahv_val)}}</td>--}}
                <td style="text-align: right;">{{number_format($ts->gm1_hvc_val)}}</td>
{{--                <td style="text-align: right;">{{number_format($ts->gm1_hosp_val)}}</td>--}}
{{--                <td style="text-align: right;">{{number_format($ts->gm3_hygiene_val)}}</td>--}}
                <td style="text-align: right;">{{number_format($total_exp_incr)}}</td>
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
                    $spell = $currency->get_bd_amount_in_text($depot_total[0]->depot_total);
                    echo 'IN WORDS: '.$spell;
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
{{--            <td></td>--}}
{{--            <td></td>--}}
            <td></td>
            <td></td>
            <td>------------------------</td>
{{--            <td></td>--}}
{{--            <td></td>--}}
            <td></td>
            <td></td>
            <td>------------------------</td>
        </tr>
        <tr>
            <td></td>
            <td>Prepared by</td>
{{--            <td></td>--}}
{{--            <td></td>--}}
            <td></td>
            <td></td>
            <td>Verified by</td>
{{--            <td></td>--}}
{{--            <td></td>/--}}
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
