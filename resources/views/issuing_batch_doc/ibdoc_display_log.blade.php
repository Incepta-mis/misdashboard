@extends('_layout_shared._master')
@section('title','Issuing Batch Doc.')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/dpicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
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

        .btn-group, .btn-group-vertical {
           margin-top: 13px;
        }  

    </style>
@endsection
@section('right-content')
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading" style="text-transform: none;">
                <span>Print History Report</span>
            </header>
            <div class="panel-body">
                <div class="form-horizontal">
                    <form action="" id="report_param">
                        <div class="form-group">
{{--                            date--}}
                            <label class="control-label col-md-1" for="date_from">
                                    <b>D.From:</b></label>
                            <div class="col-md-2 text-center">
                                <div class='input-group date' id='date_from'>
                                    <input type='text' name="date_from" class="form-control input-sm"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <label class="control-label col-md-1" for="date_to">
                                    <b>D.To:</b></label>
                            <div class="col-md-2 text-center">
                                <div class="input-group date" id="date_to">
                                    <input type="text" name="date_to" class="form-control input-sm">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
{{--                            time--}}
                            <label class="control-label col-md-1" for="date_from">
                                <b>T.From:</b></label>
                            <div class="col-md-2 text-center">
                                <div class='input-group date' id='time_from'>
                                    <input type='text' name="time_from" class="form-control input-sm"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <label class="control-label col-md-1" for="date_to">
                                <b>T.To:</b></label>
                            <div class="col-md-2 text-center">
                                <div class="input-group date" id="time_to">
                                    <input type="text" name="time_to" class="form-control input-sm">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-1" for="file">
                                <b>File</b></label>
                            <div class="col-md-2 text-center">
                                <select name="file" id="file" class="form-control input-sm">
                                    <option value="All" readonly="" selected>Select File</option>
                                    @foreach($files as $f)
                                        <option value="{{$f->file_name}}">{{$f->file_name}}</option>
                                    @endforeach    
                                </select>
                            </div>
                            <label class="control-label col-md-1" for="by">
                                <b>Print By</b></label>
                            <div class="col-md-2 text-center">
                                <select name="by" id="by" class="form-control input-sm">
                                    <option value="All" readonly selected>Select By</option>
                                    @foreach($names as $n)
                                        <option value="{{$n->code}}">{{$n->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-md-1" for="type">
                                <b>Type</b></label>
                            <div class="col-md-2 text-center">
                                <select name="type" id="type" class="form-control input-sm">
                                    <option value="All" readonly selected>Select Type</option>
                                    @foreach($types as $t)
                                        <option value="{{$t->print_type}}">{{$t->print_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </form>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <button id="btnSubmit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Display
                                Report
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <img src="{{url('public/site_resource/images/ibd_img/skeleton_page.gif')}}" id="content_loader"
                             alt="Loading Report" width="100%" height="250px" style="display: none;">
                        <div id="table_content" style="display: none;">
                            <table id="tab_log" class="table table-bordered table-condensed table-striped table-hover"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Print Date Time</th>
                                    <th>File Name</th>
                                    <th>Printed By</th>
                                    <th>Print Type</th>
                                    <!-- <th>Batch</th> -->
                                    <th>Remarks</th>
                                  
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <script src="{{url('public/site_resource/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/dataTables.select.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/jszip.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/pdfmake.min.js')}}"></script>
    <script src="{{url('public/site_resource/js/vfs_fonts.js')}}"></script>
    <script src="{{url('public/site_resource/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('public/site_resource/dpicker/moment-with-locales.js')}}"></script>
    <script src="{{url('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}"></script>
    <script>
        $(document).ready(function () {
            //date time picker init
            var date = new Date();
            var previous_date = date.setDate(date.getDate() - 1);

            $('#date_from,#date_to').datetimepicker({
                defaultDate: previous_date,
                format: 'DD-MMM-YY',
                showTodayButton: true,
                showClose: true,
                showClear: true
            });

            $('#time_from,#time_to').datetimepicker({
                format:'LT',
                // defaultDate:moment(new Date())
            });

            // end

            var http =  function (url,method,params) {
                var response = new Promise(function (resolve,reject) {
                   $.ajax({
                      url:url,
                      type:method,
                      data:params,
                      success:function (ret_val) {
                          resolve(ret_val);
                      },
                      error:function (error) {
                          reject(error);
                      }
                   });
                });

                return response;
            };

            function display_loader(){
                $('#content_loader').show();
                $('#table_content').hide();
            }

            function hide_loader(){
                $('#content_loader').hide();
                $('#table_content').show();
            }

            var table = $('#tab_log').DataTable({
                data: [],
                "paging": true,
                columns: [
                    // {data: "sales_area_code", className: 'wd'},
                    {data: "print_dt", className: 'print_dt'},
                    {data: "file_name", className: 'file_name'},
                    {data: "name", className: 'name'},
                    {data: "print_type", className: 'print_type'},
                 /*   {data: "batch", className: 'batch'},*/
                    {data: "reason", className: 'reason'}
                    ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        text:'Export to Excel',
                        className:'btn btn-sm btn-default',
                        action:function () {
                            window.location='{{URL::to('ibd/get_excel/')}}'+'/'+$('#report_param').serialize();
                        }
                    }
                ]
            });

            //get_data
            $('#btnSubmit').click(function () {
                display_loader();
                var param_data = $('#report_param').serialize();
                console.log(param_data);
                http('{{url('ibd/get_log')}}',
                    'post',{_token:'{{csrf_token()}}',param:param_data}).then(function (value) {
                    console.log(value);
                    if(table != null){
                        table.clear();
                        table.rows.add(value);
                        table.draw();
                    }
                    hide_loader();
                },function (reason) {
                   console.log(reason);
                   hide_loader();
                });
            });


        });
    </script>
@endsection