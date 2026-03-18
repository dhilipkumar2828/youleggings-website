@extends('frontend.layouts.app')

@section('title', 'You Leggings | Premium Comfort')

@section('styles')
<style>
  /* Hero Slider Fixes */
  .hero-slider-container {
    position: relative;
    width: 100%;
    height: 600px;
    overflow: hidden;
    background: #9f9f9f; /* Exact grey from the 2nd reference image */
  }
  .hero-slide {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    opacity: 0;
    visibility: hidden;
    transition: opacity 1s ease-in-out, visibility 1s;
    display: flex;
    align-items: center;
    justify-content: center; /* Center horizontally overall */
    padding: 0;
  }
  .hero-slide.active {
    opacity: 1;
    visibility: visible;
    z-index: 10;
  }
  .hero-image {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    object-fit: contain; 
    object-position: 85% center; /* Precisely aligns the model to the right quadrant */
    z-index: 0;
  }
  .hero-video {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    object-fit: contain;
    object-position: 85% center;
    z-index: 0;
  }
  .hero-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    /* Very light radial gradient or nothing. The image 2 has no visible dark gradient overlay. */
    background: transparent;
    z-index: 1;
  }
  
  .hero-content-wrapper {
    /* New wrapper to place content over the background image correctly */
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1200px; /* Standard container width */
    margin: 0 auto;
    padding: 0 15px;
    display: flex;
    justify-content: flex-start; /* Align left within container */
  }
  
  .hero-content {
    color: #333; 
    max-width: 500px;
    text-align: left; 
    padding-left: 20px; /* Slight inset for alignment with logo/menu */
  }
  .hero-subtitle {
    font-size: 13px;
    letter-spacing: 5px;
    text-transform: uppercase;
    margin-bottom: 30px;
    display: block;
    color: #444;
    font-weight: 600;
  }
  .hero-title {
    font-size: clamp(3.5rem, 6vw, 5.5rem); /* Huge font matching the layout */
    font-family: var(--font-serif, serif);
    line-height: 1.1;
    margin-bottom: 40px;
    color: #333;
    font-style: italic;
    font-weight: 400;
  }
  .hero-controls {
    position: absolute;
    bottom: 25px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 11;
    display: flex;
    gap: 12px;
  }
  .hero-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: rgba(0,0,0,0.2);
    cursor: pointer;
    transition: 0.3s;
  }
  .hero-dot.active { background: #333; transform: scale(1.2); }

  @media (max-width: 768px) {
    .hero-slider-container {
      height: 450px;
    }
    .hero-image, .hero-video {
      object-position: center center;
    }
    .hero-content {
      text-align: center;
      padding-left: 0;
      margin: 0 auto;
    }
    .hero-content-wrapper {
      justify-content: center;
    }
    .hero-title {
      font-size: 2.2rem !important;
      margin-bottom: 20px !important;
    }
    .hero-subtitle {
      font-size: 11px !important;
      letter-spacing: 2px !important;
      margin-bottom: 10px !important;
    }
  }

  .hero-btn {
    padding: 16px 35px;
    background: #333;
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 4px;
    font-size: 13px;
    display: inline-block;
    transition: 0.3s;
  }
  .hero-btn:hover {
    background: #ec407a;
    color: #fff;
    transform: translateY(-3px);
  }

  /* Premium Grid Fixes */

/* Featured Products Slider (Ultra-Strict Mobile Fix) */
.featured-slider-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

@media (max-width: 900px) {
    .featured-slider-grid {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        scroll-snap-type: x mandatory !important;
        -webkit-overflow-scrolling: touch !important;
        gap: 0 !important;
        margin: 0 -15px !important;
        padding: 10px 0 20px 0 !important;
        width: auto !important;
        list-style: none !important;
    }

    .featured-slider-grid::-webkit-scrollbar {
        display: none !important;
    }

    .featured-slider-grid .product-card {
        flex: 0 0 100% !important;
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
        scroll-snap-align: center !important;
        margin: 0 !important;
        padding: 0 15px !important;
        display: block !important;
        box-sizing: border-box !important;
    }

    .slider-nav-btns {
        display: flex !important;
        margin-top: 15px;
        justify-content: space-between;
        position: relative;
        bottom: 320px;
        gap: 20px;
    }
}

.slider-nav-btns {
    display: none;
}

.nav-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #fff;
    border: 1px solid #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
    color: #333;
}

