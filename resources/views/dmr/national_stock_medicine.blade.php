@extends('_layout_shared._master')
@section('title','National Stock Report')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>


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
    </style>
@endsection

@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        National Stock Report
                    </label>
                </header>
                <div class="panel-body" >
                          <button id="btn_display" style="display: none;"></button>
                </div>
            </section>
        </div>
    </div>
    <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
        <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
            <div class="panel">
                <img src="{{url('public/site_resource/images/preloader.gif')}}"
                     alt="Loading Report Please wait..." width="35px" height="35px"><br>
                <span><b><i>Please wait...</i></b></span>
            </div>
        </div>
    </div>


    <div class="row" id="report-body" style="display: none;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="req_ccwise" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Sap Code</th>
                                    <th>Brand</th>
                                    <th>Pack_S</th>
                                    <th>P_Group</th>

                                    <th>P_Code</th>
                                    <th>ASH</th>
                                    <th>BBR</th>
                                    <th>BOG</th>
                                    <th>BSL</th>
                                    <th>COM</th>

                                    <th>COX</th>
                                    <th>CTG</th>
                                    <th>CTGS</th>
                                    <th>DHK</th>
                                    <th>DHKS</th>

                                    <th>DNP</th>
                                    <th>FNI</th>
                                    <th>JSR</th>
                                    <th>KHL</th>
                                    <th>MAG</th>
                                    <th>MOU</th>
                                    <th>MPUR</th>
                                    <th>MYM</th>

                                    <th>NAR</th>
                                    <th>NOA</th>
                                    <th>PAB</th>
                                    <th>RAJ</th>
                                    <th>RAN</th>
                                    <th>SYL</th>
                                    <th>TNG</th>
                                    <th>CHAD</th>
                                    <th>GAZI</th> 
                                    <th>KUS</th>
                                    <th>CWH</th>
                                    <th>FAC</th>
                                </tr>
                                </thead>
                                <tbody style="white-space:nowrap;overflow:hidden;"></tbody>
                                <tfoot>
                                <tr>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>




    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{-- Added for selecting all on click--}}

    {{----}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.select.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{Html::script('public/site_resource/select2/select2.min.js')}}


    <script type="text/javascript">

        var _csrf_token;
        servloc = "{{url('rm_portal/national_stock_medicine_data')}}";
        _csrf_token = '{{csrf_token()}}';

        $(document).ready(function () {
            /**
             * Created by Sahadat on 17/02/2019.
             */

            var table;


            $('#btn_display').on('click', function () {
                $("#loader").show();
                $("#report-body").hide();
                $('#req_ccwise').DataTable().destroy();
                $.ajax({
                    url: servloc,
                    method: "post",    // change here for post method
                    dataType: 'json',

                    data: {
                        _token: _csrf_token, // include it in data section
                    },


                    success: function (resp) {


                        console.log(resp);

                        console.log($('#fix').height());
                        $("#loader").hide();
                        $("#report-body").show();

                        $("#req_ccwise").DataTable().destroy();
                        table = $("#req_ccwise").DataTable({
                            data: resp,
                            dom: '<"toolbar">Bfrtip',
                        buttons: [
                            {
                                extend: 'excelHtml5', className: "btn-warning",
                                exportOptions: {
                                    columns: [0,1,2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,25,26,27,28,29,30,31,32,33,34,35,36]
                                }
                            }
                        ],
                            // buttons: false,
                            searching: true,
                            scrollY: 300,
                            deferRender:    true,
                            scrollCollapse: true,
                            scroller: {
                                loadingIndicator: true
                            },
                            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            scrollX: true,
                            columns: [
                                {data: "company_code"},
                                {data: "company_name"},
                                {data: "sap_code"},
                                {data: "name"},
                                {data: "pack_s"},
                                {data: "p_group"},
                                {data: "p_code"},
                                {data: "ash"},
                                {data: "bbr"},
                                {data: "bog"},
                                {data: "bsl"},
                                {data: "com"},

                                {data: "cox"},
                                {data: "ctg"},
                                {data: "ctgs"},
                                {data: "dhk"},
                                {data: "dhks"},
                                {data: "dnp"},
                                {data: "fni"},
                                {data: "jsr"},
                                {data: "khl"},
                                {data: "mag"},
                                {data: "mou"},
                                {data: "mpur"},
                                {data: "mym"},

                                {data: "nar"},
                                {data: "noa"},
                                {data: "pab"},
                                {data: "raj"},
                                {data: "ran"},
                                {data: "syl"},
                                {data: "tng"},
                                {data: "chad"},
                                {data: "gazi"}, 
                                {data: "kus"},
                                {data: "cwh"},
                                {data: "fac"}




                            ],



                            language: {
                                "emptyTable": "No Matching Records Found."
                            },

                            info: false,
                            paging: false,
                            filter: false,


                        });

                        // table.fixedHeader.enable();
                    },
                    error: function (err) {
                        // console.log(err);
                        $("#loader").hide();
                        $("#report-body").show();
                    }
                });
            });

            $('#btn_display').trigger('click');


            $(".toggle-btn").click(function () {
                table.columns.adjust();
            });


        });


    </script>

@endsection