<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You Leggings | Premium Comfort</title>
  <meta name="description"
    content="Discover premium comfort with You Leggings. Luxury made affordable with our range of classic, ankle-length, and printed leggings fitting every move of your life.">
  <link rel="stylesheet" href="{{ asset('premium_assets/style.css') }}">
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

  <!-- Top Bar -->
  <div class="top-bar">
    <div class="top-bar-1">{{ $settings->top_bar_1 ?? 'COMFORT IN EVERY MOVE' }}</div>
    <div class="top-bar-2">{{ $settings->top_bar_2 ?? 'LUXURY MADE AFFORDABLE' }}</div>
    <div class="top-bar-3">{{ $settings->top_bar_3 ?? 'FROM TANTEX, FOR YOU' }}</div>
    <div class="top-bar-4">{{ $settings->top_bar_4 ?? 'LEGGINGS THAT FIT YOUR LIFE' }}</div>
  </div>

  <!-- Navigation -->
  <header class="header">
    <div class="container nav-container">
      <a href="{{ url('/') }}" class="logo">
        <img src="{{ $settings && $settings->logo ? (Str::contains($settings->logo, '/') ? asset($settings->logo) : asset('uploads/settings/'.$settings->logo)) : asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo">
      </a>

      <nav class="nav-links">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/?page=about') }}">About Us</a>
        <a href="{{ url('/?page=shop') }}">Shop</a>
        <a href="{{ url('/?page=new-arrivals') }}">New Arrivals</a>
        <a href="{{ url('/?page=blog') }}">Blog</a>
        <a href="{{ url('/?page=contact') }}">Contact Us</a>
      </nav>

      <div class="nav-icons text-dark">
        <button id="searchToggleBtn" class="nav-icon-btn" type="button" aria-label="Search">
          <i data-lucide="search"></i>
        </button>
        <div class="nav-tooltip-wrap">
          <a href="{{ url('/?page=login') }}" id="loginPageBtn" class="nav-icon-btn" aria-label="Account">
            <i data-lucide="user"></i>
          </a>
          <span class="nav-tooltip">Login</span>
        </div>
        <div class="nav-tooltip-wrap">
          <button id="dashboardBtn" class="nav-icon-btn" type="button" style="display: none;" aria-label="Dashboard">
            <i data-lucide="layout-dashboard"></i>
          </button>
          <span class="nav-tooltip">Dashboard</span>
        </div>
        <a href="{{ url('/?page=cart') }}" id="cartPageBtn" class="nav-icon-btn" aria-label="Cart">
          <i data-lucide="shopping-bag"></i>
          <span id="cartCountBadge" class="cart-count-badge" aria-live="polite">0</span>
        </a>
      </div>
      <div id="headerSearchBar" class="header-search" aria-hidden="true">
        <div class="header-search-row">
          <input type="text" placeholder="Search products..." aria-label="Search products">
          <button id="searchCloseBtn" class="header-search-close" type="button" aria-label="Close Search">
            <i data-lucide="x"></i>
          </button>
        </div>
        <div id="headerSearchResults" class="header-search-results" aria-label="Search Results"></div>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero home-page-section" id="home">
    <div class="page-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Premium Collection 2026</span>
        <h1 class="hero-title">Experience Comfort <br>In Every Move</h1>
        <a href="{{ url('/?page=shop') }}" class="btn hero-btn" style="margin-top: 25px;">Shop The Collection</a>
      </div>
    </div>
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
        @if(isset($categories))
          @foreach($categories->take(4) as $category)
          <a href="{{ url('/?page=shop') }}" class="product-card">
            <div class="product-image">
              <img src="{{ asset('uploads/category/' . $category->photo) }}" alt="{{ $category->title }}">
            </div>
            <div class="product-details">
              <h3 class="product-name">{{ $category->title }}</h3>
              <div class="product-price">Shop Collection</div>
            </div>
          </a>
          @endforeach
        @endif
      </div>
    </div>
  </section>
  <!-- About Page -->
  <section class="section about-page" id="about-page">
    <div class="page-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8937-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">About You Leggings</span>
        <h1 class="hero-title">{{ $abouts->title ?? 'Comfort Without Compromise' }}</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="about-hero">
        <span class="section-subtitle">Our Story</span>
        <h2 class="section-title">{{ $abouts->sub_title ?? 'Built on TANTEX Legacy, Designed for Every Woman' }}</h2>
      </div>

      <div class="about-story-split">
        <div class="about-story-card">
          <div class="about-story-content">
            <span class="about-story-tag">Our Promise</span>
            <h3>{{ $abouts->promise_title ?? 'Everyday Comfort, Premium Feel' }}</h3>
            <p style="color:#6f5c65; font-size:15px; line-height:1.75; margin-bottom:18px;">
              {{ $abouts->promise_desc ?? 'At You Legging, we believe every woman deserves comfort without compromise. Born from the legacy of TANTEX.' }}
            </p>
            <div class="about-feature-points">
              @if($abouts && $abouts->why_choose_1_title) <div class="about-feature-item">{{ $abouts->why_choose_1_title }}: {{ $abouts->why_choose_1_desc }}</div> @else <div class="about-feature-item">A perfect fit that flatters every body type</div> @endif
              @if($abouts && $abouts->why_choose_2_title) <div class="about-feature-item">{{ $abouts->why_choose_2_title }}: {{ $abouts->why_choose_2_desc }}</div> @else <div class="about-feature-item">Stretch that adapts to your lifestyle</div> @endif
              @if($abouts && $abouts->why_choose_3_title) <div class="about-feature-item">{{ $abouts->why_choose_3_title }}: {{ $abouts->why_choose_3_desc }}</div> @else <div class="about-feature-item">Durability that lasts wash after wash</div> @endif
            </div>
            <p style="color:#6f5c65; font-size:15px; line-height:1.75; margin-top:20px;">
              {!! $abouts->description ?? 'Whether you are at work, running errands, or relaxing at home, You Legging moves with you.' !!}
            </p>
          </div>
          <div class="about-story-image">
            <img src="{{ isset($abouts->photo) ? asset('uploads/about/'.$abouts->photo) : asset('premium_assets/images/Products/_DSC8682-Edit.jpg') }}" alt="You Leggings Our Story">
          </div>
        </div>
      </div>
    </div>

    <div class="about-why">
      <div class="container">
        <h2 class="section-title">Why Choose You Leggings?</h2>
        <div class="about-why-grid">
          @for($i=1; $i<=5; $i++)
            @php 
                $tField = "why_choose_{$i}_title"; 
                $dField = "why_choose_{$i}_desc";
                $defaultTitles = [1=>'From TANTEX Legacy', 2=>'Zero Compromise Quality', 3=>'Affordable Luxury', 4=>'Everyday Versatility', 5=>'Wide Range of Choices'];
                $defaultDescs = [1=>'A trusted brand foundation with years of quality experience.', 2=>'Premium fabrics, carefully tested for fit, comfort, and durability.', 3=>'High-end feel at market-friendly prices for everyday wear.', 4=>'Designed for work, play, travel, and everything in between.', 5=>'Colors, styles, and fits made for every woman.'];
            @endphp
            <article class="about-why-card" data-num="0{{ $i }}">
              <h3>{{ $abouts->$tField ?? $defaultTitles[$i] }}</h3>
              <p>{{ $abouts->$dField ?? $defaultDescs[$i] }}</p>
            </article>
          @endfor
        </div>
      </div>
    </div>
  </section>

  <!-- Shop Page -->
  <section class="section page-view shop-page" id="shop-page">
    <div class="page-main shop-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8984-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
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
          <div class="filter-group">
            <h3>Price Filter</h3>
            <p class="filter-range">&#8377;0 — &#8377;2,500</p>
            <input type="range" min="0" max="2500" value="2500">
          </div>
          <div class="filter-group">
            <h3>Categories</h3>
            <ul class="filter-list">
              @if(isset($categories))
                @foreach($categories as $cat)
                  <li><label><input type="checkbox"> {{ strtoupper($cat->title) }}</label></li>
                @endforeach
              @endif
            </ul>
          </div>

          <div class="filter-group">
            <h3>Sort</h3>
            <ul class="filter-list">
              <li><label><input type="radio" name="sort"> Discount</label></li>
              <li><label><input type="radio" name="sort"> Price</label></li>
            </ul>
          </div>
          <div class="filter-group">
            <h3>Availability</h3>
            <ul class="filter-list">
              <li><label><input type="checkbox"> In Stock</label></li>
              <li><label><input type="checkbox"> Out of Stock</label></li>
            </ul>
          </div>
          <div class="filter-group">
            <h3>Size</h3>
            <ul class="filter-list filter-size">
              <li><label><input type="checkbox"> XS</label></li>
              <li><label><input type="checkbox"> S</label></li>
              <li><label><input type="checkbox"> M</label></li>
              <li><label><input type="checkbox"> L</label></li>
              <li><label><input type="checkbox"> XL</label></li>
              <li><label><input type="checkbox"> 2XL</label></li>
              <li><label><input type="checkbox"> 3XL</label></li>
              <li><label><input type="checkbox"> 4XL</label></li>
              <li><label><input type="checkbox"> 5XL</label></li>
            </ul>
          </div>
          <button id="clearShopFiltersBtn" class="shop-clear-filters" type="button">Clear Filters</button>
        </aside>
        <div class="shop-products">
          <div class="products-grid">
            @if(isset($products))
              @foreach($products as $product)
                @php
                  $variant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
                  $vPhoto = $variant ? explode(',', $variant->photo)[0] : '';
                  $vPrice = $variant ? $variant->regular_price : '0';
                  $vMeta = "Sizes XS - 5XL"; 
                @endphp
                <div class="product-card shop-product-card" data-product="{{ $product->slug }}">
                  <div class="product-image">
                    <img src="{{ asset('uploads/product/' . $vPhoto) }}" alt="{{ $product->name }}">
                  </div>
                  <div class="product-details shop-product-details">
                    <p class="shop-product-category">{{ $product->categories->title ?? 'Premium' }}</p>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="shop-product-meta" style="display:none;">{{ $vMeta }}</div>
                    <div class="shop-product-bottom">
                      <div class="product-price">INR {{ number_format($vPrice, 0) }}</div>
                      <a href="{{ url('/?page=product&product=' . $product->slug) }}" class="shop-product-link">Buy Now</a>
                    </div>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Detail Page -->
  <section class="section page-view product-page" id="product-page">
    <div class="page-main product-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle" id="productDetailCategory">Leggings</span>
        <h1 class="hero-title" id="productDetailName">Product Detail</h1>
      </div>
    </div>

    <div class="container page-body">

      <div class="product-detail-layout">
        <div class="product-detail-gallery">
          <div class="product-detail-image-wrap">
            <img id="productDetailImage" src="{{ asset('premium_assets/images/Nude Comfort Ankle/_DSC8045-Edit.jpg') }}" alt="Product">
          </div>
          <div class="product-thumb-row" id="productThumbRow">
            <button class="product-thumb is-active" type="button"><img
                src="{{ asset('premium_assets/images/Nude Comfort Ankle/_DSC8045-Edit.jpg') }}" alt="Product thumbnail"></button>
          </div>
        </div>

        <div class="product-detail-content">
          <p class="product-detail-category" id="productDetailCategory">Legging</p>
          <h2 class="product-detail-title" id="productDetailName">Product Name</h2>
          <p class="product-detail-meta" id="productDetailMeta">Sizes XS - 3XL</p>
          <div class="product-detail-price" id="productDetailPrice">INR 0</div>
          <p class="product-tax-line">Inclusive of all taxes</p>

          <div class="product-detail-block compact-block">
            <h3>Select Size</h3>
            <div class="product-size-list compact-size-list" id="productSizeList">
              <button type="button">S</button>
              <button type="button" class="is-active">M</button>
              <button type="button">L</button>
              <button type="button">XL</button>
            </div>
          </div>

          <div class="product-detail-block compact-block">
            <h3>Select Color</h3>
            <div class="product-color-list" id="productColorList">
              <button type="button" class="product-color is-selected" style="--swatch:#394a58;"
                aria-label="Slate Blue"></button>
              <button type="button" class="product-color" style="--swatch:#7a253a;" aria-label="Wine"></button>
              <button type="button" class="product-color" style="--swatch:#1f2f89;" aria-label="Royal Blue"></button>
            </div>
          </div>

          <div class="product-detail-actions compact-actions">
            <button id="productAddToCartBtn" type="button" class="btn">Add to Cart</button>
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
          <button type="button" class="product-tab-btn" data-tab-target="spec" role="tab"
            aria-selected="false">Specifications</button>
          <button type="button" class="product-tab-btn" data-tab-target="fabric" role="tab"
            aria-selected="false">Fabrication</button>
          <button type="button" class="product-tab-btn" data-tab-target="reviews" role="tab"
            aria-selected="false">Reviews</button>
        </div>
        <div class="product-tab-panels">
          <div class="product-tab-panel is-active" data-tab-panel="desc">
            <p id="productDetailTabDesc">You Leggings products are designed to move with your lifestyle. From daily
              errands to long work hours, our fabrics hold their shape and offer all-day comfort without compromise.
            </p>
          </div>
          <div class="product-tab-panel" data-tab-panel="spec">
            <ul id="productDetailTabSpec">
              <li>Material composition: Premium cotton-elastane blend</li>
              <li>Stretch: 4-way flexibility for active movement</li>
              <li>Waist type: Soft elastic waistband for support</li>
              <li>Ideal use: Everyday wear, workwear, and travel</li>
            </ul>
          </div>
          <div class="product-tab-panel" data-tab-panel="fabric">
            <ul id="productDetailTabFabric">
              <li>Fine-gauge knitting for a smooth premium finish</li>
              <li>Color-lock treatment for wash-after-wash durability</li>
              <li>Reinforced stitching at stress points for long life</li>
              <li>Breathable construction engineered for all-day wear</li>
            </ul>
          </div>
          <div class="product-tab-panel" data-tab-panel="reviews">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
              <h3 style="font-family: var(--font-serif); font-size: 20px; margin: 0;">Customer Reviews</h3>
              <button type="button" class="btn" id="openReviewFormBtn" style="padding: 10px 20px; font-size: 13px;">Add
                a Review</button>
            </div>

            <div id="reviewFormContainer"
              style="display: none; background: #fff9fc; padding: 25px; border-radius: 12px; border: 1px solid #f0dbe4; margin-bottom: 30px;">
              <h4 style="margin-bottom: 20px; font-family: var(--font-serif); font-size: 18px; color: #5d3f4c;">Write a
                Review</h4>
              <div style="margin-bottom: 15px;">
                <label
                  style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #5d3f4c;">Your
                  Name <span style="color: red;">*</span></label>
                <input type="text" id="reviewName"
                  style="width: 100%; padding: 12px; border: 1px solid #e7ccd8; border-radius: 8px; font-family: inherit;"
                  placeholder="Enter your name">
              </div>
              <div style="margin-bottom: 15px;">
                <label
                  style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #5d3f4c;">Rating
                  <span style="color: red;">*</span></label>
                <select id="reviewStars"
                  style="width: 100%; padding: 12px; border: 1px solid #e7ccd8; border-radius: 8px; font-family: inherit; color: #f59e0b;">
                  <option value="★★★★★">★★★★★ (5 Stars)</option>
                  <option value="★★★★☆">★★★★☆ (4 Stars)</option>
                  <option value="★★★☆☆">★★★☆☆ (3 Stars)</option>
                  <option value="★★☆☆☆">★★☆☆☆ (2 Stars)</option>
                  <option value="★☆☆☆☆">★☆☆☆☆ (1 Star)</option>
                </select>
              </div>
              <div style="margin-bottom: 20px;">
                <label
                  style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #5d3f4c;">Your
                  Review <span style="color: red;">*</span></label>
                <textarea id="reviewText"
                  style="width: 100%; padding: 12px; border: 1px solid #e7ccd8; border-radius: 8px; min-height: 100px; font-family: inherit;"
                  placeholder="Share your experience..."></textarea>
              </div>
              <div style="display: flex; gap: 15px;">
                <button type="button" class="btn" id="submitReviewBtn">Submit Review</button>
                <button type="button" class="btn" id="cancelReviewBtn"
                  style="background: transparent; color: #5d3f4c; border: 1px solid #dfc5d0;">Cancel</button>
              </div>
            </div>

            <div id="productDetailTabReviews">
              <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0dbe4;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                  <strong style="font-size: 15px; color: #5d3f4c;">Priya K.</strong>
                  <span style="color: #f59e0b; font-size: 14px;">★★★★★</span>
                </div>
                <p style="font-size: 14px; color: #6b5a63; margin-top: 5px;">Absolutely love the fit and feel of these
                  leggings. They are incredibly soft and the waistband doesn't roll down during workouts.</p>
              </div>
              <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0dbe4;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                  <strong style="font-size: 15px; color: #5d3f4c;">Anita R.</strong>
                  <span style="color: #f59e0b; font-size: 14px;">★★★★☆</span>
                </div>
                <p style="font-size: 14px; color: #6b5a63; margin-top: 5px;">Great quality for the price! Only taking
                  off one star because I wish they had more color options in my size, but the comfort is undeniable.</p>
              </div>
              <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                  <strong style="font-size: 15px; color: #5d3f4c;">Meera S.</strong>
                  <span style="color: #f59e0b; font-size: 14px;">★★★★★</span>
                </div>
                <p style="font-size: 14px; color: #6b5a63; margin-top: 5px;">I've washed them five times already and the
                  color hasn't faded one bit. Truly a premium feel.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="related-products">
        <div class="text-center">
          <span class="section-subtitle">You May Also Like</span>
          <h2 class="section-title">Related Products</h2>
        </div>
        <div class="products-grid related-products-grid" id="relatedProductsGrid"></div>
      </div>
    </div>
  </section>
  <!-- New Arrivals Page -->
  <section class="section page-view new-arrivals-page" id="new-arrivals-page">
    <div class="page-main arrivals-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Latest Drops</span>
        <h1 class="hero-title">New Arrivals <br>Autumn 2026</h1>
      </div>
    </div>
    <div class="container page-body">
      <div class="arrivals-layout">
        <div class="products-grid arrivals-products-grid">
          @if(isset($products))
            @foreach($products->take(12) as $product)
              @php
                 $variant = \App\Models\ProductVariant::where('product_id', $product->id)->where('status', 'active')->first();
                 $vPhoto = $variant ? explode(',', $variant->photo)[0] : '';
                 $vPrice = $variant ? $variant->regular_price : '0';
              @endphp
              <div class="product-card shop-product-card" data-product="{{ $product->slug }}" onclick="window.location.href='?page=product&product={{ $product->slug }}'">
                <div class="product-image">
                  <img src="{{ asset('uploads/product/' . $vPhoto) }}" alt="{{ $product->name }}">
                </div>
                <div class="product-details shop-product-details">
                  <p class="shop-product-category">{{ $product->categories->title ?? 'Premium' }}</p>
                  <h3 class="product-name">{{ $product->name }}</h3>
                  <div class="shop-product-bottom">
                    <div class="product-price">INR {{ number_format($vPrice, 0) }}</div>
                    <a href="{{ url('/?page=product&product=' . $product->slug) }}" class="shop-product-link">View</a>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </section>

  <!-- Blog Page -->
  <section class="section page-view blog-page" id="blog-page">
    <div class="page-main blog-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8285-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Style Journal</span>
        <h1 class="hero-title">Elegance In <br>Motion</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="blog-top-layout">
        @if(isset($blogs) && $blogs->count() > 0)
        @php $highlight = $blogs->first(); @endphp
        <article class="blog-highlight-card" onclick="window.location.href='{{ route('blog_detail', $highlight->slug) }}'" style="cursor:pointer;">
          <div class="blog-highlight-image">
            <img src="{{ $highlight->photo ? asset('uploads/blog/' . $highlight->photo) : asset('premium_assets/images/Products/_DSC8716-Edit.jpg') }}" alt="{{ $highlight->title }}">
          </div>
          <div class="blog-highlight-content">
            <h2>{{ $highlight->title }}</h2>
            <p>{{ Str::limit(strip_tags($highlight->description), 150) }}</p>
            <span class="blog-date">{{ \Carbon\Carbon::parse($highlight->publish_at)->format('d-M-Y') }}</span>
          </div>
        </article>
        @else
        <article class="blog-highlight-card">
          <div class="blog-highlight-image">
            <img src="{{ asset('premium_assets/images/Products/_DSC8716-Edit.jpg') }}" alt="Featured Blog Post">
          </div>
          <div class="blog-highlight-content">
            <h2>How to Build a Versatile Leggings Wardrobe for Every Day</h2>
            <p>Create effortless looks for work, travel, and casual outings with a few high-quality essentials and smart
              color pairings.</p>
            <span class="blog-date">29-Jan-2026</span>
          </div>
        </article>
        @endif

        <aside class="blog-most-read">
          <h3>Most Read</h3>
          <ul>
            @if(isset($blogs) && $blogs->count() > 1)
              @foreach($blogs->skip(1)->take(6) as $blog)
              <li>
                <a href="{{ route('blog_detail', $blog->slug) }}">{{ $blog->title }}</a>
                <span>{{ \Carbon\Carbon::parse($blog->publish_at)->format('d-M-Y') }}</span>
              </li>
              @endforeach
            @else
            <li>
              <a href="#">How to Build a Versatile Leggings Wardrobe for Every Day</a>
              <span>29-Jan-2026</span>
            </li>
            <li>
              <a href="#">Why Every Modern Closet Needs Performance Bottom Wear</a>
              <span>21-Jan-2026</span>
            </li>
            <li>
              <a href="#">How Fabric Quality Improves Comfort and Long-Term Fit</a>
              <span>25-Dec-2025</span>
            </li>
            <li>
              <a href="#">Choosing the Right Legging Length for Every Occasion</a>
              <span>23-Dec-2025</span>
            </li>
            <li>
              <a href="#">Color Styling Guide: Matching Kurtis with Solid Leggings</a>
              <span>23-Dec-2025</span>
            </li>
            <li>
              <a href="#">Care Tips to Keep Stretch Fabrics Soft and Lasting Longer</a>
              <span>18-Dec-2025</span>
            </li>
            @endif
          </ul>
        </aside>
      </div>

      <div class="blog-articles-head">
        <h2>View All Articles</h2>
      </div>

      <div class="blog-articles-grid">
        @if(isset($blogs) && $blogs->count() > 0)
          @foreach($blogs as $blog)
          <article class="blog-article-card" onclick="window.location.href='{{ route('blog_detail', $blog->slug) }}'" style="cursor:pointer;">
            <div class="blog-article-image"><img src="{{ $blog->photo ? asset('uploads/blog/' . $blog->photo) : asset('premium_assets/images/Products/_DSC8716-Edit.jpg') }}" alt="{{ $blog->title }}"></div>
            <div class="blog-article-content">
              <p class="blog-article-date"><i data-lucide="calendar-days"></i>{{ \Carbon\Carbon::parse($blog->publish_at)->format('d-M-Y') }}</p>
              <h3>{{ $blog->title }}</h3>
            </div>
          </article>
          @endforeach
        @endif
      </div>

      <div class="blog-show-more-wrap">
        <a href="{{ url('/?page=blog') }}" class="btn blog-show-more-btn">Explore More Posts</a>
      </div>
    </div>
  </section>

  <!-- Contact Page -->
  <section class="section page-view contact-page" id="contact-page">
    <div class="page-main contact-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8937-Photoroom.png') }}'); background-size: auto 110%; background-position: right -5% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Get In Touch</span>
        <h1 class="hero-title" style="color: #000;">We Are Here <br>To Help</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="contact-grid">
        <div class="contact-panel">
          <span class="section-subtitle">Get in Touch</span>
          <h2 class="section-title">We're delighted to assist you</h2>
          <p class="section-desc">We're delighted to assist you with any inquiries you may have about our exquisite
            collections of clothing and accessories. Our commitment is to provide exceptional service and ensure your
            experience with You Leggings is enjoyable. Please reach out to us if you have any questions or need
            assistance. We look forward to hearing from you!</p>
          <ul class="contact-list">
            <li><strong>Support Hours:</strong> Monday to Saturday, 9:30 AM - 7:00 PM</li>
            <li><strong>Response Time:</strong> We usually respond within 24 hours</li>
            <li><strong>Order Help:</strong> Share your order number for faster support</li>
            <li><strong>Bulk Enquiries:</strong> Retail and wholesale requests are welcome</li>
          </ul>
        </div>
        <form class="contact-form" id="contactForm">
          @csrf
          <label for="contact-name">Name</label>
          <input id="contact-name" name="name" type="text" placeholder="Your full name" required>
          <label for="contact-mobile">Mobile Number</label>
          <input id="contact-mobile" name="phone" type="tel" placeholder="+91 98765 43210" required>
          <label for="contact-email">Email address</label>
          <input id="contact-email" name="email" type="email" placeholder="you@example.com" required>
          <label for="contact-message">Message</label>
          <textarea id="contact-message" name="message" rows="5" placeholder="Write your message" required></textarea>
          <button type="submit" class="btn">Send Message</button>
        </form>
      </div>

      <div class="contact-details-block">
        <article class="contact-detail-card">
          <div class="contact-detail-icon" aria-hidden="true">
            <i data-lucide="mail"></i>
          </div>
          <h3>Email</h3>
          <p>{{ $settings->email ?? 'youleggings@gmail.com' }}</p>
        </article>
        <article class="contact-detail-card">
          <div class="contact-detail-icon" aria-hidden="true">
            <i data-lucide="map-pin"></i>
          </div>
          <h3>Address</h3>
          <p>{!! $settings->address ?? '5/4, Surya Nagar, 2nd Street,<br> Bridgeway Colony Extn,<br> Tirupur - 641607' !!}</p>
        </article>
        <article class="contact-detail-card">
          <div class="contact-detail-icon" aria-hidden="true">
            <i data-lucide="phone"></i>
          </div>
          <h3>Phone</h3>
          <p>{{ $settings->phone ?? '+91 740143 24967' }}</p>
        </article>
      </div>
    </div>
  </section>

  <!-- Cart Page -->
  <section class="section page-view cart-page" id="cart-page">
    <div class="page-main cart-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right 10% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Review Your Selection</span>
        <h1 class="hero-title">Shopping <br>Cart</h1>
      </div>
    </div>

    <div class="container page-body">
      <div class="cart-layout">
        <!-- Cart Items List (Step 1) -->
        <div class="cart-items" id="cartItemsContainer">
          <!-- Cart items will be rendered here by JS -->
        </div>

        <!-- Checkout Form (Step 2 - Hidden by default) -->
        <div class="checkout-step cart-checkout-form-wrap" id="checkoutStage" style="display: none; flex: 1;">
          <div class="cart-checkout-form-header">
            <i data-lucide="map-pin" style="width:18px;height:18px;"></i>
            <h3>Shipping Address</h3>
          </div>
          <form id="checkoutAddressForm" class="cart-checkout-addr-form">
            @csrf
            <div class="cart-form-row-2">
              <div class="cart-form-field">
                <label>First Name</label>
                <input type="text" id="ship-first-name" name="first_name" placeholder="First Name" required>
              </div>
              <div class="cart-form-field">
                <label>Last Name</label>
                <input type="text" id="ship-last-name" name="last_name" placeholder="Last Name">
              </div>
            </div>
            <div class="cart-form-row-2">
              <div class="cart-form-field">
                <label>Mobile Number <span style="color:#ec407a">*</span></label>
                <input type="tel" id="ship-mobile" name="phone_number" placeholder="10-digit mobile" required maxlength="10">
              </div>
              <div class="cart-form-field">
                <label>Email <span style="color:#aaa; font-weight:400;">(Optional)</span></label>
                <input type="email" id="ship-email" name="email" placeholder="you@example.com">
              </div>
            </div>
            <div class="cart-form-field">
              <label>Street Address <span style="color:#ec407a">*</span></label>
              <input type="text" id="ship-address-1" name="street_1" placeholder="House No, Building Name..." required style="margin-bottom: 10px;">
              <input type="text" id="ship-address-2" name="street_2" placeholder="Street Name, Landmark, Area...">
            </div>
            <div class="cart-form-row-3">
              <div class="cart-form-field">
                <label>Town / City <span style="color:#ec407a">*</span></label>
                <input type="text" id="ship-city" name="town" placeholder="City" required>
              </div>
              <div class="cart-form-field">
                <label>State <span style="color:#ec407a">*</span></label>
                <select id="ship-state" name="state" required>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state }}</option>
                    @endforeach
                </select>
              </div>
              <div class="cart-form-field">
                <label>Pincode <span style="color:#ec407a">*</span></label>
                <input type="text" id="ship-pincode" name="pincode" placeholder="6-digit code" required maxlength="6">
              </div>
            </div>
            <div class="cart-form-field">
              <label>Payment Method</label>
              <div class="cart-payment-options">
                <label class="cart-payment-option">
                  <input type="radio" name="payment_method" value="cod" checked>
                  <span class="cart-payment-label"><i data-lucide="banknote" style="width:16px;height:16px;"></i> Cash on Delivery</span>
                </label>
                <label class="cart-payment-option">
                  <input type="radio" name="payment_method" value="razorpay">
                  <span class="cart-payment-label"><i data-lucide="credit-card" style="width:16px;height:16px;"></i> Online Payment</span>
                </label>
              </div>
            </div>
            <div class="cart-form-actions">
              <button class="btn" type="submit">Place Order</button>
              <button type="button" id="backToCartBtn" class="cart-back-btn">
                <i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Back to Cart
              </button>
            </div>
          </form>
        </div>

        <aside class="cart-summary">
          <div class="cart-summary-header">
            <i data-lucide="shopping-bag" style="width:20px;height:20px;"></i>
            <h3>Order Summary</h3>
          </div>
          <div class="cart-summary-row">
            <span>Subtotal</span>
            <strong id="cartSubtotalValue">INR 0</strong>
          </div>
          <div class="cart-summary-row">
            <span>Shipping</span>
            <strong id="cartShippingValue">INR 0</strong>
          </div>
          <div class="cart-summary-note" id="cartShippingNote">Free shipping on orders above INR 999</div>
          <div class="cart-summary-row total">
            <span>Total</span>
            <strong id="cartTotalValue">INR 0</strong>
          </div>
          <button class="btn cart-checkout-btn" type="button" id="initiateCheckoutBtn">Proceed to Checkout</button>
          <a href="{{ url('/?page=shop') }}" class="cart-continue-shopping">Continue Shopping</a>
        </aside>
      </div>
    </div>
  </section>
  
  <!-- Privacy Policy Page -->
  <section class="section page-view privacy-page" id="privacy-page">
    <div class="page-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right 10% top 50%; background-repeat: no-repeat; z-index: 2;"></div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Legal</span>
        <h1 class="hero-title">{{ $privacy->title ?? 'Privacy Policy' }}</h1>
      </div>
    </div>
    <div class="container page-body" style="padding: 60px 0; max-width: 900px;">
        <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1px solid #f0dbe4; line-height: 1.8; color: #4a3a42; font-size: 16px;">
            {!! $privacy->description ?? 'Privacy policy content coming soon...' !!}
        </div>
    </div>
  </section>

  <!-- Terms & Conditions Page -->
  <section class="section page-view terms-page" id="terms-page">
    <div class="page-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right 10% top 50%; background-repeat: no-repeat; z-index: 2;"></div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Legal</span>
        <h1 class="hero-title">{{ $terms->title ?? 'Terms & Conditions' }}</h1>
      </div>
    </div>
    <div class="container page-body" style="padding: 60px 0; max-width: 900px;">
        <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1px solid #f0dbe4; line-height: 1.8; color: #4a3a42; font-size: 16px;">
            {!! $terms->description ?? 'Terms & Conditions content coming soon...' !!}
        </div>
    </div>
  </section>

  <!-- Shipping Policy Page -->
  <section class="section page-view shipping-page" id="shipping-page">
    <div class="page-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8175-Photoroom.png') }}'); background-size: auto 110%; background-position: right 10% top 50%; background-repeat: no-repeat; z-index: 2;"></div>
      <div class="container page-main-content" style="margin-left: 110px">
        <span class="hero-subtitle">Support</span>
        <h1 class="hero-title">{{ $delivery->title ?? 'Shipping & Delivery' }}</h1>
      </div>
    </div>
    <div class="container page-body" style="padding: 60px 0; max-width: 900px;">
        <div style="background: #fff; padding: 40px; border-radius: 16px; border: 1px solid #f0dbe4; line-height: 1.8; color: #4a3a42; font-size: 16px;">
            {!! $delivery->description ?? 'Shipping and delivery content coming soon...' !!}
        </div>
    </div>
  </section>

  <!-- Login Page -->
  <section class="section page-view login-page" id="login-page">
    <div class="page-main login-main" style="background-image: none; background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8984-Photoroom.png') }}'); background-size: auto 110%; background-position: right 10% top 50%; background-repeat: no-repeat; z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">My Account</span>
        <h1 class="hero-title">Welcome Back <br>To You</h1>
      </div>
    </div>

    <div class="container page-body" style="padding-top: 20px; padding-bottom: 0;">
      <div class="login-wrap">
        <div class="login-card" id="authCard">
          <a href="index.html#home" class="login-logo">
            <img src="{{ asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo">
          </a>

          <h2 id="authTitle" style="margin-top: 20px;">Sign In</h2>

          <form id="loginForm" class="login-form auth-panel is-active">
            <div id="phoneInputGroup">
              <label for="login-mobile">Mobile Number</label>
              <input id="login-mobile" type="tel" placeholder="+91 98765 43210" maxlength="10">
              <button class="btn" type="button" id="sendOtpBtn" style="margin-top: 15px; width: 100%;">Send OTP</button>
            </div>

            <div id="otpInputGroup" style="display: none; margin-top: 20px;">
              <label for="login-otp">Enter OTP</label>
              <input id="login-otp" type="text" placeholder="6-digit OTP" maxlength="6">
              <p style="font-size: 11px; color: #666; margin-top: 8px;">A 6-digit OTP has been sent to your mobile.</p>
              <button class="btn" type="submit" style="margin-top: 15px; width: 100%;">Verify & Login</button>
              <button class="auth-bottom-btn" type="button" id="resendOtpBtn"
                style="margin-top: 10px; display: block; width: 100%; text-align: center;">Resend OTP</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Products Section (Homepage) -->
  <section class="section home-page-section" id="new-arrivals-block">
    <div class="container">
      <div class="text-center">
        <span class="section-subtitle">New Arrivals</span>
        <h2 class="section-title">All Products</h2>
        <div class="divider"></div>
      </div>

      <div class="products-grid">
        @if(isset($products))
          @foreach($products->take(4) as $item)
            @php
               $v = \App\Models\ProductVariant::where('product_id', $item->id)->where('status', 'active')->first();
               $photo = $v ? explode(',', $v->photo)[0] : 'placeholder.jpg';
               $price = $v ? $v->regular_price : '0';
            @endphp
            <div class="product-card" data-product="{{ $item->slug }}" onclick="window.location.href='?page=product&product={{ $item->slug }}'" style="cursor: pointer;">
              <div class="product-image">
                <img src="{{ asset('uploads/product/' . $photo) }}" alt="{{ $item->name }}">
              </div>
              <div class="product-details">
                <h3 class="product-name">{{ $item->name }}</h3>
                <div class="product-price">₹ {{ $price }}</div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

      <div class="text-center" style="margin-top: 30px;">
        <a href="{{ url('/?page=new-arrivals') }}" class="btn">VIEW ALL COLLECTIONS</a>
      </div>
    </div>
  </section>

  <!-- Split Banner / Highlight Section -->
  <section class="section home-page-section" style="padding: 0; margin-top: 40px;">
    <div class="split-banner">
      <div class="split-content">
        <span class="section-subtitle" style="margin-bottom: 15px;">Limited Edition</span>
        <h2 class="split-title"></h2>
        <p class="split-desc">
          Discover a collection of premium leggings that feel like a second skin. Each piece is meticulously crafted
          with precision and designed to move with you effortlessly.
        </p>
        <div>
          <a href="?page=shop" class="btn">Explore Shop</a>
        </div>
      </div>
      <div class="split-image"></div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="section home-page-section" style="background-color: #fff;">
    <div class="container">
      <div class="text-center">
        <span class="section-subtitle">Testimonials</span>
        <h2 class="section-title">What Our Customers Say</h2>
      </div>

      <div class="testimonials-carousel-wrap">
        <div class="testimonials-carousel" id="testimonialsCarousel">
          <div class="testimonials-track" id="testimonialsTrack">
            @if(isset($allreviews) && $allreviews->count() > 0)
              @foreach($allreviews as $review)
              <div class="testimonial-card">
                <div class="quote-icon">“</div>
                <p class="testimonial-text">{{ $review->feedback }}</p>
                <div class="client-name">{{ $review->name }}</div>
                <div style="font-size: 12px; color: #999; margin-top: 5px;">Verified Customer</div>
                <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
              </div>
              @endforeach
              {{-- Duplicate for infinite feel --}}
              @foreach($allreviews as $review)
              <div class="testimonial-card">
                <div class="quote-icon">“</div>
                <p class="testimonial-text">{{ $review->feedback }}</p>
                <div class="client-name">{{ $review->name }}</div>
                <div style="font-size: 12px; color: #999; margin-top: 5px;">Verified Customer</div>
                <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
              </div>
              @endforeach
            @else
              <div class="testimonial-card">
                <div class="quote-icon">“</div>
                <p class="testimonial-text">Very good fabric and reasonable price. I am very satisfied to purchase.</p>
                <div class="client-name">Jeyanthi RK</div>
                <div style="font-size: 12px; color: #999; margin-top: 5px;">Verified Customer</div>
                <div style="color: #f59e0b; margin-top: 10px;">★★★★★</div>
              </div>
            @endif
          </div>
        </div>
        <div class="testimonial-dots" id="testimonialDots" style="display: flex; justify-content: center; gap: 10px; margin-top: 30px;"></div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <!--
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <a href="index.html#home" class="logo">
            <img src="{{ asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo">
          </a>
          <p style="line-height: 1.8; margin-bottom: 20px; color: #999;">
            Premium quality leggings designed for the modern woman. Experience the perfect fit today.
          </p>
          <div class="social-icons">
            <a href="#" class="social-icon"><i data-lucide="facebook"></i></a>
            <a href="#" class="social-icon"><i data-lucide="twitter"></i></a>
            <a href="#" class="social-icon"><i data-lucide="instagram"></i></a>
            <a href="#" class="social-icon"><i data-lucide="youtube"></i></a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Explore</h4>
          <ul>
            <li><a href="index.html#home">Home</a></li>
            <li><a href="?page=about">About Us</a></li>
            <li><a href="?page=shop">Shop</a></li>
            <li><a href="?page=new-arrivals">New Arrivals</a></li>
            <li><a href="?page=contact">Contact Us</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Leggings</h4>
          <ul>
            <li><a href="#">Classic</a></li>
            <li><a href="#">Ankle Length</a></li>
            <li><a href="#">Printed</a></li>
            <li><a href="#">Churidar</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Contact Us</h4>
          <p style="color: #999; margin-bottom: 15px; display: flex; gap: 10px; align-items: flex-start;">
            <i data-lucide="map-pin" style="width: 20px; height: 20px; flex-shrink: 0; color: #fff;"></i>
            <span>5/4, Surya Nagar, 2nd Street, Bridgeway Colony Extn,<br>Tirupur - 641607</span>
          </p>
          <p style="color: #999; margin-bottom: 10px; display: flex; gap: 10px; align-items: center;">
            <i data-lucide="phone" style="width: 18px; height: 18px; color: #fff;"></i>
            <span>+91 740143 24967</span>
          </p>
          <p style="color: #999; display: flex; gap: 10px; align-items: center;">
            <i data-lucide="mail" style="width: 18px; height: 18px; color: #fff;"></i>
            <span>youleggings@gmail.com</span>
          </p>
        </div>
      </div>

      <div class="copyright">
        &copy; 2026 You Leggings. All Rights Reserved. Designed with Love.
      </div>
    </div>
  </footer>
  -->

  <!-- Enhanced Premium Footer -->
  <footer class="new-bottom-footer" style="background: #0f0f0f; border-top: 1px solid rgba(255,255,255,0.05); padding: 80px 0 30px;">
    <div class="container">
      <div class="footer-main-grid" style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.2fr; gap: 40px; margin-bottom: 60px;">
        
        <!-- Brand & About -->
        <div class="footer-brand-col">
          <a href="{{ url('/') }}" style="display: block; margin-bottom: 25px;">
            <img src="{{ $settings && $settings->logo ? (Str::contains($settings->logo, '/') ? asset($settings->logo) : asset('uploads/settings/'.$settings->logo)) : asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo" style="max-height: 60px; filter: drop-shadow(0 0 10px rgba(255,255,255,0.1));">
          </a>
          <p style="color: #888; line-height: 1.8; font-size: 0.95rem; margin-bottom: 25px; max-width: 300px;">
            Premium quality leggings designed for the modern woman. Experience the perfect fit that moves with you every day.
          </p>
          <div class="social-links-wrap" style="display: flex; gap: 12px;">
            @if($settings && $settings->facebook_link) <a href="{{ $settings->facebook_link }}" class="social-pill" target="_blank"><i data-lucide="facebook"></i></a> @endif
            @if($settings && $settings->instagram_link) <a href="{{ $settings->instagram_link }}" class="social-pill" target="_blank"><i data-lucide="instagram"></i></a> @endif
            @if($settings && $settings->twitter_link) <a href="{{ $settings->twitter_link }}" class="social-pill" target="_blank"><i data-lucide="twitter"></i></a> @endif
            @if($settings && $settings->youtube_link) <a href="{{ $settings->youtube_link }}" class="social-pill" target="_blank"><i data-lucide="youtube"></i></a> @endif
          </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-links-col">
          <h4 style="color: #fff; font-size: 1.1rem; margin-bottom: 25px; font-family: 'Outfit', sans-serif;">Explore</h4>
          <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 15px;">
            <li><a href="{{ url('/') }}" class="footer-link-item">Home</a></li>
            <li><a href="{{ url('/?page=about') }}" class="footer-link-item">About Us</a></li>
            <li><a href="{{ url('/?page=shop') }}" class="footer-link-item">Shop Collection</a></li>
            <li><a href="{{ url('/?page=new-arrivals') }}" class="footer-link-item">New Arrivals</a></li>
            <li><a href="{{ url('/?page=blog') }}" class="footer-link-item">Style Journal</a></li>
          </ul>
        </div>

        <!-- Legal/Support -->
        <div class="footer-links-col">
          <h4 style="color: #fff; font-size: 1.1rem; margin-bottom: 25px; font-family: 'Outfit', sans-serif;">Support</h4>
           <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 15px;">
            <li><a href="{{ url('/?page=privacy') }}" class="footer-link-item">Privacy Policy</a></li>
            <li><a href="{{ url('/?page=terms') }}" class="footer-link-item">Terms & Conditions</a></li>
            <li><a href="{{ url('/?page=shipping') }}" class="footer-link-item">Shipping Policy</a></li>
            <li><a href="{{ url('/?page=contact') }}" class="footer-link-item">Help Center</a></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-contact-col">
          <h4 style="color: #fff; font-size: 1.1rem; margin-bottom: 25px; font-family: 'Outfit', sans-serif;">Contact Us</h4>
          <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; gap: 15px; align-items: flex-start;">
              <div style="color: var(--primary-color);"><i data-lucide="map-pin" style="width: 20px; height: 20px;"></i></div>
              <p style="color: #888; font-size: 0.9rem; margin: 0; line-height: 1.6;">{!! $settings->address ?? '5/4, Surya Nagar, 2nd Street,<br>Bridgeway Colony Extn,<br>Tirupur - 641607' !!}</p>
            </div>
            <div style="display: flex; gap: 15px; align-items: center;">
              <div style="color: var(--primary-color);"><i data-lucide="phone" style="width: 20px; height: 20px;"></i></div>
              <a href="tel:{{ $settings->phone ?? '+917401432496' }}" style="color: #888; text-decoration: none; font-size: 0.9rem;">{{ $settings->phone ?? '+91 740143 2496' }}</a>
            </div>
            <div style="display: flex; gap: 15px; align-items: center;">
              <div style="color: var(--primary-color);"><i data-lucide="mail" style="width: 20px; height: 20px;"></i></div>
              <a href="mailto:{{ $settings->email ?? 'youleggings@gmail.com' }}" style="color: #888; text-decoration: none; font-size: 0.9rem;">{{ $settings->email ?? 'youleggings@gmail.com' }}</a>
            </div>
          </div>
        </div>

      </div>

      <!-- Copyright Area -->
      <div style="padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <p style="color: #666; font-size: 0.85rem; margin: 0;">&copy; {{ date('Y') }} You Leggings. All rights reserved.</p>
        <div style="display: flex; gap: 25px; align-items: center;">
             <p style="color: #555; font-size: 0.8rem; margin: 0;">Designed with Love</p>
             <div style="display: flex; gap: 10px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal" style="height: 15px; opacity: 0.4;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" style="height: 15px; opacity: 0.4;">
             </div>
        </div>
      </div>
    </div>
  </footer>


  <script>
    lucide.createIcons();

    function formatMoney(amount) {
      return 'INR ' + Math.round(amount).toLocaleString('en-IN');
    }
    
    // Inject real products from DB for ID lookup
    const DB_PRODUCTS = @json($products);
    const DB_PRODUCT_MAP = (DB_PRODUCTS || []).reduce((acc, p) => {
        acc[p.slug || p.id] = p;
        return acc;
    }, {});

    const params = new URLSearchParams(window.location.search);
    const activePage = params.get('page');
    const routedPages = ['about', 'shop', 'product', 'new-arrivals', 'blog', 'contact', 'cart', 'login', 'privacy', 'terms', 'shipping'];
    const isRoutedPage = routedPages.includes(activePage);
    if (isRoutedPage) {
      document.body.classList.add(`${activePage}-page-active`);
      window.scrollTo({ top: 0, behavior: 'auto' });
    }

    // Header scroll effect
    window.addEventListener('scroll', () => {
      const header = document.querySelector('.header');
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });

    const header = document.querySelector('.header');
    if (header) {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }

    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const searchCloseBtn = document.getElementById('searchCloseBtn');
    const headerSearchBar = document.getElementById('headerSearchBar');
    const headerSearchInput = headerSearchBar ? headerSearchBar.querySelector('input') : null;
    const headerSearchResults = document.getElementById('headerSearchResults');
    const cartPageBtn = document.getElementById('cartPageBtn');
    const cartCountBadge = document.getElementById('cartCountBadge');
    const loginPageBtn = document.getElementById('loginPageBtn');
    const authCard = document.getElementById('authCard');
    const authLoginTab = document.getElementById('authLoginTab');
    const authSignupTab = document.getElementById('authSignupTab');
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    const authBottomText = document.getElementById('authBottomText');
    const authBottomBtn = document.getElementById('authBottomBtn');
    const authTitle = document.getElementById('authTitle');

    if (searchToggleBtn && headerSearchBar) {
      searchToggleBtn.addEventListener('click', () => {
        headerSearchBar.classList.toggle('open');
        headerSearchBar.setAttribute('aria-hidden', headerSearchBar.classList.contains('open') ? 'false' : 'true');
        if (headerSearchBar.classList.contains('open') && headerSearchInput) {
          headerSearchInput.focus();
        }
      });
    }

    if (searchCloseBtn && headerSearchBar) {
      searchCloseBtn.addEventListener('click', () => {
        headerSearchBar.classList.remove('open');
        headerSearchBar.setAttribute('aria-hidden', 'true');
        if (headerSearchResults) {
          headerSearchResults.innerHTML = '';
          headerSearchResults.classList.remove('has-items');
        }
      });
    }

    if (cartPageBtn) {
      cartPageBtn.addEventListener('click', () => {
        window.location.href = '?page=cart';
      });
    }

    if (loginPageBtn) {
      loginPageBtn.addEventListener('click', () => {
        window.location.href = '?page=login';
      });
    }

    // Contact Form AJAX
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
      contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('contact_form') }}", {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showToast(data.message || 'Thank you! We have received your message.', 'success');
            contactForm.reset();
          } else {
            showToast('Failed to send message. Please try again.', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Error sending message.', 'error');
        });
      });
    }

    // OTP Real Logic
    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const phoneInputGroup = document.getElementById('phoneInputGroup');
    const otpInputGroup = document.getElementById('otpInputGroup');
    const loginMobileInput = document.getElementById('login-mobile');

    if (sendOtpBtn && phoneInputGroup && otpInputGroup && loginMobileInput) {
      sendOtpBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const mobile = loginMobileInput.value.trim();
        if (mobile.length < 10) {
          showToast('Please enter a valid 10-digit mobile number.', 'error');
          return;
        }

        const formData = new FormData();
        formData.append('mobile', mobile);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('generateotp') }}", {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
          showToast(data.message || 'OTP sent successfully. (Try 123456 for testing)', 'info');
          phoneInputGroup.style.display = 'none';
          otpInputGroup.style.display = 'block';
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Failed to send OTP.', 'error');
        });
      });
    }

    if (loginForm) {
      loginForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const mobile = loginMobileInput.value.trim();
        const otpValue = document.getElementById('login-otp')?.value.trim();
        
        const formData = new FormData();
        formData.append('mobile', mobile);
        formData.append('otp', otpValue);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('verifyotp') }}", {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
          if (!data.error) {
            localStorage.setItem('userLoggedIn', 'true');
            sessionStorage.setItem('justLoggedIn', 'true');
            showToast('Login successful!', 'success');
            setTimeout(() => {
              window.location.href = '{{ url('/') }}';
            }, 1000);
          } else {
            showToast(data.error.otp || 'Invalid OTP.', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showToast('Verification failed.', 'error');
        });
      });
    }

    const dashboardBtn = document.getElementById('dashboardBtn');

    function showDashboardTooltip() {
      const dashWrap = dashboardBtn ? dashboardBtn.closest('.nav-tooltip-wrap') : null;
      const dashTip = dashWrap ? dashWrap.querySelector('.nav-tooltip') : null;
      if (!dashTip) return;
      dashTip.classList.add('nav-tooltip-show');
      setTimeout(() => {
        dashTip.classList.remove('nav-tooltip-show');
      }, 3000);
    }

    if (localStorage.getItem('userLoggedIn') === 'true') {
      if (loginPageBtn) loginPageBtn.style.display = 'none';
      if (dashboardBtn) {
        dashboardBtn.style.display = 'block';
        dashboardBtn.addEventListener('click', () => {
          window.location.href = '{{ url('/customer/my_account') }}';
        });
        // Auto-show tooltip if user just logged in
        if (sessionStorage.getItem('justLoggedIn') === 'true') {
          sessionStorage.removeItem('justLoggedIn');
          setTimeout(showDashboardTooltip, 400);
        }
      }
    }

    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', () => {
        localStorage.removeItem('userLoggedIn');
        window.location.href = 'index.html';
      });
    }

    // Checkout Logic - Updated for 2 Steps
    const initiateCheckoutBtn = document.getElementById('initiateCheckoutBtn');
    if (initiateCheckoutBtn) {
      initiateCheckoutBtn.addEventListener('click', () => {
        if (localStorage.getItem('userLoggedIn') !== 'true') {
          showToast('Please login to complete your order.', 'error');
          setTimeout(() => {
            window.location.href = '?page=login';
          }, 1500);
          return;
        }

        const cartItems = getStoredCart();
        if (cartItems.length === 0) {
          showToast('Your cart is empty!', 'error');
          return;
        }

        // Move to Address Step
        const checkoutStage = document.getElementById('checkoutStage');
        const cartItemsContainer = document.getElementById('cartItemsContainer');
        cartItemsContainer.style.display = 'none';
        checkoutStage.style.display = 'block';
        initiateCheckoutBtn.style.display = 'none';
        window.scrollTo({ top: 300, behavior: 'smooth' });
      });
    }

    const backToCartBtn = document.getElementById('backToCartBtn');
    if (backToCartBtn) {
      backToCartBtn.addEventListener('click', () => {
        const checkoutStage = document.getElementById('checkoutStage');
        const cartItemsContainer = document.getElementById('cartItemsContainer');
        cartItemsContainer.style.display = 'grid'; // .cart-items uses grid
        checkoutStage.style.display = 'none';
        const initBtn = document.getElementById('initiateCheckoutBtn');
        if (initBtn) initBtn.style.display = 'block';
      });
    }

    const checkoutAddressForm = document.getElementById('checkoutAddressForm');
    function syncCartToServer() {
        const cartItems = getStoredCart();
        // Since the backend expects individual adds or full sync, we can use an endpoint or just ensure checkout has the latest.
        // For a seamless flow, we'll send the cart to a sync endpoint when it changes.
        fetch("/render_carttable", { // Using this as a proxy for sync if needed, or we can use another route
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart: cartItems })
        });
    }

    if (checkoutAddressForm) {
      checkoutAddressForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const cartItems = getStoredCart();
        if (cartItems.length === 0) {
          showToast('Your cart is empty!', 'error');
          return;
        }

        const formData = new FormData(checkoutAddressForm);
        
        // Prepare Nested Address Data as expected by CheckoutController
        const billingAddress = {
            first_name: document.getElementById('ship-first-name').value,
            last_name: document.getElementById('ship-last-name').value,
            phone_number: document.getElementById('ship-mobile').value,
            email: document.getElementById('ship-email').value,
            street_1: document.getElementById('ship-address-1').value,
            street_2: document.getElementById('ship-address-2').value,
            town: document.getElementById('ship-city').value,
            state: document.getElementById('ship-state').value,
            pincode: document.getElementById('ship-pincode').value
        };

        const paymentStatus = formData.get('payment_method'); // 'cod' or 'razorpay'

        // We need to match the backend's expected structure
        const postData = {
            _token: '{{ csrf_token() }}',
            billing_address: billingAddress,
            shipping_address: billingAddress, // Use same for now or add toggle
            payment_status: paymentStatus,
            deliver_charge: 0, // Should be calculated
            ship_discount_amount: 0
        };

        fetch("{{ route('checkout_store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(postData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.response && data.response.success === false) {
                showToast(data.response.msg || 'Checkout failed.', 'error');
            } else {
                showToast('Order placed successfully! Redirecting...', 'success');
                localStorage.removeItem(CART_STORAGE_KEY);
                updateCartBadge();
                setTimeout(() => {
                    window.location.href = '{{ url('/customer/my_account') }}';
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Order placement failed. Please try again.', 'error');
        });
      });
    }


    function slugifyProductName(name) {
      return name.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    }

    const productCards = document.querySelectorAll('.shop-product-card, .product-card');
    const productCatalog = {};

    productCards.forEach((card) => {
      const nameEl = card.querySelector('.product-name');
      const categoryEl = card.querySelector('.shop-product-category');
      const metaEl = card.querySelector('.shop-product-meta');
      const priceEl = card.querySelector('.product-price');
      const imgEl = card.querySelector('.product-image img');
      const actionEl = card.querySelector('.shop-product-link');

      if (!nameEl || !priceEl || !imgEl) return;

      const name = nameEl.textContent.trim();
      const slug = slugifyProductName(name);

      if (!productCatalog[slug]) {
        const dbProduct = DB_PRODUCT_MAP[slug] || DB_PRODUCT_MAP[name];
        productCatalog[slug] = {
          name,
          db_id: dbProduct ? dbProduct.id : null,
          category: categoryEl ? categoryEl.textContent.trim() : 'Legging',
          meta: metaEl ? metaEl.textContent.trim() : 'Sizes XS - XL',
          price: priceEl.textContent.trim(),
          image: imgEl.getAttribute('src'),
          alt: imgEl.getAttribute('alt') || name
        };
      }

      card.setAttribute('data-product', slug);

      if (actionEl) {
        actionEl.setAttribute('href', `?page=product&product=${slug}`);
        actionEl.textContent = 'Buy Now';
      }

      card.style.cursor = 'pointer';
      card.addEventListener('click', (event) => {
        if (event.target.closest('.shop-product-link')) return;
        window.location.href = `?page=product&product=${slug}`;
      });
    });

    function getSearchableProducts() {
      return Object.entries(productCatalog).map(([slug, item]) => ({ slug, ...item }));
    }

    const SIZE_ORDER = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'];

    // Edit this map to set custom thumbnail rows per product.
    // Key = product slug, Value = array of image paths in the order you want.
    // Example:
    // 'nude-comfort-ankle': ['./images/Nude Comfort Ankle/_DSC8045-Edit.jpg', './images/Cobalt Core Legging/_DSC8962.jpg']
    const productThumbConfig = {
      'nude-comfort-ankle': [
        './images/Nude Comfort Ankle/_DSC8045-Edit.jpg',
        './images/Nude Comfort Ankle/_DSC8028-Edit.jpg',
        './images/Nude Comfort Ankle/_DSC8016-Edit.jpg'
      ],
      'cobalt-core-legging': [
        './images/Cobalt Core Legging/_DSC8962.jpg',
        './images/Cobalt Core Legging/_DSC8954.jpg'
      ],
      'aqua-flex-active': [
        './images/Aqua Flex Active/_DSC9026-Edit.jpg',
        './images/Aqua Flex Active/_DSC9021-Edit.jpg',
        './images/Aqua Flex Active/_DSC9004-Edit.jpg'
      ],
      'neon-move-set': [
        './images/Products/_DSC7885-Edit.jpg',
        './images/Products/_DSC7874-Edit.jpg',
        './images/Products/_DSC7889-Edit.jpg'
      ],
      'scarlet-sport-fit': [
        './images/Products/_DSC7786-Edit.jpg',
        './images/Products/_DSC7788-Edit.jpg',
        './images/Products/_DSC7812-Edit.jpg'
      ],
      'floral-blush-pair': [
        './images/Products/_DSC8785-Edit.jpg',
        './images/Products/_DSC8789-Edit.jpg',
        './images/Products/_DSC8797-Edit.jpg'
      ],
      'olive-essential-set': [
        './images/Products/_DSC7839-Edit.jpg',
        './images/Products/_DSC7829-Edit.jpg',
        './images/Products/_DSC7865-Edit.jpg'
      ],
      'mint-aura-kurti-legging': [
        './images/Products/_DSC8871-Edit.jpg',
        './images/Products/_DSC8878-Edit.jpg',
        './images/Products/_DSC8893-Edit.jpg'
      ],
      'indigo-flare-bottom': [
        './images/Products/_DSC8659-Edit.jpg',
        './images/Products/_DSC8682-Edit.jpg',
        './images/Products/_DSC8637-Edit.jpg'
      ],
      'teal-grace-kurti-fit': [
        './images/Products/_DSC7901-Edit.jpg',
        './images/Products/_DSC7911-Edit.jpg',
        './images/Products/_DSC7925-Edit.jpg'
      ],
      'emerald-dot-kurta-set': [
        './images/Products/_DSC7937-Edit.jpg',
        './images/Products/_DSC7951-Edit.jpg',
        './images/Products/_DSC7961-Edit.jpg'
      ],
      'citrus-classic-set': [
        './images/Products/_DSC8742-Edit.jpg',
        './images/Products/_DSC8735-Edit.jpg',
        './images/Products/_DSC8752-Edit.jpg'
      ],
      'orchid-everyday-kurti': [
        './images/Products/_DSC8065-Edit.jpg',
        './images/Products/_DSC8069-Edit.jpg',
        './images/Products/_DSC8085-Edit.jpg'
      ],
      'plum-luxe-co-ord': [
        './images/Products/_DSC8116-Edit.jpg',
        './images/Products/_DSC8123.jpg',
        './images/Products/_DSC8128-Edit.jpg'
      ],
      'mustard-gleam-kurti': [
        './images/Products/_DSC8922.jpg',
        './images/Products/_DSC8910.jpg'
      ],
      'ruby-festive-set': [
        './images/Products/_DSC8810.jpg',
        './images/Products/_DSC8819.jpg',
        './images/Products/_DSC8832.jpg'
      ],
      'crimson-asym-tunic': [
        './images/Products/_DSC8352-Edit.jpg',
        './images/Products/_DSC8379-Edit.jpg',
        './images/Products/_DSC8407-Edit.jpg'
      ],
      'ivory-print-lounge': [
        './images/Products/_DSC8489-Edit.jpg',
        './images/Products/_DSC8496-Edit.jpg',
        './images/Products/_DSC8468-Edit.jpg'
      ],
      'sunrise-everyday-fit': [
        './images/Products/_DSC8432-Edit.jpg',
        './images/Products/_DSC8437-Edit.jpg',
        './images/Products/_DSC8462-Edit.jpg'
      ],
      'coral-motion-pair': [
        './images/Products/_DSC8510-Edit.jpg',
        './images/Products/_DSC8515-Edit.jpg',
        './images/Products/_DSC8523-Edit.jpg'
      ],
      'active-blue-flex': [
        './images/Products/_DSC8533-Edit.jpg',
        './images/Products/_DSC8541-Edit.jpg',
        './images/Products/_DSC8545-Edit.jpg'
      ],
      'cherry-street-edit': [
        './images/Products/_DSC8587-Edit.jpg',
        './images/Products/_DSC8591-Edit.jpg',
        './images/Products/_DSC8597-Edit.jpg'
      ],
      'azure-comfort-line': [
        './images/Products/_DSC8716-Edit.jpg',
        './images/Products/_DSC8719-Edit.jpg',
        './images/Products/_DSC8723-Edit.jpg'
      ],
      'classic-move-essential': [
        './images/Products/_DSC8189.jpg',
        './images/Products/_DSC8204.jpg'
      ]
    };

    function deriveSizeOptions(metaText) {
      const normalized = String(metaText || '').toUpperCase();
      const match = normalized.match(/(XS|S|M|L|XL|2XL|3XL|4XL|5XL)\s*-\s*(XS|S|M|L|XL|2XL|3XL|4XL|5XL)/);
      if (match) {
        const start = SIZE_ORDER.indexOf(match[1]);
        const end = SIZE_ORDER.indexOf(match[2]);
        if (start !== -1 && end !== -1) {
          const min = Math.min(start, end);
          const max = Math.max(start, end);
          return SIZE_ORDER.slice(min, max + 1);
        }
      }
      const found = SIZE_ORDER.filter((s) => normalized.includes(s));
      return found.length ? found : ['S', 'M', 'L', 'XL'];
    }

    function hashText(value) {
      return Array.from(String(value || '')).reduce((acc, ch) => acc + ch.charCodeAt(0), 0);
    }

    const colorSets = [
      [{ label: 'Nude Beige', swatch: '#d9c1aa' }, { label: 'Soft Cocoa', swatch: '#8f6a56' }, { label: 'Black', swatch: '#2c2c2c' }],
      [{ label: 'Cobalt Blue', swatch: '#1f3faa' }, { label: 'Ink Navy', swatch: '#273b57' }, { label: 'Cloud Grey', swatch: '#b7bec7' }],
      [{ label: 'Ruby Red', swatch: '#b52539' }, { label: 'Berry Pink', swatch: '#c43a68' }, { label: 'Charcoal', swatch: '#3b3f44' }],
      [{ label: 'Olive Green', swatch: '#566742' }, { label: 'Mustard', swatch: '#bf9f2e' }, { label: 'Ivory', swatch: '#ece5d8' }]
    ];

    function buildProductProfile(product, allProducts) {
      const seed = hashText(product.slug);
      const sizes = deriveSizeOptions(product.meta);
      const customThumbs = Array.isArray(productThumbConfig[product.slug])
        ? productThumbConfig[product.slug].filter((src) => typeof src === 'string' && src.trim())
        : [];

      let gallery = [];
      if (customThumbs.length) {
        gallery = [...new Set(customThumbs)];
      } else {
        const galleryPool = allProducts.filter((item) => item.slug !== product.slug).map((item) => item.image);
        gallery = [product.image];
        for (let i = 0; i < 3 && galleryPool.length; i += 1) {
          const index = (seed + i * 3) % galleryPool.length;
          gallery.push(galleryPool[index]);
        }
      }

      const comfortWords = ['second-skin comfort', 'structured stretch', 'day-long softness', 'breathable support'];
      const fitWords = ['streamlined silhouette', 'comfortable hold', 'clean everyday fit', 'flexible movement fit'];
      const useWords = ['daily routines', 'office wear', 'travel days', 'weekend styling'];

      const comfort = comfortWords[seed % comfortWords.length];
      const fit = fitWords[(seed + 1) % fitWords.length];
      const useCase = useWords[(seed + 2) % useWords.length];
      let colors = colorSets[seed % colorSets.length];
      let colorVariants = null;

      if (product.slug === 'nude-comfort-ankle') {
        colors = [
          { label: 'Deep Olive', swatch: '#3B4D3A' },
          { label: 'Cream Beige', swatch: '#E8D9B5' },
          { label: 'Soft Black', swatch: '#1C1C1C' },
          { label: 'Coffee Brown', swatch: '#6F4E37' }
        ];
        colorVariants = {
          'Deep Olive': [
            './images/Nude Comfort Ankle/_DSC8045-Edit.jpg',
            './images/Nude Comfort Ankle/_DSC8028-Edit.jpg',
            './images/Nude Comfort Ankle/_DSC8016-Edit.jpg'
          ],
          'Cream Beige': [
            './images/Nude Comfort Ankle/creame.png',
            './images/Nude Comfort Ankle/creame2.png',
            './images/Nude Comfort Ankle/creame3.png'
          ],
          'Soft Black': [
            './images/Nude Comfort Ankle/black.png',
            './images/Nude Comfort Ankle/black2.png',
            './images/Nude Comfort Ankle/black3.png'
          ],
          'Coffee Brown': [
            './images/Nude Comfort Ankle/brown.png',
            './images/Nude Comfort Ankle/brown2.png',
            './images/Nude Comfort Ankle/brown3.png'
          ]
        };
        gallery = colorVariants['Deep Olive'];
      } else if (product.slug === 'cobalt-core-legging') {
        colors = [
          { label: 'Coral', swatch: '#f96563' },
          { label: 'Warm Nude Beige', swatch: '#ac7c66' },
          { label: 'Dusty Rose', swatch: '#C3686F' },
          { label: 'Soft Mocha Brown', swatch: '#5a4238' }
        ];
        colorVariants = {
          'Coral': [
            './images/Cobalt Core Legging/_DSC8962.jpg',
            './images/Cobalt Core Legging/_DSC8954.jpg'
          ],
          'Warm Nude Beige': [
            './images/Cobalt Core Legging/Warm Nude Beige.png',
            './images/Cobalt Core Legging/Dusty Rose.png',
            './images/Cobalt Core Legging/Soft Mocha Brown.png'
          ],
          'Dusty Rose': [
            './images/Cobalt Core Legging/Dusty Rose.png',
            './images/Cobalt Core Legging/Warm Nude Beige.png',
            './images/Cobalt Core Legging/Soft Mocha Brown.png'
          ],
          'Soft Mocha Brown': [
            './images/Cobalt Core Legging/Soft Mocha Brown.png',
            './images/Cobalt Core Legging/Warm Nude Beige.png',
            './images/Cobalt Core Legging/Dusty Rose.png'
          ]
        };
        gallery = colorVariants['Coral'];
      } else if (product.slug === 'aqua-flex-active') {
        colors = [
          { label: 'Beige', swatch: '#c59a7e' },
          { label: 'Deep Black', swatch: '#1E1E1E' },
          { label: 'Navy Blue', swatch: '#283C6E' },
          { label: 'Dark Olive', swatch: '#46553C' }
        ];
        colorVariants = {
          'Beige': [
            './images/Aqua Flex Active/_DSC9026-Edit.jpg',
            './images/Aqua Flex Active/_DSC9021-Edit.jpg',
            './images/Aqua Flex Active/_DSC9004-Edit.jpg'
          ],
          'Deep Black': [
            './images/Aqua Flex Active/black.png',
            './images/Aqua Flex Active/navy blue.png',
            './images/Aqua Flex Active/olive.png'
          ],
          'Navy Blue': [
            './images/Aqua Flex Active/navy blue.png',
            './images/Aqua Flex Active/black.png',
            './images/Aqua Flex Active/olive.png'
          ],
          'Dark Olive': [
            './images/Aqua Flex Active/olive.png',
            './images/Aqua Flex Active/black.png',
            './images/Aqua Flex Active/navy blue.png'
          ]
        };
        gallery = colorVariants['Beige'];
      } else if (product.slug === 'neon-move-set') {
        colors = [
          { label: 'Aqua', swatch: '#009fbf' },
          { label: 'Maroon', swatch: '#5A1E2B' },
          { label: 'Navy Blue', swatch: '#1F2A44' },
          { label: 'Deep Black', swatch: '#2B2B2B' }
        ];
        colorVariants = {
          'Aqua': [
            './images/Products/_DSC7885-Edit.jpg',
            './images/Products/_DSC7874-Edit.jpg',
            './images/Products/_DSC7889-Edit.jpg'
          ],
          'Maroon': [
            './images/Neon Move Set/wine moreen.png',
            './images/Neon Move Set/navy blue.png',
            './images/Neon Move Set/black.png'
          ],
          'Navy Blue': [
            './images/Neon Move Set/navy blue.png',
            './images/Neon Move Set/black.png',
            './images/Neon Move Set/wine moreen.png'
          ],
          'Deep Black': [
            './images/Neon Move Set/black.png',
            './images/Neon Move Set/navy blue.png',
            './images/Neon Move Set/wine moreen.png'
          ]
        };
        gallery = colorVariants['Aqua'];
      } else if (product.slug === 'scarlet-sport-fit') {
        colors = [
          { label: 'Aqua', swatch: '#009fbf' },
          { label: 'Deep Black', swatch: '#1C1C1C' },
          { label: 'Dark Plum', swatch: '#4B2E59' },
          { label: 'Deep Forest Green', swatch: '#1F4D3A' }
        ];
        colorVariants = {
          'Aqua': [
            './images/Products/_DSC7786-Edit.jpg',
            './images/Products/_DSC7788-Edit.jpg',
            './images/Products/_DSC7812-Edit.jpg'
          ],
          'Deep Black': [
            './images/Scarlet Sport Fit/black.png',
            './images/Scarlet Sport Fit/dark plum.png',
            './images/Scarlet Sport Fit/deep forest green.png'
          ],
          'Dark Plum': [
            './images/Scarlet Sport Fit/dark plum.png',
            './images/Scarlet Sport Fit/black.png',
            './images/Scarlet Sport Fit/deep forest green.png'
          ],
          'Deep Forest Green': [
            './images/Scarlet Sport Fit/deep forest green.png',
            './images/Scarlet Sport Fit/black.png',
            './images/Scarlet Sport Fit/dark plum.png'
          ]
        };
        gallery = colorVariants['Aqua'];
      } else if (product.slug === 'floral-blush-pair') {
        colors = [
          { label: 'Aqua', swatch: '#009fbf' },
          { label: 'Classic Ivory', swatch: '#F1E6D0' },
          { label: 'Deep Emerald', swatch: '#1F6A5A' },
          { label: 'Rich Maroon', swatch: '#6E1F2A' }
        ];
        colorVariants = {
          'Aqua': [
            './images/Products/_DSC8785-Edit.jpg',
            './images/Products/_DSC8789-Edit.jpg',
            './images/Products/_DSC8797-Edit.jpg'
          ],
          'Classic Ivory': [
            './images/Floral Blush Pair/classic ivory.png',
            './images/Floral Blush Pair/deep emerald.png',
            './images/Floral Blush Pair/rich maroon.png'
          ],
          'Deep Emerald': [
            './images/Floral Blush Pair/deep emerald.png',
            './images/Floral Blush Pair/classic ivory.png',
            './images/Floral Blush Pair/rich maroon.png'
          ],
          'Rich Maroon': [
            './images/Floral Blush Pair/rich maroon.png',
            './images/Floral Blush Pair/classic ivory.png',
            './images/Floral Blush Pair/deep emerald.png'
          ]
        };
        gallery = colorVariants['Aqua'];
      } else if (product.slug === 'olive-essential-set') {
        colors = [
          { label: 'Navy', swatch: '#001f6c' },
          { label: 'Dusty Rose', swatch: '#C08081' },
          { label: 'Midnight Teal', swatch: '#0F3B3E' },
          { label: 'Cocoa Brown', swatch: '#5A3A2E' }
        ];
        colorVariants = {
          'Navy': [
            './images/Products/_DSC7839-Edit.jpg',
            './images/Products/_DSC7829-Edit.jpg',
            './images/Products/_DSC7865-Edit.jpg'
          ],
          'Dusty Rose': [
            './images/Olive Essential Set/dusty rose.png',
            './images/Olive Essential Set/midnight teal.png',
            './images/Olive Essential Set/Cocoa Brown.png'
          ],
          'Midnight Teal': [
            './images/Olive Essential Set/midnight teal.png',
            './images/Olive Essential Set/dusty rose.png',
            './images/Olive Essential Set/Cocoa Brown.png'
          ],
          'Cocoa Brown': [
            './images/Olive Essential Set/Cocoa Brown.png',
            './images/Olive Essential Set/dusty rose.png',
            './images/Olive Essential Set/midnight teal.png'
          ]
        };
        gallery = colorVariants['Navy'];
      } else if (product.slug === 'mint-aura-kurti-legging') {
        colors = [
          { label: 'Mint Aura', swatch: '#012968' },
          { label: 'Cream Beige', swatch: '#E6D3A3' },
          { label: 'Deep Maroon', swatch: '#6A1E2D' },
          { label: 'Dark Olive', swatch: '#4B5A2A' }
        ];
        colorVariants = {
          'Mint Aura': [
            './images/Products/_DSC8871-Edit.jpg',
            './images/Products/_DSC8878-Edit.jpg',
            './images/Products/_DSC8893-Edit.jpg'
          ],
          'Cream Beige': [
            './images/Mint Aura Kurti Legging/Cream Beige Pants.png',
            './images/Mint Aura Kurti Legging/Deep Maroon Pants.png',
            './images/Mint Aura Kurti Legging/Dark Olive Pants.png'
          ],
          'Deep Maroon': [
            './images/Mint Aura Kurti Legging/Deep Maroon Pants.png',
            './images/Mint Aura Kurti Legging/Cream Beige Pants.png',
            './images/Mint Aura Kurti Legging/Dark Olive Pants.png'
          ],
          'Dark Olive': [
            './images/Mint Aura Kurti Legging/Dark Olive Pants.png',
            './images/Mint Aura Kurti Legging/Cream Beige Pants.png',
            './images/Mint Aura Kurti Legging/Deep Maroon Pants.png'
          ]
        };
        gallery = colorVariants['Mint Aura'];
      } else if (product.slug === 'indigo-flare-bottom') {
        colors = [
          { label: 'Indigo', swatch: '#ffffff' },
          { label: 'Soft Sand Beige', swatch: '#E8DCC8' },
          { label: 'Deep Bottle Green', swatch: '#1F4A3A' },
          { label: 'Royal Plum', swatch: '#5A2D59' }
        ];
        colorVariants = {
          'Indigo': [
            './images/Products/_DSC8659-Edit.jpg',
            './images/Products/_DSC8682-Edit.jpg',
            './images/Products/_DSC8637-Edit.jpg'
          ],
          'Soft Sand Beige': [
            './images/Indigo Flare Bottom/Soft Sand Beige.png',
            './images/Indigo Flare Bottom/Deep Bottle Green.png',
            './images/Indigo Flare Bottom/Royal Plum.png'
          ],
          'Deep Bottle Green': [
            './images/Indigo Flare Bottom/Deep Bottle Green.png',
            './images/Indigo Flare Bottom/Soft Sand Beige.png',
            './images/Indigo Flare Bottom/Royal Plum.png'
          ],
          'Royal Plum': [
            './images/Indigo Flare Bottom/Royal Plum.png',
            './images/Indigo Flare Bottom/Soft Sand Beige.png',
            './images/Indigo Flare Bottom/Deep Bottle Green.png'
          ]
        };
        gallery = colorVariants['Indigo'];
      } else if (product.slug === 'teal-grace-kurti-fit') {
        colors = [
          { label: 'Teal Grace', swatch: '#6D000C' },
          { label: 'Classic Black', swatch: '#111111' },
          { label: 'Navy Indigo', swatch: '#1E2F6E' },
          { label: 'Muted Olive', swatch: '#5C6B3C' }
        ];
        colorVariants = {
          'Teal Grace': [
            './images/Products/_DSC7901-Edit.jpg',
            './images/Products/_DSC7911-Edit.jpg',
            './images/Products/_DSC7925-Edit.jpg'
          ],
          'Classic Black': [
            './images/Teal Grace Kurti Fit/image.png',
            './images/Teal Grace Kurti Fit/Navy Indigo.png',
            './images/Teal Grace Kurti Fit/Muted Olive.png'
          ],
          'Navy Indigo': [
            './images/Teal Grace Kurti Fit/Navy Indigo.png',
            './images/Teal Grace Kurti Fit/image.png',
            './images/Teal Grace Kurti Fit/Muted Olive.png'
          ],
          'Muted Olive': [
            './images/Teal Grace Kurti Fit/Muted Olive.png',
            './images/Teal Grace Kurti Fit/image.png',
            './images/Teal Grace Kurti Fit/Navy Indigo.png'
          ]
        };
        gallery = colorVariants['Teal Grace'];
      } else if (product.slug === 'emerald-dot-kurta-set') {
        colors = [
          { label: 'Emerald Dot', swatch: '#67000B' },
          { label: 'Soft Beige', swatch: '#E6D5C3' },
          { label: 'Deep Mustard', swatch: '#B88A1C' },
          { label: 'Charcoal Grey', swatch: '#2F2F2F' }
        ];
        colorVariants = {
          'Emerald Dot': [
            './images/Products/_DSC7937-Edit.jpg',
            './images/Products/_DSC7951-Edit.jpg',
            './images/Products/_DSC7961-Edit.jpg'
          ],
          'Soft Beige': [
            './images/Emerald Dot Kurta Set/Soft Beige.png',
            './images/Emerald Dot Kurta Set/Deep Mustard.png',
            './images/Emerald Dot Kurta Set/harcoal Grey.png'
          ],
          'Deep Mustard': [
            './images/Emerald Dot Kurta Set/Deep Mustard.png',
            './images/Emerald Dot Kurta Set/Soft Beige.png',
            './images/Emerald Dot Kurta Set/harcoal Grey.png'
          ],
          'Charcoal Grey': [
            './images/Emerald Dot Kurta Set/harcoal Grey.png',
            './images/Emerald Dot Kurta Set/Soft Beige.png',
            './images/Emerald Dot Kurta Set/Deep Mustard.png'
          ]
        };
        gallery = colorVariants['Emerald Dot'];
      } else if (product.slug === 'citrus-classic-set') {
        colors = [
          { label: 'Citrus', swatch: '#E1B556' },
          { label: 'Antique Gold', swatch: '#D4A437' },
          { label: 'Deep Maroon', swatch: '#6A1F2B' },
          { label: 'Soft Ivory', swatch: '#F2E6CF' }
        ];
        colorVariants = {
          'Citrus': [
            './images/Products/_DSC8742-Edit.jpg',
            './images/Products/_DSC8735-Edit.jpg',
            './images/Products/_DSC8752-Edit.jpg'
          ],
          'Antique Gold': [
            './images/Citrus Classic Set/Antique Gold.png',
            './images/Citrus Classic Set/Deep Maroon.png',
            './images/Citrus Classic Set/Soft Ivory.png'
          ],
          'Deep Maroon': [
            './images/Citrus Classic Set/Deep Maroon.png',
            './images/Citrus Classic Set/Antique Gold.png',
            './images/Citrus Classic Set/Soft Ivory.png'
          ],
          'Soft Ivory': [
            './images/Citrus Classic Set/Soft Ivory.png',
            './images/Citrus Classic Set/Antique Gold.png',
            './images/Citrus Classic Set/Deep Maroon.png'
          ]
        };
        gallery = colorVariants['Citrus'];
      }

      return {
        description: `${product.name} is designed for ${comfort} with a ${fit}. It is built to keep shape and comfort through ${useCase}.`,
        specifications: [
          `Category: ${product.category}`,
          `Fit profile: ${fit.charAt(0).toUpperCase()}${fit.slice(1)}`,
          `Available sizes: ${sizes.join(', ')}`,
          `MRP: ${product.price}`
        ],
        fabrication: [
          'Premium cotton-elastane blend with smooth finish',
          '4-way stretch knit for flexible movement',
          'Color retention treatment for long-lasting shade',
          'Reinforced stitching for repeated-wear durability'
        ],
        sizes,
        colors,
        gallery,
        colorVariants
      };
    }

    function clearHeaderSearchResults() {
      if (!headerSearchResults) return;
      headerSearchResults.innerHTML = '';
      headerSearchResults.classList.remove('has-items');
    }

    function renderHeaderSearchResults(query) {
      if (!headerSearchResults) return;
      const q = String(query || '').trim().toLowerCase();
      if (!q) {
        clearHeaderSearchResults();
        return;
      }

      const matches = getSearchableProducts()
        .filter((item) => `${item.name} ${item.category} ${item.meta}`.toLowerCase().includes(q))
        .slice(0, 6);

      if (!matches.length) {
        clearHeaderSearchResults();
        return;
      }

      headerSearchResults.innerHTML = matches
        .map((item) => `
          <button class="header-search-item" type="button" data-product="${item.slug}">
            <img src="${item.image}" alt="${item.alt}">
            <span class="header-search-item-name">${item.name}</span>
            <span class="header-search-item-price">${item.price}</span>
          </button>
        `)
        .join('');

      headerSearchResults.classList.add('has-items');
    }

    if (headerSearchResults) {
      headerSearchResults.addEventListener('click', (event) => {
        const item = event.target.closest('.header-search-item');
        if (!item) return;
        const slug = item.getAttribute('data-product');
        if (slug) {
          window.location.href = `?page=product&product=${slug}`;
        }
      });
    }

    const productDetailImage = document.getElementById('productDetailImage');
    const productDetailCategory = document.getElementById('productDetailCategory');
    const productDetailName = document.getElementById('productDetailName');
    const productDetailMeta = document.getElementById('productDetailMeta');
    const productDetailPrice = document.getElementById('productDetailPrice');
    const productDetailBreadcrumb = document.getElementById('productDetailBreadcrumb');
    const productDetailTabDesc = document.getElementById('productDetailTabDesc');
    const productDetailTabSpec = document.getElementById('productDetailTabSpec');
    const productDetailTabFabric = document.getElementById('productDetailTabFabric');
    const productThumbRow = document.getElementById('productThumbRow');
    const productSizeList = document.getElementById('productSizeList');
    const productColorList = document.getElementById('productColorList');
    const relatedProductsGrid = document.getElementById('relatedProductsGrid');
    const productAddToCartBtn = document.getElementById('productAddToCartBtn');
    const CART_STORAGE_KEY = 'youLeggingsCart';

    if (activePage === 'product' && productDetailImage && productDetailName) {
      const requestedProduct = params.get('product');
      const searchableProducts = getSearchableProducts();
      const productBySlug = searchableProducts.reduce((acc, item) => {
        acc[item.slug] = item;
        return acc;
      }, {});
      const fallbackProduct = searchableProducts.length ? searchableProducts[0] : null;
      const selectedProduct = (requestedProduct && productBySlug[requestedProduct]) ? productBySlug[requestedProduct] : fallbackProduct;
      const selectedSlug = selectedProduct ? selectedProduct.slug : '';

      if (selectedProduct) {
        const productProfile = buildProductProfile(selectedProduct, searchableProducts);

        productDetailImage.setAttribute('src', productProfile.gallery[0]);
        productDetailImage.setAttribute('alt', selectedProduct.alt);
        productDetailCategory.textContent = selectedProduct.category;
        productDetailName.textContent = selectedProduct.name;
        productDetailMeta.textContent = selectedProduct.meta;
        productDetailPrice.textContent = selectedProduct.price;
        if (productDetailBreadcrumb) {
          productDetailBreadcrumb.textContent = selectedProduct.name;
        }
        if (productDetailTabDesc) {
          productDetailTabDesc.textContent = productProfile.description;
        }
        if (productDetailTabSpec) {
          productDetailTabSpec.innerHTML = productProfile.specifications.map((item) => `<li>${item}</li>`).join('');
        }
        if (productDetailTabFabric) {
          productDetailTabFabric.innerHTML = productProfile.fabrication.map((item) => `<li>${item}</li>`).join('');
        }
        if (productSizeList) {
          productSizeList.innerHTML = productProfile.sizes
            .map((size, index) => `<button type="button" class="${index === 0 ? 'is-active' : ''}">${size}</button>`)
            .join('');
        }
        if (productColorList) {
          productColorList.innerHTML = productProfile.colors
            .map((color, index) => {
              let galleryImages = '';
              if (productProfile.colorVariants && productProfile.colorVariants[color.label]) {
                galleryImages = productProfile.colorVariants[color.label].join(',');
              }
              return `<button type="button" class="product-color ${index === 0 ? 'is-selected' : ''}" style="--swatch:${color.swatch};" aria-label="${color.label}" data-images="${galleryImages}"></button>`;
            })
            .join('');
        }
        if (productThumbRow) {
          productThumbRow.innerHTML = productProfile.gallery
            .map((image, index) => `<button class="product-thumb ${index === 0 ? 'is-active' : ''}" type="button"><img src="${image}" alt="${selectedProduct.name} thumbnail ${index + 1}"></button>`)
            .join('');
        }
        if (relatedProductsGrid) {
          const fallbackRelated = searchableProducts.filter((item) => item.slug !== selectedSlug);
          const sameCategory = fallbackRelated.filter((item) => item.category === selectedProduct.category);
          const differentCategory = fallbackRelated.filter((item) => item.category !== selectedProduct.category);
          const offset = Array.from(selectedSlug).reduce((sum, char) => sum + char.charCodeAt(0), 0) % (differentCategory.length || 1);
          const shiftedDifferent = [...differentCategory.slice(offset), ...differentCategory.slice(0, offset)];
          const relatedItems = [...sameCategory, ...shiftedDifferent].slice(0, 4);
          relatedProductsGrid.innerHTML = relatedItems.map((item) => `
            <div class="product-card shop-product-card" data-product="${item.slug}">
              <div class="product-image"><img src="${item.image}" alt="${item.alt || item.name}"></div>
              <div class="product-details shop-product-details">
                <p class="shop-product-category">${item.category}</p>
                <h3 class="product-name">${item.name}</h3>
                <div class="shop-product-bottom">
                  <div class="product-price">${item.price}</div>
                  <a href="?page=product&product=${item.slug}" class="shop-product-link">View</a>
                </div>
              </div>
            </div>
          `).join('');
        }
        if (productAddToCartBtn) {
          productAddToCartBtn.setAttribute('data-product', selectedSlug);
        }
      }
    }

    function getStoredCart() {
      try {
        const raw = localStorage.getItem(CART_STORAGE_KEY);
        const parsed = raw ? JSON.parse(raw) : [];
        return Array.isArray(parsed) ? normalizeCartItems(parsed) : [];
      } catch (error) {
        return [];
      }
    }

    function normalizeCartItems(items) {
      const normalized = [];
      const itemMap = new Map();
      (Array.isArray(items) ? items : []).forEach((item) => {
        const slug = String(item?.slug || '').trim();
        const size = String(item?.size || '').trim().toUpperCase();
        const color = String(item?.color || '').trim().toLowerCase();
        const qty = Math.max(1, Number(item?.qty) || 1);
        const key = `${slug}|${size}|${color}`;

        if (itemMap.has(key)) {
          const existing = itemMap.get(key);
          existing.qty += qty;
          return;
        }

        const safeItem = {
          slug,
          name: item?.name || '',
          image: item?.image || '',
          price: Number(item?.price) || 0,
          size: size || 'M',
          color: item?.color || 'Standard',
          qty
        };
        itemMap.set(key, safeItem);
        normalized.push(safeItem);
      });
      return normalized;
    }

    function updateCartBadge() {
      if (!cartCountBadge) return;
      const totalItems = getStoredCart().reduce((sum, item) => sum + (Number(item.qty) || 0), 0);
      cartCountBadge.textContent = String(totalItems);
      cartCountBadge.classList.toggle('has-items', totalItems > 0);
    }

    function setStoredCart(items) {
      try {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(normalizeCartItems(items)));
      } catch (error) {
        // Ignore storage failures gracefully.
      }
      updateCartBadge();
    }

    function parseMoney(value) {
      const amount = String(value || '').replace(/[^0-9]/g, '');
      return amount ? parseInt(amount, 10) : 0;
    }

    function formatMoney(value) {
      return `INR ${Math.round(Number(value || 0)).toLocaleString('en-IN')}`;
    }

    if (productSizeList) {
      productSizeList.addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;
        productSizeList.querySelectorAll('button').forEach((item) => item.classList.remove('is-active'));
        button.classList.add('is-active');
      });
    }

    if (productColorList) {
      productColorList.addEventListener('click', (event) => {
        const button = event.target.closest('.product-color');
        if (!button) return;
        productColorList.querySelectorAll('.product-color').forEach((item) => item.classList.remove('is-selected'));
        button.classList.add('is-selected');

        const imagesData = button.getAttribute('data-images');
        if (imagesData) {
          const images = imagesData.split(',');
          const mainImage = document.getElementById('productDetailImage');
          const thumbRow = document.getElementById('productThumbRow');

          if (mainImage && images.length > 0) {
            mainImage.setAttribute('src', images[0]);
          }
          if (thumbRow) {
            thumbRow.innerHTML = images.map((src, idx) => `<button class="product-thumb ${idx === 0 ? 'is-active' : ''}" type="button"><img src="${src}" alt="Color Thumbnail ${idx + 1}"></button>`).join('');
          }
        }
      });
    }

    if (productAddToCartBtn) {
      productAddToCartBtn.addEventListener('click', () => {
        const slug = productAddToCartBtn.getAttribute('data-product') || '';
        const selectedProduct = productCatalog[slug];
        if (!selectedProduct) return;

        const selectedSize = document.querySelector('.compact-size-list button.is-active')?.textContent.trim() || 'M';
        const selectedColor = document.querySelector('.product-color.is-selected')?.getAttribute('aria-label') || 'Standard';
        const unitPrice = parseMoney(selectedProduct.price);

        const cartItems = getStoredCart();
        const existingIndex = cartItems.findIndex((item) => item.slug === slug && item.size === selectedSize && item.color === selectedColor);

        if (existingIndex >= 0) {
          cartItems[existingIndex].qty += 1;
        } else {
          cartItems.push({
            slug,
            db_id: selectedProduct.db_id,
            name: selectedProduct.name,
            image: selectedProduct.image,
            price: unitPrice,
            size: selectedSize,
            color: selectedColor,
            qty: 1
          });
        }

        setStoredCart(cartItems);
        
        // Sync with server if logged in
        if (selectedProduct.db_id) {
            const formData = new FormData();
            formData.append('product_id', selectedProduct.db_id);
            formData.append('product_qty', 1); // cartstore expects product_qty
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch("{{ route('cart_save') }}", {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
        }

        showToast(`${selectedProduct.name} added to cart.`, 'success');
        const defaultText = 'Add to Cart';
        productAddToCartBtn.textContent = 'Added to Cart';
        productAddToCartBtn.disabled = true;
        window.setTimeout(() => {
          productAddToCartBtn.textContent = defaultText;
          productAddToCartBtn.disabled = false;
        }, 1000);
      });
    }

    const shopGrid = document.querySelector('#shop-page .shop-products .products-grid');
    const shopCards = shopGrid ? Array.from(shopGrid.querySelectorAll('.shop-product-card')) : [];
    const shopFilters = document.querySelector('#shop-page .shop-filters');
    const priceRangeLabel = shopFilters ? shopFilters.querySelector('.filter-range') : null;
    const priceSlider = shopFilters ? shopFilters.querySelector('input[type="range"]') : null;
    let currentShopSearch = (params.get('search') || '').trim().toLowerCase();
    let applyShopFiltersRef = null;

    function parsePrice(value) {
      const num = String(value || '').replace(/[^0-9.]/g, '');
      return num ? Math.floor(parseFloat(num)) : 0;
    }

    function extractSizes(metaText) {
      const sizeOrder = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'];
      const normalized = String(metaText || '').toUpperCase();
      const match = normalized.match(/(XS|S|M|L|XL|2XL|3XL|4XL|5XL)\s*-\s*(XS|S|M|L|XL|2XL|3XL|4XL|5XL)/);
      if (match) {
        const start = sizeOrder.indexOf(match[1]);
        const end = sizeOrder.indexOf(match[2]);
        if (start !== -1 && end !== -1) {
          const min = Math.min(start, end);
          const max = Math.max(start, end);
          return sizeOrder.slice(min, max + 1);
        }
      }
      return sizeOrder.filter((s) => normalized.includes(s));
    }

    function setupShopFilters() {
      if (!shopGrid || !shopFilters || !shopCards.length) return;

      const categoryInputs = Array.from(shopFilters.querySelectorAll('.filter-group:nth-child(2) input[type="checkbox"]'));
      const sizeInputs = Array.from(shopFilters.querySelectorAll('.filter-size input[type="checkbox"]'));
      const availabilityInputs = Array.from(shopFilters.querySelectorAll('.filter-group:nth-child(4) input[type="checkbox"]'));
      const sortInputs = Array.from(shopFilters.querySelectorAll('input[name="sort"]'));
      const clearFiltersBtn = document.getElementById('clearShopFiltersBtn');
      const categoryLabels = categoryInputs.map((input) => input.closest('label')?.textContent.trim()).filter(Boolean);
      const defaultCategory = categoryLabels[0] || 'YOU FULL LENGTH LEGGINGS';

      const productFilterMeta = {
        'nude-comfort-ankle': { category: 'YOU ANKLE LENGTH LEGGINGS', availability: 'in', discount: 18, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'] },
        'cobalt-core-legging': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 14, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'aqua-flex-active': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'out', discount: 10, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL'] },
        'neon-move-set': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 11, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'] },
        'scarlet-sport-fit': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 16, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'floral-blush-pair': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 9, sizes: ['M', 'L', 'XL', '2XL', '3XL'] },
        'olive-essential-set': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 13, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'] },
        'mint-aura-kurti-legging': { category: 'MERLYN FULL LENGTH LEGGINGS', availability: 'in', discount: 15, sizes: ['S', 'M', 'L', 'XL', '2XL'] },
        'indigo-flare-bottom': { category: 'MERLYN FULL LENGTH LEGGINGS', availability: 'out', discount: 8, sizes: ['M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'teal-grace-kurti-fit': { category: 'MERLYN FULL LENGTH LEGGINGS', availability: 'in', discount: 12, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'emerald-dot-kurta-set': { category: 'MERLYN FULL LENGTH LEGGINGS', availability: 'in', discount: 7, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'] },
        'citrus-classic-set': { category: 'YOU KIDS LEGGINGS', availability: 'in', discount: 20, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL'] },
        'orchid-everyday-kurti': { category: 'YOU KIDS LEGGINGS', availability: 'out', discount: 17, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'] },
        'plum-luxe-co-ord': { category: 'MERLYN FULL LENGTH LEGGINGS', availability: 'in', discount: 6, sizes: ['M', 'L', 'XL', '2XL', '3XL'] },
        'mustard-gleam-kurti': { category: 'YOU ANKLE LENGTH LEGGINGS', availability: 'in', discount: 19, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'ruby-festive-set': { category: 'YOU ANKLE LENGTH LEGGINGS', availability: 'in', discount: 10, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'] },
        'crimson-asym-tunic': { category: 'YOU ANKLE LENGTH LEGGINGS', availability: 'in', discount: 12, sizes: ['M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL'] },
        'ivory-print-lounge': { category: 'YOU KIDS LEGGINGS', availability: 'in', discount: 21, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'sunrise-everyday-fit': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 14, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL'] },
        'coral-motion-pair': { category: 'YOU ANKLE LENGTH LEGGINGS', availability: 'in', discount: 12, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL'] },
        'active-blue-flex': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 11, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'] },
        'cherry-street-edit': { category: 'MERLYN FULL LENGTH LEGGINGS', availability: 'out', discount: 9, sizes: ['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'azure-comfort-line': { category: 'YOU FULL LENGTH LEGGINGS', availability: 'in', discount: 13, sizes: ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'] },
        'classic-move-essential': { category: 'YOU KIDS LEGGINGS', availability: 'in', discount: 16, sizes: ['XS', 'S', 'M', 'L', 'XL'] }
      };

      shopCards.forEach((card, index) => {
        const slug = card.dataset.product || '';
        const nameText = card.querySelector('.product-name')?.textContent || '';
        const categoryText = card.querySelector('.shop-product-category')?.textContent || '';
        const priceText = card.querySelector('.product-price')?.textContent || '';
        const metaText = card.querySelector('.shop-product-meta')?.textContent || '';
        const mappedMeta = productFilterMeta[slug] || {};
        
        // Prefer DOM category if it's not the generic 'Premium' fallback
        const cardCategoryValue = (categoryText && categoryText !== 'Premium') ? categoryText.toUpperCase() : (mappedMeta.category || defaultCategory);
        const stockState = mappedMeta.availability || 'in';
        const mappedDiscount = typeof mappedMeta.discount === 'number' ? mappedMeta.discount : Math.max(5, Math.round((900 - parsePrice(priceText)) / 15));

        card.dataset.filterPrice = String(parsePrice(priceText));
        card.dataset.filterCategory = cardCategoryValue;
        const mappedSizes = Array.isArray(mappedMeta.sizes) && mappedMeta.sizes.length
          ? mappedMeta.sizes
          : extractSizes(metaText);
        card.dataset.filterSizes = mappedSizes.join(',');
        card.dataset.filterStock = stockState;
        card.dataset.filterDiscount = String(mappedDiscount);
        card.dataset.filterSearch = `${nameText} ${categoryText} ${metaText}`.toLowerCase();
      });

      function getCheckedLabels(inputs) {
        return inputs
          .filter((input) => input.checked)
          .map((input) => input.closest('label')?.textContent.trim())
          .filter(Boolean);
      }

      function applyShopFilters() {
        const maxPrice = priceSlider ? parseInt(priceSlider.value, 10) : 2500;
        const selectedCategories = getCheckedLabels(categoryInputs);
        const selectedSizes = getCheckedLabels(sizeInputs);
        const selectedAvailability = getCheckedLabels(availabilityInputs);
        const selectedSort = sortInputs.find((input) => input.checked)?.closest('label')?.textContent.trim().toLowerCase() || '';

        if (priceRangeLabel) {
          priceRangeLabel.textContent = `₹0 — ₹${maxPrice.toLocaleString('en-IN')}`;
        }

        const visibleCards = [];

        shopCards.forEach((card) => {
          const cardPrice = parseInt(card.dataset.filterPrice || '0', 10);
          const cardCategory = card.dataset.filterCategory || '';
          const cardSizes = (card.dataset.filterSizes || '').split(',').filter(Boolean);
          const cardStock = card.dataset.filterStock || 'in';
          const cardSearch = card.dataset.filterSearch || '';

          const matchPrice = cardPrice <= maxPrice;
          const matchCategory = !selectedCategories.length || selectedCategories.includes(cardCategory);
          const matchSize = !selectedSizes.length || selectedSizes.some((size) => cardSizes.includes(size.toUpperCase()));
          const matchSearch = !currentShopSearch || cardSearch.includes(currentShopSearch);

          let matchAvailability = true;
          if (selectedAvailability.length) {
            matchAvailability =
              (selectedAvailability.includes('In Stock') && cardStock === 'in') ||
              (selectedAvailability.includes('Out of Stock') && cardStock === 'out');
          }

          const isVisible = matchPrice && matchCategory && matchSize && matchAvailability && matchSearch;
          card.style.display = isVisible ? '' : 'none';
          if (isVisible) visibleCards.push(card);
        });

        if (selectedSort) {
          visibleCards.sort((a, b) => {
            if (selectedSort.includes('price')) {
              return parseInt(a.dataset.filterPrice || '0', 10) - parseInt(b.dataset.filterPrice || '0', 10);
            }
            if (selectedSort.includes('discount')) {
              return parseInt(b.dataset.filterDiscount || '0', 10) - parseInt(a.dataset.filterDiscount || '0', 10);
            }
            return 0;
          });
          visibleCards.forEach((card) => shopGrid.appendChild(card));
        }
      }

      const allInputs = [...categoryInputs, ...sizeInputs, ...availabilityInputs, ...sortInputs];
      allInputs.forEach((input) => input.addEventListener('change', applyShopFilters));
      if (priceSlider) priceSlider.addEventListener('input', applyShopFilters);
      applyShopFiltersRef = applyShopFilters;

      if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', () => {
          categoryInputs.forEach((input) => { input.checked = false; });
          sizeInputs.forEach((input) => { input.checked = false; });
          availabilityInputs.forEach((input) => { input.checked = false; });
          sortInputs.forEach((input) => { input.checked = false; });
          if (priceSlider) priceSlider.value = priceSlider.max || '2500';
          currentShopSearch = '';
          if (headerSearchInput) {
            headerSearchInput.value = '';
          }
          clearHeaderSearchResults();
          applyShopFilters();
          window.history.replaceState({}, '', '?page=shop');
        });
      }

      applyShopFilters();
    }

    setupShopFilters();

    function executeHeaderSearch() {
      if (!headerSearchInput) return;
      const rawQuery = headerSearchInput.value.trim();
      if (activePage !== 'shop') {
        const target = rawQuery ? `?page=shop&search=${encodeURIComponent(rawQuery)}` : '?page=shop';
        window.location.href = target;
        return;
      }

      currentShopSearch = rawQuery.toLowerCase();
      if (applyShopFiltersRef) {
        applyShopFiltersRef();
      }

      const nextUrl = rawQuery ? `?page=shop&search=${encodeURIComponent(rawQuery)}` : '?page=shop';
      window.history.replaceState({}, '', nextUrl);
    }

    if (headerSearchInput) {
      headerSearchInput.value = params.get('search') || '';
      headerSearchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
          event.preventDefault();
          executeHeaderSearch();
        }
      });
      headerSearchInput.addEventListener('input', () => {
        renderHeaderSearchResults(headerSearchInput.value);
        if (activePage === 'shop') {
          currentShopSearch = headerSearchInput.value.trim().toLowerCase();
          if (applyShopFiltersRef) {
            applyShopFiltersRef();
          }
        }
      });
    }

    document.addEventListener('click', (event) => {
      if (!headerSearchBar) return;
      if (!headerSearchBar.contains(event.target) && !searchToggleBtn?.contains(event.target)) {
        clearHeaderSearchResults();
      }
    });

    const productTabs = document.querySelectorAll('.product-tab-btn');
    const productPanels = document.querySelectorAll('.product-tab-panel');

    productTabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        const target = tab.getAttribute('data-tab-target');
        productTabs.forEach((item) => {
          item.classList.remove('is-active');
          item.setAttribute('aria-selected', 'false');
        });
        productPanels.forEach((panel) => panel.classList.remove('is-active'));
        tab.classList.add('is-active');
        tab.setAttribute('aria-selected', 'true');
        const activePanel = document.querySelector(`.product-tab-panel[data-tab-panel="${target}"]`);
        if (activePanel) activePanel.classList.add('is-active');
      });
    });

    if (productThumbRow) {
      productThumbRow.addEventListener('click', (event) => {
        const thumb = event.target.closest('.product-thumb');
        if (!thumb) return;
        const image = thumb.querySelector('img');
        if (!image || !productDetailImage) return;
        productDetailImage.setAttribute('src', image.getAttribute('src'));
        productDetailImage.setAttribute('alt', image.getAttribute('alt') || 'Product');
        productThumbRow.querySelectorAll('.product-thumb').forEach((item) => item.classList.remove('is-active'));
        thumb.classList.add('is-active');
      });
    }

    if (relatedProductsGrid) {
      relatedProductsGrid.addEventListener('click', (event) => {
        const link = event.target.closest('.shop-product-link');
        if (link) return;
        const card = event.target.closest('.shop-product-card');
        if (!card) return;
        const slug = card.getAttribute('data-product');
        if (slug) {
          window.location.href = `?page=product&product=${slug}`;
        }
      });
    }

    const cartItemsWrap = document.getElementById('cartItemsContainer');
    const cartSubtotalValue = document.getElementById('cartSubtotalValue');
    const cartShippingValue = document.getElementById('cartShippingValue');
    const cartTotalValue = document.getElementById('cartTotalValue');

    function renderCartPage() {
      if (!cartItemsWrap) return;
      const cartItems = getStoredCart();

      if (!cartItems.length) {
        cartItemsWrap.innerHTML = `
          <div class="cart-empty-state">
            <div style="font-size: 48px; margin-bottom: 16px;">🛍️</div>
            <h3 style="font-family: var(--font-serif); font-size: 1.6rem; margin-bottom: 10px; color: #3a2530;">Your cart is empty</h3>
            <p style="color: #7d6771; font-size: 15px; margin-bottom: 24px; line-height: 1.6;">Looks like you haven't added anything yet. Browse our premium collection and find your perfect fit.</p>
            <a href="?page=shop" class="btn" style="display:inline-block;">Shop Now</a>
          </div>
        `;
        if (cartSubtotalValue) cartSubtotalValue.textContent = formatMoney(0);
        if (cartShippingValue) cartShippingValue.textContent = formatMoney(0);
        if (cartTotalValue) cartTotalValue.textContent = formatMoney(0);
        return;
      }

      cartItemsWrap.innerHTML = cartItems.map((item, index) => `
        <article class="cart-item" data-cart-index="${index}">
          <div class="cart-item-img-wrap">
            <img src="${item.image}" alt="${item.name}" onerror="this.src='{{ asset('premium_assets/images/logo-new.png') }}'; this.style.padding='10px';">
          </div>
          <div class="cart-item-details">
            <div class="cart-item-main">
              <div class="cart-item-brand">YOU LEGGINGS</div>
              <h3 class="cart-item-name">${item.name}</h3>
              <div class="cart-item-meta">
                ${item.size ? `<span>Size: <strong>${item.size}</strong></span>` : ''}
                ${item.color ? `<span>Color: <strong>${item.color}</strong></span>` : ''}
              </div>
              <div class="cart-item-price-each">${formatMoney(item.price)} each</div>
            </div>
            <div class="cart-item-actions">
              <div class="cart-item-qty-stepper">
                <button type="button" data-cart-action="decrease" title="Decrease">−</button>
                <span class="qty-val">${item.qty}</span>
                <button type="button" data-cart-action="increase" title="Increase">+</button>
              </div>
              <div class="cart-item-total-price">
                ${formatMoney(item.price * item.qty)}
              </div>
              <button type="button" class="cart-item-del-btn" data-cart-action="remove" title="Remove Item">
                <i data-lucide="trash-2"></i>
              </button>
            </div>
          </div>
        </article>
      `).join('');



      const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.qty), 0);
      const shipping = subtotal > 999 ? 0 : (subtotal > 0 ? 49 : 0);
      const total = subtotal + shipping;

      if (cartSubtotalValue) cartSubtotalValue.textContent = formatMoney(subtotal);
      if (cartShippingValue) cartShippingValue.textContent = formatMoney(shipping === 0 && subtotal > 0 ? 0 : shipping);
      if (cartTotalValue) cartTotalValue.textContent = formatMoney(total);

      // Update shipping note visibility
      const shippingNote = document.getElementById('cartShippingNote');
      if (shippingNote) {
        if (subtotal > 0 && subtotal <= 999) {
          shippingNote.textContent = `Add INR ${(1000 - Math.round(subtotal)).toLocaleString('en-IN')} more for free shipping`;
          shippingNote.style.display = 'block';
        } else if (subtotal > 999) {
          shippingNote.textContent = '✓ Free shipping applied';
          shippingNote.style.color = '#4caf50';
        } else {
          shippingNote.style.display = 'none';
        }
      }

      // Re-init lucide icons for dynamic content
      if (window.lucide) lucide.createIcons();
    }

    if (cartItemsWrap) {
      cartItemsWrap.addEventListener('click', (event) => {
        const button = event.target.closest('button[data-cart-action]');
        const itemNode = event.target.closest('.cart-item');
        if (!button || !itemNode) return;

        const index = parseInt(itemNode.getAttribute('data-cart-index') || '-1', 10);
        if (index < 0) return;

        const action = button.getAttribute('data-cart-action');
        const cartItems = getStoredCart();
        if (!cartItems[index]) return;

        if (action === 'increase') {
          cartItems[index].qty += 1;
        } else if (action === 'decrease') {
          cartItems[index].qty -= 1;
          if (cartItems[index].qty <= 0) {
            cartItems.splice(index, 1);
          }
        } else if (action === 'remove') {
          cartItems.splice(index, 1);
        }

        setStoredCart(cartItems);
        renderCartPage();
      });
    }

    if (activePage === 'cart') {
      renderCartPage();
    }

    updateCartBadge();

    // Toast Notification System
    function showToast(message, type = 'success') {
      let container = document.querySelector('.toast-container');
      if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
      }

      const toast = document.createElement('div');
      toast.className = `toast toast-${type}`;

      const icon = type === 'success' ? 'check' : (type === 'error' ? 'x' : 'info');

      toast.innerHTML = `
        <div class="toast-icon"><i data-lucide="${icon}"></i></div>
        <div class="toast-message">${message}</div>
      `;

      container.appendChild(toast);
      lucide.createIcons();

      // Animate In
      setTimeout(() => toast.classList.add('show'), 100);

      // Remove after 3s
      setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 500);
      }, 4000);
    }

    // Infinite Testimonial Logic
    const tTrack = document.getElementById('testimonialsTrack');
    const tDotsContainer = document.getElementById('testimonialDots');
    let tIndex = 0;
    let tInterval;
    
    // Auto-generate dots
    if (tTrack && tDotsContainer) {
      const realCardsCount = tTrack.querySelectorAll('.testimonial-card').length / 2 || 1;
      for (let i = 0; i < realCardsCount; i++) {
        const dot = document.createElement('button');
        dot.className = `testimonial-dot ${i === 0 ? 'is-active' : ''}`;
        dot.setAttribute('aria-label', `Go to testimonial ${i + 1}`);
        tDotsContainer.appendChild(dot);
      }
    }
    
    const tDots = document.querySelectorAll('.testimonial-dot');

    function jumpTestimonial(index) {
      if (!tTrack || tDots.length === 0) return;
      const tTotal = tDots.length;
      tIndex = index;
      
      const isMobile = window.innerWidth <= 600;
      const isTablet = window.innerWidth <= 900 && !isMobile;
      
      let shiftBase;
      if (isMobile) {
        shiftBase = 'calc(100% + var(--spacing-md))';
      } else if (isTablet) {
        shiftBase = 'calc((100% - var(--spacing-md)) / 2 + var(--spacing-md))';
      } else {
        shiftBase = 'calc((100% - var(--spacing-md) * 2) / 3 + var(--spacing-md))';
      }

      tTrack.style.transition = 'transform 0.6s cubic-bezier(0.19, 1, 0.22, 1)';
      tTrack.style.transform = `translateX(calc(-${tIndex} * ${shiftBase}))`;

      tDots.forEach(dot => dot.classList.remove('is-active'));
      const activeDotIndex = tIndex % tTotal;
      if (tDots[activeDotIndex]) tDots[activeDotIndex].classList.add('is-active');

      if (tIndex >= tTotal) {
        setTimeout(() => {
          tTrack.style.transition = 'none';
          tIndex = 0;
          tTrack.style.transform = `translateX(0)`;
        }, 600);
      }
    }

    function startAutoScroll() {
      if (tInterval) clearInterval(tInterval);
      tInterval = setInterval(() => {
        jumpTestimonial(tIndex + 1);
      }, 7000);
    }

    if (tTrack && tDots.length > 0) {
      tDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          jumpTestimonial(index);
          startAutoScroll();
        });
      });
      startAutoScroll();
    }

    // Review Form Logic
    const openReviewFormBtn = document.getElementById('openReviewFormBtn');
    const cancelReviewBtn = document.getElementById('cancelReviewBtn');
    const submitReviewBtn = document.getElementById('submitReviewBtn');
    const reviewFormContainer = document.getElementById('reviewFormContainer');
    const productDetailTabReviews = document.getElementById('productDetailTabReviews');

    if (openReviewFormBtn) {
      openReviewFormBtn.addEventListener('click', () => {
        reviewFormContainer.style.display = 'block';
        openReviewFormBtn.style.display = 'none';
      });
    }

    if (cancelReviewBtn) {
      cancelReviewBtn.addEventListener('click', () => {
        reviewFormContainer.style.display = 'none';
        openReviewFormBtn.style.display = 'block';

        // clear inputs
        document.getElementById('reviewName').value = '';
        document.getElementById('reviewText').value = '';
        document.getElementById('reviewStars').value = '★★★★★';
      });
    }

    if (submitReviewBtn) {
      submitReviewBtn.addEventListener('click', () => {
        const nameInput = document.getElementById('reviewName').value.trim();
        const textInput = document.getElementById('reviewText').value.trim();
        const starsInput = document.getElementById('reviewStars').value;

        if (!nameInput || !textInput) {
          showToast('Please fill out your name and review text.', 'error');
          return;
        }

        const reviewHtml = `
          <div style="margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0dbe4;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
              <strong style="font-size: 15px; color: #5d3f4c;">${nameInput}</strong>
              <span style="color: #f59e0b; font-size: 14px;">${starsInput.split(' ')[0]}</span>
            </div>
            <p style="font-size: 14px; color: #6b5a63; margin-top: 5px;">${textInput}</p>
          </div>
        `;

        // Prepend the new review
        productDetailTabReviews.insertAdjacentHTML('afterbegin', reviewHtml);

        showToast('Review submitted successfully!', 'success');

        // Hide form and reset
        reviewFormContainer.style.display = 'none';
        openReviewFormBtn.style.display = 'block';
        document.getElementById('reviewName').value = '';
        document.getElementById('reviewText').value = '';
        document.getElementById('reviewStars').value = '★★★★★';
      });
    }
    // Banner Slider Logic
    const bannerItems = document.querySelectorAll('.hero-banner-item');
    if (bannerItems.length > 1) {
      let currentBanner = 0;
      setInterval(() => {
        bannerItems[currentBanner].style.opacity = '0';
        currentBanner = (currentBanner + 1) % bannerItems.length;
        bannerItems[currentBanner].style.opacity = '1';
      }, 5000);
    }
  </script>
</body>

</html>