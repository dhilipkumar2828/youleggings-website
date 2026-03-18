@extends('frontend.layouts.app')

@section('title', 'My Orders | You Leggings')

@section('styles')
<style>
   .account-main { flex: 1; padding: 40px; min-width: 0; }
  @media (max-width: 991px) { .account-main { padding: 30px; } }
  @media (max-width: 575px) { .account-main { padding: 15px; } }

  .panel-title { font-family: var(--font-serif, serif); font-size: 28px; margin-bottom: 30px; border-bottom: 1px solid #f8f8f8; padding-bottom: 20px; }
  @media (max-width: 575px) { .panel-title { font-size: 24px; margin-bottom: 20px; } }

  .order-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
    margin-bottom: 30px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    transition: all 0.3s ease;
  }
  .order-card:hover { 
    box-shadow: 0 15px 40px rgba(0,0,0,0.06); 
    transform: translateY(-4px);
    border-color: #fce4ec;
  }

  .order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 25px;
    border-bottom: 1px solid #f9f9f9;
    background: #fdfdfd;
    gap: 15px;
    flex-wrap: wrap;
  }
  @media (max-width: 600px) {
    .order-header { padding: 15px; flex-direction: column; align-items: flex-start; }
    .order-header > div { width: 100%; display: flex; justify-content: space-between; align-items: center; }
  }
  /* @media (max-width: 350px) {
    .order-header > div { flex-direction: column; align-items: flex-start; gap: 10px; }
  } */

  .order-id-group { display: flex; flex-direction: column; }
  .order-id-label { font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-bottom: 2px; }
  .order-id-value { font-family: var(--font-serif, serif); font-size: 16px; color: #333; font-weight: 700; }
  
  .status-badge {
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
  }
  .status-badge::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
  }
  
  .status-pending { background: #fff8e1; color: #f57f17; }
  .status-confirmed, .status-processing { background: #e3f2fd; color: #1565c0; }
  .status-shipped { background: #f3e5f5; color: #6a1b9a; }
  .status-delivered { background: #e8f5e9; color: #2e7d32; }
  .status-cancelled { background: #ffebee; color: #c62828; }

  .order-body { padding: 25px; }
  @media (max-width: 575px) { .order-body { padding: 15px; } }
  
  .order-meta {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    background: #fafafa;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 25px;
  }
  @media (max-width: 900px) {
    .order-meta { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 480px) {
    .order-meta { grid-template-columns: 1fr; gap: 15px; padding: 15px; }
  }
  .meta-item { display: flex; flex-direction: column; min-width: 0; }
  .meta-label { font-size: 11px; color: #a18a91; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
  .meta-value { font-size: 14px; font-weight: 700; color: #444; word-break: break-word; }

  .order-items-scroll {
    display: flex;
    gap: 12px;
    padding-bottom: 10px;
    overflow-x: auto;
    margin-bottom: 20px;
  }
  .order-items-scroll::-webkit-scrollbar { height: 4px; }
  .order-items-scroll::-webkit-scrollbar-thumb { background: #eee; border-radius: 10px; }

  .item-thumb-wrapper {
    position: relative;
    flex: 0 0 50px;
  }
  .order-item-img {
    width: 50px;
    height: 65px;
    border-radius: 8px;
    object-fit: cover;
    background: #f5f5f5;
    border: 1px solid #eee;
    transition: 0.2s;
  }
  .order-item-img:hover { border-color: #ec407a; }

  .order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px dashed #eee;
    gap: 15px;
    flex-wrap: wrap;
  }
  @media (max-width: 550px) {
    .order-footer { flex-direction: column; align-items: flex-start; }
    .order-total-group { text-align: left; width: 100%; display: flex; justify-content: space-between; align-items: baseline; }
  }
  .delivery-info { font-size: 13px; color: #777; display: flex; align-items: center; gap: 8px; }
  .order-total-group { text-align: right; }
  .total-label { font-size: 12px; color: #999; display: block; }
  .total-amount { font-size: 22px; font-weight: 900; color: #ec407a; line-height: 1; }

  .empty-orders {
    text-align: center;
    padding: 100px 40px;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
  }
  .empty-icon { font-size: 70px; margin-bottom: 25px; filter: grayscale(1); opacity: 0.3; }
</style>
@endsection

@section('content')
<section class="account-container">
  <div class="container">
    <div class="account-card">
      
      @include('frontend.partials.account_sidebar')

      <main class="account-main">
        <h2 class="panel-title">My Orders</h2>

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
                <div class="order-id-group">
                  <span class="order-id-label">Order Reference</span>
                  <span class="order-id-value">{{ $order->order_id }}</span>
                </div>
                <div style="display:flex; gap:12px; align-items:center;">
                  <span class="status-badge {{ $statusClass }}">{{ $order->status ?: 'Pending' }}</span>
                  <a href="{{ route('order_invoice', $order->id) }}" target="_blank" style="font-size: 11px; font-weight: 700; color: #ec407a; border: 1px solid #fdeef2; padding: 7px 18px; border-radius: 50px; text-decoration: none; background: #fffafb; transition: 0.3s;">
                    <i class="fas fa-file-invoice" style="margin-right:5px;"></i> INVOICE
                  </a>
                </div>
              </div>

              <div class="order-body">
                <div class="order-meta">
                  {{-- Product Thumbnails as first item --}}
                  <div class="meta-item" style="grid-row: span 1;">
                    <span class="meta-label">Products</span>
                    <div class="order-items-scroll" style="margin-bottom: 0; padding-bottom: 0; margin-top: 5px;">
                      @foreach($orderProducts as $item)
                        @php
                          $option = json_decode($item->option, true);
                          $imgSrc = $option['image'] ?? '';
                          $itemName = $option['name'] ?? 'Product';
                          $variant = $option['variant'] ?? '';
                          $displayImg = image_url($imgSrc);
                        @endphp
                        <div class="item-thumb-wrapper" style="flex: 0 0 50px;">
                          @if($imgSrc)
                            <img src="{{ $displayImg }}" class="order-item-img" style="width: 50px; height: 60px;" alt="{{ $itemName }}" title="{{ $itemName }} - {{ $variant }}" onerror="this.src='{{ asset('frontend/images/logo-new.png') }}'; this.style.opacity='0.5';">
                          @else
                            <div class="order-item-img" style="width: 50px; height: 60px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#999; text-align:center; padding:5px; background:#f9f9f9;">
                              <i class="fas fa-box-open" style="font-size: 14px; color: #eee;"></i>
                            </div>
                          @endif
                        </div>
                      @endforeach
                    </div>
                  </div>

                  <div class="meta-item">
                    <span class="meta-label">Placed On</span>
                    <span class="meta-value" style="font-size: 13px;">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                  </div>
                  <div class="meta-item">
                    <span class="meta-label">Payment Method</span>
                    <span class="meta-value">{{ !empty($order->payment_type) ? strtoupper($order->payment_type) : 'COD' }}</span>
                  </div>
                  <div class="meta-item">
                    <span class="meta-label">Payment Status</span>
                    @php
                      $pStatus = trim($order->payment_status);
                      if(empty($pStatus)) $pStatus = 'Pending';
                      $pStatusClass = strtolower($pStatus) == 'completed' || strtolower($pStatus) == 'paid' ? 'status-delivered' : 'status-pending';
                    @endphp
                    <span class="status-badge {{ $pStatusClass }}" style="padding: 4px 12px; font-size: 10px; margin-top:4px;">{{ ucfirst($pStatus) }}</span>
                  </div>
                </div>

                <div class="order-footer">
                  <div class="delivery-info">
                    @if($order->deliver_charge == 0)
                      <i class="fas fa-shipping-fast" style="color:#4caf50;"></i> Free Delivery
                    @else
                      <i class="fas fa-truck" style="color:#ec407a;"></i> Delivery: ₹{{ $order->deliver_charge }}
                    @endif
                  </div>
                  <div class="order-total-group">
                    <span class="total-label">Total Amount Paid</span>
                    <span class="total-amount">₹{{ number_format($order->total, 2) }}</span>
                  </div>
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
      </main>
    </div>
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
