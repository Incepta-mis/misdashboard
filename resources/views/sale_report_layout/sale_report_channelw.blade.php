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

        /*//10.4.2019*/

        /*for reduce top space+postion fixed so no scroll*/
        /*.wrapper{
            padding-top: 0px;
            position:fixed;
        }*/

        body{
            overflow: hidden;
        }
        .panel-body{
            padding-top: 0px;
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
             

                <header class="panel-heading lagerme">
                    <label style="float: left;width: 50.0%"> Channel & Company wise sales</label>

                    <label style="float: right;width: 5.0%">BDT</label>
                    <label style="float: right;width: 15.0%">Figure's in Crore <span id="export_buttons"></span></label>
                    <!-- <div id="customButton" style="width: 16.7%;float: right;"></div> -->
                    <br>
                </header>

                <header class="panel-heading mobileme">
                    </siv><label style="float: left;width: 50.0%"> Channel & Company wise sales</label>


                    <label style="float: right;width: 25.0%">Figure's in Crore <br><br> BDT</label>

                    <br>

                </header>
                <div class="panel-body">
                    <div class="adv-table">
                        <!-- <div id="tableOne"> -->
                        <table id="dtable2" class="table table-responsive table-bordered table-condensed table-striped">

                            <thead>
                            <tr>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:#8DB4E2"><center>Year</center></th>
                                {{--<th colspan="15" style="text-align:left;vertical-align:middle;background-color:#dce6f1"><center>Depot channel</center></th>--}}
                                <th colspan="5" data-orderable="false" style="background-color:#c3d598"><center>Depot Channel <br>(Excl. Inst.)</center></th>
                                <th colspan="5" data-orderable="false" style="background-color:#fabf8f"><center>Institution <br> Sales </center></th>
                                {{--<th colspan="5" data-orderable="false" style="background-color:#fde9d9"><center>Inst. sales(Unicef+<br>EDCL+UNDP+WHO)</center></th>--}}
                                <th colspan="5" data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#87d8ec"><center>Export Sales</center></th>
                                <th colspan="3" data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#d8da6d"><center>Service<br> Export</center></th>
                                <th colspan="2" data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#E6B8B7"><center>Toll <br>Mfg.</center></th>
                                {{--<th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#CCC0DA"><center>Inter<br> Com.<br> Sale</center></th>--}}

                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rosybrown"><center>All<br>Com.<br>Sale</center></th>

                            </tr>
                            <tr>
                                {{--<th colspan="5" data-orderable="false" style="background-color:#d8e4bc"><center>Depot Channel <br>(Excl. Inst.)</center></th>--}}
                                {{--<th colspan="5" data-orderable="false" style="background-color:#fabf8f"><center>Inst. <br> Sales </center></th>--}}
                                {{--<th colspan="5" data-orderable="false" style="background-color:#b7dee8"><center> Depot Includ.<br>Inst.</center></th>--}}

                                <th data-orderable="false"  style="text-align:left;vertical-align:middle;background-color:#d8e4bc"><center>IPL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#d8e4bc"><center>IVL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#d8e4bc"><center>IHHL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#d8e4bc"><center>IHNL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#d8e4bc"><center>TOTAL</center></th>

                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rgb(234,200,173)"><center>IPL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rgb(234,200,173)"><center>IVL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rgb(234,200,173)"><center>IHHL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rgb(234,200,173)"><center>IHNL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rgb(234,200,173)"><center>TOTAL</center></th>

                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#b7dee8"><center>IPL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#b7dee8"><center>IVL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#b7dee8"><center>IHHL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#b7dee8"><center>IHNL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#b7dee8"><center>TOTAL</center></th>

                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f1eea4"><center>IPL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f1eea4"><center>IVL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#f1eea4"><center>TOTAL</center></th>


                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#E6B8B7"><center>IPL</center></th>
                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:#E6B8B7"><center>IVL</center></th>

                                <th data-orderable="false" style="text-align:left;vertical-align:middle;background-color:rosybrown"><center>TOTAL</center></th>


                            </tr>

                            </thead>

                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <td>Total</td>
                                <td style="background-color:#d8e4bc"></td>
                                <td style="background-color:#d8e4bc"></td>
                                <td style="background-color:#d8e4bc"></td>
                                <td style="background-color:#d8e4bc"></td>
                                <td style="background-color:#d8e4bc"></td>

                                <td style="background-color:#eac8ad"></td>
                                <td style="background-color:#eac8ad"></td>
                                <td style="background-color:#eac8ad"></td>
                                <td style="background-color:#eac8ad"></td>
                                <td style="background-color:#eac8ad"></td>


                                <td style="background-color:#b7dee8"></td>
                                <td style="background-color:#b7dee8"></td>
                                <td style="background-color:#b7dee8"></td>
                                <td style="background-color:#b7dee8"></td>
                                <td style="background-color:#b7dee8"></td>

                                <td style="background-color:rgb(241, 238, 164);"></td>
                                <td style="background-color:rgb(241, 238, 164);"></td>
                                <td style="background-color:rgb(241, 238, 164);"></td>

                                <td style=" background-color:rgb(230, 184, 183)"></td>
                                <td style="background-color:#E6B8B7;"></td>
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

    <!-- {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}} -->

    



   

    {{--Added for Export--}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{--Export--}}


    {{Html::script('public/site_resource/js/custom/script_allcompany_sale_channelw.js')}}
    <script>
        var allcomp_channel_url = "{{url('srep/resp_allcompany_sale_channelw')}}";
        var allcomp_channel_i_url = "{{url('public/site_resource/images/loading.gif')}}";
        allcompany_sale_channel_func(allcomp_channel_url,allcomp_channel_i_url);
    </script>


@endsection