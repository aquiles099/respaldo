<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <base href="{{asset('/')}}" target="_self">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{trans('messages.ICS')}}">
    <meta name="author" content="{{trans('messages.ICS')}}">
    <meta name="title" content="{{trans('messages.ICS')}}">
    <!--DEFINE[verify & bot]-->
    <meta name="googlebot" content="all">
    <meta name="google-site-verification" content="iO5_MZm3Q_BGIgqgeHCdAd40kI6YQA-Mi9mXfRWXi00" />
    <!--DEFINE[Keywords]-->
    <meta name="keywords" content="@yield('keywords', trans('messages.keywords'))">
    <!--DEFINE[facebook]-->
    @yield('meta-facebook')
    <!--DEFINE[twitter]-->
    @yield('meta-twitter')
    <!--DEFINE[title]-->
    <title>ICS - @yield('title-page', 'ICS')</title>
    <!-- Customize favicon-->
    <link rel="shortcut icon" type="image/png" href="{{asset('dist/img/favicon.png')}}"/>
    <!-- Bootstrap Core CSS -->
    {!! HTML::style(asset('bower_components/bootstrap/dist/css/bootstrap.min.css')) !!}
    <!-- Bootstrap Responsive-->
    {!! HTML::style(asset('dist/css/bootstrap-responsive.min.css')) !!}
    <!-- Custom Fonts-Awensome -->
    {!! HTML::style(asset('bower_components/components-font-awesome/css/font-awesome.min.css')) !!}
    <!-- Custom Fonts-Tipografy-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,400,900" rel="stylesheet">
    <!-- Custom Style-->
    {!! HTML::style(asset('dist/css/style.css')) !!}
    <!-- Set DataTables -->
    {!! HTML::style(asset('bower_components/datatables/media/css/jquery.dataTables.min.css')) !!}
    <!-- Set Main CSS -->
    {!! HTML::style(asset('dist/css/main.css')) !!}
    <!-- Set Select 2 -->
    {!! HTML::style(asset('bower_components/select2/dist/css/select2.min.css')) !!}
    <!-- Set Owl Carousel -->
    {!! HTML::style(asset('bower_components/OwlCarousel/owl-carousel/owl.carousel.css')) !!}
    <!-- Set Owl Carousel Theme-->
    {!! HTML::style(asset('bower_components/OwlCarousel/owl-carousel/owl.theme.css')) !!}
    <!--Set DatePicker-->
    {!! HTML::style(asset('bower_components/datepicker/css/datepicker.css'))!!}
    <!-- Set Jquery -->
    {!! HTML::script(asset('dist/js/jquery.js')) !!}
    <!--Set Main Js-->
    {!! HTML::script(asset('src/js/main.js')) !!}
    <!--Set Facebook Plugins-->
    <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.9";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
    <!--Set Pinterest Plugins-->
    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
  </head>
