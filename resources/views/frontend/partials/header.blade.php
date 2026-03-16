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
        
       
        <div class="nav-tooltip-wrap">
          <a href="{{ route('wishlist') }}" class="nav-icon-btn" aria-label="Wishlist">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ec407a;"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
            @php
                $wishlistCount = Auth::check() ? \App\Models\Wishlist::where('customer_id', Auth::id())->count() : 0;
            @endphp
            <span id="wishlistCountBadge" class="cart-count-badge {{ $wishlistCount > 0 ? 'has-items' : '' }}" style="background: var(--primary-color, #ec407a); z-index: 5;">{{ $wishlistCount }}</span>
          </a>
          <span class="nav-tooltip">Wishlist</span>
        </div>

        <a href="{{ route('cart') }}" id="cartPageBtn" class="nav-icon-btn" aria-label="Cart">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
          <span id="cartCountBadge" class="cart-count-badge" aria-live="polite">0</span>
        </a>


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

        
      </div>
      <form id="headerSearchBar" action="{{ route('shop') }}" method="GET" class="header-search" aria-hidden="true">
        <div class="header-search-row">
          <input type="text" name="q" placeholder="Search products..." aria-label="Search products" value="{{ request('q') }}">
          <button id="searchCloseBtn" class="header-search-close" type="button" aria-label="Close Search">
            <i data-lucide="x"></i>
          </button>
        </div>
        <div id="headerSearchResults" class="header-search-results" aria-label="Search Results"></div>
      </form>
    </div>
  </header>
