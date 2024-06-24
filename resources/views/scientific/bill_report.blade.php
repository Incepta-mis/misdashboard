<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Scientific Seminar Proposal</title>
    <style>
        .textcntr {
            text-align: center;
            font-size: 11px;
        }

        /*---------BOOTSTRAP STYLES----------*/

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }

        .col-xs-12 {
            width: 100%;
        }

        .col-xs-11 {
            width: 91.66666667%;
        }

        .col-xs-10 {
            width: 83.33333333%;
        }

        .col-xs-9 {
            width: 75%;
        }

        .col-xs-8 {
            width: 66.66666667%;
        }

        .col-xs-7 {
            width: 58.33333333%;
        }

        .col-xs-6 {
            width: 50%;
        }

        .col-xs-5 {
            width: 41.66666667%;
        }

        .col-xs-4 {
            width: 33.33333333%;
        }

        .col-xs-3 {
            width: 25%;
        }

        .col-xs-2 {
            width: 16.66666667%;
        }

        .col-xs-1 {
            width: 8.33333333%;
        }

        .col-xs-pull-12 {
            right: 100%;
        }

        .col-xs-pull-11 {
            right: 91.66666667%;
        }

        .col-xs-pull-10 {
            right: 83.33333333%;
        }

        .col-xs-pull-9 {
            right: 75%;
        }

        .col-xs-pull-8 {
            right: 66.66666667%;
        }

        .col-xs-pull-7 {
            right: 58.33333333%;
        }

        .col-xs-pull-6 {
            right: 50%;
        }

        .col-xs-pull-5 {
            right: 41.66666667%;
        }

        .col-xs-pull-4 {
            right: 33.33333333%;
        }

        .col-xs-pull-3 {
            right: 25%;
        }

        .col-xs-pull-2 {
            right: 16.66666667%;
        }

        .col-xs-pull-1 {
            right: 8.33333333%;
        }

        .col-xs-pull-0 {
            right: 0;
        }

        .col-xs-push-12 {
            left: 100%;
        }

        .col-xs-push-11 {
            left: 91.66666667%;
        }

        .col-xs-push-10 {
            left: 83.33333333%;
        }

        .col-xs-push-9 {
            left: 75%;
        }

        .col-xs-push-8 {
            left: 66.66666667%;
        }

        .col-xs-push-7 {
            left: 58.33333333%;
        }

        .col-xs-push-6 {
            left: 50%;
        }

        .col-xs-push-5 {
            left: 41.66666667%;
        }

        .col-xs-push-4 {
            left: 33.33333333%;
        }

        .col-xs-push-3 {
            left: 25%;
        }

        .col-xs-push-2 {
            left: 16.66666667%;
        }

        .col-xs-push-1 {
            left: 8.33333333%;
        }

        .col-xs-push-0 {
            left: 0;
        }

        .col-xs-offset-12 {
            margin-left: 100%;
        }

        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }

        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }

        .col-xs-offset-9 {
            margin-left: 75%;
        }

        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }

        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }

        .col-xs-offset-6 {
            margin-left: 50%;
        }

        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }

        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }

        .col-xs-offset-3 {
            margin-left: 25%;
        }

        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }

        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }

        .col-xs-cusoffset-1 {
            margin-left: 7.33333333%;
        }

        .col-xs-offset-0 {
            margin-left: 0;
        }

        .col-xs-offset-12 {
            margin-left: 100%;
        }

        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }

        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }

        .col-xs-offset-9 {
            margin-left: 75%;
        }

        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }

        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }

        .col-xs-offset-6 {
            margin-left: 50%;
        }

        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }

        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }

        .col-xs-offset-3 {
            margin-left: 25%;
        }

        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }

        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }

        .col-xs-offset-0 {
            margin-left: 0;
        }

        /*table {*/
        /*    max-width: 100%;*/
        /*    background-color: transparent;*/

        /*}*/

        /*table {*/
        /*    border-collapse: collapse;*/

        /*}*/

        .custom_border tr th,
        .custom_border tbody tr td {
            border: 1px solid black;
            border-collapse: collapse;
            /*padding: 2px;*/
            text-align: center;
        }

        .row:before,
        .row:after {
            display: table;
            content: " ";
            clear: both;
        }


        #footer {
            position: absolute;
            bottom: 0px;
            width: 100%;
            /*font-size: 15px;*/
            font-family: "Times New Roman";
        }


        @page {
            margin: 2% 3% 1% 10%;
        }

        .ud {
            border-bottom: 1px dotted #000;
            font-weight: bold;
            text-decoration: none;
        }

        body {
            font-size: 12px;
            font-family: "Times New Roman";
        }

        .amt {
            text-align: right;
        }

        #rcorners3 {
            /*border-radius: 3px;*/
            /*border: 1px solid gray;*/
            /*padding: 3px;*/
            /*width: 100px;*/
            /*height: 15px;*/
            /*text-align: center;*/
        }

        #rcorners4 {
            border-radius: 12px;
            border: 1px solid black;
            padding: 13px;
            width: 500px;
            height: 20px;
            text-align: center;
        }


    </style>

