 <!-- Wrapper Start -->

 <style>
     .has-popup .popup {
         display: none;
         position: absolute;
         left: 0;
         top: 100%;
         background-color: #b00;
         padding: 10px;
         box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
         z-index: 10;
         width: 200px;
         /* Adjust the width as needed */
         border: 1px solid #ccc;
     }

     .has-popup:hover .popup {
         display: block;
     }

     .popup p {
         margin: 0;
         padding: 0;
     }

     .wishlist {
         position: absolute;
         right: 0px;
         top: 8px;
         background: #d91c53;
         width: 15px;
         height: 15px;
         display: flex;
         align-items: center;
         justify-content: center;
         border-radius: 50%;
         font-size: 12px;
         color: #fff;
     }

     body.modal-open {
         overflow: auto;
         position: fixed;
     }
 </style>
 <style>
     /* Basic styling for the menu */
     .main-nav {
         list-style-type: none;
         padding: 0;
         margin: 0;
         display: flex;
         justify-content: center;
     }

     .main-nav li {
         position: relative;
     }

     .main-nav a {
         display: block;
         padding: 8px 12px;
         text-decoration: none;
         color: #333;
         background-color: #bb0000;
     }

     .main-nav a:hover {
         background-color: #ddd;
     }

     .popup {
         display: none;
         /* Hide popups by default */
         position: absolute;
         top: 100%;
         left: 0;
         background-color: #bb0000;
         box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
         padding: 10px;
     }

     .has-popup:hover .popup {
         display: block;
         /* Show popup on hover */
     }

     .popup ul {
         list-style-type: none;
         padding: 0;
         margin: 0;
     }

     .popup ul ul {
         display: none;
         /* Hide nested lists by default */
         position: absolute;
         top: 0;
         right: 100%;
         width: 150px;
         border-right: 1px solid #111;
         border-bottom: 1px solid #111;
     }

     .popup ul li {
         position: relative;
     }

     .popup ul li:hover>ul {
         display: block;
         /* Show nested lists on hover */
         background: #fff;
     }

     .popup a {
         padding: 8px 12px;

         color: #333;
         text-decoration: none;
         display: block;
     }

     .popup a:hover {
         background-color: #ddd;
     }
 </style>
 <div class="wrapper">

     <!--	<div class="top-header">
 <div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 d-none d-lg-block">
            <ul class="header-contact-info">
                <li>Call: <a href="tel:+919191000100">+91 91910 00100</a></li>

            </ul>
        </div>

        <div class="col-lg-6 col-md-12">
            <ul class="header-top-menu">

            <li>
                @if (Auth::guard('users')->user())
<a class="header-action-btn" href="

                {{ url('customer/my_account') }}">

                    <span class="icon position-relative">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"></path></svg> My Account

                    </span>

                </a>
@else
<a class="header-action-btn" href="

                {{ url('user/auth') }}">

                    <span class="icon position-relative">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(255, 255, 255, 1);transform: ;msFilter:;"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"></path></svg> Login/Register
                    </span>

                </a>
@endif
                <li>

                    <div class="rendered_headerwish">

                    @include('frontend.header_wishlist')

                    </div>

                    {{-- end wishlist --}}
                </li>

                </ul>

                <ul class="header-top-others-option">
                    <div class="option-item">
                        <div class="search-btn-box">
                            <i class="search-btn bx bx-search-alt"></i>
                        </div>
                    </div>

                </ul>
            </div>
        </div>
    </div>
