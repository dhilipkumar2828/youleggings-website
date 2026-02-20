<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>You Leggings</title>

    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="keywords" content="" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="base_url" content="{{ url('/') }}">

    <!-- Favicon -->

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/img/you-leggings.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">
    <link rel='stylesheet' href='https://unpkg.com/swiper@6.5.4/swiper-bundle.min.css'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/range-slider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/nice-select.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.min.css?v=100') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">

</head>

<body>

    @include('frontend.layouts.arrivals_products_header_new')

    @yield('content')

    @include('frontend.layouts.footer')
    <script src="{{ asset('frontend/js/modernizr-3.11.7.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-migrate-3.3.2.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    @include('frontend.layouts.script')
    @yield('script')
    <script type="text/javascript">
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
