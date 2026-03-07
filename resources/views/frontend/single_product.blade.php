@extends('frontend.layouts.arrivals_products_master_new')

@section('content')

    <main class="main-content ">

        <section class="page-header-area mb-5">

            <div class="container">

                <div class="row">

                    <div class="col-md-6">

                        <div class="page-header-st3-content">

                            <h2 class="page-header-title">Product Detail</h2>

                        </div>

                    </div>

                    <div class="col-md-6 justify-content-end d-flex">

                        <div class="page-header-st3-content">

                            <ol class="breadcrumb justify-content-md-start">

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('index') }}">Home</a></li>

                                {{-- <li class="breadcrumb-item"><a class="text-dark" href="{{url('whatisnew')}}">Product</a>

                            </li> --}}

                                <li class="breadcrumb-item active text-dark" aria-current="page">Product Detail</li>

                            </ol>

                        </div>

                    </div>

                    <!-- <div class="col-md-7">

                    <h5 class="showing-pagination-results mt-5 mt-md-9 text-center text-md-end">Showing Single Product</h5>

                </div> -->

                </div>

            </div>

        </section>

        <!--== End Page Header Area Wrapper ==-->

        <!--== Start Product Details Area Wrapper ==-->

        @php$reviewval = DB::table('product_reviews')
                ->where('status', 'accept')
                ->where('product_id', $product->id)
                ->get();

            $re_val = 0;

            foreach ($reviewval as $r) {
                $re_val += $r->rate;
            }

            $variant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                ->where('status', 'active')
                ->where('in_stock', '!=', '0')
                ->get();

            if (count($variant1) == 0) {
                $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                    ->where('status', 'active')
                    ->first();
            } else {
                $variant = \App\Models\ProductVariant::where('product_id', $product->id)
                    ->where('status', 'active')
                    ->where('in_stock', '!=', '0')
                    ->first();
            }
            $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                ->where('status', 'active')
                ->where('in_stock', '!=', '0')
                ->first();
            if (empty($newsizevariant1)) {
                $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)
                    ->where('status', 'active')
                    ->first();
            }
            $ADiscountpercent = 0;
            $price = '';
            $discount = '';
            if ($product->discount_type === 'fixed') {
                $ADiscountpercent = $product->discount;
                $price = $newsizevariant1->regular_price - $product->discount;
                $discount = '';
            } else {
                if ($newsizevariant1->regular_price != 0) {
                    $ADiscountpercent = ($newsizevariant1->regular_price / 100) * $product->discount;
                } else {
                    $ADiscountpercent = 0;
                }
                $price = $newsizevariant1->regular_price - $ADiscountpercent;
                $discount = '%';
            }

        @endphp

        @php $singlereview=($re_val!=0) ? $re_val/count($reviewval) : 0; @endphp

        <section class="section-space padd-tb-40 padd-tb-60">

            <div class="container">

                <div class="row product-detailss">

                    <div class="col-lg-7">

                        <div class="image-slider-container">
                            <div class="main-image-wrapper">
                                @php
                                    $defaultImage =
                                        'https://via.placeholder.com/600x600/cccccc/666666?text=Select+Variant';
                                    if (isset($variant) && $variant->photo) {
                                        $photos = explode(',', $variant->photo);
                                        $defaultImage = trim($photos[0]);
                                    }
                                @endphp
                                <img src="{{ $defaultImage }}" id="main-product-image" alt="Product Image">
                                <!-- Previous Arrow -->
                                <button class="slider-arrow prev-arrow" onclick="previousImage()" id="prevBtn">
                                    &#10094;
                                </button>

                                <!-- Next Arrow -->
                                <button class="slider-arrow next-arrow" onclick="nextImage()" id="nextBtn">
                                    &#10095;
                                </button>

                                <!-- Image Counter -->
                                <div class="image-counter" id="imageCounter">
                                    <span id="currentImageNum">1</span> / <span id="totalImages">1</span>
                                </div>
                            </div>

                            <!-- Dot Indicators -->
                            <div class="slider-dots" id="sliderDots"></div>

                            <!-- Thumbnail Preview -->
                            <div class="thumbnail-preview" id="thumbnailPreview"></div>
                        </div>
                    </div>

                    <div class="col-lg-5">

                        <div class="product-details-content">

                            <!-- <h5 class="product-details-collection">Premioum collection</h5> -->

                            <h3 class="product-details-title mb-3">{{ $product->name }}</h3>
                            <!-- @if ($product->variant != null)
    <div class="product-price">
                                <span id="product_price">₹{{ $product->price }}</span>
                            </div>
