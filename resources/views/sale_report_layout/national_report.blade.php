@extends('_layout_shared._master')
@section('title','National Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedColumns.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('public/site_resource/css/scroller.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
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

        .toolbar {
            float: right;
            /*align : middle;*/
            color: orangered;
            padding-right: 25%;
            /*padding-left: 20%;*/

        }

        .shadow{
            box-shadow: 0 3px 3px 0 rgba(0,0,0,0.2)
        }

       /* .dataTables_scrollBody{
            height: calc(56vh - 100px)!important;
            overflow: auto!important;
        }
*/
       .dt-buttons{
            padding-top: 11px!important;
        }


    </style>
@endsection

@section('right-content')
<form method="post" action="{{url('srep/cmrep/download_excel')}}" id="nr_form">
    {{csrf_field()}}
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel shadow" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        National Report
                    </label>
                </header>
                <div class="panel-body" style="padding:0px;padding-top: 6px;">
                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">


                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="bgt_month"
                                                   class="col-md-4 col-sm-6 control-label"><b>Depot</b></label>
                                            <div class="col-md-8">
                                                <select name="depot" id="depot"
                                                        class="form-control input-sm">
{{--                                                    <option value="" selected disabled>Select</option>--}}
                                                    <option value="all"selected>All</option>
                                                    @foreach($depot as $d)
                                                        <option value="{{$d->d_id}}">{{$d->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cc"
                                                   class="col-md-4 col-sm-6 control-label"><b>P.Group</b></label>
                                            <div class="col-md-8">
                                                <select name="pgroup" id="pgroup"
                                                        class="form-control input-sm">

{{--                                                    <option value="" selected disabled>Select pgroup</option>--}}
                                                    <option value="all" selected>All</option>
                                                    @foreach($p_group as $pg)
                                                        <option value="{{$pg->p_group}}">
                                                            {{$pg->p_group}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="cc"
                                                   class="col-md-3 col-sm-6 control-label"><b>Sales area</b></label>
                                            <div class="col-md-9">
                                                <select name="sales_area" id="sales_area"
                                                        class="form-control input-sm">

{{--                                                    <option value="" selected disabled>Select sales area</option>--}}
                                                    <option value="all"selected>All</option>
                                                    @foreach($sales_area_code as $sac)
                                                        <option value="{{$sac->sales_area_code}}">
                                                            {{$sac->sales_area_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                                        <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Display</b></button>
                                        {{--</div>--}}
                                    </div>


                                </div>


                                {{--</form>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel shadow">
                <img src="{{url('public/site_resource/images/profile-load.svg')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>

    <div class="row" id="report-body" style="display: none;">


        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel shadow" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condensed"
                            style="margin-bottom: 0px;">
                                <tbody>
                                    <tr >
                                        <td class="text-center" style="font-size: 1.2rem;">
                                            <b>Total Sold: <span class="tsold"></span></b>
                                        </td>
                                        <td class="text-center" style="font-size: 1.2rem;">
                                            <b>Total In Transit: <span class="tint"></span></b>
                                        </td>
                                        <td class="text-center" style="font-size: 1.2rem;">
                                            <b>Total Cumulative Sales: <span class="tcum"></span></b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table id="nr_table" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th> SALES AREA</th>
                                    <th> D_ID</th>
                                    <th> NAME</th>
                                    <th> SAP_CODE</th>
                                    <th>P_GROUP</th>
                                    <th> P_CODE</th>
                                    <th>DESCRIPTION</th>
                                    <th> PACK_S</th>
                                    <th> T_P</th>
                                    <th> N_TGT</th>
                                    <th> DEPT_TGT</th>
                                    <th> VAL_N_TGT</th>
                                    <th> VAL_DEP_TGT</th>
                                    <th> N_T_TGT</th>
                                    <th> DEP_T_TGT</th>
                                    <th> QTY_SOLD</th>
                                    <th> QTY_INT</th>
                                    <th> QTY_EXP_SALE</th>
                                    <th> VAL_SOLD</th>
                                    <th> VAL_INT</th>
                                    <th> VAL_EXP_SALE</th>
                                    <th> INT_VDIS_AMT</th>
                                    <th> SOLD_VDIS_AMT</th>
                                    <th> QTY_STOCK</th>
                                    <th> ACH</th>

                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </div>
</form>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedColumns.min.js')}}
        {{Html::script('public/site_resource/js/dataTables.scroller.min.js')}}
    {{Html::script('public/site_resource/js/scroller.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}
    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}
    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    <script>

         $(document).ready(function () {
            var table = null;
            $('#btn_display').on('click', function () {
                $("#loader").show();
                $("#report-body").hide();
                $('#nr_table').DataTable().destroy();
                table = $('#nr_table').DataTable({
                    //processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{url('srep/cmrep/national_report_output')}}',
                        // type:'POST',
                        data: function (data) {
                            //console.log(data);
                            data.params = {
                                sac: $('#sales_area').val(),
                                pg: $('#pgroup').val(), 
                                d_id: $('#depot').val()
                            }
                        }
                    },
                    buttons: false,
                    searching: true,
                    scrollY: 220,
                    deferRender:    true,
                    scrollCollapse: true,
                    scroller: {
                        loadingIndicator: true
                    },
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    scrollX: true,
                    columns: [
                        {data: "sales_area_code", className: 'sales_area_code'},
                        {data: "d_id", className: 'd_id'},
                        {data: "name", className: 'name'},
                        {data: "sap_code", className: 'sap_code'},
                        {data: "p_group", className: 'p_group'},
                        {data: "p_code", className: 'p_code'},
                        {data: "description", className: 'description'},
                        {data: "pack_s", className: 'pack_s'},
                        {data: "t_p", className: 't_p'},
                        {data: "n_tgt", className: 'n_tgt'},
                        {data: "dept_tgt", className: 'dept_tgt'},
                        {data: "val_n_tgt", className: 'val_n_tgt'},
                        {data: "val_dep_tgt", className: 'val_dep_tgt'},
                        {data: "n_t_tgt", className: 'n_t_tgt'},
                        {data: "dep_t_tgt", className: 'dep_t_tgt'},
                        {data: "qty_sold", className: 'qty_sold'},
                        {data: "qty_int", className: 'qty_int'},
                        {data: "qty_exp_sale", className: 'qty_exp_sale'},
                        {data: "val_sold", className: 'val_sold'},
                        {data: "val_int", className: 'val_int'},
                        {data: "val_exp_sale", className: 'val_exp_sale'},
                        {data: "int_vdis_amt", className: 'int_vdis_amt'},
                        {data: "sold_vdis_amt", className: 'sold_vdis_amt'},
                        {data: "qty_stock", className: 'qty_stock'},
                        {data: "ach", className: 'ach'}
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: 'Export Excel',
                            action: function ( e, dt, node, config ) {
                                e.preventDefault();
                                $('#nr_form').submit();
                            }
                        }
                    ],
                    "initComplete": function (settings, json) {
                        $('#loader').hide();
                        $("#report-body").show();
                        table.columns.adjust();
                    }
                });

                //summary data
                $.ajax({
                    type:'POST',
                    url:'{{url('srep/cmrep/national_report_summary')}}',
                    data: {
                        d_id: $('#depot').val(),
                        pgroup: $('#pgroup').val(),
                        sac_data:$('#sales_area').val(),
                        _token: '{{csrf_token()}}'
                    },
                    success:function (response) {
                        console.log(response);
                        if(response[0]?.exp_sale){
                            $('.tsold').text(response[0]?.sold);
                            $('.tint').text(response[0]?.intr);
                            $('.tcum').text(response[0]?.exp_sale);
                        }
                    },
                    error:function (error) {
                        console.log(error);
                    }
                });

            });

            $('#btn_display').trigger('click');

            //to fix page scroll
            var isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
            if (isMobile) {
                console.log('yes mobile');
                $('html, body').css({
                    overflow: 'auto',
                    height: 'auto'
                });
            }else{
                $('html, body').css({
                    overflow: 'hidden',
                    height: '100%'
                });
            }

            // $('.toggle-btn').toggle(function () {
            //     table.columns.adjust();
            // });

        });
    </script>


@endsection