</div> -->

     <!--== Start Header Wrapper ==-->

     <header class="header-area sticky-header header_top">

         <div class="container">

             <div class="row align-items-center web-view-none">
                 <div class="col col-md-4 text-center">
                     <div class="header-logo ml-10">
                         <a href="{{ url('index') }}">
                             <!-- <img class="logo-main" src="{{ asset('frontend/img/Prrayasha/logo.png') }}"
                                 alt="Logo" style="width: 70px; height: 70px;" />  -->
                             <span>P</span>RRAYASHA <span>C</span>OLLECTIONS
                         </a>
                     </div>
                 </div>
                 <div class="col col-md-4">
                     <form action="{{ url('search') }}" method="post" id="search-form">
                         @csrf

                         @php
                             $product_name = session('product_name', '');
                         @endphp
                         <div class="aside-search-form position-relative mb-0 mobile-view-none">

                             <label for="SearchInput" class="visually-hidden">Search</label>
                             <input id="SearchInput" type="text" name="product_name"
                                 class="form-control mb-0 search-text-box" placeholder="Search entire store…"
                                 value="{{ $product_name }}">
                             <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                         </div>
                     </form>
                 </div>
                 <script>
                     if (window.location.search.indexOf('product_name') !== -1) {
                         history.replaceState(null, '', '/'); // Replace the URL with the home page
                     }
                     // Clear the input field after form submission
                     if (window.location.search.indexOf('product_name') === -1) {
                         document.getElementById('SearchInput').value = ''; // Clear the input if the product_name is not in the URL
                     }
                 </script>
                 <div class="col col-md-4">
                     <div class="header-action justify-content-end">

                         <ul class="m-0">
                             <li>
                                 @if (Auth::guard('users')->user() || Auth::guard('guest')->user())
                                     <div class="dropdown logoutheader">
                                         <a href="{{ url('customer/my_account') }}" class="dropbtn"><svg
                                                 xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                 viewBox="0 0 24 24" style="fill:#333 ;transform: ;msFilter:;">
                                                 <path
                                                     d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                                                 </path>
                                             </svg> <span class="mobile-view-none"> </span></a>

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
                                         <span class="icon-1 position-relative">
                                             <a href="{{ url('Wishlist') }}" class="dropbtn"><svg viewBox="0 0 24 24"
                                                     width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                                                     <path
                                                         d="m7.234 3.004c-2.652 0-5.234 1.829-5.234 5.177 0 3.725 4.345 7.727 9.303 12.54.194.189.446.283.697.283s.503-.094.697-.283c4.977-4.831 9.303-8.814 9.303-12.54 0-3.353-2.58-5.168-5.229-5.168-1.836 0-3.646.866-4.771 2.554-1.13-1.696-2.935-2.563-4.766-2.563zm0 1.5c1.99.001 3.202 1.353 4.155 2.7.14.198.368.316.611.317.243 0 .471-.117.612-.314.955-1.339 2.19-2.694 4.159-2.694 1.796 0 3.729 1.148 3.729 3.668 0 2.671-2.881 5.673-8.5 11.127-5.454-5.285-8.5-8.389-8.5-11.127 0-1.125.389-2.069 1.124-2.727.673-.604 1.625-.95 2.61-.95z"
                                                         fill-rule="nonzero" />
                                                 </svg>
                                             </a> <span
                                                 class="order-list order-list-res wishlist">{{ $wishlist }}</span>
                                         </span>

                                         <!--     <div class="dropdown-content">
                                         <a href="{{ url('customer/my_account') }}"> My Account</a>
                                         <a href="{{ url('Wishlist') }}"> Wishlist</a>
                                         <a href="{{ url('user/logout') }}"> Logout</a>
                                     </div>-->
                                     </div>
                                 @else
                                     <div class="dropdown logoutheader">
                                         <a href="{{ url('user/auth') }}" class="dropbtn"><svg
                                                 xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                 viewBox="0 0 24 24" style="fill: #333;transform: ;msFilter:;">
                                                 <path
                                                     d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                                                 </path>
                                             </svg>
                                             <span class="mobile-view-none"> </span>
                                         </a>

                                         <!--    <div class="dropdown-content">
                                         <a href="{{ url('user/auth') }}">Login / Register</a>
                                         <a href="{{ url('Wishlist') }}">Wishlist</a>
                                         <a href="{{ url('cart') }}">Cart</a>
                                     </div> -->

                                         <a href="{{ url('Wishlist') }}" class="dropbtn"><svg viewBox="0 0 24 24"
                                                 width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                                                 <path
                                                     d="m7.234 3.004c-2.652 0-5.234 1.829-5.234 5.177 0 3.725 4.345 7.727 9.303 12.54.194.189.446.283.697.283s.503-.094.697-.283c4.977-4.831 9.303-8.814 9.303-12.54 0-3.353-2.58-5.168-5.229-5.168-1.836 0-3.646.866-4.771 2.554-1.13-1.696-2.935-2.563-4.766-2.563zm0 1.5c1.99.001 3.202 1.353 4.155 2.7.14.198.368.316.611.317.243 0 .471-.117.612-.314.955-1.339 2.19-2.694 4.159-2.694 1.796 0 3.729 1.148 3.729 3.668 0 2.671-2.881 5.673-8.5 11.127-5.454-5.285-8.5-8.389-8.5-11.127 0-1.125.389-2.069 1.124-2.727.673-.604 1.625-.95 2.61-.95z"
                                                     fill-rule="nonzero" />
                                             </svg>
                                         </a>

                                     </div>

                                     <!-- <a class="header-action-btn" href="{{ url('user/auth') }}">
                            <span class="icon position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill:  #000;transform: ;msFilter:;"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"></path></svg> <span class="mobile-view-none">Login/Register</span>
                            </span>
                        </a> -->
                                 @endif
                             </li>
                         </ul>

                         {{-- wish list --}}
                         <div class="cart_render">

                             @if (auth()->guard('users')->user() && session()->has('cart') && count(session('cart')) > 0)
                                 @php
                                     $id = auth()->guard('users')->user()->id;
                                     $cart = DB::table('cart_tables')
                                         ->Join(
                                             'product_variants',
                                             'product_variants.id',
                                             'cart_tables.product_varient',
                                         )
                                         ->where('customer_id', $id)
                                         ->count();

                                 @endphp
                                 <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                     data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                     <span class="icon-1 position-relative">

                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                             <path
                                                 d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z">
                                             </path>
                                         </svg>
                                         <span class="order-list order-list-res cartcount">{{ $cart }} </span>
                                     </span>
                                 </button>
                             @elseif(!auth()->guard('users')->check() && session()->has('cart') && count(session('cart')) > 0)
                                 @php
                                     $session_cart = Session::get('cart', []);
                                 @endphp

                                 <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                     data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                     <span class="icon-1 position-relative">

                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                             <path
                                                 d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z">
                                             </path>
                                         </svg>
                                         <span
                                             class="order-list order-list-res cartcount">{{ count($session_cart) }}</span>
                                     </span>
                                 </button>
                             @else
                                 <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                     data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                     <span class="icon-1 position-relative">

                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                             <path
                                                 d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z">
                                             </path>
                                         </svg>
                                         <span class="order-list order-list-res cartcount">0</span>
                                     </span>
                                 </button>
                             @endif

                         </div>

                         &nbsp;&nbsp;
                         <a href="javascript:;" data-toggle="modal" data-target="#trackModal" class="dropbtn">
                             <i class="fa fa-truck fa-2x" aria-hidden="true"></i>
                         </a>

                         <div class="modal fade" id="trackModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel">Track Your Orders with AWB
                                         </h5>
                                         <button type="button" class="close" data-dismiss="modal"
                                             aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                         </button>
                                     </div>
                                     <div class="modal-body">
                                         <a href="https://stcourier.com/track/shipment" target="_blank"
                                             class="btn btn-warning"><span>Within Tamilnadu &
                                                 Pondicherry</span></a><br><br>
                                         <a href="https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx"
                                             target="_blank" class="btn btn-success  btn-sm">Other Locations</a>
                                     </div>

                                 </div>
                             </div>
                         </div>

                         <div class="hamburgerm d-none d-lg-block"><svg xmlns="http://www.w3.org/2000/svg"
                                 width="30" height="30" viewBox="0 0 24 24"
                                 style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                 <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path>
                             </svg></div>
                         <button class="header-menu-btn" t} @inype="button" data-bs-toggle="offcanvas"
                             data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">
                             <span></span>
                             <span></span>
                             <span></span>
                         </button>
                     </div>
                 </div>
             </div>

             <div class="row align-items-center mob-view">

                 <div class="col col-md-8 mob-heade-logo-part">

                     <ul class="nav-mobile">

                         <li class="menu-container">
                             <input id="menu-toggle" type="checkbox">
                             <label for="menu-toggle" class="menu-button">
                                 <svg class="icon-open" viewBox="0 0 24 24">
                                     <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                                 </svg>
                                 <svg class="icon-close" viewBox="0 0 100 100">
                                     <path
                                         d="M83.288 88.13c-2.114 2.112-5.575 2.112-7.69 0L53.66 66.188c-2.113-2.112-5.572-2.112-7.686 0l-21.72 21.72c-2.114 2.113-5.572 2.113-7.687 0l-4.693-4.692c-2.114-2.114-2.114-5.573 0-7.688l21.72-21.72c2.112-2.115 2.112-5.574 0-7.687L11.87 24.4c-2.114-2.113-2.114-5.57 0-7.686l4.842-4.842c2.113-2.114 5.57-2.114 7.686 0l21.72 21.72c2.114 2.113 5.572 2.113 7.688 0l21.72-21.72c2.115-2.114 5.574-2.114 7.688 0l4.695 4.695c2.112 2.113 2.112 5.57-.002 7.686l-21.72 21.72c-2.112 2.114-2.112 5.573 0 7.686L88.13 75.6c2.112 2.11 2.112 5.572 0 7.687l-4.842 4.84z" />
                                 </svg>
                             </label>

                             <ul class="menu-sidebar">
                                 @php
                                     $category = DB::table('categories')
                                         ->select('title', 'id', 'slug')
                                         ->where('is_parent', 0)
                                         ->orderBy('headerorder', 'asc')
                                         ->where('header', 'active')
                                         ->limit(9)
                                         ->where('status', 'active')
                                         ->get();
                                 @endphp
                                 @foreach ($category as $c)
                                     @php
                                         $subcategory = DB::table('categories')
                                             ->where('is_parent', 1)
                                             ->where('parent_id', $c->id)
                                             ->where('header', 'active')
                                             ->get();
                                     @endphp

                                     @if ($subcategory->count() > 0)
                                         <li>

                                             <input type="checkbox" id="sub-one-{{ $c->id }}"
                                                 class="submenu-toggle" style="display: none;">

                                             <label class="submenu-label" for="sub-one-{{ $c->id }}">
                                                 {{ $c->title }}
                                                 <div class="arrow right"><a
                                                         href="{{ url('product_list') . '/' . $c->slug }}">
                                                         &#8250;</a></div>
                                             </label>

                                             <ul class="menu-sub">
                                                 <li class="menu-sub-title">
                                                     <label class="submenu-label"
                                                         for="sub-one-{{ $c->id }}">Back</label>
                                                     <div class="arrow left">&#8249;</div>
                                                 </li>

                                                 @foreach ($subcategory as $sub)
                                                     @php
                                                         $child_subcategory = DB::table('categories')
                                                             ->where('is_parent', 1)
                                                             ->where('parent_id', $sub->id)

                                                             ->get();
                                                     @endphp

                                                     @if ($child_subcategory->count() > 0)
                                                         <li>
                                                             <input type="checkbox" id="sub-two-{{ $sub->id }}"
                                                                 class="submenu-toggle">

                                                             <label class="submenu-label"
                                                                 for="sub-two-{{ $sub->id }}">
                                                                 {{ $sub->title }}
                                                                 <div class="arrow right"><a
                                                                         href="{{ url('product_list') . '/' . $sub->slug }}">&#8250;</a>
                                                                 </div>
                                                             </label>
                                                             <ul class="menu-sub">
                                                                 <li class="menu-sub-title">
                                                                     <label class="submenu-label"
                                                                         for="sub-two-{{ $sub->id }}">Back</label>
                                                                     <div class="arrow left">&#8249;</div>
                                                                 </li>
                                                                 @foreach ($child_subcategory as $cs)
                                                                     <li><a
                                                                             href="{{ url('product_list') . '/' . $cs->slug }}">{{ $cs->title }}</a>
                                                                     </li>
                                                                 @endforeach
                                                             </ul>
                                                         </li>
                                                     @else
                                                         <li><a
                                                                 href="{{ url('product_list') . '/' . $sub->slug }}">{{ $sub->title }}</a>
                                                         </li>
                                                     @endif
                                                 @endforeach
                                             </ul>
                                         </li>
                                     @else
                                         <li><a href="{{ url('product_list') . '/' . $c->slug }}">{{ $c->title }}</a>
                                         </li>
                                     @endif
                                 @endforeach
                             </ul>

                             <div class="header-logo ">
                                 <a href="{{ url('index') }}" class="font-4 mt-0">
                                     <!-- <img class="logo-main" src="{{ asset('frontend/img/Prrayasha/logo.png') }}"
                                 alt="Logo" style="width: 70px; height: 70px;" />  -->
                                     <span>P</span>RRAYASHA <span>C</span>OLLECTIONS
                                 </a>
                             </div>
                 </div>

                 <div class="col col-md-4">
                     <div class="header-action justify-content-end">

                         <ul class="m-0">
                             <li>
                                 @if (Auth::guard('users')->user())
                                     <div class="dropdown logoutheader">
                                         <a href="{{ url('customer/my_account') }}" class="dropbtn"><svg
                                                 xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                 viewBox="0 0 24 24" style="fill: #000;transform: ;msFilter:;">
                                                 <path
                                                     d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                                                 </path>
                                             </svg> <span class="mobile-view-none"> </span></a>

                                         @php
                                             $id = auth()->guard('users')->user()->id;
                                             $wishlist = DB::table('wishlists')->where('customer_id', $id)->count();
                                             //$wishlist=DB::table('wishlists')->where('customer_id',$id)->get()->count;
                                         @endphp
                                         <span class="icon-1 position-relative">
                                             <a href="{{ url('Wishlist') }}" class="dropbtn"><svg
                                                     viewBox="0 0 24 24" width="22" height="22"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                     <path
                                                         d="m7.234 3.004c-2.652 0-5.234 1.829-5.234 5.177 0 3.725 4.345 7.727 9.303 12.54.194.189.446.283.697.283s.503-.094.697-.283c4.977-4.831 9.303-8.814 9.303-12.54 0-3.353-2.58-5.168-5.229-5.168-1.836 0-3.646.866-4.771 2.554-1.13-1.696-2.935-2.563-4.766-2.563zm0 1.5c1.99.001 3.202 1.353 4.155 2.7.14.198.368.316.611.317.243 0 .471-.117.612-.314.955-1.339 2.19-2.694 4.159-2.694 1.796 0 3.729 1.148 3.729 3.668 0 2.671-2.881 5.673-8.5 11.127-5.454-5.285-8.5-8.389-8.5-11.127 0-1.125.389-2.069 1.124-2.727.673-.604 1.625-.95 2.61-.95z"
                                                         fill-rule="nonzero" />
                                                 </svg>
                                             </a> <span
                                                 class="order-list order-list-res wishlist">{{ $wishlist }}</span>
                                         </span>

                                         <a href="javascript:;" data-toggle="modal" data-target="#trackModal3"
                                             class="dropbtn">
                                             <i class="fa fa-truck fa-2x" aria-hidden="true"></i>
                                         </a>
                                         <div class="modal fade" id="trackModal3" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h5 class="modal-title" id="exampleModalLabel">Track Your
                                                             Orders with AWB</h5>
                                                         <button type="button" class="close" data-dismiss="modal"
                                                             aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                     <div class="modal-body">
                                                         <a href="https://stcourier.com/track/shipment"
                                                             target="_blank" class="btn btn-warning "><span>Within
                                                                 Tamilnadu & Pondicherry<span></a><br><br>
                                                         <a href="https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx"
                                                             target="_blank"
                                                             class="btn btn-success w-100 btn-sm">Other Locations</a>

                                                     </div>

                                                 </div>
                                             </div>
                                         </div>

                                         <!--     <div class="dropdown-content">
                                         <a href="{{ url('customer/my_account') }}"> My Account</a>
                                         <a href="{{ url('Wishlist') }}"> Wishlist</a>
                                         <a href="{{ url('user/logout') }}"> Logout</a>
                                     </div>-->
                                     </div>
                                 @else
                                     <div class="dropdown logoutheader">
                                         <a href="{{ url('user/auth') }}" class="dropbtn"><svg
                                                 xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                 viewBox="0 0 24 24" style="fill: #000;transform: ;msFilter:;">
                                                 <path
                                                     d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z">
                                                 </path>
                                             </svg>
                                             <span class="mobile-view-none"> </span>
                                         </a>

                                         <!--    <div class="dropdown-content">
                                         <a href="{{ url('user/auth') }}">Login / Register</a>
                                         <a href="{{ url('Wishlist') }}">Wishlist</a>
                                         <a href="{{ url('cart') }}">Cart</a>
                                     </div> -->

                                         <a href="{{ url('Wishlist') }}" class="dropbtn"><svg viewBox="0 0 24 24"
                                                 width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                                                 <path
                                                     d="m7.234 3.004c-2.652 0-5.234 1.829-5.234 5.177 0 3.725 4.345 7.727 9.303 12.54.194.189.446.283.697.283s.503-.094.697-.283c4.977-4.831 9.303-8.814 9.303-12.54 0-3.353-2.58-5.168-5.229-5.168-1.836 0-3.646.866-4.771 2.554-1.13-1.696-2.935-2.563-4.766-2.563zm0 1.5c1.99.001 3.202 1.353 4.155 2.7.14.198.368.316.611.317.243 0 .471-.117.612-.314.955-1.339 2.19-2.694 4.159-2.694 1.796 0 3.729 1.148 3.729 3.668 0 2.671-2.881 5.673-8.5 11.127-5.454-5.285-8.5-8.389-8.5-11.127 0-1.125.389-2.069 1.124-2.727.673-.604 1.625-.95 2.61-.95z"
                                                     fill-rule="nonzero" />
                                             </svg>
                                         </a>

                                     </div>

                                     <!-- <a class="header-action-btn" href="{{ url('user/auth') }}">
                            <span class="icon position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill:  #000;transform: ;msFilter:;"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"></path></svg> <span class="mobile-view-none">Login/Register</span>
                            </span>
                        </a> -->
                                 @endif
                             </li>
                         </ul>

                         {{-- wish list --}}
                         <div class="cart_render">

                             @if (auth()->guard('users')->user())
                                 @php
                                     $id = auth()->guard('users')->user()->id;
                                     $cart = DB::table('cart_tables')
                                         ->Join(
                                             'product_variants',
                                             'product_variants.id',
                                             'cart_tables.product_varient',
                                         )
                                         ->where('customer_id', $id)
                                         ->count();

                                 @endphp
                                 <button class="header-action-btn" type="button" data-bs-toggle="offcanvas"
                                     data-bs-target="#AsideOffcanvasCart" aria-controls="AsideOffcanvasCart">
                                     <span class="icon-1 position-relative">

                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                             <path
                                                 d="M5 22h14c1.103 0 2-.897 2-2V9a1 1 0 0 0-1-1h-3V7c0-2.757-2.243-5-5-5S7 4.243 7 7v1H4a1 1 0 0 0-1 1v11c0 1.103.897 2 2 2zM9 7c0-1.654 1.346-3 3-3s3 1.346 3 3v1H9V7zm-4 3h2v2h2v-2h6v2h2v-2h2l.002 10H5V10z">
                                             </path>
                                         </svg>
                                         <span class="order-list order-list-res cartcount">{{ $cart }} </span>
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
                                             viewBox="0 0 24 24"
                                             style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
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

                         &nbsp;&nbsp;

                     </div>
                 </div>
             </div>

         </div>
     </header>

     <div class="mob-search-area">
         <div class="container">
             <div class="row">
                 <div class="col col-md-12 my-2 search-box-mob">
                     <form action="{{ url('search') }}" method="post">

                         @csrf
                         <div class="aside-search-form position-relative mb-0 mobile-view-only">
                             <label for="SearchInput" class="visually-hidden">Search</label>
                             <input id="SearchInput" type="text" name="product_name" class="form-control mb-0"
                                 placeholder="Search entire store…">
                             <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>

     <div class="nav-main custom-nav">
         @php
             $category = DB::table('categories')
                 ->select('title', 'id', 'slug')
                 ->where('is_parent', 0)
                 ->orderBy('headerorder', 'asc')
                 ->where('header', 'active')
                 ->limit(9)
                 ->where('status', 'active')
                 ->get();
         @endphp
         <div class="container">
             <div class="row align-items-center">
                 <div class="col-lg-12 d-none d-lg-block">
                     <div class="header-navigation ">
                         <ul class="main-nav justify-content-center">
                             <li class="has-popup">
                                 <a href="{{ url('index') }}">All categories</a>
                                 <div class="popup">
                                     <ul>
                                         @foreach ($category as $c)
                                             <li class="has-popup">
                                                 <a href="{{ url('product_list') . '/' . $c->slug }}"
                                                     style="color:black !important;">{{ $c->title }}</a>
                                             </li>
                                         @endforeach()
                                     </ul>
                                 </div>
                             </li>
                             @foreach ($category as $c)
                                 <li class="has-popup">
                                     <a href="{{ url('product_list') . '/' . $c->slug }}">{{ $c->title }}</a>
                                     @php
                                         $products = DB::table('products')
                                             ->where('status', 'active')
                                             ->where('header', 'active')
                                             ->get();
                                         $subcategory = DB::table('categories')
                                             ->where('is_parent', 1)
                                             ->where('parent_id', $c->id)
                                             ->where('header', 'active')
                                             ->where('status', 'active')
                                             ->get();
                                         $subacategorycount = $subcategory->count();
                                     @endphp
                                     @if ($subacategorycount > 0)
                                         <div class="popup">
                                             <ul class="subcategroryy-menu">

                                                 @foreach ($subcategory as $sub)
                                                     <li><a class="sub-sub-menu"
                                                             href="{{ url('product_list') . '/' . $sub->slug }}">{{ $sub->title }}</a>
                                                         @php
                                                             $child_subcategory = DB::table('categories')
                                                                 ->where('is_parent', 1)
                                                                 ->where('sub_cate_id', $sub->id)
                                                                 ->get();
                                                             $child_subcategorycount = $child_subcategory->count();
                                                         @endphp

                                                         @if ($child_subcategorycount > 0)
                                                             <ul class="subcategroryy-sub-menu">
                                                                 @foreach ($child_subcategory as $cs)
                                                                     <li><a class="sub-sub-menu"
                                                                             href="{{ url('product_list') . '/' . $cs->slug }}">{{ $cs->title }}</a>
                                                                     </li>
                                                                 @endforeach
                                                             </ul>
                                                         @endif
                                                     </li>
                                                 @endforeach

                                             </ul>
                                         </div>
                                     @endif
                                 </li>
                             @endforeach
                         </ul>

                         <!----

                         <ul class="main-nav justify-content-center">

                             <li class="has-submenu"><a href="{{ url('index') }}">All categories</a></li>

                             @foreach ($category as $c)