@else
    <div class="product-price">
                                <span id="product_price">₹{{ $product->price }}</span>
                            </div>
    @endif -->
                            <div class="product-details-action mt-2 mb-4">
                                <?php
                                $newsales_price = '';
                                
                                $variant1 = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                                if (count($variant1) == 0) {
                                    $productvarientfirst = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
                                } else {
                                    $productvarientfirst = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->first();
                                }
                                
                                if (!empty($productvarientfirst)) {
                                    $newsales_price = $productvarientfirst->regular_price;
                                } else {
                                    $newsales_price = $product->sale_price;
                                }
                                
                                $productvarientfirst11 = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                                $productVariantStocks = [];
                                if ($productvarientfirst11->count()) {
                                    foreach ($productvarientfirst11 as $pVariants) {
                                        $productVariantStocks[$product->id][$pVariants['variants']] = $pVariants->in_stock;
                                    }
                                }
                                ?>
                                <h4 class="price">
                                    <div class="product-price">
                                        <span id="product_price">₹{{ number_format($price, 0) }}</span>
                                    </div>
                                    @if ($ADiscountpercent != 0)
                                        <span class="price-old">
                                            <span class="price"><span>₹</span> <span
                                                    id="newdeprice">{{ number_format($newsizevariant1->regular_price, 0) }}</span></span>
                                    @endif

                                </h4><small>(Incl Of All Taxes)</small>

                            </div>

                            <!--    <div class="product-rating">

                                <label class="rating-label d-flex align-items-center">

                                    <input class="rating me-2" max="5"

                                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5"

                                        style="--value:{{ $singlereview }}" type="range" value="2.5" disabled>

                                    <p class="text-dark">{{ count($product_review) }} Ratings</p>

                                </label>

                            </div> -->

                            <?php
                            $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                            
                            ?>
                            @if (count($newsizevariant) == 0)
                                <div class="outofstock"
                                    style="position: static;padding: 0px 31px;border: 1px solid #222e64;background: #222e64;color: #fff;width:31%;">
                                    <p>Out Of Stock</p>
                                </div>
                            @endif

                            {{-- <div class="d-flex align-items-center">

                            <p class="mb-0 mr-4">More information about product : </p>

                            <a class="mx-2" href="{{$product->youtube_link}}" target="_blank"><img class="youtube-icon" src="{{asset('frontend/img/youtube.png')}}"width="30" alt="Go to product youtube video" title="Go to product Youtube Video" aria-label="Go to product Youtube Video" /></a>

                        </div> --}}
                            <?php
                        $p124='';
                        $productvarientfirst = \App\Models\ProductVariant::where('product_id',$product->id)->where('status','active')->first();
                        if(!empty($productvarientfirst)){
                            $p124 = $productvarientfirst->id;
                        }
                        $newsizevariant=\App\Models\ProductVariant::where('product_id',$product->id)->where('status','active')->get();
                        $productAttibute=\App\Models\ProductAttribute::where('product_id',$product->id)->where('status','active')->orderBy('id','desc')->get();

                        if(!empty($newsizevariant)){
                        ?>

                            <input type="hidden" id="product_variant_stock"
                                value="{{ json_encode($productVariantStocks) }}" />
                            <input type="hidden" id="max_qty" name="max_qty" value="0">
                            <input type="hidden" id="product_size_id" name="product_size_id" value="{{ $product->id }}">

                            <input type="hidden" id="product_varients_id" name="product_varients_id"
                                value="{{ $p124 }}">
                            <input type="hidden" id="product_variants_data" value="{{ json_encode($newsizevariant) }}" />
                            <input type="hidden" id="product_size" name="product_size">
                            <input type="hidden" id="product_discount_type" value="{{ $product->discount_type }}">
                            <input type="hidden" id="product_discount_value" value="{{ $product->discount }}">
                            {{-- <div>{{$newsizevariant}}</div>
       <div>{{$productAttibute}}</div> --}}

                            @foreach ($productAttibute as $Akey => $pA)
                                @php
                                    $attributeDefinition = \App\Models\Attribute::where(
                                        'attribute_type',
                                        $pA->attribute_name,
                                    )->first();
                                    $allowedValues = $attributeDefinition ? $attributeDefinition->value : [];

                                    $rawValues = explode(',', $pA->attribute_value);
                                    $uniqueValues = array_unique(array_map('trim', $rawValues));
                                @endphp
                                <h4>
                                    {{ $pA->attribute_name }}
                                </h4>
                                <div class="mb-4">
                                    @foreach ($uniqueValues as $attKey => $attribute)
                                        @if (in_array($attribute, $allowedValues))
                                            <button
                                                class="size-buttons-size-button size-buttons-size-button-default product-variant-size-button attributeSelection_{{ $Akey }}_{{ $attKey }}"
                                                data-order="{{ $Akey }}"
                                                data-attributetype="{{ $pA->attribute_name }}"
                                                onclick="productsizechange('{{ $attribute }}', {{ $Akey }})"
                                                id="attr_{{ $Akey }}_{{ $attKey }}">
                                                {{ $attribute }}
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach

                            <!------   <ul class="size">
                                    <?php
                                foreach($newsizevariant as $vals){

                                    $variants = str_replace(",", "",$vals->variants);
                                ?>
                                  <a onclick="productsizechange('<?php echo $variants; ?>')"><li>{{ $variants }}</li></a>
                                   <?php } ?>

                              </ul> -->
                            <!------
                            <select id="product_size" id="product_size" style="padding: 8px;" onchange="productsizechange()">
                                <?php
                            foreach($newsizevariant as $vals){

                                $variants = str_replace(",", "",$vals->variants);
                            ?>
                                <option>{{ $variants }}</option>
                                <?php } ?>
                            </select>
                            ------>

                            <?php } ?>

                            <?php
                            $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
                            ?>

                            <div id="productcolorsvarients" style="padding: 6px">

                            </div>

                            <span id="product_size_message" style="color:red;font-weight:bold;display:none;">Please Select
                                Size</span>
                            <span id="product_common_error" style="color:red;font-weight:bold;"></span>
                            @if ($product->delivery_days > 0)
                                <?php
                                // Create a DateTime object for the current date
                                $currentDate = new DateTime();
                                $formattedDate = $currentDate->format('d F');
                                
                                // Add 5 days to the current date
                                $currentDate->modify('+' . $product->delivery_days . ' days');
                                $formattedDate2 = $currentDate->format('d F');
                                ?>
                                {{-- <p style="font-weight:bold;"><i class="fa fa-calendar" aria-hidden="true"></i> Estimated delivery between <?php echo $formattedDate; ?> - <?php echo $formattedDate2; ?></p>

                            <p style="font-weight:bold;">Tax Included. Shipping calculated at checkout </p> --}}
                            @endif
                            @if ($product->stock > 0)
                                <div class="product-details-pro-qty mt-3 d-flex align-items-center">

                                    <div class="pro-qty">

                                        <input type="hidden" id="count_prod_qty{{ $product->id }}"
                                            class="count_prod_qty" value="{{ $cart_qty }}"
                                            data-product_id="{{ $product->id }}"
                                            data-product_price="{{ number_format($product->sale_price, 0) }}">

                                        <input type="text" id="quantity{{ $product->id }}" title="Quantity"
                                            class="quantity count_prod_qty{{ $product->id }}"
                                            data-product_id="{{ $product->id }}"
                                            data-product_price="{{ number_format($product->sale_price, 0) }}"
                                            value="{{ $cart_qty }}" readonly>

                                        <div class="dec qty-btn single_product_render_count"
                                            data-product_id="{{ $product->id }}" data-type="dec">-</div>

                                        <div class="inc qty-btn single_product_render_count"
                                            data-product_id="{{ $product->id }}" data-type="inc">+</div>

                                    </div>

                                    <?php
                                    $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                                    ?>
                                    @if (count($newsizevariant) > 0)
                                        {{-- <button type="button"

                                class="buyaddbtn add_to_cartid add_tobuy_modal"

                                data-product_id="{{$product->id}}"  style="white-space: nowrap;" data-type="multi_cart">Buy Now</button>&nbsp; --}}

                                        <button type="button" class="addbtn add_to_cartid add_tocart_modal"
                                            data-product_id="{{ $product->id }}" style="white-space: nowrap;"
                                            data-type="multi_cart">Add to cart</button>
                                    @endif

                                    <button type="button"
                                        class="product-action-btn action-btn-wishlist wishlist_save icon_{{ $product->id }} add_towishlist_modal btn-wishlist-page"
                                        style="white-space: nowrap;" data-bs-toggle="modal"
                                        data-bs-target="#action-WishlistModal" data-product_id="{{ $product->id }}">

                                        <i class="fa fa-heart-o"></i>

                                    </button>

                                </div>
                            @endif

                            <hr class="mt-4 mb-3" />

                            <div class="row info-feature">

                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('frontend/img/feature1.png') }}" alt="Logo" />
                                    <h4>Tailor Cut & Fit</h4>
                                </div>

                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('frontend/img/feature2.png') }}" alt="Logo" />
                                    <h4>Cotton Elastane</h4>
                                </div>

                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('frontend/img/feature4.png') }}" alt="Logo" />
                                    <h4>360° Stretch</h4>
                                </div>

                            </div>

                            <?php
                        $usage = '';
                        if(!empty($product->usage)){
                             $usage = str_replace("<p><br></p>","",$product->usage);
                             $usage = str_replace('<p><b><span style="font-size: 18px;"><br></span></b></p>',"",$usage);
                             ?>
                            {{-- <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{!!html_entity_decode($sizechart) !!}</p> --}}
                            <?php
                        }
                        ?>
                            {{-- <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{!!html_entity_decode($usage) !!}</p> --}}

                        </div>

                    </div>
                </div>

            </div>

            </div>

        </section>

        <section class="mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row tabs-main mt-4" id="product-description">

                            <div class="col-md-12">

                                <ul class="nav product-info-tabs nav-pills d-none" id="myTab" role="tablist">

                                    <li class="nav-item" role="presentation">

                                        <button class="nav-link active" id="product-tab1" data-bs-toggle="tab"
                                            data-bs-target="#ptabs1" type="button" role="tab" aria-controls="home"
                                            aria-selected="true"><span class="dot"></span>Description</button>

                                    </li>

                                    <!--     <li class="nav-item" role="presentation">

                                <button class="nav-link" id="product-tab5" data-bs-toggle="tab" data-bs-target="#ptabs5"

                                    type="button" role="tab" aria-controls="contact" aria-selected="false"><span

                                        class="dot"></span>Reviews</button>

                            </li>  -->

                                </ul>

                                <div class="tab-content mt-5" id="myTabContent">

                                    <!-- tab1 -->

                                    <div class="tab-pane fade show active product-info" id="ptabs1" role="tabpanel"
                                        aria-labelledby="product-tab1">

                                        <h3 class="mb-4">Product Description</h3>

                                        <?php
                                        $description = '';
                                        if (!empty($product->description)) {
                                            $description = str_replace('<p><br></p>', '', $product->description);
                                            $description = str_replace('<p><b><span style="font-size: 18px;"><br></span></b></p>', '', $description);
                                        }
                                        ?>

                                        <p>{!! html_entity_decode($description) !!}</p>

                                        <?php
                                        $ingrediants = '';
                                        if (!empty($product->ingrediants)) {
                                            $ingrediants = str_replace('<p><br></p>', '', $product->ingrediants);
                                            $ingrediants = str_replace('<p><b><span style="font-size: 18px;"><br></span></b></p>', '', $ingrediants);
                                        }
                                        ?>

                                        <p>{!! html_entity_decode($ingrediants) !!}</p>

                                    </div>

                                    <!-- tab1 -->

                                    <div class="tab-pane fade" id="ptabs2" role="tabpanel"
                                        aria-labelledby="product-tab2">
                                        <h5>Product Benefits</h5>

                                        <p>{!! html_entity_decode($product->benefits) !!}</p>

                                    </div>

                                    <div class="tab-pane fade" id="ptabs3" role="tabpanel"
                                        aria-labelledby="product-tab3">
                                        <h5>Product Usage</h5>

                                        <p>{!! html_entity_decode($product->usage) !!}</p>

                                    </div>

                                    <div class="tab-pane fade" id="ptabs4" role="tabpanel"
                                        aria-labelledby="product-tab4">
                                        <h5>Product Ingrediants</h5>

                                        <p>{!! html_entity_decode($product->ingrediants) !!}</p>

                                    </div>

                                    <div class="tab-pane fade" id="ptabs5" role="tabpanel"
                                        aria-labelledby="product-tab5">

                                        <div class="row">

                                            <div class="col-md-6 rendered_reviews">

                                                @include('frontend.review')

                                            </div>

                                            <div class="col-md-6">

                                                <div class="product-reviews-form-wrap">

                                                    @if (auth()->guard('users')->user())
                                                        <h4 class="mb-3">Leave a reply</h4>

                                                        <div class="product-reviews-form">

                                                            <form action="#">

                                                                <div class="form-input-item">

                                                                    <textarea class="form-control textarea" id="review_comment" placeholder="Enter you feedback" required></textarea>

                                                                    <div id="comment_err" class="text-danger"
                                                                        style="font-family:auto;display:none">Please

                                                                        provide feedback</div>

                                                                </div>

                                                                <div class="form-input-item">

                                                                    <input class="form-control input"
                                                                        id="review_customername" type="text"
                                                                        placeholder="Full Name" required>

                                                                    <div id="customer_err" class="text-danger"
                                                                        style="font-family:auto;display:none">Please

                                                                        provide name</div>

                                                                </div>

                                                                <div class="form-input-item">

                                                                    <input class="form-control input"
                                                                        id="review_customerphone" type="text"
                                                                        placeholder="Mobile Number" required>

                                                                    <div id="phone_err" class="text-danger"
                                                                        style="font-family:auto;display:none">Please

                                                                        provide number</div>

                                                                </div>

                                                                <div class="form-input-item">

                                                                    <input class="form-control input"
                                                                        id="review_customeremail" type="email"
                                                                        placeholder="Email Address" required>

                                                                    <div id="email_err" class="text-danger"
                                                                        style="font-family:auto;display:none">Please

                                                                        provide email address</div>

                                                                    <div id="invalidemail_err" class="text-danger"
                                                                        style="font-family:auto;display:none">Invalid email
                                                                        address</div>

                                                                </div>

                                                                <div class="form-input-item">
                                                                    <!-- Rating Stars Box -->
                                                                    <span class="title">Provide Your Ratings :</span>
                                                                    <div class='rating-stars text-center'>
                                                                        <ul id='stars'>
                                                                            <li class='star' title='Poor'
                                                                                data-value='1'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Fair'
                                                                                data-value='2'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Good'
                                                                                data-value='3'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Excellent'
                                                                                data-value='4'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='WOW!!!'
                                                                                data-value='5'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>

                                                                    <div class='success-box'>
                                                                        <div class='clearfix'></div>
                                                                        <img alt='tick image' width='32'
                                                                            src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K' />
                                                                        <div class='text-message'></div>
                                                                        <div class='clearfix'></div>
                                                                    </div>

                                                                    <input type="hidden" id="product_rating"
                                                                        name="product_rating">
                                                                </div>

                                                                <div class="alert alert-success" style="display:none"
                                                                    id="success_review">Review

                                                                    Submitted</div>

                                                                <div class="form-input-item mb-0">

                                                                    <button type="button" id="review_submit"
                                                                        data-product_id="{{ $product->id }}"
                                                                        class="btn">Submit</button>

                                                                </div>

                                                            </form>

                                                        </div>

                                                </div>

                                            </div>
                                        @else
                                            <h4>Please <a class="login-btn" href="{{ url('user/auth') }}">Login</a> to
                                                add review !</h4>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section class="bg-all-l">

            <div class="container">

                <div class="row">

                    <div class="col-12">

                        <div class="section-title text-center">

                            <span>Our Shop</span>

                            <h2 class="title fontsiz mt-0 mb-1">Related Products</h2>

                        </div>

                    </div>

                </div>

                <div class="row mb-n4 mb-sm-n10 g-3 g-sm-6">

                    @foreach ($r_Products as $key => $product)
                        @php $rela_val=0; @endphp

                        @php $relatedreviewval = DB::table('product_reviews')
                                ->where('product_id', $product->id)
                                ->get();

                            foreach ($relatedreviewval as $r) {
                                $rela_val += $r->rate;
                            }

                        @endphp

                        @php $relatedreview=($rela_val!=0) ? $rela_val/count($relatedreviewval) : 0; @endphp

                        <?php
                        $variant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
                        
                        $ADiscountpercent = 0;
                        $price = '';
                        $discount = '';
                        if ($product->discount_type == 'fixed') {
                            $ADiscountpercent = $product->discount;
                            $price = $variant->regular_price - $product->discount;
                            $discount = '';
                        } else {
                            if ($variant->regular_price != 0 && $variant->regular_price != 'null') {
                                $ADiscountpercent = ($variant->regular_price / 100) * $product->discount;
                            } else {
                                $ADiscountpercent = 0;
                            }
                            $price = $variant->regular_price - $ADiscountpercent;
                            $discount = '%';
                        }
                        $variants_array = \App\Models\ProductVariant::where('product_id', $product->id)
                            ->where('status', 'active')
                            //->where('in_stock', '!=','0')
                            ->get();
                        
                        $newsize = []; // Initialize the array outside the loop
                        
                        if (!empty($variants_array)) {
                            foreach ($variants_array as $vals) {
                                $size = $vals->variants;
                                array_push($newsize, $size); // Corrected the function name and variable order
                            }
                        }
                        $size1 = '';
                        $size2 = '';
                        if (count($newsize) > 0) {
                            $size1 = implode(',', $newsize);
                            $size2 = str_replace(',,', ',', $size1);
                        }
                        
                        $aSaleprice = Helper::fetchSalePrice($variant->regular_price, $product->tax_id, $product->discount, $product->discount_type);
                        ?>

                        @if ($key < 4)
                            <div class="col-6 col-lg-3 col-md-6 mb-4 mb-sm-9">

                                <!--== Start Product Item ==-->

                                <div class="product-item single-productsBox">

                                    <div class="product-thumb  product-image">

                                        <a class="d-block" href="{{ url('products') . '/' . $product->slug }}">

                                            <img src="{{ asset($r_Productvariant_photo[$key]) }}" alt="Image-HasTech"
                                                class="home_product_img product-first-image">

                                        </a>

                                        <div class="product-status">

                                            @if ($aDiscountpercent[$key] != 0)
                                                <span>{{ number_format($aDiscountpercent[$key], 0) }} %</span>
                                            @endif

                                        </div>

                                        <div class="product-action">

                                            <button type="button" data-product_id="{{ $product->id }}"
                                                class="product-action-btn d-none action-btn-wishlist wishlist_save icon_{{ $product->id }} add_towishlist_modal"
                                                data-bs-toggle="modal">

                                                @php
                                                    $currentUser =
                                                        auth()->guard('users')->user() ??
                                                        auth()->guard('guest')->user();
                                                @endphp
                                                @if ($currentUser && isset($iswishlist[$key]) && $iswishlist[$key] === 'yes')
                                                    <i class="fa fa-heart-o heart_icon{{ $product->id }}"></i>
                                                    <!--<svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="1em" height="1em" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">-->

                                                    <!--<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="red" stroke="none">-->

                                                    <!--<path d="M1220 4684 c-418 -53 -754 -260 -982 -604 -232 -350 -297 -817 -167 -1205 56 -169 155 -341 269 -470 108 -122 2125 -2157 2151 -2171 36 -18 102 -18 138 1 31 15 2073 2079 2163 2185 378 445 428 1073 128 1596 -65 113 -128 194 -231 295 -182 180 -418 304 -677 356 -109 21 -383 24 -492 4 -214 -38 -436 -141 -615 -284 -27 -22 -116 -106 -197 -186 l-147 -145 -158 155 c-162 159 -255 235 -378 306 -115 67 -258 121 -395 148 -74 15 -343 27 -410 19z"/>-->

                                                    <!--</g>-->

                                                    <!--</svg>-->
                                                @else
                                                    <i class="fa fa-heart-o heart_icon{{ $product->id }}"></i>
                                                    <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.354 2.354-6.049-.002-8.416a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595zm6.791 1.61c1.563 1.571 1.564 4.025.002 5.588L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002z"></path></svg>-->
                                                @endif

                                            </button>

                                        </div>

                                    </div>

                                    <div class="product-info">

                                        <h4 class="title"><a
                                                href="{{ url('products') . '/' . $product->slug }}">{{ $product->name }}</a>
                                        </h4>

                                        <div class="prices  justify-content-between align-items-center">

                                            <div class="position-relative">

                                                <div>

                                                    <!--    <div class="product-rating text-center justify-content-center">

                                                    <label class="rating-label justify-content-center">

                                                        <input class="rating me-2" max="5"

                                                        oninput="this.style.setProperty('--value', `${this.valueAsNumber}`)" step="0.5"

                                                        style="--value:{{ $relatedreview }}" type="range" value="2.5" disabled>

                                                        <p class="text-dark">({{ count($relatedreviewval) }})</p>

                                                    </label>

                                                </div> -->

                                                    <div class="mt-0">
                                                        <?php
                                                if($ADiscountpercent>0){
                                                ?>
                                                        <span class="price-old"> {{ $variant->regular_price }}</span>
                                                        <?php } ?>

                                                        <span class="price"><span>₹</span> {{ number_format($price, 2) }}
                                                        </span>
                                                    </div>
                                                    <?php
                                                    $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                                                    ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!--== End prPduct Item ==-->

                            </div>
                        @endif
                    @endforeach

                    <!-- End products modal -->

                </div>

            </div>

        </section>

    </main>
