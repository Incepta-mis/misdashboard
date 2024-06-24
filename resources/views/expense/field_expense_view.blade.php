@extends('_layout_shared._master')
@section('title','Field Expense Reports')
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
        <div class="col-md-offset-3 col-sm-6 col-md-6">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Process Data For Field Expense
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="col-md-12" >
                            <div class="alert alert-success" id="messg" style="display: none;">
                                <p><i class="fa fa-check-circle"></i><b> Process Completed Successfully</b></p>
                            </div>
                            <form action="" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <div class="checkbox">
                                            <label class="chekbox-inline">
                                                <input type="checkbox" name="creptype[]"
                                                       value="expense" class="ptype"
                                                       checked> Expense Data
                                            </label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="chekbox-inline">
                                                <input type="checkbox" name="creptype[]"
                                                       value="summary" class="ptype"> Summary Data
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-md-3 control-label">Exp. Month</label>
                                    <div class="col-md-6">
                                    <select class="form-control" id="expense_month">
                                        @foreach($pmonths as $month)
                                            <option value="{{$month->exp_month}}">{{$month->mon}}</option>
                                        @endforeach
                                    </select></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <button type="button" class="btn btn-primary ladda-button" id="btnProcess" data-style="zoom-in">
                                            <span class="ladda-label">Process</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <div class="row">
        <div class="col-md-offset-3 col-sm-6 col-md-6">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Field Expense Reports
                    </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="post" action="{{url('expense/field_Data')}}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="r_type">Report Type</label>
                                    <div class="col-md-6 ">
                                        <select name="r_type" id="r_type" class="form-control">
                                                <option value="expense">Expense Report</option>
                                                <option value="summary">Summary Report</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="d_type">Department</label>
                                    <div class="col-md-6 ">
                                        <select name="d_type" id="d_type" class="form-control">
                                            <option value="SALES"> SALES</option>
                                            <option value="MSD">MSD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="exp_mon">Exp.
                                        Month</label>
                                    <div class="col-md-6 ">
                                        <select name="exp_mon" id="exp_mon" class="form-control">
                                            @foreach($months as $month)
                                                <option value="{{$month->exp_month}}">{{$month->mon}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <div class="checkbox">
                                            <label class="chekbox-inline">
                                                <input type="checkbox" name="cgroup[]"
                                                       value="excel" id="excel"
                                                       checked> As Excel
                                            </label>
                                          <!--   &nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="chekbox-inline">
                                                <input type="checkbox" name="cgroup[]"
                                                       value="pdf" id="pdf"> As Pdf
                                            </label> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                        <button type="submit" formtarget="" id="btn_display"
                                                class="btn btn-default btn-sm">
                                            <i class="fa fa-check"></i> <b>Submit</b></button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
    <script src="{{url('public/site_resource/spinner-btn/spin.min.js')}}"></script>
    <script src="{{url('public/site_resource/spinner-btn/ladda.min.js')}}"></script>
    <script type="text/javascript">

        //report
        $('input[type="checkbox"]').on('change', function () {
            var type = this.value;

            if (type == 'pdf') {
                $('#btn_display').attr('formtarget', '_blank');
            }
            else {
                $('#btn_display').attr('formtarget', '');
            }

            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });

        // process


        $('#btnProcess').on('click',function () {

            var processType = $('.ptype:checked').val();
            console.log(processType);

            var l = Ladda.create(document.querySelector('#btnProcess'));
            l.start();

            // $('#btn_display').attr('disabled',true);
            $('#messg').hide();

            $.ajax({
                url:"{{url('expense/proc_emp_exp')}}",
                type:"GET",
                data:{exp_mon:$("#expense_month").val(),p_type:processType},
                success:function (response) {
                    if(response.message_status == 'done'){

                        console.log(response);
                        $('#messg').show();

                        setTimeout(function () {
                            // window.location.reload();
                             $('#messg').hide();
                        },5000);

                    }

                    l.stop();
                },
                error:function (error) {
                    console.log(error);
                    l.stop();
                    $('#btn_display').attr('disabled',false);
                }

            });

        });



    </script>
@endsection
