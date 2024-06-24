@extends('_layout_shared._master')
@section('title','Employee Competency Graph')
@section('styles')
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

        #criteria > ul > li{
            padding: 15px;
        }

        .border{
            border-bottom: 1px solid grey;
        }

        .highcharts-xaxis-labels{
            height: 450px;
        }

        .lbl_custom{
            padding-left: 0px;
            padding-right: 0px;
            text-align: left;
        }

        @media (min-width: 992px) {
            .col-md-4 {
                width: 30.33333333%;
            }
        }

        .form-group {
            margin-bottom: 0px;
        }
        table#ratingTab{
            /*table-layout: fixed;*/
            /*width: 1000px;*/
              width: 810px;
        }

        .table{
            font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;
        }
    </style>
@endsection
@section('right-content')

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <section class="panel" id="data_table">
                <header class="panel-heading">
                <label class="text-primary">
                Employee Rating Graph
                </label>
                </header>
                <div class="panel-body">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-horizontal">
                            <div class="row">
                                <div class="col-md-4" style="margin-right: 0px;">
                                    <div class="form-group">
                                        <label for="" class="col-md-2 control-label lbl_custom"
                                              style="padding-top: 3px;font-size:.9em;" >Company</label>

                                         @if(count($acess_all) > 0)
                                           @if($acess_all[0]->employee_all=='YES')
                                            <div class="col-md-9">
                                                <select name="cid" id="cid" class="form-control input-sm" style="font-size:.8em;">
                                                    <option>Select Company</option>
                                                    @forelse($company as $com)
                                                        <option value="{{$com->sap_com_id}}" data-comidd="{{$com->com_id}}">{{$com->com_name}}</option>

                                                    @empty
                                                        <option value="">No Company Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                            @endif
                                        @else
                                            <div class="col-md-9">
                                                <select name="cid" id="cid" class="form-control input-sm" style="font-size:.8em;" disabled>


                                                    @forelse($company as $com)
                                                        <option value="{{$com->company_code}}" >{{$com->company_name}}</option>
                                                    @empty
                                                        <option value="">No Company Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="col-md-3 control-label lbl_custom"
                                               style="padding-top: 3px;font-size:.9em;">Department</label>

                                         @if(count($acess_all) > 0)
                                            @if($acess_all[0]->employee_all=='YES')
                                            <div class="col-md-9">
                                                <select name="cdept" id="cdept" class="form-control input-sm" style="font-size:.8em;">
                                                    <option value="">Department Name</option>
                                                </select>
                                            </div>
                                            @endif
                                        @else
                                            <div class="col-md-9">
                                                <select name="cdept" id="cdept" class="form-control input-sm" style="font-size:.8em;" disabled>
                                                    @forelse($department as $dept)
                                                        <option value="{{$dept->dept_id}}">{{$dept->dept_name}}</option>
                                                    @empty
                                                        <option value="">No Department Found</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="" class="col-md-3 control-label"
                                               style="padding-top: 3px;font-size:.9em;">Employee</label>
                                        <div class="col-md-9">

                                             @if(count($acess_all) > 0)
                                                @if($acess_all[0]->employee_all=='YES')
                                                    <select name="cemp" id="cemp" class="form-control input-sm" style="font-size:.8em;">
                                                    </select>
                                                @endif 
                                            @else
                                            <select name="cemp" id="cemp" class="form-control input-sm" style="font-size:.8em;">
                                                <!-- <option value="">Loading...</option> -->
                                            </select>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnSubmit" style="display: none;">Display</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12" id="tabContainer" >
            <section class="panel" id="report_panel">
                <div class="panel-body">
                    <div class="col-md-11 col-sm-11 table-responsive" id="empInfo">
                    </div>
                    <div class="col-md-12 col-sm-12 table-responsive">
                        <table class="table table-bordered" id="ratingTab" >
                            <thead>
                               <tr>
                                   <th rowspan="4"  style="padding:35px;color: #424F63;width: 145px;" class="text-center">Criteria</th>
                                   <tr>
                                     <th colspan="10" class="text-center" style="color: #424F63;">Competencies</th>
                                   </tr>
                                    <tr id="trCompCata">
                                       <td style="text-align:center;">Competency Categories</td>
                                   </tr>
                               </tr>
                            </thead>
                            <tbody>
                               <tr>
                                 {{--<td rowspan="8" id="criteria">--}}
                                     {{--<ul class="list-unstyled">--}}
                                         {{--<li class="border">Master</li>--}}
                                         {{--<li class="border">Well Develop</li>--}}
                                         {{--<li class="border">Developing</li>--}}
                                         {{--<li class="border">To be Develop</li>--}}
                                         {{--<li>Poor</li>--}}
                                     {{--</ul>--}}
                                 {{--</td>--}}
                                 <td colspan="11">
                                     <!--Loader -->
                                     <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 55px;padding-bottom: 55px;">
                                         <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                                             <div class="panel">
                                                 <img src="{{url('public/site_resource/images/preloader.gif')}}" width="35px" height="35px"
                                                      alt="Loading Report Please wait..."><br>
                                                 <span><b><i>Please wait...</i></b></span>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- table -->
                                     <div id="container" style="min-width: 310px; height: 600px; margin: 0 auto;display: none;"></div>
                                 </td>
                               </tr>
                            </tbody>
                        </table>

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

    <script type="text/javascript">
        $(document).ready(function() {

                //get dept list based on company
                $('#cid').change(function(){
//                    console.log("kiki");

                    var selected = $('#cid option:selected');
    //                var empid = selected.data('empid');

                    $com_id=selected.data('comidd');

//                    console.log($com_id);

                    $.ajax({
                        type: 'get',
                        url: '{!!URL::to('emp_comp/getDeptList')!!}',
                        data: {'com_id': $com_id},
                        success: function (data) {

//                            console.log(data.department.length);

                            $('#cdept').empty();

                            var op='';
                            op+='<option>Select Department</option>';
                            for(var i=0;i<data.department.length;i++){

                                op+='<option value="'+data.department[i]['id']+'">'+data.department[i]['dept_name']+' <span style="color:green"> ('+data.department[i]['plant_name']+' )  </span> </option>';


                                // op+='<option value="'+data.department[i]['id']+'">'+data.department[i]['name']+' <span style="color:green"> ('+data.department[i]['id']+' )  </span> </option>';
                            }
                            $('#cdept').html(" ");
                            $('#cdept').append(op);
                        },
                        error: function () {

                        }

                    });

                });

                //get emp list based on dept
                $('#cdept').change(function(){
    //                console.log("emp change")
                    $dept_id=$(this).val();

    //                console.log($dept_id);

                    $.ajax({
                        type: 'get',
                        url: '{!!URL::to('emp_comp/getEmpListByDept')!!}',
                        data: {'dept_id': $dept_id},
                        success: function (data) {

    //                        console.log(data.emplist);
    //                        console.log(data.emplist.length);

                            $('#cemp').empty();

                            var op='';
                            op+='<option>Select Employee</option>';
                            for(var i=0;i<data.emplist.length;i++){
                                op+='<option value="'+data.emplist[i]['id']+'">'+data.emplist[i]['name']+'</option>';
                            }
                            $('#cemp').html(" ");
                            $('#cemp').append(op);

                            $('#btnSubmit').css('display', 'initial');
                        },
                        error: function () {

                        }

                    });

                });

        });
    </script>
    <script src="{{url('public/site_resource/chart_js/highcharts.js')}}"></script>
    <script src="{{url('public/site_resource/chart_js/series-label.js')}}"></script>
    <script src="{{url('public/site_resource/chart_js/exporting.js')}}"></script>
    <script src="{{url('public/site_resource/js/custom/ecg_js/ecg_custom.js')}}"></script>
    <script>
         _url_ed = '{{url('emp_comp/er_data')}}';
         _url_rd = '{{url('emp_comp/rtng_data')}}';
    </script>
@endsection