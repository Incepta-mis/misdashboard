<?php
/**
 * Created by Sublime Text.
 * User: masroor
 * Date: 23/02/2019
 * Time: 00:21 PM
 */
?>
@extends('_layout_shared._master')
@section('title','ELM Master Info')
@section('styles')
	<link href="{{ url('public/site_resource/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{ url('public/site_resource/css/toast/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ url('public/site_resource/css/buttons.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
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

        .fnt_size {
            font-size: 12px;
            text-align: left;
        }

        .input-group-addon {
            border-radius: 0px;
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

        .form-horizontal .control-label {
            padding-top: 3px;
            margin-bottom: 0;
            text-align: left;
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

        body {
            color: #000;
        }
        <style>
		.odd{
			background-color: #FFF8FB !important;
		}
		.even{
			background-color: #DDEBF8 !important;
		}
    </style>
@endsection
@section('right-content')
	<div class="row">
        <div class="col-md-12 col-sm-12" style="padding-top: 1%">
            <section class="panel panel-info">
                <div class="panel-heading">
                    <label class="text-default">
                        Plant Head Infromation
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
                                                   style="padding-right:0px;"><b>Company</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="comp" name="comp"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option selected disabled>Select Company</option>
                                                    @foreach($com as $c)
                                                        <option value="{{$c->com_id}}">{{$c->com_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3">
                                            <label for="plant" class="col-md-3 col-sm-3 control-label fnt_size"
                                                   style="padding-right:0px;"><b>Plant</b></label>
                                            <div class="col-md-9 col-sm-9">
                                                <select id="plant" name="plant"
                                                        class="form-control input-sm filter-option pull-left">
                                                    <option value="">Select Plant</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5 col-sm-5">											
										    <div class="col-md-offset-2 col-sm-offset-2 col-md-2 col-sm-2 col-xs-6">
										        <button type="button" id="btn_submit" class="btn btn-warning btn-sm">
										            <i class="fa fa-eye"></i> <b>Display Report</b></button>
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
		                                    <th>PLANT_ID</th>
		                                    <th>PL_HEAD_NAME</th>
		                                    <th>PL_EMP_ID</th>
		                                    <th>PL_EMAIL</th>		                                                             
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
    <!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Plant Head Master Data</h4>
	      </div>
	      <div class="modal-body">
	        <form class="form-horizontal" id="elm_emp" method="get">
	        	{{ csrf_field() }}
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="plant_id">Plant Id:</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control input-sm" name="plant_id" id="plant_id" placeholder="Enter Plant ID">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="pl_h_name">PL Head Name:</label>
			    <div class="col-sm-10"> 
			      <input type="text" class="form-control input-sm"  name="pl_h_name" id="pl_h_name" placeholder="Enter Plant Head Name">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="e_id">EMP. Id:</label>
			    <div class="col-sm-10"> 
			      <input type="text" class="form-control input-sm" name="e_id" id="e_id" placeholder="Enter Plant Head Employee ID">
			    </div>
			  </div>
			  <div class="form-group">
			    <label class="control-label col-sm-2" for="pl_h_email">PL Head Email:</label>
			    <div class="col-sm-10"> 
			      <input type="text" class="form-control input-sm" name="pl_h_email" id="pl_h_email" placeholder="Enter PL Head Email">
			    </div>
			  </div>
			  
			  <div class="form-group"> 
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-info" id="elm_btn">Submit</button>
			      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			    </div>
			  </div>
			</form>
	      </div>
	      <!-- <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div> -->
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

    {{Html::script('public/site_resource/js/dataTables.buttons.min.js')}}
    {{Html::script('public/site_resource/js/buttons.bootstrap.min.js')}}
    {{Html::script('public/site_resource/js/buttons.flash.min.js')}}

    {{Html::script('public/site_resource/js/jszip.min.js')}}
    {{Html::script('public/site_resource/js/pdfmake.min.js')}}
    {{Html::script('public/site_resource/js/vfs_fonts.js')}}

    {{Html::script('public/site_resource/js/buttons.html5.min.js')}}
    {{Html::script('public/site_resource/dpicker/moment-with-locales.js')}}
    {{Html::script('public/site_resource/dpicker/bootstrap-datetimepicker.js')}}

    <script type="text/javascript">
        $(document).ready(function () {
            //Changing company from option
            $('#comp').change(function () {
                $('#plant').empty();
                $('#dept').empty();
                $('#emp').empty();
                $('#plant').append($('<option></option>').html('Loading...'));

                var comp_id = $('#comp').val();
                $.ajax({
                    type: 'get',
                    url: '{!!URL::to('elm_portal/get_plant_id') !!}',
                    data: {'c_id': comp_id},
                    success: function (data) {
                        // console.log(data.plant);
                        var op = '';
                        op += '<option value="0" selected disabled>Select Plant</option>';
                        op += '<option value="All">All</option>';
                        for (var i = 0; i < data.plant.length; i++) {
                            op += '<option value="' + data.plant[i]['plant_id'] + '">' + data.plant[i]['plant_name'] + '</option>';
                        }
                        $('#plant').html(" ");
                        $('#plant').append(op);
                    },
                    error: function () {

                    }
                });
            });
            

            $('#btn_submit').on('click', function (e) {
                // e.preventDefault();
                $("#loader").show();
                var pl = $('#plant').val();
                var dpt = $('#dept').val();
                var emp = $('#emp').val();
                console.log('Submit button Clicked', pl, dpt, emp);
                var table = null;
                
                $.ajax({
                    type: 'post',
                    url: '{!! URL::to('elm_portal/getElmPlMasterInfo') !!}',
                    data: {'dept_id': dpt, 'plant_id': pl, 'emp_id': emp, '_token': "{{ csrf_token() }}"},
                    success: function (data) {

                        $("#showTable").show();
                        $("#loader").hide();

                        $("#elr").DataTable().destroy();
                        table = $("#elr").DataTable({
                        	dom: 'Bfrtip',
					        buttons: [
					            {
					                text: '<button class="btn btn-success btn-xs" type="button"><i class="fa fa-plus"></i> Add </button>',
					                action: function ( e, dt, node, config ) {					                   
					                     $("#myModal").modal('show');
					                }
					            }
					        ],
                            data: data,
                            columns: [
                                {data: "plant_id"},
                                {data: "pl_head_name" , className:"editable"},
                                {data: "pl_emp_id" , className:"editable"},
                                {data: "pl_email" , className:"editable"}                                                         
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
			var plant_id   = null;
			var colName  = null;
			$(document).on('dblclick', '.editable', function(){										

				oldValue = $(this).html();
				$(this).removeClass('editable');	// to stop from making repeated request				
				$(this).html('<input type="text" style="width:150px;" class="update" value="'+ oldValue +'" />');
				$(this).find('.update').focus();

				plant_id  = $(this).parent().find('td').html().trim();
				clcolName = $('#elr thead tr th').eq($(this).index()).html().trim();

				// alert('Data:'+$(this).html().trim());
				// alert('Row:'+$(this).parent().find('td').html().trim());
				// alert('Column:'+$('#elr thead tr th').eq($(this).index()).html().trim());
				
			});

			var newValue = null;
			$(document).on('blur', '.update', function(){
				var elem    = $(this);
				newValue 	= $(this).val();
				plantId	    = plant_id;
				colName	    = clcolName;

				// var empId	= $(this).parent().attr('id');
				// var colName	= $(this).parent().attr('name');									
				// console.log(elem,'-',empId,'-',colName);

				if(newValue != oldValue)
				{
					$.ajax({
						url : '{{ url("elm_portal/elmUpPLmasterInfo") }}',
						method : 'post',
						data : 
						{
							plantId    : plantId,
							colName    : colName,
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
                            	toastr.error(respone.error, '', {timeOut: 2000});                            	
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

            $(function() {
            $('#elm_btn').on('click',function(e){               
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ url('elm_portal/insElmPLMasterInfo') }}",
                    data: $('#elm_emp').serialize(),
                    success: function(response) {
                        // alert(response.success);
                        if(response.success){
                            toastr.success(response.success, '', {timeOut: 5000});  
                            $('input[type="text"], textarea').val('');  
                            $('#myModal').modal('hide');    
                        }else{
                            toastr.error(response.error, '', {timeOut: 5000});  
                        }
                                
                    },
                    error: function() {
                        toastr.error(response.error, '', {timeOut: 5000});
                        alert('Error');
                    }
                });

                return false;
                
            });
        });

        });
    </script>
@endsection        