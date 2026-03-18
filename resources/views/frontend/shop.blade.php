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
        <div class="shop-filter-overlay" id="shopFilterOverlay" onclick="toggleShopFilters()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 10004;"></div>
        
        <div class="mobile-filter-bar" style="display: none; margin-bottom: 20px;">
          <button type="button" class="btn filter-toggle-btn" onclick="toggleShopFilters()">
            <i data-lucide="filter" style="width: 18px; margin-right: 8px;"></i> FILTER
          </button>
        </div>

        <aside class="shop-filters" id="shopFilters">
          <div class="filter-header" style="display: none; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #f0dbe4; padding-bottom: 15px;">
            <h3 style="margin: 0; font-size: 20px; letter-spacing: 1px;">Filters</h3>
            <button type="button" onclick="toggleShopFilters()" style="background: none; border: none; cursor: pointer; color: #333;">
              <i data-lucide="x" style="width: 24px;"></i>
            </button>
          </div>
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
        
        {{ ucwords(strtolower($cat->title)) }}
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
                  <div class="product-image" style="position: relative; {{ request('new-arrivals') ? 'height: 380px; background: #f4f4f4;' : '' }}">
                    @php
                        $photo = $product->productvariant->first()->photo ?? '';
                        $photos = explode(',', $photo);
                    @endphp
                    <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    @php
                        $isInWishlist = Auth::check() && \App\Models\Wishlist::where('customer_id', Auth::id())->where('product_id', $product->id)->exists();
                    @endphp
                    <!-- Wishlist Button -->
                    <button type="button" class="wishlist-toggle-btn" onclick="toggleWishlist(event, {{ $product->id }})" style="position: absolute; top: 15px; right: 15px; background: rgba(255,255,255,0.95); border: 1px solid rgba(0,0,0,0.05); width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: {{ $isInWishlist ? '#ec407a' : '#555' }}; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.12); z-index: 10;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="{{ $isInWishlist ? '#ec407a' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                    </button>

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
                      <div class="product-price" style="font-size: 18px; font-weight: 700; color: #ec407a;">₹{{ number_format($sellingPrice) }}</div>
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
@section('scripts')
<script>
  // -- Wishlist Logic --
  function toggleWishlist(event, productId) {
      event.preventDefault();
      event.stopPropagation();
      
      fetch("{{ route('wishlist.add') }}", {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ product_id: productId })
      })
      .then(response => response.json())
      .then(data => {
          if(data.status === 'success' || data.status === 'info') {
              window.location.reload();
          } else {
              alert(data.msg);
              if(data.msg.includes('login')) {
                  window.location.href = "{{ route('login_user') }}";
              }
          }
      })
      .catch(error => console.error('Error:', error));
  }

  // Shop Filter Modal Logic
  function toggleShopFilters() {
      const filters = document.getElementById('shopFilters');
      const overlay = document.getElementById('shopFilterOverlay');
      filters.classList.toggle('active');
      const isActive = filters.classList.contains('active');
      overlay.style.display = isActive ? 'block' : 'none';
      document.body.classList.toggle('filter-open', isActive);
  }
</script>
@endsection
@endsection
