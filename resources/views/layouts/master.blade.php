<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Website bán hàng">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title> @yield('title') - {{ config('app.name') }} </title>
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

  <!-- Embed CSS -->
  <link rel="stylesheet" href="{{ asset('common/css/normalize.min.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/bootstrap-theme.min.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/fontawesome/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('common/css/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 


  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @if(Request::route()->getName() != 'show_cart')
  <link rel="stylesheet" href="{{ asset('css/minicart.css') }}">
  <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
  <link rel="stylesheet" href="{{ asset('css/social.css') }}">
  @endif
  @yield('css')
</head>
<body>
  <!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml: true,
      version: 'v4.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<!-- Facebook Messenger Chat Plugin -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="61563798942587"
  theme_color="#ff3300"
  logged_in_greeting="Chào bạn, chúng tôi có thể giúp gì cho bạn?"
  logged_out_greeting="Chào bạn, vui lòng đăng nhập để chat với chúng tôi.">
</div>

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
      <!-- Site Content -->
      <div class="site-content">
        @yield('content')
      </div>
    </div>

    @if(Request::route()->getName() != 'show_cart')
    <!-- MiniCart display -->
    @include('layouts.minicart')
    @include('layouts.wishlist')
    @include('layouts.social')
    @endif

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Embed Scripts -->
    <script src="{{ asset('common/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('common/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('common/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('common/js/sweetalert2.min.js') }}"></script>
   
    <!-- Custom Scripts -->
    <script src="{{ asset('js/custom.js') }}"></script>
    @if(Request::route()->getName() != 'show_cart')
    <script src="{{ asset('js/minicart.js') }}"></script>
    @endif
    @yield('js')
</body>
</html>
