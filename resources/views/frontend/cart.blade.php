@extends('frontend.layouts.app')

@section('title', 'Your Cart | You Leggings')

@section('styles')
<style>
  /* Checkout Stepper */
  .checkout-stepper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 50px;
    gap: 15px;
  }
  .step-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #bbb;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }
  .step-item.active { color: #ec407a; }
  .step-num {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
  }
  .step-item.active .step-num { border-color: #ec407a; background: #ec407a; color: #fff; }
  .step-line { width: 50px; height: 1px; background: #eee; }

  /* Cart Layout */
  .cart-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 40px;
    align-items: flex-start;
  }
  @media (max-width: 991px) {
    .cart-grid { grid-template-columns: 1fr; }
  }

  .cart-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    padding: 30px;
    border: 1px solid #f0f0f0;
  }

  .cart-item-row {
    display: grid;
    grid-template-columns: 100px 1fr 120px 120px 40px;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #f8f8f8;
  }
  .cart-item-row:last-child { border-bottom: none; }

  .cart-item-img {
    width: 80px;
    height: 100px;
    object-fit: cover;
    border-radius: 12px;
    background: #fdf7fa;
  }
  .cart-item-info h4 { font-family: var(--font-serif, serif); font-size: 18px; margin-bottom: 5px; color: #333; }
  .cart-item-info p { font-size: 13px; color: #888; margin: 0; }

  .qty-control {
    display: flex;
    align-items: center;
    background: #fdf7fa;
    border-radius: 50px;
    padding: 5px;
    width: fit-content;
  }
  .qty-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: none;
    background: #fff;
    color: #333;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: 0.2s;
  }
  .qty-btn:hover { background: #ec407a; color: #fff; }
  .qty-val { width: 40px; text-align: center; font-weight: 700; font-size: 14px; }

  .cart-price { font-weight: 700; color: #333; font-size: 16px; }
  .remove-item { color: #ff5e5e; cursor: pointer; transition: 0.3s; padding: 5px; }
  .remove-item:hover { color: #d11a2a; transform: scale(1.1); }

  /* Summary Sidebar */
  .summary-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    padding: 30px;
    position: sticky;
    top: 100px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.04);
  }
  .summary-title { font-family: var(--font-serif, serif); font-size: 24px; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
  .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 15px; color: #666; }
  .summary-row.total { border-top: 1px solid #eee; padding-top: 20px; margin-top: 20px; color: #333; font-weight: 800; font-size: 20px; }
  
  .coupon-box { display: flex; gap: 10px; margin-bottom: 25px; }
  .coupon-input { 
    flex: 1; 
    border: 1px solid #eee; 
    border-radius: 8px; 
    padding: 12px 15px; 
    font-size: 13px;
    background: #fafafa;
  }
  .coupon-btn { background: #333; color: #fff; border: none; padding: 0 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; }
  .coupon-btn:hover { background: #000; }

  .checkout-btn {
    width: 100%;
    background: #ec407a;
    color: #fff;
    border: none;
    padding: 18px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: 0.4s;
    box-shadow: 0 10px 20px rgba(236, 64, 122, 0.2);
  }
  .checkout-btn:hover { background: #d81b60; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(236, 64, 122, 0.3); }

  .empty-cart-state {
      text-align: center;
      padding: 100px 20px;
  }
</style>
@endsection

@section('content')
  <section class="section page-view cart-page" style="display: block; background: #fdfbfb;">
    <div class="container" style="padding: 50px 0 50px;">
      
      <!-- Stepper -->
      <div class="checkout-stepper">
        <div class="step-item active">
          <div class="step-num">1</div>
          <span>Shopping Cart</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
          <div class="step-num">2</div>
          <span>Checkout</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
          <div class="step-num">3</div>
          <span>Order Complete</span>
        </div>
      </div>

      <div id="cartEmptyState" class="empty-cart-state" style="display: none;">
        <div style="background: #fff; display: inline-block; padding: 40px; border-radius: 50%; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 30px;">
            <i data-lucide="shopping-bag" style="width: 80px; height: 80px; color: #ec407a;"></i>
        </div>
        <h2 style="font-family: var(--font-serif, serif); font-size: 32px; margin-bottom: 10px;">Your wardrobe is waiting</h2>
        <p style="color: #888; margin-bottom: 40px;">Explore our new arrivals and find your perfect fit.</p>
        <a href="{{ route('shop') }}" class="btn" style="background: #333; color: #fff; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: 600;">Explore Collections</a>
      </div>

      <div id="cartFullState" class="cart-grid" style="display: none;">
        <div class="cart-items-section">
          <div class="cart-card">
            <h3 style="font-family: var(--font-serif, serif); font-size: 24px; margin-bottom: 25px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px;">Your Items</h3>
            <div id="cartItemsList">
              <!-- Rendered via JS -->
            </div>
          </div>
          
          <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('shop') }}" style="text-decoration: none; color: #666; font-weight: 600; display: flex; align-items: center; gap: 8px;">
              <i data-lucide="arrow-left" style="width: 18px;"></i> Continue Shopping
            </a>
            <button onclick="clearCart()" style="background: none; border: none; color: #999; cursor: pointer; font-size: 13px;">Clear all items</button>
          </div>
        </div>

        <aside class="cart-summary-section">
          <div class="summary-card">
            <h3 class="summary-title">Order Summary</h3>
            
            <div id="couponSection" style="margin: 15px 0 25px; padding: 20px; background: #fffafb; border: 1px dashed #ec407a; border-radius: 16px;">
              <div id="couponInputGroup" style="display: flex; gap: 10px;">
                <input type="text" id="cartCouponInput" class="form-control" placeholder="Enter Coupon Code" style="flex: 1; padding: 12px; font-size: 13px; text-transform: uppercase; border: 1px solid #eee; border-radius: 10px;">
                <button type="button" onclick="applyCartCoupon()" class="btn" style="background: #333; color: #fff; border-radius: 10px; padding: 0 20px; font-size: 11px; font-weight: 700; border: none; cursor: pointer;">APPLY</button>
              </div>
              <div id="cartCouponMessage" style="font-size: 11px; margin-top: 8px; display: none; text-align: left;"></div>
              
              <div id="appliedCouponInfo" style="display: none; align-items: center; justify-content: space-between;">
                <div>
                   <span id="appliedCouponName" style="font-weight: 700; color: #ec407a; font-size: 14px;"></span>
                   <p style="margin: 0; font-size: 11px; color: #666;">Awesome! Coupon Applied</p>
                </div>
                <button type="button" onclick="removeCartCoupon()" style="background: none; border: none; color: #ff5e5e; font-size: 11px; font-weight: 700; cursor: pointer;">REMOVE</button>
              </div>
            </div>

            <div class="summary-row">
              <span>Subtotal</span>
              <strong id="cartSubtotalValue">INR 0</strong>
            </div>
            <div class="summary-row" style="color: #ec407a; display: none; font-weight: 600;" id="discountRow">
              <span>Coupon</span>
              <strong id="cartDiscountValue">-INR 0</strong>
            </div>
            
            <div class="summary-row total">
              <span>Total Payment</span>
              <strong id="cartTotalValue">INR 0</strong>
            </div>
            
            <p style="font-size: 12px; color: #999; margin: 20px 0; text-align: center;">
              Shipping & taxes calculated at checkout.
            </p>

            <button class="checkout-btn" type="button" onclick="goToCheckout()">Secure Checkout</button>
            
            <div style="margin-top: 25px; display: flex; justify-content: center; gap: 15px; opacity: 0.5;">
              {{-- <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" height="15">
              <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" height="15">
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/24/Razorpay_logo.svg/1200px-Razorpay_logo.svg.png" height="15"> --}}
            </div>
          </div>
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
        const container = document.getElementById('cartItemsList');

        if (cart.length === 0) {
            emptyState.style.display = 'block';
            fullState.style.display = 'none';
            return;
        }

        emptyState.style.display = 'none';
        fullState.style.display = 'grid';
        container.innerHTML = '';

        let subtotal = 0;

        cart.forEach((item, index) => {
            const itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;

            container.innerHTML += `
                <div class="cart-item-row">
                    <img src="${item.image}" class="cart-item-img">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <p>Variant: ${item.variant}</p>
                    </div>
                    <div class="cart-price">INR ${item.price.toLocaleString()}</div>
                    <div class="qty-control">
                        <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                        <span class="qty-val">${item.qty}</span>
                        <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                    <div class="remove-item" onclick="removeItem(${index})">
                        <i data-lucide="x"></i>
                    </div>
                </div>
            `;
        });

        const shipping = subtotal > 1499 ? 0 : 99;
        document.getElementById('cartSubtotalValue').innerText = 'INR ' + subtotal.toLocaleString();
        document.getElementById('cartTotalValue').innerText = 'INR ' + subtotal.toLocaleString();
        
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
        if(!confirm('Remove this item from your cart?')) return;
        let cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        cart.splice(idx, 1);
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        renderCart();
        if(window.updateCartBadge) window.updateCartBadge();
    };

    window.clearCart = () => {
        if(!confirm('Are you sure you want to clear your entire cart?')) return;
        localStorage.removeItem(CART_KEY);
        renderCart();
        if(window.updateCartBadge) window.updateCartBadge();
    };

    window.goToCheckout = () => {
        window.location.href = '{{ route("checkout") }}';
    };

    const COUPON_KEY = 'you_applied_coupon';

    async function applyCartCoupon() {
        const input = document.getElementById('cartCouponInput');
        const code = input.value.trim();
        const msgDiv = document.getElementById('cartCouponMessage');
        const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        let subtotal = 0;
        cart.forEach(item => subtotal += (item.price * item.qty));

        if (!code) return;

        try {
            const response = await fetch('{{ route("apply_coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coupon_code: code, subtotal: subtotal })
            });
            const data = await response.json();

            if (data.success) {
                localStorage.setItem(COUPON_KEY, JSON.stringify({
                    code: code,
                    discount: data.discount
                }));
                
                msgDiv.style.display = 'block';
                msgDiv.style.color = '#2e7d32';
                msgDiv.innerText = data.message;
                
                renderCart();
            } else {
                msgDiv.style.display = 'block';
                msgDiv.style.color = '#c62828';
                msgDiv.innerText = data.message;
            }
        } catch (error) {
            console.error('Error applying coupon:', error);
            msgDiv.style.display = 'block';
            msgDiv.style.color = '#c62828';
            msgDiv.innerText = 'Something went wrong. Please try again.';
        }
    }

    window.removeCartCoupon = () => {
        localStorage.removeItem(COUPON_KEY);
        document.getElementById('cartCouponMessage').style.display = 'none';
        renderCart();
    };

    const originalRenderCart = renderCart;
    window.renderCart = function() {
        const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        const emptyState = document.getElementById('cartEmptyState');
        const fullState = document.getElementById('cartFullState');
        const container = document.getElementById('cartItemsList');

        if (cart.length === 0) {
            emptyState.style.display = 'block';
            fullState.style.display = 'none';
            return;
        }

        emptyState.style.display = 'none';
        fullState.style.display = 'grid';
        container.innerHTML = '';

        let subtotal = 0;
        cart.forEach((item, index) => {
            const itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;
            container.innerHTML += `
                <div class="cart-item-row">
                    <img src="${item.image}" class="cart-item-img">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <p>Variant: ${item.variant}</p>
                    </div>
                    <div class="cart-price">INR ${item.price.toLocaleString()}</div>
                    <div class="qty-control">
                        <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                        <span class="qty-val">${item.qty}</span>
                        <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                    <div class="remove-item" onclick="removeItem(${index})">
                        <i data-lucide="x"></i>
                    </div>
                </div>
            `;
        });

        const couponData = JSON.parse(localStorage.getItem(COUPON_KEY));
        let discount = 0;
        
        if (couponData) {
            discount = parseFloat(couponData.discount) || 0;
            document.getElementById('couponInputGroup').style.display = 'none';
            document.getElementById('appliedCouponInfo').style.display = 'flex';
            document.getElementById('appliedCouponName').innerText = couponData.code;
            
            document.getElementById('discountRow').style.display = 'flex';
            document.getElementById('cartDiscountValue').innerText = '-INR ' + discount.toLocaleString();
        } else {
            document.getElementById('couponInputGroup').style.display = 'flex';
            document.getElementById('appliedCouponInfo').style.display = 'none';
            document.getElementById('discountRow').style.display = 'none';
        }

        document.getElementById('cartSubtotalValue').innerText = 'INR ' + subtotal.toLocaleString();
        document.getElementById('cartTotalValue').innerText = 'INR ' + (subtotal - discount).toLocaleString();
        
        if (typeof lucide !== 'undefined') lucide.createIcons();
    };

    renderCart();
</script>
@endsection

