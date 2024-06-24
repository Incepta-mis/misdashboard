<div class="left-side-inner">

    <!-- visible to small devices only -->
    <div class="visible-xs hidden-sm hidden-md hidden-lg">
        <div class="media logged-user">
            {{Html::image('public/site_resource/images/User_Circle.png','',['class'=>'media-object'])}}
            <div class="media-body">
                <h4><a href="#">User: {{Auth::user()->user_id}}</a></h4>
                <span>"Welcome to Incepta Dashboard"</span>
            </div>
        </div>

        <h5 class="left-nav-title">Account Information</h5>
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li><a href="Profile.php"><i class="fa fa-user"></i> <span>Profile</span></a></li>
            <!-- <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li> -->
            <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
        </ul>
    </div>

    <!--sidebar nav start-->
    <ul class="nav nav-pills nav-stacked custom-nav">
    @if(Auth::user()->role == 4 || Auth::user()->role == 5)

            <li @if(Request::segment(1) == 'srep') class="menu-list nav-active"
                @else class="menu-list" @endif><a href="#"><i class="fa fa-file-text"></i> <span>Sales Report</span></a>
                <ul class="sub-menu-list">
                    <!-- fatema/ -->
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/monthy_sales') class="active" @endif><a href="{{url('srep/month_daily_sales')}}">History Channel Base</a></li>
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/sale_report') class="active" @endif><a href="{{url('srep/sale_report')}}">History Company Base</a></li> 

                    <!-- raqib -->
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/team_growth_percent') class="active" @endif><a href="{{url('srep/team_growth_percent')}}">Team Growth %</a></li>

                    
                    <!-- fatema -->
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/gm_sm_ach_report') class="active" @endif><a href="{{url('srep/gm_sm_ach_report')}}">GM & SM Achievement% </a></li>  
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/rm_ach_report') class="active" @endif><a href="{{url('srep/rm_ach_report')}}">RM Achievement% </a></li>
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/performance_report') class="active" @endif><a href="{{url('srep/performance_report')}}">Performance </a></li> 

                    <!-- masroor -->
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/pgroup_wise_summary') class="active" @endif><a href="{{url('srep/pgroup_wise_summary')}}">Product Group Wise Summary</a></li>
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/sm_sales') class="active" @endif><a href="{{url('srep/sm_sales')}}">SM Wise Sales</a></li>
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/rm_sales') class="active" @endif><a href="{{url('srep/rm_sales')}}">RM Wise Sales</a></li>
                     <li @if(Route::getCurrentRoute()->uri() == 'srep/rm_sales_dtl') class="active" @endif><a href="{{url('srep/rm_sales_dtl')}}">RM Detail</a></li>
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/depot_wise_sales') class="active" @endif><a href="{{url('srep/depot_wise_sales')}}">Depot Wise Sales</a></li>

                    <!-- fatema -->
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/dhk_grp_mkt_wise_product') class="active" @endif><a href="{{url('srep/dhk_grp_mkt_wise_product')}}">DHK GRP & MKT Product </a></li>  
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/national_qty_trg_arh') class="active" @endif><a href="{{url('srep/national_qty_trg_arh')}}">NATIONAL QTY TRG ARH</a></li> 
                    
                    <!-- Raqib -->
                    <li @if(Route::getCurrentRoute()->uri() == 'srep/depot_wise_product_rank') class="active" @endif><a href="{{url('srep/depot_wise_product_rank')}}">Depot Wise Product Rank</a></li>

                </ul>
            </li>

        @endif
        @if(Auth::user()->role == 2 || Auth::user()->role == 4 || Auth::user()->role == 5 )

            <li @if(Request::segment(1) == 'dcrep') class="menu-list nav-active"
                @else class="menu-list" @endif><a href="#"><i class="fa fa-user-md"></i> <span>Doctor Call Reports</span></a>
                <ul class="sub-menu-list">
                    <!-- Raqib -->
                    <li  @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_vis_sum_rep') class="active" @endif>
                        <a href="{{url('dcrep/doc_vis_sum_rep')}}">Doctor Visit Summary Report</a>
                    <li>

                    <!-- fatema -->

                    <li  @if(Route::getCurrentRoute()->uri() == 'dcrep/item_wise_utilize') class="active" @endif>
                        <a href="{{url('dcrep/item_wise_utilize')}}">Item Wise Utilization</a>
                    <li>

                    <!-- Raqib -->

                    <li  @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_wise_itm_utl') class="active" @endif>
                        <a href="{{url('dcrep/doc_wise_itm_utl')}}">Doctor Wise Item Utilization</a>
                    <li>

                    <!-- fatema -->

                    <li  @if(Route::getCurrentRoute()->uri() == 'dcrep/item_wise_doc_details') class="active" @endif>
                        <a href="{{url('dcrep/item_wise_doc_details')}}">Item Wise Doctor Details</a>
                    <li>

                    <li  @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_wise_visit_dts') class="active" @endif>
                        <a href="{{url('dcrep/doc_wise_visit_dts')}}">Doctor Wise Visit Details</a>
                    <li>
                    
                     <li  @if(Route::getCurrentRoute()->uri() == 'dcrep/terr_wise_plan_visit') class="active" @endif>
                        <a href="{{url('dcrep/terr_wise_plan_visit')}}">Territory Wise Plan VS Visit</a>
                    <li>
                    

                </ul>
            </li>
        @endif
        

        {{--Expense Verify  Approve--}}

        @if(Auth::user()->role == 2 || Auth::user()->role == 4 || Auth::user()->role == 5 )

            <li @if(Request::segment(1) == 'expense') class="menu-list nav-active"
                @else class="menu-list" @endif><a href="#"><i class="fa fa-money"></i> <span>Expense</span></a>
                <ul class="sub-menu-list">
                    <!-- fatema -->
                    <li  @if(Request::segment(2) == 'get_expense_verify_approve') class="active" @endif>
                        <a href="{{url('expense/get_expense_verify_approve')}}">Expense Verify/Approve Form</a>
                    <li>

                    <!-- fatema -->
                   <!--  <li  @if(Request::segment(2) == 'get_expense_verify_approve') class="active" @endif>
                        <a href="{{url('expense/get_expense_verify_approve')}}">Expense Manual Entry Form</a>
                    <li> -->
                    @if(Auth::user()->desig == 'HO')
                    <!-- fatema -->
                    <li  @if(Request::segment(2) == 'get_expense_entry_form') class="active" @endif>
                        <a href="{{url('expense/get_expense_entry_form')}}">Expense Entry Form</a>
                    <li>
                    @endif

                    <!-- Raqib -->
                    <li  @if(Request::segment(2) == 'field_expense') class="active" @endif>
                        <a href="{{url('expense/field_expense')}}">Expense Reports</a>
                    <li>

                </ul>
            </li>
        @endif

        @if(Auth::user()->role == 1 || Auth::user()->role == 5)

            <li @if(Request::segment(1) == 'drep') class="menu-list nav-active"
                @else class="menu-list" @endif><a href="#"><i class="fa fa-file-text"></i> <span>Daily Report</span></a>
                <ul class="sub-menu-list">
                    <li ><a href="{{url('nat_stock')}}"> National Report</a><li>
                    <li><a href="p_group_wdsales.php"> Product Group Wise Depot Sales</a><li>
                    <li><a href="product_wise_target_vs_sold.php"> Product Wise Depot Sales Value Base </a></li>
                    <li><a href="product_wise_qty_based.php"> Product Wise Depot Sales Quantity Base </a></li>
                    <li><a href="dep_d_remit.php">Depot Daily Remittance</a></li>
                    <li @if(Route::getCurrentRoute()->uri() == 'drep/nat_stock') class="active" @endif><a href="{{url('drep/nat_stock')}}">National Stock</a></li>
                    <li><a href="rm_daily_achievement.php">RM Daily Achievement</a></li>
                    <li><a href="patient_inv_info.php">Patient Invoice Information</a></li>                
                    
                </ul>
            </li>

        @endif
        
        @if(Auth::user()->role == 2 || Auth::user()->role == 5 )

            <li class="menu-list"><a href="#"><i class="fa fa-file-text"></i> <span>Analytical Report</span></a>
                <ul class="sub-menu-list">
                    <li><a href="mon_wtvss_value.php"> Company Yearly Month Wise Achievement</a><li>
                    <li><a href="prod_rank_depot_sales.php"> Brand Ranking for Depot Sales</a><li>
                    <li><a href="prod_rank_inst_sales.php"> Brand Ranking for Institute Sales</a><li>
                </ul>
            </li>
        @endif
        @if(Auth::user()->role == 3 || Auth::user()->role == 5 )
            <li class="menu-list"><a href="#"><i class="fa fa-bar-chart-o"></i> <span>Graphical Report</span></a>
                <ul class="sub-menu-list">
                    <!--                        <li><a href="index.php"> Report Demo Chart</a></li>-->
                    <li><a href="cywsales.php"> Company Growth(Bar Chart)</a></li>
                    <li><a href="cywgp_bl.php"> Company Year Wise Sales Growth Percentage(Bar Chart)</a></li>
                    <li><a href="cywsp_pc.php"> Company Year Wise Sales Percentage(Pie Chart)</a></li>
                    <li><a href="cymws_bc.php"> Company Yearly Month Wise Sales(Bar Chart)</a></li>
                    <li><a href="cymws_lc.php"> Company Yearly Month Wise Sales(Line Chart)</a></li>
                </ul>
            </li>

    @endif

    {{--UPLOAD_EXPORT_SALES_DATA--}}

        @if(Auth::user()->role == 2 || Auth::user()->role == 4 || Auth::user()->role == 5 )

            <li @if(Request::segment(1) == 'dataupload') class="menu-list nav-active"
                @else class="menu-list" @endif><a href="#"><i class="fa fa-upload"></i> <span>Data Upload</span></a>
                <ul class="sub-menu-list">

                    <!-- fatema -->

                    <li  @if(Request::segment(2) == 'up_export_sales_data') class="active" @endif>
                        <a href="{{url('dataupload/up_export_sales_data')}}">UPLOAD EXPORT SALES DATA</a>
                    <li>

                    <li  @if(Request::segment(2) == 'inst_sales_data') class="active" @endif>
                        <a href="{{url('dataupload/inst_sales_data')}}">UPLOAD INST SALES DATA</a>
                    <li>

                </ul>
            </li>
        @endif


    </ul>
    <!--sidebar nav end-->

</div>