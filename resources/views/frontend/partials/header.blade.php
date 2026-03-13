  <!-- Top Bar -->
  <div class="top-bar">
    <div class="top-bar-1">Comfort in Every Move</div>
    <div class="top-bar-2">Luxury Made Affordable</div>
    <div class="top-bar-3">From TANTEX, For You</div>
    <div class="top-bar-4">Leggings That Fit Your Life</div>
  </div>

  <!-- Navigation -->
  <header class="header">
    <div class="container nav-container">
      <a href="{{ route('index') }}" class="logo">
        <img src="{{ asset('frontend/images/logo-new.png') }}" alt="You Leggings Logo">
      </a>

      <nav class="nav-links">
        <a href="{{ route('index') }}" class="{{ request()->routeIs('index') ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
        <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
        <a href="{{ route('shop') }}?new-arrivals=1" class="{{ request('new-arrivals') ? 'active' : '' }}">New Arrivals</a>
        <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
      </nav>

      <div class="nav-icons text-dark">
        <button id="searchToggleBtn" class="nav-icon-btn" type="button" aria-label="Search">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </button>
        
        @guest
        <div class="nav-tooltip-wrap">
          <a href="{{ route('login_user') }}" class="nav-icon-btn" aria-label="Login">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </a>
          <span class="nav-tooltip">Login / Register</span>
        </div>
        @endguest

        @auth
        <div class="nav-tooltip-wrap">
          <a href="{{ route('my_account') }}" class="nav-icon-btn" aria-label="Account">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </a>
          <span class="nav-tooltip">My Account</span>
        </div>
        @endauth

        <div class="nav-tooltip-wrap">
          <a href="{{ route('wishlist') }}" class="nav-icon-btn" aria-label="Wishlist">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.84-8.84 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            @php
                $wishlistCount = Auth::check() ? \App\Models\Wishlist::where('customer_id', Auth::id())->count() : 0;
            @endphp
            <span id="wishlistCountBadge" class="cart-count-badge {{ $wishlistCount > 0 ? 'has-items' : '' }}" style="background: var(--primary-color, #ec407a); z-index: 5;">{{ $wishlistCount }}</span>
          </a>
          <span class="nav-tooltip">Wishlist</span>
        </div>

        <a href="{{ route('cart') }}" id="cartPageBtn" class="nav-icon-btn" aria-label="Cart">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
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
