@extends('_layout_shared._master')
@section('title','ASM/RM Wise Sales')
@section('styles')

    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/rowGroup.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

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

        .panel {
            padding-bottom: 0px;
        }

        header.panel-heading {
            color: #003399;
            padding: 0px;
        }

        /*.dataTables_filter {
            display: none;
        }
*/
        .dt-buttons {
            float: right;
        }

        .p_group {
            width: 30%;
            font-size: 11px;
        }

        tr.group, tr.group:hover {
            background-color: #ddd !important;
        }

        .pocell {
            font-weight: bold;
        }

        .dataTables_scroll {
            overflow: auto;
        }

        .my-sticky-element.stuck {
            position: fixed;
            top: 39px;
            width: 83%;
            padding-right: 28px;
            padding-left: 30px;

            /*box-shadow:0 2px 2px rgba(0, 0, 0, .2);*/
        }

        .my-sticky-element {
            z-index: 1;
        }

        .tot_tar {
            text-align: right;
        }

        .tot_sal {
            text-align: right;
        }

        /*.nopadding {
            padding: 0;
            margin: 0;
        }*/

        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /*.modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }*/

        .modal {
            position: fixed;
            top: 1%;
            left: 2%;
            right: 2%;
            bottom: 1%;
            /*transform: translate(-50%, -50%);*/
        }
        th { font-size: 11px; }
        td { font-size: 11px; }

        /*.modal-dialog {*/
        /*width: 98%;*/
        /*height: 92%;*/
        /*padding: 0;*/
        /*}*/

        /*.modal-content {*/
        /*height: 99%;*/
        /*}*/

        @media only screen and (max-width: 600px) {
            .my-sticky-element.stuck {
                position: fixed;
                top: 39px;
                width: 100%;
                /* padding-right: 28px;
                 padding-left: 30px;*/

                /*box-shadow:0 2px 2px rgba(0, 0, 0, .2);*/
            }
        }

        @media screen and (max-width: 767px) {
            .table-responsive {
                border: none;
            }
        }


    </style>
@endsection

