<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="incepta">
    <link rel="shortcut icon" href="{{url('public/site_resource/images/incepta.png')}}" type="image/png"/>
    {{--<link rel="shortcut icon" href="{{url('site_resource/images/incepta.png')}}" type="image/png">--}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}
    <link href="{{url('public/site_resource/css/fonts/login-google-fonts.css')}}" rel="stylesheet" type="text/css"/>
    <title>@yield('title','title of the page')</title>

    <link href="{{ url('public/site_resource/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
{{--{{Html::style('site_resource/css/bootstrap.min.css')}}--}}
    {{Html::style('public/site_resource/css/style.css')}}
    {{Html::style('public/site_resource/css/style-responsive.css')}}
    {{Html::style('public/site_resource/fonts/css/font-awesome.min.css')}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>

    {{Html::script('public/site_resource/js/html5shiv.js')}}
    {{Html::script('public/site_resource/js/respond.min.js')}}

    <![endif]-->
    @yield('styles')
</head>

<body class="login-body">

<div class="container">

    @yield('body-content')

</div>

<!-- Placed js at the end of the document so the pages load faster -->

{{Html::script('public/site_resource/js/jquery-1.10.2.min.js')}}
{{Html::script('public/site_resource/js/bootstrap.min.js')}}
{{Html::script('public/site_resource/js/modernizr.min.js')}}

@yield('scripts')

</body>
</html>
