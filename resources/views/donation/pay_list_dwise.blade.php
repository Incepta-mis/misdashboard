@extends('_layout_shared._master')
@section('title','Pay List')
@section('styles')
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        body {
            color: #000;
        }

        .shadow{
            box-shadow: 0 3px 3px 0 rgba(0,0,0,0.2)
        }

    </style>
@endsection
@section('right-content')

    <div class="row">
        <form method="post" id="form_plist" target="report_preview" action="{{url('donation/print_paylist_dw')}}">
            {{csrf_field()}}
            <div class="col-sm-12 col-md-12">
                <section class="panel shadow">
                    <header class="panel-heading">
                        <label class="text-primary">
                            Pay List Report
                        </label>
                    </header>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-1">
                                    <label for="month" class="control-label">Month</label>
                                </div>
                                <div class="col-md-2">
                                    <select name="month" id="month" class="form-control input-sm">
                                        <option disabled value="" selected>Please wait..</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="summid" class="control-label">Smry id</label>
                                </div>
                                <div class="col-md-2">
                                    <select name="summid" id="summid" class="form-control input-sm">
                                        <option disabled value="" selected>Please wait..</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="month" class="control-label">Ref.No.</label>
                                </div>
                                <div class="col-md-2">
                                    <select name="refno" id="refno" class="form-control input-sm">
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="region" class="control-label">Region</label>
                                </div>
                                <div class="col-md-2">
                                    <select name="region" id="region" class="form-control input-sm">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12" style="padding-top: 10px;">
                                <div class="col-md-1 col-md-offset-1">
                                    <button type="button" id="btnDisplayPaylist" class="btn btn-sm btn-info"><b>Display
                                            Pay List</b>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
    <div class="row" id="loader" style="display: none;">
        <div class="panel-body">
            <div class="text-center">
                <img src="{{url('public/site_resource/images/c_loading.gif')}}" width="100px" height="100px"
                     alt="content_loading">
                <p class="text-center">Please wait....generating report</p>
            </div>
        </div>
    </div>
    <div class="row" id="ifcontainer" style="display: none;">
        <div class="col-sm-12 col-md-12">
            <section class="panel shadow">
                <div class="panel-body">
{{--                    only for chrome browser--}}
                    <div id="content_area" style="display: none">
                        <form method="post" action="{{url('donation/print_paylist_dw')}}">
                            {{csrf_field()}}
                        <input type="hidden" id="refno_h" name="refno" value="">
                        <input type="hidden" id="region_h" name="region" value="">
                        <input type="hidden" name="atype" value="dl">
                        <button class="pull-right btn btn-sm btn-default" type="submit">
                            Download PDF
                            <i class="fa fa-download"></i>
                        </button>
                        </form>
                    </div>
                    <iframe id="iframe" name="report_preview" width="100%" height="400px" src=""></iframe>
                </div>
            </section>
        </div>
    </div>

    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')

    {{Html::script('public/site_resource/js/donation_script/paylist_dw.script.js')}}
    <script>
        url = '{{url('donation/pl_selection')}}';_token = '{{Session::token()}}';
        desig = "{{Auth::user()->desig}}";
    </script>
@endsection