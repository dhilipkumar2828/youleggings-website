@extends('frontend.layouts.app')

@section('title', 'Shop | You Leggings')

@section('styles')
<style>
  .product-card:hover .view-product-overlay {
    opacity: 1 !important;
    transform: translateX(-50%) translateY(-10px) !important;
  }
  @if(request('new-arrivals'))
  .shop-product-card {
    background: #fff !important;
    border-radius: 12px !important;
    overflow: hidden !important;
    border: 1px solid #f0f0f0 !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important;
    transition: all 0.4s ease !important;
  }
  .shop-product-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
  }
  .shop-page .shop-products .products-grid {
    grid-template-columns: repeat(4, 1fr) !important;
    gap: 30px !important;
  }
  @media (max-width: 1199px) {
    .shop-page .shop-products .products-grid { grid-template-columns: repeat(3, 1fr) !important; }
  }
  @media (max-width: 991px) {
    .shop-page .shop-products .products-grid { grid-template-columns: repeat(2, 1fr) !important; }
  }
  @media (max-width: 575px) {
    .shop-page .shop-products .products-grid { grid-template-columns: 1fr !important; }
  }
  @endif
</style>
@endsection

@section('content')
  <!-- Shop Page -->
  <section class="section page-view shop-page" id="shop-page" style="display: block;">
    <div class="page-main shop-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8937-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Shop Collection</span>
        <h1 class="hero-title">Premium Leggings <br>For Every Move</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="text-center">
        <span class="section-subtitle">{{ request('new-arrivals') ? 'Just In' : 'Curated Picks' }}</span>
        <h2 class="section-title">{{ request('new-arrivals') ? 'Fresh Styles This Month' : 'Shop Products' }}</h2>
      </div>
      <div class="shop-layout" @if(request('new-arrivals')) style="display: block;" @endif>
        @if(!request('new-arrivals'))
        <aside class="shop-filters">
          <form action="{{ route('shop') }}" method="GET" id="shopFilterForm">
              <div class="filter-group">
                <h3>Price Filter</h3>
                <p class="filter-range">&#8377;0 — &#8377;{{ request('max_price', 2500) }}</p>
                <input type="range" name="max_price" min="0" max="2500" value="{{ request('max_price', 2500) }}" onchange="this.form.submit()">
              </div>

              <div class="filter-group">
                <h3>Categories</h3>
                <ul class="filter-list">
                  @foreach($categories as $cat)
                    <li>
                        <label>
                            <input type="checkbox" name="category[]" value="{{ $cat->id }}" 
                            {{ in_array($cat->id, (array)request('category', [])) ? 'checked' : '' }} 
                            onchange="this.form.submit()"> 
                            {{ strtoupper($cat->title) }}
                        </label>
                    </li>
                  @endforeach
                </ul>
              </div>

              <div class="filter-group">
                <h3>Sort</h3>
                <ul class="filter-list">
                  <li><label><input type="radio" name="sort" value="discount" onchange="this.form.submit()" {{ request('sort') == 'discount' ? 'checked' : '' }}> Discount</label></li>
                  <li><label><input type="radio" name="sort" value="price" onchange="this.form.submit()" {{ request('sort') == 'price' ? 'checked' : '' }}> Price</label></li>
                </ul>
              </div>

              <div class="filter-group">
                <h3>Availability</h3>
                <ul class="filter-list">
                  <li><label><input type="checkbox" name="availability[]" value="in_stock" onchange="this.form.submit()" {{ in_array('in_stock', (array)request('availability', [])) ? 'checked' : '' }}> In Stock</label></li>
                  <li><label><input type="checkbox" name="availability[]" value="out_of_stock" onchange="this.form.submit()" {{ in_array('out_of_stock', (array)request('availability', [])) ? 'checked' : '' }}> Out of Stock</label></li>
                </ul>
              </div>

              <div class="filter-group">
                <h3>Size</h3>
                <ul class="filter-list filter-size">
                  @foreach($all_sizes as $size)
                    <li>
                        <label>
                            <input type="checkbox" name="size[]" value="{{ $size }}" 
                            {{ in_array($size, (array)request('size', [])) ? 'checked' : '' }} 
                            onchange="this.form.submit()"> 
                            {{ strtoupper($size) }}
                        </label>
                    </li>
                  @endforeach
                </ul>
              </div>
              <a href="{{ route('shop') }}" class="shop-clear-filters text-center" style="display:block; text-decoration:none;">Clear Filters</a>
          </form>
        </aside>
        @endif

        <div class="shop-products" @if(request('new-arrivals')) style="width: 100%;" @endif>
          <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card shop-product-card">
                  <a href="{{ route('product_detail', $product->slug) }}" style="text-decoration:none; color:inherit;">
                  <div class="product-image" @if(request('new-arrivals')) style="height: 380px; position: relative; background: #f4f4f4;" @endif>
                    @php
                        $photo = $product->productvariant->first()->photo ?? '';
                        $photos = explode(',', $photo);
                    @endphp
                    <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @if(request('new-arrivals'))
                      <div class="view-product-overlay" style="position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%); background: #fff; color: #333; padding: 14px 28px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; border-radius: 50px; transition: 0.3s; opacity: 0; white-space: nowrap; z-index: 5; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">View Product</div>
                    @endif
                  </div>
                  <div class="product-details shop-product-details" style="padding: 15px; text-align: center; background: #fff;">
                    <p class="shop-product-category" style="font-size: 10px; color: #ec407a; text-transform: uppercase; font-weight: 700; letter-spacing: 2px; margin-bottom: 4px;">{{ request('new-arrivals') ? 'New Arrival' : ($product->categories->title ?? 'Legging') }}</p>
                    <h3 class="product-name" style="font-family: var(--font-serif, serif); font-size: 18px; color: #222; margin-bottom: 15px; font-weight: 500;">{{ $product->name }}</h3>
                    <div class="shop-product-bottom" style="display: flex; justify-content: space-between; align-items: center; padding-top: 0;">
                      @php
                        $regularPrice = $product->regular_price ?? 0;
                        $discount = $product->discount ?? 0;
                        $sellingPrice = $regularPrice;
                        if($discount > 0) {
                            if($product->discount_type == 'percent') {
                                $sellingPrice = $regularPrice - ($regularPrice * $discount / 100);
                            } else {
                                $sellingPrice = $regularPrice - $discount;
                            }
                        }
                      @endphp
                      <div class="product-price" style="font-size: 18px; font-weight: 700; color: #ec407a;">INR {{ number_format($sellingPrice) }}</div>
                      <span class="shop-product-link" style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #ec407a; border: 1px solid #fdeef2; padding: 10px 20px; border-radius: 4px; background: #fff;">{{ request('new-arrivals') ? 'BUY NOW' : 'VIEW' }}</span>
                    </div>
                  </div>
                  </a>
                </div>
            @empty
                <div class="text-center w-full py-5">
                    <h3>No products found matching your filters.</h3>
                </div>
            @endforelse
          </div>

          <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $products->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
