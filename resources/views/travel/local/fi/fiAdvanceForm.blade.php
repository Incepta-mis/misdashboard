<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 28/03/2020
 * Time: 5:20 PM
 */
?>
@extends('_layout_shared._master')
@section('title','Travel FI Advance')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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
            padding: 2px;
            font-size: 11px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
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
            font-size: x-small;
        }

        .emp_info > thead > tr > th {
            text-align: center;
        }

        .cnt {
            text-align: center;
        }

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
        }

        .modal-dialog {
            width: 98%;
            height: 92%;
            padding: 0;
        }

        .modal-content {
            height: 99%;
        }

        .btn.disabled {
            pointer-events: none;
        }

        /* Hiding the checkbox, but allowing it to be focused */
        .badgebox {
            opacity: 0;
        }

        .badgebox + .badge {
            /* Move the check mark away when unchecked */
            text-indent: -999999px;
            /* Makes the badge's width stay the same checked and unchecked */
            width: 27px;
        }

        .badgebox:focus + .badge {
            /* Set something to make the badge looks focused */
            /* This really depends on the application, in my case it was: */

            /* Adding a light border */
            box-shadow: inset 0px 0px 5px;
            /* Taking the difference out of the padding */
        }

        .badgebox:checked + .badge {
            /* Move the check mark back when checked */
            text-indent: 0;
        }

    </style>
@endsection
@section('right-content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel panel-info" id="data_table">
                <header class="panel-heading">
                    <label class="text-default">
                        Travel FI Advance
                    </label>
                </header>

                <div class="panel-body">

                    <div class="row" id="report-body">
                        <form action="{{ route('local.storeFiAdvance') }}" method="post" id="fi_advance_frm">
                            {{ csrf_field() }}
                            <div class="col-sm-12 col-md-12 col-xs-12">
                                <section class="panel" id="data_table">
                                    <div class="row col-sm-12 col-md-12 col-xs-12 text-center" >
                                        <span class="text-center" style="font-size: 20px;"><b><i>Advice No: </i></b><input type="text" readonly="readonly" style="font-size: 19px; background-color: #2ce691" id="advice_no" name="advice_no"></span>
                                    </div>
                                    <div class="panel panel-body">
                                        <div class="table table-responsive">
                                            <table id="example" class="display table table-bordered table-striped table-condensed"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>DOCUMENT_NO</th>
                                                    <th>COM_ID</th>
                                                    <th>COM_NAME</th>
                                                    <th>EMP_ID</th>
                                                    <th>BENEFICIARY_NAME</th>
                                                    <th>BANK_AC_NO</th>
                                                    <th>BANK_NAME</th>
                                                    <th>ROUTING_NO</th>
                                                    <th>AMOUNT</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($emp_info as $key=>$value)
                                                    <tr>
                                                        <td class="text-center"> {{ $key+1  }} </td>
                                                        <td>{{ $value->document_no  }}</td>
                                                        <td>{{ $value->company_id  }}</td>
                                                        <td>{{ $value->company_name  }}</td>
                                                        <td>{{ $value->emp_id  }}</td>
                                                        <td>{{ $value->name  }}</td>
                                                        <td>{{ $value->bank_acc_no  }}</td>
                                                        <td>{{ $value->bank_name  }}</td>
                                                        <td>{{ $value->routing_number  }}</td>
                                                        <td>{{ $value->amount  }}</td>
                                                        <input type="hidden" class="form-control" readonly="readonly" name="document_no[]" value="{{ $value->document_no  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="company_id[]" value="{{ $value->company_id  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="company_name[]" value="{{ $value->company_name  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="emp_id[]" value="{{ $value->emp_id  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="emp_name[]" value="{{ $value->name  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="bank_acc_no[]" value="{{ $value->bank_acc_no  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="bank_name[]" value="{{ $value->bank_name  }}" >
                                                        <input type="hidden" class="form-control" readonly="readonly" name="routing_number[]" value="{{ $value->routing_number  }}">
                                                        <input type="hidden" class="form-control" readonly="readonly" name="amount[]" value="{{ $value->amount  }}" >
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                                <button type="submit" class="btn btn-success text-center btn-save" id="btn_submit"><i class="glyphicon glyphicon-inbox"></i> Save </button>
                            </div>
                        </form>
                    </div>

                </div>


                {{--                <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">--}}
                {{--                    <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">--}}
                {{--                        <div class="panel">--}}
                {{--                            <img src="{{url('public/site_resource/images/preloader.gif')}}"--}}
                {{--                                 alt="Loading Report Please wait..." width="35px" height="35px"><br>--}}
                {{--                            <span><b><i>Please wait...</i></b></span>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


            </section>
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

    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}


    <script type="text/javascript">
        // $('#btn_submit').attr('formtarget', '_blank');

        $(document).ready(function () {
            $('#example').dataTable( {
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'excel', 'pdf'
                // ],
                scrollX: "200px",
                scrollCollapse: true,
                paging: false
            } );

            function randomNumber(len) {
                var randomNumber;
                var n = '';

                var d = new Date();
                var month = d.getMonth()+1;
                var day = d.getDate();

                // var output =  ((''+day).length<2 ? '0' : '') + day + '/' + ((''+month).length<2 ? '0' : '') + month + '/' + d.getFullYear();
                var output =  ((''+day).length<2 ? '0' : '') + day + '' + ((''+month).length<2 ? '0' : '') + month + '' + d.getFullYear();

                for(var count = 0; count < len; count++) {
                    randomNumber = Math.floor(Math.random() * 10);
                    n += randomNumber.toString();
                }
                return output+n;
            }
            document.getElementById("advice_no").value = randomNumber(4);
        });
    </script>



@endsection