</head>

<body>
{{--main body start--}}

<div class="row">
    <div class="col-xs-10 col-xs-offset-1">
        <div class="col-xs-2">
        <!-- <img src="{{url('public/site_resource/images/incepta.png')}}" width="80px" height="60px" style="padding-right: 15px;"> -->
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAnwAAAF2CAYAAAD0nkWtAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAABcSAAAXEgFnn9JSAAAAB3RJTUUH3wMdBxIV2glzdQAAIABJREFUeNrs3XecZFd55//POeeGqurck6UZaTSKM4pIAiSEhFAiyCwiCVhss2tjm7WNsw0vft41sNgWOLI2GGMDJoNAZLCyhHIeaZTzaHLs3FV1wznP749bXd0jNBJ4BDNonrderZ5O1dV1bt37rROeA0oppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUrth9CFQSqnn161rRSYnJynL8lm/z5rWs379vBMO1HO0UkoDn1JK/UyD22aRZqtkdHya7TvG2LptO9t2jjA6NkG7nbN1bJjp6WnGx8dptVp47wEQEUIINBqNZ739mOln/XqWZVhrieOYWq1GX18f/f399PX1kaYpxx/RR39Pg/kL5rFg3hDzh+HYeUbP60opDXxKKTXjyrUiE9Mttm/byYZNm1i7bgMbNm5ly44RpqYzvEQEIgIOMbZ6j0WMBbE4u4KyLCmKAhEhiiKccxhjEJFuANz9CfjZv16v1/HeUxRFt7fQWksURVhrQZ7EiCDisaEk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n+WF77zMV1+z1LXPEzmagOWcA3JYKnrlTK84AGsLjMsVPmMHbbUvhdwbLsbYTIpwTfUtn8acNBcm+jawGTv3toGvG/TaN15zxrMKq9MKoHXNmzL3sfOJZkqFITQ/35qCZE3b4NiG5VydtAaDa3vghRAJIVEUeWKJLRwp5XYpKeZ5tM455tafx1owBGyqme+XnDh6kAfuvYs7Th7hsbM/wQcO6PSsiIgo8MlN9MfnUnrppcs8/cyz/MXz3+b1ty4xrsG4PqYcNhs+SpLtg+2D7VGnHBK99xDWm6kPBSnmQOR908zZ5TFgk4qcc64JU/n0alEUsL52w+NLndPF1tr2n8n3VtIY66bNiiF/P8ZIqANlb9jcdvpWtcm0j2l6k10ouWG1NQlnIo6AJTFeW2ZQOnoF2BgIvoIUKQrLoFdw9vQcJ0+e5PR993LHyaN88JDCnYiIKPDJj7hvnqvSX7zwKs8+912+++qbvPjK64x8ySiUeAaYcg5bzmFsL29PqN6cBj5jCCFR+1w9SyZX3SIpNzi2OfDFJnAZY1hM1Q2Pp7terzuCbPLPlVRjmwqfJX/fYfJ4uRibtYe5ujdZiwixfaxo54kxEsMYwgibKhw1A+vp2TH16BqH9i5w6tZDnDpxmFMnbuG240c5cevBz9673/yi3jEiIqLAJz/2vrOaTv3gTV5+4eVLvPjSOb73/fOce+MCb128zMrqOkuLBSEEKh8JEYxz2KJHUfYxRcnK+gjjSjyOEBOu6FEOhqSUqMaesrpxhW9SGZxU8CanjCffKxYX8FVNSpGyKDAx4OsxNgZ6RYFNNYUBaxKkCMFjAEcOnG9dGrEwN+TAvt0cObyP40cPcuLYAW49vJe9Sz1+9syi3uMiIqLAp5fg/emFy+mX19b8f/3z585x9coyr795nvNvXuLClStcubrK1dV1Vkc1vbld2HLA2CdWRyOK3hzzi7vxPnLp6hV29Xfd8OeklNfRWWsJIbQ7cPv9PsPhkHq0wurqKil6ds0NcSYy3lihNImlXXOM15bZvdDn4N4ljhzYy6GD+zlyYB/79+9n18Ic99+z78kTe81T+o2KiIgo8MlfwTMXUvrBG4CDC9c85954i1EVKPoDLl9d5rXXXmPkBzd8jPF43G4kCSHv7O31eiwtLbG4uMjJPfOsrq4y7JccO3qQfbvBAUu74PFTWk8nIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIvL+8/8AIBFT1of0rtUAAAAASUVORK5CYII="
                 alt="" width="70px" height="50px">
        </div>
        <div class="col-xs-12 col-xs-offset-1" style="text-align: center; padding-left: 5px;">
            <span class="text-primary" style="font-size: 33px;"><b>  Incepta Pharmaceuticals Ltd</b></span>
            <br>
            <span style="font-size: 11px;"><b> Head Office:</b>40 Shahid Tajuddin Ahmed Sarani, Tejgaon I/A Dhaka - 1208, Bangladesh.

                <br> <span style="margin-left: -30px;">Phone : 880-02-8891688-703,Fax : + 88-02-8891190, E-mail : incepta@inceptapharma.com, Web :www.inceptapharma.com</span>
                    <br><b> Factory :</b> Dewan Idris Road, Bara Rangamatia, Zirabo, Savar, Dhaka
                </span>

        </div>
    </div>
