<!-- Modal -->
<div class="modal fade" id="update_expense" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Expense</h4>
            </div>
            <div class="modal-body">
                <form action="expense/newExpense" method="post" id="frmExpense" enctype="multipart/form-data" files="true">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                        <!-- depot name -->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Depot Name</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="depot_name" id="depot_name" placeholder="Depot Name" class="form-control">--}}
                            {{--Dhaka--}}
                                <span id="depot_nam"></span>
                            </div>
                        </div>
                        <!-- emp id-->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Emp ID</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="emp_id" id="emp_id" placeholder="Emp ID" class="form-control">--}}
                                {{--1007010--}}
                                <span id="empid"></span>

                            </div>
                        </div>
                        <!-- emp name -->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label for="">Emp Name</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="emp_name" id="emp_name" placeholder="Emp Name" class="form-control">--}}
                                {{--Md. AMIRUL ISLAM--}}
                                <span id="empname"></span>
                            </div>
                        </div>
                        <!-- desig -->
                        <div class="col-lg-1 col-md-1 col-sm-1">
                            <label for="">Desig</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="desig" id="desig" placeholder="Desig" class="form-control">--}}
                                {{--MPO--}}
                                <span id="desigg"></span>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Terr ID</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="terr_id" id="terr_id" placeholder="Terr ID" class="form-control">--}}
                                <span id="terrid"></span>
                            </div>
                        </div>
                        <!-- exp_date-->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Exp Date</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="exp_date" id="exp_date" placeholder="Exp Date" class="form-control">--}}
                                 <span id="expdate"></span>

                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <!-- tour_type -->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Tour Type</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <span id="tour_type_id">

                                </span>

                            </div>
                        </div>
                        <!-- tour_details -->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Tour Details</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="text" name="tour_details" id="tour_details" placeholder="Tour Details" class="form-control">

                            </div>
                        </div>
                        <!-- daily_allowance-->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Daily Allowance</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="text" value="0" readonly name="daily_allowance" id="daily_allowance" placeholder="daily_allowance" class="form-control">
                            </div>
                        </div>

                        <!-- city_all_type-->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label for="">CityFare AllowanceType</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <span id="allowance_type_id">

                                </span>

                            </div>
                        </div>
                        <!-- city_all-->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label for="">City Fare Allowance</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="text" value="0" name="city_all" id="city_all" placeholder="City Fare Allowance" class="form-control">
                                <span id="maxerror" style="color: red">

                                </span>
                                <input type="hidden" value="0" name="desig" id="desig_did">
                                <input type="hidden" value="0" name="givendb" id="givencityid">
                                <input type="hidden" value="0" name="city_all_max" id="city_all_max">


                            </div>
                        </div>

                     </div>


                    <div class="row">


                        <!-- ta_amnt-->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Travel Amount</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="text" value="0" name="ta_amnt" id="ta_amnt" placeholder="Ta Amount" class="form-control">

                            </div>
                        </div>


                        <!-- ta_image -->
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label for="">Travel Img</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="file" value="ta image">--}}
                                {{--<input type="file" name="ta_image" id="ta_image" placeholder="ta Image" class="form-control">--}}
                                <input type="file" value="" name="ta_image" id="ta_image" placeholder="ta Image" class="form-control ta_image">
                                {{--<span id='error_message' style="color:red">Only jpg Image type allowed</span>--}}
                                <span id="message_ta" style='color:red'>

                                </span>

                            </div>
                        </div>

                        <!-- ta_image_show -->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">Travel Img</label>
                            <div class="form-group">
                                <span id="img_show_link_ta">
                                    No Image
                                </span>

                            </div>
                        </div>


                        <!-- ta_des -->
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label for="">Travel description</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="ta_des" id="ta_des" placeholder="ta_description" class="form-control">--}}
                                <textarea name="ta_des" id="ta_des" placeholder="ta_description"  id="" cols="30" rows="2"></textarea>
                            </div>
                        </div>

                    </div>
                    <!-- end row clss -->
                    <div class="row">

                        <!-- oe_amnt-->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">OtherExpAmount</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="text" value="0" name="oe_amnt" id="oe_amnt" placeholder="oe Amount" class="form-control">

                            </div>
                        </div>


                        <!-- oe_image-->
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label for="">OtherExp Img</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="file" name="oe_image" id="oe_image" placeholder="oe Image" class="form-control">
                                {{--<span id='error_message' style="color:red">Only jpg Image type allowed</span>--}}
                                <span id="message_oe" style='color:red'>

                                </span>

                            </div>
                        </div>

                        <!-- oe_image_show -->
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <label for="">OtherExp Img</label>
                            <div class="form-group">
                               <span id="img_show_link_oe">
                                    No Image
                                </span>
                            </div>
                        </div>


                        <!-- oe_des -->
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label for="">OtherExpense Description</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="text" name="oe_des" id="oe_des" placeholder="oe Description" class="form-control">--}}
                                <textarea name="oe_des" id="oe_des" placeholder="oe_des"  id="" cols="30" rows="2"></textarea>

                            </div>
                        </div>



                    </div>
                    <!-- end row clss -->
                    <div class="row">
                        <!-- additional-->
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <label for="">Additional Amount</label>
                            <div class="form-group">
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <input type="text" value="0" name="add_amnt" id="add_amnt" placeholder="Additional Amount" class="form-control">

                            </div>
                        </div>
                    </div>

            {{--</div>--}}
            <input type="hidden" name="id" value="" id="id">
            <div class="modal-footer">
                <input type="hidden" id="udid" name="udid">
                <input type="hidden" id="taimgstate_id" name="taimgstate_id">
                <input type="hidden" id="oeimgstate_id" name="oeimgstate_id">
                <input type="hidden" id="upstate_id" name="upstate_id">

                <input type="submit" value="saving" id="mods" class="btn btn-primary expenseclose">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
            </form>

        </div>
        </div>
    </div>
</div>