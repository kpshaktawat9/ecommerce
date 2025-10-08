<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
        <!-- Place favicon.ico in the root directory -->

		<!-- CSS here -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.mCustomScrollbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/swiper-bundle.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery-ui.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/nice-select.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/jarallax.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/flaticon.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/slick.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/default.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/responsive.css')}}">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div id="app">
            <h3>Hello</h3>
        </div>
        <!-- JS here -->
        <script src="{{asset('frontend/assets/js/vendor/jquery-3.5.0.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/popper.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/isotope.pkgd.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/imagesloaded.pkgd.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/jquery.nice-select.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/jquery.countdown.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/swiper-bundle.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/jarallax.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/slick.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('frontend/assets/js/nav-tool.js')}}"></script>
        <script src="{{asset('frontend/assets/js/plugins.js')}}"></script>
        <script src="{{asset('frontend/assets/js/main.js')}}"></script>
    </body>
</html>
