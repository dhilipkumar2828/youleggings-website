@extends('frontend.layouts.app')

@section('title', 'Shop | You Leggings')

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
        <span class="section-subtitle">Curated Picks</span>
        <h2 class="section-title">Shop Products</h2>
      </div>
      <div class="shop-layout">
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

        <div class="shop-products">
          <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card shop-product-card">
                  <a href="{{ route('product_detail', $product->slug) }}" style="text-decoration:none; color:inherit;">
                  <div class="product-image">
                    @php
                        $photo = $product->productvariant->first()->photo ?? '';
                        $photos = explode(',', $photo);
                    @endphp
                    <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}">
                  </div>
                  <div class="product-details shop-product-details">
                    <p class="shop-product-category">{{ $product->categories->title ?? 'Legging' }}</p>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="shop-product-bottom">
                      <div class="product-price">INR {{ number_format($product->regular_price) }}</div>
                      <span class="shop-product-link">View</span>
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
