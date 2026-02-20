@extends('frontend.layouts.arrivals_products_master_new')

<style>
    /* Product Image Gallery Styles */
    .product-gallery {
        display: flex;
        gap: 15px;
    }

    .product-thumbnails {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 80px;
    }

    .thumbnail-item {
        width: 70px;
        height: 90px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .thumbnail-item:hover,
    .thumbnail-item.active {
        border-color: #ff3f6c;
        box-shadow: 0 2px 8px rgba(255, 63, 108, 0.3);
    }

    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-main-image {
        flex: 1;
        max-width: 500px;
    }

    .main-image-container {
        position: relative;
        width: 100%;
        height: 600px;
        border-radius: 12px;
        overflow: hidden;
        background: #f8f8f8;
    }

    .main-image-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .main-image-container:hover img {
        transform: scale(1.05);
    }

    /* Color Variant Styles */
    .color-selector {
        margin: 20px 0;
    }

    .color-label {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
        display: block;
        color: #282c3f;
    }

    .color-options {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .color-option {
        width: 60px;
        height: 80px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .color-option:hover,
    .color-option.selected {
        border-color: #ff3f6c;
        box-shadow: 0 4px 12px rgba(255, 63, 108, 0.2);
        transform: translateY(-2px);
    }

    .color-option img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .color-option.selected::after {
        content: '✓';
        position: absolute;
        bottom: 2px;
        right: 2px;
        background: #ff3f6c;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    /* Size Button Styles */
    .size-selector {
        margin: 20px 0;
    }

    .size-label {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #282c3f;
    }

    .size-chart-link {
        color: #ff3f6c;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .size-chart-link:hover {
        text-decoration: underline;
    }

    .size-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .size-option {
        min-width: 60px;
        height: 60px;
        border: 1px solid #bfc0c6;
        border-radius: 50px;
        background: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        color: #282c3f;
        transition: all 0.3s ease;
        padding: 0 15px;
    }

    .size-option:hover {
        border-color: #ff3f6c;
        color: #ff3f6c;
    }

    .size-option.selected {
        border-color: #ff3f6c;
        background-color: #fff;
        color: #ff3f6c !important;
        border-width: 2px;
    }

    .size-option.disabled {
        color: #d5d6d9;
        border-color: #d5d6d9;
        cursor: not-allowed;
        position: relative;
        overflow: hidden;
    }

    .size-option.disabled::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #d5d6d9;
        transform: rotate(-45deg);
    }

    /* Product Details Styles */
    .product-details-new {
        padding: 0 20px;
    }

    .product-title {
        font-size: 24px;
        font-weight: 700;
        color: #282c3f;
        margin-bottom: 8px;
    }

    .product-subtitle {
        font-size: 16px;
        color: #535665;
        margin-bottom: 16px;
    }

    .price-section {
        margin: 20px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .price-current {
        font-size: 28px;
        font-weight: 700;
        color: #282c3f;
    }

    .price-original {
        font-size: 20px;
        color: #888;
        text-decoration: line-through;
    }

    .price-discount {
        font-size: 16px;
        color: #ff905a;
        font-weight: 600;
    }

    .tax-info {
        font-size: 12px;
        color: #535665;
        margin-top: 4px;
    }

    .special-price-badge {
        display: inline-block;
        background: #ff905a;
        color: white;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin: 30px 0;
    }

    .btn-add-cart {
        flex: 1;
        background: #ff3f6c;
        color: white;
        border: none;
        padding: 16px 24px;
        font-size: 16px;
        font-weight: 700;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }

    .btn-add-cart:hover {
        background: #d63659;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 63, 108, 0.3);
    }

    .btn-wishlist {
        width: 60px;
        height: 54px;
        border: 1px solid #d5d6d9;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-wishlist:hover {
        border-color: #ff3f6c;
        color: #ff3f6c;
    }

    /* Quantity Selector */
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 20px 0;
    }

    .quantity-label {
        font-size: 16px;
        font-weight: 600;
        color: #282c3f;
    }

    .pro-qty {
        display: flex;
        align-items: center;
        border: 1px solid #d5d6d9;
        border-radius: 4px;
        overflow: hidden;
    }

    .pro-qty button {
        width: 40px;
        height: 40px;
        border: none;
        background: white;
        cursor: pointer;
        font-size: 18px;
        font-weight: 700;
        color: #282c3f;
        transition: background 0.3s ease;
    }

    .pro-qty button:hover {
        background: #f5f5f5;
    }

    .pro-qty input {
        width: 60px;
        height: 40px;
        border: none;
        text-align: center;
        font-size: 16px;
        font-weight: 700;
    }

    /* Out of Stock Badge */
    .out-of-stock-badge {
        display: inline-block;
        background: #222e64;
        color: white;
        padding: 10px 30px;
        border-radius: 4px;
        font-weight: 600;
        margin: 15px 0;
    }

    /* Error Messages */
    .error-message {
        color: #f16565;
        font-size: 14px;
        margin-top: 8px;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .product-gallery {
            flex-direction: column-reverse;
        }

        .product-thumbnails {
            flex-direction: row;
            max-width: 100%;
            overflow-x: auto;
        }

        .main-image-container {
            height: 400px;
        }

        .product-title {
            font-size: 20px;
        }

        .price-current {
            font-size: 24px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-wishlist {
            width: 100%;
        }
    }
</style>

@section('content')

<?php
$sizechart = '<span style="font-size: 18px;font-weight:bold;">Size Chart :</span><table style="width:100%">
  <tr>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">SIZE</td>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">S</td>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">M</td>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">L</td>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">XL</td>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">XXL</td>

  </tr>
  <tr>
    <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">BUST</td>
    <td style=" border:1px solid black;text-align:center;">36</td>
    <td style=" border:1px solid black;text-align:center;">38</td>
    <td style=" border:1px solid black;text-align:center;">40</td>
    <td style=" border:1px solid black;text-align:center;">42</td>
    <td style=" border:1px solid black;text-align:center;">44</td>
  </tr>
</table>';
?>

<main class="main-content">
    <!--== Start Page Header Area ==-->
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
                            <li class="breadcrumb-item"><a class="text-dark" href="{{url('index')}}">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-dark" href="{{url('whatisnew')}}">Product</a></li>
                            <li class="breadcrumb-item active text-dark" aria-current="page">Product Detail</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Page Header Area ==-->

    @php
        $reviewval = DB::table('product_reviews')->where('status', 'accept')->where('product_id', $product->id)->get();
        $re_val = 0;
        foreach ($reviewval as $r) {
            $re_val += $r->rate;
        }

        $variant1 = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
        if (count($variant1) == 0) {
            $variant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
        } else {
            $variant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->first();
        }

        $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->first();
        if (empty($newsizevariant1)) {
            $newsizevariant1 = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
        }

        $ADiscountpercent = 0;
        $price = '';
        $discount = '';
        if ($product->discount_type === "fixed") {
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

        $singlereview = ($re_val != 0) ? $re_val / count($reviewval) : 0;

        $productvarientfirst11 = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
        $productVariantStocks = [];
        if ($productvarientfirst11->count()) {
            foreach ($productvarientfirst11 as $pVariants) {
                $productVariantStocks[$product->id][$pVariants['variants']] = $pVariants->in_stock;
            }
        }

        $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->get();
    @endphp

    <!--== Start Product Details Area ==-->
    <section class="section-space padd-tb-40 padd-tb-60">
        <div class="container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <!-- Thumbnails -->
                        <div class="product-thumbnails">
                            @foreach($AP_prodimg as $index => $img)
                                <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" onclick="changeMainImage('{{asset($img)}}', this)">
                                    <img src="{{asset($img)}}" alt="Product Image {{$index + 1}}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Main Image -->
                        <div class="product-main-image">
                            <div class="main-image-container">
                                <img id="mainProductImage" src="{{asset($AP_prodimg[0])}}" alt="{{$product->name}}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-lg-6">
                    <div class="product-details-new">
                        <!-- Title -->
                        <h1 class="product-title">{{$product->name}}</h1>
                        <p class="product-subtitle">Women Fit and Flare Dress</p>

                        <!-- Price Section -->

                        <div class="price-section">
                            <span class="price-current">
                                ₹<span class="product_rate_{{$product->product_id}}">{{ number_format($price, 2, '.', '') }}</span>
                            </span>
                            @if($ADiscountpercent != 0)
                                <span class="price-original">
                                    ₹<span id="newdeprice">{{ number_format($newsizevariant1->regular_price, 2, '.', '') }}</span>
                                </span>
                                <span class="price-discount">{{ round(($ADiscountpercent / $newsizevariant1->regular_price) * 100) }}% off</span>
                            @endif
                        </div>
                        <p class="tax-info">(Incl Of All Taxes)</p>

                        <!-- Out of Stock Check -->
                        @if(count($newsizevariant->where('in_stock', '>', 0)) == 0)
                            <div class="out-of-stock-badge">
                                Out Of Stock
                            </div>
                        @endif

                        <!-- Color Selector -->
                        @php
                            $uniqueColors = $newsizevariant->unique('color');
                            // Get all product variants with different colors
                            $colorVariants = \App\Models\ProductVariant::where('product_id', $product->id)
                                ->where('status', 'active')
                                ->groupBy('color')
                                ->get();
                        @endphp

                        @if($colorVariants->count() > 1)
                        <div class="color-selector">
                            <label class="color-label">
                                Color
                            </label>
                            <div class="color-options">
                                @foreach($colorVariants as $index => $colorVar)
                                    @php
                                        $colorImage = explode(',', $colorVar->photo)[0];
                                    @endphp
                                    <div class="color-option {{ $index === 0 ? 'selected' : '' }}"
                                         onclick="selectColor(this, '{{$colorVar->color}}')"
                                         data-color="{{$colorVar->color}}">
                                        <img src="{{asset($colorImage)}}" alt="{{$colorVar->color}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Size Selector -->
                        <div class="size-selector">
                            <label class="size-label">
                                <span>Size</span>
                                <a href="#" class="size-chart-link" data-bs-toggle="modal" data-bs-target="#sizeChartModal">
                                    SIZE CHART →
                                </a>
                            </label>

                            <input type="hidden" id="product_variant_stock" value="{{ json_encode($productVariantStocks) }}" />
                            <input type="hidden" id="max_qty" name="max_qty" value="0">
                            <input type="hidden" id="product_size_id" name="product_size_id" value="{{$product->id}}">
                            <input type="hidden" id="product_varients_id" name="product_varients_id" value="{{ $variant ? $variant->id : '' }}">
                            <input type="hidden" id="product_size" name="product_size">

                            <div class="size-options">
                                @php
                                    $uniqueSizes = [];
                                    foreach ($newsizevariant as $vals) {
                                        if (in_array($vals->variants, $uniqueSizes)) continue;
                                        $uniqueSizes[] = $vals->variants;
                                @endphp
                                        <button
                                            class="size-option {{ $vals->in_stock > 0 ? '' : 'disabled' }}"
                                            data-size="{{$vals->variants}}"
                                            data-stock="{{$vals->in_stock}}"
                                            {{ $vals->in_stock > 0 ? 'onclick=selectSize(this,"' . $vals->variants . '")' : 'disabled' }}
                                        >
                                            {{$vals->variants}}
                                        </button>
                                @php
                                    }
                                @endphp
                            </div>
                            <span id="product_size_message" class="error-message">Please Select Size</span>
                        </div>

                        <!-- Quantity Selector -->
                        @if($product->stock > 0)
                        <div class="quantity-selector">
                            <span class="quantity-label">Quantity:</span>
                            <div class="pro-qty">
                                <button class="dec qty-btn" onclick="decrementQty()">-</button>
                                <input type="number" id="count_prod_qty{{$product->id}}" class="count_prod_qty"
                                       value="{{$cart_qty}}" min="1"
                                       data-product_id="{{$product->id}}"
                                       data-product_price="{{number_format($product->sale_price, 2, '.', '')}}"
                                       readonly>
                                <button class="inc qty-btn" onclick="incrementQty()">+</button>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn-add-cart" onclick="addToCart({{$product->id}})">
                                Add to Cart
                            </button>
                            <button class="btn-wishlist" onclick="addToWishlist({{$product->id}})">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>

                        <!-- Product Description -->
                        <div class="product-description mt-4">
                            <h4 style="font-weight: 600; margin-bottom: 12px;">Product Details</h4>
                            <div>{!! $product->description !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Details Area ==-->

</main>

<!-- Size Chart Modal -->
<div class="modal fade" id="sizeChartModal" tabindex="-1" aria-labelledby="sizeChartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sizeChartModalLabel">Size Chart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! $sizechart !!}
            </div>
        </div>
    </div>
</div>

<script>
    // Change main image on thumbnail click
    function changeMainImage(imgSrc, element) {
        document.getElementById('mainProductImage').src = imgSrc;

        // Update active thumbnail
        document.querySelectorAll('.thumbnail-item').forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }

    // Select color
    function selectColor(element, color) {
        document.querySelectorAll('.color-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        element.classList.add('selected');
    }

    // Select size
    function selectSize(element, size) {
        document.querySelectorAll('.size-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('product_size').value = size;
        document.getElementById('product_size_message').classList.remove('show');

        // Update variant ID and max quantity based on selected size
        productsizechange(size);
    }

    // Increment quantity
    function incrementQty() {
        const input = document.querySelector('.count_prod_qty');
        const maxQty = parseInt(document.getElementById('max_qty').value) || 999;
        if (parseInt(input.value) < maxQty) {
            input.value = parseInt(input.value) + 1;
        }
    }

    // Decrement quantity
    function decrementQty() {
        const input = document.querySelector('.count_prod_qty');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    // Add to cart function (you'll need to implement this based on your existing cart logic)
    function addToCart(productId) {
        const selectedSize = document.getElementById('product_size').value;
        if (!selectedSize) {
            document.getElementById('product_size_message').classList.add('show');
            return;
        }

        // Your existing add to cart logic here
        console.log('Adding to cart:', {
            productId: productId,
            size: selectedSize,
            quantity: document.querySelector('.count_prod_qty').value
        });
    }

    // Product size change (integrate with your existing AJAX call)
    function productsizechange(size) {
        // Your existing AJAX logic to update product variant details
        console.log('Size changed to:', size);
    }
</script>

@endsection
