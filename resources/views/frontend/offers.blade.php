 @extends('frontend.layouts.master')

 @section('content')
     <div class="wrapper">

         <main class="main-content">

             <!--== Start Hero Area Wrapper ==-->

             <section class="hero-two-slider-area position-relative">

                 <div class="swiper hero-two-slider-container">

                     <div class="swiper-wrapper">

                         <div class="swiper-slide hero-two-slide-item">

                             <div class="container">

                                 <div class="row align-items-center position-relative">

                                     <div class="col-12 col-md-6">

                                         <div class="hero-two-slide-content">

                                             <div class="hero-two-slide-text-img"><img
                                                     src="{{ asset('frontend/img/slider/text-light.webp') }}" width="427"
                                                     height="232" alt="Image"></div>

                                             <h2 class="hero-two-slide-title">50% Offer</h2>

                                             <p class="hero-two-slide-desc">Make Up Made for Skin. Our best-selling Anti

                                                 Aging Cream</p>

                                             <div class="hero-two-slide-meta">

                                                 <a class="btn btn-border-primary" href="products.html">BUY NOW</a>

                                                 <!-- <a class="ht-popup-video" data-fancybox data-type="iframe" href="https://player.vimeo.com/video/172601404?autoplay=1">

                                                        <i class="fa fa-play icon"></i>

                                                        <span>Play Now</span>

                                                    </a> -->

                                             </div>

                                         </div>

                                     </div>

                                     <div class="col-12 col-md-6">

                                         <div class="hero-two-slide-thumb">

                                             <img src="{{ asset('frontend/img/slider/banner4.png') }}" width="690"
                                                 height="690" alt="Image">

                                         </div>

                                     </div>

                                 </div>

                             </div>

                         </div>

                     </div>

                     <!--== Add Pagination ==-->

                     <div class="hero-two-slider-pagination"></div>

                 </div>

             </section>

             <!--== End Hero Area Wrapper ==-->

             <!--== Start Product Category Area Wrapper ==-->

             <section class="section-space pb-0 padd-tb-20">

                 <div class="container">

                     <div class="section-title">

                         <h2 class="title">Deal of the Day</h2>

                     </div>

                     <div class="row g-3 g-sm-6">

                         <div class="col-4 col-lg-4 col-lg-4 col-xl-4 mt-xl-0 mt-sm-4 mt-4">

                             <!--== Start Product Category Item ==-->

                             <a href="#" class="product-category-item offer-deal">

                                 <img class="icon deal-icon" src="{{ asset('frontend/img/shop/category/6.webp') }}"
                                     width="80" height="80" alt="Image-HasTech">

                                 <h3 class="title">New Arrivals</h3>

                                 <span class="flag-new offer-flag">15%</span>

                             </a>

                             <!--== End Product Category Item ==-->

                         </div>

                         <div class="col-4 col-lg-4 col-lg-4 col-xl-4  mt-xl-0 mt-sm-4 mt-4">

                             <!--== Start Product Category Item ==-->

                             <a href="#" class="product-category-item offer-deal" data-bg-color="#FFF3DA">

                                 <img class="icon deal-icon-1" src="{{ asset('frontend/img/shop/category/1.webp') }}"
                                     width="70" height="80" alt="Image-HasTech">

                                 <h3 class="title">Hair care</h3>

                                 <span data-bg-color="#835BF4" class="flag-new offer-flag">15%</span>

                             </a>

                             <!--== End Product Category Item ==-->

                         </div>

                         <div class="col-4 col-lg-4 col-lg-4 col-xl-4 mt-xl-0 mt-sm-4 mt-4">

                             <!--== Start Product Category Item ==-->

                             <a href="#" class="product-category-item offer-deal">

                                 <img class="icon deal-icon" src="{{ asset('frontend/img/shop/category/4.webp') }}"
                                     width="80" height="80" alt="Image-HasTech">

                                 <h3 class="title">Skin care</h3>

                                 <span data-bg-color="#835BF4" class="flag-new offer-flag">10%</span>

                             </a>

                             <!--== End Product Category Item ==-->

                         </div>

                     </div>

                 </div>

             </section>

             <!--== End Product Category Area Wrapper ==-->

             <!--== Start Product Area Wrapper ==-->

             <section class="section-space padd-tb-30">

                 <div class="container">

                     <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">

                         <div class="col-6 col-lg-4 col-xl-3 mb-4 mb-sm-8">

                             <!--== Start Product Item ==-->

                             <div class="product-item product-st3-item">

                                 <div class="product-thumb">

                                     <a class="d-block" href="product-details.html">

                                         <img src="{{ asset('frontend/img/shop/product-1-removebg-preview.png') }}"
                                             width="370" height="450" alt="Image-HasTech">

                                     </a>

                                     <span class="flag-new offer">20%</span>

                                     <div class="product-action">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                             <span>Add to cart</span>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                     </div>

                                 </div>

                                 <div class="product-info">

                                     <div class="product-rating">

                                         <div class="rating">

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star-half-o"></i>

                                         </div>

                                         <div class="reviews">150 reviews</div>

                                     </div>

                                     <h4 class="title"><a href="product-details.html">Body Cream</a></h4>

                                     <div class="prices">

                                         <span class="price">₹210.00</span>

                                         <span class="price-old">300.00</span>

                                     </div>

                                 </div>

                                 <div class="product-action-bottom">

                                     <button type="button" class="product-action-btn action-btn-quick-view"
                                         data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                         <i class="fa fa-expand"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-wishlist"
                                         data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                         <i class="fa fa-heart-o"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-cart"
                                         data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                         <span>Add to cart</span>

                                     </button>

                                 </div>

                             </div>

                             <!--== End prPduct Item ==-->

                         </div>

                         <div class="col-6 col-lg-4 col-xl-3 mb-4 mb-sm-8">

                             <!--== Start Product Item ==-->

                             <div class="product-item product-st3-item">

                                 <div class="product-thumb">

                                     <a class="d-block" href="product-details.html">

                                         <img src="{{ asset('frontend/img/shop/product-2-removebg-preview.png') }}"
                                             width="370" height="450" alt="Image-HasTech">

                                     </a>

                                     <span class="flag-new">20%</span>

                                     <div class="product-action">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal-1">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal-1">

                                             <span>Add to cart</span>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal-1">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                     </div>

                                 </div>

                                 <div class="product-info">

                                     <div class="product-rating">

                                         <div class="rating">

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star-half-o"></i>

                                         </div>

                                         <div class="reviews">150 reviews</div>

                                     </div>

                                     <h4 class="title"><a href="product-details.html">Face Wash</a></h4>

                                     <div class="prices">

                                         <span class="price">₹210.00</span>

                                         <span class="price-old">300.00</span>

                                     </div>

                                 </div>

                                 <div class="product-action-bottom">

                                     <button type="button" class="product-action-btn action-btn-quick-view"
                                         data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                         <i class="fa fa-expand"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-wishlist"
                                         data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                         <i class="fa fa-heart-o"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-cart"
                                         data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                         <span>Add to cart</span>

                                     </button>

                                 </div>

                             </div>

                             <!--== End prPduct Item ==-->

                         </div>

                         <div class="col-6 col-lg-4 col-xl-3 mb-4 mb-sm-8">

                             <!--== Start Product Item ==-->

                             <div class="product-item product-st3-item">

                                 <div class="product-thumb">

                                     <a class="d-block" href="product-details.html">

                                         <img src="{{ asset('frontend/img/shop/product-3-removebg-preview.png') }}"
                                             width="370" height="450" alt="Image-HasTech">

                                     </a>

                                     <span class="flag-new">20%</span>

                                     <div class="product-action">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal-2">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal-2">

                                             <span>Add to cart</span>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal-2">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                     </div>

                                 </div>

                                 <div class="product-info">

                                     <div class="product-rating">

                                         <div class="rating">

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star-half-o"></i>

                                         </div>

                                         <div class="reviews">150 reviews</div>

                                     </div>

                                     <h4 class="title"><a href="product-details.html">Foaming Face Wash</a></h4>

                                     <div class="prices">

                                         <span class="price">₹210.00</span>

                                         <span class="price-old">300.00</span>

                                     </div>

                                 </div>

                                 <div class="product-action-bottom">

                                     <button type="button" class="product-action-btn action-btn-quick-view"
                                         data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                         <i class="fa fa-expand"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-wishlist"
                                         data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                         <i class="fa fa-heart-o"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-cart"
                                         data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                         <span>Add to cart</span>

                                     </button>

                                 </div>

                             </div>

                             <!--== End prPduct Item ==-->

                         </div>

                         <div class="col-6 col-lg-4 col-xl-3 mb-4 mb-sm-8">

                             <!--== Start Product Item ==-->

                             <div class="product-item product-st3-item">

                                 <div class="product-thumb">

                                     <a class="d-block" href="product-details.html">

                                         <img src="{{ asset('frontend/img/shop/sunscreen.png') }}" width="370"
                                             height="450" alt="Image-HasTech">

                                     </a>

                                     <span class="flag-new">10%</span>

                                     <div class="product-action">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal-3">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal-3">

                                             <span>Add to cart</span>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal-3">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                     </div>

                                 </div>

                                 <div class="product-info">

                                     <div class="product-rating">

                                         <div class="rating">

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star"></i>

                                             <i class="fa fa-star-half-o"></i>

                                         </div>

                                         <div class="reviews">150 reviews</div>

                                     </div>

                                     <h4 class="title"><a href="product-details.html">Sun Screen</a></h4>

                                     <div class="prices">

                                         <span class="price">₹210.00</span>

                                         <span class="price-old">300.00</span>

                                     </div>

                                 </div>

                                 <div class="product-action-bottom">

                                     <button type="button" class="product-action-btn action-btn-quick-view"
                                         data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                         <i class="fa fa-expand"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-wishlist"
                                         data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                         <i class="fa fa-heart-o"></i>

                                     </button>

                                     <button type="button" class="product-action-btn action-btn-cart"
                                         data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                         <span>Add to cart</span>

                                     </button>

                                 </div>

                             </div>

                             <!--== End prPduct Item ==-->

                         </div>

                     </div>

                 </div>

             </section>

             <!--== End Product Area Wrapper ==-->

             <!--== Start Product Area Wrapper ==-->

             <!--== End Product Area Wrapper ==-->

             <!--== Start Product Banner Area Wrapper ==-->

             <section>

                 <div class="container">

                     <!--== Start Product Category Item ==-->

                     <a href="product.html" class="product-banner-item">

                         <img src="{{ asset('frontend/img/shop/banner/7.webp') }}" width="1170" height="240"
                             alt="Image-HasTech">

                     </a>

                     <!--== End Product Category Item ==-->

                 </div>

             </section>

             <!--== End Product Banner Area Wrapper ==-->

             <!--== Start Brand Logo Area Wrapper ==-->

             <div class="section-space padd-tb-30">

                 <div class="container">

                     <div class="row">

                         <div class="col-12">

                             <div class="section-title">

                                 <h2 class="title">Top Offers</h2>

                             </div>

                         </div>

                     </div>

                 </div>

                 <div class="container-fluid">

                     <div class="swiper brand-logo-slider-container">

                         <div class="swiper-wrapper">

                             <div class="swiper-slide brand-logo-item">

                                 <!--== Start Brand Logo Item ==-->

                                 <div class="product-item product-st3-item offers-slide">

                                     <div class="product-thumb">

                                         <a class="d-block" href="product-details.html">

                                             <img src="{{ asset('frontend/img/shop/product-1-removebg-preview.png') }}"
                                                 width="370" height="450" alt="Image-HasTech">

                                         </a>

                                         <span class="flag-new offer">20%</span>

                                         <div class="product-action">

                                             <button type="button" class="product-action-btn action-btn-quick-view"
                                                 data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                                 <i class="fa fa-expand"></i>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-cart"
                                                 data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                                 <span>Add to cart</span>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-wishlist"
                                                 data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                                 <i class="fa fa-heart-o"></i>

                                             </button>

                                         </div>

                                     </div>

                                     <div class="product-info">

                                         <div class="product-rating">

                                             <div class="rating">

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star-half-o"></i>

                                             </div>

                                             <div class="reviews">150 reviews</div>

                                         </div>

                                         <h4 class="title"><a href="product-details.html">Body Cream</a></h4>

                                         <div class="prices">

                                             <span class="price">₹210.00</span>

                                             <span class="price-old">300.00</span>

                                         </div>

                                     </div>

                                     <div class="product-action-bottom">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                             <span>Add to cart</span>

                                         </button>

                                     </div>

                                 </div>

                                 <!--== End Brand Logo Item ==-->

                             </div>

                             <div class="swiper-slide brand-logo-item">

                                 <!--== Start Brand Logo Item ==-->

                                 <div class="product-item product-st3-item offers-slide">

                                     <div class="product-thumb">

                                         <a class="d-block" href="product-details.html">

                                             <img src="{{ asset('frontend/img/shop/product-2-removebg-preview.png') }}"
                                                 width="370" height="450" alt="Image-HasTech">

                                         </a>

                                         <span class="flag-new">20%</span>

                                         <div class="product-action">

                                             <button type="button" class="product-action-btn action-btn-quick-view"
                                                 data-bs-toggle="modal" data-bs-target="#action-QuickViewModal-1">

                                                 <i class="fa fa-expand"></i>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-cart"
                                                 data-bs-toggle="modal" data-bs-target="#action-CartAddModal-1">

                                                 <span>Add to cart</span>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-wishlist"
                                                 data-bs-toggle="modal" data-bs-target="#action-WishlistModal-1">

                                                 <i class="fa fa-heart-o"></i>

                                             </button>

                                         </div>

                                     </div>

                                     <div class="product-info">

                                         <div class="product-rating">

                                             <div class="rating">

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star-half-o"></i>

                                             </div>

                                             <div class="reviews">150 reviews</div>

                                         </div>

                                         <h4 class="title"><a href="product-details.html">Face Wash</a></h4>

                                         <div class="prices">

                                             <span class="price">₹210.00</span>

                                             <span class="price-old">300.00</span>

                                         </div>

                                     </div>

                                     <div class="product-action-bottom">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                             <span>Add to cart</span>

                                         </button>

                                     </div>

                                 </div>

                                 <!--== End Brand Logo Item ==-->

                             </div>

                             <div class="swiper-slide brand-logo-item">

                                 <!--== Start Brand Logo Item ==-->

                                 <div class="product-item product-st3-item offers-slide">

                                     <div class="product-thumb">

                                         <a class="d-block" href="product-details.html">

                                             <img src="{{ asset('frontend/img/shop/product-3-removebg-preview.png') }}"
                                                 width="370" height="450" alt="Image-HasTech">

                                         </a>

                                         <span class="flag-new">20%</span>

                                         <div class="product-action">

                                             <button type="button" class="product-action-btn action-btn-quick-view"
                                                 data-bs-toggle="modal" data-bs-target="#action-QuickViewModal-2">

                                                 <i class="fa fa-expand"></i>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-cart"
                                                 data-bs-toggle="modal" data-bs-target="#action-CartAddModal-2">

                                                 <span>Add to cart</span>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-wishlist"
                                                 data-bs-toggle="modal" data-bs-target="#action-WishlistModal-2">

                                                 <i class="fa fa-heart-o"></i>

                                             </button>

                                         </div>

                                     </div>

                                     <div class="product-info">

                                         <div class="product-rating">

                                             <div class="rating">

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star-half-o"></i>

                                             </div>

                                             <div class="reviews">150 reviews</div>

                                         </div>

                                         <h4 class="title"><a href="product-details.html">Foaming Face Wash</a></h4>

                                         <div class="prices">

                                             <span class="price">₹210.00</span>

                                             <span class="price-old">300.00</span>

                                         </div>

                                     </div>

                                     <div class="product-action-bottom">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                             <span>Add to cart</span>

                                         </button>

                                     </div>

                                 </div>

                                 <!--== End Brand Logo Item ==-->

                             </div>

                             <div class="swiper-slide brand-logo-item">

                                 <!--== Start Brand Logo Item ==-->

                                 <div class="product-item product-st3-item offers-slide">

                                     <div class="product-thumb">

                                         <a class="d-block" href="product-details.html">

                                             <img src="{{ asset('frontend/img/shop/sunscreen.png') }}" width="370"
                                                 height="450" alt="Image-HasTech">

                                         </a>

                                         <span class="flag-new">10%</span>

                                         <div class="product-action">

                                             <button type="button" class="product-action-btn action-btn-quick-view"
                                                 data-bs-toggle="modal" data-bs-target="#action-QuickViewModal-3">

                                                 <i class="fa fa-expand"></i>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-cart"
                                                 data-bs-toggle="modal" data-bs-target="#action-CartAddModal-3">

                                                 <span>Add to cart</span>

                                             </button>

                                             <button type="button" class="product-action-btn action-btn-wishlist"
                                                 data-bs-toggle="modal" data-bs-target="#action-WishlistModal-3">

                                                 <i class="fa fa-heart-o"></i>

                                             </button>

                                         </div>

                                     </div>

                                     <div class="product-info">

                                         <div class="product-rating">

                                             <div class="rating">

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star"></i>

                                                 <i class="fa fa-star-half-o"></i>

                                             </div>

                                             <div class="reviews">150 reviews</div>

                                         </div>

                                         <h4 class="title"><a href="product-details.html">Sun Screen</a></h4>

                                         <div class="prices">

                                             <span class="price">₹210.00</span>

                                             <span class="price-old">300.00</span>

                                         </div>

                                     </div>

                                     <div class="product-action-bottom">

                                         <button type="button" class="product-action-btn action-btn-quick-view"
                                             data-bs-toggle="modal" data-bs-target="#action-QuickViewModal">

                                             <i class="fa fa-expand"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-wishlist"
                                             data-bs-toggle="modal" data-bs-target="#action-WishlistModal">

                                             <i class="fa fa-heart-o"></i>

                                         </button>

                                         <button type="button" class="product-action-btn action-btn-cart"
                                             data-bs-toggle="modal" data-bs-target="#action-CartAddModal">

                                             <span>Add to cart</span>

                                         </button>

                                     </div>

                                 </div>

                                 <!--== End Brand Logo Item ==-->

                             </div>

                         </div>

                         <div class="swiper-button-next"></div>

                         <div class="swiper-button-prev"></div>

                     </div>

                 </div>

             </div>

             <section class="section-space pt-0">

                 <div class="container">

                     <div class="newsletter-content-wrap" data-bg-img="assets/images/photos/bg1.webp">

                         <div class="newsletter-content">

                             <div class="section-title mb-0">

                                 <h2 class="title">Join with us</h2>

                                 <!-- <p>A leader in luxury beauty and skincare.</p> -->

                             </div>

                         </div>

                         <div class="newsletter-form">

                             <form>

                                 <input type="email" class="form-control" placeholder="enter your email">

                                 <button class="btn-submit" type="submit"><i class="fa fa-paper-plane"></i></button>

                             </form>

                         </div>

                     </div>

                 </div>

             </section>

             <!--== End News Letter Area Wrapper ==-->

         </main>
     @endsection