.nav-btn:hover {
    background: #ec407a;
    color: #fff;
}
  
  /* Curated Collections Slider */
  .premium-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 30px;
    justify-content: center;
  }
  .collection-card {
    display: block;
    text-align: center;
    text-decoration: none;
    transition: transform 0.4s ease;
    background: #fbf9fa;
    border-radius: 12px;
    padding-bottom: 25px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
  }
  .collection-card:hover { transform: translateY(-8px); }
  .collection-image-wrap {
    height: 380px;
    margin-bottom: 20px;
    position: relative;
    background: #f4f4f4;
  }
  .collection-image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
  .collection-name { font-size: 22px; font-family: var(--font-serif, serif); color: #222; margin-bottom: 8px; font-weight: 600; }
  .collection-btn { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #ec407a; display: inline-flex; align-items: center; gap: 6px; }

  .collections-nav-btns { display: none; }

  @media (max-width: 900px) {
    .collections-carousel-wrap { overflow: hidden; position: relative; width: 100%; }
    .premium-grid {
      display: flex !important;
      flex-wrap: nowrap !important;
      transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      gap: 20px !important;
      padding: 10px 0;
      width: 100%;
    }
    .collection-card {
      flex: 0 0 calc(50% - 10px);
      min-width: 0;
    }
    .collections-nav-btns {
      display: flex;
      justify-content: space-between;
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      transform: translateY(-50%);
      pointer-events: none;
      z-index: 10;
      padding: 0 5px;
    }
    .collections-nav-btns button {
      pointer-events: auto;
      background: #fff;
      border: 1px solid #eee;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      font-size: 16px;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      color: #333;
    }
    .collections-nav-btns button:disabled { opacity: 0; cursor: default; }
  }
  
  @media (max-width: 600px) {
    .collection-card { flex: 0 0 100%; }
    .collection-image-wrap { height: 320px; }
  }

  /* Testimonials Improvements */
  .testimonials-section {
    padding: 100px 0;
    background: #fdf7f9;
  }
  .testimonials-carousel-wrap {
    overflow: hidden;
    position: relative;
    padding: 10px 0 40px;
  }
  .testimonials-carousel {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    gap: 30px;
  }
  .testimonial-card {
    flex: 0 0 calc(33.333% - 20px);
    background: #fff;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    border: 1px solid #f9f9f9;
    text-align: center;
    position: relative;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 280px;
  }
  @media (max-width: 991px) {
    .testimonial-card { flex: 0 0 calc(50% - 15px); }
  }
  @media (max-width: 767px) {
    .testimonial-card { flex: 0 0 100%; }
    .testimonials-carousel { gap: 0; }
  }
  .quote-icon {
    font-size: 60px;
    color: #ffd1dc;
    line-height: 1;
    font-family: serif;
    margin-bottom: -10px;
    opacity: 0.6;
  }
  .testimonial-text {
    font-size: 16px;
    font-style: italic;
    color: #555;
    line-height: 1.8;
    margin-bottom: 25px;
  }
  .client-name {
    color: #333;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
    margin-bottom: 5px;
  }
  .testimonial-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #eee;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    padding: 0;
  }
  .testimonial-dot.is-active {
    background: #ec407a;
    width: 10px;
    border-radius: 10px;
  }

  /* Split Banner Base Styles */
  .split-banner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 600px;
    background: #fff;
    overflow: hidden;
  }
  .split-content {
    background: #fbf9fa;
    padding: 10% 12%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
  }
  .split-subtitle {
    color: var(--primary-color, #c18b95);
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    font-size: 12px;
    margin-bottom: 20px;
  }
  .split-title {
    font-family: var(--font-serif, serif);
    font-size: 3.5rem;
    line-height: 1.1;
    margin-bottom: 25px;
    color: #333;
    font-style: italic;
  }
  .split-desc {
    font-size: 16px;
    line-height: 1.8;
    color: #666;
    margin-bottom: 40px;
    max-width: 450px;
  }
  .split-btn {
    padding: 16px 40px;
    background: #333;
    color: #fff;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: none;
    display: inline-block;
    transition: 0.3s;
  }
  .split-btn:hover {
    background: #ec407a;
    color: #fff;
  }
  .split-image {
    background-image: url('{{ asset('frontend/images/Products/_DSC8723-Edit.jpg') }}');
    background-size: cover;
    background-position: center;
    transition: transform 1.5s ease;
  }
  .split-image:hover {
    transform: scale(1.05);
  }

  /* Split Banner Responsive */
  @media (max-width: 768px) {
    .split-banner {
      grid-template-columns: 1fr !important;
      min-height: auto !important;
    }
    .split-content {
      padding: 60px 25px !important;
      text-align: center;
      order: 2;
    }
    .split-image {
      min-height: 380px !important;
      order: 1;
    }
    .split-title {
      font-size: 2rem !important;
      margin-bottom: 20px !important;
    }
    .split-desc {
      margin: 0 auto 30px !important;
      max-width: 100% !important;
    }
  }


  /* Testimonials Section Heading */
  @media (max-width: 768px) {
    .testimonials-section {
      padding: 60px 0 !important;
    }
    .testimonials-section .section-title {
      font-size: 2.22rem !important;
      line-height: 1.2 !important;
    }
    .testimonials-section .section-subtitle {
       letter-spacing: 2px !important;
       margin-bottom: 10px !important;
    }
  }

  /* Collection Grid Fix */
  @media (max-width: 576px) {
    .collection-image-wrap {
      height: 280px;
    }
    .home-categories-section .premium-grid {
       grid-template-columns: 1fr !important;
       padding: 0 10px;
    }
  }
</style>



@endsection

@section('content')

  <!-- Hero Section -->
  <section class="hero-slider-container" id="home">
    @if($banners && $banners->isNotEmpty())
        @foreach($banners as $index => $banner)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                @if($banner->photo && preg_match('/\.(mp4|mov|ogg|qt)$/i', $banner->photo))
                    <video class="hero-video" autoplay muted loop playsinline>
                        <source src="{{ image_url($banner->photo) }}" type="video/{{ pathinfo($banner->photo, PATHINFO_EXTENSION) == 'mov' ? 'quicktime' : pathinfo($banner->photo, PATHINFO_EXTENSION) }}">
                    </video>
                @else
                    <img src="{{ image_url($banner->photo) }}" class="hero-image" alt="{{ $banner->title }}">
                @endif
                <div class="hero-overlay"></div>
                
                <div class="hero-content-wrapper">
                    <div class="hero-content">
                        <span class="hero-subtitle">{{ $banner->subtitle ?? 'Premium Selection' }}</span>
                        <h1 class="hero-title">{!! nl2br(e($banner->title)) !!}</h1>
                        <a href="{{ $banner->link ?: route('shop') }}" class="btn hero-btn">Explore Collection</a>
                    </div>
                </div>
            </div>
        @endforeach
        
        <!-- Controls -->
        @if($banners->count() > 1)
        <div class="hero-controls">
            @foreach($banners as $index => $banner)
                <div class="hero-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToHeroSlide({{ $index }})"></div>
            @endforeach
        </div>
        @endif
    @else
        <!-- Static Video Hero Fallback -->
        <div class="hero-slide active">
            <video class="hero-video" autoplay muted loop playsinline>
                <source src="{{ asset('frontend/videos/LEGGINGS.mp4') }}" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-content-wrapper">
                <div class="hero-content">
                    <span class="hero-subtitle">Premium Collection 2026</span>
                    <h1 class="hero-title">Experience <br>True Comfort</h1>
                    <a href="{{ route('shop') }}" class="btn hero-btn">Shop The Collection</a>
                </div>
            </div>
        </div>
    @endif
  </section>

  <section class="section home-categories-section" id="collections" style="padding: 80px 0; background: #fff;">
    <div class="container">
      <div class="text-center section-header" style="margin-bottom: 50px;">
        <span class="section-subtitle" style="color: var(--primary-color, #c18b95); font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 10px;">Our Range</span>
        <h2 class="section-title" style="font-family: var(--font-serif, serif); font-size: 2.5rem; margin-bottom: 20px;">Curated Collections</h2>
        <div class="header-divider" style="width: 60px; height: 2px; background: var(--primary-color, #c18b95); margin: 0 auto;"></div>
      </div>

      <div class="collections-carousel-wrap">
        <div class="premium-grid" id="collectionsCarousel">
          @forelse($categories as $category)
              <a href="{{ route('shop', ['category[]' => $category->id]) }}" class="collection-card">
                <div class="collection-image-wrap">
                  <img src="{{ $category->photo ? image_url($category->photo) : '' }}" alt="{{ $category->title }}">
                </div>
                <h3 class="collection-name">{{ $category->title }}</h3>
                <div class="collection-btn">
                    Explore <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
              </a>
          @empty
              <p style="text-align: center; width: 100%;">No Collections Found</p>
          @endforelse
        </div>

        <div class="collections-nav-btns">
            <button onclick="slideColCarousel(-1)" class="prev-col-btn"><i data-lucide="chevron-left"></i></button>
            <button onclick="slideColCarousel(1)" class="next-col-btn"><i data-lucide="chevron-right"></i></button>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Products Section -->
  <section class="section home-page-section" id="featured" style="padding: 80px 0; background: #fbf9fa;">
    <div class="container">
      <div class="text-center" style="margin-bottom: 50px;">
        <span class="section-subtitle" style="color: var(--primary-color, #c18b95); font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 10px;">Trending Now</span>
        <h2 class="section-title" style="font-family: var(--font-serif, serif); font-size: 2.5rem; margin-bottom: 20px;">Featured Products</h2>
        <div class="divider" style="width: 60px; height: 2px; background: var(--primary-color, #c18b95); margin: 0 auto;"></div>
      </div>

      <div class="featured-slider-grid" id="featured-slider">
        @forelse($featured_products as $product)
            @php
                $photo = $product->productvariant->first()->photo ?? '';
                $photos = $photo ? explode(',', $photo) : [''];
            @endphp
            <a href="{{ route('product_detail', $product->slug) }}" class="product-card" style="background: #fff; padding: 15px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); text-align: center; display: block; text-decoration: none; transition: 0.3s; border: 1px solid transparent;">
              <div class="product-image" style="height: 320px; border-radius: 8px; overflow: hidden; margin-bottom: 20px;">
                <img src="{{ image_url($photos[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: 0.5s;">
              </div>
              <div class="product-details">
                <p class="product-card-category" style="font-size: 11px; color: var(--primary-color, #c18b95); text-transform: uppercase; font-weight: 700; letter-spacing: 1.2px; margin-bottom: 8px;">{{ $product->categories->title ?? 'Leggings' }}</p>
                <h3 class="product-name" style="font-size: 18px; color: #333; margin-bottom: 12px; font-weight: 600;">{{ $product->name }}</h3>
                <div class="product-pricing" style="display: flex; align-items: center; justify-content: center; gap: 12px;">
                  @php
                    $regularPrice = $product->regular_price ?? 0;
                    $discount = $product->discount ?? 0;
                    $sellingPrice = $regularPrice;
                    if($discount > 0) {
                        if($product->discount_type == 'percent' || $product->discount_type == 'percentage') {
                            $sellingPrice = $regularPrice - ($regularPrice * $discount / 100);
                        } else {
                            $sellingPrice = $regularPrice - $discount;
                        }
                    }
                  @endphp
                  <span class="selling-price" style="font-size: 22px; font-weight: 700; color: #ec407a;">₹ {{ number_format($sellingPrice) }}</span>
                  @if($discount > 0)
                    <span class="regular-price" style="font-size: 15px; text-decoration: line-through; color: #bbbbbb; font-weight: 400;">₹ {{ number_format($regularPrice) }}</span>
                  @endif
                </div>
              </div>
              <!-- Wishlist Button -->
              <button type="button" class="wishlist-toggle-btn" onclick="toggleWishlist(event, {{ $product->id }})" style="position: absolute; top: 25px; right: 25px; background: rgba(255,255,255,0.9); border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #888; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
              </button>
            </a>
        @empty
            <p class="text-center" style="width: 100%; padding: 40px; color: #888;">Discoveries coming soon...</p>
        @endforelse
      </div>

      <!-- Navigation Arrows for Mobile Slider -->
      <div class="slider-nav-btns">
        <button class="nav-btn prev" onclick="slideFeatured(-1)">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <button class="nav-btn next" onclick="slideFeatured(1)">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>
      </div>
      
      <div class="text-center" style="margin-top: 60px;">
        <a href="{{ route('shop') }}" class="btn" style="padding: 15px 40px; background: #222; color: #fff; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; border-radius: 4px;">View All Products</a>
      </div>
    </div>
  </section>

  <!-- Split Banner Section (Editorial Style) -->
  <section class="split-banner">
    <div class="split-content">
      <span class="section-subtitle split-subtitle">Limited Edition</span>
      <h2 class="split-title">The Art of <br>Comfort</h2>
      <p class="split-desc">
        Discover a collection of premium leggings that feel like a second skin. Meticulously crafted for movement and designed for the modern woman.
      </p>
      <div>
        <a href="{{ route('shop') }}" class="btn split-btn">Explore Collection</a>
      </div>
    </div>
    <div class="split-image"></div>
  </section>

    <section class="section testimonials-section" id="testimonials">
      <div class="container">
        <div class="text-center" style="margin-bottom: 40px;">
          <span class="section-subtitle" style="color: #ec407a; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 15px;">Testimonials</span>
          <h2 class="section-title" style="font-family: var(--font-serif, serif); font-size: 3rem; color: #333; font-style: italic;">What Our Customers Say</h2>
        </div>

        <div class="testimonials-carousel-wrap">
          <div class="testimonials-carousel" id="testimonialsCarousel">
            @if(isset($testimonials) && count($testimonials) > 0)
                @foreach($testimonials as $test)
                <div class="testimonial-card">
                  <div class="quote-icon">“</div>
                  <p class="testimonial-text">{{ $test->feedback }}</p>
                  <div class="client-name">{{ $test->name }}</div>
                  <div style="font-size: 12px; color: #999; margin-top: 5px;">Happy Client</div>
                  <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
                </div>
                @endforeach
            @else
                {{-- Fallback static testimonials if database is empty --}}
                <div class="testimonial-card">
                  <div class="quote-icon">“</div>
                  <p class="testimonial-text">Very good fabric and reasonable price. I am very satisfied to purchase.</p>
                  <div class="client-name">Jeyanthi RK</div>
                  <div style="font-size: 12px; color: #999; margin-top: 5px;">Happy Client</div>
                  <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
                </div>
                <div class="testimonial-card">
                  <div class="quote-icon">“</div>
                  <p class="testimonial-text">Very reasonable price, nice collections also. Jeni sister also very patience with the customers.</p>
                  <div class="client-name">CSJ Deepa</div>
                  <div style="font-size: 12px; color: #999; margin-top: 5px;">Happy Client</div>
                  <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
                </div>
                <div class="testimonial-card">
                  <div class="quote-icon">“</div>
                  <p class="testimonial-text">Absolutely amazing fit and the material is super soft. Will definitely buy again!</p>
                  <div class="client-name">Priya S.</div>
                  <div style="font-size: 12px; color: #999; margin-top: 5px;">Happy Client</div>
                  <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
                </div>
            @endif
          </div>

          <div class="testimonial-dots" id="testimonialDots" style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;">
            {{-- Dots will be generated via JS to be dynamic based on screen size --}}
          </div>
        </div>
      </div>
    </section>

@endsection

@section('scripts')
<script>
  // -- Hero Slider Logic --
  let currentHero = 0;
  const heroSlides = document.querySelectorAll('.hero-slide');
  const heroDots = document.querySelectorAll('.hero-dot');
  let heroInterval;

  function goToHeroSlide(index) {
      if(heroSlides.length <= 1) return;
      heroSlides.forEach(s => s.classList.remove('active'));
      heroDots.forEach(d => d.classList.remove('active'));
      
      currentHero = index;
      heroSlides[currentHero].classList.add('active');
      if(heroDots[currentHero]) heroDots[currentHero].classList.add('active');
      
      resetHeroInterval();
  }

  function nextHeroSlide() {
      if(heroSlides.length <= 1) return;
      let next = (currentHero + 1) % heroSlides.length;
      goToHeroSlide(next);
  }

  function resetHeroInterval() {
      clearInterval(heroInterval);
      if(heroSlides.length > 1) {
          heroInterval = setInterval(nextHeroSlide, 5000);
      }
  }
  
  // Initialize
  if(heroSlides.length > 1) {
      resetHeroInterval();
  }

  // -- Improved Testimonial Carousel Logic (Fixed Page-Based) --
  let currentTestIndex = 0;
  const tCarousel = document.getElementById('testimonialsCarousel');
  const tDotsContainer = document.getElementById('testimonialDots');
  let tAutoPlay;

  function initTestimonials() {
    if(!tCarousel) return;
    const cards = tCarousel.querySelectorAll('.testimonial-card');
    const totalCards = cards.length;
    if(totalCards === 0) return;

    // Calculate how many cards to show
    const getVisible = () => {
      if(window.innerWidth > 991) return 3;
      if(window.innerWidth > 767) return 2;
      return 1;
    };

    const renderDots = () => {
      const visible = getVisible();
      const dotCount = Math.max(1, totalCards - visible + 1);
      tDotsContainer.innerHTML = '';
      
      for(let i=0; i < dotCount; i++) {
        const dot = document.createElement('button');
        dot.className = `testimonial-dot ${i === currentTestIndex ? 'is-active' : ''}`;
        dot.onclick = () => goToTestimonialPage(i);
        tDotsContainer.appendChild(dot);
      }
    };

    window.goToTestimonialPage = (index) => {
      const visible = getVisible();
      const dotCount = Math.max(1, totalCards - visible + 1);
      
      if(index >= dotCount) index = 0;
      if(index < 0) index = dotCount - 1;
      
      currentTestIndex = index;
      
      const gap = window.innerWidth > 767 ? 30 : 0;
      const cardWidth = cards[0].offsetWidth + gap;
      
      tCarousel.style.transform = `translateX(-${index * cardWidth}px)`;
      
      // Update dots
      const dots = tDotsContainer.querySelectorAll('.testimonial-dot');
      dots.forEach((d, i) => {
        d.classList.toggle('is-active', i === index);
      });

      startTAutoPlay();
    };

    const startTAutoPlay = () => {
      clearInterval(tAutoPlay);
      tAutoPlay = setInterval(() => {
        const visible = getVisible();
        const dotCount = Math.max(1, totalCards - visible + 1);
        goToTestimonialPage((currentTestIndex + 1) % dotCount);
      }, 5000);
    };

    renderDots();
    startTAutoPlay();
    
    // Handle resize
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        currentTestIndex = 0;
        renderDots();
        goToTestimonialPage(0);
      }, 250);
    });
  }

  // Initialize on load
  document.addEventListener('DOMContentLoaded', initTestimonials);

  // Add subtle hover effect for product images via JS (fallback)
  document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            let img = card.querySelector('.product-image img');
            if(img) img.style.transform = 'scale(1.05)';
        });
        card.addEventListener('mouseleave', () => {
            let img = card.querySelector('.product-image img');
            if(img) img.style.transform = 'scale(1)';
        });
  });

  // -- Wishlist Logic --
  function toggleWishlist(event, productId) {
      event.preventDefault();
      event.stopPropagation();
      
      const btn = event.currentTarget;
      const icon = btn.querySelector('i');
      
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
              // Reload page to show updated wishlist count/state
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
    function slideFeatured(direction) {
        const slider = document.getElementById('featured-slider');
        if (!slider) return;
        const cardWidth = slider.querySelector('.product-card').offsetWidth;
        slider.scrollBy({
            left: direction * cardWidth,
            behavior: 'smooth'
        });
    }
  // -- Collections Carousel Logic --
  let colIndex = 0;
  function slideColCarousel(direction) {
    const carousel = document.getElementById('collectionsCarousel');
    if(!carousel) return;
    const cards = carousel.querySelectorAll('.collection-card');
    const total = cards.length;
    
    const getVisible = () => {
      if(window.innerWidth > 900) return total; // Grid mode
      if(window.innerWidth > 600) return 2;
      return 1;
    };
    
    const visible = getVisible();
    if(total <= visible) return;

    colIndex += direction;
    
    // Limits
    if(colIndex > total - visible) colIndex = 0;
    if(colIndex < 0) colIndex = Math.max(0, total - visible);
    
    const gap = 20;
    const cardWidth = cards[0].offsetWidth + gap;
    
    carousel.style.transform = `translateX(-${colIndex * cardWidth}px)`;
  }

  // Add Lucide refresh if needed
  if(window.lucide) {
    lucide.createIcons();
  }
</script>
@endsection