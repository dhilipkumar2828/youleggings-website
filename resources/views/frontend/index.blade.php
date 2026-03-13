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

  /* Premium Grid Fixes */
  .premium-grid {
    display: grid;
    /* auto-fill prevents single items from expanding to full screen */
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 40px 30px;
    justify-content: center;
  }
  
  /* Curated Collections */
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
  .collection-card:hover {
    transform: translateY(-8px);
  }
  .collection-image-wrap {
    height: 380px; /* Decreased height */
    margin-bottom: 20px;
    position: relative;
    background: #f4f4f4;
  }
  .collection-image-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
  }
  .collection-name {
    font-size: 22px;
    font-family: var(--font-serif, serif);
    color: #222;
    margin-bottom: 8px;
    font-weight: 600;
  }
  .collection-btn {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #ec407a;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  /* Testimonial Section */
  .testimonials-section {
    position: relative;
    overflow: hidden;
  }
  .testimonial-slider {
    max-width: 900px;
    margin: 0 auto;
    overflow: hidden;
    position: relative;
  }
  .testimonial-inner {
    display: flex;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .testimonial-slide {
    min-width: 100%;
    padding: 20px;
    box-sizing: border-box;
  }
  .testimonial-card {
    background: #fff;
    padding: 60px 50px;
    border-radius: 20px;
    border: 1px solid #fdeef2;
    box-shadow: 0 20px 40px rgba(193, 139, 149, 0.05);
    text-align: center;
    position: relative;
  }
  .quote-mark {
    position: absolute;
    top: 40px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 80px;
    color: #fdeef2;
    z-index: 0;
    line-height: 1;
    font-family: serif;
  }
  .testimonial-content {
    position: relative;
    z-index: 1;
  }
  .testimonial-text {
    font-size: 18px;
    font-style: italic;
    color: #4a4a4a;
    line-height: 1.8;
    margin-bottom: 35px;
  }
  .testimonial-author {
    color: #ec407a;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 2px;
    margin-bottom: 8px;
  }
  .testimonial-stars {
    color: #ffb400;
    display: flex;
    gap: 5px;
    justify-content: center;
    margin-top: 15px;
  }
  .t-dots {
    display: flex; justify-content: center; gap: 12px; margin-top: 40px;
  }
  .t-dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: #f0f0f0; cursor: pointer; transition: 0.3s;
  }
  .t-dot.active { background: #ec407a; transform: scale(1.3); }
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
                        <a href="{{ $banner->link ?: route('shop') }}" class="btn hero-btn" style="padding: 16px 35px; background: #333; color: #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; border-radius: 0; font-size: 13px;">Explore Collection</a>
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
                    <a href="{{ route('shop') }}" class="btn hero-btn" style="padding: 16px 35px; background: #333; color: #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; border-radius: 0; font-size: 13px;">Shop The Collection</a>
                </div>
            </div>
        </div>
    @endif
  </section>

  <!-- Collections Section -->
  <section class="section home-categories-section" id="collections" style="padding: 80px 0; background: #fff;">
    <div class="container">
      <div class="text-center section-header" style="margin-bottom: 50px;">
        <span class="section-subtitle" style="color: var(--primary-color, #c18b95); font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 10px;">Our Range</span>
        <h2 class="section-title" style="font-family: var(--font-serif, serif); font-size: 2.5rem; margin-bottom: 20px;">Curated Collections</h2>
        <div class="header-divider" style="width: 60px; height: 2px; background: var(--primary-color, #c18b95); margin: 0 auto;"></div>
      </div>

      <div class="premium-grid">
        @forelse($categories as $category)
            <a href="{{ route('shop', ['category[]' => $category->id]) }}" class="collection-card">
              <div class="collection-image-wrap">
                <img src="{{ $category->photo ? image_url($category->photo) : asset('frontend/images/Products/_DSC8742-Edit.jpg') }}" alt="{{ $category->title }}">
              </div>
              <h3 class="collection-name">{{ $category->title }}</h3>
              <div class="collection-btn">
                  Explore <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              </div>
            </a>
        @empty
            @for($i=1; $i<=3; $i++)
            <a href="{{ route('shop') }}" class="collection-card">
              <div class="collection-image-wrap">
                <img src="{{ asset('frontend/images/Products/_DSC8742-Edit.jpg') }}" alt="Men's Collection">
              </div>
              <h3 class="collection-name">Collection {{ $i }}</h3>
              <div class="collection-btn">
                  Explore <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
              </div>
            </a>
            @endfor
        @endforelse
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

      <div class="premium-grid">
        @forelse($featured_products as $product)
            @php
                $photo = $product->productvariant->first()->photo ?? '';
                $photos = $photo ? explode(',', $photo) : [asset('frontend/images/Products/_DSC8742-Edit.jpg')];
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
                        if($product->discount_type == 'percent') {
                            $sellingPrice = $regularPrice - ($regularPrice * $discount / 100);
                        } else {
                            $sellingPrice = $regularPrice - $discount;
                        }
                    }
                  @endphp
                  <span class="selling-price" style="font-size: 22px; font-weight: 700; color: #ec407a;">₹ {{ number_format($sellingPrice) }}</span>
                  @if($discount > 0)
                    <span class="regular-price" style="font-size: 15px; text-decoration: line-through; color: #bbbbbb; font-weight: 400;">₹ {{ number_format($regularPrice, 2) }}</span>
                  @endif
                </div>
              </div>
              <!-- Wishlist Button -->
              <button type="button" class="wishlist-toggle-btn" onclick="toggleWishlist(event, {{ $product->id }})" style="position: absolute; top: 25px; right: 25px; background: rgba(255,255,255,0.9); border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #888; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.84-8.84 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
              </button>
            </a>
        @empty
            <p class="text-center" style="width: 100%; padding: 40px; color: #888;">Discoveries coming soon...</p>
        @endforelse
      </div>
      
      <div class="text-center" style="margin-top: 60px;">
        <a href="{{ route('shop') }}" class="btn" style="padding: 15px 40px; background: #222; color: #fff; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; border-radius: 4px;">View All Products</a>
      </div>
    </div>
  </section>

  <!-- Split Banner Section (Editorial Style) -->
  <section class="split-banner" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); height: auto; min-height: 600px; background: #fff; overflow: hidden;">
    <div class="split-content" style="background: #fbf9fa; padding: 12%; display: flex; flex-direction: column; justify-content: center; position: relative;">
      <span class="section-subtitle" style="color: var(--primary-color, #c18b95); font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 12px; margin-bottom: 20px;">Limited Edition</span>
      <h2 class="split-title" style="font-family: var(--font-serif, serif); font-size: 3.5rem; line-height: 1.1; margin-bottom: 25px; color: #333; font-style: italic;">The Art of <br>Comfort</h2>
      <p class="split-desc" style="font-size: 15px; line-height: 1.8; color: #666; margin-bottom: 40px; max-width: 400px;">
        Discover a collection of premium leggings that feel like a second skin. Meticulously crafted for movement and designed for the modern woman.
      </p>
      <div>
        <a href="{{ route('shop') }}" class="btn" style="padding: 15px 35px; background: #333; color: #fff; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border: none;">Explore Collection</a>
      </div>
    </div>
    <div class="split-image" style="background-image: url('{{ asset('frontend/images/Products/_DSC8723-Edit.jpg') }}'); background-size: cover; background-position: center; min-height: 400px; transition: transform 1.5s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"></div>
  </section>

  <!-- Testimonials Section -->
  <!-- Testimonials Section -->
  @if(isset($testimonials) && count($testimonials) > 0)
    <section class="section testimonials-section" id="testimonials" style="padding: 100px 0; background: #fffafc;">
      <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
          <span class="section-subtitle" style="color: #ec407a; font-weight: 700; letter-spacing: 4px; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 15px;">Voices of Comfort</span>
          <h2 class="section-title" style="font-family: var(--font-serif, serif); font-size: 3rem; color: #333;">What Our Customers Say</h2>
        </div>
        
        <div class="testimonial-slider">
          <div class="testimonial-inner" id="t-inner">
            @foreach($testimonials as $test)
            <div class="testimonial-slide">
              <div class="testimonial-card">
                <div class="quote-mark">“</div>
                <div class="testimonial-content">
                  <p class="testimonial-text">"{{ $test->feedback }}"</p>
                  <h4 class="testimonial-author">{{ $test->name }}</h4>
                  <div class="testimonial-stars">
                    @for($i=0; $i<5; $i++)
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="#ffb400" stroke="none"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    @endfor
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        @if(count($testimonials) > 1)
        <div class="t-dots">
          @foreach($testimonials as $index => $test)
            <div class="t-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToTestimonial({{ $index }})"></div>
          @endforeach
        </div>
        @endif
      </div>
    </section>
  @endif

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

  // -- Testimonial Slider Logic --
  let currentTestimonial = 0;
  const tInner = document.getElementById('t-inner');
  const tDots = document.querySelectorAll('.t-dot');
  let tInterval;

  function goToTestimonial(index) {
      if(!tInner) return;
      currentTestimonial = index;
      tInner.style.transform = `translateX(-${index * 100}%)`;
      
      tDots.forEach(d => d.classList.remove('active'));
      if(tDots[index]) tDots[index].classList.add('active');
      
      resetTestimonialInterval();
  }

  function nextTestimonial() {
      if(!tDots || tDots.length <= 1) return;
      let next = (currentTestimonial + 1) % tDots.length;
      goToTestimonial(next);
  }

  function resetTestimonialInterval() {
      clearInterval(tInterval);
      if(tDots && tDots.length > 1) {
          tInterval = setInterval(nextTestimonial, 6000);
      }
  }

  // Initialize
  if(tDots && tDots.length > 1) {
      resetTestimonialInterval();
  }

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
</script>
@endsection