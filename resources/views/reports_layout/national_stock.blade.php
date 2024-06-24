@extends('_layout_shared._master')
@section('title','National Stock')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
{{--    {{Html::style('site_resource/css/dataTables.bootstrap.min.css')}}--}}
{{--    {{Html::style('site_resource/css/fixedColumns.bootstrap.min.css')}}--}}
{{--    {{Html::style('site_resource/css/buttons.bootstrap.min.css')}}--}}
    <style>
        th {
            white-space: nowrap;
            overflow: hidden;
            color: #003399;
            font-size: 11px;
        }

        td {
            white-space: nowrap;
            overflow: hidden;
            color: #0c0c0c;
            font-size: 11px;
        }

        header.panel-heading {
            color: #003399;
        }

        .dataTables_filter {
            display: none;
        }

        .dt-buttons {
            float: right;
        }
    </style>
@endsection
@section('top-nav-items')
    <div>
        <label class="col-sm-1 " style="margin-top: 16px;margin-bottom: 0px;width: 7.5%;">Company</label>
        <div class="form-group col-sm-2" style="margin-top: 8px;margin-bottom: 0px;">
            <select class="form-control" id="c_code" onchange="query_data(url,i_url)">
                <option value="All">All</option>
                @foreach($company as $cmp)
                    <option value="{{$cmp->ccode}}">{{$cmp->company}}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div>
        <label class="col-sm-1 " style="margin-top: 16px;margin-bottom: 0px;width: 7.5%;">P_Group</label>
        <div class="form-group col-sm-2" style="margin-top: 8px;margin-bottom: 0px;">
            <select class="form-control" id="pgroup" onchange="query_data(url,i_url)">
                <option value="All">All</option>
                @foreach($pgroup as $pgp)
                    <option value="{{$pgp->p_group}}">{{$pgp->p_group}}</option>
                @endforeach
            </select>
        </div>

    </div>
@endsection
@section('right-content')
    <div class="row">

        <div class="col-sm-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label style="float: left;width: 28.3%">National Stock</label>
                    <div id="customButton" style="width: 22.7%;float: right;"></div>
                    <br>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <!-- <div id="tableOne"> -->
                        <table id="stock_tab" class="display table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>SAP Code</th>
                                <th>P_CODE</th>
                                <th>Name</th>
                                <th>Pack Size</th>
                                <th>DHK</th>
                                <th>COM</th>
                                <th>CTG</th>
                                <th>SYL</th>
                                <th>BSL</th>
                                <th>KHL</th>
                                <th>RAJ</th>
                                <th>MAG</th>
                                <th>BOG</th>
                                <th>RAN</th>
                                <th>MYM</th>
                                <th>NOA</th>
                                <th>COX</th>
                                <th>NAR</th>
                                <th>TNG</th>
                                <th>JSR</th>
                                <th>MOU</th>
                                <th>DNP</th>
                                <th>FNI</th>
                                <th>BBR</th>
                                <th>PAB</th>
                                <th>CWH</th>
                                <th>FAC</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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

    <script src="{{url('public/site_resource/js/jquery.dataTables.min.js')}}"></script>
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/custom/script_nat_stock.js')}}


    <script>
        var url = "{{url('drep/resp_nat_stock')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table(url,i_url,$('#c_code').val(), $('#pgroup').val());
    </script>

@endsection