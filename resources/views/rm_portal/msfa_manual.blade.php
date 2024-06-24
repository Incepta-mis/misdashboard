@extends('_layout_shared._master')
@section('title','Region Wise Terr List')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"
          type="text/css"/>
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


        .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            width: 100%;
            padding-bottom: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.5);
        }
    </style>
@endsection


@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        MSFA Manual
                    </label>
                </header>
                <div class="panel-body">

                    <div class="row" style="padding: 20px">

                        <div class="col-md-6 col-sm-6 col-lg-6" style="border: 1px solid lightblue;padding:20px">

                            <div style="" class="card">

                                <img src="{{url('public/msfa_manual/msfa_manual_one.jpg')}}"  style="width: 90%;height: 90%">
                                <div style="text-align: center">
                                    <a href="{{url('public/msfa_manual/msfa_manual_one.jpg')}}" id="dis_issue_image_url" target="_blank" style=" text-decoration: underline">View Full Image</a>
                                </div>

                            </div>

                        </div>


                        <div class="col-md-6 col-sm-6 col-lg-6" style="border: 1px solid lightblue;padding:20px">

                            <div style="" class="card">

                                <img src="{{url('public/msfa_manual/msfa_manual_two.jpg')}}"  style="width: 90%;height: 90%">
                                <div style="text-align: center">
                                    <a href="{{url('public/msfa_manual/msfa_manual_two.jpg')}}" id="dis_issue_image_url" target="_blank" style=" text-decoration: underline">View Full Image</a>
                                </div>

                            </div>

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

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/rm_portal_scripts/rmp_script.js')}}

    <script type="text/javascript">
        servloc = "{{url('rm_portal/regwTerrList')}}";
        servloc_t = "{{url('rm_portal/regwTerrListGmRm')}}";
        servloc_nm = "{{url('rm_portal/regwTerrListSmRmNameId')}}";
        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";

    </script>

@endsection