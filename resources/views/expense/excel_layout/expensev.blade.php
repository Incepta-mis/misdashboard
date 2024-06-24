<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Field Expense Data</title>
</head>
<body>

<table>
    <tr>
        <td></td>
        <td></td>
        <td style="font-size: 30px;" colspan="5"><b><span
                        style="text-align: center;"><h2>INCEPTA PHARMACEUTICALS LTD.</h2></span></b></td>
    </tr>
</table>

<table>
    <tr>
        <td>
            <b>TO</b>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><b>Report Date:</b></td>
        <td>
            <b>{{\Carbon\Carbon::now()->format('d-m-Y')}}</b>
        </td>
    </tr>
    <tr>
        <td>
            <b>THE MANAGING DIRECTOR</b>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
            <b>SUBJECT: MONTHLY FIELD EXPENSES</b>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
            <b>MONTH: {{\Carbon\Carbon::parse($exp_mon)->format('F-Y')}}</b>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
        </td>
    </tr>

</table>

<table border="1">
    <thead>
    <tr style="border: 1px solid #000000;">
        <th style="text-align: center;">SL</th>
        <th style="text-align: center;">BASE</th>
        <th style="text-align: center;">ID NO</th>
        <th style="text-align: center;">NAME</th>
        <th style="text-align: center;">DESIG</th>
        <th style="text-align: center;">Tr.C</th>
        <th style="text-align: center;">Exp.App.</th>
        <th style="text-align: center;">Exp.Rec.</th>
        <th style="text-align: center;">Deduction</th>
    </tr>
    </thead>
    <tbody>
    @foreach($depot_data as $depots)
        <tr style="border: 1px solid #000000;">
            <td></td>
            <td colspan="8"
                style="font-size: 11px;font-weight: bold;">{{$depots->depot_name}}</td>
        </tr>
        @foreach($gm_wise_pgrp as $pgr)
            @if($depots->d_id == $pgr->d_id)
                <tr style="border: 1px solid #000000;">
                    <td></td>
                    <td colspan="8"
                        style="font-size: 11px;font-weight: bold;">{{$pgr->gm_id }}
                        -{{$pgr->p_group}}</td>
                </tr>
                <?php
                $total_exp_app = 0;
                $total_exp_rec = 0;
                $total_deduction = 0;
                ?>
                @foreach($mpo_info as $mi)
                    @if($mi->gm_id == $pgr->gm_id && $mi->p_group == $pgr->p_group && $mi->d_id == $depots->d_id)
                        <tr style="border: 1px solid #000000;">
                            <td style="text-align: center;">{{$mi->serial}}</td>
                            <td style="padding-left: 2px;">{{$mi->base}}</td>
                            <td style="text-align: center;">{{$mi->emp_id}}</td>
                            <td style="padding-left: 2px;">{{$mi->emp_name}}</td>
                            <td style="text-align: center;">{{$mi->desig}}</td>
                            <td style="text-align: center;">{{$mi->terr_id}}</td>
                            <td style="text-align: right;padding-right: 2px;">{{number_format($mi->exp_app)}}</td>
                            <td style="text-align: right;padding-right: 2px;">{{number_format($mi->exp_rec)}}</td>
                            <td style="text-align: right;padding-right: 2px;">{{number_format($mi->deduction)}}</td>
                        </tr>
                        <?php
                        $total_exp_app += $mi->exp_app;
                        $total_exp_rec += $mi->exp_rec;
                        $total_deduction += $mi->deduction;
                        ?>
                    @endif
                @endforeach
                <tr style="border: 1px solid #000000;">
                    <td colspan="6" style="text-align: right;font-size: 11px;font-weight: bold;">Subtotal:</td>
                    <td style="font-size: 11px;text-align: right;padding-right: 2px;font-weight: bold;">{{number_format($total_exp_app)}}</td>
                    <td style="font-size: 11px;text-align: right;padding-right: 2px;font-weight: bold;">{{number_format($total_exp_rec)}}</td>
                    <td style="font-size: 11px;text-align: right;padding-right: 2px;font-weight: bold;">{{number_format($total_deduction)}}</td>
                </tr>
            @endif
        @endforeach
    @endforeach
    <tr style="border: 1px solid #000000;">
        <td colspan="6" style="text-align: right;font-size: 11px;font-weight: bold;">NAR total:</td>
            <?php
                $dt_exp_app = 0;
                $dt_exp_rec = 0;
                $dt_deduction = 0;

                foreach($mpo_info as $mi){
                    $dt_exp_app += $mi->exp_app;
                    $dt_exp_rec += $mi->exp_rec;
                    $dt_deduction +=$mi->deduction;
                }
                ?>
        <td style="font-size: 11px;text-align: right;padding-right: 2px;font-weight: bold;">{{number_format($dt_exp_app)}}</td>
        <td style="font-size: 11px;text-align: right;padding-right: 2px;font-weight: bold;">{{number_format($dt_exp_rec)}}</td>
        <td style="font-size: 11px;text-align: right;padding-right: 2px;font-weight: bold;">{{number_format($dt_deduction)}}</td>
    </tr>
    </tbody>
</table>
<br>

<table>
    <tr>
        <td></td>
        <td></td>
        <td style="font-size: 11px;font-weight: bold;"><b><?php

                $currency = new \App\Currency_To_Word();
                    $spell = $currency->get_bd_amount_in_text($dt_exp_app);
                    echo 'IN WORDS: '.$spell;
                     
                // $spell = new NumberFormatter('en', NumberFormatter::SPELLOUT);
                // echo 'IN WORDS: ' . strtoupper($spell->format($dt_exp_app));
                ?></b></td>
        <td></td>
        <td></td>
    </tr>
</table>

<br>
<br>
<br>
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
    </tr>
    <tr>
        <td></td>
        <td>Prepared by</td>
        <td></td>
        <td></td>
        <td>Verified by</td>
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
    </tr>
</table>

</body>
</html>