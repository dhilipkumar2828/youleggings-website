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
            <a href="{{ url('/') }}#home" class="logo">
                <img src="{{ asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo">
            </a>

            <nav class="nav-links">
                <a href="{{ url('/') }}">HOME</a>
                <a href="{{ url('/aboutus') }}">ABOUT US</a>
                <a href="{{ url('/product_list') }}">SHOP</a>
                <a href="{{ url('/newarrival_list') }}">NEW ARRIVALS</a>
                <a href="{{ url('/blogs') }}">BLOG</a>
                <a href="{{ url('/contactus') }}">CONTACT US</a>
            </nav>

            <div class="nav-icons text-dark">
                <button id="searchToggleBtn" class="nav-icon-btn" type="button" aria-label="Search">
                    <i data-lucide="search"></i>
                </button>
                <div class="nav-tooltip-wrap">
                    <button id="loginPageBtn" class="nav-icon-btn" type="button" aria-label="Account"
                        style="display: none;">
                        <i data-lucide="user"></i>
                    </button>
                    <span class="nav-tooltip">Login</span>
                </div>
                <div class="nav-tooltip-wrap">
                    <button id="dashboardBtn" class="nav-icon-btn" type="button" aria-label="Dashboard"
                        style="display: block;">
                        <i data-lucide="layout-dashboard"></i>
                    </button>
                    <span class="nav-tooltip">Dashboard</span>
                </div>
                <button id="cartPageBtn" class="nav-icon-btn" type="button" aria-label="Cart">
                    <i data-lucide="shopping-bag"></i>
                    <span id="cartCountBadge" class="cart-count-badge" aria-live="polite">0</span>
                </button>
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
            <div class="container page-main-content">
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
                        <button type="button" class="account-sidebar-btn" id="logoutBtn">Logout</button>
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
                            <div class="orders-controls">
                                <div class="show-entries">
                                    Show
                                    <select>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    entries
                                </div>
                                <div class="search-box">
                                    Search: <input type="text">
                                </div>
                            </div>

                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>S. No</th>
                                        <th>Order Id</th>
                                        <th>Order Date</th>
                                        <th>Payment Status</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="no-data">No data available in table</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="orders-pagination">
                                <div class="pagination-info">
                                    Showing 0 to 0 of 0 entries
                                </div>
                                <div class="pagination-btns">
                                    <button class="pagination-btn disabled">Previous</button>
                                    <button class="pagination-btn disabled">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Panel -->
                    <div id="address-panel" class="account-content-panel">
                        <h3
                            style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-style: normal; font-weight: 600; color: #000; font-size: 24px;">
                            Address</h3>
                        <div class="address-grid">
                            <div class="address-block">
                                <h4>Billing Address</h4>
                                <div class="address-data" id="billing-address-box">
                                    <p>No billing address set yet.</p>
                                </div>
                            </div>
                            <div class="address-block">
                                <h4>Shipping Address</h4>
                                <div class="address-data" id="shipping-address-box">
                                    <p>No shipping address set yet.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Panel -->
                    <div id="details-panel" class="account-content-panel">
                        <h3
                            style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-style: normal; font-weight: 600; color: #000; font-size: 24px;">
                            Account Details</h3>
                        <form id="details-form"
                            style="display: flex; flex-direction: column; gap: 20px; max-width: 500px; margin-top: 10px;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <label
                                        style="display: block; font-size: 13px; margin-bottom: 8px; font-weight: 600;">First
                                        Name</label>
                                    <input type="text" id="details-firstname" placeholder="First Name"
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; outline: none;">
                                </div>
                                <div>
                                    <label
                                        style="display: block; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Last
                                        Name</label>
                                    <input type="text" id="details-lastname" placeholder="Last Name"
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; outline: none;">
                                </div>
                            </div>
                            <div>
                                <label
                                    style="display: block; font-size: 13px; margin-bottom: 8px; font-weight: 600;">Email
                                    Address</label>
                                <input type="email" id="details-email" placeholder="Email Address"
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; outline: none;">
                            </div>
                            <button class="btn" type="submit" style="align-self: flex-start;">Save Changes</button>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="new-bottom-footer">
        <div class="container footer-content-wrap">
            <div class="footer-left-info">
                <div class="footer-logo-circle">
                    <img src="{{ asset('premium_assets/images/logo-new.png') }}" alt="You Leggings Logo">
                </div>
                <div class="footer-address">
                    <strong>You Leggings</strong>
                    <p>5/4, Surya Nagar, 2nd Street,<br> Bridgeway Colony Extn,<br>Tirupur - 641607</p>
                </div>
            </div>
            <div class="footer-center-copyright">
                &copy; 2026 You Leggings. All rights reserved.
            </div>
            <div class="footer-right-socials">
                <a href="#" class="social-icon-simple" aria-label="Facebook"><i data-lucide="facebook"></i></a>
                <a href="#" class="social-icon-simple" aria-label="Instagram"><i data-lucide="instagram"></i></a>
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
