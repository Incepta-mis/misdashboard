<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="{{url('public/site_resource/images/incepta.png')}}" type="image/png">

    <title>@yield('title','title')</title>

    <link href="{{url('public/site_resource/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>

{{--    {{Html::style('site_resource/css/bootstrap.min.css')}}--}}
    {{Html::style('public/site_resource/css/style.css')}}
    {{Html::style('public/site_resource/css/style-responsive.css')}}
    {{Html::style('public/site_resource/css/nprogress.css')}}
    {{Html::style('public/site_resource/fonts/css/font-awesome.min.css')}}
    {{Html::style('public/site_resource/css/toast/toastr.min.css')}}

    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>

    {{Html::script('public/site_resource/js/html5shiv.js')}}
    {{Html::script('public/site_resource/js/respond.min.js')}}


    <![endif]-->

    @yield('styles')
</head>
<body class="sticky-header">
<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo" style="background: #a2aec7">
            <a href="{{url('home')}}">
                {{Html::image('public/site_resource/images/logonu.png','i-icon',['width'=>'75px','height'=>'40px','style'=>'margin-left: 20px;padding-top:5px;'])}}
                <span style="font-family: 'Open Sans',sans-serif;font-size: 2.0rem;font-style: italic;"><strong>Incepta MIS</strong></span>
            </a>
        </div>

        <div class="logo-icon text-center">
            <a href="{{url('home')}}">
                {{Html::image('public/site_resource/images/logo_icon.png')}}</a>
        </div>
        <!--logo and iconic logo end-->
        @include('_layout_shared._nav_items')
    </div>
    <!-- left side end-->

    <!-- main content start-->
    <div class="main-content">

        <div class="row">
            <div class="col-md-12 col-sm-12" id="loader_master" style="display:none;margin-top: 5px;">
                <div class="col-md-4 col-sm-4 col-md-offset-4 text-center alert alert-info">
                    <div id="loading">
                        <img id="loading-image" src="{{url('public/site_resource/images/preloader.gif')}}" alt="Loading..
                            ." width="50" height="55"/>
                    </div>
                </div>
            </div>
        </div>
        <!-- header section start-->
        <div class="header-section" id="fix">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->
            <div>
                @yield('top-nav-items')
            </div>
            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                    @if(explode('|',Auth::user()->remark1)[0] === 'DBAR')
                    <li class="">
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            @if(isset($dbmcnt) && $dbmcnt[0]->tc > 0)
                             <span class="badge"><i class="fa fa-info"></i></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                            <h5 class="title">Notifications</h5>
                            <ul class="dropdown-list normal-list">
                               @if(isset($dbmcnt) && $dbmcnt[0]->tc > 0)
                                    <li class="new">
                                        <a href="{{url('rm_portal/dabr_home')}}">
                                            <span class="label label-danger"><i class="fa fa-info"></i></span>
                                            <span class="name" title="Doctor Birthday/Marriage Anniversary Events">Upcoming Doctor Events</span>
                                            <span class="badge badge-important">{{$dbmcnt[0]->tc}}</span>
                                        </a>
                                    </li>
                                @else
                                <li class="new">
                                    <a href="#">
                                        <span class="label label-danger"><i class="fa fa-info"></i></span>
                                        <span class="name">No New Notification!</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            {{Html::image('public/site_resource/images/User_Circle.png','')}}
                            {{Auth::user()->user_id}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="{{url('user/profile')}}"><i class="fa fa-user"></i> Profile</a></li>
                            <!-- <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li> -->
                            <li><a href="{{url('logout')}}"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->

        <!--body wrapper start-->
        <div class="wrapper">
            @yield('right-content')
            @includeIf('emp_history.emp_his_credential_modal')
        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <footer class="sticky-footer" style="text-align:left;">
            @yield('footer-content')
        </footer>
        <!--footer section end-->

    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<!--common scripts for all pages-->
{{Html::script('public/site_resource/js/jquery-2.1.4.min.js')}}
{{Html::script('public/site_resource/js/jquery-ui-1.9.2.custom.min.js')}}
{{Html::script('public/site_resource/js/jquery-migrate-1.2.1.min.js')}}
{{Html::script('public/site_resource/js/bootstrap.min.js')}}
{{Html::script('public/site_resource/js/modernizr.min.js')}}
{{Html::script('public/site_resource/js/jquery.nicescroll.js')}}

{{Html::script('public/site_resource/js/nprogress.js')}}
{{Html::script('public/site_resource/js/toast/toastr.min.js')}}
{{Html::script('public/site_resource/js/ckeditor.js')}}
{{Html::script('public/site_resource/js/scripts.js?ts='.time().'')}}
<!-- //number format -->
{{Html::script('public/site_resource/js/numberformat/accounting.js')}}
    
{{--<script type="text/javascript" src="{{url('admin_assets/js/toast/toastr.min.js')}}"></script>--}}

<script type="text/javascript">
    NProgress.configure({ showSpinner: false });
    NProgress.start();
    NProgress.done();
    chk_credential = '{{url('ehf/chk_credential')}}';
    ehf_credential = '{{url('ehf/ehf_credential')}}';
    ehf_home = '{{url('ehf/emp_history_entry')}}';
</script>

{{--pagescripts--}}
@yield('scripts')

 
    
</body>
</html>