<li class="has-submenu  position-static"><a
                                     href="{{ url('product_list') . '/' . $c->slug }}">{{ $c->title }}</a>
                                 @php
                                     $products = DB::table('products')
                                         ->where('status', 'active')
                                         ->where('header', 'active')
                                         ->get();
                                     $subcategory = DB::table('categories')
                                         ->where('is_parent', '!=', 0)
                                         ->where('parent_id', $c->id)
                                         ->where('header', 'active')
                                         ->get();

                                 @endphp
                                 @if (count($subcategory) > 0)
<div class="submenu-nav">
                                     <div class="row w-100 p-2">
                                         @foreach ($subcategory as $sub)
@php
    $child_subcategory = DB::table('categories')
        ->where('is_parent', '!=', 0)
        ->where('parent_id', $sub->id)
        ->where('header', 'active')
        ->get();
@endphp

                                         <div class="col-md-12 menunewdesign ">
                                             <a class="sub-sub-menu"
                                                 href="{{ url('product_list') . '/' . $sub->slug }}">{{ $sub->title }} <svg
                                                     version="1.0" xmlns="http://www.w3.org/2000/svg" width="15"
                                                     height="15" viewBox="0 0 512.000000 512.000000"
                                                     preserveAspectRatio="xMidYMid meet">

                                                     <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                         fill="#d91c53" stroke="none">
                                                         <path d="M2315 5109 c-800 -83 -1501 -518 -1927 -1196 -604 -961 -490 -2237
                        274 -3068 425 -462 951 -737 1583 -827 119 -17 512 -16 635 1 622 86 1148 360
                        1572 820 349 378 572 861 650 1406 17 118 17 512 0 630 -59 416 -191 769 -410
                        1099 -92 140 -185 254 -315 385 -399 404 -893 653 -1462 737 -123 18 -478 26
                        -600 13z m-80 -1468 c52 -32 1119 -971 1139 -1002 24 -39 24 -119 0 -158 -20
                        -31 -1087 -970 -1139 -1002 -41 -25 -120 -25 -162 1 -82 50 -102 170 -40 239
                        12 13 230 205 485 428 254 223 462 409 462 413 0 4 -210 192 -467 417 -258
                        226 -475 419 -485 429 -40 47 -42 131 -3 191 40 61 147 83 210 44z" />
                                                     </g>
                                                 </svg></a>
                                             <ul>
                                                 @foreach ($child_subcategory as $c)
