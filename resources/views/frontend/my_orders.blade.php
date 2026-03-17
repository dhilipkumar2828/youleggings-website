@extends('frontend.layouts.app')

@section('title', 'My Orders | You Leggings')

@section('styles')
<style>
  .orders-wrapper {
    padding: 160px 0 100px;
    background: #fdfbfb;
    min-height: 100vh;
  }
  .page-header {
    margin-bottom: 40px;
  }
  .page-header h1 {
    font-family: var(--font-serif, serif);
    font-size: 36px;
    color: #222;
  }
  .page-header p { color: #888; }

  .order-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.03);
    transition: 0.3s;
  }
  .order-card:hover { box-shadow: 0 10px 35px rgba(0,0,0,0.07); transform: translateY(-2px); }

  .order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #f8f8f8;
    flex-wrap: wrap;
    gap: 10px;
    background: #fafafa;
  }
  .order-id {
    font-size: 13px;
    color: #888;
  }
  .order-id strong { color: #222; font-size: 16px; display: block; }
  
  .status-badge {
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .status-pending { background: #fff8e1; color: #f57f17; }
  .status-confirmed, .status-processing { background: #e3f2fd; color: #1565c0; }
  .status-shipped { background: #f3e5f5; color: #6a1b9a; }
  .status-delivered { background: #e8f5e9; color: #2e7d32; }
  .status-cancelled { background: #ffebee; color: #c62828; }

  .order-meta {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
  }
  @media (max-width: 767px) {
    .order-meta { grid-template-columns: 1fr 1fr; }
  }
  .meta-value { font-size: 15px; font-weight: 700; color: #333; margin-bottom: 5px; }
  .meta-label { font-size: 12px; color: #888; font-weight: 600; text-transform: capitalize; }

  .order-items {
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
  }
  .order-item-img {
    width: 60px;
    height: 75px;
    border-radius: 8px;
    object-fit: cover;
    background: #f5f5f5;
    border: 1px solid #eee;
  }

  .order-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px dashed #eee;
  }
  .order-total-amount {
    font-size: 20px;
    font-weight: 800;
    color: #ec407a;
  }

  .empty-orders {
    text-align: center;
    padding: 80px 20px;
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
  }
</style>
@endsection

@section('content')
<section class="orders-wrapper">
  <div class="container">
    <div class="page-header">
      <h1>My Orders</h1>
      <p>Track and manage your orders from You Leggings</p>
    </div>

    @if(count($orders) > 0)
      @foreach($orders as $order)
        @php
          $statusClass = match(strtolower($order->status)) {
            'pending'   => 'status-pending',
            'confirmed', 'processing' => 'status-confirmed',
            'shipped'   => 'status-shipped',
            'delivered' => 'status-delivered',
            'cancelled' => 'status-cancelled',
            default     => 'status-pending',
          };
          // Parse order_products for this order
          $orderProducts = \App\Models\OrderProduct::where('order_id', $order->id)->get();
        @endphp

        <div class="order-card">
          <div class="order-header">
            <div class="order-id">
              <strong>{{ $order->order_id }}</strong>
              Placed on {{ $order->created_at->format('d M Y, h:i A') }}
            </div>
            <div style="display:flex; gap:12px; align-items:center;">
              <a href="{{ route('order_invoice', $order->id) }}" target="_blank" style="font-size: 11px; font-weight: 700; color: #ec407a; border: 1px solid #fdeef2; padding: 5px 15px; border-radius: 5px; text-decoration: none; background: #fffafb;">
                <i class="fas fa-file-invoice" style="margin-right:5px;"></i> INVOICE
              </a>
              {{-- <span class="status-badge {{ $statusClass }}">{{ $order->status }}</span> --}}
            </div>
          </div>

          <div class="order-body" style="padding: 25px;">
            <div class="order-meta">
              <div class="order-meta-item">
                <div class="meta-value">₹{{ number_format($order->total, 2) }}</div>
                <div class="meta-label">Total Amount</div>
              </div>
              <div class="order-meta-item">
                <div class="meta-value">{{ !empty($order->payment_type) ? strtoupper($order->payment_type) : 'COD' }}</div>
                <div class="meta-label">Payment Method</div>
              </div>
              <div class="order-meta-item">
                @php
                  $pStatus = trim($order->payment_status);
                  if(empty($pStatus)) $pStatus = 'Pending';
                  $pStatusClass = strtolower($pStatus) == 'completed' || strtolower($pStatus) == 'paid' ? 'status-delivered' : 'status-pending';
                @endphp
                <div class="meta-value">
                  <span class="status-badge {{ $pStatusClass }}" style="padding: 2px 10px; font-size: 10px;">{{ ucfirst($pStatus) }}</span>
                </div>
                <div class="meta-label">Payment Status</div>
              </div>
              <div class="order-meta-item">
                <div class="meta-value">{{ count($orderProducts) }}</div>
                <div class="meta-label">Item(S)</div>
              </div>
            </div>

            {{-- Show order item thumbnails --}}
            <div class="order-items">
              @foreach($orderProducts as $item)
                @php
                  $option = json_decode($item->option, true);
                  $imgSrc = $option['image'] ?? '';
                  $itemName = $option['name'] ?? 'Product';
                  $variant = $option['variant'] ?? '';
                  
                  // Clean image URL if it's absolute but on local/demo domain
                  $displayImg = image_url($imgSrc);
                @endphp
                @if($imgSrc)
                  <img src="{{ $displayImg }}" class="order-item-img" alt="{{ $itemName }}" title="{{ $itemName }} - {{ $variant }}" onerror="this.src='{{ asset('frontend/images/logo-new.png') }}'; this.style.opacity='0.5';">
                @else
                  <div class="order-item-img" style="display:flex; align-items:center; justify-content:center; font-size:10px; color:#999; text-align:center; padding:5px; background:#f9f9f9;">
                    <i class="fas fa-box-open" style="font-size: 20px; color: #eee;"></i>
                  </div>
                @endif
              @endforeach
            </div>

            <div class="order-total-row">
              <div style="font-size: 13px; color: #888;">
                @if($order->deliver_charge == 0)
                  🚚 Delivery: Free
                @else
                  🚚 Delivery: ₹{{ $order->deliver_charge }}
                @endif
              </div>
              <div class="order-total-amount">₹{{ number_format($order->total, 2) }}</div>
            </div>
          </div>
        </div>
      @endforeach
    @else
      <div class="empty-orders">
        <div style="font-size: 60px; margin-bottom: 20px;">📦</div>
        <h3 style="font-family: var(--font-serif, serif); font-size: 28px; margin-bottom: 10px;">No Orders Yet</h3>
        <p style="color: #888; margin-bottom: 30px;">You haven't placed any orders yet. Start shopping!</p>
        <a href="{{ route('shop') }}" style="background: #ec407a; color: #fff; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 700; display: inline-block;">
          Start Shopping
        </a>
      </div>
    @endif
  </div>
</section>
@endsection

@section('scripts')
<script>
    @if(session('order_success') || session('success'))
        // Clear the cart on successful order placement
        localStorage.removeItem('you_cart_items');
        localStorage.removeItem('you_applied_coupon');
        if(window.updateCartBadge) window.updateCartBadge();
        
        // Remove the query parameter if it exists so refresh doesn't trigger again
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    @endif
</script>
@endsection
