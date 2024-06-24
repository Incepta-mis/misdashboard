{{--Comparative Analysis For Sales Report --}}
{{--developed by:Md.Raqib Hasan--}}
{{--emp code:1012064--}}
@extends('_layout_shared._master')
@section('title','Sales Comparison')
@section('styles')
    @include('comp_analysis_of_sales.caos_styles')
@endsection
@section('right-content')
    <section class="panel">
        <div class="panel-body">

            <div class="tableFixHead table-responsive">
                <table class="table table-striped table-condensed table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2" style="font-size: 1.5rem;">Sales Comparison</th>
                        <th colspan="13" style="font-size: 1.5rem;" class="text-center">
                            {{-- @if($year[0]->syear)  {{$year[0]->syear}} @endif --}}
                        </th>
                    </tr>
                    <tr>
                        <th>Particulars</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Jan</th>
                        <th class="text-center">Feb</th>
                        <th class="text-center">Mar</th>
                        <th class="text-center">Apr</th>
                        <th class="text-center">May</th>
                        <th class="text-center">Jun</th>
                        <th class="text-center">Jul</th>
                        <th class="text-center">Aug</th>
                        <th class="text-center">Sep</th>
                        <th class="text-center">Oct</th>
                        <th class="text-center">Nov</th>
                        <th class="text-center">Dec</th>
                        <th class="text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                depot sales--}}
                    <tr>
                        <td colspan="15">
                            <span style="font-weight: bold;font-size: 1.2rem;">Depot Sales:</span>
                        </td>
                    </tr>
                    @php
                        $desc = '';
                        $year = '';

                        $gt_fyear = '';
                        $gt_frow_jan = 0;
                        $gt_frow_feb = 0;
                        $gt_frow_mar = 0;
                        $gt_frow_apr = 0;
                        $gt_frow_may = 0;
                        $gt_frow_jun = 0;
                        $gt_frow_jul = 0;
                        $gt_frow_aug = 0;
                        $gt_frow_sep = 0;
                        $gt_frow_oct = 0;
                        $gt_frow_nov = 0;
                        $gt_frow_dec = 0;

                        $gt_syear = 0;
                        $gt_srow_jan = 0;
                        $gt_srow_feb = 0;
                        $gt_srow_mar = 0;
                        $gt_srow_apr = 0;
                        $gt_srow_may = 0;
                        $gt_srow_jun = 0;
                        $gt_srow_jul = 0;
                        $gt_srow_aug = 0;
                        $gt_srow_sep = 0;
                        $gt_srow_oct = 0;
                        $gt_srow_nov = 0;
                        $gt_srow_dec = 0;

                       $gt_tyear = '';
                        $gt_trow_jan = 0;
                        $gt_trow_feb = 0;
                        $gt_trow_mar = 0;
                        $gt_trow_apr = 0;
                        $gt_trow_may = 0;
                        $gt_trow_jun = 0;
                        $gt_trow_jul = 0;
                        $gt_trow_aug = 0;
                        $gt_trow_sep = 0;
                        $gt_trow_oct = 0;
                        $gt_trow_nov = 0;
                        $gt_trow_dec = 0;

                    $gr_fyear = '';
                        $gr_frow_jan = 0;
                        $gr_frow_feb = 0;
                        $gr_frow_mar = 0;
                        $gr_frow_apr = 0;
                        $gr_frow_may = 0;
                        $gr_frow_jun = 0;
                        $gr_frow_jul = 0;
                        $gr_frow_aug = 0;
                        $gr_frow_sep = 0;
                        $gr_frow_oct = 0;
                        $gr_frow_nov = 0;
                        $gr_frow_dec = 0;

                        $gr_syear = 0;
                        $gr_srow_jan = 0;
                        $gr_srow_feb = 0;
                        $gr_srow_mar = 0;
                        $gr_srow_apr = 0;
                        $gr_srow_may = 0;
                        $gr_srow_jun = 0;
                        $gr_srow_jul = 0;
                        $gr_srow_aug = 0;
                        $gr_srow_sep = 0;
                        $gr_srow_oct = 0;
                        $gr_srow_nov = 0;
                        $gr_srow_dec = 0;

                       $gr_tyear = '';
                        $gr_trow_jan = 0;
                        $gr_trow_feb = 0;
                        $gr_trow_mar = 0;
                        $gr_trow_apr = 0;
                        $gr_trow_may = 0;
                        $gr_trow_jun = 0;
                        $gr_trow_jul = 0;
                        $gr_trow_aug = 0;
                        $gr_trow_sep = 0;
                        $gr_trow_oct = 0;
                        $gr_trow_nov = 0;
                        $gr_trow_dec = 0;

                        $idx3 = 0;
                        $idx4 = 0;

                        $cyid = 0;

                    @endphp
                    @forelse($depot_sales as $ds)
                        <tr @if(strtoupper($ds->sales_desc) == strtoupper('Depot Total Sales') )style="background-color: #c6e0b4;font-weight: bold;"
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') )
                            @php $cyid++; @endphp
                            @if($cyid == 1)
                            style="background-color: #ffff99;font-weight: bold;"
                            @elseif($cyid == 2)
                            style="background-color: #fce4d6;font-weight: bold;"
                            @php $cyid = 0; @endphp
                            @endif
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M') )style="background-color: #ffff99;font-weight: bold;"
                                @endif>
                            @if($desc !== $ds->sales_desc)
                                @if($loop->index == 3)
                                   <td rowspan="3" style="vertical-align: middle;">{{$ds->sales_desc}}</td>
                                @else
                                    <td>{{$ds->sales_desc}}</td>
                                @endif
                            @else
                                @if($loop->index !== 3 && $loop->index !== 4 && $loop->index !== 5)
                                    @if(strtoupper($desc) == strtoupper('Growth % CY M/M'))
                                        <td>{{$desc}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                            @endif
                            @if($loop->index == 0)
                                <td rowspan="3" style="vertical-align: middle;text-align: center;">{{$ds->sales_year}}</td>
                            @elseif($loop->index !== 0 && $loop->index !== 1 && $loop->index !== 2 )
                            <td class="text-center">
                                @if(strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M /PY M') )
                                    {{$ds->sales_year}}
                                @endif
                            </td>
                            @endif
                            <td class="text-right">{{$ds->jan}}@if($ds->jan !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->feb}}@if($ds->feb !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->mar}}@if($ds->mar !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->apr}}@if($ds->apr !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->may}}@if($ds->may !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->jun}}@if($ds->jun !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->jul}}@if($ds->jul !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->aug}}@if($ds->aug !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->sep}}@if($ds->sep !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->oct}}@if($ds->oct !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->nov}}@if($ds->nov !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->dec}}@if($ds->dec !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">
                                @if($loop->index === 3)
                                    @php $idx3 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 4)
                                    @php $idx4 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                           $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @endif
                                @if(strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M/M') && strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M /PY M') )
                                    {{number_format($ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                                    $ds->oct +$ds->nov + $ds->dec,2) }}
                                @endif
                                @if(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))
                                    @if($idx3 && $idx4)
                                        {{number_format((($idx3-$idx4)/$idx4)*100,2,'.','')}}%

                                    @endif
                                @endif
                            </td>

                        </tr>
                        @php
                            $desc = $ds->sales_desc;
                        @endphp
                        {{--                        grand total first row--}}
                        @if($loop->index === count($depot_sales)-6)
                            @php
                                $gt_fyear = $ds->sales_year;
                                $gt_frow_jan = $ds->jan;
                                $gt_frow_feb = $ds->feb;
                                $gt_frow_mar = $ds->mar;
                                $gt_frow_apr = $ds->apr;
                                $gt_frow_may = $ds->may;
                                $gt_frow_jun = $ds->jun;
                                $gt_frow_jul = $ds->jul;
                                $gt_frow_aug = $ds->aug;
                                $gt_frow_sep = $ds->sep;
                                $gt_frow_oct = $ds->oct;
                                $gt_frow_nov = $ds->nov;
                                $gt_frow_dec = $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total second row--}}
                        @if($loop->index === count($depot_sales)-5)
                            @php
                                $gt_syear = $ds->sales_year;
                                $gt_srow_jan = $ds->jan;
                                $gt_srow_feb = $ds->feb;
                                $gt_srow_mar = $ds->mar;
                                $gt_srow_apr = $ds->apr;
                                $gt_srow_may = $ds->may;
                                $gt_srow_jun = $ds->jun;
                                $gt_srow_jul = $ds->jul;
                                $gt_srow_aug = $ds->aug;
                                $gt_srow_sep = $ds->sep;
                                $gt_srow_oct = $ds->oct;
                                $gt_srow_nov = $ds->nov;
                                $gt_srow_dec = $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total third row--}}
                        @if($loop->index === count($depot_sales)-4)
                            @php
                                $gt_tyear = $ds->sales_year;
                                $gt_trow_jan = $ds->jan;
                                $gt_trow_feb = $ds->feb;
                                $gt_trow_mar = $ds->mar;
                                $gt_trow_apr = $ds->apr;
                                $gt_trow_may = $ds->may;
                                $gt_trow_jun = $ds->jun;
                                $gt_trow_jul = $ds->jul;
                                $gt_trow_aug = $ds->aug;
                                $gt_trow_sep = $ds->sep;
                                $gt_trow_oct = $ds->oct;
                                $gt_trow_nov = $ds->nov;
                                $gt_trow_dec = $ds->dec;
                            @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="15">No Records Found for depot Sales</td>
                        </tr>
                    @endforelse
                    {{--                institute sales--}}
                    <tr>
                        <td colspan="15"></td>
                    </tr>
                    <tr>
                        <td colspan="15">
                            <span style="font-weight: bold;font-size: 1.2rem;">Institutional Sales:</span>
                        </td>
                    </tr>
                    @php
                        $desc = '';
                        $year = '';
                        $iidx = 0;
                        $iidx2 = 0;
                        $iidx6 = 0;
                        $iidx7 = 0;
                        $iidx12 = 0;
                        $iidx13 = 0;
                    @endphp
                    @forelse($institute_sales as $ds)
                        <tr @if(strtoupper($ds->sales_desc) == strtoupper('Institutional Total Sales') )style="background-color: #d9e1f2;font-weight: bold;"
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') )
                            @php $cyid++; @endphp
                            @if($cyid == 1)
                            style="background-color: #ffff99;font-weight: bold;"
                            @elseif($cyid == 2)
                            style="background-color: #fce4d6;font-weight: bold;"
                            @php $cyid = 0; @endphp
                            @endif
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M') )style="background-color: #ffff99;font-weight: bold;"
                                @endif>

                            @if($desc !== $ds->sales_desc)
                                @if($loop->index == 0 || $loop->index == 6 || $loop->index == 12
                                    || $loop->index == 18|| $loop->index == 24)
                                    <td rowspan="3" style="vertical-align: middle;">{{$ds->sales_desc}}</td>
                                @else
                                    <td>{{$ds->sales_desc}}</td>
                                @endif
                            @else
                                @if($loop->index !== 0 && $loop->index !== 1 && $loop->index !== 2
                                    && $loop->index !== 6 && $loop->index !== 7 && $loop->index !== 8
                                    && $loop->index !== 12 && $loop->index !== 13 && $loop->index !== 14
                                    && $loop->index !== 18 && $loop->index !== 19 && $loop->index !== 20
                                    && $loop->index !== 25 && $loop->index !== 26 && $loop->index !== 27)
                                    @if(strtoupper($desc) == strtoupper('Growth % CY M/M'))
                                        <td>{{$desc}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                            @endif
                            <td class="text-center">
                                @if(strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M /PY M') )
                                    {{$ds->sales_year}}
                                @endif
                            </td>
                            <td class="text-right">{{$ds->jan}}@if($ds->jan !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->feb}}@if($ds->feb !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->mar}}@if($ds->mar !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->apr}}@if($ds->apr !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->may}}@if($ds->may !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->jun}}@if($ds->jun !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->jul}}@if($ds->jul !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->aug}}@if($ds->aug !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->sep}}@if($ds->sep !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->oct}}@if($ds->oct !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->nov}}@if($ds->nov !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->dec}}@if($ds->dec !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">
                                @if($loop->index === 0)
                                    @php $iidx = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 1)
                                    @php $iidx2 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 6)
                                    @php $iidx6 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 7)
                                    @php $iidx7 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 12)
                                    @php $iidx12 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 13)
                                    @php $iidx13 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @endif
                                @if(strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M/M') && strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M /PY M') )
                                    {{number_format($ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                        $ds->oct +$ds->nov + $ds->dec,2)}}
                                @endif
                                @if(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))
                                    @if($loop->index == 5 && $iidx && $iidx2)
                                        {{number_format((($iidx-$iidx2)/$iidx2)*100,2,'.','')}}%
                                    @elseif($loop->index == 11 && $iidx6 && $iidx7)
                                        {{number_format((($iidx6-$iidx7)/$iidx7)*100,2,'.','')}}%
                                    @elseif($loop->index == 17 && $iidx12 && $iidx13)
                                        {{number_format((($iidx12-$iidx13)/$iidx13)*100,2,'.','')}}%
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @if(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))
                            <tr>
                                <td colspan="15"></td>
                            </tr>
                        @endif
                        @php $desc = $ds->sales_desc @endphp
                        {{--                        grand total first row--}}
                        @if($loop->index === count($institute_sales)-7)
                            @php
                                $gt_frow_jan += $ds->jan;
                                $gt_frow_feb += $ds->feb;
                                $gt_frow_mar += $ds->mar;
                                $gt_frow_apr += $ds->apr;
                                $gt_frow_may += $ds->may;
                                $gt_frow_jun += $ds->jun;
                                $gt_frow_jul += $ds->jul;
                                $gt_frow_aug += $ds->aug;
                                $gt_frow_sep += $ds->sep;
                                $gt_frow_oct += $ds->oct;
                                $gt_frow_nov += $ds->nov;
                                $gt_frow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total second row--}}
                        @if($loop->index === count($institute_sales)-6)
                            @php
                                $gt_srow_jan += $ds->jan;
                                $gt_srow_feb += $ds->feb;
                                $gt_srow_mar += $ds->mar;
                                $gt_srow_apr += $ds->apr;
                                $gt_srow_may += $ds->may;
                                $gt_srow_jun += $ds->jun;
                                $gt_srow_jul += $ds->jul;
                                $gt_srow_aug += $ds->aug;
                                $gt_srow_sep += $ds->sep;
                                $gt_srow_oct += $ds->oct;
                                $gt_srow_nov += $ds->nov;
                                $gt_srow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total third row--}}
                        @if($loop->index === count($institute_sales)-5)
                            @php
                                $gt_trow_jan += $ds->jan;
                                $gt_trow_feb += $ds->feb;
                                $gt_trow_mar += $ds->mar;
                                $gt_trow_apr += $ds->apr;
                                $gt_trow_may += $ds->may;
                                $gt_trow_jun += $ds->jun;
                                $gt_trow_jul += $ds->jul;
                                $gt_trow_aug += $ds->aug;
                                $gt_trow_sep += $ds->sep;
                                $gt_trow_oct += $ds->oct;
                                $gt_trow_nov += $ds->nov;
                                $gt_trow_dec += $ds->dec;
                            @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="15">No Records Found for Institute Sales</td>
                        </tr>
                    @endforelse
                    {{--                export sales--}}
                    <tr>
                        <td colspan="15">
                            <span style="font-weight: bold;font-size: 1.2rem;">Export Sales:</span>
                        </td>
                    </tr>
                    @php
                        $desc = '';
                        $year = '';
                        $sidx = 0;
                        $sidx2 = 0;
                        $sidx6 = 0;
                        $sidx7 = 0;
                        $sidx12 = 0;
                        $sidx13 = 0;
                        $sidx18 = 0;
                        $sidx19 = 0;
                    @endphp
                    @forelse($export_sales as $ds)
                        <tr @if(strtoupper($ds->sales_desc) == strtoupper('Export Total Sales') )style="background-color: #d9e1f2;font-weight: bold;"
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') )
                            @php $cyid++; @endphp
                            @if($cyid == 1)
                            style="background-color: #ffff99;font-weight: bold;"
                            @elseif($cyid == 2)
                            style="background-color: #fce4d6;font-weight: bold;"
                            @php $cyid = 0; @endphp
                            @endif
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M') )style="background-color: #ffff99;font-weight: bold;"
                                @endif>
                            @if($desc !== $ds->sales_desc)
                                @if($loop->index == 0 || $loop->index == 6 || $loop->index == 12|| $loop->index == 18)
                                    <td rowspan="3" style="vertical-align: middle;">{{$ds->sales_desc}}</td>
                                @else
                                    <td>{{$ds->sales_desc}}</td>
                                @endif
                            @else
                                @if($loop->index !== 0 && $loop->index !== 1 && $loop->index !== 2
                                    && $loop->index !== 6 && $loop->index !== 7 && $loop->index !== 8
                                    && $loop->index !== 12 && $loop->index !== 13 && $loop->index !== 14
                                    && $loop->index !== 18 && $loop->index !== 19 && $loop->index !== 20)
                                    @if(strtoupper($desc) == strtoupper('Growth % CY M/M'))
                                        <td>{{$desc}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif
                            @endif
                            <td class="text-center">
                                @if(strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M /PY M') )
                                    {{$ds->sales_year}}
                                @endif
                            </td>
                            <td class="text-right">{{$ds->jan}}@if($ds->jan !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->feb}}@if($ds->feb !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->mar}}@if($ds->mar !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->apr}}@if($ds->apr !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->may}}@if($ds->may !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->jun}}@if($ds->jun !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->jul}}@if($ds->jul !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->aug}}@if($ds->aug !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->sep}}@if($ds->sep !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->oct}}@if($ds->oct !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->nov}}@if($ds->nov !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right">{{$ds->dec}}@if($ds->dec !== '0' && (strtoupper($ds->sales_desc) == strtoupper('Growth % CY M/M') || strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))) % @endif</td>
                            <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">
                                @if($loop->index === 0)
                                    @php $sidx = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 1)
                                    @php $sidx2 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 6)
                                    @php $sidx6 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 7)
                                    @php $sidx7 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 12)
                                    @php $sidx12 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 13)
                                    @php $sidx13 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 18)
                                    @php $sidx18 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @elseif($loop->index === 19)
                                    @php $sidx19 = $ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                         $ds->oct +$ds->nov + $ds->dec;
                                    @endphp
                                @endif
                                @if(strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M/M') && strtoupper($ds->sales_desc) !== strtoupper('Growth % CY M /PY M') )
                                    {{number_format($ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                                        $ds->oct +$ds->nov + $ds->dec,2) }}
                                @endif

                                @if(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))
                                    @if($loop->index == 5 && $sidx && $sidx2)
                                        {{number_format((($sidx-$sidx2)/$sidx2)*100,2,'.','')}}%
                                    @elseif($loop->index == 11 && $sidx6 && $sidx7)
                                        {{number_format((($sidx6-$sidx7)/$sidx7)*100,2,'.','')}}%
                                    @elseif($loop->index == 17 && $sidx12 && $sidx13)
                                        {{number_format((($sidx12-$sidx13)/$sidx13)*100,2,'.','')}}%
                                    @elseif($loop->index == 23 && $sidx18 && $sidx19)
                                        {{number_format((($sidx18-$sidx19)/$sidx19)*100,2,'.','')}}%
                            @endif
                            @endif
                        </tr>
                        @if(strtoupper($ds->sales_desc) == strtoupper('Growth % CY M /PY M'))
                            <tr>
                                <td colspan="15"></td>
                            </tr>
                        @endif
                        @php $desc = $ds->sales_desc @endphp
                        {{--                        grand total first row--}}
                        @if($loop->index === count($export_sales)-7)
                            @php
                                $gt_frow_jan += $ds->jan;
                                $gt_frow_feb += $ds->feb;
                                $gt_frow_mar += $ds->mar;
                                $gt_frow_apr += $ds->apr;
                                $gt_frow_may += $ds->may;
                                $gt_frow_jun += $ds->jun;
                                $gt_frow_jul += $ds->jul;
                                $gt_frow_aug += $ds->aug;
                                $gt_frow_sep += $ds->sep;
                                $gt_frow_oct += $ds->oct;
                                $gt_frow_nov += $ds->nov;
                                $gt_frow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total second row--}}
                        @if($loop->index === count($export_sales)-6)
                            @php
                                $gt_srow_jan += $ds->jan;
                                $gt_srow_feb += $ds->feb;
                                $gt_srow_mar += $ds->mar;
                                $gt_srow_apr += $ds->apr;
                                $gt_srow_may += $ds->may;
                                $gt_srow_jun += $ds->jun;
                                $gt_srow_jul += $ds->jul;
                                $gt_srow_aug += $ds->aug;
                                $gt_srow_sep += $ds->sep;
                                $gt_srow_oct += $ds->oct;
                                $gt_srow_nov += $ds->nov;
                                $gt_srow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total third row--}}
                        @if($loop->index === count($export_sales)-5)
                            @php
                                $gt_trow_jan += $ds->jan;
                                $gt_trow_feb += $ds->feb;
                                $gt_trow_mar += $ds->mar;
                                $gt_trow_apr += $ds->apr;
                                $gt_trow_may += $ds->may;
                                $gt_trow_jun += $ds->jun;
                                $gt_trow_jul += $ds->jul;
                                $gt_trow_aug += $ds->aug;
                                $gt_trow_sep += $ds->sep;
                                $gt_trow_oct += $ds->oct;
                                $gt_trow_nov += $ds->nov;
                                $gt_trow_dec += $ds->dec;
                            @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="15">No Records Found for Export Sales</td>
                        </tr>
                    @endforelse
                    {{--                service export toll mfg sales--}}
                    @php
                        $desc = '';
                        $year = '';
                    @endphp
                    @forelse($export_service as $ds)
                        <tr>
                            @if($desc !== $ds->sales_desc)
                                @if($loop->index == 0 )
                                    <td rowspan="3" style="vertical-align: middle;">{{$ds->sales_desc}}</td>
                                @endif
                            @endif
                            <td class="text-center">{{$ds->sales_year}}</td>
                            <td class="text-right">{{$ds->jan}}</td>
                            <td class="text-right">{{$ds->feb}}</td>
                            <td class="text-right">{{$ds->mar}}</td>
                            <td class="text-right">{{$ds->apr}}</td>
                            <td class="text-right">{{$ds->may}}</td>
                            <td class="text-right">{{$ds->jun}}</td>
                            <td class="text-right">{{$ds->jul}}</td>
                            <td class="text-right">{{$ds->aug}}</td>
                            <td class="text-right">{{$ds->sep}}</td>
                            <td class="text-right">{{$ds->oct}}</td>
                            <td class="text-right">{{$ds->nov}}</td>
                            <td class="text-right">{{$ds->dec}}</td>
                            <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">
                                {{number_format($ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                           $ds->oct +$ds->nov + $ds->dec,2) }}</td>
                        </tr>
                        @php $desc = $ds->sales_desc @endphp
                        {{--                        grand total first row--}}
                        @if($loop->index === 0)
                            @php
                                $gt_frow_jan += $ds->jan;
                                $gt_frow_feb += $ds->feb;
                                $gt_frow_mar += $ds->mar;
                                $gt_frow_apr += $ds->apr;
                                $gt_frow_may += $ds->may;
                                $gt_frow_jun += $ds->jun;
                                $gt_frow_jul += $ds->jul;
                                $gt_frow_aug += $ds->aug;
                                $gt_frow_sep += $ds->sep;
                                $gt_frow_oct += $ds->oct;
                                $gt_frow_nov += $ds->nov;
                                $gt_frow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total second row--}}
                        @if($loop->index === 1)
                            @php
                                $gt_srow_jan += $ds->jan;
                                $gt_srow_feb += $ds->feb;
                                $gt_srow_mar += $ds->mar;
                                $gt_srow_apr += $ds->apr;
                                $gt_srow_may += $ds->may;
                                $gt_srow_jun += $ds->jun;
                                $gt_srow_jul += $ds->jul;
                                $gt_srow_aug += $ds->aug;
                                $gt_srow_sep += $ds->sep;
                                $gt_srow_oct += $ds->oct;
                                $gt_srow_nov += $ds->nov;
                                $gt_srow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total third row--}}
                        @if($loop->index === 2)
                            @php
                                $gt_trow_jan += $ds->jan;
                                $gt_trow_feb += $ds->feb;
                                $gt_trow_mar += $ds->mar;
                                $gt_trow_apr += $ds->apr;
                                $gt_trow_may += $ds->may;
                                $gt_trow_jun += $ds->jun;
                                $gt_trow_jul += $ds->jul;
                                $gt_trow_aug += $ds->aug;
                                $gt_trow_sep += $ds->sep;
                                $gt_trow_oct += $ds->oct;
                                $gt_trow_nov += $ds->nov;
                                $gt_trow_dec += $ds->dec;
                            @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="15">No Records Found for service export</td>
                        </tr>
                    @endforelse
                    @php
                        $desc = '';
                        $year = '';
                    @endphp
                    @forelse($toll as $ds)
                        <tr>
                            @if($desc !== $ds->sales_desc)
                                @if($loop->index == 0 )
                                    <td rowspan="3" style="vertical-align: middle;">{{$ds->sales_desc}}</td>
                                @endif
                            @endif
                            <td class="text-center">{{$ds->sales_year}}</td>
                            <td class="text-right">{{$ds->jan}}</td>
                            <td class="text-right">{{$ds->feb}}</td>
                            <td class="text-right">{{$ds->mar}}</td>
                            <td class="text-right">{{$ds->apr}}</td>
                            <td class="text-right">{{$ds->may}}</td>
                            <td class="text-right">{{$ds->jun}}</td>
                            <td class="text-right">{{$ds->jul}}</td>
                            <td class="text-right">{{$ds->aug}}</td>
                            <td class="text-right">{{$ds->sep}}</td>
                            <td class="text-right">{{$ds->oct}}</td>
                            <td class="text-right">{{$ds->nov}}</td>
                            <td class="text-right">{{$ds->dec}}</td>
                            <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">{{number_format($ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                           $ds->oct +$ds->nov + $ds->dec,2) }}</td>
                        </tr>
                        @php $desc = $ds->sales_desc @endphp
                        {{--                        grand total first row--}}
                        @if($loop->index === 0)
                            @php
                                $gt_frow_jan += $ds->jan;
                                $gt_frow_feb += $ds->feb;
                                $gt_frow_mar += $ds->mar;
                                $gt_frow_apr += $ds->apr;
                                $gt_frow_may += $ds->may;
                                $gt_frow_jun += $ds->jun;
                                $gt_frow_jul += $ds->jul;
                                $gt_frow_aug += $ds->aug;
                                $gt_frow_sep += $ds->sep;
                                $gt_frow_oct += $ds->oct;
                                $gt_frow_nov += $ds->nov;
                                $gt_frow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total second row--}}
                        @if($loop->index === 1)
                            @php
                                $gt_srow_jan += $ds->jan;
                                $gt_srow_feb += $ds->feb;
                                $gt_srow_mar += $ds->mar;
                                $gt_srow_apr += $ds->apr;
                                $gt_srow_may += $ds->may;
                                $gt_srow_jun += $ds->jun;
                                $gt_srow_jul += $ds->jul;
                                $gt_srow_aug += $ds->aug;
                                $gt_srow_sep += $ds->sep;
                                $gt_srow_oct += $ds->oct;
                                $gt_srow_nov += $ds->nov;
                                $gt_srow_dec += $ds->dec;
                            @endphp
                        @endif
                        {{--                        grand total second row--}}
                        @if($loop->index === 2)
                            @php
                                $gt_trow_jan += $ds->jan;
                                $gt_trow_feb += $ds->feb;
                                $gt_trow_mar += $ds->mar;
                                $gt_trow_apr += $ds->apr;
                                $gt_trow_may += $ds->may;
                                $gt_trow_jun += $ds->jun;
                                $gt_trow_jul += $ds->jul;
                                $gt_trow_aug += $ds->aug;
                                $gt_trow_sep += $ds->sep;
                                $gt_trow_oct += $ds->oct;
                                $gt_trow_nov += $ds->nov;
                                $gt_trow_dec += $ds->dec;
                            @endphp
                        @endif
                    @empty
                        <tr>
                            <td colspan="15">No Records Found for toll manufacturing</td>
                        </tr>
                    @endforelse
                    {{--                    grand total first row--}}
                    <tr style="background-color: #c6e0b4;font-weight: bold;">
                        <td rowspan="3" style="vertical-align: middle;">Grand Total Sales</td>
                        <td class="text-center">{{$gt_fyear}}</td>
                        <td class="text-right">{{$gt_frow_jan}}</td>
                        <td class="text-right">{{$gt_frow_feb}}</td>
                        <td class="text-right">{{$gt_frow_mar}}</td>
                        <td class="text-right">{{$gt_frow_apr}}</td>
                        <td class="text-right">{{$gt_frow_may}}</td>
                        <td class="text-right">{{$gt_frow_jun}}</td>
                        <td class="text-right">{{$gt_frow_jul}}</td>
                        <td class="text-right">{{$gt_frow_aug}}</td>
                        <td class="text-right">{{$gt_frow_sep}}</td>
                        <td class="text-right">{{$gt_frow_oct}}</td>
                        <td class="text-right">{{$gt_frow_nov}}</td>
                        <td class="text-right">{{$gt_frow_dec}}</td>
                        <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">{{number_format($gt_frow_jan + $gt_frow_feb + $gt_frow_mar +$gt_frow_apr +$gt_frow_may +$gt_frow_jun +
                             $gt_frow_jul +$gt_frow_aug +$gt_frow_sep +
                           $gt_frow_oct +$gt_frow_nov + $gt_frow_dec,2) }}</td>
                    </tr>

                    {{--                    grand total second row--}}
                    <tr style="background-color: #c6e0b4;font-weight: bold;">
{{--                        <td></td>--}}
                        <td class="text-center">{{$gt_syear}}</td>
                        <td class="text-right">{{$gt_srow_jan}}</td>
                        <td class="text-right">{{$gt_srow_feb}}</td>
                        <td class="text-right">{{$gt_srow_mar}}</td>
                        <td class="text-right">{{$gt_srow_apr}}</td>
                        <td class="text-right">{{$gt_srow_may}}</td>
                        <td class="text-right">{{$gt_srow_jun}}</td>
                        <td class="text-right">{{$gt_srow_jul}}</td>
                        <td class="text-right">{{$gt_srow_aug}}</td>
                        <td class="text-right">{{$gt_srow_sep}}</td>
                        <td class="text-right">{{$gt_srow_oct}}</td>
                        <td class="text-right">{{$gt_srow_nov}}</td>
                        <td class="text-right">{{$gt_srow_dec}}</td>
                        <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">{{number_format($gt_srow_jan + $gt_srow_feb + $gt_srow_mar +$gt_srow_apr +$gt_srow_may +$gt_srow_jun +
                             $gt_srow_jul +$gt_srow_aug +$gt_srow_sep +
                           $gt_srow_oct +$gt_srow_nov + $gt_srow_dec,2) }}</td>
                    </tr>

                    {{--                    grand total third row--}}
                    <tr style="background-color: #c6e0b4;font-weight: bold;">
{{--                        <td></td>--}}
                        <td class="text-center">{{$gt_tyear}}</td>
                        <td class="text-right">{{$gt_trow_jan}}</td>
                        <td class="text-right">{{$gt_trow_feb}}</td>
                        <td class="text-right">{{$gt_trow_mar}}</td>
                        <td class="text-right">{{$gt_trow_apr}}</td>
                        <td class="text-right">{{$gt_trow_may}}</td>
                        <td class="text-right">{{$gt_trow_jun}}</td>
                        <td class="text-right">{{$gt_trow_jul}}</td>
                        <td class="text-right">{{$gt_trow_aug}}</td>
                        <td class="text-right">{{$gt_trow_sep}}</td>
                        <td class="text-right">{{$gt_trow_oct}}</td>
                        <td class="text-right">{{$gt_trow_nov}}</td>
                        <td class="text-right">{{$gt_trow_dec}}</td>
                        <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">{{number_format($gt_trow_jan + $gt_trow_feb + $gt_trow_mar +$gt_trow_apr +$gt_trow_may +$gt_trow_jun +
                             $gt_trow_jul +$gt_trow_aug +$gt_trow_sep +
                           $gt_trow_oct +$gt_trow_nov + $gt_trow_dec,2) }}</td>
                    </tr>

                    {{--                    growth rows calculation--}}
                    {{--                    first row--}}
                    @php
                        $gr_fyear = $gt_fyear;
                        if($gt_srow_dec !== 0 && $gt_frow_jan !== 0){
                        $gr_frow_jan = (($gt_frow_jan-$gt_srow_dec)/$gt_srow_dec)*100;
                        }
                        if($gt_frow_jan !== 0 && $gt_frow_feb !== 0){
                        $gr_frow_feb = (($gt_frow_feb-$gt_frow_jan)/$gt_frow_jan)*100;
                        }
                        if($gt_frow_feb !== 0 && $gt_frow_mar !== 0){
                        $gr_frow_mar = (($gt_frow_mar-$gt_frow_feb)/$gt_frow_feb)*100;
                        }
                        if($gt_frow_mar !== 0 && $gt_frow_apr !== 0){
                        $gr_frow_apr = (($gt_frow_apr-$gt_frow_mar)/$gt_frow_mar)*100;
                        }
                        if($gt_frow_apr !== 0 && $gt_frow_may !== 0){
                         $gr_frow_may = (($gt_frow_may-$gt_frow_apr)/$gt_frow_apr)*100;
                        }
                        if($gt_frow_may !== 0 && $gt_frow_jun !== 0){
                        $gr_frow_jun = (($gt_frow_jun-$gt_frow_may)/$gt_frow_may)*100;
                        }
                        if($gt_frow_jun !== 0 && $gt_frow_jul !== 0){
                        $gr_frow_jul = (($gt_frow_jul-$gt_frow_jun)/$gt_frow_jun)*100;
                        }
                        if($gt_frow_jul !== 0 && $gt_frow_aug !== 0){
                        $gr_frow_aug = (($gt_frow_aug-$gt_frow_jul)/$gt_frow_jul)*100;
                        }
                        if($gt_frow_aug !== 0 && $gt_frow_sep !== 0){
                        $gr_frow_sep = (($gt_frow_sep-$gt_frow_aug)/$gt_frow_aug)*100;
                        }
                        if($gt_frow_sep !== 0 && $gt_frow_oct !== 0){
                        $gr_frow_oct = (($gt_frow_oct-$gt_frow_sep)/$gt_frow_sep)*100;
                        }
                        if($gt_frow_oct !== 0 && $gt_frow_nov !== 0){
                        $gr_frow_nov = (($gt_frow_nov-$gt_frow_oct)/$gt_frow_oct)*100;
                        }
                        if($gt_frow_nov !== 0 && $gt_frow_dec !== 0){
                        $gr_frow_dec = (($gt_frow_dec-$gt_frow_nov)/$gt_frow_nov)*100;
                        }

                    @endphp
                    <tr style="background-color: #ffff99;font-weight: bold;">
                        <td>Growth %CY M/M</td>
                        <td class="text-center">{{$gr_fyear}}</td>
                        <td class="text-right"> @if($gr_frow_jan){{number_format($gr_frow_jan,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_feb){{number_format($gr_frow_feb,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_mar){{number_format($gr_frow_mar,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_apr){{number_format($gr_frow_apr,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_may){{number_format($gr_frow_may,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_jun){{number_format($gr_frow_jun,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_jul){{number_format($gr_frow_jul,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_aug){{number_format($gr_frow_aug,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_sep){{number_format($gr_frow_sep,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_oct){{number_format($gr_frow_oct,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_nov){{number_format($gr_frow_nov,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_frow_dec){{number_format($gr_frow_dec,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td></td>
                    </tr>

                    {{--                    second row--}}

                    @php
                        $gr_syear = $gt_syear;
                        if($gt_trow_dec !== 0 && $gt_srow_jan !== 0){
                        $gr_srow_jan = (($gt_srow_jan-$gt_trow_dec)/$gt_trow_dec)*100;
                        }
                        if($gt_srow_jan !== 0 && $gt_srow_feb !== 0){
                        $gr_srow_feb = (($gt_srow_feb-$gt_srow_jan)/$gt_srow_jan)*100;
                        }
                        if($gt_srow_feb !== 0 && $gt_srow_mar !== 0){
                        $gr_srow_mar = (($gt_srow_mar-$gt_srow_feb)/$gt_srow_feb)*100;
                        }
                        if($gt_srow_mar !== 0 && $gt_srow_apr !== 0){
                        $gr_srow_apr = (($gt_srow_apr-$gt_srow_mar)/$gt_srow_mar)*100;
                        }
                        if($gt_srow_apr !== 0 && $gt_srow_may !== 0){
                         $gr_srow_may = (($gt_srow_may-$gt_srow_apr)/$gt_srow_apr)*100;
                        }
                        if($gt_srow_may !== 0 && $gt_srow_jun !== 0){
                        $gr_srow_jun = (($gt_srow_jun-$gt_srow_may)/$gt_srow_may)*100;
                        }
                        if($gt_srow_jun !== 0 && $gt_srow_jul !== 0){
                        $gr_srow_jul = (($gt_srow_jul-$gt_srow_jun)/$gt_srow_jun)*100;
                        }
                        if($gt_srow_jul !== 0 && $gt_srow_aug !== 0){
                        $gr_srow_aug = (($gt_srow_aug-$gt_srow_jul)/$gt_srow_jul)*100;
                        }
                        if($gt_srow_aug !== 0 && $gt_srow_sep !== 0){
                        $gr_srow_sep = (($gt_srow_sep-$gt_srow_aug)/$gt_srow_aug)*100;
                        }
                        if($gt_srow_sep !== 0 && $gt_srow_oct !== 0){
                        $gr_srow_oct = (($gt_srow_oct-$gt_srow_sep)/$gt_srow_sep)*100;
                        }
                        if($gt_srow_oct !== 0 && $gt_srow_nov !== 0){
                        $gr_srow_nov = (($gt_srow_nov-$gt_srow_oct)/$gt_srow_oct)*100;
                        }
                        if($gt_srow_nov !== 0 && $gt_srow_dec !== 0){
                        $gr_srow_dec = (($gt_srow_dec-$gt_srow_nov)/$gt_srow_nov)*100;
                        }

                    @endphp
                    <tr style="background-color: #fce4d6;font-weight: bold;">
                        <td>Growth %CY M/M</td>
                        <td class="text-center">{{$gr_syear}}</td>
                        <td class="text-right"> @if($gr_srow_jan){{number_format($gr_srow_jan,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_feb){{number_format($gr_srow_feb,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_mar){{number_format($gr_srow_mar,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_apr){{number_format($gr_srow_apr,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_may){{number_format($gr_srow_may,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_jun){{number_format($gr_srow_jun,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_jul){{number_format($gr_srow_jul,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_aug){{number_format($gr_srow_aug,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_sep){{number_format($gr_srow_sep,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_oct){{number_format($gr_srow_oct,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_nov){{number_format($gr_srow_nov,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_srow_dec){{number_format($gr_srow_dec,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td></td>
                    </tr>

                    {{--                    third row--}}

                    @php

                        if($gt_frow_jan !== 0 && $gt_srow_jan !== 0){
                        $gr_trow_jan = (($gt_frow_jan-$gt_srow_jan)/$gt_srow_jan)*100;
                        }
                        if($gt_frow_feb !== 0 && $gt_srow_feb !== 0){
                        $gr_trow_feb = (($gt_frow_feb-$gt_srow_feb)/$gt_srow_feb)*100;
                        }
                        if($gt_frow_mar !== 0 && $gt_srow_mar !== 0){
                        $gr_trow_mar = (($gt_frow_mar-$gt_srow_mar)/$gt_srow_mar)*100;
                        }
                        if($gt_frow_apr !== 0 && $gt_srow_apr !== 0){
                        $gr_trow_apr = (($gt_frow_apr-$gt_srow_apr)/$gt_srow_apr)*100;
                        }
                        if($gt_frow_may !== 0 && $gt_srow_may !== 0){
                         $gr_trow_may = (($gt_frow_may-$gt_srow_may)/$gt_srow_may)*100;
                        }
                        if($gt_frow_jun !== 0 && $gt_srow_jun !== 0){
                        $gr_trow_jun = (($gt_frow_jun-$gt_srow_jun)/$gt_srow_jun)*100;
                        }
                        if($gt_frow_jul !== 0 && $gt_srow_jul !== 0){
                        $gr_trow_jul = (($gt_frow_jul-$gt_srow_jul)/$gt_srow_jul)*100;
                        }
                        if($gt_frow_aug !== 0 && $gt_srow_aug !== 0){
                        $gr_trow_aug = (($gt_frow_aug-$gt_srow_aug)/$gt_srow_aug)*100;
                        }
                        if($gt_frow_sep !== 0 && $gt_srow_sep !== 0){
                        $gr_trow_sep = (($gt_frow_sep-$gt_srow_sep)/$gt_srow_sep)*100;
                        }
                        if($gt_frow_oct !== 0 && $gt_srow_oct !== 0){
                        $gr_trow_oct = (($gt_frow_oct-$gt_srow_oct)/$gt_srow_oct)*100;
                        }
                        if($gt_frow_nov !== 0 && $gt_srow_nov !== 0){
                        $gr_trow_nov = (($gt_frow_nov-$gt_srow_nov)/$gt_srow_nov)*100;
                        }
                        if($gt_frow_dec !== 0 && $gt_srow_dec !== 0){
                        $gr_trow_dec = (($gt_frow_dec-$gt_srow_dec)/$gt_srow_dec)*100;
                        }

                    @endphp
                    <tr style="background-color: #ffff99;font-weight: bold;">
                        <td>Growth %CY M /PY M</td>
                        <td></td>
                        <td class="text-right"> @if($gr_trow_jan){{number_format($gr_trow_jan,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_feb){{number_format($gr_trow_feb,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_mar){{number_format($gr_trow_mar,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_apr){{number_format($gr_trow_apr,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_may){{number_format($gr_trow_may,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_jun){{number_format($gr_trow_jun,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_jul){{number_format($gr_trow_jul,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_aug){{number_format($gr_trow_aug,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_sep){{number_format($gr_trow_sep,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_oct){{number_format($gr_trow_oct,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_nov){{number_format($gr_trow_nov,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right"> @if($gr_trow_dec){{number_format($gr_trow_dec,2,'.','')}}
                            % @else {{'0'}} @endif</td>
                        <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">
                            @php
                               $row_sum_first = $gt_frow_jan + $gt_frow_feb + $gt_frow_mar +$gt_frow_apr +$gt_frow_may +$gt_frow_jun +
                                                 $gt_frow_jul +$gt_frow_aug +$gt_frow_sep +
                                                 $gt_frow_oct +$gt_frow_nov + $gt_frow_dec;
                               $row_sum_secnd = $gt_srow_jan + $gt_srow_feb + $gt_srow_mar +$gt_srow_apr +$gt_srow_may +$gt_srow_jun +
                                                 $gt_srow_jul +$gt_srow_aug +$gt_srow_sep +
                                                    $gt_srow_oct +$gt_srow_nov + $gt_srow_dec;

                               $result_gt = (( $row_sum_first - $row_sum_secnd ) / $row_sum_secnd ) * 100;
                            @endphp
                            {{number_format($result_gt,2,'.','')}}%
                        </td>
                    </tr>
{{--                    Company Wise Sales Summary--}}
                    <tr><td colspan="15"></td></tr>
                    <tr>
                        <td colspan="2" style="font-size: 1.5rem;font-weight: bold;background-color: #f4b184;">Company Wise Sales Summary</td>
                        <td colspan="13"></td>
                    </tr>
                    @php
                        $ct_fyear = '';
                        $ct_fdesc = '';
                         $ct_frow_jan = 0;
                         $ct_frow_feb = 0;
                         $ct_frow_mar = 0;
                         $ct_frow_apr = 0;
                         $ct_frow_may = 0;
                         $ct_frow_jun = 0;
                         $ct_frow_jul = 0;
                         $ct_frow_aug = 0;
                         $ct_frow_sep = 0;
                         $ct_frow_oct = 0;
                         $ct_frow_nov = 0;
                         $ct_frow_dec = 0;
                    @endphp
                    @forelse($company as $ds )
                        <tr @if(strtoupper($ds->sales_desc) == strtoupper('Total')) style="background-color: #fce4d6;font-weight: bold;"  @endif>
                            @if(strtoupper($ds->sales_desc) == strtoupper('Total'))
                                <td style="text-align: center;">{{$ds->sales_desc}}</td>
                            @else
                                <td>{{$ds->sales_desc}}</td>
                            @endif
                            @if($loop->index == 0 ||$loop->index == 5||$loop->index == 10)
                                    <td class="text-center" style="vertical-align: middle;" rowspan="4">{{$ds->sales_year}}</td>
                            @elseif(strtoupper($ds->sales_desc) == strtoupper('Total'))
                                    <td class="text-center">{{$ds->sales_year}}</td>
                            @endif

                            <td class="text-right">{{number_format($ds->jan,2)}}</td>
                            <td class="text-right">{{number_format($ds->feb,2)}}</td>
                            <td class="text-right">{{number_format($ds->mar,2)}}</td>
                            <td class="text-right">{{number_format($ds->apr,2)}}</td>
                            <td class="text-right">{{number_format($ds->may,2)}}</td>
                            <td class="text-right">{{number_format($ds->jun,2)}}</td>
                            <td class="text-right">{{number_format($ds->jul,2)}}</td>
                            <td class="text-right">{{number_format($ds->aug,2)}}</td>
                            <td class="text-right">{{number_format($ds->sep,2)}}</td>
                            <td class="text-right">{{number_format($ds->oct,2)}}</td>
                            <td class="text-right">{{number_format($ds->nov,2)}}</td>
                            <td class="text-right">{{number_format($ds->dec,2)}}</td>
                            <td class="text-right" style="background-color: #fce4d6;font-weight: bold;">
                                {{number_format($ds->jan + $ds->feb + $ds->mar +$ds->apr +$ds->may +$ds->jun +$ds->jul +$ds->aug +$ds->sep +
                           $ds->oct +$ds->nov + $ds->dec,2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="15"></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    @include('comp_analysis_of_sales.caos_scripts')
@endsection