@endsection

@section('script')
    <script>
        let selectedAttributes = {};
        let nextOrder = 0;

        let currentImages = [];
        let currentImageIndex = 0;

        // Navigate to next image
        function nextImage() {
            if (currentImageIndex < currentImages.length - 1) {
                currentImageIndex++;
                updateMainImage();
            }
        }

        // Navigate to previous image
        function previousImage() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                updateMainImage();
            }
        }

        // Go to specific image
        function goToImage(index) {
            currentImageIndex = index;
            updateMainImage();
        }

        // Update main image and controls
        function updateMainImage() {
            const mainImage = $('#main-product-image');

            // Add loading effect
            mainImage.addClass('image-loading');

            // Update image
            mainImage.attr('src', currentImages[currentImageIndex]);

            // Remove loading effect after image loads
            mainImage.on('load', function() {
                $(this).removeClass('image-loading');
            });

            // Update counter
            $('#currentImageNum').text(currentImageIndex + 1);

            // Update arrow states
            $('#prevBtn').prop('disabled', currentImageIndex === 0);
            $('#nextBtn').prop('disabled', currentImageIndex === currentImages.length - 1);

            // Update dots
            $('.dot').removeClass('active');
            $(`.dot[data-index="${currentImageIndex}"]`).addClass('active');

            // Update thumbnails
            $('.thumbnail-item').removeClass('active');
            $(`.thumbnail-item[data-index="${currentImageIndex}"]`).addClass('active');
        }

        // Update product images and slider
        function updateProductImages(photoUrl) {
            console.log("Updating images to:", photoUrl);

            // Parse images
            if (typeof photoUrl === 'string' && photoUrl.includes(',')) {
                currentImages = photoUrl.split(',').map(url => url.trim()).filter(url => url);
            } else if (typeof photoUrl === 'string') {
                currentImages = [photoUrl];
            } else {
                currentImages = [];
            }

            console.log("Total images:", currentImages.length);

            // Reset to first image
            currentImageIndex = 0;

            // Update total count
            $('#totalImages').text(currentImages.length);

            // Update main image
            if (currentImages.length > 0) {
                updateMainImage();
            }

            // Create dots
            createSliderDots();

            // Create thumbnails
            createThumbnails();

            // Show/hide arrows based on image count
            if (currentImages.length <= 1) {
                $('.slider-arrow').hide();
                $('#imageCounter').hide();
            } else {
                $('.slider-arrow').show();
                $('#imageCounter').show();
            }
        }

        // Create dot indicators
        function createSliderDots() {
            const dotsContainer = $('#sliderDots');
            dotsContainer.empty();

            currentImages.forEach((url, index) => {
                const isActive = index === 0 ? 'active' : '';
                const dot = $(`<div class="dot ${isActive}" data-index="${index}"></div>`);
                dot.on('click', function() {
                    goToImage(index);
                });
                dotsContainer.append(dot);
            });
        }

        // Create thumbnail preview
        function createThumbnails() {
            const thumbnailContainer = $('#thumbnailPreview');
            thumbnailContainer.empty();

            currentImages.forEach((url, index) => {
                const isActive = index === 0 ? 'active' : '';
                const thumbnail = $(`
                    <div class="thumbnail-item ${isActive}" data-index="${index}">
                        <img src="${url}" alt="Image ${index + 1}">
                    </div>
                `);
                thumbnail.on('click', function() {
                    goToImage(index);
                });
                thumbnailContainer.append(thumbnail);
            });
        }

        // Keyboard navigation
        $(document).on('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                previousImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            }
        });

        // Touch swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        $('.main-image-wrapper').on('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        $('.main-image-wrapper').on('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                nextImage(); // Swipe left
            }
            if (touchEndX > touchStartX + 50) {
                previousImage(); // Swipe right
            }
        }

        let product_variant_stock_obj = [];
        let product_variants_data = [];
        $(document).ready(function() {
            let product_variants_data = JSON.parse($('#product_variants_data').val() || '[]');
            console.log("=== ALL VARIANTS ===");
            $.each(product_variants_data, function(index, variant) {
                console.log("Variant " + index + ":", variant.variants, "Price:", variant.regular_price);
            });

            // Initialize slider with the image currently in the DOM (from PHP)
            let initialImage = $('#main-product-image').attr('src');
            if (initialImage && !initialImage.includes('via.placeholder.com')) {
                updateProductImages(initialImage);
            }
        });

        $(document).ready(function() {
            // Reset global state to ensure clean start
            nextOrder = 0;
            selectedAttributes = {};

            // Parse data from hidden inputs
            try {
                product_variant_stock_obj = JSON.parse($('#product_variant_stock').val() || '[]');
                product_variants_data = JSON.parse($('#product_variants_data').val() || '[]');
            } catch (e) {
                console.error("Error parsing variant data", e);
            }

            console.log("Product Variants Loaded:", product_variants_data);

            // Identify all attribute orders present on the page
            let attributeOrders = [];
            $('.product-variant-size-button').each(function() {
                let order = $(this).data('order');
                if (order !== undefined && !attributeOrders.includes(order)) {
                    attributeOrders.push(order);
                }
            });

            // Sort orders to ensure strict sequence (0 -> 1 -> 2 ...)
            attributeOrders.sort((a, b) => a - b);

            console.log("Found attribute orders:", attributeOrders);

            // Function to click buttons sequentially with a delay
            // This ensures that the state (nextOrder) updates correctly between clicks
            function autoSelectAttributes(index) {
                if (index >= attributeOrders.length) {
                    console.log("Auto-selection complete.");
                    return;
                }

                let order = attributeOrders[index];
                // Select the first button for this order
                let btn = $(`.product-variant-size-button[data-order="${order}"]`).first();

                if (btn.length) {
                    console.log(`Auto-clicking order ${order}: ${btn.text().trim()}`);

                    // Trigger the click
                    btn.trigger('click');

                    // Wait for the next step
                    setTimeout(function() {
                        autoSelectAttributes(index + 1);
                    }, 200); // 200ms delay between clicks
                } else {
                    // Skip if button not found (shouldn't happen)
                    autoSelectAttributes(index + 1);
                }
            }

            // Start the auto-selection process after a short initial delay
            if (attributeOrders.length > 0) {
                setTimeout(function() {
                    autoSelectAttributes(0);
                }, 300);
            }
        });

        function productsizechange(vals, order) {
            console.log("User clicked:", vals, "Order:", order);

            if (order > nextOrder) {
                let missingAttribute = "the previous attribute";
                alert("Please select " + missingAttribute + " first");
                return;
            }

            selectedAttributes[order] = vals;
            console.log("Selected so far:", selectedAttributes);

            if (order === nextOrder) {
                nextOrder++;
            }

            var product_id = $("#product_size_id").val();

            // Handle visual selection
            $(`.product-variant-size-button[data-order="${order}"]`).each(function() {
                let btnText = $(this).text().trim();
                if (btnText === vals) {
                    $(this).css({
                        'background-color': '#E4037E',
                        'border-color': '#E4037E',
                        'color': '#fff'
                    });
                } else {
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            // Count total attributes
            let totalAttributes = $('.product-variant-size-button').map(function() {
                return $(this).data('order');
            }).get();
            let maxOrder = Math.max(...totalAttributes);
            let attributeCount = maxOrder + 1;

            console.log("Total attributes:", attributeCount);

            // Check if all attributes are selected
            let allSelected = true;
            for (let i = 0; i < attributeCount; i++) {
                if (!selectedAttributes[i]) {
                    allSelected = false;
                    break;
                }
            }

            if (allSelected) {
                // Build attribute map to determine variant name order
                let attributeMap = [];

                for (let i = 0; i < attributeCount; i++) {
                    let attrType = $(`.product-variant-size-button[data-order="${i}"]`).first().data('attributetype');
                    let attrValue = selectedAttributes[i];

                    attributeMap.push({
                        order: i,
                        type: attrType ? attrType.toUpperCase() : '',
                        value: attrValue
                    });

                    console.log(`Attribute ${i}:`, attrType, "=", attrValue);
                }

                // Sort attributes to match variant naming convention
                // Priority: SIZE > COLOR > others (alphabetically)
                attributeMap.sort((a, b) => {
                    const priority = {
                        'SIZE': 1,
                        'COLOR': 2
                    };
                    const aPriority = priority[a.type] || 999;
                    const bPriority = priority[b.type] || 999;

                    if (aPriority !== bPriority) {
                        return aPriority - bPriority;
                    }
                    return a.type.localeCompare(b.type);
                });

                // Build combined value in the sorted order
                let combinedValue = attributeMap.map(attr => attr.value).join('').toUpperCase();

                console.log("Sorted attribute order:", attributeMap.map(a => a.type).join(' > '));
                console.log("Combined Value:", combinedValue);

                let product_variants_data = JSON.parse($('#product_variants_data').val() || '[]');

                console.log("=== Available Variants ===");
                $.each(product_variants_data, function(index, variant) {
                    console.log("Variant:", variant.variants);
                });

                let matchedVariant = null;
                $.each(product_variants_data, function(index, variant) {
                    if (variant.variants.toUpperCase() === combinedValue) {
                        matchedVariant = variant;
                        console.log("✓✓✓ MATCH FOUND!:", variant);
                        return false;
                    }
                });

                if (!matchedVariant) {
                    // Try alternative combinations
                    console.log("Trying alternative combinations...");
                    let allPermutations = generatePermutations(attributeMap.map(a => a.value));

                    $.each(allPermutations, function(i, perm) {
                        let testValue = perm.join('').toUpperCase();
                        $.each(product_variants_data, function(index, variant) {
                            if (variant.variants.toUpperCase() === testValue) {
                                matchedVariant = variant;
                                console.log("✓ Found with alternative combination:", testValue);
                                return false;
                            }
                        });
                        if (matchedVariant) return false;
                    });
                }

                if (matchedVariant) {
                    console.log("✓ Matched Variant:", matchedVariant);

                    // Update price
                    // Update price
                    let regularPrice = parseFloat(matchedVariant.regular_price);
                    let finalPrice = regularPrice;

                    let discountType = $('#product_discount_type').val();
                    let discountValue = parseFloat($('#product_discount_value').val()) || 0;

                    if (discountType === 'percentage') {
                        let discountAmount = (regularPrice * discountValue) / 100;
                        finalPrice = regularPrice - discountAmount;
                    } else if (discountType === 'fixed') {
                        finalPrice = regularPrice - discountValue;
                    }

                    $('#product_price').text('₹' + finalPrice.toFixed(2));
                    $('.product_rate_' + product_id).text(finalPrice.toFixed(2));
                    $('.product_rate_').text(finalPrice.toFixed(2)); // For old selector

                    // Update old price if discount exists
                    $('#newdeprice').text(regularPrice.toFixed(2));

                    // Update stock
                    let stock = parseInt(matchedVariant.in_stock);
                    $('#max_qty').val(stock);

                    // Update variant ID
                    $('#product_varients_id').val(matchedVariant.id);

                    // Update SKU
                    if (matchedVariant.sku) {
                        $('#product_sku').text(matchedVariant.sku);
                    }

                    // Update product size field
                    $("#product_size").val(combinedValue);

                    // Handle quantity validation based on stock
                    const quantityProductId = $('#quantity' + product_id);
                    let currentQty = parseInt(quantityProductId.val()) || 1;

                    if (currentQty > stock) {
                        quantityProductId.val(1);
                        console.log("Quantity reset to 1 (exceeds stock)");
                    }

                    // Hide size message
                    $("#product_size_message").css('display', 'none');
                    $("#product_common_error").text('');

                    // Clear color variants section (if you're not using it anymore)
                    $("#productcolorsvarients").html('');

                    // Update images
                    if (matchedVariant.photo) {
                        console.log("Updating images for variant:", matchedVariant.variants);
                        updateProductImages(matchedVariant.photo);
                    }

                    // Show stock status
                    if (stock === 0) {
                        $("#product_common_error").text('Out of Stock');
                        $('.add_to_cartid').prop('disabled', true);
                    } else if (stock < 5) {
                        $("#product_common_error").text('Only ' + stock + ' left in stock!');
                        $('.add_to_cartid').prop('disabled', false);
                    } else {
                        $('.add_to_cartid').prop('disabled', false);
                    }

                    console.log("✓ All updates complete - Price:", price, "Stock:", stock, "Variant ID:", matchedVariant
                    .id);

                } else {
                    console.log("❌ No matching variant found for:", combinedValue);
                    console.log("Available variants:");
                    $.each(product_variants_data, function(index, variant) {
                        console.log("  - " + variant.variants);
                    });

                    // Show error message
                    $("#product_common_error").text('This combination is not available');
                    $('.add_to_cartid').prop('disabled', true);
                }
            } else {
                console.log("Waiting for all selections...");
                console.log("Selected:", Object.keys(selectedAttributes).length, "of", attributeCount);

                // Hide error messages while selecting
                $("#product_size_message").css('display', 'none');
                $("#product_common_error").text('');
            }
        }

        function generatePermutations(arr) {
            if (arr.length <= 1) return [arr];

            let result = [];
            for (let i = 0; i < arr.length; i++) {
                let current = arr[i];
                let remaining = arr.slice(0, i).concat(arr.slice(i + 1));
                let remainingPerms = generatePermutations(remaining);

                for (let perm of remainingPerms) {
                    result.push([current].concat(perm));
                }
            }
            return result;
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.dec').css('display', 'none');

            $('.dec').on('click', function() {

                var productId = $(this).data('product_id');
                var type = $(this).data('type');
                var quantityInput = $('#quantity' + productId);
                let currentQuantity = parseInt(quantityInput.val(), 10);

                if (currentQuantity == 2) {
                    console.log('alert0');
                    $('.dec').css('display', 'none');
                } else {

                    $('.dec').css('display', 'block');

                }

            });

            $('.inc').on('click', function() {
                var productId = $(this).data('product_id');
                var type = $(this).data('type');
                var quantityInput = $('#quantity' + productId);
                let currentQuantity = parseInt(quantityInput.val(), 10);
                if (currentQuantity == 1) {
                    console.log('alert0');
                    $('.dec').css('display', 'block');
                }
            });

        });

        const imgs = document.querySelectorAll('.img-select a');

        const imgBtns = [...imgs];

        let imgId = 1;

        imgBtns.forEach((imgItem) => {

            imgItem.addEventListener('click', (event) => {

                event.preventDefault();

                imgId = imgItem.dataset.id;

                slideImage();

            });

        });

        function slideImage() {

            const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

            document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;

        }

        window.addEventListener('resize', slideImage);

        function selectcolor() {
            var colors = $("#product_color").val();
            var oldcolors = '<laebl style="padding: 8px;background:' + colors + '">' + colors + '</laebl>';
            $(".choosecolor").html(oldcolors);
        }

        $(document).ready(function() {

            //productsizechange('S');

            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function() {
                $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });

            /* 2. Action to perform on click */
            $('#stars li').on('click', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                $("#product_rating").val(ratingValue)
                var msg = "";
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                } else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                responseMessage(msg);

            });

        });

        function responseMessage(msg) {
            $('.success-box').fadeIn(200);
            $('.success-box div.text-message').html("<span>" + msg + "</span>");
        }

        $(document).ready(function() {
            // Initially set the background color of the active li
            $('li.active').css('background-color', '#007bff'); // Example background color

            // Example: Change background color on click
            $('.size li').click(function() {
                $('ul.size li').css('background', 'linear-gradient(180deg, #223f65, #0e1a30)');
                // Remove active class from all li elements
                $('li').removeClass('active');

                // Add active class to the clicked li element
                $(this).addClass('active');
                $('ul.size li:first-child.active').css('background', 'none');

                // Change background color of the active li
                $('ul.size li.active').css('background-color', '#007bff'); // Example background color
            });

            $('li.active').css('background-color', '#007bff'); // Example background color

            $('.size-buttons-size-button-disabled').click(function() {
                $(this).css({
                    'border': '1px solid #d5d6d9',
                    'background-color': '#fff',
                    'color': '#d5d6d9'
                });
            });

        });

        function productcolorchange(vals) {

            $("#product_color").val(vals);

            $("#yourcolors").html(vals);
        }
    </script>

    <script></script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script>
        // tippy('.product-variant-size-button', {
        //     content: 'My tooltip!',
        //   });
        tippy('.product-variant-size-button');
    </script>
@endsection
