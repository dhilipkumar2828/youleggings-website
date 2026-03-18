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
   max-width: 1400px;
   margin: 0 auto;
  }
  @media (max-width: 991px) {
    .cart-grid { grid-template-columns: 1fr;
   justify-content: center;
  align-items: center;
justify-items: center; }
  }

  .cart-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    padding: 30px;
    border: 1px solid #f0f0f0;
   width: auto;
  }

  .cart-item-row {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 25px 0;
    border-bottom: 1px solid #f5f5f5;
    position: relative;
  }
  .cart-item-row:last-child { border-bottom: none; }

  .cart-item-main {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
  }

  .cart-item-img {
    width: 90px;
    height: 110px;
    object-fit: cover;
    border-radius: 12px;
    background: #fdf7fa;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }
  .cart-item-info h4 { font-family: var(--font-serif, serif); font-size: 19px; margin-bottom: 5px; color: #222; font-weight: 600; }
  .cart-item-info p { font-size: 12px; color: #888; margin: 2px 0; letter-spacing: 0.5px; }

  .cart-item-right {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-left: auto;
  }

  .qty-control {
    display: flex;
    align-items: center;
    background: #fdf7fa;
    border-radius: 50px;
    padding: 4px;
    width: fit-content;
    border: 1px solid #fdeef3;
  }
  .qty-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: #fff;
    color: #333;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .qty-btn:hover { background: #ec407a; color: #fff; }
  .qty-val { width: 35px; text-align: center; font-weight: 700; font-size: 14px; color: #333; }

  .cart-price { font-weight: 800; color: #333; font-size: 17px; margin-top: 8px; }
  .remove-item { 
    color: #ff5e5e; 
    cursor: pointer; 
    transition: 0.3s; 
    padding: 8px;
    background: #fffafa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .remove-item:hover { color: #fff; background: #ff5e5e; transform: scale(1.1); }

  /* Responsive Fixes for 800px down to 350px */
  @media (max-width: 800px) {
    .cart-item-row {
      flex-wrap: wrap;
      padding: 20px 0;
    }
    .cart-item-right {
      width: 100%;
      margin-left: 0;
      /* justify-content: space-between;
      margin-top: 15px;
      padding-top: 15px; */
      border-top: 1px solid #f9f9f9;
      gap: 10px;
    }
    .cart-item-info h4 { font-size: 16px; }
  }

  @media (max-width: 480px) {
    .cart-item-row {
      gap: 15px;
    }
    .cart-item-img {
      width: 70px;
      height: 90px;
    }
    .cart-item-info h4 { font-size: 15px; }
    .cart-price { font-size: 15px; }
    .qty-control { padding: 3px; }
    .qty-btn { width: 24px; height: 24px; }
    .qty-val { width: 30px; font-size: 13px; }
  }

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
  @media (max-width: 500px) {
 .cart-item-info h4 { font-family: var(--font-serif, serif); font-size: 14px; margin-bottom: 5px; color: #333; }
 .step-text { font-size: 10px; }
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
          <span class="step-text">Shopping Cart</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
          <div class="step-num">2</div>
          <span class="step-text">Checkout</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
          <div class="step-num">3</div>
          <span class="step-text">Order Complete</span>
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

      <div id="cartFullState" class="cart-grid" style="display: none;justify-items: center;">
        <div class="cart-items-section" style="width: 100%;">
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
              <strong id="cartSubtotalValue">₹0</strong>
            </div>
            <div class="summary-row" style="color: #ec407a; display: none; font-weight: 600;" id="discountRow">
              <span>Coupon</span>
              <strong id="cartDiscountValue">-₹0</strong>
            </div>
            
            <div class="summary-row total">
              <span>Total Payment</span>
              <strong id="cartTotalValue">₹0</strong>
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
            let price = parseFloat(item.price) || 0;
            // Hotfix: if price somehow became '500495' because of previous bug, use 495
            if (price > 10000 && price.toString().endsWith('495')) {
                price = 495;
                item.price = 495; // fix in memory
                localStorage.setItem(CART_KEY, JSON.stringify(cart)); // save fixed state
            }
            
            const qty = parseInt(item.qty) || 1;
            const itemSubtotal = price * qty;
            subtotal += itemSubtotal;

            container.innerHTML += `
                <div class="cart-item-row">
                    <div class="cart-item-main">
                        <img src="${item.image}" class="cart-item-img">
                        <div class="cart-item-info">
                            <h4>${item.name}</h4>
                            <p>Variant: ${item.variant}</p>
                            <div class="cart-price">₹${price.toLocaleString()}</div>
                        </div>
                    </div>
                   
                    <div class="cart-item-right">
                        <div class="qty-control">
                            <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                            <span class="qty-val">${qty}</span>
                            <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                        </div>
                        <div class="remove-item" onclick="removeItem(${index})">
                            <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                        </div>
                    </div>
                </div>
            `;
        });

        // Coupon display logic
        const COUPON_KEY = 'you_applied_coupon';
        const couponData = JSON.parse(localStorage.getItem(COUPON_KEY));
        let discount = 0;
        
        if (couponData) {
            discount = parseFloat(couponData.discount) || 0;
            document.getElementById('couponInputGroup').style.display = 'none';
            document.getElementById('appliedCouponInfo').style.display = 'flex';
            document.getElementById('appliedCouponName').innerText = couponData.code;
            
            document.getElementById('discountRow').style.display = 'flex';
            document.getElementById('cartDiscountValue').innerText = '-₹' + discount.toLocaleString();
        } else {
            document.getElementById('couponInputGroup').style.display = 'flex';
            document.getElementById('appliedCouponInfo').style.display = 'none';
            document.getElementById('discountRow').style.display = 'none';
        }

        document.getElementById('cartSubtotalValue').innerText = '₹' + subtotal.toLocaleString();
        document.getElementById('cartTotalValue').innerText = '₹' + (subtotal - discount).toLocaleString();
        
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

    // Initial call to render the cart
    renderCart();
</script>
@endsection