@section('right-content')


    <div class="row" id="fix">

        <div class="col-sm-12 col-md-12 my-sticky-element table-responsive">
            <section class="panel" id="data_table">

                <div class="table-responsive">

                    <header class="panel-heading " style="padding-bottom: 0px;">
                        <table class="display table table-bordered table-striped table-responsive"
                               style="margin-bottom: 0px;">
                            @foreach($pgwsq as $key)
                                <tr>
                                    <td style="background-color: #ADDFFF">REPORT CURRENT MONTH</td>
                                    <td style="background-color: #ADDFFF">REPORT UPTO</td>
                                    <td style="background-color: #ADDFFF">REPORT DATE</td>
                                    <td style="background-color: #ADDFFF">WORKING DAYS IN CURRENT MONTH</td>
                                    <td style="background-color: #ADDFFF">DAYS OVER</td>
                                    <!-- <td style="background-color: #C6DEFF">REPORT PREV MONTH</td>
                                    <td style="background-color: #C6DEFF">WORKING DAYS IN PREV MONTH</td>
                                    <td style="background-color: #C6DEFF">DAYS OVER</td> -->
                                </tr>
                                <tr>
                                    <td style="background-color:#fde4ea">{{ $key->report_cmonth }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->report_upto }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->report_date }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->twd }}</td>
                                    <td style="background-color:#fde4ea">{{ $key->wd }}</td>
                                <!--   <td>{{ $key->report_pmonth }}</td>
                                    <td>{{ $key->ptwd }}</td>
                                    <td>{{ $key->pwd }}</td> -->
                                </tr>
                            @endforeach
                        </table>
                    </header>
                </div>
            </section>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <table>
                        <tr>
                            <td style="background-color:#fde9d9; padding: 5px;">
                                <label>ASM/RM Wise Sales</label>

                                <label class="srcfl" style="text-align:right;width:800px"></label>

                            </td>
                        </tr>
                    </table>

                </header>
                <div class="panel-body">
                    <div class="adv-table  table-responsive">
                        <!-- <div id="tableOne"> -->
                        <table id="rmws" class="display table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th style="background-color: #FCD5B4">ASM/RM NAME</th>
                                <th style="background-color: #FCD5B4">RM TERR ID</th>
                                <th style="background-color: #FCD5B4">DSM/SM ID</th>
                                <th style="background-color: #FCD5B4">SM/DSM/SSM NAME</th>
                                <th style="background-color: #FCD5B4">GM ID</th>
                                <th style="background-color: #FCD5B4">GM</th>
                                {{--<th style="background-color: #FCD5B4">Product Group</th>--}}
                                <th style="background-color: #FCD5B4">Total Target</th>
                                <th style="background-color: #FCD5B4">Total Sales</th>
                                <th style="background-color: #FCD5B4">Ach%</th>
                                <th style="background-color: #FCD5B4">Today Product Out</th>
                                <th style="background-color: #FCD5B4">Total In-Transit</th>
                            </tr>

                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th style="background-color: #CCFFCC;" colspan="6">Grand Total</th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>
                                <th style="background-color: #CCFFCC"></th>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog" >
        <div class="modal-dialog  modal-lg " >

            <!-- Modal content-->
            <div class="modal-content">
                {{--<form action="" class="form-horizontal" role="form">--}}
                <div class="modal-header ">

                    <button type="button"  class="close" data-dismiss="modal" >&times;</button>
                    <div  id="export_buttons" style="margin-right: 3%">
                    </div>
                    <h4 class="modal-title">RM Sales Report</h4>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nopadding table-responsive" >
                    <div id="modal-body-terrChange  table-responsive">
                        <table id="rmSales" class="display table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="background-color: #FCD5B4">RM TERR ID</th>
                                <th style="background-color: #FCD5B4">P CODE</th>
                                <th style="background-color: #FCD5B4">BRAND NAME</th>
                                <th style="background-color: #FCD5B4">P GROUP</th>
                                <th style="background-color: #FCD5B4">TGT QTY</th>
                                <th style="background-color: #FCD5B4">SOLD QTY</th>
                                <th style="background-color: #FCD5B4">INT QTY</th>
                                <th style="background-color: #FCD5B4">TGT VALUE</th>
                                <th style="background-color: #FCD5B4">SOLD VAL</th>
                                <th style="background-color: #FCD5B4">INT VAL</th>
                                <th style="background-color: #FCD5B4">VAL EXP SALE</th>
                                <th style="background-color: #FCD5B4">INT DIS AMT</th>
                                <th style="background-color: #FCD5B4">SOLD DIS AMT</th>
                                <th style="background-color: #FCD5B4">TODAY OUT VAL</th>
                                <th style="background-color: #FCD5B4">TOTAL INT VAL</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot></tfoot>

                        </table>


                    </div>
                </div>
                <div class="modal-footer">
                    {{--<input type="submit" class="btn btn-warning" id="fn-submit" value="Submit">--}}
                    <input type="button" class="btn btn-default" id="fn-close" data-dismiss="modal" value="Close">
                </div>
                {{--</form>--}}
            </div>

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
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{--Added for Export--}}

    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script(' https://code.jquery.com/jquery-3.3.1.js')}}

    {{--Added for Export--}}





    {{Html::script('public/site_resource/js/custom/script_rm_wise_sales.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/dataTables.rowGroup.min.js')}}



    <script>
        var url_sm = "{{url('srep/resp_rm_wise_sales')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table_rm(url_sm, i_url);

        var $cache = $('.my-sticky-element');

        //store the initial position of the element
        var vTop = $cache.offset().top - parseFloat($cache.css('margin-top').replace(/auto/, 0));
        $(window).scroll(function (event) {
            // what the y position of the scroll is
            var y = $(this).scrollTop();

            // whether that's below the form
            if (y >= vTop) {
                // if so, ad the fixed class
                $cache.addClass('stuck');
            } else {
                // otherwise remove it
                $cache.removeClass('stuck');
            }
        });

        $(".toggle-btn").click(function () {
            $('#rmws').DataTable()
                .columns.adjust();
        });
        $(document).on('click', '.btnTerr', function () {
            console.log('clicked from dom');
            var rmTerr = $(this)[0].innerHTML;
            console.log(rmTerr);
            $.ajax({
                type: 'post',
                url: '{!! URL::to('srep/rm_sales_modal') !!}',
                data: {'rm_id': rmTerr, '_token': '{{csrf_token()}}'},
                success: function (data) {
                    console.log(data.report_data);
                    $(document).ready(function () {
                        var rmSales = $('#rmSales').dataTable({
                            data: data.report_data,
                            destroy: true,

                            "columns": [
                                {"data": "rm_terr_id"},
                                {"data": "p_code"},
                                {"data": "brand_name"},
                                {"data": "p_group"},
                                {"data": "tgt_qty"},
                                {"data": "sold_qty"},
                                {"data": "int_qty"},
                                {"data": "tgt_value"},
                                {"data": "sold_val"},
                                {"data": "int_val"},
                                {"data": "val_exp_sale"},
                                {"data": "int_dis_amt"},
                                {"data": "sold_dis_amt"},
                                {"data": "today_out_val"},
                                {"data": "total_int_val"}

                            ]
                        });
                    });

                    //       Save as implementation ////////

                    new $.fn.dataTable.Buttons(rmSales, {
                        buttons: [
                            {
                                extend: 'excel',
                                text: '<i class="fa fa-save"></i> Save As Excel',
                                action: function (e, dt, node, config) {
                                    exportExtension = 'Excel';
                                    $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                },
                                className: 'btn btn-sm btn-primary'
                            }
                        ]
                    }).container().appendTo($('#export_buttons'));
                    //  Save as implementation  Ended   here ///////
                },
                error: function (data) {
                    console.log("fail");
                }
            });
        });


    </script>

@endsection