@extends('_layout_shared._master')
@section('title','Travel Local History')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

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

        body {
            color: black;
        }

        .help-block {
            color: red;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .bolded {
            font-weight:bold;
            color: #0000ff ;
            text-decoration: underline;
        }

        .bgColors {
            background-color: #ffffff;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        input[type=file]::-webkit-file-upload-button {
            width: 0;
            padding: 0;
            margin: 0;
            -webkit-appearance: none;
            border: none;
            border: 0px;
        }

        x::-webkit-file-upload-button, input[type=file]:after {
            content: 'Browse...';
            /*background-color: blue;*/
            left: 76%;
            /*margin-left:3px;*/
            position: relative;
            -webkit-appearance: button;
            padding: 2px 8px 2px;
            border: 0px;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <label class="text-primary">
                        Travel Local History
                    </label>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="form-group">
                                <label for="advice_no" class="col-md-4 col-sm-4 control-label"><b>Document
                                        Number: </b></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control document_no" id="document_no"
                                            name="document_no">
                                        <option value="">Select Document</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="form-group">
                                <label for="status" class="col-md-3 col-sm-3 control-label"><b>Status: </b></label>
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control" id="status"
                                            name="status">
                                        <option value="">Select Status</option>
                                        <option value="Advance">Advance</option>
                                        <option value="Adjustment">Adjustment</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-2">
                                    <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                        <i class="fa fa-check"></i> <b>Display Report</b></button>
                                </div>
                            </div>
                        </div>
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
                    <div class="col-sm-12 col-md-12 col-xs-12">
                        <section class="panel" id="data_table">
                            <div class="panel-body">
                                <div class="table table-responsive">
                                    <table id="example" class="display table table-bordered table-striped"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>DOCUMENT_NO</th>
                                            <th>LOCATION</th>
                                            <th>DURATION</th>
                                            <th>AMOUNT</th>
                                            <th>RECOMMENDED</th>
                                            <th>APPROVED</th>
                                        </tr>
                                        </thead>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>


            </section>
        </div>
    </div>


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">EXPENDITURE</h4>
                </div>
                <div class="modal-body" id="exp">
                    <div class="input-group">
                        <span class="input-group-addon" >Accommodation</span>
                        <input type="text" class="form-control bgColors" id="accommodation" readonly aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Meals</span>
                        <input type="text" class="form-control bgColors " id="meals" readonly aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Incidentals</span>
                        <input type="text" class="form-control bgColors" id="incidentals" readonly aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >DA</span>
                        <input type="text" class="form-control bgColors" id="da"  readonly aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Means of Transport</span>
                        <input type="text" class="form-control bgColors" id="mot"  readonly aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Transport</span>
                        <input type="text" class="form-control bgColors"  id="transport" readonly aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" > Others</span>
                        <input type="text" class="form-control bgColors" id="others"  readonly aria-describedby="basic-addon1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/toast/toastr.min.js')}}
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}


    {{Html::script('public/site_resource/select2/select2.min.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}



    <script type="text/javascript">

        $(function () {

            var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id  }}";

            $(".document_no").empty().append("<option value='loader'>Loading...</option>");
            $.ajax({
                type: "get",
                url: '{{route('local.getMyLocalDocumentNO')}}',
                data: {emp_id: emp_id},
                dataType: 'json',
                success: function (response) {
                    var selItems = '';
                    selItems += "<option value=''>Select Document Number</option>";
                    selItems += "<option value='All'>All</option>";
                    for (var l = 0; l < response.length; l++) {
                        var id = response[l]['document_no'];
                        var val = response[l]['document_no'];
                        selItems += "<option value='" + id + "'>" + val + "</option>";
                    }
                    $('.document_no').empty().append(selItems);
                },
                error: function (response) {
                    console.log(response);
                }
            });
            $(".document_no").select2();
        });


        $('#btn_display').on('click', function () {

            if($.trim($('#status').val()) == '' ){
                swal({
                    icon: 'error',
                    type: 'error',
                    text: 'Please select Status..!'
                });
            }else {
                var document_no = $('#document_no').val();
                var status = $('#status').val();
                var emp_id = "{{ \Illuminate\Support\Facades\Auth::user()->user_id }}";
                var url = "{{ route('local.getMyLocalTravel') }}";
                $("#loader").show();
                $("#report-body").hide();
                $.ajax({
                    // headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                    type: "get",
                    url: url, // you need change it.
                    data: {
                        'emp_id': emp_id,
                        'document_no': document_no,
                        'status' : status
                    },
                    success: function (data) {
                        // console.log(data);
                        $("#loader").hide();
                        $("#report-body").show();

                        $("#example").DataTable().destroy();
                        table = $("#example").DataTable({

                            data: data,
                            dom: 'Bfrtip',
                            buttons: [
                                'excel', 'pdf',
                            ],
                            autoWidth: true,
                            columns: [
                                {data: 'id'},
                                {data: 'document_no'},
                                {data: 'location'},
                                {data: 'days'},
                                {data: 'linetotal', className: 'total'},
                                {
                                    data: "sup_accept",
                                    "render": function (data, type, row) {
                                        //console.log("get row data =",row.sup_accept);
                                        if (row.sup_accept === null) {
                                            return '<span class="label label-warning">Pending</span>';
                                        } else if (row.sup_accept === 'YES') {
                                            return '<span class="label label-success "> Accepted </span>';
                                        } else if (row.sup_accept === 'NO') {
                                            return '<span class="label label-danger "> Rejected </span>';
                                        }
                                    }
                                },
                                {
                                    data: "dept_accept",
                                    className: "saccept",
                                    "render": function (data, type, row) {
                                        //console.log("get row data =",row.dept_accept);
                                        if (row.dept_accept === null) {
                                            return '<span class="label label-warning">Pending</span>';
                                        } else if (row.dept_accept === 'YES') {
                                            return '<span class="label label-success "> Accepted </span>';
                                        } else if (row.dept_accept === 'NO') {
                                            return '<span class="label label-danger "> Rejected </span>';
                                        }
                                    }
                                },


                            ],
                            language: {
                                "emptyTable": "No Matching Records Found."
                            },
                            columnDefs: [
                                {
                                    "targets": [0],
                                    "visible": false
                                },
                                {
                                    targets: 4,
                                    createdCell: function (td, cellData, rowData, row, col) {
                                        // $(td).css('color', 'red');
                                        $(td).addClass('bolded');
                                    }
                                }
                            ],
                            info: true,
                            paging: true,
                            filter: true
                        });
                    },
                    error: function (e) {
                        console.log('Error : ', e);
                    }
                });
            }


        });

        $(document).on('click','.total',function () {
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            console.log('Yes clicked',data.id);

            var id = data.id;

            $.ajax({
                url: "{{ route('local.getMyLocalExpenditure') }}",
                type: 'get',
                data: {'id':id},
                beforeSend: function(){
                    // Show image container
                    $("#loader").show();
                },
                success: function(response){
                    console.log(response);

                    $('#myModal').modal('show');
                    $(".modal-body #accommodation").val( response[0].accommodation );
                    $(".modal-body #meals").val( response[0].meals );
                    $(".modal-body #incidentals").val( response[0].incidentals );
                    $(".modal-body #da").val( response[0].da );
                    $(".modal-body #mot").val( response[0].means_of_transport );
                    $(".modal-body #transport").val( response[0].transport );
                    $(".modal-body #others").val( response[0].others );
                },
                complete:function(data){
                    // Hide image container
                    $("#loader").hide();

                }
            });

        });

    </script>


@endsection
