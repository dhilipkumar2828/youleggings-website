@extends('frontend.layouts.app')

@section('title', 'Your Cart | You Leggings')

@section('content')
  <section class="section page-view cart-page" style="display: block;">
    <div class="page-main cart-main" style="background-color: #9f9f9f;">
      <div class="hero-overlay"></div>
      <div style="position: absolute; inset: 0; background-image: url('{{ asset('frontend/images/bg-less/_DSC8659-Photoroom.png') }}'); background-size: auto 110%; background-position: right 100% top 50%; background-repeat: no-repeat; transform: scaleX(-1); z-index: 2;"></div>
      <div class="container page-main-content">
        <span class="hero-subtitle">Your Selection</span>
        <h1 class="hero-title">Shopping Cart</h1>
      </div>
    </div>

    <div class="container page-body" style="padding-top: 60px; padding-bottom: 100px;">
      <div id="cartEmptyState" style="display: none; text-align: center; padding: 50px 0;">
        <i data-lucide="shopping-bag" style="width: 64px; height: 64px; color: #ddd; margin-bottom: 20px;"></i>
        <h2>Your cart is empty</h2>
        <p style="margin: 15px 0 30px; color: #666;">Looks like you haven't added anything yet.</p>
        <a href="{{ route('shop') }}" class="btn">Start Shopping</a>
      </div>

      <div id="cartFullState" class="cart-layout" style="display: none;">
        <div class="cart-items-container">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="cartTableBody">
              <!-- Rendered via JS -->
            </tbody>
          </table>
        </div>

        <aside class="cart-summary">
          <h3>Order Summary</h3>
          <div class="cart-summary-row">
            <span>Subtotal</span>
            <strong id="cartSubtotalValue">INR 0</strong>
          </div>
          <div class="cart-summary-row">
            <span>Shipping</span>
            <strong id="cartShippingValue">INR 0</strong>
          </div>
          <div class="cart-summary-row total">
            <span>Total</span>
            <strong id="cartTotalValue">INR 0</strong>
          </div>
          <button class="btn cart-checkout-btn" type="button" onclick="window.location.href='{{ route('login_user') }}'">Proceed to Checkout</button>
        </aside>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
    const CART_KEY = 'you_cart_items';

    function renderCart() {
        const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        const emptyState = document.getElementById('cartEmptyState');
        const fullState = document.getElementById('cartFullState');
        const tbody = document.getElementById('cartTableBody');

        if (cart.length === 0) {
            emptyState.style.display = 'block';
            fullState.style.display = 'none';
            return;
        }

        emptyState.style.display = 'none';
        fullState.style.display = 'flex';
        tbody.innerHTML = '';

        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;

            tbody.innerHTML += `
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="${item.image}" style="width: 60px; height: 80px; object-fit: cover; border-radius: 8px;">
                            <div>
                                <h4 style="margin: 0; font-size: 15px;">${item.name}</h4>
                                <p style="font-size: 12px; color: #777; margin: 5px 0 0;">Size: ${item.variant}</p>
                            </div>
                        </div>
                    </td>
                    <td>INR ${item.price.toLocaleString()}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button onclick="updateQty(${index}, -1)" style="border: 1px solid #ddd; background: #fff; width: 24px; height: 24px; cursor: pointer;">-</button>
                            <span>${item.qty}</span>
                            <button onclick="updateQty(${index}, 1)" style="border: 1px solid #ddd; background: #fff; width: 24px; height: 24px; cursor: pointer;">+</button>
                        </div>
                    </td>
                    <td>INR ${itemSubtotal.toLocaleString()}</td>
                    <td><button onclick="removeItem(${index})" style="background: none; border: none; color: #ff5e5e; cursor: pointer;"><i data-lucide="trash-2"></i></button></td>
                </tr>
            `;
        });

        const shipping = subtotal > 999 ? 0 : 49;
        document.getElementById('cartSubtotalValue').innerText = 'INR ' + subtotal.toLocaleString();
        document.getElementById('cartShippingValue').innerText = (shipping === 0 ? 'FREE' : 'INR ' + shipping);
        document.getElementById('cartTotalValue').innerText = 'INR ' + (subtotal + shipping).toLocaleString();
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    window.updateQty = (idx, delta) => {
        let cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        cart[idx].qty += delta;
        if (cart[idx].qty < 1) cart[idx].qty = 1;
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        renderCart();
        if(window.updateCartBadge) window.updateCartBadge();
    };

    window.removeItem = (idx) => {
        let cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        cart.splice(idx, 1);
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        renderCart();
        if(window.updateCartBadge) window.updateCartBadge();
    };

    renderCart();
</script>
@endsection
