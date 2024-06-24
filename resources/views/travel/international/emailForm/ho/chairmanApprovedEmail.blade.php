<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 08/09/2020
 * Time: 3:06 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Requisition - International Approved ')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/select2/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>

    <link href="{{ url('public/site_resource/css/datepicker3.css')}}" rel="stylesheet" type="text/css"/>



    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
            font-size: x-small;
        }

        .input-group-addon {
            border-radius: 0px;
        }

        .table > thead > tr > th {
            padding: 2px;
            font-size: 10px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 10px;
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

        input {
            color: black;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }

        /*.hd {*/
        /*height: 100% !important;*/
        /*min-height: 786px;*/
        /*}*/

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .modal {

        }

        .modal-dialog {
            width: 90%;
            height: 90%;

        }

        .vertical-alignment-helper {
            display: table;
            height: 100%;
            width: 100%;
        }

        .vertical-align-center {
            /*To center vertically */
            display: table-cell;
            vertical-align: middle;
        }

        .modal-content {
            height: auto;
            /*min-height: 100%;*/
            border-radius: 0;
            /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
            width: inherit;
            height: inherit;
            /* To center horizontally */
            margin: 0 auto;
        }

        .form-control {
            height: 24px;

        }


    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Travel Approved
                    </label>
                </header>

                <div class="panel-body">
                    <div class="table table-responsive">
                        <table id="example" class="display table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th style="display: none;"></th>
                                <th style="display: none;"></th>
                                <th style="display: none;"></th>
                                <th style="display: none;"></th>
                                <th>Emp ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Appr.Name</th>
                                <th>Accept</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rs as $data)

                                {{-- {{ dd($data) }} --}}

                                <tr>


                                    <td class="line_id" style="display: none;">{{$data->id}}</td>
                                    <td class="document_no" style="display: none;">{{ $data->document_no }}</td>
                                    <td class="emp_id" style="display: none;"> {{ $data->emp_id }}  </td>
                                    <td class="emp_name" style="display: none;"> {{ $data->emp_name }}  </td>

                                    <td >{{$data->emp_id}}</td>
                                    <td >{{$data->emp_name}}</td>
                                    <td > {{ $data->location }}</td>
                                    <td > {{ $data->accept_name }}</td>
                                    @if($data->plant_id != '1000')
                                        <td>
                                            @if( $data->plant_head_accept == 'NO' ) <span class="label label-danger">Not Approved</span>
                                            @elseif( $data->plant_head_accept == '' ) <span
                                                    class="label label-warning">Pending</span>
                                            @elseif( $data->plant_head_accept == 'YES' ) <span
                                                    class="label label-success">Accepted</span>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            @if( $data->dept_accept == 'NO' ) <span class="label label-danger">Not Approved</span>
                                            @elseif( $data->dept_accept == '' ) <span
                                                    class="label label-warning">Pending</span>
                                            @elseif( $data->dept_accept == 'YES' ) <span
                                                    class="label label-success">Accepted</span>
                                            @endif
                                        </td>
                                    @endif


                                    <td>
                                        @if( ($data->chairman_sir_accept == 'NO') || ($data->chairman_madam_accept == 'NO') ) <span class="label label-danger">Not Approved</span>
                                        @elseif( ($data->chairman_sir_accept == '') && ($data->chairman_madam_accept == '') ) <span
                                                class="label label-warning">Pending</span>
                                        @elseif( ($data->chairman_sir_accept == 'YES') || ($data->chairman_madam_accept == 'YES') ) <span
                                                class="label label-success">Accept</span>
                                        @endif
                                    </td>
                                    <td>

                                        @if( ($data->chairman_sir_accept == '') && ($data->chairman_madam_accept == '') )
                                            <button type='button' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'>view</span>   </button>
                                            <button type='button' class='btn btn-success btn-xs accept' id='accept'><span class='glyphicon glyphicon-ok'></span>  </button>
                                            <button type='button' class='btn btn-danger btn-xs reject' id='reject'><span class='glyphicon glyphicon-remove'></span>  </button>
                                        @elseif( ($data->chairman_sir_accept == 'YES') || ($data->chairman_madam_accept == 'YES') )
                                            <button type='button' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'>view</span>   </button>
                                            <button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>
                                            <button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>
                                        @elseif( ($data->chairman_sir_accept == 'NO') || ($data->chairman_madam_accept == 'NO') )
                                            <button type='button' class='btn btn-info btn-xs edit-btn'><span class='glyphicon glyphicon-edit'>view</span>   </button>
                                            <button  class='btn btn-success btn-xs acpt disabled'><span class='glyphicon glyphicon-ok'></span>  </button>
                                            <button  class='btn btn-danger btn-xs rejt disabled'><span class='glyphicon glyphicon-remove'></span>  </button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
        <div class="modal-dialog modal-sm" role="document"
             style="width:250px; height: 250px;position: absolute; left: 50%;top: 50%;transform: translate(-50%, -50%); ">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div id="loaderWait">
                        <img src="{{url('public/site_resource/images/MadeupWillingKronosaurus-small.gif')}}"
                             alt="Loading Please wait..." width="200px" height="200px"><br>
                        <span><b><i>Please wait...</i></b></span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="myModal" class="modal fade">
        <div class="modal-dialog">

            {{--<form method="post" role="form" action="{{ url('elm_portal/masterpleaveapp') }}" id="edfrm">--}}
            <form role="form" id="edfrm">
                {{ csrf_field() }}

                <div class="modal-content">
                    <div class="modal-body">



                        <div class="container tbs"><h2>INCEPTA PHARMACEUTICALS LTD.</h2>
                            <p>TRAVEL DETAILS</p>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td colspan="2"> <span id="emp_name"> </span></td>
                                    <td>Emp Code</td>
                                    <td colspan="2"> <span id="emp_id"> </span> </td>
                                </tr>
                                <tr>
                                    <td>Designation</td>
                                    <td colspan="2"> <span id="desig_name"> </span> </td>
                                    <td>Department</td>
                                    <td colspan="2"><span id="dept_name"> </span> </td>
                                </tr>
                                <tr>
                                    <td>Passport Number</td>
                                    <td> <span id="passport_no"> </span> </td>
                                    <td>Issue Date</td>
                                    <td> <span id="date_of_issue"> </span> </td>
                                    <td>Expiry Date</td>
                                    <td> <span id="date_of_expiry"> </span> </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td colspan="2"> <span id="emp_email"> </span> </td>
                                    <td>Mobile No.</td>
                                    <td colspan="2"> <span id="emp_mobile"> </span> </td>
                                </tr>
                                <tr>
                                    <td>GL</td>
                                    <td colspan="2"> <span id="gl_code"> </span> </td>
                                    <td>Cost Center</td>
                                    <td colspan="2"> <span id="cost_center_name"> </span> </td>
                                </tr>
                                <tr>
                                    <td>Travel Type</td>
                                    <td colspan="2"> <span id="travel_type"> </span> </td>
                                    <td>Purpose.</td>
                                    <td colspan="2"> <span id="purpose"> </span> </td>
                                </tr>
                                <tr>
                                    <td>Hotel Rent Born By</td>
                                    <td colspan="1">

                                        <div id='list'>
                                            <input type='checkbox' value='Company' readonly /> Company
                                            <input type='checkbox' value='Vendor' readonly />  Vendor
                                            <input type='checkbox' value='Others' readonly />  others
                                        </div>


                                    </td>
                                    <td>Meal Expense Born By</td>
                                    <td colspan="1">

                                        <div id='list2'>
                                            <input type='checkbox' value='Company' readonly /> Company
                                            <input type='checkbox' value='Vendor' readonly />  Vendor
                                            <input type='checkbox' value='Others' readonly />  others
                                        </div>

                                    </td>
                                    <td>Transport Born By</td>
                                    <td colspan="1">

                                        <div id='list3'>
                                            <input type='checkbox' value='Company' readonly /> Company
                                            <input type='checkbox' value='Vendor' readonly />  Vendor
                                            <input type='checkbox' value='Others' readonly />  others
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: center"><b>PERIOD & ROUTE DETAILS</b></td>
                                </tr>
                                <tr>

                                    <td colspan="6" style="padding-bottom: 0px; padding-top: 0px;">
                                        <table class="table table-bordered" id="ttable">


                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: center"><b>EXPENSE GL,CC & CWIP ASSET RELATED
                                            INFO</b></td>
                                </tr>
                                <tr>
                                    <td>MRP NO</td>
                                    <td colspan="2">
                                        <span id="mrp_no"></span>
                                    </td>
                                    <td>DATE</td>
                                    <td colspan="2">
                                        <span id="mrp_date"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SAP PR NO</td>
                                    <td colspan="2">
                                        <span id="sap_pr_no"></span>
                                    </td>
                                    <td>DATE</td>
                                    <td colspan="2">
                                        <span id="sap_pr_date"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>L/C NO</td>
                                    <td colspan="2">
                                        <span id="lc_no"></span>
                                    </td>
                                    <td>DATE</td>
                                    <td colspan="2">
                                        <span id="lc_date"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>PO NO</td>
                                    <td colspan="2">
                                        <span id="po_no"></span>
                                    </td>
                                    <td>DATE</td>
                                    <td colspan="2">
                                        <span id="po_date"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CWIP ASSET NO</td>
                                    <td colspan="2">
                                        <span id="cwip_asset_no"></span>
                                    </td>
                                    <td>CWIP ASSET NAME</td>
                                    <td colspan="2">
                                        <span id="cwip_asset_name"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>



                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>


    </div>



    @endsection

    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/bootstrap-datepicker.js')}}
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

        $("#example").DataTable({});


        //view details
        $(document).on("click",".edit-btn",function() {

            $("#example").DataTable().destroy();
            var table = $("#example").DataTable({});
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'accept';
            var id = data[0];
            var document_no = data[1];






            console.log(document_no);

            $("#myModal").modal('show');
            // var line_id = $(this).data('id');
            $(".modal-body #line_id").val(document_no);



            $.ajax({
                type: "post",
                url: "{{route('international.getInfoByDocumentNo')}}",
                data: {document_no: document_no, '_token': '{{csrf_token()}}'},
                success: function (data) {

                    console.log(data);

                    $('#emp_name').text(data[0].emp_name);
                    $('#emp_id').text(data[0].emp_id);
                    $('#desig_name').text(data[0].desig_name);
                    $('#dept_name').text(data[0].dept_name);
                    $('#passport_no').text(data[0].passport_no);
                    $('#date_of_issue').text(data[0].date_of_issue);
                    $('#date_of_expiry').text(data[0].date_of_expiry);
                    $('#gl_code').text(data[0].gl_code);
                    $('#cost_center_name').text(data[0].cost_center_name);
                    $('#travel_type').text(data[0].travel_type);
                    $('#purpose').text(data[0].purpose);
                    $('#emp_email').text(data[0].emp_email);
                    $('#emp_mobile').text(data[0].emp_mobile);



                    // var values = ['company','vendor'];
                    var values = [];

                    if(data[0].hotel_company !== null ){
                        values.push( data[0].hotel_company );
                    }
                    if(data[0].hotel_vendor !== null ){
                        values.push( data[0].hotel_vendor );
                    }
                    if(data[0].hotel_others !== null ){
                        values.push( data[0].hotel_others );
                    }

                    $('#list [value="'+values.join('"],[value="')+'"]').prop('checked',true);


                    var values2 = [];

                    if(data[0].meal_company !== null ){
                        values2.push( data[0].meal_company );
                    }
                    if(data[0].meal_vendor !== null ){
                        values2.push( data[0].meal_vendor );
                    }
                    if(data[0].meal_others !== null ){
                        values2.push( data[0].meal_others );
                    }

                    $('#list2 [value="'+values2.join('"],[value="')+'"]').prop('checked',true);


                    var values3 = [];

                    if(data[0].transport_company !== null ){
                        values3.push( data[0].meal_company );
                    }
                    if(data[0].transport_vendor !== null ){
                        values3.push( data[0].meal_vendor );
                    }
                    if(data[0].transport_others !== null ){
                        values3.push( data[0].meal_others );
                    }

                    $('#list3 [value="'+values3.join('"],[value="')+'"]').prop('checked',true);

                    $('#ttable').empty().append('<tr>\n' +
                        '                                                <td colspan="2" style="text-align: center"><strong>DATE</strong></td>\n' +
                        '                                                <td colspan="4" style="text-align: center"><strong>ROUTE</strong></td>\n' +
                        '                                            </tr>\n' +
                        '                                            <tr>\n' +
                        '                                                <td colspan="1" style="text-align: center"><strong>FROM</strong></td>\n' +
                        '                                                <td colspan="1" style="text-align: center"><strong>TO</strong></td>\n' +
                        '                                                <td colspan="2" style="text-align: center"><strong>FROM</strong></td>\n' +
                        '                                                <td colspan="2" style="text-align: center"><strong>TO</strong></td>\n' +
                        '                                            </tr>');

                    $.each(data, function (key, val) {
                        $('#ttable').append(
                            '<tr><td colspan="1">'+ val.from_time+' </td>\n' +
                            '<td colspan="1">'+val.to_time+' </td>\n' +
                            '<td colspan="2">'+ val.from_loc+' </td>\n' +
                            '<td colspan="2">'+ val.to_loc+' </td></tr>'
                        );
                    });

                    $('#mrp_no').text(data[0].mrp_no);
                    $('#mrp_date').text(data[0].mrp_date);
                    $('#sap_pr_no').text(data[0].sap_pr_no);
                    $('#sap_pr_date').text(data[0].sap_pr_date);
                    $('#lc_no').text(data[0].lc_no);
                    $('#lc_date').text(data[0].lc_date);
                    $('#po_no').text(data[0].po_no);
                    $('#po_date').text(data[0].po_date);
                    $('#cwip_asset_no').text(data[0].cwip_asset_no);
                    $('#cwip_asset_name').text(data[0].cwip_asset_name);



                }
            });


        });


        $(document).on("click",".accept",function() {

            $("#example").DataTable().destroy();
            var table = $("#example").DataTable({});
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'accept';
            var id = data[0];
            var empID = data[1];
            var self = $(this);

            // console.log(data);
            // alert( 'You clicked on '+data[0]+'\'s row ' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {id: id, st: st, empID : empID},
                url: "{{ route('international.intlTravelChairmanApproved') }}",
                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                    $("#loadMe").modal({
                        backdrop: "static", //remove ability to close modal with click
                        keyboard: false, //remove option to close with keyboard
                        show: true //Display loader!
                    });
                },
                success: function (resp) {
                    // console.log(resp);
                    if (resp.success) {
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        location.reload();
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    $('#loadMe').modal('hide');
                },
                error: function () {

                }
            });
        });

        //for reject button
        $(document).on("click",".reject",function( ){

            $("#example").DataTable().destroy();
            var table = $("#example").DataTable({});
            var closestRow = $(this).closest('tr');
            var data = table.row(closestRow).data();
            var st = 'reject';
            var id = data[0];
            var self = $(this);

            console.log(data);
            // alert( 'You clicked on '+data.id+'\'s row' + st );

            $.ajax({
                type: "GET",
                dataType: 'json',
                data: {id: id, st: st},
                url: "{{ route('international.intlTravelChairmanRejected') }}",
                success: function (resp) {
                    // console.log('rejection data =',resp);
                    if (resp.success) {
                        self.closest('tr').find('.accept').attr('disabled', true);
                        self.closest('tr').find('.reject').attr('disabled', true);
                        toastr.success(resp.success, '', {timeOut: 2000});
                        location.reload();
                        resp = '';
                    } else {
                        toastr.error(resp.error, '', {timeOut: 2000});
                    }
                },
                error: function () {

                }
            });

        });

        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {

                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif


    </script>

@endsection
