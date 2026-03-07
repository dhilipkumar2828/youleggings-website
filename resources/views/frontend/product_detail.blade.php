@extends('frontend.layouts.app')

@section('content')
  <!-- Product Detail Page -->
  <section class="section page-view product-page-active" style="display: block;">
    <div class="page-main product-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8984-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Product Details</span>
        <h1 class="hero-title">Buy Your <br>Perfect Fit</h1>
      </div>
    </div>

    <div class="container page-body">

      <div class="product-detail-layout">
        <div class="product-detail-gallery">
          <div class="product-detail-image-wrap">
            @php
                $photo = $product->productvariant->first()->photo ?? '';
                $photos = explode(',', $photo);
            @endphp
            <img id="productDetailImage" src="{{ asset('storage/'.$photos[0]) }}" alt="{{ $product->name }}">
          </div>
          <div class="product-thumb-row" id="productThumbRow">
            @foreach($photos as $p)
            <button class="product-thumb {{ $loop->first ? 'is-active' : '' }}" type="button"><img
                src="{{ asset('storage/'.$p) }}" alt="Product thumbnail"></button>
            @endforeach
          </div>
        </div>

        <div class="product-detail-content">
          <p class="product-detail-category">{{ $product->categories->title ?? 'Legging' }}</p>
          <h2 class="product-detail-title">{{ $product->name }}</h2>
          <p class="product-detail-meta">Quality Guaranteed</p>
          <div class="product-detail-price">INR {{ number_format($product->regular_price) }}</div>
          <p class="product-tax-line">Inclusive of all taxes</p>

          <div class="product-detail-block compact-block">
            {!! $product->description !!}
          </div>

          <div class="product-detail-actions compact-actions">
            <button id="productAddToCartBtn" type="button" class="btn" data-id="{{ $product->id }}">Add to Cart</button>
          </div>

          <div class="product-service-strip compact-service-strip">
            <div class="product-service-item compact-service-item">
              <i data-lucide="truck"></i>
              <h4>Free Shipping</h4>
            </div>
            <div class="product-service-item compact-service-item">
              <i data-lucide="badge-check"></i>
              <h4>Quality Mark</h4>
            </div>
            <div class="product-service-item compact-service-item">
              <i data-lucide="lock"></i>
              <h4>Secure Pay</h4>
            </div>
            <div class="product-service-item compact-service-item">
              <i data-lucide="rotate-ccw"></i>
              <h4>Easy Return</h4>
            </div>
          </div>
        </div>
      </div>

      <div class="product-tab-section"
        style="margin-top: 50px; background: #fff; padding: 30px; border-radius: 14px; box-shadow: 0 10px 24px rgba(125, 84, 101, 0.08); border: 1px solid #f0dbe4;">
        <div class="product-tab-nav" role="tablist" aria-label="Product Information Tabs">
          <button type="button" class="product-tab-btn is-active" data-tab-target="desc" role="tab"
            aria-selected="true">Description</button>
        </div>
        <div class="product-tab-panels">
          <div class="product-tab-panel is-active" data-tab-panel="desc">
            {!! $product->description !!}
          </div>
        </div>
      </div>

      <div class="related-products" style="margin-top: 80px;">
        <div class="text-center">
          <span class="section-subtitle">You May Also Like</span>
          <h2 class="section-title">Related Products</h2>
        </div>
        <div class="products-grid related-products-grid">
            @foreach($related_products as $rel)
            <div class="product-card shop-product-card">
              <a href="{{ route('product_detail', $rel->slug) }}">
              <div class="product-image">
                @php
                    $rel_photo = $rel->productvariant->first()->photo ?? '';
                    $rel_photos = explode(',', $rel_photo);
                @endphp
                <img src="{{ asset('storage/'.$rel_photos[0]) }}" alt="{{ $rel->name }}">
              </div>
              <div class="product-details shop-product-details">
                <p class="shop-product-category">{{ $rel->categories->title ?? 'Legging' }}</p>
                <h3 class="product-name">{{ $rel->name }}</h3>
                <div class="shop-product-bottom">
                  <div class="product-price">INR {{ number_format($rel->regular_price) }}</div>
                  <span class="shop-product-link">View</span>
                </div>
              </div>
              </a>
            </div>
            @endforeach
        </div>
      </div>
    </div>
  </section>
@endsection
