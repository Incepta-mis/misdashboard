@extends("_layout_shared._master")
@section("title","monthly working day")
@section("styles")
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
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
    </style>
@endsection
@section('right-content')
    <!-- Stored in resources/views/layouts/master.blade.php
    -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                    <label class="text-primary">
                        Monthly Working Day
                    </label>
                </header>

                <div class="panel-body">

                    <div class="form-horizontal">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="emp_month"
                                                   class="col-md-6 col-sm-6 control-label">
                                                <b>Sales Report Month:</b></label>

                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <input type="text" id="report_month" class="form-control input-sm"
                                                           value="{{$fdm[0]->mfd}}">
                                                    <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-default" id="cwd">Create Working Day
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-default" id="dwd">Display Working Day
                                        </button>

                                    </div>
                                </div>


                            </div>
                            {{--This script is for displaying the entire table in console on click of display working day button--}}
                            {{--<script>--}}
                                {{--function showRow() {--}}
                                    {{--document.getElementById("showTable").style.display = "";--}}
                                {{--}--}}
                            {{--</script>--}}
                        </div>
                    </div>

                </div>

            </section>
        </div>
    </div>
    <div class="row" id="showTable" style="display: none;">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <table id="twd" width="100%" class="table table-bordered table-condensed table-striped">
                            <thead>
                            <tr>
                                <th>WORKING DATE</th>
                                <th>DAY</th>
                                <th>WORKING DAY STATUS</th>
                                <th>WORKING DAY</th>
                                <th>TOTAL WORKING DAY</th>
                                <th>EDIT</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            
                        </table>
                        </div>
                    {{--This is the update button --}}
                    <div class="col-md-offset-5 col-sm-offset-4 col-md-2 col-sm-2 col-xs-6">
                        <button type="button"  id="btn-update" class="btn btn-default btn-sm" >
                            <i class="fa fa-check"></i> <b>Update</b></button>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @endsection
    @section("footer-content")
    {{date('Y')}} &copy; Incepta Pharmaceuticals Ltd.
@endsection
@section("scripts")
    <script src="{{url('public/site_resource/js/toast/toastr.min.js')}}"></script>
    {{Html::script('public/site_resource/js/jquery.dataTables.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/dataTables.fixedHeader.min.js')}}
    <script>
        $(document).ready(function () {

            var table = "";
            $("#cwd").click(function () {
                console.log($('#report_month').val());
                console.log('blabllasd');

                $.ajax({
                    method: "POST",
                    url: "{{url('repprocess/create_working_day')}}",
                    data: {fdm: $('#report_month').val(), _token: '{{csrf_token()}}'}
                })
                    .done(function (response) {
                        toastr.success(response);
                        console.log(response);
                    });

            });

            $("#dwd").click(function () {
                console.log($('#report_month').val());
                $.ajax({
                    method: "post",
                    url: "{{url('repprocess/display_working_day')}}",
                    data: {fdm: $('#report_month').val(), _token: '{{csrf_token()}}'}
                })
                    .done(function (response) {
                        console.log(response);
                        $('#twd').DataTable().destroy();
                    table =  $('#twd').DataTable(
                            {
                                data: response,
                                columns: [
                                    {data: "wd",className:'wd'},
                                    {data: "day",className:'day'},
                                    {data: "wds",className:'wds'},
                                    {data: "wday",className:'wday'},
                                    {data: "twd",className:'twd'},
                                    {
                                        data: null,
                                        "defaultContent": "<button >Edit</button>"
                                    },
                                ],
                                // "bLengthChange": true,
                                "bPaginate": false,
                                "scrollY": 300,
                            }
                        );
                        $("#showTable").show();
                            table.columns.adjust();

                    });


            });
            // update button actions
            $("#btn-update").click(function () {
                console.log('update button clicked');
                var array=[];
                $('#twd tr:gt(0)').each(function () {

                    var wds = $(this).find('td:eq(2)').html();
                    var val = null;
                    if(wds.indexOf('select') === -1){
                        val = wds;
                    }else{
                        val = $(this).find('td:eq(2)').find('select').val();
                        var data = {wd: $(this).find('td:eq(0)').html(), day: $(this).find('td:eq(1)').html(), wds: val, wday: $(this).find('td:eq(3)').html(), twd: $(this).find('td:eq(4)').html()};
                        array.push(data);
                    }
                   var data1 = $(this).find('td:eq(0)').html()+"|"+$(this).find('td:eq(1)').html()+"|"+val;
                   // console.log(data1);
                });
                if(array.length>0){
                    // console.log(array);
                    $.ajax({
                    method:"post",
                        url:"{{url('repprocess/update_working_day')}}",
                        data: {fdm: $('#report_month').val(),update:array, _token: '{{csrf_token()}}'}
                    })
                        .done(function (response) {
                            console.log(response);
                            toastr.success('Data updated Successfully');
                        }).error(function (error){
                            console.log(error);
                        
                    });
                }
                // shows a message if wds column isn't edited
                else {
                    toastr.error('Please change Working Day Status to update');
                }
                });
               // This method is for making the "Working Day Status" column editable in case of clicking Edit button
            $('#twd tbody').on( 'click', 'button', function () {
                console.log('button clicked');
                var value_wds =  $(this).closest('tr').find('.wds').text();
                // $(this).closest('tr').find('.wds')
                //     .html('<select name="wds"><option value="Y" >Y</option><option value="N">N</option></select>');
                if(value_wds == 'Y'){
                    $(this).closest('tr').find('.wds')
                        .html('<select name="wds" class="wdst"><option value="Y" selected>Y</option><option value="N">N</option></select>');
                }
                else{
                    $(this).closest('tr').find('.wds')
                        .html('<select name="wds" class="wdst"><option value="Y" >Y</option><option value="N" selected>N</option></select>');
                }
            } );

            $(".toggle-btn").click(function () {
                $('#twd').DataTable().columns.adjust();
            });

        });


    </script>
@endsection

