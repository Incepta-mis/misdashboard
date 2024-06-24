@extends('_layout_shared._master')
@section('title','National Target QTY ACH')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--    {{Html::style('site_resource/css/dataTables.bootstrap.min.css')}}--}}
    {{--    {{Html::style('site_resource/css/fixedColumns.bootstrap.min.css')}}--}}
    {{--    {{Html::style('site_resource/css/buttons.bootstrap.min.css')}}--}}
    <link href="{{ url('public/site_resource/css/fixedHeader.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
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

        /*.dataTables_filter {
            display: none;
        }
*/
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

        table.dataTable tr.group td {
            font-weight: bold;
            background-color: #e0e0e0;
        }

        .n_tgt_qty_clss,.n_sales_qty_clss{
            text-align: center;
        }

        div.panel-body div.adv-table div.dataTables_filter label input.input-sm{
            margin-left:0.5em;
            height:22px;
            width:64%;
            display:inline;
        }

        .panel-heading {
           /* border-bottom: 1px dotted rgba(0, 0, 0, 0.2);*/
           padding:8px;
           padding-top: 0px;
           padding-bottom: 0px;
        }

        /*//10.4.2019-----------------------*/
        .wrapper{
            padding-top: 0px;
            /*position:fixed;*/
            /*width: 80%;*/
        }

        body{
            overflow: hidden;
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

        <div class="col-sm-12 col-md-12 my-sticky-element table-responsive">
            <section class="panel" id="data_table">
                <div class="table-responsive">
                    <header class="panel-heading " style="padding-bottom: 0px;">
                        <table class="display table table-bordered table-striped table-responsive" style="margin-bottom: 0px;">
                            <tbody><tr>
                                <td style="background-color: #ADDFFF">REPORT CURRENT MONTH</td>
                                <td style="background-color: #ADDFFF">REPORT UPTO</td>
                                <td style="background-color: #ADDFFF">REPORT DATE</td>
                                <td style="background-color: #ADDFFF">WORKING DAYS IN CURRENT MONTH</td>
                                <td style="background-color: #ADDFFF">DAYS OVER</td>

                            </tr>
                            <tr>
                                <td>{{$month->report_month}}</td>
                                <td>{{date("j-F-Y", strtotime($month->report_upto))}}</td>
                                <td>{{date("j-F-Y", strtotime($month->report_date))}}</td>
                                <td>{{$month->twd}}</td>
                                <td>{{$month->wd}}</td>

                            </tr>
                            </tbody>
                        </table>
                    </header>
                </div>
            </section>
        </div>
    </div>

            <div class="row">

                <div class="col-sm-12">
                    <section class="panel" id="data_table">

                         <header class="panel-heading" style="background-color: #fde9d9;">
                            <table>
                                <tr>
                                    <td style="background-color: #fde9d9; padding: 5px;">
                                        <label>Quantity Achievement &nbsp; &nbsp; <span id="export_buttons"></span></label>

                                        <label class="srcfl" style="text-align:right;width:800px"></label>

                                    </td>
                                </tr>
                            </table>

                        </header>


                        <div class="panel-body">
                    
                    <div class="adv-table  table-responsive">

                        <table id="national_trg_table" class="display table table-bordered table-striped table-responsive" width="100%">
                            <thead>


                            <tr>
                                <th style="background-color: #FCD5B4">P_GROUP</th>
                                <th style="background-color: #FCD5B4">DESCRIPTION</th>
                                <th style="background-color: #FCD5B4">PACK_S</th>
                                <th style="background-color: #FCD5B4">Target Quantity</th>
                                <th style="background-color: #FCD5B4">Quantity_Sales</th>
                                <th style="background-color: #FCD5B4">%</th>
                            </tr>

                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="background-color: #CCFFCC;" >Grand Total</th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>

                                <th style="background-color: #CCFFCC" class="n_tgt_tfoot"></th>
                                <th style="background-color: #CCFFCC" class="total_tfoot"></th>
                                <th style="background-color: #CCFFCC" class="percentage_tfoot"></th>

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

    {{Html::script('public/site_resource/js/custom/script_national_qty_trg_arch.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}
     {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

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

        var url_national_qty = "{{url('srep/resp_national_qty_trg')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";

        initialize_table_national_trg(url_national_qty,i_url);

        
    </script>

    
   
@endsection