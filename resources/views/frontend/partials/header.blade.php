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
          <i data-lucide="search"></i>
        </button>
        <div class="nav-tooltip-wrap">
          <a href="{{ route('login_user') }}" id="loginPageBtn" class="nav-icon-btn" aria-label="Account">
            <i data-lucide="user"></i>
          </a>
          <span class="nav-tooltip">Login</span>
        </div>
        <div class="nav-tooltip-wrap">
          <a href="{{ route('login_user') }}" id="dashboardBtn" class="nav-icon-btn" style="display: none;" aria-label="Dashboard">
            <i data-lucide="layout-dashboard"></i>
          </a>
          <span class="nav-tooltip">Dashboard</span>
        </div>
        <a href="{{ route('cart') }}" id="cartPageBtn" class="nav-icon-btn" aria-label="Cart">
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
