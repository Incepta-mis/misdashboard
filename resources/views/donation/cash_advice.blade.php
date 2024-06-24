@extends('_layout_shared._master')
@section('title','Cash Advice')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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
    </style>
@endsection

@section('right-content')
    <form method="post" action="{{url('donation/print_summary')}}">
        {{csrf_field()}}
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Cash Advice
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">

                                    @if( Auth::user()->desig === 'All'||
                                                Auth::user()->desig === 'HO')

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sum_no"
                                                           class="col-md-4 col-sm-6 control-label"><b>FI Doc No</b></label>
                                                    <div class="col-md-8">
                                                        <select name="sum_no" id="sum_no"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            @foreach($sumid as $sum)
                                                                <option value="{{$sum->fi_doc_no}}">Sum No - {{$sum->summ_id}} - Doc - {{$sum->fi_doc_no}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="ver_employee"
                                                           class="col-md-3 col-sm-6 control-label"><b>Name</b></label>
                                                    <div class="col-md-9">
                                                        <select name="ver_employee" id="ver_employee"
                                                                class="form-control input-sm" required>
                                                            <option value="">Select</option>
                                                            @foreach($employee as $bk)
                                                                <option value="{{$bk->user_id}}">{{$bk->name}} </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="depot"
                                                           class="col-md-3 col-sm-6 control-label"><b>Depot</b></label>
                                                    <div class="col-md-9">
                                                        <select name="depot" id="depot"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            <option value="ALL">ALL</option>
                                                            @foreach($depot as $bk)
                                                                <option value="{{$bk->depot_id}}">
                                                                    DID - {{$bk->depot_id}} - DN - {{$bk->depot_name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-1">
                                                <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                    <button type="button" id="btn_display" class="btn btn-default btn-sm">
                                                        <i class="fa fa-check"></i> <b>Display</b></button>
                                                </div>
                                            </div>


                                        </div>

                                    @endif


                                </div>
                            </div>
                        </div>
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
                                <table id="depo_info" class="table table-condensed table-striped table-bordered"
                                       width="100%">
                                    <thead style="white-space:nowrap;">
                                    <tr>
                                        <th>Depot ID </th>
                                        <th>Depot Name</th>
                                        <th>Terr Id</th>
                                        <th>No of Req</th>
                                        <th>Amount</th>
                                        <th>Detail</th>

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


            {{--<div class="row">--}}
                {{--<div class="col-md-12">--}}

                    {{--<div class="col-md-2">--}}
                        {{--<div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">--}}
                            {{--<button type="button" id="show_cash" class="btn btn-default btn-sm">--}}
                                {{--<i class="fa fa-check"></i> <b>Display Data</b></button>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}

        </div>


    {{--</form>--}}

    {{--<div class="row" id="sum_detail" style="display: none; padding-top: 10px;">--}}

        {{--<div class="col-md-3">--}}
            {{--<div class="form-group">--}}
                {{--<label for="Id_select"--}}
                       {{--class="col-md-5 col-sm-6 control-label"><b>Sum ID</b></label>--}}
                {{--<div class="col-md-7">--}}
                    {{--<select name="Id_select" id="Id_select"--}}
                            {{--class="form-control input-sm">--}}
                        {{--<option value="">Select</option>--}}

                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-sm-3 col-md-2"> <button type="button" id="btn_sum_dis" class="btn btn-default btn-sm">--}}
                {{--<i class="fa fa-check"></i> <b>Display</b></button></div>--}}

    {{--</div>--}}


    <div class="row" id="detail-body" style="display: none; padding-top: 10px;">
        <div class="">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="detail_list" class="table table-condensed table-striped table-bordered"
                                   width="100%">
                                <thead style="white-space:nowrap;">
                                <tr>
                                    <th>Depot ID</th>
                                    <th>Req ID</th>
                                    <th>Terr ID</th>
                                    <th>Doc Name</th>
                                    <th>In Favour Of</th>
                                    <th>Approved Amount</th>
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


    <div class="row">
    <div class="panel-body">

    <div class="col-md-4" id="prepare_button" style="display: none;">
    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
    <button type="button" id="save_button" class="btn btn-default btn-sm">
    <i class="fa fa-check"></i> <b>Process</b></button>
    </div>
    </div>


    <div class="col-md-3" id="print_advice" style="display: none; ">
    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
    <button type="submit" id="print_button" class="btn btn-default btn-sm">
    <i class="fa fa-check"></i> <b>Print/View </b></button>
    </div>
    </div>

    <div class="col-md-3" id="print_payee" style="display: none; ">
    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
    <button type="button" id="send_mail"  class="btn btn-default btn-sm">
    <i class="fa fa-check"></i> <b>Send Mail</b></button>
    </div>
    </div>

    </div>
    </div>
{{--    </form>--}}
        @if(Auth::user()->user_id === '1016856' || Auth::user()->user_id === '1005975'||Auth::user()->user_id === '1004184'||Auth::user()->user_id === '1000234' || Auth::user()->user_id === '1007284')
{{--<form method="post">--}}
{{--        {{csrf_field()}}--}}

            <div class="row">
                <div class="panel-body">

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="ref_no"
                                   class="col-md-3 col-sm-6 control-label"><b>Ref No</b></label>
                            <div class="col-md-9">
                                <select name="ref_no" id="ref_no"
                                        class="form-control input-sm" required>
                                    <option value="">Select</option>
                                    @foreach($refno as $ref)
                                        <option value="{{$ref->ref_no}}">Sum No
                                            - {{$ref->summ_id}} - Ref No
                                            - {{$ref->ref_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" id="print_summary" style="">
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                            <button type="submit" id="print_summary_super" class="btn btn-default btn-sm" formaction="{{url('donation/print_summary_super')}}" >
                                <i class="fa fa-check"></i> <b>Summary Print</b></button>
                        </div>
                    </div>


                </div>
            </div>

        @endif
</form>


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
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{--{{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}--}}

    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}

    {{Html::script('public/site_resource/js/donation_script/cash_advice_script.js')}}


    <script type="text/javascript">

        depot_detail = "{{url('donation/depot_detail')}}";
        det_process = "{{url('donation/det_process')}}";
        save_proc = "{{url('donation/save_proc')}}";
        print_summary = "{{url('donation/print_summary')}}";
        send_mail_cash = "{{url('donation/send_mail_cash')}}"

        _csrf_token = '{{csrf_token()}}';


        $("#print_button").click(function () {

            console.log('print_advice button clicked');

            $("#print_payee").show();

        });

        // $("#print_summary_super").click(function () {
        //
        //     console.log('print_summary_super button clicked');
        //     if ($("#ref_no").val()==''){
        //         toastr.alert("Please select Reference No");
        //     }
        //     else {
        //         $('#print_summary_super').attr('formtarget', '_blank');
        //     }
        //
        //     $("#print_payee").show();
        //
        // });

        $('#print_button').attr('formtarget', '_blank');

        $('#print_summary_super').attr('formtarget', '_blank');




    </script>

@endsection