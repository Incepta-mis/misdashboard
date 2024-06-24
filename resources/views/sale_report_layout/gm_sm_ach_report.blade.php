@extends('_layout_shared._master')
@section('title','GM & SM Achievement%')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

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
        .table>tfoot>tr>td{
            background-color: #d9edf7;
        }
        .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td {
            padding: 5px;
        }
        .depot_sales_class{
            background-color: #EEECE1;
        }
        .export_st_total_class{
            background-color: #EEECE1;
        }
        .inst_total_class{
            background-color: #D8E4BC;
        }
        .export_total_class{
            background-color: #DCE6F1;
        }
        .toll_class{
            background-color: #DAEEF3;
        }
        .total_sale_class{
            background-color: #B7DEE8;
        }
        .smname{
            width: 4%;
        }

        .smtarget_value{
            width: 4%;
        }

        .smsales_value{
            width: 4%;
        }


        .smachievement{
            width: 2%;
        }

        .gmname{
            width: 4%;
        }

        .gmtarget_value{
            width: 4%;
        }

        .gmsales_value{
            width: 4%;
        }


        .gmachievement{
            width: 2%;
        }
        /*.dtable3>thead>tr>th>.firstth{
            width: 52px;
        }*/
        table #dtable3 thead {
            display:table;
            width: 60%;
            background-color: lightblue;
            position: fixed;
        }
        table#dtable3{
            /*table-layout:fixed;*/
            margin-bottom: -7px;

        }
        /*table#dtable1{
          table-layout:fixed;
          margin-bottom: -7px;

        }*/
        /*table #dtable3 thead .nameth{

           width: 4%;
        }*/
        .sales_person_clss{
            font-weight: bold;
            background-color: #c1e5ea;
        }
        .remarkclss{
            text-align: center;
        }
        .achclss{
            text-align: center;
        }

    </style>
@endsection
@section('top-nav-items')
    <div>


    </div>
    <div>


    </div>
@endsection
@section('right-content')
    <div class="row">

        <div class="col-sm-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label style="float:left;width:70.0%">Sales achievement analysis (Cumulative)
                        &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp Figures in <span style="color:green">Crore</span>&nbsp&nbsp &nbsp  &nbsp &nbsp<span style="color:blue">BDT</span></label>

                    <br>
                </header>
                <div class="panel-body">
                    <div class="adv-table">


                        <table id="sm_gm_dsm_table" class="display table table-bordered table-striped table-responsive" style="width:80%">
                            <thead>


                            <tr>
                                <th style="background-color: #FCD5B4"></th>
                                <th style="background-color:rgb(204, 192, 218)">Name</th>
                                <th style="background-color:#D8E4BC"><center>Total TGT_Value <br> <span style="color:green">Upto Current Month</span></center></th>
                                <th style="background-color:#fcd5b4;"><center>Total Sales<br> <span style="color:green">Upto Current Month</span></center></th>
                                <th style="background-color:rgb(204, 192, 218)"><center>Ach%</center></th>
                                <th style="background-color:rgb(216, 218, 109)"><center>Remark</center></th>

                            </tr>

                            {{--<th class="nameth" style="background-color:#fcd5b4;width:27%">Name</th>--}}


                            </thead>
                            <tbody>
                            </tbody>
                            {{--<tfoot>--}}
                            {{--<tr>--}}
                                {{--<th style="background-color: #CCFFCC;" >Grand Total</th>--}}
                                {{--<th style="background-color: #CCFFCC"></th>--}}
                                {{--<th style="background-color: #CCFFCC"></th>--}}
                                {{--<th style="background-color: #CCFFCC"></th>--}}
                                {{--<th style="background-color: #CCFFCC"></th>--}}
                                {{--<th style="background-color: #CCFFCC"></th>--}}

                            {{--</tr>--}}
                            {{--</tfoot>--}}
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
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}


    {{Html::script('public/site_resource/js/custom/script_dsm_gm_sm_wise_ach.js')}}


    

    <script>
        var dsm_wise_url = "{{url('srep/resp_dsm_gm_sm_wise_ach')}}";
        var dsm_wise_i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table_sm_dsm_gm_ach(dsm_wise_url,dsm_wise_i_url);

    </script>


@endsection