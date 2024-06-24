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


        /*div#ascrail200.nicescroll-rails div{*/
            /*position: relative;*/
            /*top: 0px;*/
            /*float: right;*/
            /*width: 6px;*/
            /*height: 432px;*/
            /*background-color: red;*/
            /*border: 0px;*/
            /*background-clip: padding-box;*/
            /*border-radius: 0px;*/
        /*}*/

        /*//10.4.2019*/

        /*for reduce top space+postion fixed so no scroll*/
       /* .wrapper{
            padding-top: 0px;
            position:fixed;
        }*/
        
        body{
            overflow: hidden;
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
                    <label style="float:left;width:90.0%">&nbsp &nbsp Channel wise yearly sales (all company)
                        &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp Figures in <span style="color:green">Crore</span>&nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp<span style="color:blue">BDT</span><span id="export_buttons"></span> </label>

                    <br>
                    <input type="hidden" id="spe_id_chk" value="{{$data[0]->cnt}}">

                </header>

                <header class="panel-heading mobileme">
                    <label style="float:left;width:90.0%">&nbsp &nbsp Month Wise Sales Report (IPL+IVL+IHHL+IHNL)
                        &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp Figures in <span style="color:green">Crore</span>&nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp<span style="color:blue">BDT</span><span id="export_buttons"></span> </label>

                    <br>
                </header>




                <div class="panel-body">
                    <div class="adv-table  table-responsive">
                        <!-- <div id="tableOne"> -->
                        <table id="dtable1" class="table table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th rowspan="2" style="text-align:left;vertical-align:middle;background-color:#8db4e2"><center>Year</center></th>
                                <th colspan="12" data-orderable="false" style="background-color:#D8E4BC"><center>Depot Channel</center></th>
                                <th rowspan="2" data-orderable="false" style="background-color:#D8E4BC;text-align:left;vertical-align:middle;"><center>Depot <br> Total</center></th>
                                
                                 <th rowspan="2" data-orderable="false" style="background-color:#CCC0DA;text-align:left;vertical-align:middle;"><center>Inst. <br> Sale</center></th>

                                <th rowspan="2" data-orderable="false" style="background-color:#E6B8B7;text-align:left;vertical-align:middle;" @if(!$data[0]->cnt) class="spe_hid" @endif ><center>Special <br> Sales </center></th>


                               

                                <th rowspan="2" data-orderable="false" style="background-color:#FCD5B4;text-align:left;vertical-align:middle;"><center>Export <br> (Prod.)</center></th>
                                <th rowspan="2" data-orderable="false" style="background-color:#bc8f8f;text-align:left;vertical-align:middle;"><center>Export <br> (Serv. <br>+ Tech)</center></th>
                                <th rowspan="2" data-orderable="false" style="background-color:#d8da6d;text-align:left;vertical-align:middle;"><center>Toll <br> Mfg</th>
                                

                                <th rowspan="2" data-orderable="false" style="background-color:#b7dee8;ext-align:left;vertical-align:middle;"><center>Grand<br> Total</center></th>
                                <th rowspan="2" data-orderable="false" style="background-color:#f1eea4;text-align:left;vertical-align:middle;"><center>Grand<br> Growth <br>%</center></th>
                            </tr>
                            <tr>
                                <!--<th rowspan="2" data-orderable="false">Year</th>-->
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Jan</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Feb</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Mar</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Apr</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>May</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Jun</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Jul</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Aug</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Sep</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Oct</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Nov</center></th>
                                <th data-orderable="false" style="background-color:#e8f1d5;text-align:left;vertical-align:middle;"><center>Dec</center></th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>
                            <tr>
                                <td style="background-color: #8db4e2">Total</td>

                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>

                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>
                                <td style="background-color: #e8f1d5"></td>

                                <td style="background-color:#D8E4BC"></td>

                                <td style="background-color: #e6b8b7"></td>
                                <td style="background-color: #ccc0da"></td>
                                <td style="background-color: #fcd5b4"></td>
                                

                                <td style="background-color: #bc8f8f"></td>
                                <td style="background-color: #d8da6d"></td>

                               <!--  <td></td> -->
                                <td style="background-color:#b7dee8;"></td>
                                <td style="background-color: rgb(241, 238, 164)"></td>
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
   


    {{Html::script('public/site_resource/js/custom/script_month_wsale.js')}}
    

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
        var url = "{{url('srep/resp_month_daily_sales')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        var spe_val=$('#spe_id_chk').val();
        console.log("valueeee  ",spe_val);
        initialize_table(url,i_url,spe_val);
    </script>

   

    <script type="text/javascript">
        $(document).ready(function(){
                // console.log("hhh");

                // var dd=$('table#dtable1 thead tr th.depo_gwt_class').attr('class').split(" ");
                // console.log(dd[0]);
                // console.log(dd.length);

                // console.log($('table#dtable1 thead tr th.depo_gwt_class').attr('class').split(" "));

                // if(i=0;i<dd.length;i++){
                //     if(dd[0]=='spe_hid'){
                //         $('table#dtable1 tbody tr th.depo_gwt_class').each(function(){
                //             $(this).addClass('spe_hid');
                //         })
                //     }
                // }
                // (widths[0] !=0) ? '{ "sWidth": "1%" }' : '',   
        });
    </script>
    
 

@endsection