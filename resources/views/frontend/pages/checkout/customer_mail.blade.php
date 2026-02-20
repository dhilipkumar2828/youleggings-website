<!DOCTYPE html>

<html class="no-js" lang="zxx">

<head>

    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Tulia - Cosmetic & Beauty Care Products</title>

    <meta name="robots" content="noindex, follow" />

    <meta name="description" content="Tulia - Cosmetic & Beauty Care Products">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="keywords" content="Tulia, Beauty Care Products, Skin Care, Hair Care" />

    <meta name="author" content="codecarnival" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="base_url" content="{{ url('/') }}">

    <!-- Favicon -->

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/img/favicon.png') }}">

    <!-- CSS (Font, Vendor, Icon, Plugins & Style CSS files) -->

    <!-- Font CSS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS (Bootstrap & Icon Font) -->

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap.min.css') }}">

    <!-- Plugins CSS (All Plugins Files) -->

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/fancybox.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/range-slider.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/nice-select.css') }}">

    <!-- Style CSS -->

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/custom.css') }}">

    <!-- <link rel="stylesheet" href="./assets/css/owl.carousel.css"> -->

</head>

<body>

    <p>Your order has been placed</p>

    <p>Your Order Id is {{ $details['order_id'] }}</p>

    <p>Track your order here <a href="{{ url('customer/my_account') }}">{{ $details['order_id'] }}</a></p>

</body>

</html>
