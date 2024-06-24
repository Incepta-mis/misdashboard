@extends('_layout_shared._master')
@section('title','BEFTN Advice')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.css">
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
            color: orangered;
            padding-right: 25%;
        }
    </style>
@endsection

@section('right-content')
    <form method="post" action="{{url('donation/print_beftn_advice')}}">
{{--    <form method="post">--}}
        {{csrf_field()}}
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <section class="panel" id="data_table">
                    <header class="panel-heading">
                        <label class="text-primary">
                            BEFTN Advice
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12">
                                    @if(Auth::user()->desig === 'GM' || Auth::user()->desig === 'NSM' || Auth::user()->desig === 'SM' ||
                                                Auth::user()->desig === 'DSM' || Auth::user()->desig === 'All'||
                                                Auth::user()->desig === 'HO')
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sum_no"
                                                           class="col-md-3 col-sm-6 control-label"><b>Sum Id</b></label>
                                                    <div class="col-md-9">
                                                        <select name="sum_no" id="sum_no"
                                                                class="form-control input-sm">
                                                            <option value="">Select</option>
                                                            @foreach($sumid as $sum)
                                                                <option value="{{$sum->fi_doc_no}}">Sum No
                                                                    - {{$sum->summ_id}} - Doc No
                                                                    - {{$sum->fi_doc_no}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label for="bank"
                                                           class="col-md-2 col-sm-6 control-label"><b>Bank</b></label>
                                                    <div class="col-md-10">
                                                        <select name="bank" id="bank"
                                                                class="form-control input-sm" required>
                                                            <option value="">Select</option>
                                                            @foreach($bank as $bk)
                                                                 <option value='{"fn": "{{$bk->full_name}}","sn":"{{$bk->short_name}}","em":"{{$bk->email}}","acno":"{{$bk->account_no}}","bn":"{{$bk->branch_name}}","ct":"{{$bk->city}}","adr":"{{$bk->address}}"}'>
                                                                    AN - {{$bk->account_no}} - SN - {{$bk->short_name}}
                                                                    - FN - {{$bk->full_name}} - BN
                                                                    - {{$bk->branch_name}}- CITY
                                                                    - {{$bk->city}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
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
                                <table id="bank_info" class="table table-condensed table-striped table-bordered"
                                       width="100%">
                                    <thead style="white-space:nowrap;">
                                    <tr>
                                        <th>Short Name</th>
                                        <th>Full Name</th>
                                        <th>Account No</th>
                                        <th>Address</th>
                                        <th>Branch</th>
                                        <th>City</th>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-2">
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                            <button type="button" id="show_beftn_data" class="btn btn-default btn-sm">
                                <i class="fa fa-check"></i> <b>Show BEFTN Data</b></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-offset-3 col-sm-offset-2 col-md-12 col-sm-2 col-xs-6">
                            <div class="col-md-6">Account No</div>
                            <div class="col-md-2"><input id="ac_check" name="ac_check" type="checkbox"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="sum_portion" style="display: none; padding-top: 10px;">
            <div class="panel-body">
                <div class="col-sm-12 col-md-12">
                    <div class="col-sm-3 col-md-2"><label>Total No Of Req</label></div>
                    <div class="col-sm-3 col-md-2"><input id="req_num" value="" disabled></div>
                    <div class="col-sm-3 col-md-2"><label>Total Req Amount</label></div>
                    <div class="col-sm-3 col-md-2"><input id="req_amount" value="" disabled></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel-body">
                <div class="col-md-4" id="prepare_button" style="display: none;">
                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                        <button type="button" id="prepare_beftn_advice" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b>Prepare Bank Advice & Payee List Report</b></button>
                    </div>
                </div>
                <div class="col-md-3" id="print_beftn_advice" style="display: none; ">
                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                        <button type="submit" id="print_bank_advice" class="btn btn-default btn-sm" formnovalidate>
                            <i class="fa fa-check"></i> <b>Print/View Bank Advice</b></button>
                    </div>
                </div>
                <div class="col-md-3" id="print_beftn_payee" style=" ">
                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                        <button type="submit" id="print_beftn_payee_list" formaction="{{url('donation/print_beftn_payee')}}"
                                class="btn btn-default btn-sm" formnovalidate >
                            <i class="fa fa-check"></i> <b>Print/View Payee list</b></button>
                    </div>
                </div>
                <div class="col-md-2" id="send_mail_beftn_section" style="display: none; ">
                    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                        <button type="button" id="send_mail_beftn" class="btn btn-default btn-sm">
                            <i class="fa fa-check"></i> <b> Send Mail</b></button>
                    </div>
                </div>
            </div>
        </div>

        @if(Auth::user()->user_id === '1020386' || Auth::user()->user_id === '1016856' || Auth::user()->user_id ===
        '1005975' ||Auth::user()->user_id === '1004184' || Auth::user()->user_id === '1000234' || Auth::user()->user_id === '1007284')
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
                    <div class="col-md-3" id="print_advice_section" >
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                            <button type="submit" id="print_beftn_advice_super" class="btn btn-default btn-sm"
                                    formaction="{{url('donation/print_beftn_advice_super')}}">
                                <i class="fa fa-check"></i> <b>Bank Advice</b></button>
                        </div>
                    </div>
                    <div class="col-md-3" id="print_beftn_payee_section" style="">
                        <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                            <button type="submit" id="print_beftn_payee_list_super"
                                    formaction="{{url('donation/print_beftn_payee_list_super')}}"
                                    class="btn btn-default btn-sm">
                                <i class="fa fa-check"></i> <b>Payee list</b></button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

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
    {{Html::script('public/site_resource/js/dataTables.rowsGroup.js')}}
    {{Html::script('public/site_resource/js/donation_script/beftn_advice_script.js')}}

    <script type="text/javascript">
        beftn_sum_show = "{{url('donation/beftn_sum_show')}}";
        prepare_beftn_advice = "{{url('donation/prepare_beftn_advice')}}";
        print_beftn_advice = "{{url('donation/print_beftn_advice')}}";
        _csrf_token = '{{csrf_token()}}';
        send_mail_beftn = "{{url('donation/send_mail_beftn')}}"

        $("#print_bank_advice").click(function () {
            console.log('print_bank_advice button clicked');
            $("#print_beftn_payee").show();
        });

        $("#print_beftn_payee").click(function () {
            console.log('print_beftn_payee button clicked');
            $("#send_mail_beftn_section").show();
        });

        $('#print_bank_advice').attr('formtarget', '_blank');
        $('#print_beftn_payee_list').attr('formtarget', '_blank');
        $('#print_beftn_payee_list_super').attr('formtarget', '_blank');
        $('#print_beftn_advice_super').attr('formtarget', '_blank');
    </script>

@endsection