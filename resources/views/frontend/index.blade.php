@extends('frontend.layouts.app')

@section('title', 'You Leggings | Premium Comfort')

@section('content')

  <!-- Hero Section -->
  <section class="hero home-page-section" id="home">
    @if($banners->isNotEmpty())
        @foreach($banners as $banner)
            <div class="hero-slide {{ $loop->first ? 'active' : '' }}">
                <img src="{{ image_url($banner->photo) }}" class="hero-image" alt="{{ $banner->title }}">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <span class="hero-subtitle">{{ $banner->subtitle }}</span>
                    <h1 class="hero-title">{!! nl2br(e($banner->title)) !!}</h1>
                    @if($banner->link)
                        <a href="{{ $banner->link }}" class="btn hero-btn">Explore Now</a>
                    @else
                        <a href="{{ route('shop') }}" class="btn hero-btn">Explore Now</a>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <!-- Static Video Hero Fallback -->
        <video class="hero-video" autoplay muted loop playsinline>
          <source src="{{ asset('frontend/videos/LEGGINGS.mp4') }}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <span class="hero-subtitle">Premium Collection 2026</span>
          <h1 class="hero-title">Experience <br>True Comfort</h1>
          <a href="{{ route('shop') }}" class="btn hero-btn">Shop The Collection</a>
        </div>
    @endif
  </section>

  <!-- Collections Section -->
  <section class="section home-categories-section" id="collections">
    <div class="container">
      <div class="text-center section-header">
        <span class="section-subtitle">Our Range</span>
        <h2 class="section-title">Collections</h2>
        <div class="header-divider"></div>
      </div>

      <div class="products-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px 30px;">
        @forelse($categories as $category)
            <a href="{{ route('shop', ['category[]' => $category->id]) }}" class="product-card" style="border: none; box-shadow: none; text-align: center; background: transparent;">
              <div class="product-image" style="height: 420px; border-radius: 16px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                <img src="{{ $category->photo ? image_url($category->photo) : asset('frontend/images/Products/_DSC8742-Edit.jpg') }}" alt="{{ $category->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
              </div>
              <div class="product-details" style="padding: 0;">
                <h3 class="product-name" style="font-size: 26px; font-family: var(--font-serif); margin-bottom: 12px; color: #333;">{{ $category->title }}</h3>
                <div class="product-price" style="color: var(--primary-color); font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; font-size: 13px;">
                    Explore Collection <i data-lucide="arrow-right" style="width: 16px; height: 16px; vertical-align: middle; margin-left: 6px;"></i>
                </div>
              </div>
            </a>
        @empty
            <!-- Fallback Category Cards -->
            @for($i=1; $i<=3; $i++)
            <a href="{{ route('shop') }}" class="product-card" style="border: none; box-shadow: none; text-align: center; background: transparent;">
              <div class="product-image" style="height: 420px; border-radius: 16px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
                <img src="{{ asset('frontend/images/Products/_DSC8742-Edit.jpg') }}" alt="Men's Collection" style="width: 100%; height: 100%; object-fit: cover;">
              </div>
              <div class="product-details" style="padding: 0;">
                <h3 class="product-name" style="font-size: 26px; font-family: var(--font-serif); margin-bottom: 12px; color: #333;">Collection {{ $i }}</h3>
                <div class="product-price" style="color: var(--primary-color); font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; font-size: 13px;">
                    Explore Collection <i data-lucide="arrow-right" style="width: 16px; height: 16px; vertical-align: middle; margin-left: 6px;"></i>
                </div>
              </div>
            </a>
            @endfor
        @endforelse
      </div>
    </div>
  </section>

  <!-- Featured Products Section -->
  <section class="section home-page-section" id="featured">
    <div class="container">
      <div class="text-center">
        <span class="section-subtitle">Trending Now</span>
        <h2 class="section-title">Featured Products</h2>
        <div class="divider"></div>
      </div>

      <div class="products-grid">
        @forelse($featured_products as $product)
            @php
                $photo = $product->productvariant->first()->photo ?? '';
                $photos = explode(',', $photo);
            @endphp
            <a href="{{ route('product_detail', $product->slug) }}" class="product-card">
              <div class="product-image">
                <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}">
              </div>
              <div class="product-details">
                <p class="product-card-category" style="font-size: 12px; color: var(--primary-color); text-transform: uppercase; font-weight: 700; letter-spacing: 1.2px; margin-bottom: 6px;">{{ $product->categories->title ?? 'Legging' }}</p>
                <h3 class="product-name">{{ $product->name }}</h3>
                <div class="product-price">INR {{ number_format($product->regular_price) }}</div>
              </div>
            </a>
        @empty
            <p class="text-center w-full">Coming Soon...</p>
        @endforelse
      </div>
      
      <div class="text-center" style="margin-top: 50px;">
        <a href="{{ route('shop') }}" class="btn">View All Products</a>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  @if($testimonials->isNotEmpty())
    <section class="section home-page-section testimonials" id="testimonials">
      <div class="container">
        <div class="text-center">
          <span class="section-subtitle">What They Say</span>
          <h2 class="section-title">Customer Reviews</h2>
          <div class="divider"></div>
        </div>
        <div class="testimonials-slider">
          @foreach($testimonials as $test)
          <div class="testimonial-card">
            <p>"{{ $test->feedback }}"</p>
            <h4>- {{ $test->name }}</h4>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

@endsection

@section('scripts')
<script>
  // Homepage specific scripts (if any)
</script>
@endsection