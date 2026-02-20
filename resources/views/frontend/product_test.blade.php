@extends('frontend.layouts.arrivals_products_master_new')

@section('content')

    <style>
        .price-show {

            display: none;

        }

        section.browse-list-section.mobviewsecone {
            display: none;
        }

        @media (max-width: 767px) {
            section.browse-list-section.mobviewsecone {
                display: block;
            }

            .topnavnewmega {
                display: none;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
        integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <main class="main-content ">

        <!--== Start Page Header Area Wrapper ==-->

        <section class="browse-list-section mobviewsecone">
            <!-- category list custom -->

            <div class="container">

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">
                    <div id="owl-one" class="owl-carousel owl-theme">

                        @php
                            $category = DB::table('categories')
                                ->select('title', 'id', 'slug', 'photo')
                                ->where('is_parent', 0)
                                ->orderBy('headerorder', 'asc')
                                ->where('header', 'active')
                                ->where('status', 'active')
                                ->get();
                        @endphp

                        @foreach ($category as $c)
                            <div class="item">

                                <div class="category-item text-center">
                                    <a href="{{ url('product_list') . '/' . $c->slug }}" style="color:black !important;">
                                        <img src="{{ $c->photo }}" class="img-fluid menuimg" width="64"
                                            height="64" alt="">
                                        <h5 class="title fontsiz mt-0 mb-0">{{ $c->title }}</h5>

                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="page-header-area">

            <div class="container">

                <div class="row">

                    <div class="col-md-6">

                        <div class="page-header-st3-content">

                            <h2 class="page-header-title">{{ isset($categories) ? $categories->title : 'All Products' }}
                            </h2>

                        </div>

                    </div>

                    <div class="col-md-6 justify-content-end d-flex">

                        <div class="page-header-st3-content">

                            <ol class="breadcrumb justify-content-center justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">Products</li>

                                <li class="breadcrumb-item active text-dark" aria-current="page">
                                    {{ isset($categories) ? $categories->title : 'All Products' }}</li>

                            </ol>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->

        <section class="section-space ">

            <div class="container ">

                <div class="row justify-content-between flex-xl-row-reverse">

                    <div class="col-xl-9">
                        <button class="mobile-product-filter-btn" type="button"><i class="fa fa-filter"></i></button>

                        <input type="hidden" id="slug" name="slug" value="{{ isset($slug) ? $slug : '' }}">

                        <!--<div class="row mb-5">-->

                        <!--<div class="col-6">-->

                        <!-- <span>

    Showing 1 – 18 of 100

    </span> -->

                        <!--</div>-->

                        <!--<div class="col-6  d-flex justify-content-end">-->

                        <!--<div class="box bx-width">-->

                        <!--<select>-->

                        <!--  <option value="1">Sort by Price: Low to High</option>-->

                        <!--  <option value="2">Sort by Latest</option>-->

                        <!--  <option value="3">Sort by Price: High to Low</option>-->

                        <!--</select>-->

                        <!--</div>-->

                        <!--                </div>-->

                        <!--</div>-->

                        <!--@if (count($products) > 0)
    -->
                        <!--    <script>
                            -- >
                            <
                            !--
                            let products = @json($products); // Converts PHP array/collection to JSON-->
                            <
                            !--console.log(products); // Prints entire array to console-->

                            <
                            !-- // Optional: Loop through each product in JS-->
                            <
                            !--products.forEach((product, index) => {
                                -- >
                                <
                                !--console.log(`Product ${index + 1}:`, product);
                                -- >
                                <
                                !--
                            });
                            -- >
                            <
                            !--
                        </script>-->
                        <!--
    @endif-->

                        <span class="filtered_products">

                            @include('frontend.product_list_test')

                        </span>

                    </div>

                    <div class="col-xl-3 mobile-product-filter">

                        <div class="product-sidebar-widget ">
                            <button class="mobile-product-filter-btn-close" type="submit"><i
                                    class="fa fa-close"></i></button>

                            <!--<div class="product-widget-search ">-->

                            <!--<form action="#">-->

                            <!--    <input type="search" placeholder="Search Here">-->

                            <!--    <button type="submit"><i class="fa fa-search"></i></button>-->

                            <!--</form>-->

                            <!--</div>-->

                            <div class="product-widget">

                                <h4 class="product-widget-title">Price Filter</h4>

                                <input type="hidden" id="highest_price" value="{{ $highest_rate }}">

                                <div class="product-widget-range-slider">

                                    <div class="slider-range" id="slider-range"></div>

                                    <div class="slider-labels">

                                        <span id="slider-range-value1"></span>

                                        <span>—</span>

                                        <span id="slider-range-value2"></span>

                                    </div>

                                </div>

                            </div>

                            @if (!isset($slug))
                                <div class="product-widget">

                                    <h4 class="product-widget-title">Categories</h4>

                                    @foreach ($prod_categories as $c)
                                        <ul class="product-widget-category">

                                            <!-- <li><a href="{{ url('product_list') }}">{{ $c->title }} <span>(</span></a></li> -->

                                            <li><input type="checkbox" name="cat[]" class="cat form-check-input"
                                                    value="{{ $c->id }}">&nbsp {{ $c->title }} <span></li>

                                        </ul>
                                    @endforeach

                                </div>
                            @endif

                            <div class="product-widget ">

                                <h4 class="product-widget-title">Sort</h4>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="discount" name="discount"
                                        value="1">

                                    <label class="form-check-label" for="check1">Discount</label>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="checkprice" name="price_sort"
                                        value="1">

                                    <label class="form-check-label" for="check2">Price</label>

                                </div>

                                <div class="price-show">

                                    <input type="radio" class="form-check-input" id="radio-1" name="price_sort"
                                        value="high-to-low">

                                    <label class="form-check-label">High to Low</label>

                                </div>

                                <div class="price-show">

                                    <input type="radio" class="form-check-input" id="radio-2" name="price_sort"
                                        value="low-to-high">

                                    <label class="form-check-label">Low to High</label>

                                </div>

                            </div>

                            <div class="product-widget ">

                                <h4 class="product-widget-title">Availability</h4>

                                <div class="form-check">

                                    <input type="radio" class="form-check-input" id="in_stock" name="in_stock"
                                        value="1">

                                    <label class="form-check-label" for="check1">In Stock </label>

                                </div>

                                <div class="form-check">

                                    <input type="radio" class="form-check-input" id="in_stock" name="in_stock"
                                        value="2">

                                    <label class="form-check-label" for="check2">Out of Stock </label>

                                </div>

                            </div>

                            <div class="product-widget ">

                                <h4 class="product-widget-title">Size</h4>
                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="XS">

                                    <label class="form-check-label" for="check1">XS</label>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="S">

                                    <label class="form-check-label" for="check1">S</label>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="M">

                                    <label class="form-check-label" for="check1">M</label>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="L">

                                    <label class="form-check-label" for="check2">L</label>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="XL">

                                    <label class="form-check-label" for="check2">XL</label>

                                </div>

                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="2XL">

                                    <label class="form-check-label" for="check2">2XL</label>

                                </div>
                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="3XL">

                                    <label class="form-check-label" for="check2">3XL</label>

                                </div>
                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="4XL">

                                    <label class="form-check-label" for="check2">4XL</label>

                                </div>
                                <div class="form-check">

                                    <input type="checkbox" class="form-check-input" id="size" name="size"
                                        value="5XL">

                                    <label class="form-check-label" for="check2">5XL</label>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Product Area Wrapper ==-->

        <!--== Start Product Banner Area Wrapper ==-->

        <section class="d-none">

            <div class="container">

                <!--== Start Product Category Item ==-->

                <a href="{{ url('product_list') }}" class="product-banner-item">

                    <img src="{{ asset('frontend/img/shop/banner/7.webp') }}" width="1170" height="240"
                        alt="Image-HasTech">

                </a>

                <!--== End Product Category Item ==-->

            </div>

        </section>

        <!--== End Product Banner Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->

        <!--== End Product Area Wrapper ==-->

    </main>

@endsection

@section('script')
@endsection
