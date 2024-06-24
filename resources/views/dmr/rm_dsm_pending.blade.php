@extends('_layout_shared._master')
@section('title','M DSM Pending ')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

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
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        RM DSM Pending
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">

                                    <div class="row">


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="bgt_month"
                                                       class="col-md-4 col-sm-6 control-label"><b>Month</b></label>
                                                <div class="col-md-8">
                                                    <select name="bgt_month" id="bgt_month"
                                                            class="form-control input-sm">
                                                        <option value="">Select</option>
                                                        @foreach($month_name as $mn)
                                                            <option value="{{$mn->monthname}}">{{$mn->monthname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2">

                                            <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                <i class="fa fa-check"></i> <b>Display</b></button>

                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">
        <div class="col-sm-12 col-md-12">
                <section class ="panel" id="data_table">
                    <div class = "panel-body">
                        <div class="table-responsive">

                            <div class="col-sm-6 col-md-6">
                            <table id="rm_pending" class="table table-condensed table-striped table-bordered" width="100%">
                                <thead style="white-space:nowrap;">
                                <tr style="border: 1px solid #000000;text-align: center;">
                                    <th>RM_TERR_ID</th>
                                    <th>PENDING</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            </div>

                            <div class="col-sm-6 col-md-6">
                            <table id="dsm_pending" class="table table-condensed table-striped table-bordered" width="100%">
                                <thead style="white-space:nowrap;">
                                <tr style="border: 1px solid #000000;text-align: center;">
                                    <th>DSM_TERR_ID</th>
                                    <th>PENDING</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            </div>

                        </div>
                    </div>
                </section>
            </div>

    </div>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{-- Added for selecting all on click--}}

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}

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


    <script type="text/javascript">
        $(document).ready(function () {

                let rm_dsm_pending_data = "{{url('dmr/rm_dsm_pending_data')}}";
                _csrf_token = '{{csrf_token()}}';
                var table;


            $("#btn_display").click(function () {

                // if ($("#bgt_year").val() === "") {
                //     alert("Please select Program Year");
                // }

                    if ($("#bgt_month").val() === "") {
                    alert("Please select Program Month");
                }


                else {

                    let month = $("#bgt_month").val();

                    $("#loader").show();
                    $.ajax({
                        method: 'post',
                        url: rm_dsm_pending_data,
                        data: {
                            month: month,
                            _token: _csrf_token,
                        },
                        success: function (data) {
                            console.log(data);
                            // console.log(data['resp']);

                            $('#rm_pending').DataTable().destroy();
                            $('#dsm_pending').DataTable().destroy();

                            let table = $('#rm_pending').DataTable({
                                data: data['rm'],

                                columns: [

                                    {data: "rm_terr_id"},
                                    {data: "total"},


                                ],
                                paging:false,
                                filtering:false,
                                searching:false,
                                info:false

                            });
                            let table2 = $('#dsm_pending').DataTable({
                                data: data['dsm'],

                                columns: [

                                    {data: "rm_terr_id"},
                                    {data: "total"},


                                ],
                                paging:false,
                                filtering:false,
                                searching:false,
                                info:false

                            });


                            $("#loader").hide();

                            $("#report-body").show();
                            table.columns.adjust();
                            table2.columns.adjust();
                        },
                        error: function () {
                            $("#loader").hide();
                            console.log('fail');
                        }

                    });

                }

            });



            }
        );



    </script>

@endsection