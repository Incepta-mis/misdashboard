@extends('_layout_shared._master')
@section('title','Expense Verify/Approve Report')
@section('styles')
    <link rel="stylesheet" href="{{url('public/site_resource/spinner-btn/ladda-themeless.min.css')}}">
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
    </style>
@endsection
@section('right-content')
    <div class="row">
        <div class=" col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Expense Verify/Approve Report
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        @if(Session::has('message'))
                           <div class="alert alert-info">
                               <p><i class="fa fa-info-circle"></i> <b>{{Session::get('message')}}</b></p>
                           </div>
                        @endif    
                        <form class="form-horizontal" method="post" action="{{url('expense/q_data')}}">
                            {{csrf_field()}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="col-md-6 control-label">Expense Month</label>
                                    <div class="col-md-6">
                                        <select name="emonth" id="emonth" class="form-control">
                                            @foreach($exp_month as $month)
                                                <option value="{{$month->exp_month}}">{{$month->mon}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="" class="col-md-4 control-label">Region</label>
                                    <div class="col-md-8">
                                        <select name="region" id="region" class="form-control">
                                            @if($regions != null)
                                                @foreach($regions as $region)
                                                    <option value="{{$region->rm_terr_id}}">{{$region->rm_terr_id}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->desig == 'RM' || Auth::user()->desig == 'ASM' || Auth::user()->desig == 'HO' )
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label">Verified</label>
                                        <div class="col-md-8">
                                            <select name="vstat" id="vstat" class="form-control">
                                                <option value="">All</option>
                                                <option value="YES">Yes</option>
                                                <option value="NO">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(Auth::user()->desig == 'HO'||Auth::user()->desig == 'All')
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="" class="col-md-5 control-label">Approved</label>
                                        <div class="col-md-7">
                                            <select name="astat" id="astat" class="form-control">
                                                <option value="">All</option>
                                                <option value="YES">Yes</option>
                                                <option value="NO">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-11 col-sm-11">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-9" >
                                        <div class="checkbox" style="margin-left: 15px;">
                                            <label class="chekbox-inline">
                                                <input type="checkbox" name="cgroup[]"
                                                       value="excel" id="excel"
                                                       checked> As Excel
                                            </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="chekbox-inline">
                                                <input type="checkbox" name="cgroup[]"
                                                       value="pdf" id="pdf"> As Pdf
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4 col-md-offset-2"  >
                                        <div style="margin-left: 15px;"><button type="submit" id="btn_submit" class="btn btn-default btn-sm">
                                            <i class="fa fa-check-circle"></i>  <b>Submit</b></button></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </section>
        </div>
    </div>
    @endsection
    @section('footer-content')
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section('scripts')
    <script>

        $(function () {

            var log = console.log.bind(console);
            //report type selection
            $('input[type="checkbox"]').on('change', function () {
                var type = this.value;

                if (type == 'pdf') {
                    $('#btn_submit').attr('formtarget', '_blank');
                }
                else {
                    $('#btn_submit').attr('formtarget', '');
                }
                $('input[name="' + this.name + '"]').not(this).prop('checked', false);
            });

        });

    </script>
@endsection