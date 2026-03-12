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

  .order-body {
    padding: 20px 25px;
  }
  .order-meta {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    margin-bottom: 15px;
  }
  .order-meta-item { font-size: 14px; color: #666; }
  .order-meta-item strong { color: #333; }

  .order-items {
    display: flex;
    gap: 10px;
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
              <span class="status-badge {{ $statusClass }}">{{ $order->status }}</span>
            </div>
          </div>

          <div class="order-body">
            <div class="order-meta">
              <div class="order-meta-item">
                <strong>₹{{ number_format($order->total, 2) }}</strong><br>
                Total Amount
              </div>
              <div class="order-meta-item">
                <strong>{{ strtoupper($order->payment_type) }}</strong><br>
                Payment Method
              </div>
              <div class="order-meta-item">
                <strong>{{ ucfirst($order->payment_status ?? 'Pending') }}</strong><br>
                Payment Status
              </div>
              <div class="order-meta-item">
                <strong>{{ $orderProducts->count() }}</strong><br>
                Item(s)
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
                @endphp
                @if($imgSrc)
                  <img src="{{ image_url($imgSrc) }}" class="order-item-img" alt="{{ $itemName }}" title="{{ $itemName }} - {{ $variant }}">
                @else
                  <div class="order-item-img d-flex align-items-center justify-content-center" style="display:flex; align-items:center; justify-content:center; font-size:10px; color:#999; text-align:center; padding:5px;">
                    {{ Str::limit($itemName, 10) }}
                  </div>
                @endif
              @endforeach
            </div>

            <div class="order-total-row">
              <div style="font-size: 14px; color: #888;">
                @if($order->deliver_charge == 0)
                  🚚 <strong style="color:#2e7d32;">Free Delivery</strong>
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
