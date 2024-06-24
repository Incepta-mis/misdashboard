@extends('_layout_shared._master')
@section('title','Recruitment Management System')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 4px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 4px;
            font-size: 11px;
        }

        body {
            color: #000;
        }

        .btn-primary {
            margin-right: 10px;
        }

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/
            /*font-weight: bold;*/

        }

        .s_font {
            font-size: 11px;
            padding: 7px 0;
        }

        .form-group {
            margin-bottom: 0;
        }



    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Department Wise Status (Graphical Presentation)
                    </label>
                </header>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form method="post" class="form-horizontal" role="form"
                          action="">
                        {{csrf_field()}}
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12" style="height: 30px">
                                <div class="row">
                                    <div class="col-md-4" style="padding: 0 5px; margin: 0 0 20px 0;">
                                        <div class="form-group">
                                            <label for="plant_name"
                                                   class="col-md-4 col-sm-6 control-label s_font"><b>Plant
                                                    Name</b></label>
                                            <div class="col-md-8" id="plant_option">
                                                <select name="plant_name"
                                                        id="plant_name"
                                                        class="form-control input-sm"
                                                        style="font-size: 10px; height: 26px; padding: 0;">
                                                    <option value="" selected disabled>Select</option>
                                                    {{--                                                    <option value="ALL">ALL</option>--}}
                                                    @foreach($plant_name as $pn)
                                                        <option value="{{$pn->plant_id}}">{{$pn->plant_name}}
                                                            | {{$pn->plant_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-md-8" style="padding: 0 10px;">
                                        <div style="height: 100%; width: 15%">
                                            <button type="button" id="display_data_vacant_status"
                                                    class="btn btn-default btn-sm"
                                                    style="width: 100%; margin: auto;">
                                                <i class="fa fa-check" aria-hidden="true"></i><b>Display</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <section class="panel" id="graph_table">
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form method="post" class="form-horizontal" role="form"
                          action="{{url('')}}">
                        {{csrf_field()}}
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 0">
                                        <section class="panel">
                                            <div class="panel-body" style="padding: 0">
                                                <div id="container"></div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    {{--This code area is for showing loader image ends here--}}
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/highcharts/highcharts.js')}}
    {{Html::script('public/site_resource/js/highcharts/exporting.js')}}



    <script type="text/javascript">

        $(document).ready(function () {

            //select 2 start
            function customMatcher(term, text) {
                term.term = term.term || '';
                if (text.text.toUpperCase().includes(term.term.toUpperCase())) {
                    return text;
                }
                return false;
            }

            $('#plant_name').select2({
                matcher: function (term, text) {
                    return customMatcher(term, text);
                }
            });

            function chart(cata, series, row_num) {

                Highcharts.chart('container', {

                    chart: {
                        type: 'column',
                         height: '50%'
                    },
                    title: {
                        text: 'Employee Status Overview'
                    },
                    // subtitle: {
                    //     text: ''
                    // },
                    xAxis: {
                        // categories: ['Engineering', 'Legal Affairs', 'Finance And Accounts', 'Information Technology'],
                        categories: cata,
                        title: {
                            text: 'Departments'
                        },
                        labels: {
                            rotation: -45
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Employees'
                        },
                        labels: {
                            overflow: 'justify',
                        }
                    },
                    tooltip: {
                        valueSuffix: ' '
                    },
                    plotOptions: {
                        column: {
                            dataLabels: {
                                enabled: true
                            }
                        }
                    },
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'top',
                        x: 10,
                        y: 0,
                        floating: false,
                        borderWidth: 1,
                        backgroundColor:
                            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                        shadow: true
                    },
                    credits: {
                        enabled: false
                    },
                    series: series
                });
                // chart.setSize("100%", "100%", true);
            }

            $("#display_data_vacant_status").on('click', function () {
                //chart
                console.log($("#plant_name").val());

                $.ajax({
                    type: "post",
                    datatype: 'json',
                    url: '{{url('rms/report/get_dept_name')}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        plant_id: $("#plant_name").val()
                    },
                    success: function (response) {
                        console.log(response);
                        var categories = [];
                        for (let i = 0; i < response.get_dept_name.length; i++) {
                            categories.push(response.get_dept_name[i].dept_name);
                        }
                        console.log(categories);
                        console.log(response.series);

                        var row_num = " ";

                        if(response.get_dept_name.length < 10){
                            row_num = "30%"
                        }else{
                            row_num = "100%"
                        }

                        chart(categories, response.series, row_num)
                    }
                })


            })
        });

    </script>

@endsection