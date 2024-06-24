@extends("_layout_shared._master")
@section("title","monthly working day")
@section("styles")
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .table > thead > tr > th {
            padding: 4px;
            font-size: 14px;
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
        .mid_align_class{
            text-align: center;
        }

        /*.dataTables_filter {*/
            /*display: none;*/
        /*}*/

         /*//27.4.2019*/

        /*for reduce top space+postion fixed so no scroll*/
        .wrapper{
            padding-top: 0px;
            /*position:fixed;*/
        }
        
        body{
            overflow: hidden;
        }

    </style>
@endsection
@section('right-content')
    <!-- Stored in resources/views/layouts/master.blade.php
    -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Sale Due & Overdue Invoice
                    </label>
                </header>

                {{--<div class="panel-body">--}}



                {{--</div>--}}

            </section>
        </div>
    </div>
    <div class="row" id="showTable">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <table id="due_table" width="100%" class="table table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>Invoice Type</th>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>
                                <th>Sum No</th>
                                <th>Chemist No</th>
                                <th>Chemist Name</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Overdue Days No</th>

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
    @section("footer-content")
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section("scripts")
    <script src="{{url('public/site_resource/js/toast/toastr.min.js')}}"></script>
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/custom/script_sdue_overdue_inv.js')}}



    <script>
        var url = "{{url('rm_portal/dis_sal_overdue_inv')}}";
        var i_url = "{{url('public/site_resource/images/loading.gif')}}";
        initialize_table(url,i_url);
    </script>

    {{--<script>--}}
        {{--$(document).ready(function () {--}}

            {{--var table = "";--}}


                {{--$.ajax({--}}
                    {{--method: "post",--}}
                    {{--url: "{{url('rm_portal/dis_sal_overdue_inv')}}",--}}
                    {{--data: {_token: '{{csrf_token()}}'}--}}
                {{--})--}}
                        {{--.done(function (response) {--}}
                            {{--console.log(response);--}}
                            {{--$('#due_table').DataTable().destroy();--}}
                            {{--table =$('#due_table').DataTable(--}}
                                    {{--{--}}
                                        {{--data: response,--}}
                                        {{--columns: [--}}
                                            {{--{data: "INV_TYPE",className:'INV_TYPE'},--}}
                                            {{--{data: "INV_NO",className:'INV_NO'},--}}
                                            {{--{data: "INV_DATE",className:'INV_DATE'},--}}
                                            {{--{data: "SUM_NO",className:'SUM_NO'},--}}
                                            {{--{data: "CH_NO",className:'CH_NO'},--}}
                                            {{--{data: "CH_NAME",className:'CH_NAME'},--}}
                                            {{--{data: "AMOUNT",className:'AMOUNT'},--}}
                                            {{--{data: "DUE_DATE",className:'DUE_DATE'},--}}
                                            {{--{data: "OVERDUE_DAYS",className:'OVERDUE_DAYS'},--}}

                                        {{--],--}}
                                        {{--// "bLengthChange": true,--}}
                                        {{--"bPaginate": false,--}}
                                        {{--"scrollY": 300,--}}
                                    {{--}--}}
                            {{--);--}}
                            {{--$("#showTable").show();--}}
                            {{--table.columns.adjust();--}}

                        {{--});--}}

            {{--$(".toggle-btn").click(function () {--}}
                {{--$('#due_table').DataTable().columns.adjust();--}}
            {{--});--}}

        {{--});--}}


    {{--</script>--}}
@endsection



