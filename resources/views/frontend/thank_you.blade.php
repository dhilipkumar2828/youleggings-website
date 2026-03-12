@extends('frontend.layouts.app')

@section('title', 'Order Placed Successfully | You Leggings')

@section('styles')
<style>
  .success-wrapper {
    padding: 160px 0 100px;
    background: linear-gradient(135deg, #fff8fc 0%, #fdf5ff 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
  .success-card {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 30px 80px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
    padding: 60px 50px;
    max-width: 700px;
    margin: 0 auto;
    text-align: center;
  }
  .success-icon {
    width: 110px;
    height: 110px;
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    color: #2e7d32;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    animation: pop 0.5s ease;
  }
  @keyframes pop {
    0% { transform: scale(0); opacity: 0; }
    70% { transform: scale(1.15); }
    100% { transform: scale(1); opacity: 1; }
  }
  .success-title {
    font-family: var(--font-serif, serif);
    font-size: 38px;
    color: #222;
    margin-bottom: 10px;
  }
  .order-badge {
    display: inline-block;
    background: linear-gradient(135deg, #ec407a, #f06292);
    color: #fff;
    padding: 10px 30px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 1px;
    margin: 20px 0;
    box-shadow: 0 8px 20px rgba(236, 64, 122, 0.3);
  }
  .order-meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin: 30px 0;
    text-align: left;
  }
  .order-meta-item {
    background: #fafafa;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 15px 20px;
  }
  .order-meta-item label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    color: #999;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
  }
  .order-meta-item span {
    font-size: 15px;
    font-weight: 700;
    color: #333;
  }
  .action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 30px;
  }
  .btn-primary-pink {
    background: linear-gradient(135deg, #ec407a, #f06292);
    color: #fff;
    padding: 16px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    transition: 0.3s;
    box-shadow: 0 10px 25px rgba(236, 64, 122, 0.25);
    font-size: 15px;
  }
  .btn-primary-pink:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(236, 64, 122, 0.35); color: #fff; }
  .btn-outline-dark {
    background: #fff;
    color: #333;
    padding: 16px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    transition: 0.3s;
    border: 2px solid #333;
    font-size: 15px;
  }
  .btn-outline-dark:hover { background: #333; color: #fff; }
  .confetti-bar {
    height: 6px;
    background: linear-gradient(90deg, #ec407a, #f48fb1, #ab47bc, #7e57c2, #42a5f5, #26c6da, #66bb6a, #ffca28, #ff7043, #ec407a);
    border-radius: 6px;
    margin-bottom: 35px;
    animation: shimmer 3s infinite;
    background-size: 200% auto;
  }
  @keyframes shimmer {
    0% { background-position: 0% center; }
    100% { background-position: 200% center; }
  }
</style>
@endsection

@section('content')
<section class="success-wrapper">
  <div class="container">
    <div class="success-card">
      <div class="confetti-bar"></div>

      <div class="success-icon">
        <i data-lucide="check-circle-2" style="width: 60px; height: 60px;"></i>
      </div>

      <h1 class="success-title">Order Placed! 🎉</h1>
      <p style="color: #888; font-size: 16px; margin-bottom: 5px;">
        Thank you for shopping with <strong>You Leggings</strong>!
      </p>

      @php $order = session('last_order'); @endphp

      @if($order)
        <div class="order-badge">Order ID: {{ $order['order_id'] }}</div>

        <p style="color: #666; font-size: 14px;">A confirmation has been sent to <strong>{{ $order['email'] }}</strong></p>

        <div class="order-meta-grid">
          <div class="order-meta-item">
            <label>Customer Name</label>
            <span>{{ $order['name'] }}</span>
          </div>
          <div class="order-meta-item">
            <label>Order Total</label>
            <span style="color: #ec407a;">₹{{ number_format($order['total'], 2) }}</span>
          </div>
          <div class="order-meta-item">
            <label>Payment Method</label>
            <span>{{ strtoupper($order['payment']) }}</span>
          </div>
          <div class="order-meta-item">
            <label>Items Ordered</label>
            <span>{{ $order['items_count'] }} item(s)</span>
          </div>
          <div class="order-meta-item" style="grid-column: span 2;">
            <label>Shipping To</label>
            <span>{{ $order['address'] }}</span>
          </div>
        </div>
      @else
        <div class="order-badge">Order Confirmed ✓</div>
        <p style="color: #666; margin: 20px 0;">Your order has been received and is being processed.</p>
      @endif

      <div class="action-buttons">
        <a href="{{ route('shop') }}" class="btn-outline-dark">Continue Shopping</a>
        @auth
          <a href="{{ route('my_orders') }}" class="btn-primary-pink">
            <i data-lucide="package" style="width:16px; display:inline; margin-right:6px;"></i>
            My Orders
          </a>
        @else
          <a href="{{ route('login_user') }}" class="btn-primary-pink">Track Your Order</a>
        @endauth
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
    // Clear the cart on successful order placement
    localStorage.removeItem('you_cart_items');
    if(window.updateCartBadge) window.updateCartBadge();
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
@endsection