</div>

<div class="row">
    <hr>
</div>
<div class="col-xs-12 " style="text-align: center;">
    <span style="font-size: 20px;">SCIENTIFIC SEMINAR BILL</span><br>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <br>
                <br>
                To <span style="font-size: 12px;float: right">Date:  <b>{{$rs_data[0]->dat}}</b> </span>
                <br>
                General Manager, Sales
                <br>
                Incepta Pharmaceuticals Ltd.
                <br>
                <br>
                <span style="font-size: 15px;"><b>Bill No. <span style="
                                border-radius: 12px;
                                border: 1px solid black;
                                padding: 13px;
                                width: 500px;
                                height: 20px;
                                text-align: center;
                                  ">{{$rs_data[0]->bill_no}}</span></b></span>
                @if($rs_data[0]->prog_no !== null)
                <span style="font-size: 15px;float: right"><b>Proposal No.  {{$rs_data[0]->prog_no}}</b> </span>
                @endif
                <br>
                <br>
                <table width="100%">
                    <tr>
                        <td colpsan="3">From</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->rm_name}}</span></td>
                        <td>Name of Territory:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->rm_terr_id}}</span></td>
                    </tr>
                    <tr>
                        <td>Team:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->prog_team}}</span></td>
                        <td>Territory Code:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->mpo_terr_id}}</span></td>
                    </tr>
                    <tr>
                        <td>Employee Code:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->rm_emp_id}}</span></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>


                    <tr>
                        <td>Program Name:</td>
                        <td><span id="rcorners3"><b>{{$rs_data[0]->program_type}}</b></span></td>
                        <td>Venue:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->program_venue}}</span></td>

                    </tr>
                    <tr>
                        <td>Date-Time:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->prog_date_time}}</span></td>
                        <td>Total Participants:</td>
                        <td><span id="rcorners3">Proposed:<b>{{$rs_data[0]->nop_proposed}}</b>
                                <span>&nbsp;</span>Attended: <b>{{$rs_data[0]->nop_attended}}</b></span></td>
                    </tr>
                    <tr>
                        <td>Program Feedback:</td>
                        <td colspan="3"><span id="rcorners3">{{$rs_data[0]->program_feedback}}</span></td>
                    </tr>
                    <tr>
                        <td>Brand Name:</td>
                        <td colspan="3"><span id="rcorners3">{{$rs_data[0]->brand_name}}</span></td>
                    </tr>
                    <tr>
                        <td>Total Expenditure:</td>
                        <td><b>{{number_format($rs_data[0]->actual_expenditure)}} </b></td>
                        <td colspan="2">In Word: <span>&nbsp;</span>
                            <?php
                            $currency = new \App\Currency_To_Word();
                            $spell = $currency->get_bd_amount_in_text($rs_data[0]->actual_expenditure);
                            echo '' . $spell . ' only';
                            ?>
                        </td>

                    </tr>
                    @if($rs_data[0]->advance_budget !== null)
                    <tr>
                        <td>Advance Budget:</td>
                        <td><b>{{number_format($rs_data[0]->advance_budget)}} </b></td>
                        <td colspan="2">In Word: <span>&nbsp;</span>
                            <?php
                            $currency = new \App\Currency_To_Word();
                            $spell = $currency->get_bd_amount_in_text($rs_data[0]->advance_budget);
                            echo '' . $spell . ' only';
                            ?>
                        </td>

                    </tr>
                    @endif
                    @if($rs_data[0]->advance_budget !== null)
                    <tr>
                        @if($rs_data[0]->advance_budget > $rs_data[0]->actual_expenditure )
                        <td>Refundable :</td>
                            @elseif($rs_data[0]->actual_expenditure > $rs_data[0]->advance_budget )
                            <td>Payable :</td>
                        @else
                            <td>Payable/Refundable :</td>
                        @endif
                        <td><b>{{number_format($rs_data[0]->payable_refundable)}} </b></td>
                        <td colspan="2">In Word: <span>&nbsp;</span>
                            <?php
                            $currency = new \App\Currency_To_Word();
                            $spell = $currency->get_bd_amount_in_text($rs_data[0]->payable_refundable);
                            echo '' . $spell . ' only';
                            ?>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Month of Bill:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->month_of_prog}}</span></td>
{{--                        <td>Cost Per Head:</td>--}}
{{--                        <td><span id="rcorners3"><b>{{number_format($rs_data[0]->cost_per_head)}} </b> </span></td>--}}
                    </tr>

                    <tr>
                        <td>Institute/Association/Doctor :</td>
                        <td colspan="3"><span id="rcorners3">{{$rs_data[0]->program_details}}</span></td>

                    </tr>

                    <tr>
                        <td>Promotional Materials :</td>
                        <td colspan="3"><span id="rcorners3">{{$rs_data[0]->pm}}</span></td>

                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Region:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->rm_terr_id}}</span></td>
                        <td>Concern Depot:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->depot_name}}</span></td>
                    </tr>

                    <tr>
                        <td>SAM/AM Name:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->am_name}}</span></td>
                        <td>ASM/RM Name:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->rm_name}}</span></td>
                    </tr>


                    <tr>
                        <td colspan="">Sr.SM/SM/DSM Name:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->sm_name}}</span></td>
                        <td>GM Name:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->gm_name}}</span></td>
                    </tr>
                    <tr>
                        <td colspan="">SAM/AM Tr. Code & Mob:</td>
                        <td><span id="rcorners3">{{$rs_data[0]->am_terr_id}}<span>&nbsp;</span> {{$rs_data[0]->mobile}}</span>
                        </td>
                        {{--                        <td colspan="">GL: <span>&nbsp;</span>--}}
                        {{--                        </td>--}}
                        {{--                        <td>--}}
                        {{--                            @foreach($gl as $gl)--}}
                        {{--                                <span>{{$gl->gl}}</span> <span>&nbsp;</span>--}}
                        {{--                            @endforeach--}}
                        {{--                        </td>--}}
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>


                </table>

            </div>
        </div>
    </div>
