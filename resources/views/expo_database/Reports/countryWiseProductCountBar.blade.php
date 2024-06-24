<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 24/02/2019
 * Time: 9:37 AM
 */
?>
@extends('_layout_shared._master')
@section('title','Bar Chart - Country Wise Product')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        /*.panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }*/

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        input[type=file]::-webkit-file-upload-button {
            width: 0;
            padding: 0;
            margin: 0;
            -webkit-appearance: none;
            border: none;
            border: 0px;
        }

        x::-webkit-file-upload-button, input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        body {
            color: #000;
        }

        .permittedColor{
            color: #0eb66a;
        }

		.odd{
			background-color: #FFF8FB !important;
		}
		.even{
			background-color: #DDEBF8 !important;
		}


    </style>
@endsection
@section('right-content')

    <div class="row">

        <div class="col-md-4 col-md-offset-2">
            <div class="panel" style="background-color: #C39BD3">
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-truck"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Export Country  </span>
                            <h4 style="color: whitesmoke">{{ $noOfCountry[0]->no_of_country }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel " style="background-color: #4F9FCF">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="col-xs-8">
                            <span class="state-title" style="color: whitesmoke">  Total Number of Brand  </span>
                            <h4 style="color: whitesmoke">{{ $noOfBrand[0]->brand_name }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">



            <div class="row states-info">
                <div class="col-md-12">
{{--                    {{ dd($cstatus) }}--}}
                    @foreach($cstatus as $st)
                        <div @if($loop->index == 0) class="col-md-2" @else class="col-md-2" @endif >
                            <div  @if($st->current_status == 'Registered') class="panel blue-bg"
                                  @elseif($st->current_status == 'In-Process')  class="panel green-bg"
                                  @elseif($st->current_status == 'Permitted')  class="panel turquoise-bg"
                                  @elseif($st->current_status == 'Dropped')  class="panel yellow-bg"
                                  @elseif($st->current_status == 'Rejected')  class="panel red-bg"
                                  @elseif($st->current_status == 'Withdrawl')  class="panel turquoise-bg"
                                  @endif>
                                <div class="panel-body">
                                    <div class="row">
                                        @if($st->current_status == 'Registered')
                                            <div class="col-xs-4">
                                                <i class="fa fa-pencil"></i>
                                            </div>

                                            <div class="col-xs-8">
                                                <span class="state-title"> Registered </span>
                                                <h4><span> {{ $st->status }} </span></h4>
                                            </div>
                                        @elseif($st->current_status == 'Permitted')
                                            <div class="col-xs-4">
                                                <i class="fa fa-check-circle"></i>
                                            </div>

                                            <div class="col-xs-8">
                                                <span class="state-title"> Permitted </span>
                                                <h4><span> {{ $st->status }} </span></h4>
                                            </div>
                                        @elseif($st->current_status == 'In-Process')
                                            <div class="col-xs-4">
                                                <i class="fa fa-tag"></i>
                                            </div>

                                            <div class="col-xs-8">
                                                <span class="state-title"> In-Process </span>
                                                <h4><span> {{ $st->status }} </span></h4>
                                            </div>

                                        @elseif($st->current_status == 'Dropped')
                                            <div class="col-xs-4">
                                                <i class="fa fa-trash-o"></i>
                                            </div>

                                            <div class="col-xs-8">
                                                <span class="state-title"> Dropped </span>
                                                <h4><span> {{ $st->status }} </span></h4>
                                            </div>
                                        @elseif($st->current_status == 'Rejected')
                                            <div class="col-xs-4">
                                                <i class="fa fa-trello"></i>
                                            </div>

                                            <div class="col-xs-8">
                                                <span class="state-title"> Rejected </span>
                                                <h4><span> {{ $st->status }} </span></h4>
                                            </div>
                                        @elseif($st->current_status == 'Withdrawl')
                                            <div class="col-xs-4">
                                                <i class="fa fa-external-link-square"></i>
                                            </div>

                                            <div class="col-xs-8">
                                                <span class="state-title"> Withdrawl </span>
                                                <h4><span> {{ $st->status }} </span></h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>



    </div>


    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">

                {{-- <section class="error-wrapper text-center"> --}}
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                        {{-- <p class="highcharts-description">
                            Chart showing use of rotated axis labels and data labels. This can be a
                        </p> --}}
                        <?php

                            if(!empty($rs)){
                                $countryName = array();
                                $countryProd = array();
                                foreach ($rs as $key => $value) {
                                    $countryName[]   = $value->export_country;
                                    $countryProd[]   = '['.$value->no_prod.']';
                                }

                                // Log::info($countryProd);
                            }


                        ?>

                    </figure>
                {{-- </section> --}}
        </div>


    </div>


@endsection
@section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection



@section('scripts')


{{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
{{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}

{{Html::script('public/site_resource/js/highcharts/highcharts.js')}}
{{Html::script('public/site_resource/js/highcharts/exporting.js')}}

<script type="text/javascript">


        var  noOfProduct = new Array( <?php echo implode(',', $countryProd) ; ?> );

        /*Highcharts.chart('container', {
            chart: {
                type: 'spline',
                scrollablePlotArea: {
                    minWidth: 900,
                    scrollPositionX: 1
                }
            },
            title: {
                text: 'Country Wise Product'
            },
            subtitle: {
                text: 'Export Information'
            },
            legend: {
                enabled: false,
            },
            xAxis: {
                categories: ['<?php echo join($countryName, "', '") ?>'],
                labels: {
                    overflow: 'justify'
                },
                type: 'category',
                // allowDecimals: false,
                // labels: {
                //     step: 1
                // }
            },
            yAxis: {
                tickWidth: 1,
                title: {
                    text: 'Number of Product'
                },
                lineWidth: 1,
                opposite: true,
            },
            credits: {
                 enabled: false
            },
            tooltip: {
                pointFormat: 'Export: <b>{point.y:f} product</b>',
                split: true
            },
            legend: {
                verticalAlign: 'top',
                align: 'right'
            },
            scrollbar: {
                enabled: true
            },
            series: [{
                    name: 'Country',
                    data: noOfProduct,
            }]
        });*/

        /*Highcharts.chart('container', {
            chart: {
                type: 'column',
            },
            title: {
                text: 'Country Wise Product'
            },
            subtitle: {
                text: 'Export Information'
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: ['<?php echo join($countryName, "', '") ?>'],
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of Product'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Export: <b>{point.y:f} product</b>',
            },
            series: [{
                name: 'Country',
                data: noOfProduct,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });*/

        // Create the chart
        Highcharts.chart('container', {
            chart: {
                 height: 700,
                type: 'column',
                scrollablePlotArea: {
                    minWidth: 700,
                    scrollPositionX: 1
                }
            },
            title: {
                text: 'Country Wise Product'
            },
            subtitle: {
                text: 'Export Information'
            },
            credits: {
                enabled: false
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                categories: ['<?php echo join($countryName, "', '") ?>'],
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '9px',
                    },

                },
                scrollbar: {
                    enabled: true
                },
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of Brand'
                },
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:f}'
                    }
                }
            },

            tooltip: {
                // headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}%</b> of total<br/>'
                pointFormat: 'Export: <b>{point.y:f} product</b>',
            },

            series: [
                {
                    name: "Country",
                    colorByPoint: true,
                    data: noOfProduct,
                }
            ],
            drilldown: {
                series: [
                    {
                        name: ['<?php echo join($countryName, "', '") ?>'],
                        id: ['<?php echo join($countryName, "', '") ?>'],
                        data: noOfProduct,
                    }
                ]
            }
        });
</script>


@endsection
@section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection