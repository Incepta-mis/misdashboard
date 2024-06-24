<div class="left-side-inner">

    <!-- visible to small devices only -->
    <div class="visible-xs hidden-sm hidden-md hidden-lg">
        <div class="media logged-user">
            {{Html::image('public/site_resource/images/User_Circle.png','',['class'=>'media-object'])}}
            <div class="media-body">
                <h4><a href="#">&nbsp;{{Auth::user()->name}}</a></h4>
                <span>&nbsp;&nbsp;<strong>Id: {{Auth::user()->user_id}}</strong></span>
            </div>
        </div>

        <!-- <h5 class="left-nav-title">Categories</h5> -->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li><a href="{{url('user/profile')}}"><i class="fa fa-user"></i> <span>Profile</span></a></li>
            <!-- <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li> -->
            <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
        </ul>
    </div>
<?php
    $research_users = Auth::user()->getResearchExpenseUsers();
?>
@if(Auth::user()->getCategory() != null)
    <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked custom-nav">
            @foreach(Auth::user()->getCategory() as $data)


                {{-- CATEGORY ONE(SALES REPORT) START    --}}
                @if($data->mcategory == 1)
                    <li @if(Request::segment(1) == 'srep') class="menu-list nav-active"
                        @else class="menu-list sale_report_clss" @endif>
                        <a href="#"><i class="fa fa-file-text"></i> <span>Sales Report</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr91 = explode('|', $data->scategory);?>
                                @if(in_array('1',$arr91,false))
                                    <li @if(Request::segment(2) =='hrep') class="menu-list-first nav-active active"
                                        @else class="menu-list-first" @endif>
                                        <a href="#">
                                            <i class="fa fa-clipboard"></i>
                                            Historical report
                                        </a>
                                        <ul class="sub-menu-list-first">
                                            @if(strpos($data->scate_two,',') !== false)
                                                <?php $arr92 = explode(',', $data->scate_two); ?>
                                                @if(substr($arr92[0],0,1) == '1')
                                                    @if(strpos(substr($arr92[0], 2, -1),'|') !== false)
                                                        <?php $arr93 = explode('|', substr($arr92[0], 2, -1));?>
                                                        @if(in_array('7',$arr93,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/caos_report') class="active" @endif>
                                                                <a href="{{url('srep/hrep/caos_report')}}">Sales
                                                                    Comparison</a>
                                                            </li>
                                                        @endif

                                                        @if(in_array('1',$arr93,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/month_daily_sales') class="active" @endif>
                                                                <a href="{{url('srep/hrep/month_daily_sales')}}">Channel
                                                                    wise
                                                                    yearly sales(
                                                                    all company)</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('2',$arr93,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/summary_of_sales') class="active" @endif>
                                                                <a href="{{url('srep/hrep/summary_of_sales')}}">Channel
                                                                    &
                                                                    group
                                                                    wise sales(
                                                                    all company)</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('3',$arr93,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/sale_report') class="active" @endif>
                                                                <a href="{{url('srep/hrep/sale_report')}}">Company wise
                                                                    yearly
                                                                    sales</a>
                                                            </li>
                                                        @endif

                                                        @if(in_array('4',$arr93,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/sale_report_channelw') class="active" @endif>
                                                                <a href="{{url('srep/hrep/sale_report_channelw')}}">Channel
                                                                    &
                                                                    Company wise
                                                                    sales</a></li>
                                                        @endif
                                                        @if(in_array('5',$arr93,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/team_growth_percent') class="active" @endif>
                                                                <a href="{{url('srep/hrep/team_growth_percent')}}">Team
                                                                    wise
                                                                    sales</a></li>
                                                        @endif
                                                        @if(in_array('6',$arr93,false))
                                                            <li @if(Request::segment(3) =='hbrand') class="menu-list-3L2 nav-active active"
                                                                @else class="menu-list-3L2"
                                                                @endif class="menu-list-3L2">
                                                                <a href="#"> <i class="fa fa-list"></i>Brand Ranking</a>
                                                                <ul class="sub-menu-list-3L2">
                                                                    @if(strpos($data->scate_three,'|') !== false)
                                                                        <?php $arr94 = explode('|', $data->scate_three); ?>
                                                                        @if(in_array('1',$arr94,false))
                                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/depot_wise_product_rank') class="active" @endif>
                                                                                <a href="{{url('srep/hrep/hbrand/depot_wise_product_rank')}}">Monthly
                                                                                    Ranking</a>
                                                                            </li>
                                                                        @endif
                                                                        @if(in_array('2',$arr94,false))
                                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/yearly_product_rank') class="active" @endif>
                                                                                <a href="{{url('srep/hrep/hbrand/yearly_product_rank')}}">Yearly
                                                                                    Ranking</a>
                                                                            </li>
                                                                        @endif
                                                                        @if(in_array('3',$arr94,false))
                                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/brand_ranking_report') class="active" @endif>
                                                                                <a href="{{url('srep/hrep/hbrand/brand_ranking_report')}}">Brand Ranking</a>
                                                                            </li>
                                                                        @endif
                                                                    @elseif(strpos($data->scate_three,'All') !== false)
                                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/depot_wise_product_rank') class="active" @endif>
                                                                            <a href="{{url('srep/hrep/hbrand/depot_wise_product_rank')}}">Monthly
                                                                                Ranking</a>
                                                                        </li>
                                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/yearly_product_rank') class="active" @endif>
                                                                            <a href="{{url('srep/hrep/hbrand/yearly_product_rank')}}">Yearly
                                                                                Ranking</a>
                                                                        </li>
                                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/brand_ranking_report') class="active" @endif>
                                                                                <a href="{{url('srep/hrep/hbrand/brand_ranking_report')}}">Brand Ranking</a>
                                                                            </li>
                                                                    @endif
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @elseif(strpos(substr($arr92[0], 2, -1),'All') !== false)

                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/caos_report') class="active" @endif>
                                                            <a href="{{url('srep/hrep/caos_report')}}">Sales
                                                                Comparison</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/month_daily_sales') class="active" @endif>
                                                            <a href="{{url('srep/hrep/month_daily_sales')}}">Channel
                                                                wise yearly
                                                                sales(
                                                                all company)</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/summary_of_sales') class="active" @endif>
                                                            <a href="{{url('srep/hrep/summary_of_sales')}}">Channel &
                                                                group wise
                                                                sales(
                                                                all company)</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/sale_report') class="active" @endif>
                                                            <a href="{{url('srep/hrep/sale_report')}}">Company wise
                                                                yearly
                                                                sales</a>
                                                        </li>

                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/sale_report_channelw') class="active" @endif>
                                                            <a href="{{url('srep/hrep/sale_report_channelw')}}">Channel
                                                                &
                                                                Company wise
                                                                sales</a></li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/team_growth_percent') class="active" @endif>
                                                            <a href="{{url('srep/hrep/team_growth_percent')}}">Team wise
                                                                sales</a></li>
                                                        <li @if(Request::segment(3) =='hbrand') class="menu-list-3L2 nav-active active"
                                                            @else class="menu-list-3L2" @endif class="menu-list-3L2">
                                                            <a href="#"> <i class="fa fa-list"></i>Brand Ranking</a>
                                                            <ul class="sub-menu-list-3L2">
                                                                <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/depot_wise_product_rank') class="active" @endif>
                                                                    <a href="{{url('srep/hrep/hbrand/depot_wise_product_rank')}}">Monthly
                                                                        Ranking</a>
                                                                </li>
                                                                <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/yearly_product_rank') class="active" @endif>
                                                                    <a href="{{url('srep/hrep/hbrand/yearly_product_rank')}}">Yearly
                                                                        Ranking</a>
                                                                </li>
                                                                <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/brand_ranking_report') class="active" @endif>
                                                                    <a href="{{url('srep/hrep/hbrand/brand_ranking_report')}}">Brand Ranking</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                @if(in_array('2',$arr91,false))
                                    <li @if(Request::segment(2) =='cmrep') class="menu-list-sec nav-active active"
                                        @else class="menu-list-sec" @endif>
                                        <a href="">
                                            <i class="fa fa-align-left"></i>
                                            Current Month report</a>
                                        <ul class="sub-menu-list-sec">
                                            @if(strpos($data->scate_two,',') !== false)
                                                <?php $arr95 = explode(',', $data->scate_two);?>
                                                @if(substr($arr95[1],0,1) == '2')
                                                    @if(strpos(substr($arr95[1], 2, -1),'|') !== false)
                                                        <?php $arr96 = explode('|', substr($arr95[1], 2, -1));?>
                                                        @if(in_array('1',$arr96,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/pgroup_wise_summary') class="active" @endif>
                                                                <a href="{{url('srep/cmrep/pgroup_wise_summary')}}">Product
                                                                    group wise
                                                                    sales</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('2',$arr96,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/depot_wise_sales') class="active" @endif>
                                                                <a href="{{url('srep/cmrep/depot_wise_sales')}}">Depot
                                                                    wise sales</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('4',$arr96,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/depot_product_activity') class="active" @endif>
                                                                <a href="{{url('srep/cmrep/depot_product_activity')}}">Depot
                                                                    Product Activity</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('3',$arr96,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/dhk_grp_mkt_wise_product') class="active" @endif>
                                                                <a href="{{url('srep/cmrep/dhk_grp_mkt_wise_product')}}">Dhaka
                                                                    depot
                                                                    sales</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('5',$arr96,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/national_report') class="active" @endif>
                                                                <a href="{{url('srep/cmrep/national_report')}}">National
                                                                    Report</a>
                                                            </li>
                                                        @endif
                                                         @if(in_array('6',$arr96,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/national_stock_medicine') class="active" @endif>
                                                                <a href="{{url('srep/cmrep/national_stock_medicine')}}">National Stock</a>
                                                            </li>
                                                        @endif
                                                    @elseif(strpos(substr($arr95[1], 2, -1),'All') !== false)
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/pgroup_wise_summary') class="active" @endif>
                                                            <a href="{{url('srep/cmrep/pgroup_wise_summary')}}">Product
                                                                group wise
                                                                sales</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/depot_wise_sales') class="active" @endif>
                                                            <a href="{{url('srep/cmrep/depot_wise_sales')}}">Depot wise
                                                                sales</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/depot_product_activity') class="active" @endif>
                                                            <a href="{{url('srep/cmrep/depot_product_activity')}}">Depot
                                                                Product Activity</a>
                                                        </li>

                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/dhk_grp_mkt_wise_product') class="active" @endif>
                                                            <a href="{{url('srep/cmrep/dhk_grp_mkt_wise_product')}}">Dhaka
                                                                depot
                                                                sales</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/national_report') class="active" @endif>
                                                            <a href="{{url('srep/cmrep/national_report')}}">National
                                                                Report</a>
                                                        </li>

                                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/national_stock_medicine') class="active" @endif>
                                                            <a href="{{url('srep/cmrep/national_stock_medicine')}}">National Stock</a>
                                                        </li>
                                                    
                                                    @endif
                                                @endif
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Request::segment(2) =='hrep') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Historical report
                                    </a>
                                    <ul class="sub-menu-list-first">

                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/caos_report') class="active" @endif>
                                            <a href="{{url('srep/hrep/caos_report')}}">Sales Comparison</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/month_daily_sales') class="active" @endif>
                                            <a href="{{url('srep/hrep/month_daily_sales')}}">Channel wise yearly sales(
                                                all company)</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/summary_of_sales') class="active" @endif>
                                            <a href="{{url('srep/hrep/summary_of_sales')}}">Channel & group wise sales(
                                                all company)</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/sale_report') class="active" @endif>
                                            <a href="{{url('srep/hrep/sale_report')}}">Company wise yearly sales</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/sale_report_channelw') class="active" @endif>
                                            <a href="{{url('srep/hrep/sale_report_channelw')}}">Channel & Company wise
                                                sales</a></li>


                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/team_growth_percent') class="active" @endif>
                                            <a href="{{url('srep/hrep/team_growth_percent')}}">Team wise sales</a></li>


                                        <li @if(Request::segment(3) =='hbrand') class="menu-list-3L2 nav-active active"
                                            @else class="menu-list-3L2" @endif class="menu-list-3L2">
                                            <a href="#"> <i class="fa fa-list"></i>Brand Ranking</a>
                                            <ul class="sub-menu-list-3L2">
                                                <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/depot_wise_product_rank') class="active" @endif>
                                                    <a href="{{url('srep/hrep/hbrand/depot_wise_product_rank')}}">Monthly
                                                        Ranking</a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/yearly_product_rank') class="active" @endif>
                                                    <a href="{{url('srep/hrep/hbrand/yearly_product_rank')}}">Yearly
                                                        Ranking</a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'srep/hrep/hbrand/brand_ranking_report') class="active" @endif>
                                                    <a href="{{url('srep/hrep/hbrand/brand_ranking_report')}}">Brand Ranking</a>
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li @if(Request::segment(2) =='cmrep') class="menu-list-sec nav-active active"
                                    @else class="menu-list-sec" @endif>
                                    <a href="">
                                        <i class="fa fa-align-left"></i>
                                        Current Month report</a>
                                    <ul class="sub-menu-list-sec">
                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/pgroup_wise_summary') class="active" @endif>
                                            <a href="{{url('srep/cmrep/pgroup_wise_summary')}}">Product group wise
                                                sales</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/depot_wise_sales') class="active" @endif>
                                            <a href="{{url('srep/cmrep/depot_wise_sales')}}">Depot wise sales</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/depot_product_activity') class="active" @endif>
                                            <a href="{{url('srep/cmrep/depot_product_activity')}}">Depot Product
                                                Activity</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/dhk_grp_mkt_wise_product') class="active" @endif>
                                            <a href="{{url('srep/cmrep/dhk_grp_mkt_wise_product')}}">Dhaka depot
                                                sales</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/national_report') class="active" @endif>
                                            <a href="{{url('srep/cmrep/national_report')}}">National Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'srep/cmrep/national_stock_medicine') class="active" @endif>
                                            <a href="{{url('srep/cmrep/national_stock_medicine')}}">National Stock</a>
                                        </li>

                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif
                {{--CATEGORY ONE(SALES REPORT) END--}}

                {{-- CATEGORY TWO(PERFORMANCE REPORT) START    --}}
                @if($data->mcategory == 2)
                    <li @if(Request::segment(1) == 'prep') class="menu-list nav-active"
                        @else class="menu-list sale_report_clss_per" @endif>
                        <a href="#"><i class="fa fa-file-o"></i> <span>Performance Report (Territory)</span></a>
                        <ul class="sub-menu-list-per">
                            <!-- fatema/ -->
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr97 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr97,false))
                                    <li @if(Request::segment(2) =='hreper') class="menu-list-first-per nav-active active"
                                        @else class="menu-list-first-per" @endif>
                                        <a href="#">
                                            <i class="fa fa-clipboard"></i>
                                            Historical report
                                        </a>
                                        <ul class="sub-menu-list-first-per">
                                            @if(strpos($data->scate_two,',') !== false)
                                                <?php $arr98 = explode(',', $data->scate_two);?>
                                                @if(substr($arr98[0],0,1) == '1')
                                                    @if(strpos(substr($arr98[0], 2, -1),'|') !== false)
                                                        <?php $arr99 = explode('|', substr($arr98[0], 2, -1));?>
                                                        @if(in_array('1',$arr99,false))
                                                            <li @if(Request::segment(3) =='hsaleper') class="menu-list-3L1-per nav-active active"
                                                                @else class="menu-list-3L1-per"
                                                                @endif class="menu-list-3L1-per">
                                                                <a href=""> <i class="fa fa-list"></i>Sales Performance</a>
                                                                <ul class="sub-menu-list-3L1-per">
                                                                    @if(strpos($data->scate_three,',') !== false)
                                                                        <?php $arr100 = explode(',', $data->scate_three);?>
                                                                        @if(substr($arr100[0],0,2) == '11')
                                                                            @if(strpos(substr($arr100[0], 3, -1),'|') !== false)
                                                                                <?php $arr101 = explode('|', substr($arr100[0], 3, -1));?>
                                                                                @if(in_array('1',$arr101,false))
                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/performance_report') class="active" @endif>
                                                                                        <a href="{{url('prep/hreper/hsaleper/performance_report')}}">Team
                                                                                            wise</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(in_array('2',$arr101,false))

                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/gm_ach_rep') class="active" @endif>
                                                                                        <a href="{{url('prep/hreper/hsaleper/gm_ach_rep')}}">ED
                                                                                            wise</a>
                                                                                    </li>

                                                                                @endif
                                                                                @if(in_array('3',$arr101,false))
                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/sm_asm_dsm_ach_rep') class="active" @endif>
                                                                                        <a href="{{url('prep/hreper/hsaleper/sm_asm_dsm_ach_rep')}}">DSM/SM
                                                                                            wise</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(in_array('4',$arr101,false))
                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/rm_ach_report') class="active" @endif>
                                                                                        <a href="{{url('prep/hreper/hsaleper/rm_ach_report')}}">RM/ASM
                                                                                            wise</a>
                                                                                    </li>
                                                                                @endif
                                                                            @elseif(strpos(substr($arr100[0], 3, -1),'All') !== false)
                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/performance_report') class="active" @endif>
                                                                                    <a href="{{url('prep/hreper/hsaleper/performance_report')}}">Team
                                                                                        wise</a>
                                                                                </li>

                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/gm_ach_rep') class="active" @endif>
                                                                                    <a href="{{url('prep/hreper/hsaleper/gm_ach_rep')}}">ED
                                                                                        wise</a>
                                                                                </li>

                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/sm_asm_dsm_ach_rep') class="active" @endif>
                                                                                    <a href="{{url('prep/hreper/hsaleper/sm_asm_dsm_ach_rep')}}">DSM/SM
                                                                                        wise</a>
                                                                                </li>
                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/rm_ach_report') class="active" @endif>
                                                                                    <a href="{{url('prep/hreper/hsaleper/rm_ach_report')}}">RM/ASM
                                                                                        wise</a>
                                                                                </li>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                @if(in_array('2',$arr97,false))
                                    <li @if(Request::segment(2) =='cmreper') class="menu-list-sec-per nav-active active"
                                        @else class="menu-list-sec-per" @endif>
                                        <a href="">
                                            <i class="fa fa-align-left"></i>
                                            Current Month report</a>
                                        <ul class="sub-menu-list-sec-per">
                                            @if(strpos($data->scate_two,',') !== false)
                                                <?php $arr102 = explode(',', $data->scate_two);?>
                                                @if(substr($arr102[1],0,1) == '2')
                                                    @if(strpos(substr($arr102[1], 2, -1),'|') !== false)
                                                        <?php $arr103 = explode('|', substr($arr102[1], 2, -1));?>
                                                        @if(in_array('1',$arr103,false))
                                                            <li @if(Request::segment(3) =='csaleper') class="menu-list-3L3-per nav-active active"
                                                                @else class="menu-list-3L3-per" @endif>
                                                                <a href="#"> <i class="fa fa-list"></i>Sales Performance</a>
                                                                <ul class="sub-menu-list-3L3-per">
                                                                    @if(strpos($data->scate_three,',') !== false)
                                                                        <?php $arr104 = explode(',', $data->scate_three);
                                                                        ?>
                                                                        @if(substr($arr104[1],0,2) == '21')
                                                                            @if(strpos(substr($arr104[1], 3, -1),'|') !== false)
                                                                                <?php
                                                                                $arr105 = explode('|', substr($arr104[1], 3, -1));
                                                                                ?>
                                                                                @if(in_array('1',$arr105,false))
                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/sm_sales') class="active" @endif>
                                                                                        <a href="{{url('prep/cmreper/csaleper/sm_sales')}}">SM
                                                                                            wise</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(in_array('2',$arr105,false))
                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/rm_sales_dtl') class="active" @endif>
                                                                                        <a href="{{url('prep/cmreper/csaleper/rm_sales_dtl')}}">RM
                                                                                            wise</a>
                                                                                    </li>
                                                                                @endif
                                                                                @if(in_array('3',$arr105,false))
                                                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/national_qty_trg_arh') class="active" @endif>
                                                                                        <a href="{{url('prep/cmreper/csaleper/national_qty_trg_arh')}}">Quantity
                                                                                            achievement</a>
                                                                                    </li>
                                                                                @endif
                                                                            @elseif(strpos(substr($arr104[1], 3, -1),'All') !== false)
                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/sm_sales') class="active" @endif>
                                                                                    <a href="{{url('prep/cmreper/csaleper/sm_sales')}}">SM
                                                                                        wise</a>
                                                                                </li>
                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/rm_sales_dtl') class="active" @endif>
                                                                                    <a href="{{url('prep/cmreper/csaleper/rm_sales_dtl')}}">RM
                                                                                        wise</a>
                                                                                </li>
                                                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/national_qty_trg_arh') class="active" @endif>
                                                                                    <a href="{{url('prep/cmreper/csaleper/national_qty_trg_arh')}}">Quantity
                                                                                        achievement</a>
                                                                                </li>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                            <!-- //borna paste start -->
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Request::segment(2) =='hreper') class="menu-list-first-per nav-active active"
                                    @else class="menu-list-first-per" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Historical report
                                    </a>
                                    <ul class="sub-menu-list-first-per">
                                        <li @if(Request::segment(3) =='hsaleper') class="menu-list-3L1-per nav-active active"
                                            @else class="menu-list-3L1-per" @endif class="menu-list-3L1-per">
                                            <a href=""> <i class="fa fa-list"></i>Sales Performance</a>
                                            <ul class="sub-menu-list-3L1-per">
                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/performance_report') class="active" @endif>
                                                    <a href="{{url('prep/hreper/hsaleper/performance_report')}}">Team
                                                        wise</a>
                                                </li>
                                                @if(Auth::user()->urole === '12' && ((Auth::user()->user_id === '1000353')||(Auth::user()->user_id === '1000298')))
                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/gm_ach_rep') class="active" @endif>
                                                        <a href="{{url('prep/hreper/hsaleper/gm_ach_rep')}}">ED wise</a>
                                                    </li>
                                                @elseif(Auth::user()->urole !== '12')
                                                    <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/gm_ach_rep') class="active" @endif>
                                                        <a href="{{url('prep/hreper/hsaleper/gm_ach_rep')}}">ED wise</a>
                                                    </li>
                                                @endif
                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/sm_asm_dsm_ach_rep') class="active" @endif>
                                                    <a href="{{url('prep/hreper/hsaleper/sm_asm_dsm_ach_rep')}}">DSM/SM
                                                        wise</a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/hreper/hsaleper/rm_ach_report') class="active" @endif>
                                                    <a href="{{url('prep/hreper/hsaleper/rm_ach_report')}}">RM/ASM
                                                        wise</a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li @if(Request::segment(2) =='cmreper') class="menu-list-sec-per nav-active active"
                                    @else class="menu-list-sec-per" @endif>
                                    <a href="">
                                        <i class="fa fa-align-left"></i>
                                        Current Month report</a>
                                    <ul class="sub-menu-list-sec-per">
                                        <li @if(Request::segment(3) =='csaleper') class="menu-list-3L3-per nav-active active"
                                            @else class="menu-list-3L3-per" @endif>
                                            <a href="#"> <i class="fa fa-list"></i>Sales Performance</a>
                                            <ul class="sub-menu-list-3L3-per">
                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/sm_sales') class="active" @endif>
                                                    <a href="{{url('prep/cmreper/csaleper/sm_sales')}}">SM wise</a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/rm_sales_dtl') class="active" @endif>
                                                    <a href="{{url('prep/cmreper/csaleper/rm_sales_dtl')}}">RM wise</a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'prep/cmreper/csaleper/national_qty_trg_arh') class="active" @endif>
                                                    <a href="{{url('prep/cmreper/csaleper/national_qty_trg_arh')}}">Quantity
                                                        achievement</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                        @endif
                        <!-- borna paste end -->
                        </ul>
                    </li>

                @endif
                {{--CATEGORY TWO(PERFORMANCE REPORT) END--}}



            <!-- //borna paste start 8.5.2019-->

                {{-- CATEGORY 11 START --}}

                @if($data->mcategory == 11)

                    <li @if(Request::segment(1) == 'repprocess') class="menu-list nav-active"
                        @else class="menu-list" @endif>
                        <a href="#"><i class="fa fa-spinner fa-spin"></i> <span>Daily Data Process</span></a>
                        <ul class="sub-menu-list">
                            <!-- fatema/ -->
                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr9 = explode('|', $data->scategory); ?>
                            @if(in_array('1',$arr9,false))
                                <!-- Sahadat -->
                                    <li @if(Route::getCurrentRoute()->uri() == 'repprocess/monthly_working_day') class="active" @endif>
                                        <a href="{{url('repprocess/monthly_working_day')}}">Monthly Working Day</a>
                                    </li>

                                @endif
                                @if(in_array('2',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'repprocess/daily_data_process') class="active" @endif>
                                        <a href="{{url('repprocess/daily_data_process')}}">Daily Report Process</a>
                                    </li>
                                @endif

                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Sahadat -->
                                <li @if(Route::getCurrentRoute()->uri() == 'repprocess/monthly_working_day') class="active" @endif>
                                    <a href="{{url('repprocess/monthly_working_day')}}">Monthly Working Day</a>
                                </li>


                                <!-- fatema -->
                                <li @if(Route::getCurrentRoute()->uri() == 'repprocess/daily_data_process') class="active" @endif>
                                    <a href="{{url('repprocess/daily_data_process')}}">Daily Report Process</a>
                                </li>


                            @endif
                        </ul>
                    </li>

                @endif
                {{--CATEGORY 11 END--}}


                {{--CATEGORY EIGHTEEN START--}}
                @if($data->mcategory == 18)

                    <li @if(Request::segment(1) == 'dcrep') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-user-md"></i> <span>Doctor Call Reports</span></a>
                        <ul class="sub-menu-list">

                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr1 = explode('|', $data->scategory); ?>

                            @if(in_array('1',$arr1,false))
                                <!-- Raqib -->
                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_vis_sum_rep') class="active" @endif>
                                        <a href="{{url('dcrep/doc_vis_sum_rep')}}">Doctor Visit Summary Report</a>
                                    </li>
                            @endif
                            <!-- fatema -->
                                @if(in_array('2',$arr1,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/item_wise_utilize') class="active" @endif>
                                        <a href="{{url('dcrep/item_wise_utilize')}}">Item Wise Utilization</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr1,false))
                                <!-- Raqib -->

                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_wise_itm_utl') class="active" @endif>
                                        <a href="{{url('dcrep/doc_wise_itm_utl')}}">Doctor Wise Item Utilization</a>
                                    </li>
                                @endif

                                @if(in_array('4',$arr1,false))
                                <!-- fatema -->
                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/item_wise_doc_details') class="active" @endif>
                                        <a href="{{url('dcrep/item_wise_doc_details')}}">Item Wise Doctor Details</a>
                                    </li>
                                @endif
                                @if(in_array('5',$arr1,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_wise_visit_dts') class="active" @endif>
                                        <a href="{{url('dcrep/doc_wise_visit_dts')}}">Doctor Wise Visit Details</a>
                                    </li>
                                @endif
                                @if(in_array('6',$arr1,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/terr_wise_plan_visit') class="active" @endif>
                                        <a href="{{url('dcrep/terr_wise_plan_visit')}}">Territory Wise Plan VS Visit</a>
                                    </li>
                                @endif

                                @if(in_array('7',$arr1,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dcrep/prescription_survey_report') class="active" @endif>
                                        <a href="{{url('dcrep/prescription_survey_report')}}">Prescription Survey
                                            Report</a>
                                    </li>
                                @endif

                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Raqib -->
                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_vis_sum_rep') class="active" @endif>
                                    <a href="{{url('dcrep/doc_vis_sum_rep')}}">Doctor Visit Summary Report</a>
                                </li>
                                <!-- fatema -->

                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/item_wise_utilize') class="active" @endif>
                                    <a href="{{url('dcrep/item_wise_utilize')}}">Item Wise Utilization</a>
                                </li>
                                <!-- Raqib -->

                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_wise_itm_utl') class="active" @endif>
                                    <a href="{{url('dcrep/doc_wise_itm_utl')}}">Doctor Wise Item Utilization</a>
                                </li>
                                <!-- fatema -->

                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/item_wise_doc_details') class="active" @endif>
                                    <a href="{{url('dcrep/item_wise_doc_details')}}">Item Wise Doctor Details</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/doc_wise_visit_dts') class="active" @endif>
                                    <a href="{{url('dcrep/doc_wise_visit_dts')}}">Doctor Wise Visit Details</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/terr_wise_plan_visit') class="active" @endif>
                                    <a href="{{url('dcrep/terr_wise_plan_visit')}}">Territory Wise Plan VS Visit</a>
                                </li>
                                {{--Sahadat--}}
                                <li @if(Route::getCurrentRoute()->uri() == 'dcrep/prescription_survey_report') class="active" @endif>
                                    <a href="{{url('dcrep/prescription_survey_report')}}">Prescription Survey Report</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                {{--CATEGORY EIGHTEEN END--}}

                {{--CATEGORY THREE START--}}
                {{--Expense Verify  Approve--}}

                @if($data->mcategory == 3 )
                    <li @if(Request::segment(1) == 'expense') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-money"></i> <span>Expense</span></a>
                        <ul class="sub-menu-list">
                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr2 = explode('|', $data->scategory); ?>
                            @if(in_array('1',$arr2,false))
                                <!-- fatema -->
                                    <li @if(Request::segment(2) == 'get_expense_verify_approve') class="active" @endif>
                                        <a href="{{url('expense/get_expense_verify_approve')}}">Expense Verify/Approve
                                            Form</a>
                                    </li>
                            @endif

                            @if(in_array('8',$arr2,false))

                                    <li @if(Request::segment(2) == 'expense_verify_approve_am') class="active" @endif>
                                        <a href="{{url('expense/expense_verify_approve_am')}}">Expense Verify AM</a>
                                    </li>
                            @endif

                                @if(in_array('9',$arr2,false))
                                <!-- fatema -->
                                    <li @if(Request::segment(2) == 'expense_view_mpo') class="active" @endif>
                                        <a href="{{url('expense/expense_view_mpo')}}">Expense View </a>
                                    </li>
                                @endif

                            @if(in_array('2',$arr2,false))
                                <!-- fatema -->
                                    <li @if(Request::segment(2) == 'get_expense_entry_form') class="active" @endif>
                                        <a href="{{url('expense/get_expense_entry_form')}}">Expense Entry Form</a>
                                    </li>
                            @endif
                            @if(in_array('3',$arr2,false))
                                <!-- Raqib -->
                                    <li @if(Request::segment(2) == 'field_expense') class="active" @endif>
                                        <a href="{{url('expense/field_expense')}}">Expense Reports</a>
                                    </li>
                            @endif
                            @if(in_array('4',$arr2,false))
                                <!-- Raqib -->
                                    <li @if(Request::segment(2) == 'eva_report') class="active" @endif>
                                        <a href="{{url('expense/eva_report')}}">Expense Verify/Approve Report</a>
                                    </li>
                            @endif
                            @if(in_array('5',$arr2,false))
                                <!-- Masroor -->
                                    <li @if(Request::segment(2) == 'exp') class="active" @endif>
                                        <a href="{{url('expense/eac_report')}}">Expense Actual/Approve</a>
                                    </li>
                            @endif


                            @if(in_array('6',$arr2,false))
                                <!-- Raqib -->
                                    <li @if(Request::segment(2) == 'expense_stat') class="active" @endif>
                                        <a href="{{url('expense/expense_stat')}}">Expense Statistics</a>
                                    </li>
                            @endif

                            @if(in_array('7',$arr2,false))
                                <!-- Raqib -->
                                    <li @if(Request::segment(2) == 'dmr_report') class="active" @endif>
                                        <a href="{{url('expense/dmr_report')}}">Doctor Info Report</a>
                                    </li>
                            @endif

                        @elseif(strpos($data->scategory,'All') !== false)
                            <!-- fatema -->
                                <li @if(Request::segment(2) == 'get_expense_verify_approve') class="active" @endif>
                                    <a href="{{url('expense/get_expense_verify_approve')}}">Expense Verify/Approve
                                        Form</a>
                                </li>

                                <li @if(Request::segment(2) == 'expense_verify_approve_am') class="active" @endif>
                                    <a href="{{url('expense/expense_verify_approve_am')}}">Expense Verify AM</a>
                                </li>

                                <li @if(Request::segment(2) == 'expense_view_mpo') class="active" @endif>
                                    <a href="{{url('expense/expense_view_mpo')}}">Expense View </a>
                                </li>

                                <!-- fatema -->
                                <li @if(Request::segment(2) == 'get_expense_entry_form') class="active" @endif>
                                    <a href="{{url('expense/get_expense_entry_form')}}">Expense Entry Form</a>
                                </li>
                                <!-- Raqib -->
                                <li @if(Request::segment(2) == 'field_expense') class="active" @endif>
                                    <a href="{{url('expense/field_expense')}}">Expense Reports</a>
                                </li>
                                <!-- Raqib -->
                                <li @if(Request::segment(2) == 'eva_report') class="active" @endif>
                                    <a href="{{url('expense/eva_report')}}">Expense Verify/Approve Report</a>
                                </li>
                                <!-- Raqib -->
                                <li @if(Request::segment(2) == 'exp') class="active" @endif>
                                    <a href="{{url('expense/eac_report')}}">Expense Actual/Approve</a>
                                </li>
                                <!-- Raqib -->
                                <li @if(Request::segment(2) == 'expense_stat') class="active" @endif>
                                    <a href="{{url('expense/expense_stat')}}">Expense Statistics</a>
                                </li>
                                <!-- Raqib -->
                                <li @if(Request::segment(2) == 'dmr_report') class="active" @endif>
                                    <a href="{{url('expense/dmr_report')}}">Doctor Info Report</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--CATEGORY THREE END--}}















                {{--CATEGORY FOUR START--}}

                  {{-- CATEGORY 14 START  Donation  Author :: Sahadat   --}}
                @if($data->mcategory == 4)
                    <li @if(Request::segment(1) == 'rm_portal') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-file-text"></i>
                            <span>RM Portal</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr7 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr7,false))
                                    <li @if(Request::segment(2) == 'regwtlist_report') class="active" @endif>
                                        <a href="{{url('rm_portal/regwtlist_report')}}">Region Wise Terr List</a>
                                    </li>

                                @endif
                                @if(in_array('2',$arr7,false))
                                    <li @if(Request::segment(2) == 'regwDoclist_report') class="active" @endif>
                                        <a href="{{url('rm_portal/regwDoclist_report')}}">Region Wise Doctor List</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr7,false))
                                    <li @if(Request::segment(2) == 'terrRearrange') class="active" @endif>
                                        <a href="{{url('rm_portal/terrRearrange')}}">Territory Rearrange</a>
                                    </li>
                                @endif
                                @if(in_array('4',$arr7,false))
                                    <li @if(Request::segment(2) == 'dp_view') class="active" @endif>
                                        <a href="{{url('rm_portal/dp_view')}}">Doctors Maintenance</a>
                                    </li>
                                @endif
                                @if(in_array('5',$arr7,false))
                                    <li @if(Request::segment(2) == 'doctor_brand') class="active" @endif>
                                        <a href="{{url('rm_portal/doctor_brand')}}">Doctor Brand</a>
                                    </li>
                                @endif
                                @if(in_array('13',$arr7,false))
                                    <li @if(Request::segment(2) == 'doc_brand_sum') class="active" @endif>
                                        <a href="{{url('rm_portal/doc_brand_sum')}}">Doctor Brand Summary</a>
                                    </li>
                                @endif
                            <!--       @if(in_array('6',$arr7,false))
                                <li @if(Request::segment(2) == 'doctorVsPlan') class="active" @endif>
                                        <a href="{{url('rm_portal/doctorVsPlan')}}">Doctor Visit Plan</a>
                                    </li>
                                    @endif -->


                            <!--                        @if(in_array('7',$arr7,false))
                                <li @if(Request::segment(2) == 'itemWiseDoc') class="active" @endif>
                                        <a href="{{url('rm_portal/itemWiseDoc')}}">Item Wise Doctors Delete</a>
                                    <li>
                                        @endif -->


                                @if(in_array('8',$arr7,false))
                                    <li @if(Request::segment(2) == 'brandWiseDoc') class="active" @endif>
                                        <a href="{{url('rm_portal/brandWiseDoc')}}">Brand Wise Doctors Delete</a>
                                    </li>
                                @endif

                                @if(in_array('9',$arr7,false))
                                    <li @if(Request::segment(2) == 'terrbrandWiseExp') class="active" @endif>
                                        <a href="{{url('rm_portal/terrbrandWiseExp')}}">Terr Wise Brand Exposure</a>
                                    </li>
                                @endif
                                @if(in_array('10',$arr7,false))
                                    <li @if(Request::segment(2) == 'dwDocVisitPlan') class="active" @endif>
                                        <a href="{{url('rm_portal/dwDocVisitPlan')}}">Day wise Doctor Visit Plan</a>
                                    <li>
                                @endif
                                @if(in_array('11',$arr7,false))
                                    <li @if(Request::segment(2) == 'docTerrChange') class="active" @endif>
                                        <a href="{{url('rm_portal/docTerrChange')}}">Doctor Territory Rearrange</a>
                                    <li>
                                @endif
                                @if(in_array('12',$arr7,false))
                                    <li @if(Request::segment(2) == 'docWisebrandAssign') class="active" @endif>
                                        <a href="{{url('rm_portal/docWisebrandAssign')}}">Doctor Wise Brand Assign</a>
                                    <li>
                                @endif

                                @if(in_array('14',$arr7,false))
                                    <li @if(Request::segment(2) == 'brandwregdoc') class="active" @endif>
                                        <a href="{{url('rm_portal/brandwregdoc')}}">Brand Wise Regional Doctors</a>
                                    <li>
                                @endif

                                @if(in_array('15',$arr7,false))

                                    <li @if(Request::segment(2) == 'dwDocVisitPlanv2') class="active" @endif>
                                        <a href="{{url('rm_portal/dwDocVisitPlanv2')}}">Monthly Visit Plan</a>
                                    </li>

                                @endif

                                @if(in_array('19',$arr7,false))

                                    <li @if(Request::segment(2) == 'docPlanMonitoring') class="active" @endif>
                                        <a href="{{url('rm_portal/docPlanMonitoring')}}">Doctor Plan Monitoring</a>
                                    </li>

                                @endif
                                @if(in_array('21',$arr7,false))

                                <li @if(Request::segment(2) == 'terrWsalesAchIndex') class="active" @endif>
                                    <a href="{{url('rm_portal/terrWsalesAchIndex')}}">Terr Wise Sales Achievement</a>
                                </li>

                                @endif

                                @if(in_array('24',$arr7,false))
                                    <li @if(Request::segment(2) == 'RmAmWsalesAchIndex') class="active" @endif>
                                        <a href="{{url('rm_portal/RmAmWsalesAchIndex')}}">RM/AM Sales Achievement</a>
                                    </li>
                                @endif

                            <!-- 27.4.2019 -->
                                @if(in_array('16',$arr7,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'due_overdue_invoice') class="active" @endif>
                                        <a href="{{url('rm_portal/due_overdue_invoice')}}">Invoice Due & OverDue</a>
                                    </li>
                                @endif


                            <!-- @if(in_array('16',$arr7,false))

                                <li @if(Request::segment(2) == 'apk_download') class="active" @endif>
                                        <a href="{{url('rm_portal/apk_download')}}">mSFA Application</a>
                                    </li>

                                    @endif -->

                                @if(in_array('17',$arr7,false))

                                    <li @if(Request::segment(2) == 'apk_download') class="active" @endif>
                                        <a href="{{url('rm_portal/apk_download')}}">mSFA Application</a>
                                    </li>

                                @endif

                                @if(in_array('18',$arr7,false))

                                    <li @if(Request::segment(2) == 'apk_download_td') class="active" @endif>
                                        <a href="{{url('rm_portal/apk_download_td')}}">Training & Development
                                            Application</a>
                                    </li>

                                @endif

                                    @if(in_array('22',$arr7,false))

                                        <li @if(Request::segment(2) == 'incepta_nm') class="active" @endif>
                                            <a href="{{url('rm_portal/incepta_nm')}}">Notice Manager Application</a>
                                        </li>

                                    @endif

                                @if(in_array('19',$arr7,false))
                                    <li @if(Request::segment(2) == 'national_stock_medicine') class="active" @endif>
                                        <a href="{{url('rm_portal/national_stock_medicine')}}">National Stock Report</a>
                                    </li>
                                @endif

                                @if(in_array('21',$arr7,false))
                                        <li @if(Request::segment(2) == 'msfa_manual') class="active" @endif>
                                            <a href="{{url('rm_portal/msfa_manual')}}">MSFA Manual</a>
                                        </li>
                                @endif


                                @if(in_array('20',$arr7,false))
                                        @if(explode('|',Auth::user()->remark1)[0] === 'DBAR')
                                        <li @if(Request::segment(2) == 'dabr_home') class="active" @endif>
                                            <a href="{{url('rm_portal/dabr_home')}}">Doctor Marriage/Birthday Reminder
                                                @if(isset($dbmcnt))
                                                    @if($dbmcnt[0]->tc > 0)
                                                        <span class="info-number">
                                                <span class="badge" style="position: inherit;border-radius: 7px;">{{$dbmcnt[0]->tc}}</span>
                                              </span>
                                                    @endif
                                                @endif
                                            </a>
                                        </li>
                                        @endif
                                @endif

                                @if(in_array('23',$arr7,false))
                                        <li @if(Request::segment(2) == 'web_order') class="active" @endif>
                                            <a target="__blank" href="http://app.inceptapharma.com:5011/order_sys?emp_id={{Auth::user()->user_id}}&password={{Auth::user()->raw_password}}">Web Order</a>
                                        </li>
                                @endif


                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Request::segment(2) == 'regwtlist_report') class="active" @endif>
                                    <a href="{{url('rm_portal/regwtlist_report')}}">Region Wise Terr List</a>
                                </li>
                                <li @if(Request::segment(2) == 'regwDoclist_report') class="active" @endif>
                                    <a href="{{url('rm_portal/regwDoclist_report')}}">Region Wise Doctor List</a>
                                </li>
                                <li @if(Request::segment(2) == 'terrRearrange') class="active" @endif>
                                    <a href="{{url('rm_portal/terrRearrange')}}">Territory Rearrange</a>
                                </li>

                                <li @if(Request::segment(2) == 'dp_view') class="active" @endif>
                                    <a href="{{url('rm_portal/dp_view')}}">Doctors Maintenance</a>
                                </li>
                                <li @if(Request::segment(2) == 'doctor_brand') class="active" @endif>
                                    <a href="{{url('rm_portal/doctor_brand')}}">Doctor Brand</a>
                                </li>
                                <li @if(Request::segment(2) == 'doc_brand_sum') class="active" @endif>
                                    <a href="{{url('rm_portal/doc_brand_sum')}}">Doctor Brand Summary</a>
                                </li>
                            <!-- <li @if(Request::segment(2) == 'doctorVsPlan') class="active" @endif>
                                    <a href="{{url('rm_portal/doctorVsPlan')}}">Doctor Visit Plan</a>
                                </li> -->
                            <!-- <li @if(Request::segment(2) == 'itemWiseDoc') class="active" @endif>
                                    <a href="{{url('rm_portal/itemWiseDoc')}}">Item Wise Doctors Delete</a>
                                    <li> -->
                                <li @if(Request::segment(2) == 'brandWiseDoc') class="active" @endif>
                                    <a href="{{url('rm_portal/brandWiseDoc')}}">Brand Wise Doctors Delete</a>
                                </li>

                                <li @if(Request::segment(2) == 'terrbrandWiseExp') class="active" @endif>
                                    <a href="{{url('rm_portal/terrbrandWiseExp')}}">Terr Wise Brand Exposure</a>
                                </li>
                                <li @if(Request::segment(2) == 'dwDocVisitPlan') class="active" @endif>
                                    <a href="{{url('rm_portal/dwDocVisitPlan')}}">Day wise Doctor Visit Plan</a>
                                <li>
                                <li @if(Request::segment(2) == 'docTerrChange') class="active" @endif>
                                    <a href="{{url('rm_portal/docTerrChange')}}">Doctor Territory Rearrange</a>
                                <li>
                                <li @if(Request::segment(2) == 'docWisebrandAssign') class="active" @endif>
                                    <a href="{{url('rm_portal/docWisebrandAssign')}}">Doctor Wise Brand Assign</a>
                                <li>
                                <li @if(Request::segment(2) == 'brandwregdoc') class="active" @endif>
                                    <a href="{{url('rm_portal/brandwregdoc')}}">Brand Wise Regional Doctors</a>
                                <li>
                                <li @if(Request::segment(2) == 'dwDocVisitPlanv2') class="active" @endif>
                                    <a href="{{url('rm_portal/dwDocVisitPlanv2')}}">Monthly Visit Plan</a>
                                </li>

                                <li @if(Request::segment(2) == 'docPlanMonitoring') class="active" @endif>
                                    <a href="{{url('rm_portal/docPlanMonitoring')}}">Doctor Plan Monitoring</a>
                                </li>
                                <li @if(Request::segment(2) == 'terrWsalesAchIndex') class="active" @endif>
                                    <a href="{{url('rm_portal/terrWsalesAchIndex')}}">Terr Wise Sales Achievement</a>
                                </li>
                                <!-- 27.4.2019 -->

                                {{-- 24/04/2024 --}}
                                <li @if(Request::segment(2) == 'RmAmWsalesAchIndex') class="active" @endif>
                                    <a href="{{url('rm_portal/RmAmWsalesAchIndex')}}">RM/AM Sales Achievement</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'due_overdue_invoice') class="active" @endif>
                                    <a href="{{url('rm_portal/due_overdue_invoice')}}">Invoice Due & OverDue</a>
                                </li>

                                <li @if(Request::segment(2) == 'apk_download') class="active" @endif>
                                    <a href="{{url('rm_portal/apk_download')}}">mSFA Application</a>
                                </li>

                                <li @if(Request::segment(2) == 'apk_download_td') class="active" @endif>
                                    <a href="{{url('rm_portal/apk_download_td')}}">Training & Development
                                        Application</a>
                                </li>

                                <li @if(Request::segment(2) == 'incepta_nm') class="active" @endif>
                                    <a href="{{url('rm_portal/incepta_nm')}}">Notice Manager Application</a>
                                </li>

                                <li @if(Request::segment(2) == 'national_stock_medicine') class="active" @endif>
                                    <a href="{{url('rm_portal/national_stock_medicine')}}">National Stock Report</a>
                                </li>

                                 <li @if(Request::segment(2) == 'msfa_manual') class="active" @endif>
                                    <a href="{{url('rm_portal/msfa_manual')}}">MSFA Manual</a>
                                </li>
                                <li @if(Request::segment(2) == 'vacant_territory') class="active" @endif>
                                    <a href="{{url('rm_portal/vacant_territory')}}">Vacant Territory</a>
                                </li>

                                @if(explode('|',Auth::user()->remark1)[0] === 'DBAR')
                                <li @if(Request::segment(2) == 'dabr_home') class="active" @endif>
                                    <a href="{{url('rm_portal/dabr_home')}}">Doctor Marriage/Birthday Reminder
                                        @if(isset($dbmcnt))
                                          @if($dbmcnt[0]->tc > 0)
                                              <span class="info-number">
                                                <span class="badge" style="position: inherit;border-radius: 7px;">{{$dbmcnt[0]->tc}}</span>
                                              </span>
                                          @endif
                                       @endif
                                    </a>
                                </li>
                                @endif

                                <li @if(Request::segment(2) == 'web_order') class="active" @endif>
                                    <a target="__blank" href="http://app.inceptapharma.com:5011/order_sys?emp_id={{Auth::user()->user_id}}&password={{Auth::user()->raw_password}}">Web Order</a>
                                </li>

                            @endif
                        </ul>
                    </li>
                @endif


                {{--CATEGORY FOUR END--}}
                {{--CATEGORY FIVE START--}}

                @if($data->mcategory == 5)
                    <li @if(Request::segment(1) == 'emp_comp') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-user"></i>
                            <span>Employee Competency</span></a>
                        <ul class="sub-menu-list">

                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr8 = explode('|', $data->scategory); ?>
                            @if(in_array('1',$arr8,false))
                                <!-- fatema -->

                                    <li @if(Request::segment(2) == 'get_user_manual') class="active" @endif>
                                        <a href="{{url('emp_comp/get_user_manual')}}">User Manual</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr8,false))
                                    <li @if(Request::segment(2) == 'get_rating_def') class="active" @endif>
                                        <a href="{{url('emp_comp/get_rating_def')}}">Rating Definition</a>
                                    </li>
                                @endif

                            <!-- raqib -->
                                @if(in_array('3',$arr8,false))
                                    <li @if(Request::segment(2) == 'v_es') class="active" @endif>
                                        <a href="{{url('emp_comp/v_es')}}">Employee Supervisor</a>
                                    </li>
                                @endif

                                @if(in_array('4',$arr8,false))
                                    <li @if(Request::segment(2) == 'get_emprating_entry') class="active" @endif>
                                        <a href="{{url('emp_comp/get_emprating_entry')}}">Employee Rating Entry</a>
                                    </li>
                                @endif

                            <!-- raqib -->
                                @if(in_array('5',$arr8,false))
                                    <li @if(Request::segment(2) == 'er_graph') class="active" @endif>
                                        <a href="{{url('emp_comp/er_graph')}}">Employee Rating Graph</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- fatema -->
                                <li @if(Request::segment(2) == 'get_user_manual') class="active" @endif>
                                    <a href="{{url('emp_comp/get_user_manual')}}">User Manual</a>
                                </li>
                                <li @if(Request::segment(2) == 'get_rating_def') class="active" @endif>
                                    <a href="{{url('emp_comp/get_rating_def')}}">Rating Definition</a>
                                </li>
                                <!-- raqib -->
                                <li @if(Request::segment(2) == 'v_es') class="active" @endif>
                                    <a href="{{url('emp_comp/v_es')}}">Employee Supervisor</a>
                                </li>
                                <li @if(Request::segment(2) == 'get_emprating_entry') class="active" @endif>
                                    <a href="{{url('emp_comp/get_emprating_entry')}}">Employee Rating Entry</a>
                                </li>
                                <!-- raqib -->
                                <li @if(Request::segment(2) == 'er_graph') class="active" @endif>
                                    <a href="{{url('emp_comp/er_graph')}}">Employee Rating Graph</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--CATEGORY FIVE END--}}

                {{--CATEGORY SIX START--}}
                @if($data->mcategory == 6)
                    <li @if(Request::segment(1) == 'drep') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-file-text"></i>
                            <span>Daily Report</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr3 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr3,false))
                                    <li>
                                        <a href="#"> National Report</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr3,false))
                                    <li>
                                        <a href="#"> Product Group Wise Depot Sales</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr3,false))
                                    <li>
                                        <a href="#"> Product Wise Depot Sales Value Base </a>
                                    </li>
                                @endif
                                @if(in_array('4',$arr3,false))
                                    <li>
                                        <a href="#"> Product Wise Depot Sales Quantity Base </a>
                                    </li>
                                @endif
                                @if(in_array('5',$arr3,false))
                                    <li>
                                        <a href="#">Depot Daily Remittance</a>
                                    </li>
                                @endif
                                @if(in_array('6',$arr3,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'drep/nat_stock') class="active" @endif>
                                        <a href="#">National Stock</a>
                                    </li>
                                @endif
                                @if(in_array('7',$arr3,false))
                                    <li>
                                        <a href="#">RM Daily Achievement</a>
                                    </li>
                                @endif
                                @if(in_array('8',$arr3,false))
                                    <li>
                                        <a href="#">Patient Invoice Information</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li>
                                    <a href="#"> National Report</a>
                                </li>
                                <li>
                                    <a href="#"> Product Group Wise Depot Sales</a>
                                </li>
                                <li>
                                    <a href="#"> Product Wise Depot Sales Value Base </a>
                                </li>
                                <li>
                                    <a href="#"> Product Wise Depot Sales Quantity Base </a>
                                </li>
                                <li>
                                    <a href="#">Depot Daily Remittance</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'drep/nat_stock') class="active" @endif>
                                    <a href="#">National Stock</a>
                                </li>
                                <li>
                                    <a href="#">RM Daily Achievement</a>
                                </li>
                                <li>
                                    <a href="#">Patient Invoice Information</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--CATEGORY SIX END--}}

                {{--CATEGORY SEVEN START--}}
                @if($data->mcategory == 7)
                    <li class="menu-list"><a href="#"><i class="fa fa-file-text"></i> <span>Analytical Report</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr4 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr4,false))
                                    <li><a href="#"> Company Yearly Month Wise Achievement</a></li>
                                @endif
                                @if(in_array('2',$arr4,false))
                                    <li><a href="#"> Brand Ranking for Depot Sales</a></li>
                                @endif
                                @if(in_array('3',$arr4,false))
                                    <li><a href="#"> Brand Ranking for Institute Sales</a></li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li><a href="#"> Company Yearly Month Wise Achievement</a></li>
                                <li><a href="#"> Brand Ranking for Depot Sales</a></li>
                                <li><a href="#"> Brand Ranking for Institute Sales</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--CATEGORY SEVEN END--}}

                {{--CATEGORY EIGHT START--}}
                @if($data->mcategory == 8)
                    <li class="menu-list"><a href="#"><i class="fa fa-bar-chart-o"></i>
                            <span>Graphical Report</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr5 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr5,false))
                                    <li><a href="#"> Company Growth(Bar Chart)</a></li>
                                @endif
                                @if(in_array('2',$arr5,false))
                                    <li><a href="#"> Company Year Wise Sales Growth Percentage(Bar Chart)</a></li>
                                @endif
                                @if(in_array('3',$arr5,false))
                                    <li><a href="#"> Company Year Wise Sales Percentage(Pie Chart)</a></li>
                                @endif
                                @if(in_array('4',$arr5,false))
                                    <li><a href="#"> Company Yearly Month Wise Sales(Bar Chart)</a></li>
                                @endif
                                @if(in_array('5',$arr5,false))
                                    <li><a href="#"> Company Yearly Month Wise Sales(Line Chart)</a></li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li><a href="#"> Company Growth(Bar Chart)</a></li>
                                <li><a href="#"> Company Year Wise Sales Growth Percentage(Bar Chart)</a></li>
                                <li><a href="#"> Company Year Wise Sales Percentage(Pie Chart)</a></li>
                                <li><a href="#"> Company Yearly Month Wise Sales(Bar Chart)</a></li>
                                <li><a href="#"> Company Yearly Month Wise Sales(Line Chart)</a></li>
                            @endif
                        </ul>
                    </li>

                @endif
                {{--CATEGORY EIGHT END--}}

                {{--CATEGORY NINE START--}}
                {{--UPLOAD_EXPORT_SALES_DATA--}}
                @if($data->mcategory == 10)

                    <li @if(Request::segment(1) == 'dataupload') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-upload"></i> <span>Data Upload</span></a>
                        <ul class="sub-menu-list">
                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr6 = explode('|', $data->scategory); ?>
                            @if(in_array('1',$arr6,false))
                            <!-- fatema -->
                                <li @if(Request::segment(2) == 'up_export_sales_data') class="active" @endif>
                                <!-- <a href="{{url('dataupload/up_export_sales_data')}}">UPLOAD EXPORT SALES DATA</a> -->
                                    <a href="#">UPLOAD EXPORT SALES DATA</a>
                                <li>
                            @endif
                            @if(in_array('2',$arr6,false))
                                <li @if(Request::segment(2) == 'inst_sales_data') class="active" @endif>
                                <!-- <a href="{{url('dataupload/inst_sales_data')}}">UPLOAD INST SALES DATA</a> -->
                                    <a href="#">UPLOAD INST SALES DATA</a>
                                <li>
                            @endif
                            @if(in_array('3',$arr6,false))
                                <li @if(Request::segment(2) == 'upload_brand_sales_data') class="active" @endif>
                                    <a href="{{url('upload_brand_sales_data')}}">UPLOAD INSTITUTE EXPORT BRAND RANKING</a>
                                <li>
                            @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                    <!-- fatema -->
                                <li @if(Request::segment(2) == 'up_export_sales_data') class="active" @endif>
                                    <a href="{{url('dataupload/up_export_sales_data')}}">UPLOAD EXPORT SALES
                                        DATA</a>
                                    <!-- <a href="#">UPLOAD EXPORT SALES DATA</a> -->
                                <li>
                                <li @if(Request::segment(2) == 'inst_sales_data') class="active" @endif>
                                    <a href="{{url('dataupload/inst_sales_data')}}">UPLOAD INST SALES DATA</a>
                                    <!-- <a href="#">UPLOAD INST SALES DATA</a> -->
                                <li>
                                <li @if(Request::segment(2) == 'upload_brand_sales_data') class="active" @endif>
                                    <a href="{{url('upload_brand_sales_data')}}">UPLOAD INSTITUTE EXPORT BRAND RANKING</a>
                                <li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--CATEGORY NINE END--}}

                @if(Auth::user()->user_id == '1015847')

                    @if($data->mcategory == 9)

                        <li @if(Request::segment(1) == 'scm_portal') class="menu-list nav-active"
                            @else class="menu-list" @endif><a href="#"><i class="fa fa-chain"></i> <span> SCM Portal </span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)

                                    <?php $arr7 = explode('|', $data->scategory);?>

                                    {{--  Packaging Material Trail --}}


                                    @if(in_array('17',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_att_share') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_att_share')}}">Add Attachments & Share</a>
                                        </li>
                                    @endif
                                    @if(in_array('18',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_machine_rpt_page') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_machine_rpt_page')}}">Machine Trial Statement</a>
                                        </li>
                                    @endif

                         

                                @elseif(strpos($data->scategory,'All') !== false)
                                    {{--  Packaging Material Trail--}}
                                    
                                    <li @if(Request::segment(2) == 'scm_att_share') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_att_share')}}">Add Attachments & Share</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scm_machine_rpt_page') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_machine_rpt_page')}}">Machine Trial Statement</a>
                                    </li>

                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                
                @if(Auth::user()->user_id == '1006605')

                    @if($data->mcategory == 9)

                        <li @if(Request::segment(1) == 'scm_portal') class="menu-list nav-active"
                            @else class="menu-list" @endif><a href="#"><i class="fa fa-chain"></i> <span> SCM Portal </span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)

                                    <?php $arr7 = explode('|', $data->scategory);?>

                                    {{--  Packaging Material Trail --}}

                                    @if(in_array('16',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_pac_req') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_pac_req')}}">Pack Trial Request Form</a>
                                        </li>
                                    @endif

                                    @if(in_array('17',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_att_share') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_att_share')}}">Add Attachments & Share</a>
                                        </li>
                                    @endif
                                    @if(in_array('18',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_machine_rpt_page') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_machine_rpt_page')}}">Machine Trial Statement</a>
                                        </li>
                                    @endif

                                @elseif(strpos($data->scategory,'All') !== false)
                                    {{--  Packaging Material Trail--}}
                                    <li @if(Request::segment(2) == 'scm_pac_req') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_pac_req')}}">Pack Trial Request Form</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scm_att_share') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_att_share')}}">Add Attachments & Share</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scm_machine_rpt_page') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_machine_rpt_page')}}">Machine Trial Statement</a>
                                    </li>

                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

                @if(Auth::user()->plant_id == '1000')   
                    {{--SCM PROTAL--}}
                    @if($data->mcategory == 9)

                        <li @if(Request::segment(1) == 'scm_portal') class="menu-list nav-active"
                            @else class="menu-list" @endif><a href="#"><i class="fa fa-chain"></i> <span> SCM Portal </span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)
                                    <?php $arr7 = explode('|', $data->scategory); ?>
                                    @if(in_array('1',$arr7,false))
                                        <li @if(Request::segment(2) == 'company_upload_page') class="active" @endif>
                                            <a href="{{url('scm_portal/company_upload_page')}}">Company Info Upload</a>
                                        </li>
                                    @endif
                                    @if(in_array('2',$arr7,false))
                                        <li @if(Request::segment(2) == 'material_upload_page') class="active" @endif>
                                            <a href="{{url('scm_portal/material_upload_page')}}">Block List Data Upload</a>
                                        </li>
                                    @endif
                                    @if(in_array('11',$arr7,false))
                                        <li @if(Request::segment(2) == 'blkListFilesUpload') class="active" @endif>
                                            <a href="{{url('scm_portal/blkListFilesUpload')}}">Block List Files Upload</a>
                                        </li>
                                    @endif
                                    @if(in_array('3',$arr7,false))
                                        <li @if(Request::segment(2) == 'clearance_entry_page') class="active" @endif>
                                            <a href="{{url('scm_portal/clearance_entry_page')}}">Clearance Entry</a>
                                        </li>
                                    @endif
                                    @if(in_array('4',$arr7,false))
                                        <li @if(Request::segment(2) == 'ipl_cc') class="active" @endif>
                                            <a href="{{url('scm_portal/ipl_cc')}}">Clearance Letter</a>
                                        </li>
                                    @endif

                                    @if(in_array('5',$arr7,false))
                                        <li @if(Request::segment(2) == 'bl_statement') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_statement')}}">Block List Statement </a>
                                        </li>
                                    @endif

                                    @if(in_array('8',$arr7,false))
                                        <li @if(Request::segment(2) == 'bl_statement_summary') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_statement_summary')}}">Block List Statement Summary </a>
                                        </li>
                                    @endif

                                    @if(in_array('9',$arr7,false))
                                        <li @if(Request::segment(2) == 'bl_warning') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_warning')}}">Block List Warning Material </a>
                                        </li>
                                    @endif
                                    

                                    {{-- @if(Auth::user()->user_id == '1014927' || Auth::user()->user_id == '1010112') --}}
                                        @if(in_array('14',$arr7,false))
                                            <li @if(Request::segment(2) == 'bl_fp_entry') class="active" @endif>
                                                <a href="{{url('scm_portal/bl_fp_entry')}}">Finish Product Entry</a>
                                            </li>
                                        @endif

                                         @if(in_array('15',$arr7,false))
                                            <li @if(Request::segment(2) == 'applied_blocklist_rpt') class="active" @endif>
                                                <a href="{{url('scm_portal/applied_blocklist_rpt')}}">Applied Blocklist</a>
                                            </li>
                                         @endif

                                        @if(in_array('10',$arr7,false))
                                            <li @if(Request::segment(2) == 'bl_apply_from') class="active" @endif>
                                                <a href="{{url('scm_portal/bl_apply_from')}}">Block List Application Form  </a>
                                            </li>
                                        @endif

                                        @if(in_array('13',$arr7,false))
                                            <li @if(Request::segment(2) == 'bl_from_update') class="active" @endif>
                                                <a href="{{url('scm_portal/bl_from_update')}}">Block List Application Update  </a>
                                            </li>
                                         @endif

                                        @if(in_array('11',$arr7,false))
                                            <li @if(Request::segment(2) == 'bl_apply_rpt') class="active" @endif>
                                                <a href="{{url('scm_portal/bl_apply_rpt')}}">Print BlockList  </a>
                                            </li>
                                         @endif

                                    {{-- @endif --}}

                                    @if(in_array('6',$arr7,false))
                                        <li @if(Request::segment(2) == 'bl_statement_u') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_statement_u')}}">BlockList Available Qty Update </a>
                                        </li>
                                    @endif


                                    @if(in_array('7',$arr7,false))
                                        <li @if(Request::segment(2) == 'cl_statement') class="active" @endif>
                                            <a href="{{url('scm_portal/cl_statement')}}">Clearance Statement </a>
                                        </li>
                                    @endif

                                    @if(in_array('12',$arr7,false))
                                        <li @if(Request::segment(2) == 'dgdaValidSource') class="active" @endif>

                                            <a href="{{ asset('public/SCM/ValidSourceDGDA/ValidSource-DGDA.pdf') }}" target="_blank">Valid Source - DGDA</a>

                                        </li>
                                    @endif


                                    {{--  Packaging Material Trail --}}
                                    @if(in_array('16',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_pac_req') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_pac_req')}}">Pack Trial Request Form</a>
                                        </li>
                                    @endif

                                    @if(in_array('17',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_att_share') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_att_share')}}">Add Attachments & Share</a>
                                        </li>
                                    @endif
                                    @if(in_array('18',$arr7,false))
                                            <li @if(Request::segment(2) == 'scm_machine_rpt_page') class="active" @endif>
                                                <a href="{{url('scm_portal/scm_machine_rpt_page')}}">Machine Trial Statement</a>
                                            </li>
                                    @endif
                            
                                    @if(Auth::user()->user_id == '1000122' || Auth::user()->user_id == '1001893' 
                                    || Auth::user()->user_id == '1010112'  || Auth::user()->user_id == '1017988' 

                                    )
                                        @if(in_array('19',$arr7,false))
                                                <li @if(Request::segment(2) == 'scm_pacTrialRcm_page') class="active" @endif>
                                                    <a href="{{url('scm_portal/scm_pacTrialRcm_page')}}">Machine Trial Recommend</a>
                                                </li>
                                        @endif
                                    @endif

                                    @if(in_array('20',$arr7,false))
                                        <li @if(Request::segment(2) == 'amendment') class="active" @endif>
                                            <a href="{{url('scm_portal/amendment')}}">Amendment Entry</a>
                                        </li>
                                    @endif
                                    
                                    @if(in_array('21',$arr7,false))
                                        <li @if(Request::segment(2) == 'purchase_req_for_raw_mat') class="active" @endif>
                                            <a href="{{url('scm_portal/purchase_req_for_raw_mat')}}">Purchase
                                                Requisition for Raw Materials</a>
                                        </li>
                                    @endif

                                    @if(in_array('22',$arr7,false))
                                        <li @if(Request::segment(2) == 'req_for_raw_mat_update') class="active" @endif>
                                            <a href="{{url('scm_portal/req_for_raw_mat_update')}}">Update
                                                Purchase Requisition</a>
                                        </li>
                                    @endif

                                    @if(in_array('25',$arr7,false))
                                        <li @if(Request::segment(2) == 'comStatementPage') class="active" @endif>
                                            <a href="{{url('scm_portal/comStatementPage')}}">Generate Comparative Statement</a>
                                        </li>
                                    @endif

                                    @if(in_array('23',$arr7,false))
                                        <li @if(Request::segment(2) == 'scm_notice') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_notice')}}">SCM Notice Upload</a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->user_id == '1020386' || Auth::user()->user_id == '1005975')
                                        @if(in_array('26',$arr7,false))
                                            <li @if(Request::segment(2) == 'mat_purchase_info') class="active" @endif>
                                                <a href="{{url('scm_portal/mat_purchase_info')}}">Material Purchase
                                                    Information</a>
                                            </li>
                                        @endif
                                        @if(in_array('27',$arr7,false))
                                            <li @if(Request::segment(2) == 'mat_purchase_report') class="active" @endif>
                                                <a href="{{url('scm_portal/mat_purchase_report')}}">Material Purchase
                                                    Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('28',$arr7,false))
                                            <li @if(Request::segment(2) == 'committed_report') class="active"
                                                    @endif>
                                                <a href="{{url('scm_portal/committed_report')}}">Finance Report -
                                                    Capex/Raw pack committed</a>
                                            </li>
                                        @endif
                                        @if(in_array('29',$arr7,false))
                                            <li @if(Request::segment(2) == 'uncommitted_report')
                                                class="active" @endif>
                                                <a href="{{url('scm_portal/uncommitted_report')}}">Finance Report -
                                                    Capex uncommitted</a>
                                            </li>
                                        @endif
                                         @if(in_array('30',$arr7,false))
                                            <li @if(Request::segment(2) == 'scmDataModification') class="active" @endif>
                                                <a href="{{url('scm_portal/scmDataModification')}}">Input data management</a>
                                            </li>
                                            @endif
                                    @endif

                                @elseif(strpos($data->scategory,'All') !== false)

                                    <li @if(Request::segment(2) == 'company_upload_page') class="active" @endif>
                                        <a href="{{url('scm_portal/company_upload_page')}}">Company Info Upload</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'material_upload_page') class="active" @endif>
                                        <a href="{{url('scm_portal/material_upload_page')}}">Block List Data Upload</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'blkListFilesUpload') class="active" @endif>
                                        <a href="{{url('scm_portal/blkListFilesUpload')}}">Block List Files Upload</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'clearance_entry_page') class="active" @endif>
                                        <a href="{{url('scm_portal/clearance_entry_page')}}">Clearance Entry</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'ipl_cc') class="active" @endif>
                                        <a href="{{url('scm_portal/ipl_cc')}}">Clearance Letter </a>
                                    </li>
                                    <li @if(Request::segment(2) == 'bl_statement') class="active" @endif>
                                        <a href="{{url('scm_portal/bl_statement')}}">Block List Statement </a>
                                    </li>
                                    <li @if(Request::segment(2) == 'bl_statement_summary') class="active" @endif>
                                        <a href="{{url('scm_portal/bl_statement_summary')}}">Block List Statement Summary </a>
                                    </li>
                                    <li @if(Request::segment(2) == 'bl_warning') class="active" @endif>
                                        <a href="{{url('scm_portal/bl_warning')}}">Block List Warning Material </a>
                                    </li>
                                    {{-- @if(Auth::user()->user_id == '1014927' || Auth::user()->user_id == '1010112') --}}
                                        <li @if(Request::segment(2) == 'bl_fp_entry') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_fp_entry')}}">Finish Product Entry</a>
                                        </li>
                                         <li @if(Request::segment(2) == 'applied_blocklist_rpt') class="active" @endif>
                                                <a href="{{url('scm_portal/applied_blocklist_rpt')}}">Applied Blocklist</a>
                                         </li>

                                        <li @if(Request::segment(2) == 'bl_apply_from') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_apply_from')}}">Block List Application Form  </a>
                                        </li>
                                       
                                        <li @if(Request::segment(2) == 'bl_from_update') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_from_update')}}">Block List Application Update  </a>
                                        </li>
                                    
                                        <li @if(Request::segment(2) == 'bl_apply_rpt') class="active" @endif>
                                            <a href="{{url('scm_portal/bl_apply_rpt')}}">Print BlockList  </a>
                                        </li>
                                    {{-- @endif --}}
                                    <li @if(Request::segment(2) == 'bl_statement_u') class="active" @endif>
                                        <a href="{{url('scm_portal/bl_statement_u')}}">BlockList Available Qty Update </a>
                                    </li>
                                    <li @if(Request::segment(2) == 'cl_statement') class="active" @endif>
                                        <a href="{{url('scm_portal/cl_statement')}}">Clearance Statement </a>
                                    </li>

                                    <li @if(Request::segment(2) == 'dgdaValidSource') class="active" @endif>
                                        <a href="{{ asset('public/SCM/ValidSourceDGDA/ValidSource-DGDA.pdf') }}" target="_blank">Valid Source - DGDA</a>
                                    </li>

                                     {{--  Packaging Material Trail--}}
                                     <li @if(Request::segment(2) == 'scm_pac_req') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_pac_req')}}">Pack Trial Request Form</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scm_att_share') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_att_share')}}">Add Attachments & Share</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scm_machine_rpt_page') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_machine_rpt_page')}}">Machine Trial Statement</a>
                                    </li>

                                    @if(Auth::user()->user_id == '1000122' || Auth::user()->user_id == '1001893' 
                                    || Auth::user()->user_id == '1010112' || Auth::user()->user_id == '1017988' )
                                        <li @if(Request::segment(2) == 'scm_pacTrialRcm_page') class="active" @endif>
                                            <a href="{{url('scm_portal/scm_pacTrialRcm_page')}}">Machine Trial Recommend</a>
                                        </li>
                                    @endif

                                    <li @if(Request::segment(2) == 'amendment') class="active" @endif>
                                        <a href="{{url('scm_portal/amendment')}}">Amendment Entry</a>
                                    </li>
                                    
                                    <li @if(Request::segment(2) == 'purchase_req_for_raw_mat') class="active" @endif>
                                        <a href="{{url('scm_portal/purchase_req_for_raw_mat')}}">Purchase
                                            Requisition for Raw Materials</a>
                                    </li>
                                     <li @if(Request::segment(2) == 'req_for_raw_mat_update') class="active" @endif>
                                        <a href="{{url('scm_portal/req_for_raw_mat_update')}}">Update
                                            Purchase Requisition</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'comStatementPage') class="active" @endif>
                                        <a href="{{url('scm_portal/comStatementPage')}}">Generate Comparative Statement</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scm_notice') class="active" @endif>
                                        <a href="{{url('scm_portal/scm_notice')}}">SCM Notice Upload</a>
                                    </li>
                                    @if(Auth::user()->user_id == '1020386' || Auth::user()->user_id == '1005975')
                                        <li @if(Request::segment(2) == 'mat_purchase_info') class="active" @endif>
                                            <a href="{{url('scm_portal/mat_purchase_info')}}">Material Purchase
                                                Information</a>
                                        </li>
                                        <li @if(Request::segment(2) == 'mat_purchase_report') class="active" @endif>
                                            <a href="{{url('scm_portal/mat_purchase_report')}}">Material Purchase
                                                Report</a>
                                        </li>
                                        <li @if(Request::segment(2) == 'committed_report') class="active"
                                                @endif>
                                            <a href="{{url('scm_portal/committed_report')}}">Finance Report -
                                                Capex/Raw pack committed</a>
                                        </li>
                                        <li @if(Request::segment(2) == 'uncommitted_report')
                                            class="active" @endif>
                                            <a href="{{url('scm_portal/uncommitted_report')}}">Finance Report -
                                                Capex uncommitted</a>
                                        </li>
                                        <li @if(Request::segment(2) == 'scmDataModification') class="active" @endif>
                                            <a href="{{url('scm_portal/scmDataModification')}}">Input data management</a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </li>
                    @endif 
                @endif

                @if($data->mcategory == 12)

                    <li @if(Request::segment(1) == 'sms') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-envelope"></i>
                            <span>SMS Gateway</span></a>
                        <ul class="sub-menu-list">

                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr1 = explode('|', $data->scategory); ?>

                            @if(in_array('1',$arr1,false))
                                <!-- Raqib -->
                                    <li @if(Route::getCurrentRoute()->uri() == 'sms/send_sms') class="active" @endif>
                                        <a href="{{route('send_sms')}}">Send SMS</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Route::getCurrentRoute()->uri() == 'sms/send_sms') class="active" @endif>
                                    <a href="{{route('send_sms')}}">Send SMS</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                @endif


                {{--ELM PROTAL--}}
                @if($data->mcategory == 13)
                    <li @if(Request::segment(1) == 'elm_portal') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-users"></i>
                            <span> Leave Management </span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr7 = explode('|', $data->scategory); ?>
                                @if(in_array('13',$arr7,false))
                                    <li @if(Request::segment(2) == 'elmDashboard') class="active" @endif>
                                        <a href="{{url('elm_portal/elmDashboard')}}" onclick="showLoader()">Dashboard</a>
                                    </li>
                                @endif
                        
                                @if(in_array('1',$arr7,false))
                                    <li @if(Request::segment(2) == 'apply_leave') class="active" @endif>
                                        <a href="{{url('elm_portal/apply_leave')}}">Apply Leave</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr7,false))
                                    <li @if(Request::segment(2) == 'my_application') class="active" @endif>
                                        <a href="{{url('elm_portal/my_application')}}">My Application</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr7,false))
                                    <li @if(Request::segment(2) == 'req_application') class="active" @endif>
                                        <a href="{{url('elm_portal/req_application')}}">Requested Application</a>
                                    </li>
                                @endif
                                @if(in_array('21',$arr7,false))
                                    <li @if(Request::segment(2) == 'my_attendance') class="active" @endif>
                                        <a href="{{url('elm_portal/my_attendance')}}">My Attendance</a>
                                    </li>
                                @endif
                                @if(in_array('4',$arr7,false))
                                    <li @if(Request::segment(2) == 'primary_aprv') class="active" @endif>
                                        <a href="{{url('elm_portal/primary_aprv_master')}}">Recommend </a>
                                    </li>
                                @endif
                                @if(in_array('5',$arr7,false))
                                    <li @if(Request::segment(2) == 'secondary_aprv') class="active" @endif>
                                        <a href="{{url('elm_portal/secondary_aprv_master')}}">Approve </a>
                                    </li>
                                @endif
                                @if(in_array('18',$arr7,false))
                                    <li @if(Request::segment(2) == 'secondary_aprv_pending') class="active" @endif>
                                        <a href="{{url('elm_portal/secondary_aprv_pending')}}">Pending Approval</a>
                                    </li>
                                @endif
                                @if(in_array('6',$arr7,false))
                                    <li @if(Request::segment(2) == 'leave_approval_hr') class="active" @endif>
                                        <a href="{{url('elm_portal/leave_approval_hr')}}">Leave Approval</a>
                                    </li>
                                @endif
                                @if(in_array('7',$arr7,false))
                                    <li @if(Request::segment(2) == 'plan_headapproval') class="active" @endif>
                                        <a href="{{url('elm_portal/plan_headapproval')}}">Plant Head Approval</a>
                                    </li>
                                @endif


                                @if(in_array('9',$arr7,false))
                                    <li @if(Request::segment(2) == 'elmLeveInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/elmLeveInfo')}}">Employee Master Data</a>
                                    </li>
                                @endif
                                @if(in_array('10',$arr7,false))
                                    <li @if(Request::segment(2) == 'elmplheadInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/elmplheadInfo')}}">Plant Head Master Data</a>
                                    </li>
                                @endif
                                @if(in_array('11',$arr7,false))
                                    <li @if(Request::segment(2) == 'elmMatInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/elmMatInfo')}}">Maternity Master Data</a>
                                    </li>
                                @endif
                                @if(in_array('12',$arr7,false))
                                    <li @if(Request::segment(2) == 'elmRoleInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/elmRoleInfo')}}">Role Information</a>
                                    </li>
                                @endif
                                @if(in_array('15',$arr7,false))
                                    <li @if(Request::segment(2) == 'elmDashboard') class="active" @endif>
                                        <a href="{{url('elm_portal/elmLvCancel')}}">Leave Cancellation</a>
                                    </li>
                                @endif
                                @if(in_array('14',$arr7,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'elm_portal/empInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/empInfo')}}">Delete Leave</a>
                                    </li>
                                @endif

                                @if(in_array('16',$arr7,false))
                                    <li @if(Request::segment(2) ==  'elmAttenReport') class="active" @endif>
                                        <a href="{{url('elm_portal/elmAttenReport')}}">Attendance Report</a>
                                    </li>
                                @endif

                                @if(in_array('8',$arr7,false))
                                    <li @if(Request::segment(2) == 'LeaveSummary') class="active" @endif>
                                        <a href="{{url('elm_portal/LeaveSummary')}}">Leave Summary Report</a>
                                    </li>
                                @endif
                                @if(in_array('20',$arr7,false))
                                    <li @if(Request::segment(2) == 'empLeaveDetails') class="active" @endif>
                                        <a href="{{url('elm_portal/empLeaveDetails ')}}">Emp Leave Details Report</a>
                                    </li>
                                @endif
                                @if(in_array('19',$arr7,false))
                                    <li @if(Request::segment(2) ==  'jobReport') class="active" @endif>
                                        <a href="{{url('elm_portal/jobReport')}}">Job Card</a>
                                    </li>

                                @endif

                                @if( Auth::user()->user_id == '1015729' || Auth::user()->user_id == '1010112'  || Auth::user()->user_id == '1005872' || Auth::user()->user_id == '1015790' || Auth::user()->user_id == '1018516')
                                    @if(in_array('17',$arr7,false))
                                        <li @if(Request::segment(2) ==  'elmNonMgtP') class="active" @endif>
                                            <a href="{{url('elm_portal/elmNonMgtP')}}">Non Mgt. Password</a>
                                        </li>
                                    @endif
                                @endif

                                @if( Auth::user()->user_id == '1002681' || Auth::user()->user_id == '1010112' || Auth::user()->user_id == '1003973' || Auth::user()->user_id == '1010480')
                                    @if(in_array('22',$arr7,false))
                                        <li @if(Request::segment(2) ==  'depot_pending') class="active" @endif>
                                            <a href="{{url('elm_portal/depot_pending')}}">Depot Pending Leave</a>
                                        </li>
                                    @endif
                                    @if(in_array('23',$arr7,false))
                                        <li @if(Request::segment(2) ==  'depot_transfer') class="active" @endif>
                                            <a href="{{url('elm_portal/depot_transfer')}}">Employee Transfer</a>
                                        </li>
                                    @endif
                                @endif
                                @if(in_array('24',$arr7,false))
                                    <li @if(Request::segment(2) == 'facManagerInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/facManagerInfo ')}}">Factory Manager Information</a>
                                    </li>
                                @endif
                                @if(in_array('25',$arr7,false))
                                    <li @if(Request::segment(2) == 'facRCMuserInfo') class="active" @endif>
                                        <a href="{{url('elm_portal/facRCMuserInfo ')}}">Factory RCM User Info</a>
                                    </li>
                                @endif
                                @if(in_array('26',$arr7,false))
                                    <li @if(Request::segment(2) == 'dissimilarEmployee') class="active" @endif>
                                        <a href="{{url('elm_portal/dissimilarEmployee ')}}">Dissimilar Employee</a>
                                    </li>
                                @endif
                                @if(in_array('27',$arr7,false))
                                    <li @if(Request::segment(2) == 'leave-delegate') class="active" @endif>
                                        <a href="{{url('elm_portal/leave-delegate ')}}">Leave Delegate</a>
                                    </li>
                                @endif



                            @elseif(strpos($data->scategory,'All') !== false)

                                <li @if(Request::segment(2) == 'elmDashboard') class="active" @endif>
                                    <a href="{{url('elm_portal/elmDashboard')}}" onclick="showLoader()">Dashboard</a>
                                </li>

                                <li @if(Request::segment(2) == 'apply_leave') class="active" @endif>
                                    <a href="{{url('elm_portal/apply_leave')}}">Apply Leave</a>
                                </li>
                                <li @if(Request::segment(2) == 'my_application') class="active" @endif>
                                    <a href="{{url('elm_portal/my_application')}}">My Application</a>
                                </li>
                                <li @if(Request::segment(2) == 'req_application') class="active" @endif>
                                    <a href="{{url('elm_portal/req_application')}}">Requested Application</a>
                                </li>
                                <li @if(Request::segment(2) == 'my_attendance') class="active" @endif>
                                    <a href="{{url('elm_portal/my_attendance')}}">My Attendance</a>
                                </li>
                                <li @if(Request::segment(2) == 'primary_aprv') class="active" @endif>
                                    <a href="{{url('elm_portal/primary_aprv_master')}}">Recommend</a>
                                </li>
                                <li @if(Request::segment(2) == 'secondary_aprv') class="active" @endif>
                                    <a href="{{url('elm_portal/secondary_aprv_master')}}">Approve</a>
                                </li>
                                <li @if(Request::segment(2) == 'secondary_aprv_pending') class="active" @endif>
                                    <a href="{{url('elm_portal/secondary_aprv_pending')}}">Pending Approval</a>
                                </li>
                                <li @if(Request::segment(2) == 'leave_approval_hr') class="active" @endif>
                                    <a href="{{url('elm_portal/leave_approval_hr')}}">Leave Approval</a>
                                </li>
                                <li @if(Request::segment(2) == 'plan_headapproval') class="active" @endif>
                                    <a href="{{url('elm_portal/plan_headapproval')}}">Plant Head Approval</a>
                                </li>

                                <li @if(Request::segment(2) == 'elmLeveInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/elmLeveInfo')}}">Employee Master Data</a>
                                </li>
                                <li @if(Request::segment(2) == 'elmplheadInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/elmplheadInfo')}}">Plant Head Master Data</a>
                                </li>
                                <li @if(Request::segment(2) == 'elmMatInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/elmMatInfo')}}">Maternity Master Data</a>
                                </li>
                                <li @if(Request::segment(2) == 'elmRoleInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/elmRoleInfo')}}">Role Information</a>
                                </li>
                                <li @if(Request::segment(2) == 'elmDashboard') class="active" @endif>
                                    <a href="{{url('elm_portal/elmLvCancel')}}">Leave Cancellation</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'elm_portal/empInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/empInfo')}}">Delete Leave</a>
                                </li>

                                <li @if(Request::segment(2)  == 'elmAttenReport') class="active" @endif>
                                    <a href="{{url('elm_portal/elmAttenReport')}}">Attendance Report</a>
                                </li>
                                <li @if(Request::segment(2) == 'LeaveSummary') class="active" @endif>
                                    <a href="{{url('elm_portal/LeaveSummary')}}">Leave Summary Report</a>
                                </li>
                                <li @if(Request::segment(2) == 'empLeaveDetails') class="active" @endif>
                                    <a href="{{url('elm_portal/empLeaveDetails ')}}">Emp Leave Details Report</a>
                                </li>
                                <li @if(Request::segment(2) ==  'jobReport') class="active" @endif>
                                    <a href="{{url('elm_portal/jobReport')}}">Job Card</a>
                                </li>

                                @if(Auth::user()->user_id == '1015729' || Auth::user()->user_id == '1010112'  || Auth::user()->user_id == '1005872' )
                                    <li @if(Request::segment(2) ==  'elmNonMgtP') class="active" @endif>
                                        <a href="{{url('elm_portal/elmNonMgtP')}}">Non Mgt. Password</a>
                                    </li>
                                @endif
                                
                                @if(Auth::user()->user_id == '1002681' || Auth::user()->user_id == '1010112'
                                 || Auth::user()->user_id == '1005975' || Auth::user()->user_id == '1003973' || Auth::user()->user_id == '1010480')
                                <li @if(Request::segment(2) ==  'depot_pending') class="active" @endif>
                                    <a href="{{url('elm_portal/depot_pending')}}">Depot Pending Leave</a>
                                </li>
                                <li @if(Request::segment(2) ==  'depot_transfer') class="active" @endif>
                                    <a href="{{url('elm_portal/depot_transfer')}}">Employee Transfer</a>
                                </li>
                                @endif
                                
                                <li @if(Request::segment(2) ==  'facManagerInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/facManagerInfo')}}">Factory Manager Information</a>
                                </li>
                                <li @if(Request::segment(2) == 'facRCMuserInfo') class="active" @endif>
                                    <a href="{{url('elm_portal/facRCMuserInfo ')}}">Factory RCM User Info</a>
                                </li>
                                  <li @if(Request::segment(2) == 'dissimilarEmployee') class="active" @endif>
                                    <a href="{{url('elm_portal/dissimilarEmployee ')}}">Dissimilar Employee</a>
                                </li>
                                <li @if(Request::segment(2) == 'leave-delegate') class="active" @endif>
                                    <a href="{{url('elm_portal/leave-delegate ')}}">Leave Delegate</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


               
                {{-- CATEGORY 14 START  Donation  Author :: Sahadat   --}}
                @if($data->mcategory == 14)
                    @foreach($research_users as $rUsers)
                        @if($rUsers->user_id === Auth::user()->user_id)
                            <li @if(Request::segment(1) == 'donation') class="menu-list nav-active"
                                @else class="menu-list" @endif>
                                <a href="#"><i class="fa fa-briefcase"></i> <span>Research Expense</span></a>
                                <ul class="sub-menu-list">
                                    @if(strpos($data->scategory,'|') !== false)
                                        <?php $arr9 = explode('|', $data->scategory); ?>
                                        @if(in_array('33',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/ssd_expense_calculation') class="active" @endif>
                                                <a href="{{url('donation/ssd_expense_calculation')}}">SSD Expense calculation</a>
                                            </li>
                                        @endif
                                        @if(in_array('28',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_view') class="active" @endif>
                                                <a href="{{url('donation/cash_process_view')}}">Cash Process FI</a>
                                            </li>
                                        @endif


                                        @if(in_array('29',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_rm_view') class="active" @endif>
                                                <a href="{{url('donation/cash_process_rm_view')}}">Cash Process RM</a>
                                            </li>
                                        @endif
                                        @if(in_array('30',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_depot_view') class="active" @endif>
                                                <a href="{{url('donation/cash_process_depot_view')}}">Cash Process Depot</a>
                                            </li>
                                        @endif
                                        @if(in_array('26',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_order_status') class="active" @endif>
                                                <a href="{{url('donation/pay_order_status')}}">Pay Order Status</a>
                                            </li>
                                        @endif
                                        @if(in_array('27',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_order_report_view') class="active" @endif>
                                                <a href="{{url('donation/pay_order_report_view')}}">Pay Order Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('17',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/cost_center_budget') class="active" @endif>
                                                <a href="{{url('donation/cost_center_budget')}}">Cost Center Budget</a>
                                            </li>
                                        @endif
                                        @if(in_array('20',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/budget_report_monthly') class="active" @endif>
                                                <a href="{{url('donation/budget_report_monthly')}}">Budget Monthly Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('23',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/re_report_fi') class="active" @endif>
                                                <a href="{{url('donation/re_report_fi')}}">RE Report FI</a>
                                            </li>
                                        @endif
                                        @if(in_array('19',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/budget_report') class="active" @endif>
                                                <a href="{{url('donation/budget_report')}}">Budget Summary Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('31',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/fi_misc') class="active" @endif>
                                                <a href="{{url('donation/fi_misc')}}">FI Misc</a>
                                            </li>
                                        @endif
                                        @if(in_array('25',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/business_promotion') class="active" @endif>
                                                <a href="{{url('donation/business_promotion')}}">Business Promotion</a>
                                            </li>
                                        @endif
                                        @if(in_array('21',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/request_status_for_ssd') class="active" @endif>
                                                <a href="{{url('donation/request_status_for_ssd')}}">Requisition Status For
                                                    SSD</a>
                                            </li>
                                        @endif
                                        @if(in_array('18',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/budget_closing') class="active" @endif>
                                                <a href="{{url('donation/budget_closing')}}">Budget Closing</a>
                                            </li>
                                        @endif
                                        @if(in_array('16',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/sub_cost_center_budget') class="active" @endif>
                                                <a href="{{url('donation/sub_cost_center_budget')}}">Sub Cost Center Budget</a>
                                            </li>
                                        @endif
                                        @if(in_array('1',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/donation_requisition') class="active" @endif>
                                                <a href="{{url('donation/donation_requisition')}}">Requisition</a>
                                            </li>
                                        @endif
                                        @if(in_array('2',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/requisition_verification') class="active" @endif>
                                                <a href="{{url('donation/requisition_verification')}}">Requisition
                                                    Verification</a>
                                            </li>
                                        @endif
                                        @if(in_array('11',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/verified_not_verified') class="active" @endif>
                                                <a href="{{url('donation/verified_not_verified')}}">Verified not Verified
                                                    Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('12',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/donation_requisition_exception') class="active" @endif>
                                                <a href="{{url('donation/donation_requisition_exception')}}">Requisition
                                                    Exception</a>
                                            </li>
                                        @endif
                                        @if(in_array('9',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/pending_request') class="active" @endif>
                                                <a href="{{url('donation/pending_request')}}">Pending Request</a>
                                            </li>
                                        @endif
                                        @if(in_array('32',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/vacant_territory') class="active" @endif>
                                                <a href="{{url('donation/vacant_territory')}}">Vacant Territory</a>
                                            </li>
                                        @endif
                                        @if(in_array('3',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/ssd_report_process') class="active" @endif>
                                                <a href="{{url('donation/ssd_report_process')}}">SSD Report Process</a>
                                            </li>
                                        @endif
                                        @if(in_array('13',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/doc_wise_view') class="active" @endif>
                                                <a href="{{url('donation/doc_wise_view')}}">Beneficiary wise Expense Details</a>
                                            </li>
                                        @endif
                                        @if(in_array('24',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/infavor_correction_view') class="active" @endif>
                                                <a href="{{url('donation/infavor_correction_view')}}">Infavor Of Correction</a>
                                            </li>
                                        @endif
                                        @if(in_array('4',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/amgm_approval') class="active" @endif>
                                                <a href="{{url('donation/amgm_approval')}}">Requisition Approval</a>
                                            </li>
                                        @endif
                                        @if(in_array('5',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/fi_process') class="active" @endif>
                                                <a href="{{url('donation/fi_process')}}">Finance Process</a>
                                            </li>
                                        @endif
                                        @if(in_array('6',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/cheque_advice') class="active" @endif>
                                                <a href="{{url('donation/cheque_advice')}}">Cheque Advice</a>
                                            </li>
                                        @endif
                                        @if(in_array('34',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/beftn_advice') class="active"
                                                    @endif>
                                                <a href="{{url('donation/beftn_advice')}}">BEFTN Advice</a>
                                            </li>
                                        @endif
                                        @if(in_array('35',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/beftn_maintain') class="active"
                                                    @endif>
                                                <a href="{{url('donation/beftn_maintain')}}">BEFTN Maintenance</a>
                                            </li>
                                        @endif

                                        @if(in_array('7',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_advice') class="active" @endif>
                                                <a href="{{url('donation/cash_advice')}}">Cash Advice</a>
                                            </li>
                                        @endif
                                        @if(in_array('22',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/finance_record_monthly') class="active" @endif>
                                                <a href="{{url('donation/finance_record_monthly')}}">Finance Record Monthly</a>
                                            </li>
                                        @endif
                                        @if(in_array('8',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri()=='donation/budget_expense_report') class="active" @endif>
                                                <a href="{{url('donation/budget_expense_report')}}">Budget VS Expense Report</a>
                                            </li>
                                        @endif
                                        {{-- @if(in_array('10',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_list') class="active" @endif>
                                            <a href="{{url('donation/pay_list')}}">Pay List Report</a>
                                        </li>
                                        @endif  --}}
                                        @if(in_array('14',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_list_dw') class="active" @endif>
                                                <a href="{{url('donation/pay_list_dw')}}">Pay List Report Depot Wise</a>
                                            </li>
                                        @endif
                                        @if(in_array('15',$arr9,false))
                                            <li @if(Route::getCurrentRoute()->uri() == 'donation/reqexp_v') class="active" @endif>
                                                <a href="{{url('donation/reqexp_v')}}">Requisition Exception HO</a>
                                            </li>
                                        @endif
                                    @elseif(strpos($data->scategory,'All') !== false)
                                    <!-- Sahadat -->

                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/ssd_expense_calculation') class="active" @endif>
                                            <a href="{{url('donation/ssd_expense_calculation')}}">SSD Expense calculation</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_view') class="active" @endif>
                                            <a href="{{url('donation/cash_process_view')}}">Cash Process FI</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_mail_report') class="active" @endif>
                                            <a href="{{url('donation/cash_process_mail_report')}}">Cash Process Mail Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_rm_view') class="active" @endif>
                                            <a href="{{url('donation/cash_process_rm_view')}}">Cash Process RM</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_process_depot_view') class="active" @endif>
                                            <a href="{{url('donation/cash_process_depot_view')}}">Cash Process Depot</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_order_status') class="active" @endif>
                                            <a href="{{url('donation/pay_order_status')}}">Pay Order Status</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_order_report_view') class="active" @endif>
                                            <a href="{{url('donation/pay_order_report_view')}}">Pay Order Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cost_center_budget') class="active" @endif>
                                            <a href="{{url('donation/cost_center_budget')}}">Cost Center Budget</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/budget_report_monthly') class="active" @endif>
                                            <a href="{{url('donation/budget_report_monthly')}}">Budget Monthly Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/re_report_fi') class="active" @endif>
                                            <a href="{{url('donation/re_report_fi')}}">RE Report FI</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/budget_report') class="active" @endif>
                                            <a href="{{url('donation/budget_report')}}">Budget Summary Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/fi_misc') class="active" @endif>
                                            <a href="{{url('donation/fi_misc')}}">FI Misc</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/business_promotion') class="active" @endif>
                                            <a href="{{url('donation/business_promotion')}}">Business Promotion</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/budget_closing') class="active" @endif>
                                            <a href="{{url('donation/budget_closing')}}">Budget Closing</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/sub_cost_center_budget') class="active" @endif>
                                            <a href="{{url('donation/sub_cost_center_budget')}}">Sub Cost Center Budget</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/donation_requisition') class="active" @endif>
                                            <a href="{{url('donation/donation_requisition')}}">Requisition</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/donation_requisition_exception') class="active" @endif>
                                            <a href="{{url('donation/donation_requisition_exception')}}">Requisition
                                                Exception</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/requisition_verification') class="active" @endif>
                                            <a href="{{url('donation/requisition_verification')}}">Requisition Verification</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/ssd_report_process') class="active" @endif>
                                            <a href="{{url('donation/ssd_report_process')}}">SSD Report Process</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/request_status_for_ssd') class="active" @endif>
                                            <a href="{{url('donation/request_status_for_ssd')}}">Requisition Status For SSD</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/doc_wise_view') class="active" @endif>
                                            <a href="{{url('donation/doc_wise_view')}}">Beneficiary wise Expense Details</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/infavor_correction_view') class="active" @endif>
                                            <a href="{{url('donation/infavor_correction_view')}}">Infavor Of Correction</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/amgm_approval') class="active" @endif>
                                            <a href="{{url('donation/amgm_approval')}}">Requisition Approval</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/fi_process') class="active" @endif>
                                            <a href="{{url('donation/fi_process')}}">Finance Process</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cheque_advice') class="active" @endif>
                                            <a href="{{url('donation/cheque_advice')}}">Cheque Advice</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/beftn_advice') class="active" @endif>
                                            <a href="{{url('donation/beftn_advice')}}">BEFTN Advice</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/beftn_maintain') class="active"@endif>
                                            <a href="{{url('donation/beftn_maintain')}}">BEFTN Maintenance</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/cash_advice') class="active" @endif>
                                            <a href="{{url('donation/cash_advice')}}">Cash Advice</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/finance_record_monthly') class="active" @endif>
                                            <a href="{{url('donation/finance_record_monthly')}}">Finance Record Monthly</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri()== 'donation/budget_expense_report') class="active" @endif>
                                            <a href="{{url('donation/budget_expense_report')}}">Budget VS Expense Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/pending_request') class="active" @endif>
                                            <a href="{{url('donation/pending_request')}}">Pending Request</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/vacant_territory') class="active" @endif>
                                            <a href="{{url('donation/vacant_territory')}}">Vacant Territory</a>
                                        </li>
                                        {{-- <!-- <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_list') class="active" @endif>
                                              <a href="{{url('donation/pay_list')}}">Pay List Report</a>
                                          </li> --> --}}

                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/pay_list_dw') class="active" @endif>
                                            <a href="{{url('donation/pay_list_dw')}}">Pay List Report Depot Wise</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/verified_not_verified') class="active" @endif>
                                            <a href="{{url('donation/verified_not_verified')}}">Verified not Verified Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'donation/reqexp_v') class="active" @endif>
                                            <a href="{{url('donation/reqexp_v')}}">Requisition Exception HO</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif
                {{--CATEGORY 14 END--}}
            


























                {{-- CATEGORY 24 START  Medicine Requisition  Author :: Sahadat   --}}

                @if($data->mcategory == 24)

                    <li @if(Request::segment(1) == 'dmr') class="menu-list nav-active"
                        @else class="menu-list" @endif>
                        <a href="#"><i class="fa fa-medkit"></i> <span>Medicine Requisition</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr9 = explode('|', $data->scategory); ?>

                                    @if(in_array('8',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'dmr/rm_dsm_pending') class="active" @endif>
                                            <a href="{{url('dmr/rm_dsm_pending')}}">RM DSM Pending</a>
                                        </li>
                                    @endif

                                @if(in_array('1',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dmr/doctor_medicine_requisition') class="active" @endif>
                                        <a href="{{url('dmr/doctor_medicine_requisition')}}">Doctor Medicine
                                            Requisition</a>
                                    </li>
                                @endif

                                @if(in_array('2',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dmr/medicine_requisition_verification') class="active" @endif>
                                        <a href="{{url('dmr/medicine_requisition_verification')}}">Medicine Requisition
                                            Verification</a>
                                    </li>
                                @endif

                                @if(in_array('3',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dmr/ssd_process_dmr') class="active" @endif>
                                        <a href="{{url('dmr/ssd_process_dmr')}}">SSD Process</a>
                                    </li>
                                @endif

                                @if(in_array('4',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dmr/rm_wise_report') class="active" @endif>
                                        <a href="{{url('dmr/rm_wise_report')}}">RM Wise Report</a>
                                    </li>
                                @endif

                                @if(in_array('6',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dmr/depot_wise_report') class="active" @endif>
                                        <a href="{{url('dmr/depot_wise_report')}}">Depot Wise Report</a>
                                    </li>
                                @endif

                                @if(in_array('5',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dmr/cost_center_budget_dmr') class="active" @endif>
                                        <a href="{{url('dmr/cost_center_budget_dmr')}}"> Cost Center Budget</a>
                                    </li>
                                @endif
                                    @if(in_array('7',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'dmr/budget_report') class="active" @endif>
                                            <a href="{{url('dmr/budget_report')}}">Budget Summary Report</a>
                                        </li>
                                    @endif

                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Sahadat -->

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/rm_dsm_pending') class="active" @endif>
                                    <a href="{{url('dmr/rm_dsm_pending')}}">RM DSM Pending</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/cost_center_budget_dmr') class="active" @endif>
                                    <a href="{{url('dmr/cost_center_budget_dmr')}}"> Cost Center Budget</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/budget_report') class="active" @endif>
                                    <a href="{{url('dmr/budget_report')}}">Budget Summary Report</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/doctor_medicine_requisition') class="active" @endif>
                                    <a href="{{url('dmr/doctor_medicine_requisition')}}">Doctor Medicine Requisition</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/medicine_requisition_verification') class="active" @endif>
                                    <a href="{{url('dmr/medicine_requisition_verification')}}">Medicine Requisition
                                        Verification</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/ssd_process_dmr') class="active" @endif>
                                    <a href="{{url('dmr/ssd_process_dmr')}}">SSD Process</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/rm_wise_report') class="active" @endif>
                                    <a href="{{url('dmr/rm_wise_report')}}">RM Wise Report</a>
                                </li>


                                <li @if(Route::getCurrentRoute()->uri() == 'dmr/depot_wise_report') class="active" @endif>
                                    <a href="{{url('dmr/depot_wise_report')}}">Depot Wise Report</a>
                                </li>

                            @endif
                        </ul>
                    </li>

                @endif
                {{--CATEGORY 24 END--}}


                {{-- CATEGORY 32 START  Scientific seminar  Author :: Sahadat   --}}

                @if($data->mcategory == 32)

                    <li @if(Request::segment(1) == 'scientific') class="menu-list nav-active"
                        @else class="menu-list" @endif>
                        <a href="#"><i class="fa fa-coffee"></i> <span>Scientific Seminar</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr9 = explode('|', $data->scategory); ?>

                                @if(in_array('1',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_proposal') class="active" @endif>
                                        <a href="{{url('scientific/seminar_proposal')}}">Scientific Seminar Proposal</a>
                                    </li>
                                @endif

                                @if(in_array('2',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_bill') class="active" @endif>
                                        <a href="{{url('scientific/seminar_bill')}}">Scientific Seminar Bill</a>
                                    </li>
                                @endif

                                @if(in_array('3',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_reports') class="active" @endif>
                                        <a href="{{url('scientific/seminar_reports')}}">Scientific Seminar Reports</a>
                                    </li>
                                @endif


                                @if(in_array('4',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_voucher') class="active" @endif>
                                        <a href="{{url('scientific/seminar_voucher')}}">Depot Account Process</a>
                                    </li>
                                @endif

                                @if(in_array('5',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'scientific/cost_center_budget') class="active" @endif>
                                        <a href="{{url('scientific/cost_center_budget')}}">Cost Center Budget</a>
                                    </li>
                                @endif


                                    @if(in_array('12',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/budget_report') class="active" @endif>
                                            <a href="{{url('scientific/budget_report')}}">Budget Summary Report</a>
                                        </li>
                                    @endif

                                @if(in_array('6',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'scientific/approval_status') class="active" @endif>
                                        <a href="{{url('scientific/approval_status')}}">Approval Status</a>
                                    </li>
                                @endif

                                    @if(in_array('7',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/outstanding_proposal_view') class="active" @endif>
                                            <a href="{{url('scientific/outstanding_proposal_view')}}">Outstanding Proposal</a>
                                        </li>
                                    @endif

                                    @if(in_array('8',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/bill_settlement_view') class="active" @endif>
                                            <a href="{{url('scientific/bill_settlement_view')}}">Bill Settlement</a>
                                        </li>
                                    @endif

                                    @if(in_array('9',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/budget_actual_consumption_view') class="active" @endif>
                                            <a href="{{url('scientific/budget_actual_consumption_view')}}">Budget Actual Consumption</a>
                                        </li>
                                    @endif

                                    @if(in_array('10',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/teamwise_budget_expense_view') class="active" @endif>
                                            <a href="{{url('scientific/teamwise_budget_expense_view')}}">Teamwise Budget & Actual Expense</a>
                                        </li>
                                    @endif

                                    @if(in_array('11',$arr9,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/depotwise_actual_view') class="active" @endif>
                                            <a href="{{url('scientific/depotwise_actual_view')}}">RM,Team and Depot wise actual</a>
                                        </li>
                                    @endif
                                    @if(Auth::user()->user_id == '1001261' || Auth::user()->user_id == '1000725' ||
                                    Auth::user()->user_id == '1001440' || Auth::user()->user_id == '1000001' ||
                                    Auth::user()->user_id == '1000353' || Auth::user()->user_id == '1000085' ||
                                    Auth::user()->user_id == '1000298' || Auth::user()->user_id == '1020386' || Auth::user()->user_id == '1005975')
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/proposal_bill_approval')
                                            class="active" @endif>
                                            <a href="{{url('scientific/proposal_bill_approval')}}">Proposal & Bill Approval</a>
                                        </li>
                                    @endif


                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Sahadat -->

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_proposal') class="active" @endif>
                                    <a href="{{url('scientific/seminar_proposal')}}">Scientific Seminar Proposal</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_bill') class="active" @endif>
                                    <a href="{{url('scientific/seminar_bill')}}">Scientific Seminar Bill</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_reports') class="active" @endif>
                                    <a href="{{url('scientific/seminar_reports')}}">Scientific Seminar Reports</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/seminar_voucher') class="active" @endif>
                                    <a href="{{url('scientific/seminar_voucher')}}">Depot Account Process</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/cost_center_budget') class="active" @endif>
                                    <a href="{{url('scientific/cost_center_budget')}}">Cost Center Budget</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/budget_report') class="active" @endif>
                                    <a href="{{url('scientific/budget_report')}}">Budget Summary Report</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/approval_status') class="active" @endif>
                                    <a href="{{url('scientific/approval_status')}}">Approval Status</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/outstanding_proposal_view') class="active" @endif>
                                    <a href="{{url('scientific/outstanding_proposal_view')}}">Outstanding Proposal</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/bill_settlement_view') class="active" @endif>
                                    <a href="{{url('scientific/bill_settlement_view')}}">Bill Settlement</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/budget_actual_consumption_view') class="active" @endif>
                                    <a href="{{url('scientific/budget_actual_consumption_view')}}">Budget Actual Consumption</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/teamwise_budget_expense_view') class="active" @endif>
                                    <a href="{{url('scientific/teamwise_budget_expense_view')}}">Teamwise Budget & Actual Expense</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'scientific/depotwise_actual_view') class="active" @endif>
                                    <a href="{{url('scientific/depotwise_actual_view')}}">RM,Team and Depot wise actual</a>
                                </li>
                                
                                @if(Auth::user()->user_id == '1001261' || Auth::user()->user_id == '1000725' ||
                                    Auth::user()->user_id == '1001440' || Auth::user()->user_id == '1000001' ||
                                    Auth::user()->user_id == '1000353' || Auth::user()->user_id == '1000085' ||
                                    Auth::user()->user_id == '1000298' || Auth::user()->user_id == '1020386' || Auth::user()->user_id == '1005975')
                                        <li @if(Route::getCurrentRoute()->uri() == 'scientific/proposal_bill_approval')
                                            class="active" @endif>
                                            <a href="{{url('scientific/proposal_bill_approval')}}">Proposal & Bill Approval</a>
                                        </li>
                                    @endif

                            @endif
                        </ul>
                    </li>

                @endif


                {{--CATEGORY 32 END--}}

                {{-- CATEGORY 41 START  Offer Price   Author :: Sahadat   --}}

                @if($data->mcategory == 41)

                    <li @if(Request::segment(1) == 'offer') class="menu-list nav-active"
                        @else class="menu-list" @endif>
                        <a href="#"><i class="fa fa-coffee"></i> <span>Offer Price</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr9 = explode('|', $data->scategory); ?>

                                @if(in_array('1',$arr9,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'offer/discount_approval') class="active" @endif>
                                        <a href="{{url('offer/discount_approval')}}">Discount Approval</a>
                                    </li>
                                @endif


                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Sahadat -->

                                <li @if(Route::getCurrentRoute()->uri() == 'offer/discount_approval') class="active" @endif>
                                    <a href="{{url('offer/discount_approval')}}">Discount Approval</a>
                                </li>

                            @endif
                        </ul>
                    </li>

                @endif


                {{--CATEGORY 41 END--}}



                {{--QUIZ PROTAL--}}

                {{--QUIZ PROTAL--}}
                @if($data->mcategory == 15)
                    <li @if(Request::segment(1) == 'quiz') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-chain-broken"></i>
                            <span> Virtual Exam System </span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr10 = explode('|', $data->scategory); ?>

                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/quizGrpInfo') class="active" @endif>
                                    <a href="{{url('quiz/quizGrpInfo')}}">Group Information</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/UpExamMaterial') class="active" @endif>
                                    <a href="{{url('quiz/UpExamMaterial')}}">Upload Reading Material</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/examDateTime') class="active" @endif>
                                    <a href="{{url('quiz/examDateTime')}}">Set Exam Date & Time</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/addQuestions') class="active" @endif>
                                    <a href="{{url('quiz/addQuestions')}}">Set Question Paper</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/notification_panel') class="active" @endif>
                                    <a href="{{url('quiz/notification_panel')}}">Send Group Notification</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/reExamApprovedIndex') class="active" @endif>
                                    <a href="{{url('quiz/reExamApprovedIndex')}}">Re-Exam Approved</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/employeePasswordIndex') class="active" @endif>
                                    <a href="{{url('quiz/employeePasswordIndex')}}">Employee Info</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/evalArchvUp') class="active" @endif>
                                    <a href="{{url('quiz/evalArchvUp')}}">Evaluation Archive Upload</a>
                                </li>

                                <li @if(Request::segment(2) =='') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Results

                                    </a>
                                    <ul class="sub-menu-list-first">

                                        <li @if(Route::getCurrentRoute()->uri() == 'quiz/grpWiseReport') class="active" @endif>
                                            <a href="{{url('quiz/grpWiseReport')}}">Group Wise Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'quiz/grpEmpWiseReport') class="active" @endif>
                                            <a href="{{url('quiz/grpEmpWiseReport')}}">Employee Wise Result</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'quiz/regionWiseResult') class="active" @endif>
                                            <a href="{{url('quiz/regionWiseResult')}}">Region Wise Result</a>
                                        </li>

                                         <li @if(Route::getCurrentRoute()->uri() == 'quiz/evalArchvReport') class="active" @endif>
                                            <a href="{{url('quiz/evalArchvReport')}}">Evaluation Archive Report</a>
                                        </li>

                                    </ul>
                                </li>

                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/quizGrpInfo') class="active" @endif>
                                    <a href="{{url('quiz/quizGrpInfo')}}">Group Information</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/UpExamMaterial') class="active" @endif>
                                    <a href="{{url('quiz/UpExamMaterial')}}">Upload Reading Material</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/examDateTime') class="active" @endif>
                                    <a href="{{url('quiz/examDateTime')}}">Set Exam Date & Time</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/addQuestions') class="active" @endif>
                                    <a href="{{url('quiz/addQuestions')}}">Set Question Paper</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/notification_panel') class="active" @endif>
                                    <a href="{{url('quiz/notification_panel')}}">Send Group Notification</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/reExamApprovedIndex') class="active" @endif>
                                    <a href="{{url('quiz/reExamApprovedIndex')}}">Re-Exam Approved</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/employeePasswordIndex') class="active" @endif>
                                    <a href="{{url('quiz/employeePasswordIndex')}}">Employee Info</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'quiz/evalArchvUp') class="active" @endif>
                                    <a href="{{url('quiz/evalArchvUp')}}">Evaluation Archive Upload</a>
                                </li>
                                <li @if(Request::segment(2) =='') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Results
                                    </a>
                                    <ul class="sub-menu-list-first">

                                        <li @if(Route::getCurrentRoute()->uri() == 'quiz/grpWiseReport') class="active" @endif>
                                            <a href="{{url('quiz/grpWiseReport')}}">Group Wise Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'quiz/grpEmpWiseReport') class="active" @endif>
                                            <a href="{{url('quiz/grpEmpWiseReport')}}">Employee Wise Result</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'quiz/regionWiseResult') class="active" @endif>
                                            <a href="{{url('quiz/regionWiseResult')}}">Region Wise Result</a>
                                        </li>

                                         <li @if(Route::getCurrentRoute()->uri() == 'quiz/evalArchvReport') class="active" @endif>
                                            <a href="{{url('quiz/evalArchvReport')}}">Evaluation Archive Report</a>
                                        </li>

                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--QUIZ PROTAL END--}}

                {{--CATEGORY 16 START employee history form--}}

                @if($data->mcategory == 16)
                    <li @if(Request::segment(1) == 'ehf') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-h-square"></i> <span>Employee History Form</span></a>
                        <ul class="sub-menu-list">

                        @if(strpos($data->scategory,'|') !== false)
                            <?php $arr81 = explode('|', $data->scategory); ?>
                            @if(in_array('1',$arr81,false))
                                <!-- fatema -->

                                <!-- <li  @if(Request::segment(2) == 'get_user_manual') class="active" @endif>
                                <a href="{{url('emp_comp/get_user_manual')}}">User Manual</a>
                            </li> -->
                                <li @if(Route::getCurrentRoute()->uri() == 'ehf/emp_history_entry/{valid}') class="active" @endif>
                                    <a href="#ehcmodal" data-toggle="modal">Entry Form</a>
                                </li>
                                @endif
                                @if(in_array('2',$arr81,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'ehf/historyWiseReport') class="active" @endif>
                                        <a href="{{url('ehf/historyWiseReport')}}">Employee History Report</a>
                                       {{-- <a href="#">Employee History Report</a> --}}
                                    </li>
                                @endif
                                @if(in_array('3',$arr81,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'ehf/emp_history_hr') class="active" @endif>
                                        <a href="{{url('ehf/emp_history_hr')}}">Employee History HR</a>
                                    </li>
                                @endif


                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- fatema -->
                            <!-- <li  @if(Request::segment(2) == 'get_user_manual') class="active" @endif>
                                <a href="{{url('emp_comp/get_user_manual')}}">User Manual</a>
                            </li> -->
                                <li @if(Route::getCurrentRoute()->uri() == 'ehf/emp_history_entry/{valid}') class="active" @endif>
                                    <a href="#ehcmodal" data-toggle="modal">Entry Form</a>
                                </li>
{{--                                <li @if(Route::getCurrentRoute()->uri() == 'ehf/emp_history_hr') class="active" @endif>--}}
{{--                                    <a href="{{url('ehf/emp_history_hr')}}">Employee History HR</a>--}}
{{--                                </li>--}}

                                @if(Auth::user()->user_id == '1000720' || Auth::user()->user_id == '1003467' || Auth::user()->user_id == '1012316' ||
                                                                   Auth::user()->user_id == '1016856' ||Auth::user()->user_id == '1005975' )
                                    <li @if(Request::segment(2) ==  'emp_history_hr') class="active" @endif>
                                        <a href="{{url('ehf/emp_history_hr')}}">Employee History HR</a>
                                    </li>
                                @endif

                                <li @if(Route::getCurrentRoute()->uri() == 'ehf/historyWiseReport') class="active" @endif>
                                    <a href="{{url('ehf/historyWiseReport')}}">Employee History Report</a>
                                </li>



                            @endif
                        </ul>
                    </li>
                @endif
                {{--CATEGORY 16 END--}}

                {{--category-23--}}
                @if($data->mcategory == 23)
                    <li @if(Request::segment(1) == 'nc') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-leaf"></i>
                            <span>NeoCare Diaper</span></a>
                        <ul class="sub-menu-list">

                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr80 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr80,false))

                                    <li @if(Route::getCurrentRoute()->uri() == 'nc/Neocare') class="active" @endif>
                                        <a href="{{url('nc/Neocare')}}">Entry Form</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr80,false))

                                    <li @if(Route::getCurrentRoute()->uri() == 'nc/customerinforep') class="active" @endif>
                                        <a href="{{url('nc/customerinforep')}}">Customer Information Report</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr80,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'nc/neosms') class="active" @endif>
                                        <a href="{{url('nc/neosms')}}">SMS to customer</a>
                                    </li>
                                @endif

                                @if(in_array('4',$arr80,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'survey') class="active" @endif>
                                        <a href="{{url('survey')}}" target="_blank">Neocare Survey</a>
                                    </li>
                                @endif

                                    @if(in_array('5',$arr80,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'nc/chemist_entry') class="active" @endif>
                                            <a href="{{url('nc/chemist_entry')}}">Hospital Wise Chemist Entry</a>
                                        </li>
                                    @endif

                                    @if(in_array('6',$arr80,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'nc/sample_entry') class="active" @endif>
                                            <a href="{{url('nc/sample_entry')}}">Sample Information Entry</a>
                                        </li>
                                    @endif

                                    @if(in_array('7',$arr80,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'nc/sample_info_report') class="active" @endif>
                                            <a href="{{url('nc/sample_info_report')}}">Sample Information Report</a>
                                        </li>
                                    @endif
                                    @if(in_array('8',$arr80,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'nc/hwc_report') class="active" @endif>
                                            <a href="{{url('nc/hwc_report')}}">Hospital Wise Chemist Report</a>
                                        </li>
                                    @endif



                            @elseif(strpos($data->scategory,'All') !== false)

                                <li @if(Route::getCurrentRoute()->uri() == 'nc/chemist_entry') class="active" @endif>
                                    <a href="{{url('nc/chemist_entry')}}">Hospital Wise Chemist Entry</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'nc/sample_entry') class="active" @endif>
                                    <a href="{{url('nc/sample_entry')}}" >Sample Information Entry</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'nc/sample_info_report') class="active" @endif>
                                    <a href="{{url('nc/sample_info_report')}}">Sample Information Report</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'nc/hwc_report') class="active" @endif>
                                    <a href="{{url('nc/hwc_report')}}">Hospital Wise Chemist Report</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'nc/Neocare') class="active" @endif>
                                    <a href="{{url('nc/Neocare')}}">Entry Form</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'nc/customerinforep') class="active" @endif>
                                    <a href="{{url('nc/customerinforep')}}">Customer Information Report</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'nc/neosms') class="active" @endif>
                                    <a href="{{url('nc/neosms')}}">SMS to customer</a>
                                </li>

                                <li @if(Route::getCurrentRoute()->uri() == 'survey') class="active" @endif>
                                    <a href="{{url('survey')}}" target="_blank">Neocare Survey</a>
                                </li>

                            @endif
                        </ul>
                    </li>
                @endif



                @if($data->mcategory == 17)

                    <li @if(Request::segment(1) == 'event') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-user-md"></i>
                            <span>Event Management</span></a>
                        <ul class="sub-menu-list">

                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr83 = explode('|', $data->scategory); ?>

                                @if(in_array('1',$arr83,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'event/room_view') class="active" @endif>
                                        <a href="{{url('event/room_view')}}">Insert Room Info</a>
                                    </li>
                                @endif
                            <!-- fatema -->
                                @if(in_array('2',$arr83,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'event/event_view') class="active" @endif>
                                        <a href="{{url('event/event_view')}}">Book Event</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr83,false))
                                <!-- Raqib -->

                                    <li @if(Route::getCurrentRoute()->uri() == 'event/booking_report_view') class="active" @endif>
                                        <a href="{{url('event/booking_report_view')}}">Booking Information Report</a>
                                    </li>
                                @endif
                                @if(in_array('4',$arr83,false))
                                <!-- Raqib -->

                                    <li @if(Route::getCurrentRoute()->uri() == 'event/admin_panel_view') class="active" @endif>
                                        <a href="{{url('event/admin_panel_view')}}">Admin Panel</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Dipro -->
                                <li @if(Route::getCurrentRoute()->uri() == 'event/room_view') class="active" @endif>
                                    <a href="{{url('event/room_view')}}">Insert Room Info</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'event/event_view') class="active" @endif>
                                    <a href="{{url('event/event_view')}}">Book Event</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'event/booking_report_view') class="active" @endif>
                                    <a href="{{url('event/booking_report_view')}}">Booking Information Report</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'event/admin_panel_view') class="active" @endif>
                                    <a href="{{url('event/admin_panel_view')}}">Admin Panel</a>
                                </li>

                            @endif

                        </ul>
                    </li>
                @endif

                {{-- CATEGORY 31 START  Sample Requisition  Author :: Dipro   --}}

                {{--Sample Requisition Starts Here--}} {{--Author: Dipro--}}

                @if($data->mcategory == 31)

                    <li @if(Request::segment(1) == 'dsr') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-paperclip"></i> <span>Sample Requisition</span></a>
                        <ul class="sub-menu-list">

                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr84 = explode('|', $data->scategory); ?>

                                @if(in_array('1',$arr84,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dsr/sample_requisition_view') class="active" @endif>
                                        <a href="{{url('dsr/sample_requisition_view')}}">Special Requisition</a>
                                    </li>
                                @endif
                            <!-- Dipro -->
                                @if(in_array('2',$arr84,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'dsr/sample_req_verification_view') class="active" @endif>
                                        <a href="{{url('dsr/sample_req_verification_view')}}">Requisition
                                            Verification</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr84,false))
                                <!-- Dipro -->

                                    <li @if(Route::getCurrentRoute()->uri() == 'dsr/sample_req_report_view') class="active" @endif>
                                        <a href="{{url('dsr/sample_req_report_view')}}">Requisition Report</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Dipro -->
                                <li @if(Route::getCurrentRoute()->uri() == 'dsr/sample_requisition_view') class="active" @endif>
                                    <a href="{{url('dsr/sample_requisition_view')}}">Special Requisition</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'dsr/sample_req_verification_view') class="active" @endif>
                                    <a href="{{url('dsr/sample_req_verification_view')}}">Requisition Verification</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'dsr/sample_req_report_view') class="active" @endif>
                                    <a href="{{url('dsr/sample_req_report_view')}}">Requisition Report</a>
                                </li>

                            @endif

                        </ul>
                    </li>
                @endif
                {{--Sample Requisition Ends Here--}} {{--Author: Dipro--}}
                {{--CATEGORY 31 END--}}


                {{--Export DATABASE--}}
                @if($data->mcategory == 20)

                    <li @if(Request::segment(1) == 'expo') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-truck"></i>
                            <span> Export Database </span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr20 = explode('|', $data->scategory); ?>

                                @if(in_array('1',$arr20,false))

                                @endif
                                @if(in_array('2',$arr20,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'expo/getPageExpoPlantWiseDataUpload') class="active" @endif>
                                        <a href="{{url('expo/getPageExpoPlantWiseDataUpload')}}">Bulk Code Entry
                                            Form</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr20,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'expo/getPageExpoCountryWiseProducts') class="active" @endif>
                                        <a href="{{url('expo/getPageExpoCountryWiseProducts')}}">Master Data Entry
                                            Form</a>
                                    </li>
                                @endif
                                @if(in_array('4',$arr20,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'expo/getExpoView') class="active" @endif>
                                        <a href="{{url('expo/getExpoView')}}">Product Details Entry Form</a>
                                    </li>
                                @endif
                                @if(in_array('5',$arr20,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'expo/getExpoEntryInfoUpdate') class="active" @endif>
                                        <a href="{{url('expo/getExpoEntryInfoUpdate')}}">Export Update</a>
                                    </li>
                                @endif

                                <li @if(Request::segment(2) =='report') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Reports
                                    </a>
                                    <ul class="sub-menu-list-first">
                                    @if(strpos($data->scate_two,',') !== false)
                                        <!--                                            --><?php //print_r($data->scate_two); ?>
                                            <?php $arr22 = explode(',', $data->scate_two); ?>
                                            @if(substr($arr22[0],0,1) == '1')
                                                @if(strpos(substr($arr22[0], 2, -1),'|') !== false)
                                                    <?php $arr23 = explode('|', substr($arr22[0], 2, -1));?>

                                                    @if(in_array('1',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/cwbarcharts') class="" @endif>
                                                            <a href="{{url('expo/report/cwbarcharts')}}">1. Export
                                                                Summary Chart</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('2',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/country_count_page') class="active" @endif>
                                                            <a href="{{url('expo/report/country_count_page')}}">2.
                                                                Export Country Count of Incepta</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('3',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/bulkProdStatus') class="active" @endif>
                                                            <a href="{{url('expo/report/bulkProdStatus')}}">3. QA –
                                                                Export Product Status</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('4',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/qapsCurrent') class="active" @endif>
                                                            <a href="{{url('expo/report/qapsCurrent')}}">4. QA –
                                                                Export Product Details Status</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('5',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/imTeamWiseProductStatus') class="active" @endif>
                                                            <a href="{{url('expo/report/imTeamWiseProductStatus')}}">5.
                                                                IM Team Wise Product Status</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('6',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/yearWiseStatus') class="active" @endif>
                                                            <a href="{{url('expo/report/yearWiseStatus')}}"> 6. Year
                                                                Wise Country submission status</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('7',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/ers') class="active" @endif>
                                                            <a href="{{url('expo/report/ers')}}">7. Expiry date Wise
                                                                Status for Renewal</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('8',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/subDateProdStatus_page') class="active" @endif>
                                                            <a href="{{url('expo/report/subDateProdStatus_page')}}">8.
                                                                Export Country Wise REG & EXP Date</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('9',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/pcs') class="active" @endif>
                                                            <a href="{{url('expo/report/pcs')}}">9. Product Current
                                                                Status Date Wise</a>
                                                        </li>
                                                    @endif

                                                       <!--registration certificate-->                                        


                                                    @if(in_array('10',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/regCertificate') class="active" @endif>
                                                            <a href="{{url('expo/report/regCertificate')}}">10. Registration certificate of product</a>
                                                        </li>
                                                    @endif

                                                    @if(in_array('11',$arr23,false))
                                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/genericProductForScm') class="active" @endif>
                                                            <a href="{{url('expo/report/genericProductForScm')}}">11. Generic Product</a>
                                                        </li>
                                                    @endif

                                                @endif
                                            @endif
                                        @endif



                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/yearWiseSubStatus') class="active" @endif>
                                            <a href="{{url('expo/report/yearWiseSubStatus')}}">Year wise Country submission status</a>
                                        </li> --}}




                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/cwps') class="active" @endif>
                                            <a href="{{url('expo/report/cwps')}}">Country Wise Product Status Count</a>
                                        </li> --}}



                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/ers') class="active" @endif>
                                            <a href="{{url('expo/report/ers')}}"> Expiry Renewal Status</a>
                                        </li> --}}

                                        {{--  <li @if(Route::getCurrentRoute()->uri() == 'expo/qaps') class="" @endif>
                                             <a href="{{url('expo/qaps')}}">QA - Product Status Details</a>
                                         </li> --}}


                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/AgentListIndex') class="active" @endif>
                                            <a href="{{url('expo/report/AgentListIndex')}}">Agent Information</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/marketingIndex') class="active" @endif>
                                            <a href="{{url('expo/report/marketingIndex')}}">Marketing AID</a>
                                        </li> --}}

                                    </ul>
                                </li>
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Route::getCurrentRoute()->uri() == 'expo/getPageExpoPlantWiseDataUpload') class="active" @endif>
                                    <a href="{{url('expo/getPageExpoPlantWiseDataUpload')}}">Bulk Code Entry Form</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'expo/getPageExpoCountryWiseProducts') class="active" @endif>
                                    <a href="{{url('expo/getPageExpoCountryWiseProducts')}}">Master Data Entry Form</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'expo/getExpoView') class="active" @endif>
                                    <a href="{{url('expo/getExpoView')}}">Product Details Entry Form</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'expo/getExpoEntryInfoUpdate') class="active" @endif>
                                    <a href="{{url('expo/getExpoEntryInfoUpdate')}}">Export Update</a>
                                </li>

                                <li @if(Request::segment(2) =='report') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Reports
                                    </a>
                                    <ul class="sub-menu-list-first">

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/cwbarcharts') class="" @endif>
                                            <a href="{{url('expo/report/cwbarcharts')}}">1. Export Summary Chart</a>
                                        </li>


                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/country_count_page') class="active" @endif>
                                            <a href="{{url('expo/report/country_count_page')}}">2. Export Country Count
                                                of Incepta</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/bulkProdStatus') class="active" @endif>
                                            <a href="{{url('expo/report/bulkProdStatus')}}">3. QA – Export Product
                                                Status</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/qapsCurrent') class="active" @endif>
                                            <a href="{{url('expo/report/qapsCurrent')}}">4. QA – Export Product Details
                                                Status</a>
                                        </li>


                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/imTeamWiseProductStatus') class="active" @endif>
                                            <a href="{{url('expo/report/imTeamWiseProductStatus')}}">5. IM Team Wise
                                                Product Status</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/yearWiseStatus') class="active" @endif>
                                            <a href="{{url('expo/report/yearWiseStatus')}}">6. Year Wise Country
                                                submission status </a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/ers') class="active" @endif>
                                            <a href="{{url('expo/report/ers')}}"> 7. Expiry date Wise Status for
                                                Renewal</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/subDateProdStatus_page') class="active" @endif>
                                            <a href="{{url('expo/report/subDateProdStatus_page')}}">8. Export Country
                                                Wise REG & EXP Date</a>
                                        </li>


            

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/pcs') class="active" @endif>
                                            <a href="{{url('expo/report/pcs')}}">9. Product Current Status Date Wise</a>
                                        </li>

                                          <!--registration certificate-->
                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/regCertificate') class="" @endif>
                                            <a href="{{url('expo/report/regCertificate')}}">10. Registration certificate of product</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/genericProductForScm') class="active" @endif>
                                            <a href="{{url('expo/report/genericProductForScm')}}">11. Generic Product</a>
                                        </li>

                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/yearWiseSubStatus') class="active" @endif>
                                            <a href="{{url('expo/report/yearWiseSubStatus')}}">Year wise Country submission status</a>
                                        </li> --}}




                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/cwps') class="active" @endif>
                                            <a href="{{url('expo/report/cwps')}}">Country Wise Product Status Count</a>
                                        </li> --}}



                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/ers') class="active" @endif>
                                            <a href="{{url('expo/report/ers')}}"> Expiry Renewal Status</a>
                                        </li> --}}

                                        {{--  <li @if(Route::getCurrentRoute()->uri() == 'expo/qaps') class="" @endif>
                                             <a href="{{url('expo/qaps')}}">QA - Product Status Details</a>
                                         </li> --}}

                                        {{-- <li @if(Route::getCurrentRoute()->uri() == 'expo/report/AgentListIndex') class="active" @endif>
                                            <a href="{{url('expo/report/AgentListIndex')}}">Agent Information</a>
                                        </li>

                                        <li @if(Route::getCurrentRoute()->uri() == 'expo/report/marketingIndex') class="active" @endif>
                                            <a href="{{url('expo/report/marketingIndex')}}">Marketing AID</a>
                                        </li> --}}

                                    </ul>
                                </li>

                            @endif
                        </ul>
                    </li>

                @endif
                {{--Export DATABASE END--}}

                  {{--Trave Management--}}
                  @if($data->mcategory == 21)
                  <li @if(Request::segment(1) == 'travel') class="menu-list nav-active"
                      @else class="menu-list" @endif>
                      <a href="#"><i class="fa fa-plane"></i>
                          <span> Travel Management </span></a>
                      <ul class="sub-menu-list">
                          @if(strpos($data->scategory,'|') !== false)
                              <?php $arrTrv = explode('|', $data->scategory); ?>
                              @if(in_array('1',$arrTrv,false))
                                  <li @if(Request::segment(2) =='local') class="menu-list-first nav-active active"
                                      @else class="menu-list-first" @endif>
                                      <a href="#">
                                          <i class="fa fa-clipboard"></i>
                                          Local Travel
                                      </a>
                                      <ul class="sub-menu-list-first">
                                          @if(strpos($data->scate_two,',') !== false)
                                              <?php $arrTrvl1 = explode(',', $data->scate_two); ?>
                                              @if(substr($arrTrvl1[0],0,1) == '1')
                                                  @if(strpos(substr($arrTrvl1[0], 2, -1),'|') !== false)
                                                      <?php $arrTrvl2 = explode('|', substr($arrTrvl1[0], 2, -1));?>
                                                      @if(in_array('1',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'masterData.grades') class="active" @endif>
                                                              <a href="{{route('masterData.grades')}}">Grade Wise
                                                                  Allowance</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('2',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.application') class="active" @endif>
                                                              <a href="{{route('local.application')}}">Local Travel
                                                                  Advance</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('3',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.history') class="active" @endif>
                                                              <a href="{{route('local.history')}}">Local Travel
                                                                  History</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('4',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.adjustment') class="active" @endif>
                                                              <a href="{{route('local.adjustment')}}">Local Travel
                                                                  Adjustment</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('5',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.adjustmentDetails') class="active" @endif>
                                                              <a href="{{route('local.adjustmentDetails')}}">Local
                                                                  Travel Adjustment
                                                                  Details</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('6',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.recommended') class="active" @endif>
                                                              <a href="{{route('local.recommended')}}">Local Travel
                                                                  Recommended</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('7',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.approvedBy') class="active" @endif>
                                                              <a href="{{route('local.approved')}}">Local Travel
                                                                  Approved</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('8',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.fi_advance') class="active" @endif>
                                                              <a href="{{route('local.fi_advance')}}">Local Travel FI
                                                                  Advance</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('9',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.fi_adjustment') class="active" @endif>
                                                              <a href="{{route('local.fi_adjustment')}}">Local Travel
                                                                  FI Adjustment</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('10',$arrTrvl2,false))
                                                          <li @if(Route::currentRouteName() == 'local.getAdvice') class="active" @endif>
                                                              <a href="{{route('local.getAdvice')}}">Bank Advice</a>
                                                          </li>
                                                      @endif
                                                  @elseif(strpos(substr($arrTrvl1[0], 2, -1),'All') !== false)
                                                      <li @if(Route::currentRouteName() == 'masterData.grades') class="active" @endif>
                                                          <a href="{{route('masterData.grades')}}">Grade Wise
                                                              Allowance</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.application') class="active" @endif>
                                                          <a href="{{route('local.application')}}">Local Travel
                                                              Advance</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.history') class="active" @endif>
                                                          <a href="{{route('local.history')}}">Local Travel
                                                              History</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.adjustment') class="active" @endif>
                                                          <a href="{{route('local.adjustment')}}">Local Travel
                                                              Adjustment</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.adjustmentDetails') class="active" @endif>
                                                          <a href="{{route('local.adjustmentDetails')}}">Local Travel
                                                              Adjustment
                                                              Details</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.recommended') class="active" @endif>
                                                          <a href="{{route('local.recommended')}}">Local Travel
                                                              Recommended</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.approvedBy') class="active" @endif>
                                                          <a href="{{route('local.approved')}}">Local Travel
                                                              Approved</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.fi_advance') class="active" @endif>
                                                          <a href="{{route('local.fi_advance')}}">Local Travel FI
                                                              Advance</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.fi_adjustment') class="active" @endif>
                                                          <a href="{{route('local.fi_adjustment')}}">Local Travel FI
                                                              Adjustment</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'local.getAdvice') class="active" @endif>
                                                          <a href="{{route('local.getAdvice')}}">Bank Advice</a>
                                                      </li>
                                                  @endif
                                              @endif
                                          @endif
                                      </ul>
                                  </li>
                              @endif
                              @if(in_array('2',$arrTrv,false))
                                  <li @if(Request::segment(2) =='international') class="menu-list-first nav-active active"
                                      @else class="menu-list-first" @endif>
                                      <a href="#">
                                          <i class="fa fa-clipboard"></i>
                                          International Travel
                                      </a>
                                      <ul class="sub-menu-list-sec">
                                          @if(strpos($data->scate_two,',') !== false)
                                              <?php $arrTrvr1 = explode(',', $data->scate_two); ?>
                                              @if(substr($arrTrvr1[1],0,1) == '2')
                                                  @if(strpos(substr($arrTrvr1[1], 2, -1),'|') !== false)
                                                      <?php $arrTrvr2 = explode('|', substr($arrTrvr1[1], 2, -1));?>
                                                      @if(in_array('1',$arrTrvr2,false))
                                                          <li @if(Route::currentRouteName() == 'international.application') class="active" @endif>
                                                              <a href="{{route('international.application')}}">International
                                                                  Travel
                                                                  Form</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('2',$arrTrvr2,false))
                                                        <li @if(Route::currentRouteName() == 'international.history') class="active" @endif>
                                                            <a href="{{route('international.history')}}">International Travel History</a>
                                                        </li>
                                                      @endif
                                                      @if(in_array('3',$arrTrvr2,false))
                                                          <li @if(Route::currentRouteName() == 'international.headapproved') class="active" @endif>
                                                              <a href="{{route('international.headapproved')}}">International
                                                                  Travel
                                                                  Approved</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('4',$arrTrvr2,false))
                                                          <li @if(Route::currentRouteName() == 'international.siteHeadApproved') class="active" @endif>
                                                              <a href="{{route('international.siteHeadApproved')}}">International
                                                                  Travel
                                                                  Approved Site Head</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('5',$arrTrvr2,false))
                                                        <li @if(Route::currentRouteName() == 'international.plantHeadApproved') class="active" @endif>
                                                            <a href="{{route('international.plantHeadApproved')}}">International Travel Approved Plant Head</a>
                                                        </li>
                                                      @endif
                                                      @if(in_array('6',$arrTrvr2,false))
                                                          <li @if(Route::currentRouteName() == 'international.chairmanApproved') class="active" @endif>
                                                              <a href="{{route('international.chairmanApproved')}}">International
                                                                  Travel
                                                                  Approved C</a>
                                                          </li>
                                                      @endif

                                                      {{--NOTE SHEET--}}
                                                      @if(in_array('7',$arrTrvr2,false))
                                                          <li @if(Route::currentRouteName() == 'international.noteSheetIndex') class="active" @endif>
                                                              <a href="{{route('international.noteSheetIndex')}}">Create
                                                                  Note
                                                                  Sheet</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('8',$arrTrvr2,false))
                                                          <li @if(Route::currentRouteName() == 'international.noteSheetView') class="active" @endif>
                                                              <a href="{{route('international.noteSheetView')}}">View
                                                                  Note Sheet</a>
                                                          </li>
                                                      @endif
                                                      @if(in_array('9',$arrTrvr2,false))
                                                      <li @if(Route::currentRouteName() == 'international.noteSheetCheckedBy') class="active" @endif>
                                                        <a href="{{route('international.noteSheetCheckedBy')}}">Note Sheet Checked </a>
                                                      </li>
                                                      @endif
                                                      @if(in_array('10',$arrTrvr2,false))
                                                    <li @if(Route::currentRouteName() == 'international.intlnoteSheetRecommendedBy') class="active" @endif>
                                                        <a href="{{route('international.intlnoteSheetRecommendedBy')}}">Note Sheet Recommended </a>
                                                    </li>
                                                    @endif
                                                    @if(in_array('11',$arrTrvr2,false))
                                                    <li @if(Route::currentRouteName() == 'international.intlnoteSheetApprovedBy') class="active" @endif>
                                                        <a href="{{route('international.intlnoteSheetApprovedBy')}}">Note Sheet Approved </a>
                                                    </li>
                                                    @endif    





                                                  @elseif(strpos(substr($arrTrvr1[1], 2, -1),'All') !== false)
                                                      <li @if(Route::currentRouteName() == 'international.application') class="active" @endif>
                                                          <a href="{{route('international.application')}}">International
                                                              Travel
                                                              Form</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'international.history') class="active" @endif>
                                                        <a href="{{route('international.history')}}">International Travel History</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'international.headapproved') class="active" @endif>
                                                          <a href="{{route('international.headapproved')}}">International
                                                              Travel
                                                              Approved</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'international.siteHeadApproved') class="active" @endif>
                                                          <a href="{{route('international.siteHeadApproved')}}">International
                                                              Travel
                                                              Approved Site Head</a>
                                                      </li>

                                                      <li @if(Route::currentRouteName() == 'international.plantHeadApproved') class="active" @endif>
                                                        <a href="{{route('international.plantHeadApproved')}}">International Travel Approved Plant Head</a>
                                                     </li>

                                                      <li @if(Route::currentRouteName() == 'international.chairmanApproved') class="active" @endif>
                                                          <a href="{{route('international.chairmanApproved')}}">International
                                                              Travel
                                                              Approved C</a>
                                                      </li>

                                                      {{--NOTE SHEET--}}

                                                      <li @if(Route::currentRouteName() == 'international.noteSheetIndex') class="active" @endif>
                                                          <a href="{{route('international.noteSheetIndex')}}">Create
                                                              Note Sheet</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'international.noteSheetView') class="active" @endif>
                                                          <a href="{{route('international.noteSheetView')}}">View Note
                                                              Sheet</a>
                                                      </li>
                                                      <li @if(Route::currentRouteName() == 'international.noteSheetCheckedBy') class="active" @endif>
                                                        <a href="{{route('international.noteSheetCheckedBy')}}">Note Sheet Checked </a>
                                                    </li>
                                                    <li @if(Route::currentRouteName() == 'international.intlnoteSheetRecommendedBy') class="active" @endif>
                                                        <a href="{{route('international.intlnoteSheetRecommendedBy')}}">Note Sheet Recommended </a>
                                                    </li>
                                                    <li @if(Route::currentRouteName() == 'international.intlnoteSheetApprovedBy') class="active" @endif>
                                                        <a href="{{route('international.intlnoteSheetApprovedBy')}}">Note Sheet Approved </a>
                                                    </li>

                                                  @endif
                                              @endif
                                          @endif
                                      </ul>
                                  </li>
                              @endif
                          @elseif(strpos($data->scategory,'All') !== false)
                              <li @if(Request::segment(2) =='local') class="menu-list-first nav-active active"
                                  @else class="menu-list-first" @endif>
                                  <a href="#">
                                      <i class="fa fa-clipboard"></i>
                                      Local Travel
                                  </a>
                                  <ul class="sub-menu-list-first">

                                      <li @if(Route::currentRouteName() == 'masterData.grades') class="active" @endif>
                                          <a href="{{route('masterData.grades')}}">Grade Wise Allowance</a>
                                      </li>

                                      <li @if(Route::currentRouteName() == 'local.application') class="active" @endif>
                                          <a href="{{route('local.application')}}">Local Travel Advance</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.history') class="active" @endif>
                                          <a href="{{route('local.history')}}">Local Travel History</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.adjustment') class="active" @endif>
                                          <a href="{{route('local.adjustment')}}">Local Travel Adjustment</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.adjustmentDetails') class="active" @endif>
                                          <a href="{{route('local.adjustmentDetails')}}">Local Travel Adjustment
                                              Details</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.recommended') class="active" @endif>
                                          <a href="{{route('local.recommended')}}">Local Travel Recommended</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.approvedBy') class="active" @endif>
                                          <a href="{{route('local.approved')}}">Local Travel Approved</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.fi_advance') class="active" @endif>
                                          <a href="{{route('local.fi_advance')}}">Local Travel FI Advance</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.fi_adjustment') class="active" @endif>
                                          <a href="{{route('local.fi_adjustment')}}">Local Travel FI Adjustment</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'local.getAdvice') class="active" @endif>
                                          <a href="{{route('local.getAdvice')}}">Bank Advice</a>
                                      </li>


                                  </ul>
                              </li>

                              <li @if(Request::segment(2) =='international') class="menu-list-first nav-active active"
                                  @else class="menu-list-first" @endif>
                                  <a href="#">
                                      <i class="fa fa-clipboard"></i>
                                      International Travel
                                  </a>
                                  <ul class="sub-menu-list-sec">
                                      <li @if(Route::currentRouteName() == 'international.application') class="active" @endif>
                                          <a href="{{route('international.application')}}">International Travel
                                              Form</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.history') class="active" @endif>
                                        <a href="{{route('international.history')}}">International Travel History</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.headapproved') class="active" @endif>
                                          <a href="{{route('international.headapproved')}}">International Travel
                                              Approved</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.siteHeadApproved') class="active" @endif>
                                          <a href="{{route('international.siteHeadApproved')}}">International Travel
                                              Approved Site Head</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.plantHeadApproved') class="active" @endif>
                                        <a href="{{route('international.plantHeadApproved')}}">International Travel Approved Plant Head</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.chairmanApproved') class="active" @endif>
                                          <a href="{{route('international.chairmanApproved')}}">International Travel
                                              Approved C</a>
                                      </li>

                                      {{--NOTE SHEET--}}

                                      <li @if(Route::currentRouteName() == 'international.noteSheetIndex') class="active" @endif>
                                          <a href="{{route('international.noteSheetIndex')}}">Create Note Sheet</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.noteSheetView') class="active" @endif>
                                          <a href="{{route('international.noteSheetView')}}">View Note Sheet</a>
                                      </li>
                                      <li @if(Route::currentRouteName() == 'international.noteSheetCheckedBy') class="active" @endif>
                                        <a href="{{route('international.noteSheetCheckedBy')}}">Note Sheet Checked By</a>
                                    </li>
                                    <li @if(Route::currentRouteName() == 'international.intlnoteSheetRecommendedBy') class="active" @endif>
                                        <a href="{{route('international.intlnoteSheetRecommendedBy')}}">Note Sheet Recommended By</a>
                                    </li>
                                    <li @if(Route::currentRouteName() == 'international.intlnoteSheetApprovedBy') class="active" @endif>
                                        <a href="{{route('international.intlnoteSheetApprovedBy')}}">Note Sheet Approved By</a>
                                    </li>
                                  </ul>
                              </li>
                          @endif
                      </ul>
              @endif
              {{--Trave Management End--}}

                {{--issuing of batch document--}}
                @if($data->mcategory == 30)

{{--@if(strpos(request()->getHttpHost(),'web.inceptapharma.com:5031') !== false && ( Auth::user()->emp_plant === '1100' || Auth::user()->emp_plant === '1300' || Auth::user()->emp_plant === '2100' || Auth::user()->emp_plant === '2200'))--}}

                    @if(( Auth::user()->emp_plant === '1100' || Auth::user()->emp_plant === '1500' || Auth::user()->emp_plant === '1300' || Auth::user()->emp_plant === '2100' || Auth::user()->emp_plant === '2200'))
                        <li @if(Request::segment(1) == 'ibd') class="menu-list nav-active"
                            @else class="menu-list" @endif><a href="#"><i class="fa fa-folder"></i> <span>Issue of Batch Document</span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)
                                    <?php $arr82 = explode('|', $data->scategory); ?>
                                    @if(in_array('1',$arr82,false))
                                        <li @if(Route::getCurrentRoute()->uri() == 'ibd/ibd_home') class="active" @endif>
                                            <a href="{{url('ibd/ibd_home')}}">Print Document</a>
                                        </li>
                                    @endif
                                    @if(in_array('2',$arr82,false))

                                        <li @if(Route::getCurrentRoute()->uri() == 'ibd/log_view') class="active" @endif>
                                            <a href="{{url('ibd/log_view')}}">Print Report</a>
                                        </li>
                                    @endif
                                @elseif(strpos($data->scategory,'All') !== false)
                                    <li @if(Route::getCurrentRoute()->uri() == 'ibd/ibd_home') class="active" @endif>
                                        <a href="{{url('ibd/ibd_home')}}">Print Document</a>
                                    </li>
                                    <li @if(Route::getCurrentRoute()->uri() == 'ibd/log_view') class="active" @endif>
                                        <a href="{{url('ibd/log_view')}}">Print Report</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                {{--            end of batch document--}}

                {{--            Employee Daily Attendance--}}
                @if($data->mcategory == 33)
                    {{-- @if(strpos(request()->getHttpHost(),'web.inceptapharma.com:5031') !== false && ( Auth::user()->plant_id === '1100' || Auth::user()->plant_id === '1300'))--}}
                    <li @if(Request::segment(1) == 'damail') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-user"></i> <span>Emp. Daily Attendance</span></a>
                        <ul class="sub-menu-list">

                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr82 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr82,false))

                                    <li @if(Route::getCurrentRoute()->uri() == 'damail/home') class="active" @endif>
                                        <a href="{{url('damail/home')}}">Daily Attendance Mail</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Route::getCurrentRoute()->uri() == 'damail/home') class="active" @endif>
                                    <a href="{{url('damail/home')}}">Daily Attendance Mail</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    {{--                @endif--}}
                @endif
                {{-- STABILITY STUDY MANAGEMENT START    --}}
                @if($data->mcategory == 34)
                    <li @if(Request::segment(1) == 'ssm') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-book"></i>
                            <span>Stability Study Mang. </span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                {{-- Extra  --}}
                                <?php $arr83 = explode('|', $data->scategory); ?>
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Request::segment(2) == 'ssm/dataupload') class="active" @endif>
                                    <a href="{{url('ssm/dataupload')}}">Upload sample Data</a>
                                <li>
                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/sample_info') class="active" @endif>
                                    <a href="{{url('ssm/sample_info')}}">Sample Information</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/result_info') class="active" @endif>
                                    <a href="{{url('ssm/result_info')}}">Result Information</a>
                                </li>
                                 <li @if(Route::getCurrentRoute()->uri() == 'ssm/dailymachinerun_info') class="active" @endif>
                                    <a href="{{url('ssm/dailymachinerun_info')}}">Daily Machine Run Status</a>
                                </li>
                                 <li @if(Route::getCurrentRoute()->uri() == 'ssm/dailymachinerun_info') class="active" @endif>
                                    <a href="{{url('ssm/interim_info')}}">Interim Stability Data</a>
                                </li>
                                <li @if(Request::segment(2) =='report') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Report
                                    </a>
                                    <ul class="sub-menu-list-first">
                                        <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/interim/interimstabilitydatareport') class="active" @endif>
                                            <a href="{{url('ssm/report/interim/interimstabilitydatareport')}}">Interim Stability Data Report
                                            </a>
                                        </li>
                                        
                                        <li @if(Request::segment(3) =='sample') class="menu-list-3L2 nav-active active"
                                            @else class="menu-list-3L2" @endif class="menu-list-3L2">
                                            <a href="#"> <i class="fa fa-list"></i>Sample</a>
                                            <ul class="sub-menu-list-3L2">

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/monthlystabilitysampleplanner_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/monthlystabilitysampleplanner_info')}}">Monthly Stability Sample Planner
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/workloadcalc_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/workloadcalc_info')}}">Work Load
                                                        Calculation
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/machinehour_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/machinehour_info')}}">Machine Hour
                                                        Calculation
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/machineutical_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/machineutical_info')}}">Machine
                                                        Utilization Calculation
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/analystwiseprdctlist_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/analystwiseprdctlist_info')}}">Analyst
                                                        Wise Product List
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/timepointwiseprdctlist_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/timepointwiseprdctlist_info')}}">Time
                                                        Point Wise Product List
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/chamberwideproductlist_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/chamberwideproductlist_info')}}">Chamber
                                                        WiseProduct List
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/productlistmaturedwithinanytime_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/productlistmaturedwithinanytime_info')}}">Product
                                                        List
                                                        matured Within Any Time
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/sample/productlistmaturedtoday_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/sample/productlistmaturedtoday_info')}}">Product List Matured Today
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li @if(Request::segment(3) =='result') class="menu-list-3L2 nav-active active"
                                            @else class="menu-list-3L2" @endif class="menu-list-3L2">
                                            <a href="#"> <i class="fa fa-list"></i>Result</a>
                                            <ul class="sub-menu-list-3L2">

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/dailymachinerunstatus_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/dailymachinerunstatus_info')}}">Daily Machine Run Status
                                                    </a>
                                                </li>
                                                 <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata_info')}}">Summary of Stability Monitoring Data for PQR_24M1
                                                    </a>
                                                </li>
                                                 <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata24M2_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata24M2_info')}}">Summary of Stability Monitoring Data for PQR_24M2
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata24M3_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata24M3_info')}}">Summary of Stability Monitoring Data for PQR_24M3
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata36M1_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata36M1_info')}}">Summary of Stability Monitoring Data for PQR_36M1
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata36M2_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata36M2_info')}}">Summary of Stability Monitoring Data for PQR_36M2
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata48M1_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata48M1_info')}}">Summary of Stability Monitoring Data for PQR_48M1
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata48M2_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata48M2_info')}}">Summary of Stability Monitoring Data for PQR_48M2
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata60M1_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata60M1_info')}}">Summary of Stability Monitoring Data for PQR_60M1
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdata60M2_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdata60M2_info')}}">Summary of Stability Monitoring Data for PQR_60M2
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdatapdbatch01_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdatapdbatch01_info')}}">Summary of Stability Monitoring Data for PD Batch_01
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdatapdbatch02_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdatapdbatch02_info')}}">Summary of Stability Monitoring Data for PD Batch_02
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdatapdbatch03_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdatapdbatch03_info')}}">Summary of Stability Monitoring Data for PD Batch_03
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdatapdbatch04_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdatapdbatch04_info')}}">Summary of Stability Monitoring Data for PD Batch_04
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdatapdbatch05_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdatapdbatch05_info')}}">Summary of Stability Monitoring Data for PD Batch_05
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdataecountry01_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdataecountry01_info')}}">Summary of Stability Monitoring Data Export Country_01
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdataecountry02_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdataecountry02_info')}}">Summary of Stability Monitoring Data Export Country_02
                                                    </a>
                                                </li>

                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdataecountry03_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdataecountry03_info')}}">Summary of Stability Monitoring Data Export Country_03
                                                    </a>
                                                </li>
                                                 <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdataecountry04_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdataecountry04_info')}}">Summary of Stability Monitoring Data Export Country_04
                                                    </a>
                                                </li>
                                                <li @if(Route::getCurrentRoute()->uri() == 'ssm/report/result/stabilitymonitoringdataecountry05_info') class="active" @endif>
                                                    <a href="{{url('ssm/report/result/stabilitymonitoringdataecountry05_info')}}">Summary of Stability Monitoring Data Export Country_05
                                                    </a>
                                                </li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                            @endif
                        </ul>
                    </li>

                @endif
                {{-- STABILITY STUDY MANAGEMENT END --}}
                 {{-- CATEGORY 35 START  Recruitment Management System  Author :: Dipro   --}}

                {{--Recruitment Management System Starts Here--}} {{--Author: Dipro--}}

                @if($data->mcategory == 35)

                    <li @if(Request::segment(1) == 'rms') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="big-icon ico-users2"
                                                                      style="font-size: 16px; margin-right: 10px;"></i>
                            <span>Recruitment Management System</span></a>
                        <ul class="sub-menu-list">

                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr85 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/dept_wise_vacant_view') class="active" @endif>
                                        <a href="{{url('rms/dept_wise_vacant_view')}}">Department Wise
                                            Vacant</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/dept_wise_recruitment_view') class="active" @endif>
                                        <a href="{{url('rms/dept_wise_recruitment_view')}}">Department Wise
                                            Recruitment</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/dept_wise_cv_sorting_view') class="active" @endif>
                                        <a href="{{url('rms/dept_wise_cv_sorting_view')}}">Department Wise
                                            CV Sorting</a>
                                    </li>
                                @endif
                                @if(in_array('4',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/candidates_exam_records_view') class="active" @endif>
                                        <a href="{{url('rms/candidates_exam_records_view')}}">Candidate Exam
                                            Records</a>
                                    </li>
                                @endif
                                <!-- Masroor -->
                                @if(in_array('8',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/candidateAppointmentStatus') class="active" @endif>
                                        <a href="{{url('rms/candidateAppointmentStatus')}}">Candidate Status for Appointment </a>
                                    </li>
                                 @endif
                                <!-- Masroor -->
                                @if(in_array('5',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/job_appointment_letter_view') class="active" @endif>
                                        <a href="{{url('rms/job_appointment_letter_view')}}">Job Offer & Appointment
                                            Letter Issue</a>
                                    </li>
                                @endif
                                @if(in_array('6',$arr85,false))
                                    <li @if(Route::getCurrentRoute()->uri() == 'rms/recruitment_confirmation_view') class="active" @endif>
                                        <a href="{{url('rms/recruitment_confirmation_view')}}">Recruitment
                                            Complete</a>
                                    </li>
                                @endif
                                @if(in_array('7',$arr85,false))
                                    <li @if(Request::segment(2) =='report') class="menu-list-sec nav-active active"
                                        @else class="menu-list-sec" @endif>
                                        <a href="">
                                            <i class="fa fa-align-left"></i>
                                            Reports</a>
                                        <ul class="sub-menu-list-sec">
                                            @if(strpos($data->scate_two,',') !== false)
                                                <?php $arr_rms = explode(',', $data->scate_two);?>
                                                @if(substr($arr_rms[1],0,1) == '2')
                                                    @if(strpos(substr($arr95[1], 2, -1),'|') !== false)
                                                        <?php $arr_rms2 = explode('|', substr($arr_rms[1], 2, -1));?>
                                                        @if(in_array('1',$arr_rms2,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_vacant_status') class="active" @endif>
                                                                <a href="{{url('rms/report/dept_wise_vacant_status')}}">
                                                                    <i
                                                                            class="glyphicon glyphicon-registration-mark"></i>
                                                                    Dept Wise
                                                                    Status (Graphical Presentation)</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('2',$arr_rms2,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_vacant_report') class="active" @endif>
                                                                <a href="{{url('rms/report/dept_wise_vacant_report')}}">
                                                                    <i
                                                                            class="glyphicon glyphicon-registration-mark"></i>
                                                                    Dept Wise
                                                                    Vacant Report</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('3',$arr_rms2,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_recruitment_report') class="active" @endif>
                                                                <a href="{{url('rms/report/dept_wise_recruitment_report')}}">
                                                                    <i
                                                                            class="glyphicon glyphicon-registration-mark"></i>
                                                                    Dept Wise
                                                                    Recruitment Report</a>
                                                            </li>
                                                        @endif
                                                        @if(in_array('4',$arr_rms2,false))
                                                            <li @if(Route::getCurrentRoute()->uri() == 'rms/report/final_cv_sorting_list') class="active" @endif>
                                                                <a href="{{url('rms/report/final_cv_sorting_list')}}">
                                                                    <i
                                                                            class="glyphicon glyphicon-registration-mark"></i>
                                                                    Final CV
                                                                    Sorting List</a>
                                                            </li>
                                                        @endif
                                                    @elseif(strpos(substr($arr_rms[1], 2, -1),'All') !== false)
                                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_vacant_status') class="active" @endif>
                                                            <a href="{{url('rms/report/dept_wise_vacant_status')}}"> <i
                                                                        class="glyphicon glyphicon-registration-mark"></i>
                                                                Dept Wise
                                                                Status (Graphical Presentation)</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_vacant_report') class="active" @endif>
                                                            <a href="{{url('rms/report/dept_wise_vacant_report')}}"> <i
                                                                        class="glyphicon glyphicon-registration-mark"></i>
                                                                Dept Wise
                                                                Vacant Report</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_recruitment_report') class="active" @endif>
                                                            <a href="{{url('rms/report/dept_wise_recruitment_report')}}">
                                                                <i
                                                                        class="glyphicon glyphicon-registration-mark"></i>
                                                                Dept Wise
                                                                Recruitment Report</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/cv_sorting_report') class="active" @endif>
                                                            <a href="{{url('rms/report/cv_sorting_report')}}"> <i
                                                                        class="glyphicon glyphicon-registration-mark"></i>CV
                                                                Sorting Report</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/written_interview_result_report') class="active" @endif>
                                                            <a href="{{url('rms/report/written_interview_result_report')}}">
                                                                <i
                                                                        class="glyphicon glyphicon-registration-mark"></i>Written
                                                                Interview Result</a>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                            <!-- Dipro -->
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/dept_wise_vacant_view') class="active" @endif>
                                    <a href="{{url('rms/dept_wise_vacant_view')}}">Department Wise Vacant</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/dept_wise_recruitment_view') class="active" @endif>
                                    <a href="{{url('rms/dept_wise_recruitment_view')}}">Department Wise Recruitment</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/dept_wise_cv_sorting_view') class="active" @endif>
                                    <a href="{{url('rms/dept_wise_cv_sorting_view')}}">Department Wise CV Sorting</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/candidates_exam_records_view') class="active" @endif>
                                    <a href="{{url('rms/candidates_exam_records_view')}}">Candidate Exam Records</a>
                                </li>
                                <!-- Masroor -->
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/candidateAppointmentStatus') class="active" @endif>
                                    <a href="{{url('rms/candidateAppointmentStatus')}}">Candidate Status for Appointment</a>
                                </li>
                                <!-- Masroor -->
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/job_appointment_letter_view') class="active" @endif>
                                    <a href="{{url('rms/job_appointment_letter_view')}}">Job Offer & Appointment Letter
                                        Issue</a>
                                </li>
                                <li @if(Route::getCurrentRoute()->uri() == 'rms/recruitment_confirmation_view') class="active" @endif>
                                    <a href="{{url('rms/recruitment_confirmation_view')}}">Recruitment Complete</a>
                                </li>
                                <li @if(Request::segment(2) =='report') class="menu-list-first nav-active active"
                                    @else class="menu-list-first" @endif>
                                    <a href="#">
                                        <i class="fa fa-clipboard"></i>
                                        Reports
                                    </a>
                                    <ul class="sub-menu-list-first">
                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_vacant_status') class="active" @endif>
                                            <a href="{{url('rms/report/dept_wise_vacant_status')}}"> <i
                                                        class="glyphicon glyphicon-registration-mark"></i> Dept Wise
                                                Status (Graphical Presentation)</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_vacant_report') class="active" @endif>
                                            <a href="{{url('rms/report/dept_wise_vacant_report')}}"> <i
                                                        class="glyphicon glyphicon-registration-mark"></i> Dept Wise
                                                Vacant Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/dept_wise_recruitment_report') class="active" @endif>
                                            <a href="{{url('rms/report/dept_wise_recruitment_report')}}"> <i
                                                        class="glyphicon glyphicon-registration-mark"></i> Dept Wise
                                                Recruitment Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/cv_sorting_report') class="active" @endif>
                                            <a href="{{url('rms/report/cv_sorting_report')}}"> <i
                                                        class="glyphicon glyphicon-registration-mark"></i>CV
                                                Sorting Report</a>
                                        </li>
                                        <li @if(Route::getCurrentRoute()->uri() == 'rms/report/written_interview_result_report') class="active" @endif>
                                            <a href="{{url('rms/report/written_interview_result_report')}}"> <i
                                                        class="glyphicon glyphicon-registration-mark"></i>Written
                                                Interview Result</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </li>

                @endif

                {{--Recruitment Management System Ends Here--}} {{--Author: Dipro--}}

                {{--CATEGORY 35 END--}}

                    {{--TDS PROTAL--}}
                @if($data->mcategory == 36)
                    <li @if(Request::segment(1) == 'talent_development') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-tumblr-square"></i>
                            <span> Talent Development </span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr66 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr66,false))
                                    <li @if(Request::segment(2) == 'user_guidelines') class="active" @endif>
                                        <a href="{{url('talent_development/user_guidelines')}}">User Guidelines</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr66,false))
                                    <li @if(Request::segment(2) == 'tds_form') class="active" @endif>
                                        <a href="{{url('talent_development/tds_form')}}">Talent Development Form</a>
                                    </li>
                                @endif

                               <!--  @if(in_array('3',$arr66,false))
                                    <li @if(Request::segment(2) == 'tds_manager_form') class="active" @endif>
                                        <a href="{{url('talent_development/tds_manager_form')}}">Talent Development
                                            Manager</a>
                                    </li>
                                @endif -->
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Request::segment(2) == 'user_guidelines') class="active" @endif>
                                    <a href="{{url('talent_development/user_guidelines')}}">User Guidelines</a>
                                </li>
                                <li @if(Request::segment(2) == 'tds_form') class="active" @endif>
                                    <a href="{{url('talent_development/tds_form')}}">Talent Development Form</a>
                                </li>
                               <!--  <li @if(Request::segment(2) == 'tds_manager_form') class="active" @endif>
                                    <a href="{{url('talent_development/tds_manager_form')}}">Talent Development
                                        Manager</a>
                                </li> -->
                            @endif
                        </ul>
                    </li>
                @endif


                @if($data->mcategory == 37)
                    <li @if(Request::segment(1) == 'sp_portal') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-upload"></i> <span>Short
                                Product List</span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr7 = explode('|', $data->scategory); ?>
                                @if(in_array('1',$arr7,false))
                                    <li @if(Request::segment(2) == 'shortProducts') class="active" @endif>
                                        <a href="{{url('sp_portal/shortProducts')}}">Upload Short Product</a>
                                    </li>
                                @endif
                                @if(in_array('2',$arr7,false))
                                    <li @if(Request::segment(2) == 'monthWiseReport') class="active" @endif>
                                        <a href="{{url('sp_portal/monthWiseReport')}}">Month Wise Report</a>
                                    </li>
                                @endif
                                @if(in_array('3',$arr7,false))
                                    <li @if(Request::segment(2) == 'yearlyMonthSummaryReport') class="active" @endif>
                                        <a href="{{url('sp_portal/yearlyMonthSummaryReport')}}">Yearly Month Summary
                                            Report</a>
                                    </li>
                                @endif
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Request::segment(2) == 'shortProducts') class="active" @endif>
                                    <a href="{{url('sp_portal/shortProducts')}}">Upload Short Product</a>
                                </li>
                                <li @if(Request::segment(2) == 'monthWiseReport') class="active" @endif>
                                    <a href="{{url('sp_portal/monthWiseReport')}}">Month Wise Report</a>
                                </li>
                                <li @if(Request::segment(2) == 'yearlyMonthSummaryReport') class="active" @endif>
                                    <a href="{{url('sp_portal/yearlyMonthSummaryReport')}}">Yearly Month Summary
                                        Report</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

               
                @if(Auth::user()->user_id === '1005975' || Auth::user()->user_id === '1020387' || Auth::user()->user_id === '1020386' || Auth::user()->user_id === 'CDM_IT'|| Auth::user()->user_id === 'CDM_ADMIN'||Auth::user()->user_id === 'CDM_ENG'|| Auth::user()->user_id === 'CDMDB_7150')
                    @if($data->mcategory == 39)
                        <li @if(Request::segment(1) == 'stationery') class="menu-list nav-active"
                            @else class="menu-list" @endif>
                            <a href="#"><i class="fa fa-file-text"></i><span>Stationery Management</span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)
                                    <?php $arr91 = explode('|', $data->scategory);?>
                                    @if(in_array('1',$arr91,false))
                                        <li @if(Request::segment(2) =='item') class="menu-list-first nav-active active"
                                            @else class="menu-list-first" @endif>
                                            <a href="#">
                                                <i class="fa fa-clipboard"></i>
                                                Master Data
                                            </a>
                                            <ul class="sub-menu-list-first">
                                                @if(strpos($data->scate_two,',') !== false)
                                                    <?php $arr92 = explode(',', $data->scate_two); ?>
                                                    @if(substr($arr92[0],0,1) == '1')
                                                        @if(strpos(substr($arr92[0], 2, -1),'|') !== false)
                                                            <?php $arr93 = explode('|', substr($arr92[0], 2, -1));?>
                                                            @if(in_array('2',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/itemTypes') class="active" @endif>
                                                                    <a href="{{url('stationery/item/itemTypes')
                                                                    }}">Item Types</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('1',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/category') class="active" @endif>
                                                                    <a href="{{url('stationery/item/category')
                                                                    }}">Item Categories</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('3',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/items') class="active" @endif>
                                                                    <a href="{{url('stationery/item/items')
                                                                    }}">Item Master Data</a>
                                                                </li>
                                                            @endif

                                                        @elseif(strpos(substr($arr92[0], 2, -1),'All') !== false)
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/itemTypes') class="active" @endif>
                                                                <a href="{{url('stationery/item/itemTypes')}}">Item Types</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/category') class="active" @endif>
                                                                <a href="{{url('stationery/item/category')}}">Item Categories</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/items') class="active" @endif>
                                                                <a href="{{url('stationery/item/items')}}">Item Master Data</a>
                                                            </li>

                                                        @endif
                                                    @endif
                                                @endif
                                            </ul>
                                        </li>
                                    @endif

                                    @if(in_array('2',$arr91,false))
                                        <li @if(Request::segment(2) =='form') class="menu-list-first nav-active active"
                                            @else class="menu-list-first" @endif>
                                            <a href="#">
                                                <i class="fa fa-clipboard"></i>
                                                Forms
                                            </a>
                                            <ul class="sub-menu-list-first">
                                                @if(strpos($data->scate_two,',') !== false)
                                                    <?php $arr92 = explode(',', $data->scate_two); ?>
                                                    @if(substr($arr92[0],0,1) == '1')
                                                        @if(strpos(substr($arr92[0], 2, -1),'|') !== false)
                                                            <?php $arr93 = explode('|', substr($arr92[0], 2, -1));?>
                                                            @if(in_array('6',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/openingStock') class="active" @endif>
                                                                    <a href="{{url('stationery/form/openingStock')
                                                                        }}">Opening Stock</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('1',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/issueItem/itemIssue') class="active" @endif>
                                                                    <a href="{{url('stationery/form/issueItem/itemIssue')}}">Item Requisition</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('7',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/receive') class="active" @endif>
                                                                    <a href="{{url('stationery/form/receive') }}">Item Receive</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('3',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/transferItem/itemTransfer') class="active" @endif>
                                                                    <a href="{{url('stationery/form/transferItem/itemTransfer')}}">Item Transfer</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('8',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/transferReceive') class="active"
                                                                        @endif> <a href="{{url('stationery/form/transferReceive') }}">Item Transfer Receive</a>
                                                                </li>
                                                            @endif
                                                              @if(in_array('5',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/chalan/createChalan') class="active" @endif>
                                                                    <a href="{{url('stationery/form/chalan/createChalan')}}">Challan Receive</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('2',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/cwiptomainid/cwipIdToMainID') class="active" @endif>
                                                                    <a href="{{url('stationery/form/cwiptomainid/cwipIdToMainID')}}">Upgrage CWIP Id To Main Id</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('4',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemRepair/itemRepair') class="active" @endif>
                                                                    <a href="{{url('stationery/form/itemRepair/itemRepair')}}">Item Repair</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('9',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemDestruction') class="active" @endif>
                                                                    <a href="{{url('stationery/form/itemDestruction')
                                                                         }}">Item Destruction</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('10',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemSales') class="active" @endif>
                                                                    <a href="{{url('stationery/form/itemSales')
                                                                 }}">Item Sales</a>
                                                                </li>
                                                            @endif
                                                          
                                                        @elseif(strpos(substr($arr92[0], 2, -1),'All') !== false)
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/openingStock') class="active" @endif>
                                                                <a href="{{url('stationery/form/openingStock')}}">Opening Stock</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/issueItem/itemIssue') class="active" @endif>
                                                                <a href="{{url('stationery/form/issueItem/itemIssue')}}">Item 
                                                                </a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/receive') class="active" @endif>
                                                                <a href="{{url('stationery/form/receive') }}">Item Receive</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/transferItem/itemTransfer') class="active" @endif>
                                                                <a href="{{url('stationery/form/transferItem/itemTransfer')}}">Item Transfer</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/transferReceive') class="active"
                                                                    @endif> <a href="{{url('stationery/form/transferReceive') }}">Item Transfer Receive</a>
                                                            </li>
                                                             <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/chalan/createChalan') class="active" @endif>
                                                                <a href="{{url('stationery/form/chalan/createChalan')}}">Challan Receive</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/cwiptomainid/cwipIdToMainID') class="active" @endif>
                                                                <a href="{{url('stationery/form/cwiptomainid/cwipIdToMainID')}}">Upgrage CWIP Id To Main Id</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemRepair/itemRepair') class="active" @endif>
                                                                <a href="{{url('stationery/form/itemRepair/itemRepair')}}">Item Repair</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemDestruction') class="active" @endif>
                                                                <a href="{{url('stationery/form/itemDestruction')}}">Item Destruction</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemSales') class="active" @endif>
                                                                <a href="{{url('stationery/form/itemSales')}}">Item Sales</a>
                                                            </li>
                                                           
                                                        @endif
                                                    @endif
                                                @endif
                                            </ul>
                                        </li>
                                    @endif

                                    @if(in_array('3',$arr91,false))
                                        <li @if(Request::segment(2) =='report') class="menu-list-first nav-active active"
                                            @else class="menu-list-first" @endif>
                                            <a href="#">
                                                <i class="fa fa-clipboard"></i>
                                                Reports
                                            </a>
                                            <ul class="sub-menu-list-first">
                                                @if(strpos($data->scate_two,',') !== false)
                                                    <?php $arr92 = explode(',', $data->scate_two); ?>
                                                    @if(substr($arr92[0],0,1) == '1')
                                                        @if(strpos(substr($arr92[0], 2, -1),'|') !== false)
                                                            <?php $arr93 = explode('|', substr($arr92[0], 2, -1));?>
                                                            @if(in_array('1',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/stockReport') class="active" @endif>
                                                                    <a href="{{url('stationery/report/stockReport')
                                                                }}">Opening Stock Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('2',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_stock') class="active" @endif>
                                                                    <a href="{{url('stationery/report/item_stock')}}">Plant Wise Item Stock</a>
                                                                </li>
                                                            @endif

                                                        
                                                             @if(in_array('3',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_stock_ledger') class="active" @endif>
                                                                    <a href="{{url
                                                                    ('stationery/report/item_stock_ledger')}}">Plant
                                                                        Wise Item Stock Ledger</a>
                                                                </li>
                                                            @endif

                                                              @if(in_array('4',$arr93,false))
                                                                  <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/reqReport') class="active" @endif>
                                                            <a href="{{url('stationery/report/reqReport')}}">Item Requisition Report</a>
                                                            </li>
                                                  
                                                              @endif


                                                                    @if(in_array('5',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_uses_report') class="active" @endif>
                                                                    <a href="{{url('stationery/report/item_uses_report')}}">Item Uses Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('6',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/pr_receive_report') class="active"@endif>
                                                                    <a href="{{url('stationery/report/pr_receive_report')}}">PR Receive Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('7',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_transfer_report') class="active"@endif>
                                                                    <a href="{{url('stationery/report/item_transfer_report')}}">Item Transfer Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('8',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/trans_rcv_report') class="active"@endif>
                                                                    <a href="{{url ('stationery/report/trans_rcv_report') }}">Transfer Receive Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('9',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/challanRcvReport') class="active"@endif>
                                                                    <a href="{{url('stationery/report/challanRcvReport')}}">Challan Receive Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('10',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/cwipToMainIdReport') class="active"@endif>
                                                                    <a href="{{url('stationery/report/cwipToMainIdReport')}}">CWIP to main ID Report</a>
                                                                </li>
                                                            @endif
                                                            @if(in_array('11',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemRepairReport') class="active"@endif>
                                                                    <a href="{{url('stationery/report/itemRepairReport')}}">Item Repair Report</a>
                                                                </li>
                                                            @endif

                                                              @if(in_array('12',$arr93,false))
                                                                   <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemSalesReport') class="active"@endif>
                                                                        <a href="{{url('stationery/report/itemSalesReport')}}">Item Sales Report</a>
                                                                  </li>

                                                            @endif
                                                            @if(in_array('13',$arr93,false))
                                                                <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemDestReport') class="active"@endif>
                                                                    <a href="{{url('stationery/report/itemDestReport') }}">Item Destruction Report</a>
                                                                </li>
                                                            @endif

                                                        @elseif(strpos(substr($arr92[0], 2, -1),'All') !== false)
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/stockReport') class="active" @endif>
                                                                <a href="{{url('stationery/report/stockReport')}}">Opening Stock Report</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_stock') class="active" @endif>
                                                                <a href="{{url('stationery/report/item_stock')}}">Plant Wise Item Stock</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_stock_ledger') class="active" @endif>
                                                                <a href="{{url
                                                                ('stationery/report/item_stock_ledger')}}">Plant
                                                                    Wise Item Stock Ledger</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_uses_report') class="active" @endif>
                                                                    <a href="{{url('stationery/report/item_uses_report')}}">Item Uses Report</a>
                                                                </li>

                                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_uses_report_two') class="active" @endif>
                                                         <a href="{{url('stationery/report/item_uses_report_two')}}">Item Uses Report two</a>
                                                         </li>
                                                               
                                                                 

                                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/pr_receive_report') class="active"@endif>
                                                                <a href="{{url('stationery/report/pr_receive_report')}}">PR Receive Report</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_transfer_report') class="active"@endif>
                                                                <a href="{{url('stationery/report/item_transfer_report')}}">Item Transfer Report</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/trans_rcv_report') class="active"@endif>
                                                                <a href="{{url ('stationery/report/trans_rcv_report') }}">Transfer Receive Report</a>
                                                            </li>
                                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/challanRcvReport') class="active"@endif>
                                                                <a href="{{url('stationery/report/challanRcvReport')}}">Challan Receive Report</a>
                                                            </li>

                                                         <li @if(Route::getCurrentRoute()->uri() =='stationery/report/cwipToMainIdReport') class="active"@endif>
                                                        <a href="{{url('stationery/report/cwipToMainIdReport')}}">CWIP to main ID Report</a>
                                                        </li>
                                                         <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemRepairReport') class="active"@endif>
                                                          <a href="{{url('stationery/report/itemRepairReport')}}">Item Repair Report</a>
                                                         </li>

                                                         <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemSalesReport') class="active"@endif>
                                                        <a href="{{url('stationery/report/itemSalesReport')}}">Item Sales Report</a>
                                                        </li>
                                                        <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemDestReport') class="active"@endif>
                                                            <a href="{{url('stationery/report/itemDestReport') }}">Item Destruction Report</a>
                                                        </li>


                                                        @endif
                                                    @endif
                                                @endif
                                            </ul>
                                        </li>
                                    @endif

                                @elseif(strpos($data->scategory,'All') !== false)
                                    <li @if(Request::segment(2) =='item') class="menu-list-first nav-active active"
                                        @else class="menu-list-first" @endif>
                                        <a href="#">
                                            <i class="fa fa-clipboard"></i>
                                            Master Data
                                        </a>
                                        <ul class="sub-menu-list-first">
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/itemTypes') class="active" @endif>
                                                <a href="{{url('stationery/item/itemTypes')}}">Item Types</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/category') class="active" @endif>
                                                <a href="{{url('stationery/item/category')}}">Item Categories</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/item/items') class="active" @endif>
                                                <a href="{{url('stationery/item/items')}}">Item Master Data</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li @if(Request::segment(2) =='form') class="menu-list-first nav-active active"
                                        @else class="menu-list-first" @endif>
                                        <a href="#">
                                            <i class="fa fa-clipboard"></i>
                                            Forms
                                        </a>
                                        <ul class="sub-menu-list-first">
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/openingStock') class="active" @endif>
                                                <a href="{{url('stationery/form/openingStock')}}">Opening Stock</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/issueItem/itemIssue') class="active" @endif>
                                                <a href="{{url('stationery/form/issueItem/itemIssue')}}">Item Requisition</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/receive') class="active" @endif>
                                                <a href="{{url('stationery/form/receive') }}">Item Receive</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/transferItem/itemTransfer') class="active" @endif>
                                                <a href="{{url('stationery/form/transferItem/itemTransfer')}}">Item Transfer</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/transferReceive') class="active"
                                                    @endif> <a href="{{url('stationery/form/transferReceive') }}">Item Transfer Receive</a>
                                            </li>
                                              <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/chalan/createChalan') class="active" @endif>
                                                <a href="{{url('stationery/form/chalan/createChalan')}}">
                                                    Challan Receive
                                                </a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/cwiptomainid/cwipIdToMainID') class="active" @endif>
                                                <a href="{{url('stationery/form/cwiptomainid/cwipIdToMainID')}}">Upgrage CWIP Id To Main Id</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemRepair/itemRepair') class="active" @endif>
                                                <a href="{{url('stationery/form/itemRepair/itemRepair')}}">Item Repair</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemDestruction') class="active" @endif>
                                                <a href="{{url('stationery/form/itemDestruction')}}">Item Destruction</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/itemSales') class="active" @endif>
                                                <a href="{{url('stationery/form/itemSales')}}">Item Sales</a>
                                            </li>
                                          

                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/form/item_use/useIndex') class="active" @endif>
                                                <a href="{{url('stationery/form/item_use/useIndex')}}">Item Uses</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li @if(Request::segment(2) =='report') class="menu-list-first nav-active active"
                                        @else class="menu-list-first" @endif>
                                        <a href="#">
                                            <i class="fa fa-clipboard"></i>
                                            Reports
                                        </a>
                                        <ul class="sub-menu-list-first">
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/stockReport') class="active" @endif>
                                                <a href="{{url('stationery/report/stockReport')}}">Opening Stock Report</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_stock') class="active" @endif>
                                                <a href="{{url('stationery/report/item_stock')}}">Plant Wise Item Stock</a>
                                            </li>

                                          

                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_stock_ledger') class="active" @endif>
                                                <a href="{{url
                                                ('stationery/report/item_stock_ledger')}}">Plant
                                                    Wise Item Stock Ledger</a>
                                            </li>

                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/reqReport') class="active" @endif>
                                                <a href="{{url('stationery/report/reqReport')}}">Item Requisition Report</a>
                                            </li>

                                            <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_uses_report') class="active" @endif>
                                                <a href="{{url('stationery/report/item_uses_report')}}">Item Uses Report</a>
                                            </li>
                                             <li @if(Route::getCurrentRoute()->uri() == 'stationery/report/item_uses_report_two') class="active" @endif>
                                                         <a href="{{url('stationery/report/item_uses_report_two')}}">Item Uses Report two</a>
                                                         </li>


                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/pr_receive_report') class="active"@endif>
                                                <a href="{{url('stationery/report/pr_receive_report')}}">PR Receive Report</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/item_transfer_report') class="active"@endif>
                                                <a href="{{url('stationery/report/item_transfer_report')}}">Item Transfer Report</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/trans_rcv_report') class="active"@endif>
                                                <a href="{{url ('stationery/report/trans_rcv_report') }}">Transfer Receive Report</a>
                                            </li>

                                             <li @if(Route::getCurrentRoute()->uri() =='stationery/report/challanRcvReport') class="active"@endif>
                                                <a href="{{url('stationery/report/challanRcvReport')}}">Challan Receive Report</a>
                                            </li>

                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/cwipToMainIdReport') class="active"@endif>
                                                <a href="{{url('stationery/report/cwipToMainIdReport')}}">CWIP to main ID Report</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemRepairReport') class="active"@endif>
                                                <a href="{{url('stationery/report/itemRepairReport')}}">Item Repair Report</a>
                                            </li>
                                               <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemSalesReport') class="active"@endif>
                                                <a href="{{url('stationery/report/itemSalesReport')}}">Item Sales Report</a>
                                            </li>
                                            <li @if(Route::getCurrentRoute()->uri() =='stationery/report/itemDestReport') class="active"@endif>
                                                <a href="{{url('stationery/report/itemDestReport') }}">Item Destruction Report</a>
                                            </li>

                                        </ul>
                                    </li>
                                @endif
                            </ul>
                        </li>

                    @endif
                @endif
                
                 @if($data->mcategory == 42)
                    <li @if(Request::segment(1) == 'depot') class="menu-list nav-active"
                        @else class="menu-list" @endif><a href="#"><i class="fa fa-users"></i>
                            <span> Depot Employees </span></a>
                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr20 = explode('|', $data->scategory); ?>
                                <li @if(Route::getCurrentRoute()->uri() == 'depot/depotEmpList') class="active"
                                        @endif>
                                    <a href="{{url('depot/depotEmpList')}}">Depot Employee List</a>
                                </li>
                            @elseif(strpos($data->scategory,'All') !== false)
                                <li @if(Route::getCurrentRoute()->uri() == 'depot/depotEmpList') class="active" @endif>
                                    <a href="{{url('depot/depotEmpList')}}">Depot Employee List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                    
                @if($data->mcategory == 43)
                        <li @if(Request::segment(1) == 'employeeExtention') class="menu-list nav-active"
                            @else class="menu-list" @endif>
                            <a href="#"><i class="fa fa-user"></i><span>Employee Extention Information</span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)
                                    <?php $arr91 = explode('|', $data->scategory);?>
                                        @if(in_array('1',$arr7,false))
                                            <li @if(Request::segment(2) == 'shortProducts') class="active" @endif>
                                                <a href="{{url('sp_portal/shortProducts')}}">Upload Short Product</a>
                                            </li>
                                        @endif

                                @elseif(strpos($data->scategory,'All') !== false)
                                    <li @if(Route::getCurrentRoute()->uri() == 'employeeExtention/viewEmpExt') class="active" @endif>
                                        <a href="{{url('employeeExtention/viewEmpExt')}}">Employee Extention </a>
                                    </li>

                                       
                                    <li @if(Route::getCurrentRoute()->uri() == 'employeeExtention/viewEmpExtReport') class="active" @endif>
                                        <a href="{{url('employeeExtention/viewEmpExtReport')}}">Employee Extention Report </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                @endif


                   @if($data->mcategory == 47  )
                    <li @if(Request::segment(1) == 'serviceAgreementNotification') class="menu-list nav-active"
                        @else class="menu-list" @endif>
                        <a href="#"><i class="fa fa-bell"></i><span>Service Agreement Notification</span></a>

                        <ul class="sub-menu-list">
                            @if(strpos($data->scategory,'|') !== false)
                                <?php $arr95 = explode('|', $data->scategory);?>
                                @if(in_array('1',$arr95,false))
                                    <li @if(Request::segment(2) == 'serviceAgreementNotification') class="active" @endif>
                                        <a href="{{url('serviceAgreementNotification/viewService')}}">Service Agreement Notification</a>
                                    </li>
                                @endif

                            @elseif(strpos($data->scategory,'All') !== false)

                                <li @if(Route::getCurrentRoute()->uri() == 'serviceAgreementNotification/viewService') class="active" @endif>
                                    <a href="{{url('serviceAgreementNotification/viewService')}}">Service Agreement Notification</a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif



              @if($data->mcategory == 44)
                     <li @if(Request::segment(1) == 'visaAirTicketAndHotelInfoSys') class="menu-list nav-active"
                         @else class="menu-list" @endif>
                           <a href="#"><i class="fa fa-ticket"></i><span>Visa And Air Ticket & Hotel Info System</span></a>
                         <ul class="sub-menu-list">
                             @if(strpos($data->scategory,'|') !== false)
                                 <?php $arr95 = explode('|', $data->scategory);?>
                                 @if(in_array('1',$arr95,false))
                                     <li @if(Request::segment(2) == 'visaAirTicketAndHotelInfoSys') class="active" @endif>
                                         <a href="{{url('visaAirTicket/shortProducts')}}">Visa And Air Ticket Info</a>
                                     </li>
                                 @endif
                             @elseif(strpos($data->scategory,'All') !== false)


                                <li @if(Route::getCurrentRoute()->uri() == 'visaAirTicketAndHotelInfoSys/visaAirTicket/viewAirTicket') class="active" @endif>
                                     <a href="{{url('visaAirTicketAndHotelInfoSys/visaAirTicket/viewAirTicket')}}">Visa And Air Ticket Info</a>
                                 </li>

                                 <li @if(Route::getCurrentRoute()->uri() == 'visaAirTicketAndHotelInfoSys/hotelManagement/viewHotelManagement') class="active" @endif>
                                     <a href="{{url('visaAirTicketAndHotelInfoSys/hotelManagement/viewHotelManagement')}}">Hotel Management System</a>
                                 </li>

                             @endif
                         </ul>
                     </li>
                 @endif

               
                @if($data->mcategory == 45 )
                        <li @if(Request::segment(1) == 'attendenceManagementSys') class="menu-list nav-active"
                            @else class="menu-list" @endif>
                            <a href="#"><i class="fa fa-users"></i><span>Attendance Status Daily</span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)
                                    <?php $arr95 = explode('|', $data->scategory);?>
                                    @if(in_array('1',$arr95,false))
                                        <li @if(Request::segment(2) == 'attendenceManagementSys') class="active" @endif>
                                            <a href="{{url('attendence/viewAttendence')}}">Absenteeism Reporting</a>
                                        </li>
                                    @endif
                                @elseif(strpos($data->scategory,'All') !== false)


                                    <li @if(Route::getCurrentRoute()->uri() == 'attendenceManagementSys/attendence/shiftTradeRequest') class="active" @endif>
                                        <a href="{{url('attendenceManagementSys/attendence/shiftTradeRequest')}}">Team Schedule</a>


                                    <li @if(Route::getCurrentRoute()->uri() == 'attendenceManagementSys/attendence/viewAttendence') class="active" @endif>
                                        <a href="{{url('attendenceManagementSys/attendence/viewAttendence')}}">Absenteeism Reporting</a>
                                    </li>

                                @endif
                            </ul>
                        </li>
                @endif

            
                @if( Auth::user()->user_id === '1005975' || Auth::user()->user_id === '1010112' || Auth::user()->user_id
                === '1020387' || Auth::user()->user_id === '1020386' || Auth::user()->user_id === '1003433' || Auth::user
                ()->user_id === '1003457' || Auth::user()->user_id === '1000122' || Auth::user()->user_id === '1015741'
                || Auth::user()->user_id === '1016631' || Auth::user()->user_id === '1022246' || Auth::user()->user_id
                === '1021915' || Auth::user()->user_id === '1022221' || Auth::user()->user_id === '1020981' || Auth::user
                ()->user_id === '1004184' || Auth::user()->user_id === '1021366' || Auth::user()->user_id === '1021207')
                    @if($data->mcategory == 46)
                        <li @if(Request::segment(1) == 'import_management') class="menu-list nav-active"
                            @else class="menu-list" @endif>
                            <a href="#"><i class="fa fa-file-text"></i><span>Import Management</span></a>
                            <ul class="sub-menu-list">
                                @if(strpos($data->scategory,'|') !== false)
                                    <?php $arr91 = explode('|', $data->scategory);?>
                                        @if(in_array('1',$arr91,false))
                                            <li @if(Request::segment(2) == 'capex_items') class="active" @endif>
                                                <a href="{{url('import_management/capex_items')}}">SPARE PARTS,
                                                    SERVICE AND CAPITAL MACHINERY</a>
                                            </li>
                                        @endif
                                        @if(in_array('7',$arr91,false))
                                            <li @if(Request::segment(2) == 'raw_pack_lab_planning') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/raw_pack_lab_planning')}}">RAW-PACK LAB-PLANNING</a>
                                            </li>
                                        @endif
                                        @if(in_array('8',$arr91,false))
                                            <li @if(Request::segment(2) == 'lc_management') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/lc_management')}}">LC MANAGEMENT</a>
                                            </li>
                                        @endif
                                        @if(in_array('9',$arr91,false))
                                            <li @if(Request::segment(2) == 'doc_management') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/doc_management')}}">DOCUMENTATION</a>
                                            </li>
                                        @endif
                                        @if(in_array('10',$arr91,false))
                                            <li @if(Request::segment(2) == 'duty_management') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/duty_management')}}">DUTY</a>
                                            </li>
                                        @endif
                                        @if(in_array('11',$arr91,false))
                                            <li @if(Request::segment(2) == 'finance_management') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/finance_management')}}">FINANCE</a>
                                            </li>
                                        @endif
                                        @if(in_array('12',$arr91,false))
                                            <li @if(Request::segment(2) == 'scmDataModification')
                                                class="active" @endif>
                                                <a href="{{url('import_management/scmDataModification')}}">INPUT DATA MANAGEMENT</a>
                                            </li>
                                        @endif
                                        <!-- @if(in_array('13',$arr91,false))
                                            <li @if(Request::segment(2) =='') class="menu-list-first nav-active active"
                                                @else class="menu-list-first" @endif>
                                                <a href="#">
                                                    <i class="fa fa-clipboard"></i>
                                                    REPORTS
                                                </a>
                                                <ul class="sub-menu-list-first">
                                                    <li @if(Request::segment(2) == 'capex_report') class="active"
                                                            @endif>
                                                        <a href="{{url('import_management/capex_report')}}">CAPEX REPORT</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endif -->
                                        <!-- @if(in_array('6',$arr91,false))
                                            <li @if(Request::segment(2) == 'mat_purchase_info') class="active" @endif>
                                                <a href="{{url('import_management/mat_purchase_info')}}">Material Purchase
                                                    Information</a>
                                            </li>
                                        @endif
                                        @if(in_array('2',$arr91,false))
                                            <li @if(Request::segment(2) == 'mat_purchase_report') class="active" @endif>
                                                <a href="{{url('import_management/mat_purchase_report')}}">Material Purchase
                                                    Report</a>
                                            </li>
                                        @endif
                                        @if(in_array('3',$arr91,false))
                                            <li @if(Request::segment(2) == 'committed_report') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/committed_report')}}">Finance Report -
                                                    Capex/Raw pack committed</a>
                                            </li>
                                        @endif
                                        @if(in_array('4',$arr91,false))
                                            <li @if(Request::segment(2) == 'uncommitted_report')
                                                class="active" @endif>
                                                <a href="{{url('import_management/uncommitted_report')}}">Finance Report -
                                                    Capex uncommitted</a>
                                            </li>
                                        @endif -->
                                @elseif(strpos($data->scategory,'All') !== false)
                                    <li @if(Request::segment(2) == 'capex_items') class="active" @endif>
                                        <a href="{{url('import_management/capex_items')}}">SPARE PARTS,
                                            SERVICE AND CAPITAL MACHINERY</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'raw_pack_lab_planning') class="active"
                                            @endif>
                                        <a href="{{url('import_management/raw_pack_lab_planning')}}">RAW-PACK LAB-PLANNING</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'lc_management') class="active"
                                            @endif>
                                        <a href="{{url('import_management/lc_management')}}">LC MANAGEMENT</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'doc_management') class="active"
                                            @endif>
                                        <a href="{{url('import_management/doc_management')}}">DOCUMENTATION</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'duty_management') class="active"
                                            @endif>
                                        <a href="{{url('import_management/duty_management')}}">DUTY</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'finance_management') class="active"
                                            @endif>
                                        <a href="{{url('import_management/finance_management')}}">FINANCE</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'scmDataModification') class="active" @endif>
                                        <a href="{{url('import_management/scmDataModification')}}">INPUT DATA MANAGEMENT</a>
                                    </li>
                                    <!-- <li @if(Request::segment(2) =='') class="menu-list-first nav-active active"
                                        @else class="menu-list-first" @endif>
                                        <a href="#">
                                            <i class="fa fa-clipboard"></i>
                                            REPORTS
                                        </a>
                                        <ul class="sub-menu-list-first">
                                            <li @if(Request::segment(2) == 'capex_report') class="active"
                                                    @endif>
                                                <a href="{{url('import_management/capex_report')}}">CAPEX REPORT</a>
                                            </li>
                                        </ul>
                                    </li> -->
                                    <!-- <li @if(Request::segment(2) == 'mat_purchase_info') class="active" @endif>
                                        <a href="{{url('import_management/mat_purchase_info')}}">Material Purchase
                                            Information</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'mat_purchase_report') class="active" @endif>
                                        <a href="{{url('import_management/mat_purchase_report')}}">Material Purchase
                                            Report</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'committed_report') class="active"
                                            @endif>
                                        <a href="{{url('import_management/committed_report')}}">Finance Report -
                                            Capex/Raw pack committed</a>
                                    </li>
                                    <li @if(Request::segment(2) == 'uncommitted_report')
                                        class="active" @endif>
                                        <a href="{{url('import_management/uncommitted_report')}}">Finance Report -
                                            Capex uncommitted</a>
                                    </li> -->
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif

            @endforeach
        </ul>
@endif
<!--sidebar nav end-->

</div>
<script>
    function showLoader(){
        $('#loader_master').show();
    }
</script>