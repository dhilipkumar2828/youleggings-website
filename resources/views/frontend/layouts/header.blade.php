   <!--== Wrapper Start ==-->

   <div class="wrapper">

       <!--== Start Header Wrapper ==-->

       <header class="header-area sticky-header header-transparent header_top">

           <div class="container">

               <div class="row align-items-center">

                   <div class="col-5 col-lg-2 col-xl-2">

                       <div class="header-logo">

                           <button class="header-menu-btn" type="button" data-bs-toggle="offcanvas"
                               data-bs-target="#AsideOffcanvasMenu" aria-controls="AsideOffcanvasMenu">

                               <span></span>

                               <span></span>

                               <span></span>

                           </button>

                           <a href="{{ url('index') }}">

                               <img class="logo-main" src="{{ asset('frontend/img/logo.png') }}"width="150"
                                   height="100" alt="Logo" />

                           </a>

                       </div>

                   </div>

                   @php

                       $category = DB::table('categories')->select('title', 'id')->where('status', 'active')->get();

                   @endphp

                   <div class="col-lg-7 col-xl-6 d-none d-lg-block">

                       <div class="header-navigation ps-7">

                           <ul class="main-nav justify-content-start">

                               <li class="has-submenu"><a href="{{ url('index') }}">home</a>

                               </li>

                               <li class="has-submenu"><a href="{{ url('aboutus') }}">About</a>

                               </li>

                               {{-- <li class="has-submenu"><a href="">Products</a>

                                </li> --}}

                               <!-- <li><a href="#">about</a></li> -->

                               <li class="has-submenu"><a href="{{ url('whatisnew') }}">New Arrivals</a></li>

                               <li class="has-submenu position-static"><a href="{{ url('product_list') }}">Products</a>

                                   <ul class="submenu-nav-mega">

                                       @foreach ($category as $c)
                                           @php

                                               $products = DB::table('products')
                                                   ->where('category', $c->id)
                                                   ->where('status', 'active')
                                                   ->get();

                                           @endphp

                                           <li><a href="{{ url('product_list') }}"
                                                   class="mega-title">{{ $c->title }}</a>

                                               @foreach ($products as $p)
                                                   <ul>

                                                       <li><a
                                                               href="{{ url('products') . '/' . $p->slug }}">{{ $p->name }}</a>
                                                       </li>

                                                   </ul>
                                               @endforeach

                                           </li>
                                       @endforeach

                                       <li><a href="#/" class="mega-title">Body Care</a>

                                           <ul>

                                               <li><a href="products.html">Body Wash</a></li>

                                               <li><a href="products.html">Body Gel</a></li>

                                               <li><a href="products.html">Body Scrub</a></li>

                                               <li><a href="products.html">Gel Wash</a></li>

                                           </ul>

                                       </li>

                                   </ul>

                               </li>

                               <!-- <li><a href="#">Contact</a></li> -->

                           </ul>

                       </div>

                   </div>

                   <div class="col-7 col-lg-3 col-xl-4">

                       <div class="header-action justify-content-end">

                           <button class="header-action-btn ms-0" type="button" data-bs-toggle="offcanvas"
                               data-bs-target="#AsideOffcanvasSearch" aria-controls="AsideOffcanvasSearch">

                               <span class="icon">

                                   <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                       xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

                                       <rect class="icon-rect" width="30" height="30" fill="url(#pattern1)" />

                                       <defs>

                                           <pattern id="pattern1" patternContentUnits="objectBoundingBox"
                                               width="1" height="1">

                                               <use xlink:href="#image0_504:11" transform="scale(0.0333333)" />

                                           </pattern>

                                           <image id="image0_504:11" width="30" height="30"
                                               xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAABiUlEQVRIie2Wu04CQRSGP0G2EUtIbHwA8B3EQisLIcorEInx8hbEZ9DKy6toDI1oAgalNFpDoYWuxZzJjoTbmSXERP7kZDbZ859vdmb27MJcf0gBUAaugRbQk2gBV3IvmDa0BLwA4Zh4BorTACaAU6fwPXAI5IAliTxwBDScvJp4vWWhH0BlTLEEsC+5Fu6lkgNdV/gKDnxHCw2I9rSiNQNV8baBlMZYJtpTn71KAg9SY3dUYn9xezLPgG8P8BdwLteq5X7CzDbnAbXKS42WxtQVUzoGeFlqdEclxXrnhmhhkqR+8KuMqzHA1vumAddl3IwB3pLxVmOyr1NjwKQmURJ4lBp7GmOAafghpg1qdSDeDrCoNReJWmZB4dsAPsW7rYVa1Rx4FbOEw5TEPKmFvgMZX3DCgYeYNniMaQ5piTXghGhPLdTmZ33hYNpem98f/UHRwSxvhqhXx4anMA3/EmhiOlJPJnSBOb3uQcpOE65VhujPpAms/Bu4u+x3swRbeB24mTV4LgB+AFuLedkPkcmmAAAAAElFTkSuQmCC" />

                                       </defs>

                                   </svg>

                               </span>

                           </button>

                           {{-- end wishlist --}}

                           <div class="cart_render">

                               {{-- cart list --}}

                               @include('frontend.header_cartlist')

                           </div>

                           {{-- end cartlist --}}

                           @if (Auth::guard('customer')->check())
                               <a class="header-action-btn"
                                   href="

                           {{ url('customer/my_account') }}">

                                   <span class="icon my_account">

                                       <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                           xmlns="http://www.w3.org/2000/svg"
                                           xmlns:xlink="http://www.w3.org/1999/xlink">

                                           <rect class="icon-rect" width="30" height="30"
                                               fill="url(#pattern3)" />

                                           <defs>

                                               <pattern id="pattern3" patternContentUnits="objectBoundingBox"
                                                   width="1" height="1">

                                                   <use xlink:href="#image0_504:10" transform="scale(0.0333333)" />

                                               </pattern>

                                               <image id="image0_504:10" width="30" height="30"
                                                   xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAABEUlEQVRIie3UMUoDYRDF8Z8psqUpLBRrBS+gx7ATD6E5iSjeQQ/gJUzEwmChnZZaKZiQ0ljsLkhQM5/5Agr74DX7DfOfgZ1Hoz+qAl30Marcx2H1thCtY4DJN76parKqmAH9DM+6eTcArX2QE3yVAO7lBA8TwMNIw6UgeJI46My+rWCjUQL0LVIUBd8lgEO1UfBZAvg8oXamCuWNRu64nRNMmUo/wReSXLXayoDoKc9miMvqW/ZNG2VRNLla2MYudrCFTvX2intlnl/gGu/zDraGYzyLZ/UTjrD6G2AHpxgnAKc9xgmWo9BNPM4BnPYDNiLg24zQ2oNpyFdZvRKZLlGhnvvKPzXXti/Yy7hEo3+iD9EHtgdqxQnwAAAAAElFTkSuQmCC" />

                                           </defs>

                                       </svg>

                                   </span>

                               </a>
                           @else
                               <a class="header-action-btn" href="

                           {{ url('user/auth') }}">

                                   <span class="icon">

                                       <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                           xmlns="http://www.w3.org/2000/svg"
                                           xmlns:xlink="http://www.w3.org/1999/xlink">

                                           <rect class="icon-rect" width="30" height="30"
                                               fill="url(#pattern3)" />

                                           <defs>

                                               <pattern id="pattern3" patternContentUnits="objectBoundingBox"
                                                   width="1" height="1">

                                                   <use xlink:href="#image0_504:10" transform="scale(0.0333333)" />

                                               </pattern>

                                               <image id="image0_504:10" width="30" height="30"
                                                   xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAABmJLR0QA/wD/AP+gvaeTAAABEUlEQVRIie3UMUoDYRDF8Z8psqUpLBRrBS+gx7ATD6E5iSjeQQ/gJUzEwmChnZZaKZiQ0ljsLkhQM5/5Agr74DX7DfOfgZ1Hoz+qAl30Marcx2H1thCtY4DJN76parKqmAH9DM+6eTcArX2QE3yVAO7lBA8TwMNIw6UgeJI46My+rWCjUQL0LVIUBd8lgEO1UfBZAvg8oXamCuWNRu64nRNMmUo/wReSXLXayoDoKc9miMvqW/ZNG2VRNLla2MYudrCFTvX2intlnl/gGu/zDraGYzyLZ/UTjrD6G2AHpxgnAKc9xgmWo9BNPM4BnPYDNiLg24zQ2oNpyFdZvRKZLlGhnvvKPzXXti/Yy7hEo3+iD9EHtgdqxQnwAAAAAElFTkSuQmCC" />

                                           </defs>

                                       </svg>

                                   </span>

                               </a>
                           @endif

                       </div>

                   </div>

               </div>

           </div>

   </div>

   </header>
