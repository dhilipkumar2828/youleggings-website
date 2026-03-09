@extends('frontend.layouts.app')

@section('title', 'My Account | You Leggings')

@section('content')
  <!-- My Account Content -->
  <section class="section page-view my-account-page" style="display: block;">
    <div class="page-main account-main" style="background-color: #9f9f9f;">
      <div class="page-main-overlay"></div>
      <div
        style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8937-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;">
      </div>
      <div class="container page-main-content">
        <span class="hero-subtitle">User Dashboard</span>
        <h1 class="hero-title">My Account</h1>
      </div>
    </div>

    <div class="container page-body" style="padding-top: 60px; padding-bottom: 80px;">
      <div class="account-layout">
        <aside class="account-sidebar">
          <div class="account-sidebar-nav">
            <button type="button" class="account-sidebar-btn is-active" data-account-tab="overview">Dashboard</button>
            <button type="button" class="account-sidebar-btn" data-account-tab="orders">Orders</button>
            <button type="button" class="account-sidebar-btn" data-account-tab="address">Address</button>
            <button type="button" class="account-sidebar-btn" data-account-tab="details">Account Details</button>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
              @csrf
              <button type="submit" class="account-sidebar-btn">Logout</button>
            </form>
          </div>
        </aside>

        <main class="account-content">
          <!-- Dashboard Panel -->
          <div id="overview-panel" class="account-content-panel is-active">
            <h3 style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-weight: 600; color: #000; font-size: 24px;">Dashboard</h3>
            <p>Hello, <span class="welcome-user-name">{{ Auth::user()->name ?? 'Guest' }}</span></p>
            <p style="margin-top: 15px;">From your account dashboard you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
          </div>

          <!-- Orders Panel -->
          <div id="orders-panel" class="account-content-panel" style="display:none;">
            <h3 style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-weight: 600; color: #000; font-size: 24px;">Orders</h3>
            <div class="orders-table-container">
              <table class="orders-table">
                <thead>
                  <tr>
                    <th>S. No</th>
                    <th>Order Id</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td colspan="6" class="no-data">You have no orders yet.</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Address Panel -->
          <div id="address-panel" class="account-content-panel" style="display:none;">
            <h3 style="border-bottom: 1px dotted #ccc; padding-bottom: 15px; margin-bottom: 10px; font-weight: 600; color: #000; font-size: 24px;">Address</h3>
            <div class="address-grid">
                <div class="address-block">
                    <h4>Shipping Address</h4>
                    <p>{{ Auth::user()->address ?? 'No address set yet.' }}</p>
                </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
    const accountSidebarBtns = document.querySelectorAll('.account-sidebar-btn');
    const accountPanels = document.querySelectorAll('.account-content-panel');

    accountSidebarBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetTab = btn.getAttribute('data-account-tab');
            if(!targetTab) return;

            accountSidebarBtns.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');

            accountPanels.forEach(panel => {
                panel.style.display = 'none';
                if (panel.id === `${targetTab}-panel`) {
                    panel.style.display = 'block';
                }
            });
        });
    });
</script>
@endsection