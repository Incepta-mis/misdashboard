@extends('_layout_shared._master')
@section('title','History Channel Base')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

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
            padding: 5px 1px 5px 1px;
        }
        .depot_sales_class{
            background-color: #f1eea4;
            text-align: right;
        }
        .export_st_total_class{
            background-color: #ccc0da;
            text-align: right;
        }
        .inst_total_class{
            background-color: #D8E4BC;
            text-align: right;
        }


        .export_total_class{
            background-color: #eac8ad;
            text-align: right;
        }
        .toll_class{
            background-color:#e6b8b7;
            text-align: right;
        }
        .total_sale_class{
            /*background-color: #B7DEE8;*/
            background-color: rosybrown;
            text-align: right;
            /*font-weight: bold;*/
        }
        .kinetix_inter_class{
            /*background-color: #f5ae78;*/
            background-color: #e4c4ab;
            text-align: right;
        }

        .table>tfoot>tr>td{
            font-weight: bold;
        }
        .adv-table .dtable1 tr.odd:hover td.sorting_1 {
            background-color: #D6FF5C;
        }
        .grand_total_class {
            font-weight: bold;
            text-align: right;
            background-color:#b7dee8;
        }
        .total_sale_class{
            font-weight: bold;
            text-align: right;
        }
        .right_align_class{
            text-align: right;
        }

        .depo_total_class{
            text-align: right;
            background-color:#D8E4BC;
        }

        .depo_gwt_class{
            text-align: center;
            background-color:#f3d7d6;
        }
        }




        /*to center the table header text*/
        .table.dataTable.table-condensed > thead > tr > th {
            padding: 5px;
        }

        .sorting_1{
            background-color:#8db4e2;
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

        .inst_sales_t1_class{
            text-align: right;
            background-color:#e4ddec;
        }
        .eprod_class{
            text-align: right;
            background-color:#f9e4d3;
        }
        .eser_class{
            text-align: right;
            background-color:#d6a7a7;
        }
        .toll_t1_class{
            text-align: right;
            background-color:#e2e475;
        }
        .grand_growth_class{
            text-align: center;
            background-color:#fbf9c7;
        }

        /*//10.4.2019*/

        /*for reduce top space+postion fixed so no scroll*/
      /*  .wrapper{
            padding-top: 0px;
            position:fixed;
        }*/

        body{
            overflow: hidden;
        }
        .panel-heading{
            padding-top: 0px;
            padding-bottom:0px;
        }

        .panel-body{
            padding-top: 0px;
        }
        .special_tot_class {
            background-color: rgb(183, 222, 232);
            text-align: right;
        }

    </style>
    @include('comp_analysis_of_sales.caos_styles')
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
                    <label style="float:left;width:90.0%">&nbsp; &nbsp;Channel & group wise sales( all company)
                        &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; Figures in <span style="color:green">Crore</span>&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<span style="color:blue">BDT</span><span id="export_buttons"></span></label>

                    <br>
                     <input type="hidden" id="spe_id_chk" value="{{$data[0]->cnt}}">
                </header>

                <div class="panel-body">
                    <div class="adv-table">
                        <!-- <div id="tableOne"> -->
                        <table id="dtable6" class="table table-responsive table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th rowspan="3" style="text-align:left;vertical-align:middle;background-color:#8db4e2"><center>Year</center></th>
                                <th rowspan="3" style="text-align:left;vertical-align:middle;background-color:#d8da6d" data-orderable="false"><center>Depot <br>Sales</center></th>



                                <th colspan="3" data-orderable="false" style="background-color:#c3d598"><center>Institutional <br>Sales</center></th>

                                <th colspan="3" style="text-align:left;vertical-align:middle;background-color:#87d8ec" data-orderable="false"><center>Special <br>Sales</center></th>


                                <th colspan="5" data-orderable="false" style="background-color:#fabf8f"><center>Export<br> (Products)</center></th>

                                <th colspan="3" data-orderable="false" style="background-color:#cea6fd"><center>Export<br> (Service+Tech)</center></th>

                                <th rowspan="3" data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#e6b8b7"><center>Toll</center> <br><center>Mfg</center></th>
                                <!--    <th rowspan="3" data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#e4c4ab"><center>KINETIX<br>-Inter <br>Comp.<br>Sales<br>(Hospi.)</center></th> -->
                                <th rowspan="3" data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rosybrown"><center>Grand<br>Total</center></th>
                            </tr>
                            <tr>

                                <th data-orderable="false" style="background-color:#d8e4bc" ><center>B01</center></th>
                                <th data-orderable="false" style="background-color:#d8e4bc" ><center>B02</center></th>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:#D8E4BC" data-orderable="false"><center>Total</center></th>

                                <th data-orderable="false" style="background-color:rgb(183, 222, 232)"><center>B03</center></th>
                                <th data-orderable="false" style="background-color:rgb(183, 222, 232)"><center>B04</center></th>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:rgb(183, 222, 232)" data-orderable="false"><center>Total</center></th>

                                <th data-orderable="false" style="background-color: #eac8ad"><center>A01</center></th>
                                <th data-orderable="false" style="background-color: #eac8ad"><center>A02</center></th>
                                <th data-orderable="false" style="background-color: #eac8ad"><center>A03</center></th>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;" data-orderable="false"><center> Total <br>( BDT<br>in Cr.)</center></th>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;" data-orderable="false"><center> Total<br> (USD in<br> Million)</center></th>

                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:#ccc0da" data-orderable="false"><center>Service</center></th>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:#ccc0da" data-orderable="false"><center>Tech.</center></th>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:#ccc0da" data-orderable="false"><center>Total</center></th>


                            </tr>

                            <tr>

                                <th style="background-color:#e5ecd2" data-orderable="false"><center> Wahiduzzaman </center></th>
                                <th style="background-color:#e5ecd2" data-orderable="false"><center> Mahbubul </center></th>
                                <th style="background-color:#daeaef" data-orderable="false"><center> Ehsan </center></th>
                                <th style="background-color:#daeaef" data-orderable="false"> <center> Arefin </center></th>

                                <th style="background-color:#f1decf" data-orderable="false"><center> Ehsan </center></th>
                                <th style="background-color:#f1decf" data-orderable="false"><center> Arefin </center></th>
                                <th style="background-color:#f1decf" data-orderable="false"><center> Mahbubul </center></th>


                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <td style="background-color: #8db4e2">Total</td>

                                <td style="background-color:#d8da6d"></td>

                                <td style="background-color: #e5ecd2"></td>
                                <td style="background-color: #e5ecd2"></td>
                                <td style="background-color: #c3d598"></td>


                                <td style="background-color:#daeaef"></td>
                                <td style="background-color:#daeaef"></td>
                                <td style="background-color:#87d8ec"></td>

                                <td style="background-color: #eac8ad"></td>
                                <td style="background-color: #eac8ad"></td>
                                <td style="background-color:#eac8ad"></td>
                                <td style="background-color:#fabf8f"></td>
                                <td style="background-color:#fabf8f"></td>

                                <td style="background-color:#ccc0da"></td>
                                <td style="background-color:#ccc0da"></td>
                                <td style="background-color:#cea6fd"></td>

                                <td style="background-color:#e6b8b7"></td>
                                <td style="background-color:rosybrown"></td>


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


    {{Html::script('public/site_resource/js/custom/script_summary_data.js')}}

    {{--Added for Export--}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Export--}}
    <script>
        var summary_url = "{{url('srep/resp_summary_data')}}";
        var summary_i_url = "{{url('public/site_resource/images/loading.gif')}}";
         var spe_val=$('#spe_id_chk').val();
        console.log("valueeee  ",spe_val);
        summary_data_table(summary_url,summary_i_url,spe_val);
    </script>





@endsection