<li> <div class="popup">

                                       <p>
                                           <a
                                     href="#">rrr</a>
                                 </p>

                                    </div>
                                                 </li>
@endforeach
                                             </ul>
                                         </div>
@endforeach
                                     </div>
                                 </div>
@endif
                             </li>
@endforeach
                          </ul>
                            ---->
                     </div>

                 </div>
             </div>
         </div>
     </div>

     <!--End Sticky Icon-->

     <div class="icon-bar">
         <a href="https://www.facebook.com/people/Prrayasha-Collections/61554943980619/" class="facebook"
             target="_blank"><i class="fa fa-facebook"></i></a>
         <a href="#" class="whatsapp"><i class="fa fa-whatsapp"></i></a>
         <a href="https://www.instagram.com/prrayashacollections/" class="instagram"><i
                 class="fa fa-instagram"></i></a>
         <a href="https://www.youtube.com/@prrayashacollections" class="youtube"><i class="fa fa-youtube"></i></a>
     </div>

     <div class="adminActions">
         <input type="checkbox" name="adminToggle" class="adminToggle" />
         <a class="adminButton" href="#!"><i class="fa fa-share"></i></a>
         <div class="adminButtons">
             <a href="https://www.facebook.com/people/Prrayasha-Collections/61554943980619/" title="facebook"
                 class="facebook"><i class="fa fa-facebook"></i></a>
             <a href="#" title="whatsapp" class="whatsapp"><i class="fa fa-whatsapp"></i></a>
             <a href="https://www.instagram.com/prrayashacollections/" title="instagram" class="instagram"><i
                     class="fa fa-instagram"></i></a>
             <a href="https://www.youtube.com/@prrayashacollections" title="youtube" class="youtube"><i
                     class="fa fa-youtube"></i></a>
         </div>
     </div>
     <!--== End Header Wrapper ==-->
