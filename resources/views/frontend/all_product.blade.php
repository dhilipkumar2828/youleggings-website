@extends('frontend.layouts.arrivals_products_master')

@section('content')
    <main class="main-content">

        <!--== Start Page Header Area Wrapper ==-->

        <section class="page-header-area pt-10 pb-9" data-bg-color="#FFF3DA">

            <div class="container" style="margin-top:100px;">

                <div class="row">

                    <div class="col-md-5">

                        <div class="page-header-st3-content text-center text-md-start">

                            <ol class="breadcrumb justify-content-center justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">New Arrivals</li>

                            </ol>

                            <h2 class="page-header-title">New Arrivals</h2>

                        </div>

                    </div>

                    <div class="col-md-7">

                        <h5 class="showing-pagination-results mt-5 mt-md-9 text-center text-md-end">Showing 06 Results</h5>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->

        <section class="">

            <div class="container">

                <div class="row justify-content-between flex-xl-row-reverse">

                    <div class="padding-top text-center arrivals">

                        <h2 class="title">Newly Arrived</h2>

                        <!-- <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit amet luctus venenatis</p> -->

                    </div>

                    <div class="col-xl-12">

                        <div class="row g-3 g-sm-6">

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-1-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-2-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-3-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-3-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-5-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-half-o"></i>

                                            </div>

                                            <div class="reviews">150 reviews</div>

                                        </div>

                                        <h4 class="title"><a href="product-details.html">Conditioner</a></h4>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-6-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-half-o"></i>

                                            </div>

                                            <div class="reviews">150 reviews</div>

                                        </div>

                                        <h4 class="title"><a href="product-details.html">Serum</a></h4>

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

                            <!-- <div class="col-12">

                                        <ul class="pagination justify-content-center me-auto ms-auto mt-5 mb-10">

                                            <li class="page-item">

                                                <a class="page-link previous" href="product.html" aria-label="Previous">

                                                    <span class="fa fa-chevron-left" aria-hidden="true"></span>

                                                </a>

                                            </li>

                                            <li class="page-item"><a class="page-link" href="product.html">01</a></li>

                                            <li class="page-item"><a class="page-link" href="product.html">02</a></li>

                                            <li class="page-item"><a class="page-link" href="product.html">03</a></li>

                                            <li class="page-item"><a class="page-link" href="product.html">....</a></li>

                                            <li class="page-item">

                                                <a class="page-link next" href="product.html" aria-label="Next">

                                                    <span class="fa fa-chevron-right" aria-hidden="true"></span>

                                                </a>

                                            </li>

                                        </ul>

                                    </div> -->

                        </div>

                    </div>

                    <!-- <div class="col-xl-3">

                                <div class="product-sidebar-widget">

                                    <div class="product-widget-search">

                                        <form action="#">

                                            <input type="search" placeholder="Search Here">

                                            <button type="submit"><i class="fa fa-search"></i></button>

                                        </form>

                                    </div>

                                    <div class="product-widget">

                                        <h4 class="product-widget-title">Price Filter</h4>

                                        <div class="product-widget-range-slider">

                                            <div class="slider-range" id="slider-range"></div>

                                            <div class="slider-labels">

                                                <span id="slider-range-value1"></span>

                                                <span>—</span>

                                                <span id="slider-range-value2"></span>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="product-widget">

                                        <h4 class="product-widget-title">Categoris</h4>

                                        <ul class="product-widget-category">

                                            <li><a href="product.html">

                                                Hair Oil <span>(5)</span></a></li>

                                            <li><a href="product.html">Shampoo <span>(4)</span></a></li>

                                            <li><a href="product.html">Face Wash <span>(2)</span></a></li>

                                            <li><a href="product.html">Face Cream <span>(6)</span></a></li>

                                            <li><a href="product.html">Body Wash <span>(12)</span></a></li>

                                            <li><a href="product.html">Skincare <span>(7)</span></a></li>

                                            <li><a href="product.html">Body Lotion<span>(9)</span></a></li>

                                        </ul>

                                    </div>

                                    <div class="product-widget mb-0">

                                        <h4 class="product-widget-title">Popular Tags</h4>

                                        <ul class="product-widget-tags">

                                            <li><a href="blog.html">Beauty</a></li>

                                            <li><a href="blog.html">MakeupArtist</a></li>

                                            <li><a href="blog.html">Makeup</a></li>

                                            <li><a href="blog.html">Hair</a></li>

                                            <li><a href="blog.html">Nails</a></li>

                                            <li><a href="blog.html">Hairstyle</a></li>

                                            <li><a href="blog.html">Skincare</a></li>

                                        </ul>

                                    </div>

                                </div>

                            </div> -->

                </div>

            </div>

        </section>

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

        <section class="">

            <div class="container">

                <div class="row justify-content-between flex-xl-row-reverse">

                    <div class="padding-top text-center arrivals">

                        <h2 class="title">Skin Care</h2>

                        <!-- <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit amet luctus venenatis</p> -->

                    </div>

                    <div class="col-xl-12">

                        <div class="row g-3 g-sm-6">

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-1-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-2-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-3-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                        </div>

                    </div>

                </div>

                <div class="row justify-content-between flex-xl-row-reverse">

                    <div class="padding-top text-center arrivals">

                        <h2 class="title">Hair Care</h2>

                        <!-- <p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam, purus sit amet luctus venenatis</p> -->

                    </div>

                    <div class="col-xl-12">

                        <div class="row g-3 g-sm-6">

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-3-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-5-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-half-o"></i>

                                            </div>

                                            <div class="reviews">150 reviews</div>

                                        </div>

                                        <h4 class="title"><a href="product-details.html">Conditioner</a></h4>

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

                            <div class="col-6 col-lg-4 col-xl-4 mb-4 mb-sm-8">

                                <!--== Start Product Item ==-->

                                <div class="product-item product-st3-item">

                                    <div class="product-thumb">

                                        <a class="d-block" href="product-details.html">

                                            <img src="{{ asset('frontend/img/shop/product-6-removebg-preview.png') }}"
                                                width="370" height="450" alt="Image-HasTech">

                                        </a>

                                        <span class="flag-new">new</span>

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

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-o"></i>

                                                <i class="fa fa-star-half-o"></i>

                                            </div>

                                            <div class="reviews">150 reviews</div>

                                        </div>

                                        <h4 class="title"><a href="product-details.html">Serum</a></h4>

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

                </div>

            </div>

        </section>

    </main>

    </body>

    </html>
@endsection

@section('script')
@endsection
