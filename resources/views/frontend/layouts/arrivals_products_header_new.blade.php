<div class="wrapper">

    <header class="header-area sticky-header header_top">

        <div class="container-fluid">

            <div class="row align-items-center">
                <div class="col col-md-4 text-center">
                    <ul class="top_menu">
                        <li><a href="">Home</a></li>
                        <li><a href="{{ url('aboutus') }}">About Us </a></li>
                        <li><a href="{{ url('all_products') }}">Shop </a></li>
                        <li><a href="{{ url('newarrival_list') }}">New Arrivals</a></li>
                        <li><a href="">Blog</a></li>
                        <li><a href="{{ url('contactus') }}">Contact us</a></li>
                    </ul>
                </div>
                <div class="col col-md-4">
                    <div class="header-logo text-center">
                        <a href="{{ url('index') }}" class="d-inline-block">
                            <img class="logo-main" src="{{ $settings && $settings->logo ? (Str::contains($settings->logo, '/') ? asset($settings->logo) : asset('uploads/settings/'.$settings->logo)) : asset('frontend/img/you-leggings.png') }}" alt="Logo" />

                        </a>
                    </div>
                </div>
                <div class="col col-md-4">
                    <div class="header-action justify-content-end">
                        <form action="{{ url('search') }}" method="post">
                            @csrf

                            @php
                                $product_name = session('product_name', '');
                            @endphp
                            <div class="aside-search-form">
                                <input id="SearchInput" type="text" name="product_name"
                                    class="form-control mb-0 search-text-box" placeholder="Search…"
                                    value="{{ $product_name }}">
                                <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>

                        <ul class="m-0">
                            <li>
                                @if (Auth::guard('users')->user() || Auth::guard('guest')->user())
                                    <div class="dropdown logoutheader">
                                        <a href="{{ url('customer/my_account') }}" class="dropbtn">

                                            Dashboard <span class="mobile-view-none"> </span></a>

                                        @php
                                            if (Auth::guard('users')->check()) {
                                                $id = auth()->guard('users')->user()->id;
                                            } elseif (Auth::guard('guest')->check()) {
                                                $id = auth()->guard('guest')->user()->id;
                                            } else {
                                                $id = '';
                                            }

                                            $wishlist = DB::table('wishlists')->where('customer_id', $id)->count();
                                            //$wishlist=DB::table('wishlists')->where('customer_id',$id)->get()->count;
                                        @endphp
                                        <!--<span class="icon-1 position-relative">-->
                                        <!--    <a href="{{ url('Wishlist') }}" class="dropbtn">Whishlist-->
                                        <!--    </a> <span-->
                                        <!--        class="order-list order-list-res wishlist">{{ $wishlist }}</span>-->
                                        <!--</span>-->
                                    </div>
                                @else
                                    <div class="dropdown logoutheader">
                                        <a href="{{ url('user/auth') }}" class="dropbtn">Login
                                        </a>

                                    </div>
                                @endif
                            </li>
                        </ul>

                        {{-- wish list --}}
                        <div class="cart_render">

                            @if (auth()->guard('users')->user() || auth()->guard('guest')->user())
                                @php
                                    $id = auth()->guard('users')->user()->id ?? auth()->guard('guest')->user()->id;
                                    $cart = DB::table('cart_tables')->where('customer_id', $id)->get();

                                @endphp
                                <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                    <span class="icon-1 position-relative">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" style="fill: #121212;transform: ;msFilter:;">
                                            <path
                                                d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z">
                                            </path>
                                        </svg>
                                        <span class="order-list order-list-res cartcount">{{ count($cart) }} </span>
                                    </span>
                                </button>
                            @else
                                @php
                                    $session_cart = Session::get('cart', []);
                                @endphp

                                <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                    <span class="icon-1 position-relative">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                            <path
                                                d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z">
                                            </path>
                                        </svg>
                                        <span
                                            class="order-list order-list-res cartcount">{{ count($session_cart) }}</span>
                                    </span>
                                </button>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </header>

    <div class="topnavnewmega" id="myTopnav">

        @php
            $category = DB::table('categories')
                ->select('title', 'id', 'slug', 'photo')
                ->where('is_parent', 0)
                ->orderBy('headerorder', 'asc')
                ->where('header', 'active')
                ->limit(4)
                ->where('status', 'active')
                ->get();
        @endphp
        <!--<div class="dropdownn megaa">-->
        <!--    <div class="mainnaame">-->
        <!--        <img src="https://taslim.oceansoftwares.in/prrayasha/public/frontend/img/3.png" class="img-fluid menuimg" width="64" height="64" alt="">-->
        <!--        <a href="{{ url('index') }}" class="dropbtnn"> All categories-->
        <!--     </a>-->
        <!--      </div>-->

        <!--    <div class="dropdownn-content mega-menu animate">-->

        <!--      <ul>-->
        <!--      @foreach ($category as $c)
-->
        <!--      <li class="title">-->
        <!--             <a  href="{{ url('product_list') . '/' . $c->slug }}" style="color:black !important;">{{ $c->title }}</a>-->
        <!--     </li>-->
        <!--
@endforeach()-->

    </div>

    <div class="top-section">
        <div class="container-fluid g-0">
            <div class="row">
                <div class="col-md-3 text-center bg1 p-1 text-white">Comfort in Every Move</div>
                <div class="col-md-3 text-center bg2 p-1 text-white">Luxury Made Affordable</div>
                <div class="col-md-3 text-center bg3 p-1 text-white">From TANTEX, For You</div>
                <div class="col-md-3 text-center bg3 p-1 text-white" style="background:#009DE7">Leggings That Fit Your
                    Life</div>
            </div>
        </div>
    </div>
