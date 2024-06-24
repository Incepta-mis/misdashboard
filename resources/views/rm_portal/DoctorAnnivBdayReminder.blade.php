@extends('_layout_shared._master')
@section('title','Doctor Anniversary/Birthday Reminder')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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


        .panel-scroll {
            height: 180px;
            overflow-y: scroll;
        }

        ul.goal-progress li {
            padding-bottom: 0;
            margin-bottom: 5px;
        }

        .card{
            box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.2);
        }

        .dataTables_length, .dataTables_filter {
             padding: 0;
        }

        .export:hover{
            cursor: pointer;
        }

    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="panel panel-info card">
                    <header class="panel-heading" style="text-transform: none;">
                        Upcoming Birth Day
                        <span class="pull-right">Export to Excel
                            <i class="fa fa-file export" name="birth" title="Export as Excel"></i>
                        </span>
                    </header>
                    <div class="panel-body scroll">
                        <div class="text-center content_loader">
                            <img width="100px" src="{{url('public/site_resource/images/c_loading.gif')}}" alt="">
                        </div>
                        <ul class="goal-progress bidays">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-info card">
                    <header class="panel-heading" style="text-transform: none;">
                        Upcoming Marriage Anniversary
                        <span class="pull-right">Export to Excel
                         <i class="fa fa-file export" name="marriage" title="Export as Excel"></i>
                        </span>
                    </header>
                    <div class="panel-body scroll">
                        <div class="content_loader text-center">
                            <img width="100px" src="{{url('public/site_resource/images/c_loading.gif')}}" alt="">
                        </div>
                        <ul class="goal-progress madays">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="panel card">
        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-12">
                    <img src="{{url('public/site_resource/images/ibd_img/skeleton_page.gif')}}"
                         class="content_loader"
                                            alt="Loading Report" width="100%" height="250px" style="display: none;">
                    <div id="table_content" style="display: none;">
                        <table id="tab_dabr" class="table table-bordered table-condensed table-striped table-hover"
                               width="100%">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Doctor Id</th>
                                <th>Doctor Name</th>
                                <th>Doctor Address</th>
                                <th>Territory</th>
                                <th>Email Id</th>
                                <th>Mobile No</th>
                                <th>MarriageDay</th>
                                <th>Birthday</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{--    modal doctor details--}}
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="doctor_details" class="modal fade"
         data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #46B8DA;">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">Doctor Details</h4>
                </div>
                <div class="modal-body table-responsive" id="info">
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnCloseModal" class="btn btn-warning btn-sm">
                        <i class="fa fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
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
    <script src="{{url('public/site_resource/js/jquery.slimscroll.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('.scroll').slimScroll({
                height:'180px',
                alwaysVisible: true,
                railVisible: true
            });

            var columns = [];

            var http = function (url, method, params) {
                var response = new Promise(function (resolve, reject) {
                    $.ajax({
                        url: url,
                        type: method,
                        data: params,
                        success: function (ret_val) {
                            resolve(ret_val);
                        },
                        error: function (error) {
                            reject(error);
                        }
                    });
                });

                return response;
            };

            function getList(values,type) {
                console.log(values);
                var rows = '';
                if(values.length > 0){
                    for(var i=0;i<values.length;i++){
                        rows += '<li>'+
                            '<div class="prog-avatar">'+
                            '<img src="{{url('public/site_resource/images/doctor.png')}}" alt="">'+
                            '</div>'+
                            '<div class="details">'+
                            '<div class="title">'+
                            '<a href="#" class="doc_id">'+values[i].id+'</a> -'+ values[i].name +
                            '<p><span class="badge badge-warning">Event Date: '+values[i].edate+'</span> | Days left to Event: <span class="badge badge-warning">'+values[i].day_diff+'</span></p>'+
                            '</div>'+
                            '</div>'+
                            '</li>';
                    }
                }else{
                    rows += '<li>'+
                                '<div class="details">'+
                                    '<div class="title">'+
                                    '<p class="text-center alert alert-info"><span class="badge badge-warning"><i class="fa fa-info "></i></span> <b>No Upcoming '+type+' within 3 Days</b></p>'+
                                    '</div>'+
                                '</div>'+
                            '</li>';
                }

                return rows;
            }

            function display_loader() {
                $('.content_loader').show();
                $('#table_content').hide();
            }

            function hide_loader() {
                $('.content_loader').hide();
                $('#table_content').fadeIn(1000);
            }

            var table = $('#tab_dabr').DataTable({
                data: [],
                "paging": true,
                columns: [
                    {data: 'sl', className: 'sl'},
                    {data: 'doctor_id', className: 'doctor_id'},
                    {data: 'doctor_name', className: 'sl'},
                    {data: 'doctor_address', className: 'doctor_address'},
                    {data: 'territory', className: 'territory'},
                    {data: 'email_id', className: 'email_id'},
                    {data: 'mobile_no', className: 'mobile_no'},
                    {data: 'marriage_day', className: 'marriage_day'},
                    {data: 'birthday', className: 'birthday'}
                ]
            });

            //get_data
            function load_view_data() {
                display_loader();
                var param_data = $('#report_param').serialize();
                console.log(param_data);
                http('{{url('rm_portal/dabr_data')}}', 'get', {}).then(function (value) {
                    console.log(value);
                    if (table != null && value.drecords) {
                        table.clear();
                        table.rows.add(value.drecords);
                        table.draw();
                    }

                    $('.bidays').empty().hide().append(getList(value.brecords,'Birthday')).fadeIn(1000);
                    $('.madays').empty().hide().append(getList(value.mrecords,'Marriage Anniversary')).fadeIn(1000);

                    hide_loader();
                }, function (reason) {
                    console.log(reason);
                    hide_loader();
                });
            };

            load_view_data();

            $(document).on('click','.doc_id',function () {
                console.log('clicked');
                http('{{url('rm_portal/get_doc_details')}}','post',{
                    doc_id:$(this).text(),
                    _token:'{{csrf_token()}}'
                }).then(function (response) {
                    $('#doctor_details').modal('show');
                    var table = '<table class="table table-striped table-hover">' +
                        '<tbody>' +
                        '<tr><td class="text-right">Doctor Id:</td><td>'+response[0].doctor_id+'</td></tr>'+
                        '<tr><td class="text-right">Name:</td><td>'+response[0].doctor_name+'</td></tr>'+
                        '<tr><td class="text-right">Address:</td><td>'+response[0].doctor_address+'</td></tr>'+
                        '<tr><td class="text-right">Territory:</td><td>'+response[0].territory+'</td></tr>'+
                        '<tr><td class="text-right">Email:</td><td>'+response[0].email_id+'</td></tr>'+
                        '<tr><td class="text-right">Mobile:</td><td>'+response[0].mobile_no+'</td></tr>'+
                        '</tbody>' +
                        '</table>';
                    $('#info').empty().append(table);
                    console.log(response);
                },function (error) {
                    console.log(error);
                })
            });

            $('#btnCloseModal').on('click',function () {
                $('#doctor_details').modal('hide');
            });

            $('.export').on('click',function () {
               console.log($(this).attr('name'));
               var params = {'type':$(this).attr('name'),_token:'{{csrf_token()}}'};
               window.location = '{{url('rm_portal/dabr_export/')}}'+'/'+JSON.stringify(params);
            });

            // setInterval(function (){
            //     window.location.reload();
            // },10000);

        });
    </script>
@endsection