@extends('_layout_shared._master')
@section('title','History Company Base')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> -->

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

        tfoot{
            font-weight:bold;
        }


        .ipl_sales_class{
            background-color:#FCD5B4;
            text-align: right;
        }
        .ivl_sales_class{
            background-color:#B7DEE8;
            text-align: right;
        }
        .ihhl_sales_class{
            background-color:#E6B8B7;
            text-align: right;
        }
        .ihnl_sales_class{
            background-color:#D8E4BC;
            text-align: right;
        }
        .tot_sales_class{
            background-color:#CCC0DA;
            font-weight: bold;
            text-align: right;
        }

        .right_align_class{
            text-align: right;
        }

        table.dataTable.table-condensed > thead > tr > th {
            padding: 5px;
        }

        .depot_clss{
            background-color:rgb(216, 228, 188);
            text-align: right;
        }
        .inst_clss{
            background-color:rgb(234, 200, 173);
            text-align: right;
        }
        .expot_clss{
            background-color:rgb(183, 222, 232);
            text-align: right;
        }


        .ser_expot_clss{
            background-color:rgb(241, 238, 164);
            text-align: right;
        }
        .toll_mfg{
            background-color:rgb(230, 184, 183);
            text-align: right;
        }
        .hospi_clss{
            background-color:rgb(204, 192, 218);
            text-align: right;
        }
        .all_com_clss{
            background-color:rosybrown;
            font-weight: bold;
            text-align: right;
        }

        .team_total_class{
            background-color: rgb(223, 240, 219);
            font-weight: bold;
            text-align: right;
        }
        .saleyrclss{
            background-color:#8db4e2;
        }

        .dataTable tr.odd td.sorting_1, .dataTable tr.even.gradeA td.sorting_1 {
            background-color:#8db4e2;
        }



        tr.even td.sorting_1, table.display tr.even.gradeC, table.display tr.gradeC, tr.odd.gradeC td.sorting_1, table.display tr.even.gradeU, table.display tr.gradeU, tr.odd.gradeU td.sorting_1 {
            background-color:#8db4e2 !important;
        }

        @media(max-width:767px) {
            .lagerme{
                display:none;
                /*display:initial;*/
            }

            .mobileme{
                display:initial;
                /*display:initial;*/
            }
        }

        @media(min-width:767px) {
            .lagerme{
                /*display:none;*/
                display:initial;
            }

            .mobileme{
                display:none;
                /*display:initial;*/
            }
        }

        .inter_sales_class{
            background-color:#f9edb4;
            text-align: right;
        }

        .net_sales_class{
            background-color:#b9ecea;
            text-align: right;
            font-weight: bold;
        }

        .net_grwth_class{
            text-align: right;
            /*font-weight: bold;*/
        }

        .center_align_class_gwt{
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
                    <label style="float: left;width: 50.0%">Team wise sales history-Depot Channel</label>
                    <!-- <div id="customButton" style="width: 16.7%;float: right;"></div> -->
                    <br>
                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <!-- <div id="tableOne"> -->
                        <table id="dtable3" class="table table-responsive table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th style="text-align:left;vertical-align:middle;"><center>Year</center></th>



                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>Special</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>Cellbiotic<BR>(Inc. Hum.<br> Vac.)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>Kinetix<br>(Inc. Hospi.)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>Zymos<br>(Inc. herbal<br>& Nutri.)</center></th>

                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>AHVD</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>Hygiene <br>(Diap.)</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>INS <br>Sale<br>B01<br> (Mr. Wahiduz<br>zaman)</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>INS<br> Sale<br>B02 <br> (Mr. Mahbubul <br>Karim)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>INS <br>Sale<br>B03<br> (Mr.Ehsan <br>Aziz)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>INS <br>Sale<br>B04<br> (Dr.Arefin <br>Ahmed)</center></th>

                                <th data-orderable="false"  style="text-align:left;vertical-align:middle;background-color:#dff0db"><center>Total</center></th>


                                <th  data-orderable="false"  style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>Special <br>%</center></th>
                                {{--<th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>CELLBIOTIC%</center></th>--}}
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>Cellbiotic%<BR>(Inc. Hum.<br> Vac.)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>Kinetix %<BR>(Inc. Hospi.)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>Zymos %<br>(Inc. Herbal<br>& Nutri.)</center></th>

                                <th data-orderable="false"  style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>AHVD <br>%</center></th>
                                <th  data-orderable="false"  style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>Hygiene <br>Diaper %</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>INS<br> Sale<br>B01% <br> (Mr. Wahiduz<br>zaman)</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>INS<br> Sale<br>B02% <br> (Mr. Mahbubul<br>Karim)</center></th>
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>INS <br>Sale<br>B03%<br>(Mr.Ehsan<br> Aziz)</center></th>
                                {{--<th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>INS <br>Sale_B04%<br> (Dr. E H Arefin)</center></th>--}}
                                <th  data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f2dede"><center>INS <br>Sale<br>B04%<br> (Dr.Arefin <br>Ahmed)</center></th>


                            </tr>


                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td style="background-color: rgb(223, 240, 219);"></td>


                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                            </tr>
                            </tfoot>
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




    {{Html::script('public/site_resource/js/custom/script_depot_team_w_sales_history.js')}}


    <script>
        var depot_team_w_sales_url = "{{url('srep/resp_depot_teamw_sales_history')}}";
        var depot_team_w_sales_i_url = "{{url('public/site_resource/images/loading.gif')}}";
        depot_team_w_sales_history_func(depot_team_w_sales_url,depot_team_w_sales_i_url);
    </script>






@endsection