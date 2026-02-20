@extends('frontend.layouts.arrivals_products_master_new')

<style>
    .size-buttons-select-size {
        display: inline-block;
        font-size: 16px;
        margin: 0;
        font-weight: 700
    }

    .inc.qty-btn {
        font-size: 20px !important;
    }

    .size-buttons-size-container {
        margin: 10px 0 24px
    }

    .size-buttons-size-header {
        margin: 0 0 10px;
        position: relative;
        line-height: 1
    }

    .size-buttons-size-chart {
        margin-left: 30px
    }

    .size-buttons-arrow {
        display: inline-block;
        width: 6px;
        height: 6px;
        margin-left: 4px;
        border: solid #ff3e6c;
        border-width: 2px 2px 0 0;
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
        margin-bottom: 2px
    }

    .size-buttons-show-size-chart {
        outline: 0;
        background-color: transparent;
        border: 0;
        letter-spacing: .5px;
        text-align: right;
        padding: 0 0 5px;
        color: #ff3e6c;
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 0
    }

    .size-buttons-arrowRightBold {
        position: relative;
        top: 4px;
        color: #ff3e6c;
        -webkit-transform: scale(.8);
        transform: scale(.8)
    }

    .size-buttons-sizeTip {
        position: absolute;
        top: 0;
        left: 0;
        height: 1px;
        min-width: 400px;
        visibility: hidden;
        -webkit-transition: visibility .1s ease-out;
        transition: visibility .1s ease-out;
        -webkit-transition-delay: .1s;
        transition-delay: .1s
    }

    .size-buttons-sizeTip .size-buttons-sizeTipMeta {
        position: absolute;
        min-width: 400px;
        left: 0;
        bottom: 10px;
        text-align: left;
        border: 1px solid #e9e9eb;
        background-color: #fff;
        padding: 18px;
        z-index: 29;
        border-radius: 4px;
        font-weight: 400;
        -webkit-box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1);
        box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1)
    }

    .size-buttons-sizeTip .size-buttons-sizeTipMeta p {
        margin: 0
    }

    .size-buttons-tipAndBtnContainer {
        margin: 10px 10px 10px 0
    }

    .size-buttons-tipAndBtnContainer:hover .size-buttons-sizeTip {
        visibility: visible
    }

    .size-buttons-size-buttons {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        display: -webkit-box;
        display: -ms-flexbox;
        display: inline-flex !important;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        margin: 0;
        font-size: 13px;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        position: relative;
    }

    .size-buttons-size-buttons-error {
        padding-bottom: 10px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: inline-flex;
        -webkit-animation: size-buttons-shake .82s cubic-bezier(.36, .07, .19, .97) both;
        animation: size-buttons-shake .82s cubic-bezier(.36, .07, .19, .97) both;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-perspective: 1000px;
        perspective: 1000px
    }

    @-webkit-keyframes size-buttons-shake {

        10%,
        90% {
            -webkit-transform: translate3d(-1px, 0, 0);
            transform: translate3d(-1px, 0, 0)
        }

        20%,
        80% {
            -webkit-transform: translate3d(2px, 0, 0);
            transform: translate3d(2px, 0, 0)
        }

        30%,
        50%,
        70% {
            -webkit-transform: translate3d(-4px, 0, 0);
            transform: translate3d(-4px, 0, 0)
        }

        40%,
        60% {
            -webkit-transform: translate3d(4px, 0, 0);
            transform: translate3d(4px, 0, 0)
        }
    }

    .size-buttons-size-error-message {
        color: #f16565;
        margin-top: 15px;
        display: block
    }

    .size-buttons-size-button-default {
        background-color: #fff;
        border: 1px solid #bfc0c6;
        border-radius: 50px;
        padding: 0;
        min-width: 50px;
        height: 50px;
        text-align: center;
        cursor: pointer;
        color: #282c3f;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        position: relative
    }

    .size-buttons-size-button {
        position: relative
    }

    .size-buttons-size-button-selected {
        border: 1px solid #ff3f6c;
        background-color: #fff;
        color: #ff3f6c !important
    }

    .size-buttons-size-button-disabled {
        color: #d5d6d9;
        border: 1px solid #d5d6d9;
        cursor: default;
        font-weight: 700;
        outline: none;
        overflow: hidden
    }

    .size-buttons-size-strike-hide {
        width: 0;
        height: 0
    }

    .size-buttons-size-strike-show {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #d5d6d9;
        -webkit-transform: rotate(-45deg);
        transform: rotate(-45deg)
    }

    .size-buttons-big-size {
        min-height: 48px;
        min-width: 60px;
        border-radius: 50px;
        height: auto;
        width: auto;
        padding: 0 10px;
        font-weight: 700
    }

    .size-buttons-out-of-stock {
        color: #f16565
    }

    .size-buttons-size-button:hover {
        border: 1px solid #ff3f6c
    }

    .size-buttons-size-button:focus {
        outline: 0
    }

    .size-buttons-unified-size {
        margin: 0;
        font-size: 14px;
        padding: 0 8px;
        font-weight: 700
    }

    .size-buttons-unified-size+.size-buttons-inventory-left {
        left: 7%;
        bottom: -3px
    }

    .size-buttons-sku-price {
        font-size: 12px;
        text-transform: capitalize;
        font-weight: 400;
        margin-top: 4px
    }

    .size-buttons-bodymeasure {
        color: #535665
    }

    .size-buttons-sizeChartInfo {
        color: #535665;
        margin-top: 5px;
        font-size: 12px
    }

    .size-buttons-sizeFitDesc {
        font-weight: 400;
        border: none
    }

    .size-buttons-measurementType {
        font-size: 14px;
        color: #282c3f
    }

    .size-buttons-measurementName {
        font-size: 14px;
        margin-left: 6px;
        font-weight: 700;
        color: #535665
    }

    .size-buttons-inventory-left {
        font-size: 12px;
        font-weight: 400;
        position: absolute;
        width: 100%;
        left: 0;
        width: 90%;
        left: 7%;
        background-color: #ff905a;
        color: #fff;
        border-radius: 2px;
        text-align: center
    }

    .size-buttons-inventory-left-hidden {
        visibility: hidden
    }

    .size-buttons-sizeButtonAsLink {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto
    }

    @media (min-width: 600px) {
        .size-buttons-size-buttons {
            margin-bottom: 10px
        }
    }

    @media (min-width: 980px) {
        .size-buttons-size-chart {
            top: 0;
            right: 0
        }
    }

    .size-buttons-recoContainer {
        position: relative;
        clear: both
    }

    .size-buttons-recoWrapper {
        background: #fff0f4;
        padding: 9px 7px;
        width: 84%
    }

    .size-buttons-recoTextContainer {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex
    }

    .size-buttons-recoTextContainer.size-buttons-recoTextWithMoreProfiles {
        width: calc(100% - 90px)
    }

    .size-buttons-sizeRecoImg {
        width: 27px;
        height: 22px;
        margin-right: 14px
    }

    .size-buttons-recoContainerMobile {
        overflow: hidden
    }

    .size-buttons-recText {
        font-size: 16px;
        position: relative;
        margin: 8px
    }

    .size-buttons-moreProfilesWeb {
        position: absolute;
        right: 16px;
        top: 8px
    }

    .size-buttons-moreProfilesMobile {
        right: 20px;
        max-height: 0;
        -webkit-transition: max-height .6s cubic-bezier(0, 1, .5, 1);
        transition: max-height .6s cubic-bezier(0, 1, .5, 1)
    }

    .size-buttons-moreProfilesMobile .size-buttons-profileListHeader {
        position: absolute;
        right: 12px;
        top: 14px
    }

    .size-buttons-profileListHeader {
        cursor: pointer;
        padding: 10px 0;
        font-weight: 700;
        font-size: 16px;
        color: #ff3f6c
    }

    .size-buttons-sharpCorner {
        border-color: #fde3f3 transparent;
        border-style: solid;
        border-width: 10px 10px 0;
        width: 0;
        position: absolute;
        left: 22px;
        bottom: -8px
    }

    .size-buttons-profilesListWeb {
        margin: 0;
        width: 70px;
        background-color: #fff;
        -webkit-box-shadow: 0 0 4px 0 rgba(0, 0, 0, .13);
        box-shadow: 0 0 4px 0 rgba(0, 0, 0, .13);
        position: absolute;
        right: 0;
        top: 24px;
        padding: 8px 12px 4px;
        z-index: 2;
        display: none
    }

    .size-buttons-profilesListMobile {
        white-space: nowrap;
        overflow: auto;
        -webkit-transform: translateX(110%);
        transform: translateX(110%);
        -webkit-transition: -webkit-transform .6s cubic-bezier(0, 1, .5, 1);
        transition: -webkit-transform .6s cubic-bezier(0, 1, .5, 1);
        transition: transform .6s cubic-bezier(0, 1, .5, 1);
        transition: transform .6s cubic-bezier(0, 1, .5, 1), -webkit-transform .6s cubic-bezier(0, 1, .5, 1)
    }

    .size-buttons-profilesListMobile li {
        display: inline-block;
        border-radius: 50px;
        border: .5px solid #696b79;
        padding: 12px 18px;
        width: 65px;
        text-align: center;
        font-weight: 700;
        font-size: 15px;
        margin-right: 10px
    }

    .size-buttons-pNameHeader {
        color: #ff3f6c;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 90px;
        display: inline-block
    }

    .size-buttons-moreProfilesMobile.size-buttons-showProfiles {
        max-height: 50px
    }

    .size-buttons-moreProfilesMobile.size-buttons-showProfiles .size-buttons-profilesListMobile {
        -webkit-transform: translateX(0);
        transform: translateX(0)
    }

    .size-buttons-moreProfilesWeb:hover .size-buttons-profilesListWeb {
        display: inline-block
    }

    .size-buttons-profileItem {
        margin-bottom: 6px;
        cursor: pointer;
        color: #7e818c;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis
    }

    .size-buttons-profileItem.size-buttons-selected {
        border: 1px solid #ff3f6c;
        background-color: #fff;
        color: #ff3f6c !important
    }

    .size-buttons-personalisedReco {
        width: 70%;
        display: inline-block;
        margin-top: 2px
    }

    .size-buttons-similarWrapper {
        margin: 0
    }

    .size-buttons-moreProfileSC {
        position: absolute;
        top: 12px;
        right: 16px
    }

    .size-buttons-viewSimilar {
        color: #ff3e6c;
        font-weight: 700;
        cursor: pointer
    }

    .size-buttons-tagInfoText {
        position: absolute;
        background: #fff;
        top: -78px;
        left: 0;
        width: 330px;
        padding: 8px 10px;
        display: none;
        border-radius: 6px;
        -webkit-box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1);
        box-shadow: 0 2px 16px 0 rgba(40, 44, 63, .1);
        text-align: left;
        border: 1px solid #e9e9eb;
        color: #535665
    }

    .size-buttons-tagInfoIcon {
        display: inline-block;
        border: 1px solid #7e808c;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        background: #7e808c;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        text-align: center;
        cursor: pointer;
        margin-left: 10px
    }

    .size-buttons-tagInfoIcon:hover+.size-buttons-tagInfoText {
        display: block
    }

    .size-buttons-hide {
        display: none
    }

    .size-buttons-shakeText {
        -webkit-animation: size-buttons-shake .6s cubic-bezier(.36, .07, .19, .97) both;
        animation: size-buttons-shake .6s cubic-bezier(.36, .07, .19, .97) both;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-perspective: 1000px;
        perspective: 1000px
    }

    .size-buttons-login {
        color: #ff3e6c;
        margin-left: 7px;
        font-weight: 700;
        cursor: pointer
    }

    .size-buttons-buttonContainer {
        position: relative
    }

    .size-buttons-reco-icon {
        display: inline-block;
        margin: 0 10px 0 4px;
        vertical-align: top
    }

    .size-buttons-sc-reco-txt {
        padding: 14px;
        background: -webkit-gradient(linear, left top, right top, from(#fde3f3), to(#fef9e5));
        background: linear-gradient(90deg, #fde3f3, #fef9e5);
        color: #282c3f
    }

    @keyframes size-buttons-shake {

        10%,
        90% {
            -webkit-transform: translate3d(-1px, 0, 0);
            transform: translate3d(-1px, 0, 0)
        }

        20%,
        80% {
            -webkit-transform: translate3d(2px, 0, 0);
            transform: translate3d(2px, 0, 0)
        }

        30%,
        50%,
        70% {
            -webkit-transform: translate3d(-2px, 0, 0);
            transform: translate3d(-2px, 0, 0)
        }

        40%,
        60% {
            -webkit-transform: translate3d(2px, 0, 0);
            transform: translate3d(2px, 0, 0)
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
          <!--<tr>
            <td style=" border:1px solid black;color:#111;font-size: 14px;font-weight:700;text-align:center;">WAIST</td>
            <td style=" border:1px solid black;text-align:center;">28</td>
            <td style=" border:1px solid black;text-align:center;">30</td>
            <td style=" border:1px solid black;text-align:center;">32</td>
             <td style=" border:1px solid black;text-align:center;">34</td>
              <td style=" border:1px solid black;text-align:center;">36</td>
          </tr>-->
        </table>';
    ?>

    <main class="main-content ">

        <!--== Start Page Header Area Wrapper ==-->

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

                                <li class="breadcrumb-item"><a class="text-dark" href="{{ url('whatisnew') }}">Product</a>

                                </li>

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
            //dd("dis",$newsizevariant1);
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
                // dd("ass1",$price);
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

        @php $singlereview = ($re_val != 0) ? $re_val / count($reviewval) : 0; @endphp

        <section class="section-space padd-tb-40 padd-tb-60">

            <div class="container">

                <div class="row product-details">

                    <div class="col-lg-6">

                        <div class="product-left ">

                            @for ($i = 0; $i < count($AP_prodimg); $i++)
                                <div class="img-all-product">

                                    <img src="{{ asset($AP_prodimg[$i]) }}" alt="..." class="img-fluid">

                                </div>
                            @endfor

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="product-details-content">

                            <!-- <h5 class="product-details-collection">Premioum collection</h5> -->

                            <h3 class="product-details-title mb-0 text-dark">{{ $product->name }}</h3>

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
                                // dd("ass", $productvarientfirst11);
                                $productVariantStocks = [];
                                if ($productvarientfirst11->count()) {
                                    foreach ($productvarientfirst11 as $pVariants) {
                                        $productVariantStocks[$product->id][$pVariants['variants']] = $pVariants->in_stock;
                                        //  dd("aas",$productVariantStocks);
                                    }
                                }
                                ?>
                                <h4 class="price">
                                    <span>₹</span>
                                    <span class="product_rate_{{ $product->product_id }}">
                                        {{ number_format($price, 2, '.', '') }}
                                    </span>

                                    @if ($ADiscountpercent != 0)
                                        <span class="price-old"
                                            style="text-decoration: line-through; color:#888; margin-left:8px;">
                                            <span>₹</span>
                                            <span id="newdeprice">
                                                {{ number_format($newsizevariant1->regular_price, 2, '.', '') }}
                                            </span>
                                        </span>
                                    @endif
                                </h4>
                                <small>(Incl Of All Taxes)</small>

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

                            <h4>Select Size :</h4>
                            <?php
    $p124 = '';
    $productvarientfirst = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
    if (!empty($productvarientfirst)) {
        $p124 = $productvarientfirst->id;
    }
    // $newsizevariant=\App\Models\ProductVariant::where('product_id',$product->id)->where('status','active')->get();
    $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)
        ->where('status', 'active')
        ->get();

    $uniqueColors = $newsizevariant->unique('variants');   // or 'color'
    if (!empty($newsizevariant)) {
                            ?>

                            <input type="hidden" id="product_variant_stock"
                                value="{{ json_encode($productVariantStocks) }}" />
                            <input type="hidden" id="max_qty" name="max_qty" value="0">
                            <input type="hidden" id="product_size_id" name="product_size_id" value="{{ $product->id }}">

                            <input type="hidden" id="product_varients_id" name="product_varients_id"
                                value="{{ $p124 }}">

                            <input type="hidden" id="product_size" name="product_size">

                            <div class="size-buttons-size-buttons">
                                <?php
        $uniqueSizes = [];
        foreach ($newsizevariant as $vals) {
            if (in_array($vals->variants, $uniqueSizes))
                continue;
            $uniqueSizes[] = $vals->variants;
            // dd("aaaaaaa",$vals);
            if ($vals->in_stock > 0) {
                                                    ?>
                                <div class="size-buttons-tipAndBtnContainer">
                                    <div class="size-buttons-buttonContainer">
                                        <button
                                            class="size-buttons-size-button size-buttons-size-button-default product-variant-size-button"
                                            data-tippy-content="{{ $vals->in_stock }} Stocks Available"
                                            data-product-stock="{{ $vals->in_stock }} Stocks Available"
                                            data-product-variant-size="<?php echo $vals->variants; ?>"
                                            onclick="productsizechange('<?php echo $vals->variants; ?>')">
                                            <span class="size-buttons-size-strike-hide"></span>
                                            <p class="size-buttons-unified-size">{{ $vals->variants }}</p>
                                        </button>
                                    </div>

                                </div>
                                <?php

            } else {
                                                    ?>
                                <div class="size-buttons-tipAndBtnContainer">
                                    <div class="size-buttons-buttonContainer">
                                        <button class="size-buttons-size-button-disabled size-buttons-size-button-default">
                                            <span class="size-buttons-size-strike-hide"></span>
                                            <p class="size-buttons-unified-size">{{ $vals->variants }}</p>
                                        </button>
                                    </div>

                                </div>
                                <?php

            }
        }
                                            ?>

                            </div>

                            <!------   <ul class="size">
                                        <?php
        foreach ($newsizevariant as $vals) {

            $variants = str_replace(",", "", $vals->variants);
                                    ?>
                                      <a onclick="productsizechange('<?php echo $variants; ?>')"><li>{{ $variants }}</li></a>
                                       <?php    } ?>

                                  </ul> -->
                            <!------
                                <select id="product_size" id="product_size" style="padding: 8px;" onchange="productsizechange()">
                                    <?php
        foreach ($newsizevariant as $vals) {

            $variants = str_replace(",", "", $vals->variants);
                                ?>
                                    <option>{{ $variants }}</option>
                                    <?php    } ?>
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
                                            data-product_price="{{ number_format($product->sale_price, 2, '.', '') }}">

                                        <input type="text" id="quantity{{ $product->id }}" title="Quantity"
                                            class="quantity count_prod_qty{{ $product->id }}"
                                            data-product_id="{{ $product->id }}"
                                            data-product_price="{{ number_format($product->sale_price, 2, '.', '') }}"
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

                            <?php
    $usage = '';
    if (!empty($product->usage)) {
        $usage = str_replace("<p><br></p>", "", $product->usage);
        $usage = str_replace('<p><b><span style="font-size: 18px;"><br></span></b></p>', "", $usage);
                                 ?>
                            {{-- <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{!!html_entity_decode($sizechart) !!}</p> --}}
                            <?php
    }
                            ?>
                            {{-- <p style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{!!html_entity_decode($usage) !!}</p> --}}

                        </div>

                    </div>

                </div>

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

                            <div class="tab-pane fade show active" id="ptabs1" role="tabpanel"
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

                            <div class="tab-pane fade" id="ptabs2" role="tabpanel" aria-labelledby="product-tab2">
                                <h5>Product Benefits</h5>

                                <p>{!! html_entity_decode($product->benefits) !!}</p>

                            </div>

                            <div class="tab-pane fade" id="ptabs3" role="tabpanel" aria-labelledby="product-tab3">
                                <h5>Product Usage</h5>

                                <p>{!! html_entity_decode($product->usage) !!}</p>

                            </div>

                            <div class="tab-pane fade" id="ptabs4" role="tabpanel" aria-labelledby="product-tab4">
                                <h5>Product Ingrediants</h5>

                                <p>{!! html_entity_decode($product->ingrediants) !!}</p>

                            </div>

                            <div class="tab-pane fade" id="ptabs5" role="tabpanel" aria-labelledby="product-tab5">

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

                                                            <input class="form-control input" id="review_customername"
                                                                type="text" placeholder="Full Name" required>

                                                            <div id="customer_err" class="text-danger"
                                                                style="font-family:auto;display:none">Please

                                                                provide name</div>

                                                        </div>

                                                        <div class="form-input-item">

                                                            <input class="form-control input" id="review_customerphone"
                                                                type="text" placeholder="Mobile Number" required>

                                                            <div id="phone_err" class="text-danger"
                                                                style="font-family:auto;display:none">Please

                                                                provide number</div>

                                                        </div>

                                                        <div class="form-input-item">

                                                            <input class="form-control input" id="review_customeremail"
                                                                type="email" placeholder="Email Address" required>

                                                            <div id="email_err" class="text-danger"
                                                                style="font-family:auto;display:none">Please

                                                                provide email address</div>

                                                            <div id="invalidemail_err" class="text-danger"
                                                                style="font-family:auto;display:none">Invalid email address
                                                            </div>

                                                        </div>
                                                        <style>
                                                            * {
                                                                -webkit-box-sizing: border-box;
                                                                -moz-box-sizing: border-box;
                                                                box-sizing: border-box;
                                                            }

                                                            *:before,
                                                            *:after {
                                                                -webkit-box-sizing: border-box;
                                                                -moz-box-sizing: border-box;
                                                                box-sizing: border-box;
                                                            }

                                                            .clearfix {
                                                                clear: both;
                                                            }

                                                            .text-center {
                                                                text-align: center;
                                                            }

                                                            pre {
                                                                display: block;
                                                                padding: 9.5px;
                                                                margin: 0 0 10px;
                                                                font-size: 13px;
                                                                line-height: 1.42857143;
                                                                color: #333;
                                                                word-break: break-all;
                                                                word-wrap: break-word;
                                                                background-color: #F5F5F5;
                                                                border: 1px solid #CCC;
                                                                border-radius: 4px;
                                                            }

                                                            .new-react-version {
                                                                padding: 20px 20px;
                                                                border: 1px solid #eee;
                                                                border-radius: 20px;
                                                                box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);

                                                                text-align: center;
                                                                font-size: 14px;
                                                                line-height: 1.7;
                                                            }

                                                            .new-react-version .react-svg-logo {
                                                                text-align: center;
                                                                max-width: 60px;
                                                                margin: 20px auto;
                                                                margin-top: 0;
                                                            }

                                                            .success-box {
                                                                margin: 50px 0;
                                                                padding: 10px 10px;
                                                                border: 1px solid #eee;
                                                                background: #f9f9f9;
                                                            }

                                                            .success-box img {
                                                                margin-right: 10px;
                                                                display: inline-block;
                                                                vertical-align: top;
                                                            }

                                                            .success-box>div {
                                                                vertical-align: top;
                                                                display: inline-block;
                                                                color: #888;
                                                            }

                                                            /* Rating Star Widgets Style */
                                                            .rating-stars ul {
                                                                list-style-type: none;
                                                                padding: 0;

                                                                -moz-user-select: none;
                                                                -webkit-user-select: none;
                                                            }

                                                            .rating-stars ul>li.star {
                                                                display: inline-block;

                                                            }

                                                            /* Idle State of the stars */
                                                            .rating-stars ul>li.star>i.fa {
                                                                font-size: 2.5em;
                                                                /* Change the size of the stars */
                                                                color: #ccc;
                                                                /* Color on idle state */
                                                            }

                                                            /* Hover state of the stars */
                                                            .rating-stars ul>li.star.hover>i.fa {
                                                                color: #FFCC36;
                                                            }

                                                            /* Selected state of the stars */
                                                            .rating-stars ul>li.star.selected>i.fa {
                                                                color: #FF912C;
                                                            }
                                                        </style>
                                                        <div class="form-input-item">
                                                            <!-- Rating Stars Box -->
                                                            <span class="title">Provide Your Ratings :</span>
                                                            <div class='rating-stars text-center'>
                                                                <ul id='stars'>
                                                                    <li class='star' title='Poor' data-value='1'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star' title='Fair' data-value='2'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star' title='Good' data-value='3'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star' title='Excellent' data-value='4'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                    <li class='star' title='WOW!!!' data-value='5'>
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
                                    <h4>Please <a class="login-btn" href="{{ url('user/auth') }}">Login</a> to add review
                                        !</h4>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <!--== End Product Details Area Wrapper ==-->

        <!--== Start Product Area Wrapper ==-->

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
                        @php $rela_val = 0; @endphp

                        @php $relatedreviewval = DB::table('product_reviews')
                                ->where('product_id', $product->id)
                                ->get();

                            foreach ($relatedreviewval as $r) {
                                $rela_val += $r->rate;
                            }

                        @endphp

                        @php $relatedreview = ($rela_val != 0) ? $rela_val / count($relatedreviewval) : 0; @endphp

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
                                                <span>{{ number_format($aDiscountpercent[$key], 2, '.', '') }} %</span>
                                            @endif

                                        </div>

                                        <div class="product-action">

                                            <button type="button" data-product_id="{{ $product->id }}"
                                                class="product-action-btn action-btn-wishlist wishlist_save icon_{{ $product->id }} add_towishlist_modal"
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

                                                    <div class="mt-3">
                                                        <?php
                                            if ($ADiscountpercent > 0) {
                                                                                    ?>
                                                        <span class="price-old"> {{ $variant->regular_price }}</span>
                                                        <?php        } ?>

                                                        <span class="price"><span>₹</span> {{ number_format($price, 2) }}
                                                        </span>
                                                    </div>
                                                    <?php
                                                    $newsizevariant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->where('in_stock', '!=', '0')->get();
                                                    ?>

                                                    <div class="size-buttons-size-buttons">
                                                        <?php
                                            if (count($variants_array) > 0) {
                                                foreach ($variants_array as $vals) {

                                                    if ($vals->in_stock > 0) {
                                                        $class = "";
                                                    } else {
                                                        $class = "-disabled";
                                                    }
                                                              ?>
                                                        <div class="size-buttons-tipAndBtnContainer"
                                                            style="margin: 10px 6px 10px 0;">
                                                            <div class="size-buttons-buttonContainer"><button
                                                                    class="size-buttons-size-button<?php echo $class; ?> size-buttons-size-button-default"
                                                                    style="min-width:30px; height:30px"><span
                                                                        class="size-buttons-size-strike-hide"></span>
                                                                    <p class="size-buttons-unified-size"
                                                                        style="font-size:9px;">{{ $vals->variants }}</p>
                                                                </button></div>

                                                        </div>
                                                        <?php            }
                                            } ?>

                                                    </div>

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

        <!--== End Product Area Wrapper ==-->

    </main>

    <style>
        #product-reviews-form {

            width: 80px;

            height: 50px;

            border: 2px solid #e63946;

            border-radius: 50px;

            font-weight: 700;

            font-size: 13px;

            letter-spacing: .2em;

            text-transform: uppercase;

            color: #231942;

            lign-items: center;

            display: flex;

            padding: 7px 24px 5px 5px;

            justify-content: flex-end;

        }
    </style>

    <script>
        function productcolorchange(color) {
            // Update display
            document.getElementById('yourcolors').textContent = color;

            // Update hidden input
            document.getElementById('product_color').value = color;

            // Highlight selected color
            document.querySelectorAll('.color-option').forEach(li => {
                li.style.border = (li.style.background === color) ? '2px solid black' : '1px solid #ccc';
            });
        }

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

        var product_variant_stock = $("#product_variant_stock").val();
        var product_variant_stock_obj = JSON.parse(product_variant_stock);

        function slideImage() {

            const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

            document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;

        }

        window.addEventListener('resize', slideImage);

        var allVariants = {!! \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->get()->toJson() !!};
        var productDiscount = {{ $product->discount ?? 0 }};
        var productDiscountType = "{{ $product->discount_type }}";
        console.log('Product Discount Settings:', {
            productDiscount,
            productDiscountType
        });

        function productsizechange(vals) {
            var product_id = $("#product_size_id").val();

            // Handle selected size
            $(".product-variant-size-button").each(function() {
                if ($(this).data('product-variant-size') == vals) {
                    $(this).css({
                        'background-color': '#282c3f',
                        'color': '#fff'
                    });
                } else {
                    $(this).css({
                        'background-color': '',
                        'color': ''
                    });
                }
            });

            const quantityProductId = $('#quantity' + product_id);
            const countProdQty = $('.count_prod_qty');

            $.each(product_variant_stock_obj, function(index, obj) {
                $.each(obj, function(key, val) {
                    if (key == vals) {
                        if (quantityProductId.val() > val) {
                            quantityProductId.val(1);
                        }
                        $('#max_qty').val(val);
                        return false;
                    }
                });
            });

            //alert(vals);
            $("#product_size_message").css('display', 'none');
            $("#product_size").val(vals);
            // var product_id = $("#product_size_id").val();
            $("#productcolorsvarients").html('')
            var token = $('meta[name="csrf-token"]').attr('content');
            var path = $('meta[name="base_url"]').attr('content') + '/getproductvarientssize';
            $.ajax({
                url: path,
                type: "GET",
                data: {
                    _token: token,
                    product_id: $("#product_size_id").val(),
                    size: $("#product_size").val(),
                },
                success: function(response) {

                    if (response != '') {
                        console.log('AJAX Response:', response);
                        console.log('Colors HTML:', response.colors);
                        $(".product_rate_{{ $product->product_id }}").html(response.data.regular_price);
                        $("#product_varients_id").val(response.data.product_varients_id)
                        $("#productcolorsvarients").html(response.colors)
                        $("#newdeprice").html(response.data.original_price)
                        $('#max_qty').val(response.data.in_stock)

                    }
                }
            });
        }

        function selectVariantColor(element) {
            var color = $(element).data('color');
            var variantId = $(element).data('variant-id');
            var price = $(element).data('price');
            var stock = $(element).data('stock');

            console.log('selectVariantColor called:', {
                color,
                variantId,
                price,
                stock
            });

            // Visual highlight
            $('.color-option').css('border', '1px solid #ccc');
            $(element).css('border', '2px solid black');

            $("#product_color").val(color);
            updateVariantDetails(variantId, price, stock);
        }

        function updateVariantDetails(variantId, price, stock) {
            console.log('=== updateVariantDetails START ===');
            console.log('Raw inputs:', {
                variantId,
                price,
                stock
            });
            console.log('Global variables:', {
                productDiscount,
                productDiscountType
            });

            $("#product_varients_id").val(variantId);
            $('#max_qty').val(stock);

            // Parse and validate price
            var parsedPrice = parseFloat(price);
            if (isNaN(parsedPrice) || parsedPrice === undefined || parsedPrice === null) {
                console.error('ERROR: Invalid price value!', price);
                alert('Error: Invalid price data. Please refresh the page.');
                return;
            }

            console.log('Parsed price:', parsedPrice);

            // Calculate sale price with discount
            var salePrice = parsedPrice;
            var originalPrice = parsedPrice;
            var discount = parseFloat(productDiscount);

            if (isNaN(discount)) {
                console.error('ERROR: Invalid discount value!', productDiscount);
                discount = 0;
            }

            console.log('Discount value:', discount, 'Type:', productDiscountType);

            if (productDiscountType == 'fixed') {
                salePrice = parsedPrice - discount;
                console.log('Fixed discount:', parsedPrice, '-', discount, '=', salePrice);
            } else {
                // Apply percentage discount for any non-fixed type
                var discountAmount = (parsedPrice * discount) / 100;
                salePrice = parsedPrice - discountAmount;
                console.log('Percentage discount:', parsedPrice, '- (', parsedPrice, '*', discount, '/ 100) =', parsedPrice,
                    '-', discountAmount, '=', salePrice);
            }

            console.log('Final calculated prices - Sale:', salePrice, 'Original:', originalPrice);

            // Validate final prices
            if (isNaN(salePrice)) {
                console.error('ERROR: Sale price is NaN!');
                salePrice = parsedPrice; // Fallback to original price
            }

            // Update the display
            var salePriceFormatted = salePrice.toFixed(2);
            var originalPriceFormatted = originalPrice.toFixed(2);

            console.log('Formatted prices - Sale:', salePriceFormatted, 'Original:', originalPriceFormatted);
            console.log('About to update elements...');

            $(".product_rate_{{ $product->product_id }}").html(salePriceFormatted);
            $("#newdeprice").html(originalPriceFormatted);
            $("#yourcolors").html($("#product_color").val());

            console.log('After update - Sale price element:', $(".product_rate_{{ $product->product_id }}").html());
            console.log('After update - Original price element:', $("#newdeprice").html());
            console.log('=== updateVariantDetails END ===');

            // Reset quantity if needed
            var quantityInput = $('#quantity' + {{ $product->id }});
            if (parseInt(quantityInput.val()) > stock) {
                quantityInput.val(1);
            }
        }

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

        $(document).ready(function() {
            // Trigger click on the first available size button to initialize state
            var firstSizeBtn = $('.product-variant-size-button').first();
            if (firstSizeBtn.length > 0) {
                // We use the onclick attribute value or just call the function directly
                var size = firstSizeBtn.data('product-variant-size');
                productsizechange(size);
            }
        });

        function productcolorchange(vals) {

            $("#product_color").val(vals);

            $("#yourcolors").html(vals);
        }
    </script>

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script>
        // tippy('.product-variant-size-button', {
        //     content: 'My tooltip!',
        //   });
        tippy('.product-variant-size-button');
    </script>

@endsection

@section('script')
@endsection