</div>


@if(!empty($budget) && !empty($cost))


    <span style="float:left;">

            <table width="60%">
            <td align="left"><b>Budget Details</b></td>
            <td align="right" colspan="2">
                <b>GL </b> <span>&nbsp;</span>
            @foreach($gl as $gl)
                    <span style="font-size: 15px;"><b>{{$gl->gl}}</b></span> <span>&nbsp;</span>
                @endforeach
            </td>

            </table>
        <p>
        </p>

         <table class="custom_border" width="60%">
                    <tr>
                        <th style="font-size: 15px;">Team</th>
                        <th style="font-size: 15px;">Cost Center</th>
                        <th style="font-size: 15px;">Amount</th>
                    </tr>
                    <tbody>

                    @foreach($budget as $rd)
                        <tr>
                            <td style="text-align:left">{{ $rd->cc_team_name }}</td>
                            <td style="text-align:left">{{ $rd->cost_center_id }}</td>
{{--                            <td style="text-align:right">{{number_format($rd->pro_amt)}}</td>--}}
                             <td style="text-align:right">{{number_format($rd->bill_amt)}}</td>
                        </tr>
                    @endforeach
<tr>
    <td colspan="2" style="text-align:right"><b>Total</b></td>
    <td style="text-align:right"><b>{{number_format($rs_data[0]->actual_expenditure)}}</b> </td>
