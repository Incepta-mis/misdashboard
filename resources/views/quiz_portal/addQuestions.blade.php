<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 4/10/2019
 * Time: 4:08 PM
 */
?>
@extends('_layout_shared._master')
@section('title','SET QUESTION PAPER')
@section('styles')
    <link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/salert/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/select.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .panel-heading {
            padding: 5px 15px 2px 15px;
            margin-bottom: 0px;
        }

        .form-control {
            border-radius: 0px;
        }

        body {
            color: black;
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


        /*Here starts styling of table section*/
        .table > thead > tr > th {
            padding: 2px;
            font-size: 12px;
        }

        .table > tbody > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        .table > tfoot > tr > td {
            padding: 2px;
            font-size: 11px;
        }

        table tr:nth-child(even) {background-color: #ededed;}

        body {
            color: #000;
        }


    </style>
    <script type="text/javascript">

        function submitForm(){
            var dt1 = document.forms["myForm"]["grp"].value;
            if (dt1 === "") {
                // alert("Date must be filled out");
                swal({
                    type: 'error',
                    text: 'Select Group First!',
                });
                return false;
            }

            var dt2 = document.forms["myForm"]["ques"].value;
            if (dt2 === "") {
                // alert("Date must be filled out");
                swal({
                    type: 'error',
                    text: 'Select Questions!',
                });
                return false;
            }
        }

    </script>

@endsection
@section('right-content')

    <div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Set Question Paper
                    </label>
                </div>
                <div class="panel-body" style="padding-top: 2%">

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Success!</strong> {{ session()->get('message') }}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Error!</strong> {{ session()->get('error') }}
                        </div>
                    @endif

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <form method="post" id="myForm" action="{{ url('quiz/storeQuestions') }}" enctype="multipart/form-data">
                                    {{ csrf_field() }}


                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class='col-sm-6 col-md-6'>
                                                <div class="form-group">
                                                    <label for="region"
                                                           class="col-md-2 col-sm-2 control-label"><b>Group:</b></label>
                                                    <div class="col-md-10 col-sm-10">
                                                        <select name="grp" id="grp"
                                                                class="form-control input-sm grp">
                                                            <option value="">Select Group</option>
                                                            @foreach($grpInfo as $l)
                                                                <option value="{{$l->group_id}}">{{$l->group_id}}
                                                                    - {{$l->group_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class='col-sm-6 col-md-6'>
                                                <div class="form-group">
                                                    <input type='button' value='+ Add' class="btn btn-primary btn-sm "
                                                           id='addButton'>
                                                    <input type='button' value='- Remove'
                                                           class="btn btn-primary btn-sm "
                                                           id='removeButton'>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">


                                            <div id="addnRow" class="table table-responsive">

                                            </div>


                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <label for="mrk"
                                                           class="control-label"><b>Total Mark:</b></label>
                                                     <input type="text" name="t_mrk">
                                                    <button type="submit" class="btn btn-default" id="getButtonValue" onclick="return submitForm();">Submit</button>
                                                </div>
                                                <div class='col-sm-6 col-md-6'>
                                                <div class="form-group">
                                                    <input type='button' value='+ Add' class="btn btn-primary btn-sm "
                                                           id='addButton'>
                                                    <input type='button' value='- Remove'
                                                           class="btn btn-primary btn-sm "
                                                           id='removeButton'>
                                                </div>
                                            </div>
                                            </div>


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
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-success">
                <div class="panel-heading">
                    <label class="text-default">
                        View Question Paper
                    </label>
                </div>
                <div class="panel-body hd" style="padding-top: 2%">
                    <div class="form-horizontal">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <label for="comp"
                                                   class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Group</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select name="grp_id" id="grp_id"
                                                        class="form-control input-sm grp">
                                                    <option value="">Select Group</option>
                                                    @foreach($grpInfo as $l)
                                                        <option value="{{$l->group_id}}">{{$l->group_id}}
                                                            - {{$l->group_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-5 col-sm-5">
                                            <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
                                                <button type="button" id="btn_submit" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i> <b>Display Questions</b></button>
                                            </div>
                                            <div class="col-md-offset-4 col-sm-offset-4 col-md-2 col-sm-2 col-xs-4">
                                                <div id="export_buttons">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-12 col-sm-12" id="loader" style="display: none; margin-top: 5px;">
            <div class="col-md-4 col-sm-4 col-md-offset-4 text-center">
                <div class="panel">
                    <img src="{{url('public/site_resource/images/preloader.gif')}}"
                         alt="Loading Report Please wait..." width="35px" height="35px"><br>
                    <span><b><i>Please wait...</i></b></span>
                </div>
                <div class="col-md-offset-6 col-sm-offset-6 col-md-2 col-sm-2 col-xs-6">
                    <div id="export_buttons">

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div id="showTable" style="display: none;">
                <div class="col-sm-12 col-md-12">
                    <section class="panel" id="data_table">
                        <div class="panel-body">
                            <div class="col-md-12 col-sm-12 table-responsive">
                                <table id="elr" width="100%" class="table table-bordered table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>GROUP_ID</th>
                                        <th>Q_ID</th>
                                        <th>QUES_TEXT</th>
                                        <th>QUES_A</th>
                                        <th>QUES_B</th>
                                        <th>QUES_C</th>
                                        <th>QUES_D</th>
                                        <th>QUES_TRUE</th>
                                        <th>QUES_FALSE</th>
                                        <th>CORRECT_ANSWER</th>
                                        <!-- <th>QUES_ANSWER</th> -->
                                        {{--<th>QUIZ MARK</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
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
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}
    {{Html::script('public/site_resource/js/salert/sweetalert2.min.js')}}

    <script type="text/javascript">
        $(function () {
            $(document).ready(function () {
                $('#example').DataTable({
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "searching": false,
                });
            });

            var counter = 0;
            $("#addMe").on('click', function () {
                counter++;
                console.log($(".auto_id").val(counter));

            });


        });


        $(document).ready(function () {

            var counter = 1;


            $("#addButton").click(function () {

                // if (counter > 10) {
                //     alert("Only 10 textboxes allow");
                //     return false;
                // }



                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("id", 'TextBoxDiv' + counter);


                newTextBoxDiv.after().html('<table id="example" class="table table-bordered table-striped" width="100%">' +
                    '<tr>\n' +
                        '<td>Q.No.</td>\n' +
                        '<td><b"><input type="text" id="q_id" name="q_id" \n' +
                        'readonly value="'+counter+'"></b>\n' +
                        '</td>\n' +
                        '<td colspan="12"><input type="text" name="ques[]"\n' +
                        'class="form-control input-sm"></td colspan="4">\n' +
                    '</tr>\n' +
                    '<tr>\n' +
                        '<td>A</td>\n' +
                        '<td><input type="text" name="A[]"></td>\n' +
                        '<td>B</td>\n' +
                        '<td><input type="text" name="B[]"></td>\n' +
                        '<td>C</td>\n' +
                        '<td><input type="text" name="C[]"></td>\n' +
                        '<td>D</td>\n' +
                        '<td><input type="text" name="D[]"></td>\n' +
                        '<td>Ans</td>\n' +
                        '<td><input type="text" name="Ans[]"></td>\n' +
                        '<td> <fieldset id="group1">\n' +
                    ' True   <input type="checkbox" value="true" name="group1">\n' +
                    ' False  <input type="checkbox" value="false" name="group1">\n' +
                    '  </fieldset></td>' +
                    '</tr></table>');

                newTextBoxDiv.appendTo("#addnRow");

                counter++;





            });

            $("#removeButton").click(function () {
                if (counter == 1) {
                    alert("No more textbox to remove");
                    return false;
                }

                counter--;

                $("#TextBoxDiv" + counter).remove();

            });

            // $("#getButtonValue").click(function (e) {
            //
            //
            //     var titles = [];
            //     $('input[name^=A]').each(function(){
            //         titles.push($(this).val());
            //     });
            //     console.log(titles);
            //     // return false;
            //
            // });
        });



        $('#btn_submit').on('click', function (e) {
            e.preventDefault();
            $("#loader").show();
            var grp_id = $('#grp_id').val();
            console.log('Submit button Clicked', grp_id);
            var table = null;

            $.ajax({
                type: 'post',
                url: '{!! URL::to('quiz/getQuestionsAll') !!}',
                data: {'grp_id': grp_id,'_token': "{{ csrf_token() }}" },
                success: function (data) {

                    console.log('table data = ',data);

                    $("#showTable").show();
                    $("#loader").hide();

                    $("#elr").DataTable().destroy();
                    table = $("#elr").DataTable({
                        // dom: 'Bfrtip',
                        // buttons: [
                        //     {
                        //         text: '<button class="btn btn-success btn-xs" type="button"><i class="fa fa-plus"></i> Add </button>',
                        //         action: function ( e, dt, node, config ) {
                        //             $("#myModal").modal('show');
                        //         }
                        //     }
                        // ],
                        data: data,
                        columns: [
                            {data: "group_id"},
                            {data: "ques_id" },
                            {data: "ques_text" , className:"editable"},
                            {data: "ques_a" , className:"editable"},
                            {data: "ques_b" , className:"editable"},
                            {data: "ques_c" , className:"editable"},
                            {data: "ques_d" , className:"editable"},
                            {data: "ques_true" , className:"editable"},
                            {data: "ques_false" , className:"editable"},
                            {data: "ques_answer" , className:"editable"},
                            // {data: "quiz_mark" , className:"editable"}
                        ],
                        language: {
                            "emptyTable": "No Matching Records Found."
                        },
                        info: true,
                        paging: false,
                        filter: true
                    });


                    table.fixedHeader.enable();
                    new $.fn.dataTable.Buttons(table, {
                        buttons: [
                            {
                                extend: 'collection',
                                text: '<i class="fa fa-save"></i> Save As <span class="caret"></span>',
                                buttons: [
                                    {
                                        extend: 'excel',
                                        text: 'Save As Excel',
                                        footer: true,
                                        action: function (e, dt, node, config) {
                                            exportExtension = 'Excel';
                                            $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, node, config);
                                        }
                                    }, {
                                        extend: 'pdf',
                                        text: 'Save As PDF',
                                        orientation: 'landscape',
                                        footer: true,
                                        action: function (e, dt, node, config) {
                                            exportExtension = 'PDF';
                                            $.fn.DataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, node, config);
                                        }
                                    }
                                ],
                                className: 'btn btn-sm btn-primary'
                            }
                        ]
                    }).container().appendTo($('#export_buttons'));

                },
                error: function (e) {
                    console.log(e);
                    $("#loader").hide();
                    $("#showTable").show();
                }
            });
        });

        // Inline editing
        var oldValue = null;
        var group_id   = null;
        var colName  = null;
        var tblrowId = null;
        var clcolName = null;
        var ques_id = null;
        $(document).on('dblclick', '.editable', function(){

            oldValue = $(this).html();
            $(this).removeClass('editable');	// to stop from making repeated request
            $(this).html('<input type="text" style="width:150px;" class="update" value="'+ oldValue +'" />');
            $(this).find('.update').focus();

            group_id  = $(this).parent().find('td').html().trim();
            clcolName = $('#elr thead tr th').eq($(this).index()).html().trim();
            tblrowId  = $(this).closest('tr').index();
            ques_id  =  $(this).parent().find('td').eq(1).html().trim();

            // alert('Row index: ' + $(this).closest('tr').index());
            // alert('Data:'+$(this).html().trim());
            // alert('Row:'+$(this).parent().find('td').html().trim());
            // alert('Column:'+$('#elr thead tr th').eq($(this).index()).html().trim());

        });

        var newValue = null;
        $(document).on('blur', '.update', function(){
            var elem    = $(this);
            newValue 	= $(this).val();
            group_id	= group_id;
            tblrowId	= tblrowId;
            ques_id	= ques_id;
            colName	    = clcolName;

            // var empId	= $(this).parent().attr('id');
            // var colName	= $(this).parent().attr('name');
            // console.log(elem,'-',empId,'-',colName);

            if(newValue != oldValue)
            {
                $.ajax({
                    url : '{{ url("quiz/QuesUpdate") }}',
                    method : 'post',
                    data :
                        {
                            group_id    : group_id,
                            tblrowId    : tblrowId,
                            colName    : colName,
                            ques_id    : ques_id,
                            newValue   : newValue,
                            '_token'   : '{{csrf_token()}}',
                        },
                    success : function(respone)
                    {
                        // console.log('Update Value = ',respone);
                        $(elem).parent().addClass('editable');
                        $(elem).parent().html(newValue);
                        if (respone.success) {
                            toastr.success(respone.success, '', {timeOut: 2000})
                        }
                        else {
                            toastr.error(respone.error, 'No update', {timeOut: 2000});
                        }
                    }
                });
            }
            else
            {
                $(elem).parent().addClass('editable');
                $(this).parent().html(newValue);
            }
        });
        // end inline editing


    </script>

@endsection
