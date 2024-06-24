<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 24/02/2019
 * Time: 9:37 AM
 */
?>
@extends('_layout_shared._master')
@section('title','ELM Dashboard')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>--}}





    <!-- <script src="https://code.highcharts.com/modules/export-data.js"></script> -->

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
    </style>
@endsection
@section('right-content')


    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-8 col-sm-8">
                        <form method="post" action="{{ url('elm_portal\das_date') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2"><b>Select Date</b></label>
                                <div class="col-sm-6 col-md-6">
                                    <input type="text" class="form-control datepicker" name="st_dt"
                                           style="font-size: x-small; padding-right: 0px;" id="date1">
                                </div>
                                <div class="col-sm-3 col-md-3">
                                    <input type="submit" class="btn btn-warning" value="Submit">
                                </div>

                            </div>

                        </form>
                    </div>
                    <div class="col-md-4 col-sm-4">


                           <form >

                               <div class="form-group">
                                   <div class="col-sm-12 col-md-12">
                                   <b style="font-size: larger">  <a> <i class="fa fa-dashboard"></i> </a>{{ $curr_dt }} </b>
                                   </div>
                               </div>

                           </form>




                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row states-info">
                <div class="col-md-3">
                    <div class="panel red-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title"> Total Department </span>
                                    <h4>{{ $dept[0]->total_dept }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel blue-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-group"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Total Employee  </span>
                                    <h4>{{ $tolemps[0]->total_emp }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel green-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Present Employee   </span>
                                    <h4>{{ $pemps[0]->present_emp }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="panel turquoise-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  OSD Employee   </span>
                                    <h4>{{ $emp_osd[0]->osd }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row states-info">


                <div class="col-md-3">
                    <div class="panel yellow-bg">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Absent Employee  </span>
                                    <h4>{{ $absent }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="panel" style="background-color: #d7aeb2">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="col-xs-8">
                                    <span class="state-title">  Leave Employee  </span>
                                    <h4>{{ $lev_emp }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--<div class="row">--}}
        {{--<div class="col-sm-12">--}}
            {{--<section class="panel">--}}

                {{--<div class="col-md-12 col-sm-12">--}}
                    {{--<div class="panel">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="row">--}}
                                {{--<div id="container3"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</section>--}}
        {{--</div>--}}
    {{--</div>--}}


    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Employee Overall percentage
                    <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
                </header>
                <div class="panel-body">

                    <div id="container3"></div>

                </div>
            </section>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Employee Overview
                    <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
                </header>
                <div class="panel-body">

                    <div id="container"></div>

                    <?php

                    if(!empty($barcharData)){


                        $dept_name = array();
                        $pres_emp  = array();
                        $total_emp = array();
                        $emp_osd   = array();
                        $emp_lev   = array();
                        foreach ($barcharData as $key => $value) {


                            $dept_name[]   = $value->dept_name;
                            $pres_emp[]    = $value->present_emp;
                            $absent_emp[]  = $value->absent_emp;
                            $total_emp[]   = $value->total_emp;
                            $emp_osd[]     = $value->emp_osd;
                            $emp_lev[]     = $value->emp_lev;



                            $js_array = json_encode($key);


                        }


//                       $dept_name;
//                       $x3 =  "[{ name : ".implode(',', $dept_name).join(123,$dept_name)." }]";
//                       dd($x3);
//                        exit;


                    }else {

                        $pres_emp[]   = '';
                        $absent_emp[] = '';
                        $total_emp[]  = '';
                        $dept_name[]  = '';
                        $emp_osd[]    = '';
                        $emp_lev[]    = '';
                    }

                    ?>


                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Employee Overview
                    <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
                </header>
                <div class="panel-body">

                    <div id="container4"></div>

                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Employee Overview
                    <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                 </span>
                </header>
                <div class="panel-body">

                    <div id="container2"></div>

                </div>
            </section>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Employee Overview Pie Chart
                    <span class="tools pull-right">
                        <a href="javascript:;" class="fa fa-chevron-down"></a>
                        <a href="javascript:;" class="fa fa-times"></a>
                    </span>
                </header>
                <div class="panel-body">
                    <div id="container5"></div>
                </div>
            </section>
        </div>
    </div> -->

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection



@section('scripts')

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}


    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{Html::script('public/site_resource/js/highcharts/highcharts.js')}}
    {{Html::script('public/site_resource/js/highcharts/exporting.js')}}


    <script type="text/javascript">
        $(window).on('load', function () {
            $('#loader_master').hide();
        })
        $(document).ready(function () {

            $('#date1').datepicker({
                format: "dd-M-yyyy",
                todayHighlight: 'TRUE',
                autoclose: true,
                minDate: 0,
                maxDate: '+1Y+6M'
            });


            var present_array = '';
            var absent_array = '';
            var total_array = '' ;
            var osd_array = '';
            var lev_array = '';


             present_array = new Array(<?php echo implode(',', $pres_emp); ?>);
             absent_array  = new Array(<?php echo implode(',', $absent_emp); ?>);
             total_array   = new Array(<?php echo implode(',', $total_emp); ?>);
             osd_array     = new Array(<?php echo implode(',', $emp_osd); ?>);
             lev_array     = new Array(<?php echo implode(',', $emp_lev); ?>);

            Highcharts.chart('container', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                // subtitle: {
                //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
                // },
                xAxis: {

                    categories: ['<?php echo join($dept_name, "', '") ?>'],
                    // categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'People',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' People'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [
                    {  name: 'PRESENT',  data: present_array, color: 'green' },
                    {  name: 'ABSENT',   data: absent_array ,  color: 'red'},
                    {  name: 'TOTAL',    data: total_array, color: 'black' },
                    {  name: 'OSD',      data: osd_array, color: 'orange' },
                    {  name: 'LEAVE',      data: lev_array, color: 'yellow' }
                ]
            });
            Highcharts.chart('container2', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: ''
                },
                // subtitle: {
                //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
                // },
                xAxis: {

                    categories: ['<?php echo join($dept_name, "', '") ?>'],
                    // categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'People',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                    valueSuffix: ' People'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                    shadow: true
                },
                credits: {
                    enabled: false
                },
                series: [
                    {  name: 'PRESENT',  data: present_array, color: 'green' },
                    {  name: 'ABSENT',   data: absent_array,  color: 'red' },
                    {  name: 'TOTAL',    data: total_array, color: 'black' },
                    {  name: 'OSD',      data: osd_array, color: 'orange' },
                    {  name: 'LEAVE',      data: lev_array, color: 'yellow' }
                ]
            });

            Highcharts.chart('container3', {
                chart: {
                    type: 'area'
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    // categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
                    categories: ['<?php echo join($dept_name, "', '") ?>'],
                    tickmarkPlacement: 'on',
                    title: {
                        enabled: false
                    }
                },
                yAxis: {
                    title: {
                        text: 'Percent'
                    }
                },
                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.percentage:.1f}%</b> ({point.y:,.0f} People)<br/>',
                    split: true
                },
                plotOptions: {
                    area: {
                        stacking: 'percent',
                        lineColor: '#ffffff',
                        lineWidth: 1,
                        marker: {
                            lineWidth: 1,
                            lineColor: '#ffffff'
                        }
                    }
                },

                series: [
                    // {  name: 'TOTAL',    data: total_array },
                    {  name: 'PRESENT',  data: present_array, color: 'green' },
                    {  name: 'ABSENT',   data: absent_array,  color: 'red' },
                    {  name: 'OSD',      data: osd_array, color: 'orange' },
                    {  name: 'LEAVE',    data: lev_array, color: 'yellow' }
                ]
            });

            Highcharts.chart('container4', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                // subtitle: {
                //     text: 'Source: WorldClimate.com'
                // },
                xAxis: {

                categories: ['<?php echo join($dept_name, "', '") ?>'],
                // categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                title: {
                    text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'People',
                        align: 'high'
                    },
                    labels: {
                        overflow: 'justify'
                    }
                },
                tooltip: {
                        valueSuffix: ' People'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                        shadow: true
                    },
                    credits: {
                        enabled: false
                    },


                    series: [
                            // {  name: 'TOTAL',    data: total_array },
                            {  name: 'PRESENT',  data: present_array, color: 'green' },
                            {  name: 'ABSENT',   data: absent_array, color: 'red' },
                            {  name: 'OSD',      data: osd_array, color: 'orange' },
                            {  name: 'LEAVE',    data: lev_array, color: 'yellow' }
                        ]
            });

            //  Highcharts.chart('container5', {
            //     chart: {
            //         plotBackgroundColor: null,
            //         plotBorderWidth: null,
            //         plotShadow: false,
            //         type: 'pie'
            //     },
            //     title: {
            //         text: ''
            //     },
            //     tooltip: {
            //         pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            //     },
            //     accessibility: {
            //         point: {
            //             valueSuffix: '%'
            //         }
            //     },
            //     plotOptions: {
            //         pie: {
            //             allowPointSelect: true,
            //             cursor: 'pointer',
            //             dataLabels: {
            //                 enabled: true,
            //                 format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            //             }
            //         }
            //     },
            //     series: [{
            //         name: 'Employee Overview',
            //         colorByPoint: true,
            //         data: [{
            //             name: 'Present',
            //             y: <?php echo $totalPresentP;?>,
            //             sliced: true,
            //             selected: true
            //         }, {
            //             name: 'OSD',
            //             y: <?php echo $totalOsdP;?>
            //         }, {
            //             name: 'Absent',
            //             y: <?php echo $totalAbsentP;?>
            //         }, {
            //             name: 'Leave',
            //             y: <?php echo $totalLeaveP;?>
            //         }]
            //     }]
            // });    

        });
    </script>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection