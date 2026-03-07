<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | You Leggings</title>
    <link rel="stylesheet" href="{{ asset('premium_assets/style.css') }}">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="my-account-page-active">

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
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ $settings && $settings->logo ? (Str::contains($settings->logo, '/') ? asset($settings->logo) : asset('uploads/settings/'.$settings->logo)) : asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo">
            </a>

            <nav class="nav-links">
                <a href="{{ url('/') }}">HOME</a>
                <a href="{{ url('/?page=about') }}">ABOUT US</a>
                <a href="{{ url('/?page=shop') }}">SHOP</a>
                <a href="{{ url('/?page=new-arrivals') }}">NEW ARRIVALS</a>
                <a href="{{ url('/?page=blog') }}">BLOG</a>
                <a href="{{ url('/?page=contact') }}">CONTACT US</a>
            </nav>

            <div class="nav-icons text-dark">
                <button id="searchToggleBtn" class="nav-icon-btn" type="button" aria-label="Search">
                    <i data-lucide="search"></i>
                </button>
                <div class="nav-tooltip-wrap">
                    <a href="{{ url('/?page=login') }}" id="loginPageBtn" class="nav-icon-btn" aria-label="Account"
                        style="display: none;">
                        <i data-lucide="user"></i>
                    </a>
                    <span class="nav-tooltip">Login</span>
                </div>
                <div class="nav-tooltip-wrap">
                    <button id="dashboardBtn" class="nav-icon-btn" type="button" aria-label="Dashboard"
                        style="display: block;">
                        <i data-lucide="layout-dashboard"></i>
                    </button>
                    <span class="nav-tooltip">Dashboard</span>
                </div>
                <a href="{{ url('/?page=cart') }}" id="cartPageBtn" class="nav-icon-btn" aria-label="Cart">
                    <i data-lucide="shopping-bag"></i>
                    <span id="cartCountBadge" class="cart-count-badge" aria-live="polite">0</span>
                </a>
            </div>
        </div>
    </header>

    <!-- My Account Content -->
    <section class="section page-view my-account-page">
        <div class="page-main account-main" style="background-image: none; background-color: #9f9f9f;">
            <div class="page-main-overlay"></div>
            <div
                style="position: absolute; inset: 0; background-image: url('{{ asset('premium_assets/images/bg-less/_DSC8937-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
            </div>
            <div class="container page-main-content" style="margin-left: 110px">
                <span class="hero-subtitle">Shop Collection</span>
                <h1 class="hero-title">My Account</h1>
            </div>
        </div>

        <div class="container page-body" style="padding-top: 60px; padding-bottom: 80px;">
            <div class="account-layout">
                <aside class="account-sidebar">
                    <div class="account-sidebar-nav">
                        <button type="button" class="account-sidebar-btn is-active"
                            data-account-tab="overview">Dashboard</button>
                        <button type="button" class="account-sidebar-btn" data-account-tab="orders">Orders</button>
                        <button type="button" class="account-sidebar-btn" data-account-tab="address">Address</button>
                        <button type="button" class="account-sidebar-btn" data-account-tab="details">Account
                            Details</button>
                        <a href="{{ route('user.logout') }}" class="account-sidebar-btn" style="text-decoration: none; display: block;">Logout</a>
                    </div>
                </aside>

                <main class="account-content">
                    <!-- Dashboard Panel -->
                    <div id="overview-panel" class="account-content-panel is-active">
                        <h3
                            style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-style: normal; font-weight: 600; color: #000; font-size: 24px;">
                            Dashboard</h3>
                        <p>Hello, <span class="welcome-user-name">{{ $customer_name }}</span></p>
                        <p style="margin-top: 15px;">From your account dashboard you can easily check & view your recent
                            orders, manage your shipping and billing addresses and edit your password and account
                            details.</p>
                    </div>

                    <!-- Orders Panel -->
                    <div id="orders-panel" class="account-content-panel">
                        <h3
                            style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-style: normal; font-weight: 600; color: #000; font-size: 24px;">
                            Orders</h3>

                        <div class="orders-table-container">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->order_id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="order-status-badge status-{{ strtolower($order->status) }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>₹ {{ number_format($order->total ?? ($order->sub_total + $order->deliver_charge - ($order->discound_amount ?? 0)), 0) }}</td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <a href="{{ route('tracking', $order->id) }}" class="btn-sm" title="Track Order"><i data-lucide="truck" style="width:14px;"></i></a>
                                                <a href="{{ route('downloadPdf', $order->id) }}" class="btn-sm" title="Download Invoice"><i data-lucide="download" style="width:14px;"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="no-data">You haven't placed any orders yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Address Panel -->
                    <div id="address-panel" class="account-content-panel">
                        <h3
                            style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-style: normal; font-weight: 600; color: #000; font-size: 24px;">
                            Address</h3>
                        <div class="address-grid">
                            <div class="address-block">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <h4 style="margin:0;">Billing Address</h4>
                                </div>
                                <div class="address-data" id="billing-address-box">
                                    @if($billing_address)
                                        <p><strong>{{ $billing_address->first_name }} {{ $billing_address->last_name }}</strong></p>
                                        <p>{{ $billing_address->street_1 }}</p>
                                        @if($billing_address->street_2) <p>{{ $billing_address->street_2 }}</p> @endif
                                        <p>{{ $billing_address->town }}, {{ $state->state ?? '' }} - {{ $billing_address->pincode }}</p>
                                        <p>Phone: {{ $billing_address->phone_number }}</p>
                                    @else
                                        <p>No billing address set yet.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="address-block">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                    <h4 style="margin:0;">Shipping Address</h4>
                                </div>
                                <div class="address-data" id="shipping-address-box">
                                    @if($shipping_address)
                                        <p><strong>{{ $shipping_address->first_name }} {{ $shipping_address->last_name }}</strong></p>
                                        <p>{{ $shipping_address->street_1 }}</p>
                                        @if($shipping_address->street_2) <p>{{ $shipping_address->street_2 }}</p> @endif
                                        <p>{{ $shipping_address->town }}, {{ $shipping_address->state }} - {{ $shipping_address->pincode }}</p>
                                        <p>Phone: {{ $shipping_address->phone_number }}</p>
                                    @else
                                        <p>No shipping address set yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Panel -->
                    <div id="details-panel" class="account-content-panel">
                        <h3
                            style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-style: normal; font-weight: 600; color: #000; font-size: 24px;">
                            Account Details</h3>
                        <form id="details-form" action="{{ route('account.update', auth()->guard('users')->user()->id ?? 0) }}" method="POST"
                            style="display: flex; flex-direction: column; gap: 20px; max-width: 500px; margin-top: 10px;">
                            @csrf
                            <div>
                                <label style="display: block; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Full Name</label>
                                <input type="text" name="name" value="{{ $account->name ?? '' }}" placeholder="Display Name"
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Email Address</label>
                                <input type="email" name="email" value="{{ $account->email ?? '' }}" placeholder="Email Address"
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Phone Number</label>
                                <input type="text" value="{{ $account->phone ?? '' }}" disabled
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9; cursor: not-allowed;">
                                <small style="color: #666; font-size: 11px; margin-top: 5px; display: block;">Phone number cannot be changed as it's linked to your account verification.</small>
                            </div>
                            <button class="btn" type="submit" style="align-self: flex-start;">Update Profile</button>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

    <!-- Enhanced Premium Footer -->
    <footer class="new-bottom-footer">
        <div class="container">
            <div class="footer-main-grid">
                
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
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" style="height: 15px; opacity: 0.4;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" style="height: 15px; opacity: 0.4;">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        const accountSidebarBtns = document.querySelectorAll('.account-sidebar-btn');
        const accountPanels = document.querySelectorAll('.account-content-panel');

        accountSidebarBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-account-tab');
                if(!targetTab) return;

                // Update Side Nav
                accountSidebarBtns.forEach(b => b.classList.remove('is-active'));
                btn.classList.add('is-active');

                // Update Content
                accountPanels.forEach(panel => {
                    panel.classList.remove('is-active');
                    if (panel.id === `${targetTab}-panel`) {
                        panel.classList.add('is-active');
                    }
                });
            });
        });
    </script>
</body>

</html>