</tr>
                    </tbody>

                </table>


    </span>


    <span style="float:right;">
             <table width="33%">
            <td align="left"><b>Cost Details</b></td>
            <td align="right">
            </td>
            </table>
        <p>
        </p>

{{--        <p style="margin-right:5%;"><b>Cost Details</b></p>--}}
          <table class="custom_border" width="33%">
                    <tr>
                        <th style="font-size: 15px;">Item</th>
                        <th style="font-size: 15px;">Amount</th>
                    </tr>
                    <tbody>

                    @foreach($cost as $rd)
                        <tr>
                            <td style="text-align:left">{{ $rd->ci_name }}</td>
{{--                            <td style="text-align:right">{{number_format($rd->pro_amt)}}</td>--}}
                            <td style="text-align:right">{{number_format($rd->bill_amt)}}</td>
                        </tr>
                    @endforeach
                <tr>
                    <td style="text-align:right"><b>Total</b></td>
                    <td style="text-align:right"><b>{{number_format($rs_data[0]->actual_expenditure)}}</b></td>
                </tr>
                    </tbody>

                </table>

            </span>

    {{--                </div>--}}

@endif

<br>
<br>

{{--main body end--}}

<footer id="footer">

    {{--</div>--}}
    <div class="row">

        <div class="col-xs-1"></div>
        <div class="col-xs-9" style="font-size: x-small">
            <p id="rcorners4">This is a system-generated form, so no sign is required. Please inform
                MSD/SSD department of discrepancies, if any.</p>
        </div>
        <div class="col-xs-2"></div>

    </div>

</footer>

</body>


</html>

