@extends('frontend.layouts.app')

@section('content')

  <!-- Hero Section -->
  <section class="hero home-page-section" id="home">
    @if(count($banners) > 0)
      @foreach($banners as $banner)
        @php $is_video = Str::endsWith($banner->photo, ['.mp4', '.webm', '.ogg']); @endphp
        @if($is_video)
          <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('storage/'.$banner->photo) }}" type="video/mp4">
          </video>
        @else
          <div class="hero-image" style="background-image: url('{{ asset('storage/'.$banner->photo) }}'); background-size: cover; background-position: center; height: 100vh; width: 100%;"></div>
        @endif
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <span class="hero-subtitle">{{ $banner->subtitle ?? 'Premium Collection '.date('Y') }}</span>
          <h1 class="hero-title">{!! nl2br(e($banner->title)) !!}</h1>
          @if($banner->link)
            <a href="{{ $banner->link }}" class="btn hero-btn">Shop The Collection</a>
          @else
            <a href="{{ route('shop') }}" class="btn hero-btn">Shop The Collection</a>
          @endif
        </div>
      @endforeach
    @else
    <video class="hero-video" autoplay muted loop playsinline>
      <source src="{{ asset('frontend/videos/LEGGINGS.mp4') }}" type="video/mp4">
      Your browser does not support the video tag.
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <span class="hero-subtitle">Premium Collection {{ date('Y') }}</span>
      <h1 class="hero-title">Experience <br>True Comfort</h1>
      <a href="{{ route('shop') }}" class="btn hero-btn">Shop The Collection</a>
    </div>
    @endif
  </section>

  <!-- Collections Section -->
  <section class="section home-page-section" id="shop">
    <div class="container">
      <div class="text-center">
        <span class="section-subtitle">Our Range</span>
        <h2 class="section-title">Collections</h2>
        <div class="divider"></div>
      </div>

      <div class="products-grid">
        @foreach($categories as $category)
        <a href="{{ route('shop', ['category' => $category->id]) }}" class="product-card">
          <div class="product-image">
            <img src="{{ asset('storage/'.$category->photo) }}" alt="{{ $category->title }}">
          </div>
          <div class="product-details">
            <h3 class="product-name">{{ $category->title }}</h3>
            <div class="product-price">Shop Range</div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Featured Products Section -->
  <section class="section home-page-section" id="featured">
    <div class="container">
      <div class="text-center">
        <span class="section-subtitle">Latest Drop</span>
        <h2 class="section-title">Featured Products</h2>
        <div class="divider"></div>
      </div>

      <div class="products-grid">
        @foreach($featured_products as $product)
        <div class="product-card">
          <div class="product-image">
            @php
              $photo = $product->productvariant->first()->photo ?? '';
              $photos = explode(',', $photo);
            @endphp
            <img src="{{ asset('storage/'.($photos[0] ?? '')) }}" alt="{{ $product->name }}">
          </div>
          <div class="product-details">
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="product-price">
              @if($product->selling_price < $product->regular_price)
                ₹ {{ number_format($product->selling_price, 0) }} 
                <span class="product-old-price">₹ {{ number_format($product->regular_price, 0) }}</span>
              @else
                ₹ {{ number_format($product->regular_price, 0) }}
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="text-center" style="margin-top: 30px;">
        <a href="{{ route('shop') }}" class="btn">View All Collections</a>
      </div>
    </div>
  </section>

  <!-- Split Banner -->
  <section class="section home-page-section" style="padding: 0; margin-top: 100px;">
    <div class="split-banner">
      <div class="split-content">
        <span class="section-subtitle" style="margin-bottom: 15px;">Limited Edition</span>
        <h2 class="split-title">The Art of <br>Comfort</h2>
        <p class="split-desc">
          Discover a collection of premium leggings that feel like a second skin. Each piece is meticulously crafted
          with precision and designed to move with you effortlessly.
        </p>
        <div>
          <a href="{{ route('shop') }}" class="btn">Explore Shop</a>
        </div>
      </div>
      <div class="split-image" style="background-image: url('{{ asset('frontend/images/Products/_DSC8716-Edit.jpg') }}'); border: none;"></div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="section home-page-section" style="background-color: #fff;">
    <div class="container">
      <div class="text-center">
        <span class="section-subtitle">Testimonials</span>
        <h2 class="section-title">What Our Customers Say</h2>
      </div>

      <div class="container">
        <div class="testimonials-carousel-wrap">
          <div class="testimonials-carousel" id="testimonialsCarousel">
            @forelse($testimonials as $testimonial)
            <div class="testimonial-card">
              <div class="quote-icon">“</div>
              <p class="testimonial-text">{{ $testimonial->feedback ?? $testimonial->comment }}</p>
              <div class="client-name">{{ $testimonial->client_name ?? $testimonial->name }}</div>
              <div style="font-size: 12px; color: #999; margin-top: 5px;">Happy Client</div>
              <div style="color: #f59e0b; margin-top: 10px;">
                @for($i=0; $i<($testimonial->rating ?? 5); $i++)★@endfor
              </div>
            </div>
            @empty
            <div class="testimonial-card">
              <div class="quote-icon">“</div>
              <p class="testimonial-text">Very good fabric and reasonable price. I am very satisfied to purchase.</p>
              <div class="client-name">Jeyanthi RK</div>
              <div style="font-size: 12px; color: #999; margin-top: 5px;">Happy Client</div>
              <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
            </div>
            @endforelse
          </div>

          <div class="testimonial-dots" id="testimonialDots"
            style="display: flex; justify-content: center; gap: 10px; margin-top: 30px; padding-bottom: 20px;">
            @foreach($testimonials as $index => $testimonial)
            <button class="testimonial-dot {{ $loop->first ? 'is-active' : '' }}" data-index="{{ $index }}" aria-label="Testimonial {{ $index + 1 }}"></button>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
