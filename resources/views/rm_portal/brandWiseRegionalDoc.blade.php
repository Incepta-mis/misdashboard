@extends('_layout_shared._master')
@section('title','Brand Wise Regional Doctors')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>



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


        #overlay{
            position:fixed;
            z-index:99999;
            top:0;
            left:0;
            bottom:0;
            right:0;
            background:rgba(0,0,0,0.9);
            transition: 1s 0.4s;
        }
        #progress{
            height:1px;
            background:#fff;
            position:absolute;
            width:0;
            top:50%;
        }
        #progstat{
            font-size:0.7em;
            letter-spacing: 3px;
            position:absolute;
            top:50%;
            margin-top:-40px;
            width:100%;
            text-align:center;
            color:#fff;
        }



    </style>
@endsection

@section('right-content')

    <div id="overlay">
        <div id="progstat"></div>
        <div id="progress"></div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Brand Wise Regional Doctors
                    </label>
                </header>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <form action="" class="form-horizontal" role="form">
                                    @if(Auth::user()->desig === 'GM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
                                    Auth::user()->desig === 'DSM' || Auth::user()->desig === 'All'||
                                    Auth::user()->desig === 'HO')

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm">
                                                            <option value="">Select RM Territory</option>
                                                            <!-- <option value="All">All</option> -->
                                                            @foreach($rm_terr as $terr)
                                                                <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand Name:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="bnd_name" id="bnd_name"
                                                                class="form-control input-sm">
                                                            <option value="">Select Brand</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(Auth::user()->desig === 'RM'||  Auth::user()->desig === 'ASM')
                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Region Terr
                                                            Id:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="rm_terr" id="rm_terr"
                                                                class="form-control input-sm" disabled>
                                                            @foreach($rm_terr as $terr)
                                                                <option value="{{$terr->rm_terr_id}}">{{$terr->rm_terr_id}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="rm_terr"
                                                           class="col-md-6 col-sm-6 control-label"><b>Brand Name:</b></label>
                                                    <div class="col-md-6">
                                                        <select name="bnd_name" id="bnd_name"
                                                                class="form-control input-sm">
                                                            <option value="">Select Brand</option>
                                                            @foreach($brand_name as $brands)
                                                                <option value="{{$brands->brand_name}}">{{$brands->brand_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                    <i class="fa fa-check"></i> <b>Display Report</b></button>
                                            </div>
                                            <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                                                <div id="export_buttons">

                                                </div>
                                            </div>
                                        </div>
                                    @endif






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


    <div class="col-md-12 col-sm-12" id="loader_submit" style="display: none; margin-top: 5px;">
        <div class="col-md-6 col-sm-6 col-md-offset-3 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/processing.gif')}}"
                     alt="Loading Report Please wait..."><br>
            </div>
        </div>
    </div>



    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table id="doc_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>TERR_ID</th>
                                    <th>DOCTOR_ID</th>
                                    <th>DOCTOR_NAME</th>
                                    <th>ADDRESS</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                {{--<tr>--}}
                                    {{--<td style="text-align: right;">Total</td>--}}
                                    {{--<td></td>--}}
                                    {{--<td></td>--}}
                                {{--</tr>--}}
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </section>
            </div>
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

    {{Html::script('public/site_resource/js/rm_portal_scripts/brandWiseRegDocList_script.js')}}



    <script type="text/javascript">
        servloc_bnd = "{{url('rm_portal/getBrands')}}";
        servloc_data = "{{url('rm_portal/bwrdoclist')}}";

        eid = "{{Auth::user()->user_id}}";
        desig = "{{Auth::user()->desig}}";


        (function(){
            function id(v){return document.getElementById(v); }
            function loadbar() {
                var ovrl = id("overlay"),
                    prog = id("progress"),
                    stat = id("progstat"),
                    img = document.images,
                    c = 0;
                tot = img.length;

                function imgLoaded(){
                    c += 1;
                    var perc = ((100/tot*c) << 0) +"%";
                    prog.style.width = perc;
                    stat.innerHTML = "Loading "+ perc;
                    if(c===tot) return doneLoading();
                }
                function doneLoading(){
                    ovrl.style.opacity = 0;
                    setTimeout(function(){
                        ovrl.style.display = "none";
                    }, 1200);
                }
                for(var i=0; i<tot; i++) {
                    var tImg     = new Image();
                    tImg.onload  = imgLoaded;
                    tImg.onerror = imgLoaded;
                    tImg.src     = img[i].src;
                }
            }
            document.addEventListener('DOMContentLoaded', loadbar, false);
        }());

    </script>


@endsection