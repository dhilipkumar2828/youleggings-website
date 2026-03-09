@extends('frontend.layouts.app')

@section('content')
  <!-- Shop Page -->
  <section class="section page-view shop-page-active" style="display: block;">
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
          <form action="{{ route('shop') }}" method="GET">
            <div class="filter-group">
                <h3>Categories</h3>
                <ul class="filter-list">
                    @foreach($categories as $category)
                    <li><label><input type="checkbox" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, (array) request('category', [])) ? 'checked' : '' }} onchange="this.form.submit()"> {{ $category->title }}</label></li>
                    @endforeach
                </ul>
            </div>
          </form>
        </aside>

        <div class="shop-products">
          <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card shop-product-card">
              <a href="{{ route('product_detail', $product->slug) }}">
              <div class="product-image">
                @php
                    $photo = $product->productvariant->first()->photo ?? '';
                    $photos = explode(',', $photo);
                @endphp
                <img src="{{ asset('storage/'.$photos[0]) }}" alt="{{ $product->name }}">
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
            @endforeach
          </div>

          <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $products->links() }}
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
