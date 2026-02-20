    @extends('frontend.layouts.arrivals_products_master_new')

    @section('content')
        <main class="main-content">

            <?php

        $flatoffers = DB::table('coupon')
            ->where('offer_details', 1)
            ->where('status', 'active')
            ->first();

        if(!empty($flatoffers)){
        ?>
            <!--  <div class="offer mob">-->
            <!--  <div class="offer-text">FLAT ₹{{ $flatoffers->flatofferamount }} OFF </div>-->
            <!--  <p>Flat ₹{{ $flatoffers->flatofferamount }} Off on Orders above ₹{{ $flatoffers->offeramountabove }}\-</p>-->
            <!--  <div class="offer-code" onclick="copyToClipboard('250OFF')">Use Code: <span>{{ $flatoffers->coupon_code }}</span>-->
            <!--  </div>-->
            <!--</div>-->
            <div class="offer mob">
                <p>FLAT ₹{{ $flatoffers->flatofferamount }} OFF / Flat ₹{{ $flatoffers->flatofferamount }} Off on Orders
                    above ₹{{ $flatoffers->offeramountabove }}\</p>
                <p> Use Code: {{ $flatoffers->coupon_code }} </p>

            </div>

            <?php } ?>
            <!--== End Hero Area Wrapper ==-->

            <?php
        $flatoffers = DB::table('coupon')
            ->where('offer_details', 1)
            ->where('status', 'active')
            ->first();

        if(!empty($flatoffers)){
        ?>
            <div class="offer web">
                <div class="offer-text">FLAT ₹{{ $flatoffers->flatofferamount }} OFF </div>
                <p>Flat ₹{{ $flatoffers->flatofferamount }} Off on Orders above ₹{{ $flatoffers->offeramountabove }}\-</p>
                <div class="offer-code" onclick="copyToClipboard('250OFF')">Use Code:
                    <span>{{ $flatoffers->coupon_code }}</span>
                </div>
            </div>
            <?php } ?>

            <section class="hero-two-slider-area position-relative d-none d-md-block">
                <!-- First section visible only on web view -->
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach ($banners as $i => $b)
                            <button type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide-to="{{ $i }}"
                                class="@if ($i == 0) active @endif" aria-current="true"
                                aria-label="Slide {{ $i }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner">
                        @foreach ($banners as $i => $b)
                            @if ($b->link != '0')
                                <a href="product_list/{{ $b->link }}"
                                    class="carousel-item @if ($i == 0) active @endif">
                                    <img src="{{ asset($b->photo) }}" alt="" class="w-100">
                                </a>
                            @else
                                <div class="carousel-item @if ($i == 0) active @endif">
                                    <img src="{{ asset($b->photo) }}" alt="" class="w-100">
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="prev">

                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                        <span class="visually-hidden">Previous</span>

                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide="next">

                        <span class="carousel-control-next-icon" aria-hidden="true"></span>

                        <span class="visually-hidden">Next</span>

                    </button> --}}

                </div>
            </section>

            <section class="browse-list-section mt-5 pt-5 pb-0 mb-5">
                <div class="container">
                    <div class="row mb-5">
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

                                    <div class="category-item">
                                        <a href="{{ url('product_list') . '/' . $c->slug }}">
                                            <img src="{{ $c->photo }}" class="img-fluid" alt="">

                                            <div class="mt-4 d-flex cateinfo">
                                                <h5 class="title fontsiz mt-0 mb-0">{{ $c->title }}</h5>

                                                <img class="arroww flex1" src="{{ asset('frontend/img/arrow.png') }}"
                                                    alt="Logo" />

                                            </div>

                                        </a>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                </div>
            </section>

            <section class="browse-list-section mt-5 pt-5 pb-0 mb-5">
                <div class="container">
                    @if (!empty($advertisement->photo))
                        <div class="row">

                            <div class="col-md-12">

                                <div class="banner-box-footer">

                                    <img src="{{ !empty($advertisement->photo) ? $advertisement->photo : '' }}"
                                        alt="{{ $advertisement->photo }}" style="margin: 1px; border-radius: 22px;">

                                </div>

                            </div>

                        </div>
                    @endif
                </div>
            </section>

            <section class="top-product-list-section webview mb-5">
                @php
                    // Fetching active products with stock available
                    $productCategories = DB::table('products as p')
                        ->leftjoin('product_variants as v', 'v.product_id', '=', 'p.id')
                        ->where('p.status', '=', 'active')
                        ->where('p.deleted_at', '=', null)
                        ->where('v.in_stock', '>', '0')
                        ->where('p.tag', '=', 'NA')
                        ->orderBy('p.id', 'desc')
                        ->select('p.*')
                        ->groupBy('p.id')
                        ->limit(8)
                        ->get();
                @endphp

                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-title text-left"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <h3 class="title fontsiz mt-5 mb-3">All Products<span class="headingline"></span></h3>
                                {{-- <a class="see-btn" href="{{ url('/newarrival_list') }}">
                                   See All Items
                                </a> --}}
                            </div>
                        </div>
                    </div>

                    <div class="row newarrivall">
                        <div id="owl-five-product" class="owl-carousel owl-theme">
                            @foreach ($productCategories as $product)
                                @php
                                    $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                                        ->where('status', 'active')
                                        ->first();

                                    $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                                        ->where('status', 'active')
                                        ->where('in_stock', '>', '0')
                                        ->first();

                                    if (empty($newsizevariant1)) {
                                        $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                                            ->where('status', 'active')
                                            ->first();
                                    }

                                    $price = '';
                                    $discount = '';
                                    if ($newsizevariant1) {
                                        if ($product->discount_type == 'fixed') {
                                            $price = $newsizevariant1->regular_price - $product->discount;
                                            $discount = '';
                                        } else {
                                            if ($newsizevariant1->regular_price != 0) {
                                                $ADiscountpercent =
                                                    ($newsizevariant1->regular_price / 100) * $product->discount;
                                                $price = $newsizevariant1->regular_price - $ADiscountpercent;
                                                $discount = '%';
                                            } else {
                                                $price = $newsizevariant1->regular_price;
                                            }
                                        }
                                    }

                                    $variants_array = \App\Models\ProductVariant::where('product_id', $product->id)
                                        ->where('status', 'active')
                                        ->get();
                                @endphp

                                @if (!empty($variant->photo))
                                    <div class="item">
                                        <div class="product-card">
                                            <div class="custom-product-image">
                                                @php
                                                    // Extract first photo
                                                    $photos = explode(',', $variant->photo);
                                                    $firstPhoto = trim($photos[0]);
                                                @endphp

                                                <a href="{{ url('products/' . $product->slug) }}">
                                                    <img src="{{ $firstPhoto }}" alt="{{ $product->name }}">
                                                </a>

                                            </div>
                                            <div class="product-info mt-3">
                                                <h5 class="product-name">{{ $product->name }}</h5>
                                                <div class="price-info">
                                                    @if ($product->discount > 0)
                                                        <div class="product-price">
                                                            <div class="discounted-price">
                                                                <span><i
                                                                        class="fa">&#xf156;</i>{{ $price }}</span>
                                                            </div>
                                                            <div class="original-price">
                                                                <span><i
                                                                        class="fa">&#xf156;</i>{{ $newsizevariant1->regular_price }}</span>
                                                            </div>
                                                            {{-- <div class="product-discount">
                                                                <p>{{ $product->discount }}{{ $discount }} Off</p>
                                                            </div> --}}
                                                        </div>
                                                    @else
                                                        <p class="product-price singleprice"><i
                                                                class="fa">&#xf156;</i>{{ $newsizevariant1->regular_price }}
                                                        </p>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="browse-list-section mobenifit my-5 pt-2 pb-5">
                <div class="container">

                    <div class="row">
                        <div class="col-12">
                            <div class="custom-title text-left">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="benefitrow p-5 h-100">

                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h3 class="title fontsiz text-white">What Makes You Leggings
                                            Different <span class="headingline"></span></h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <h5>Classic <br>
                                            Leggings</h5>
                                        <p>Everyday essentials with unmatched comfort</p>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>Ankle-Length <br>
                                            Leggings</h5>
                                        <p>Sleek and stylish for modern looks.
                                        </p>
                                    </div>

                                    <div class="col-md-4">
                                        <h5>Printed <br>
                                            Leggings</h5>
                                        <p>Add a touch of fun and
                                            flair</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Churidar <br>
                                            Leggings</h5>
                                        <p>Traditional style with a contemporary twist.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Jeggings <br>
                                            Leggings</h5>
                                        <p>The perfect fusion of jeans and leggings.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Capri <br>
                                            Leggings</h5>
                                        <p>Chic and breathable for casual days.</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <img class="different-img" src="{{ asset('frontend/img/leggings-different.jpg') }}" />
                        </div>
                    </div>

                </div>
            </section>

            <div class="parallax-section parallax1 mb-5 pb-5">

                <section id="testimonials">

                    <div class="container">

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="testimonial-heading">
                                    <span>Testimonial</span>
                                    <h3 class="title fontsiz">What our customers say</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="testimonial-box-container">
                                    <div id="owl-two" class="owl-carousel owl-theme">

                                        @foreach ($allreviews as $reviews)
                                            <!--BOX-1-------------->
                                            <div class="item">
                                                <div class="testimonial-box">

                                                    <img class="quoteimg" src="{{ asset('frontend/img/quote.svg') }}" />

                                                    <div class="box-top">
                                                        <!--profile----->
                                                        <div class="profile">
                                                            <div class="name-user">
                                                                <h6>{{ $reviews->name }}</h6>
                                                                <span class="d-block">Happy Client</span>
                                                            </div>
                                                        </div>
                                                        <!--reviews------>
                                                        <div class="reviews">
                                                            {!! str_repeat('<span><i class="fa fa-star"></i></span>', $reviews->rate) !!}
                                                            {!! str_repeat('<span><i class="fa fa-star-o"></i></span>', 5 - $reviews->rate) !!}

                                                        </div>
                                                    </div>
                                                    <!--Comments---------------------------------------->
                                                    <div class="client-comment">
                                                        <p>

                                                            {{ $reviews->feedback }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!--BOX-3-------------->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </section>

            </div>

            <!--== Start Product Area Wrapper ==-->

        </main>

        </div>

        <script src='https://unpkg.com/swiper@6.5.4/swiper-bundle.min.js'></script>
        <script>
            function openTab(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }

            document.getElementById("defaultOpen").click();
        </script>
        <script>
            $(document).ready(function() {
                $("#owl-five").owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 500,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        576: {
                            items: 1
                        },
                        768: {
                            items: 1
                        },
                        992: {
                            items: 2
                        }
                    }
                });
            });
        </script>
        <script>
            $('.category-button').on('click', function() {
                const categoryId = $(this).data('category-id');
                $('.category-button').removeClass('highlight');
                $(this).addClass('highlight');
                localStorage.setItem('lastCategoryId', categoryId);
                fetchSubcategories(categoryId);
            });

            $(document).ready(function() {
                const lastCategoryId = localStorage.getItem('lastCategoryId');
                if (lastCategoryId) {
                    fetchSubcategories(lastCategoryId);
                    $('.category-button').each(function() {
                        if ($(this).data('category-id') == lastCategoryId) {
                            $(this).addClass('highlight');
                        }
                    });
                }
            });

            function fetchSubcategories(categoryId) {
                $.ajax({
                    url: "{{ url('fetch-subcategories') }}/" + categoryId,
                    method: 'GET',
                    success: function(data) {
                        $('#category_name').text(data.category.title);
                        $('#subcategory-list').empty();
                        if (data.sub_category.length > 0) {
                            let subcategoryRow = $('<div class="subcategory-row"></div>');
                            data.sub_category.forEach(function(sub, index) {
                                const subcategoryItem = $(`
                        <div class="subcategory-item">
                            <a href="{{ url('product_list') }}/${sub.slug}" class="text-center d-block mb-4">
                                <img src="${sub.photo}" class="img-fluid menuimg" width="150" height="150" alt="${sub.title}">
                                <h5 class="title fontsiz mt-0 mb-0">${sub.title}</h5>
                            </a>
                        </div>
                    `);

                                subcategoryRow.append(subcategoryItem);

                                if ((index + 1) % 4 === 0) {
                                    $('#subcategory-list').append(subcategoryRow);
                                    subcategoryRow = $('<div class="subcategory-row"></div>');
                                }
                            });
                            if (subcategoryRow.children().length > 0) {
                                $('#subcategory-list').append(subcategoryRow);
                            }
                        } else {
                            $('#subcategory-list').append('<p>No subcategories available.</p>');
                        }
                    },
                    error: function() {
                        alert('Error fetching subcategories.');
                    }
                });
            }
        </script>
    @endsection
