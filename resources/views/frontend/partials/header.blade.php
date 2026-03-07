  <!-- Top Bar -->
  <div class="top-bar">
    <div class="top-bar-1">{{ $settings->top_bar_1 ?? 'Comfort in Every Move' }}</div>
    <div class="top-bar-2">{{ $settings->top_bar_2 ?? 'Luxury Made Affordable' }}</div>
    <div class="top-bar-3">{{ $settings->top_bar_3 ?? 'From TANTEX, For You' }}</div>
    <div class="top-bar-4">{{ $settings->top_bar_4 ?? 'Leggings That Fit Your Life' }}</div>
  </div>

  <!-- Navigation -->
  <header class="header">
    <div class="container nav-container">
      <a href="{{ route('index') }}" class="logo">
        <img src="{{ asset('storage/' . ($settings->logo ?? '')) }}" 
             onerror="this.src='{{ asset('frontend/images/logo-new.png') }}'" 
             alt="{{ $settings->title ?? 'You Leggings Logo' }}">
      </a>

      <nav class="nav-links">
        <a href="{{ route('index') }}">Home</a>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('shop') }}">Shop</a>
        <a href="{{ route('blog') }}">Blog</a>
        <a href="{{ route('contact') }}">Contact Us</a>
      </nav>

      <div class="nav-icons text-dark">
        <button id="searchToggleBtn" class="nav-icon-btn" type="button" aria-label="Search">
          <i data-lucide="search"></i>
        </button>
        <div class="nav-tooltip-wrap">
          <button id="loginPageBtn" class="nav-icon-btn" type="button" aria-label="Account">
            <i data-lucide="user"></i>
          </button>
          <span class="nav-tooltip">Login</span>
        </div>
        
        <button id="cartPageBtn" class="nav-icon-btn" type="button" aria-label="Cart">
          <i data-lucide="shopping-bag"></i>
          <span id="cartCountBadge" class="cart-count-badge" aria-live="polite">0</span>
        </button>
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
