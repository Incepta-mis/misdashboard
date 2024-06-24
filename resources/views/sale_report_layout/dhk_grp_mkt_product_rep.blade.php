@extends('_layout_shared._master')
@section('title','DHK GRP & MKT Product')
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
            font-size: 13px;
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

        /*//10.4.2019-----------------------*/
      /*  .wrapper{
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
                

                <header class="panel-heading " style="padding-bottom: 0px;width: 75%;">
                   


                    <table class="display table table-bordered table-striped table-responsive" style="margin-bottom: 0px;">
                        <tbody><tr>
                            <td style="background-color: #ADDFFF">MONTH</td>
                            <td style="background-color: #ADDFFF">PRODUCT OUT ON</td>
                            <td style="background-color: #ADDFFF">REPORT DATE</td>
                            <td style="background-color: #ADDFFF">WORKING DAYS IN MONTH</td>
                            <td style="background-color: #ADDFFF">DAYS OVER</td>
                            {{--<td style="background-color: #C6DEFF">REPORT PREV MONTH</td>--}}
                            {{--<td style="background-color: #C6DEFF">WORKING DAYS IN PREV MONTH</td>--}}
                            {{--<td style="background-color: #C6DEFF">DAYS OVER</td>--}}
                        </tr>
                        <tr>
                            <td>@if(count($month) > 0){{$month->report_month}}@endif</td>
                            <td>@if(count($prd_out_on) > 0){{date("j-F-Y", strtotime($prd_out_on->report_upto))}}@endif</td>
                            <td>@if(count($reprot_d) > 0){{date("j-F-Y", strtotime($reprot_d->report_date))}}@endif</td>
                            <td>@if(count($month) > 0){{$month->twd}}@endif</td>
                            <td>@if(count($month) > 0){{$month->wd}}@endif</td>
                            {{--<td>JUL-18</td>--}}
                            {{--<td>27</td>--}}
                            {{--<td>15</td>--}}
                        </tr>
                        </tbody></table>


                        <br>
                        <br>
                        <br>


                         <label style="float: left;width: 50.0%">DHAKA DEPOT SALES</label>
                         <br>
                </header>

                <div class="panel-body">
                    
                    
                    <div class="adv-table table-responsive">
                        <!-- <div id="tableOne"> -->
                        <table id="dtable1" class="table table-responsive table-bordered table-condensed table-striped" style="width: 75%">
                            <thead>
                           
                            <tr>
                            
                                <th style="background-color: rgb(141, 180, 226);text-align: center;font-weight: bold" data-orderable="false">P_GROUP</th>
                                <th style="background-color: rgb(252, 213, 180);text-align: center;font-weight: bold" data-orderable="false">DHAKA RETAIL</th>
                                <th style="background-color: #D8E4BC;text-align: center;font-weight: bold" data-orderable="false">MITFORD</th>
                                <th style="background-color: rgb(188, 143, 143);text-align: center;font-weight: bold" data-orderable="false">OUTSTATION</th>
                                <th style="background-color: rgb(241, 238, 164);text-align: center;font-weight: bold" data-orderable="false">Grand Total</th>
                               
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($datas) > 0)
                            <?php $sum_dhk_ret = 0 ?>
                            <?php $sum_mitford = 0 ?>
                            <?php $sum_outstation = 0 ?>
                            <?php $sum_grand_total= 0 ?>
                                

                                @foreach($datas as $d)
                                    <tr>
                                        <td style="font-weight: bold;background-color: #cad8e8">{{ $d->p_group}}</td>
                                        <td style="text-align: right">{{ number_format($d->dhaka_retail, 0, '.', ',') }}</td>
                                        <td style="text-align: right">{{ number_format($d->mitford, 0, '.', ',') }}</td>
                                        <td style="text-align: right">{{ number_format($d->outstation, 0, '.', ',') }}</td>
                                        <td style="font-weight: bold;background-color:#ececd6;text-align: right">{{ number_format($d->grand_total, 0, '.', ',') }}</td>
                                    </tr>
                                    <?php $sum_dhk_ret +=$d->dhaka_retail ?>
                                    <?php $sum_mitford +=$d->mitford ?>
                                    <?php $sum_outstation +=$d->outstation ?>
                                    <?php $sum_grand_total +=$d->grand_total ?>

                                @endforeach

                            </tbody>

                            <tfoot>
                            <tr>
                                <td style="font-weight: bold">Grand Total</td>
                                <td style="text-align: right;font-weight: bold">{{ number_format($sum_dhk_ret, 0, '.', ',') }}</td>
                                <td style="text-align: right;font-weight: bold">{{ number_format($sum_mitford, 0, '.', ',') }}</td>
                                <td style="text-align: right;font-weight: bold">{{ number_format($sum_outstation, 0, '.', ',') }}</td>
                                <td style="text-align: right;font-weight: bold">{{ number_format($sum_grand_total, 0, '.', ',') }}</td>
                               
                               
                            </tr>
                            </tfoot>
                             @else
                                <tr><td colspan="5" class="text-center">No Data Available</td></tr>
                            @endif
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
    
   

@endsection