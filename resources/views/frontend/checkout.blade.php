@extends('frontend.layouts.app')

@section('title', 'Checkout | You Leggings')

@section('styles')
<style>
  .checkout-grid {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 40px;
    margin-top: 50px;
  }
  @media (max-width: 991px) {
    .checkout-grid { grid-template-columns: 1fr; }
  }

  .checkout-section {
    background: #fff;
    padding: 35px;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    margin-bottom: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.02);
  }
  .section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f8f8f8;
  }
  .section-header i { color: #ec407a; }
  .section-header h3 { font-family: var(--font-serif, serif); font-size: 22px; margin: 0; }

  .form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }
  .form-group { margin-bottom: 20px; }
  .form-group.full { grid-column: span 2; }
  .form-group label { display: block; font-size: 13px; font-weight: 700; text-transform: uppercase; color: #555; margin-bottom: 8px; letter-spacing: 0.5px; }
  .form-control {
    width: 100%;
    padding: 14px 18px;
    border: 1px solid #eee;
    border-radius: 10px;
    font-size: 15px;
    background: #fafafa;
    transition: all 0.3s;
  }
  .form-control:focus { border-color: #ec407a; outline: none; background: #fff; box-shadow: 0 5px 15px rgba(236, 64, 122, 0.05); }

  /* Payment Selection */
  .payment-methods { display: grid; gap: 15px; }
  .payment-option {
    border: 2px solid #eee;
    border-radius: 12px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 15px;
    cursor: pointer;
    transition: 0.3s;
  }
  .payment-option:hover { border-color: #fdeef2; background: #fffafb; }
  .payment-option.active { border-color: #ec407a; background: #fffafb; }
  .payment-radio { width: 20px; height: 20px; accent-color: #ec407a; }
  .payment-icon { width: 40px; height: 40px; background: #eee; border-radius: 8px; display: flex; align-items: center; justify-content: center; }

  /* Order Review Sidebar */
  .review-card {
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    border: 1px solid #f0f0f0;
    position: sticky;
    top: 100px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.05);
  }
  .review-title { font-family: var(--font-serif, serif); font-size: 24px; margin-bottom: 25px; }

  .review-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #f8f8f8;
  }
  .review-item img { width: 50px; height: 60px; object-fit: cover; border-radius: 8px; }
  .review-item-info { flex: 1; }
  .review-item-name { font-size: 14px; font-weight: 600; margin: 0; }
  .review-item-meta { font-size: 11px; color: #999; margin: 3px 0; }
  .review-item-price { font-weight: 700; color: #ec407a; font-size: 14px; }

  .review-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #666; }
  .review-row.total { border-top: 1px solid #eee; padding-top: 20px; margin-top: 20px; color: #333; font-weight: 800; font-size: 20px; }

  .place-order-btn {
    width: 100%;
    background: #333;
    color: #fff;
    border: none;
    padding: 20px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    cursor: pointer;
    margin-top: 30px;
    transition: 0.3s;
  }
  .place-order-btn:hover { background: #ec407a; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(236, 64, 122, 0.2); }

  .address-card { border: 2px solid #eee; border-radius: 12px; padding: 15px; cursor: pointer; transition: 0.3s; position: relative; background: #fff; }
  .address-card:hover { border-color: #fdeef2; background: #fffafb; }
  .address-card.active { border-color: #ec407a; background: #fffafb; }
  .address-card.active .check-mark { display: block !important; }
</style>
@endsection

@section('content')
  <section class="section page-view checkout-page" style="display: block; background: #fdfbfb;">
    <div class="container" style="padding: 50px 0 100px;">
      
      <!-- Stepper -->
      <div class="checkout-stepper" style="display: flex; justify-content: center; align-items: center; margin-bottom: 50px; gap: 15px;">
        <div class="step-item" style="display: flex; align-items: center; gap: 10px; color: #bbb; font-weight: 600; font-size: 14px; text-transform: uppercase;">
          <div class="step-num" style="width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ddd; display: flex; align-items: center; justify-content: center;">1</div>
          <span>Cart</span>
        </div>
        <div class="step-line" style="width: 50px; height: 1px; background: #eee;"></div>
        <div class="step-item active" style="color: #ec407a;">
          <div class="step-num" style="width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ec407a; background: #ec407a; color: #fff; display: flex; align-items: center; justify-content: center;">2</div>
          <span>Checkout</span>
        </div>
        <div class="step-line" style="width: 50px; height: 1px; background: #eee;"></div>
        <div class="step-item">
          <div class="step-num" style="width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ddd; display: flex; align-items: center; justify-content: center;">3</div>
          <span>Payment</span>
        </div>
      </div>

      <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" onsubmit="return handleOrderSubmit(event)" class="validate">
        @csrf
        <div class="checkout-grid">
          @if(session('error'))
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 700; border: 1px solid #ffcdd2;">
              {{ session('error') }}
            </div>
          @endif
          @if ($errors->any())
            <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ffcdd2;">
              <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="checkout-left">
            @if(isset($addresses) && count($addresses) > 0)
            <div class="checkout-section">
              <div class="section-header">
                <i data-lucide="map-pin"></i>
                <h3>Saved Addresses</h3>
              </div>
              <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px; margin-bottom: 10px;">
                @foreach($addresses as $addr)
                <div class="address-card" onclick="selectSavedAddress({{ json_encode($addr) }}, this)">
                  <div style="font-weight: 700; margin-bottom: 5px; color: #333;">{{ $addr->sfirst_name }} {{ $addr->slast_name }}</div>
                  <div style="font-size: 12px; color: #666; line-height: 1.6; margin-bottom: 5px;">
                    <i data-lucide="map-pin" style="width: 12px; display: inline; vertical-align: middle;"></i> {{ $addr->saddress }}<br>
                    {{ $addr->scity }}, {{ $addr->sstate }} - {{ $addr->spincode }}
                  </div>
                  <div style="font-size: 12px; color: #888;">
                    <i data-lucide="phone" style="width: 12px; display: inline; vertical-align: middle;"></i> {{ $addr->sphone_number }}
                  </div>
                  <div class="check-mark" style="position: absolute; top: 12px; right: 12px; color: #ec407a; display: none;">
                    <i data-lucide="check-circle-2" style="width: 20px; height: 20px;"></i>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            @endif

            <div class="checkout-section">
              <div class="section-header">
                <i data-lucide="user"></i>
                <h3>Personal Information</h3>
              </div>
              <div class="form-grid">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" class="form-control" name="first_name" required placeholder="John">
                </div>
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" class="form-control" name="last_name" required placeholder="Doe">
                </div>
                <div class="form-group">
                  <label>Email Address</label>
                  <input type="email" class="form-control" name="email" required placeholder="john@example.com" value="{{ Auth::user()->email ?? '' }}">
                </div>
                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="tel" class="form-control" name="phone" required placeholder="+91 000 000 00">
                </div>
              </div>
            </div>

            <div class="checkout-section">
              <div class="section-header">
                <i data-lucide="map-pin"></i>
                <h3>Shipping Details</h3>
              </div>
              <div class="form-grid">
                <div class="form-group full">
                  <label>Street Address</label>
                  <input type="text" class="form-control" name="address" required placeholder="House number and street name">
                </div>
                <div class="form-group">
                  <label>Town / City</label>
                  <input type="text" class="form-control" name="city" required placeholder="Bhubaneswar">
                </div>
                <div class="form-group">
                  <label>State</label>
                  <select class="form-control" name="state" required onchange="calculateShipping()">
                    <option value="">Select State</option>
                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    <option value="Assam">Assam</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Chandigarh">Chandigarh</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Goa">Goa</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Ladakh">Ladakh</option>
                    <option value="Lakshadweep">Lakshadweep</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Manipur">Manipur</option>
                    <option value="Meghalaya">Meghalaya</option>
                    <option value="Mizoram">Mizoram</option>
                    <option value="Nagaland">Nagaland</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Puducherry">Puducherry</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Sikkim">Sikkim</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="West Bengal">West Bengal</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Pincode</label>
                  <input type="text" class="form-control" name="pincode" required placeholder="751001">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" class="form-control" name="country" value="India" readonly>
                  </div>
              </div>
            </div>

            <div class="checkout-section">
              <div class="section-header">
                <i data-lucide="credit-card"></i>
                <h3>Payment Method</h3>
              </div>
              <div class="payment-methods">
                <label class="payment-option active">
                  <input type="radio" name="payment_method" value="razorpay" class="payment-radio" checked>
                  <div class="payment-icon"><i data-lucide="shield-check"></i></div>
                  <div>
                    <strong style="display:block; font-size: 15px;">Razorpay Secure</strong>
                    <span style="font-size: 12px; color: #999;">Pay via UPI, Cards, Netbanking</span>
                  </div>
                </label>
                <label class="payment-option">
                  <input type="radio" name="payment_method" value="cod" class="payment-radio">
                  <div class="payment-icon"><i data-lucide="truck"></i></div>
                  <div>
                    <strong style="display:block; font-size: 15px;">Cash on Delivery</strong>
                    <span style="font-size: 12px; color: #999;">Pay when your order arrives</span>
                  </div>
                </label>
              </div>
            </div>
          </div>
          {{-- Hidden field for cart items - INSIDE form so it gets submitted --}}
          <input type="hidden" name="cart_items" id="cart_items_input" value="">

        <aside class="checkout-right">
          <div class="review-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
              <h3 style="font-family: var(--font-serif, serif); font-size: 24px; margin: 0;">Order Review</h3>
              <a href="{{ route('cart') }}" style="color: #ec407a; font-size: 14px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                <i data-lucide="edit-3" style="width: 16px;"></i> Change
              </a>
            </div>
            
            <div id="checkoutItemsList">
              <!-- Rendered via JS -->
            </div>

            <div class="review-row">
              <span>Subtotal</span>
              <strong id="checkoutSubtotal">₹0</strong>
            </div>


            <div class="review-row" id="discountRow" style="display: none; color: #ec407a; font-weight: 600;">
              <span>Coupon</span>
              <strong id="checkoutDiscount">₹0</strong>
            </div>
            <div class="review-row" id="shippingRow" style="display: none;">
              <span>Shipping Fee</span>
              <strong id="checkoutShipping">₹0</strong>
            </div>
            <div class="review-row total">
              <span>Total Amount</span>
              <strong id="checkoutTotal">₹0</strong>
            </div>
            
            <input type="hidden" name="coupon_code" id="hiddenCouponCode" value="">
            <input type="hidden" name="discount_amount" id="hiddenDiscountAmount" value="0">

            <button type="submit" class="place-order-btn">Confirm Order</button>

            <p style="font-size: 11px; text-align: center; color: #999; margin-top: 20px;">
              By placing your order, you agree to our <a href="#" style="color: #ec407a;">Terms & Conditions</a>.
            </p>
          </div>
        </aside>
      </div>
    </form>

    </div>
  </section>
@endsection

@section('scripts')
<script>
    const CART_KEY = 'you_cart_items';

    function renderCheckoutReview() {
        const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        const container = document.getElementById('checkoutItemsList');
        
        if (cart.length === 0) {
            window.location.href = '{{ route("cart") }}';
            return;
        }

        container.innerHTML = '';
        let subtotal = 0;

        cart.forEach(item => {
            subtotal += (item.price * item.qty);
            container.innerHTML += `
                <div class="review-item">
                    <img src="${item.image}">
                    <div class="review-item-info">
                        <h4 class="review-item-name">${item.name}</h4>
                        <p class="review-item-meta">Variant: ${item.variant} | Qty: ${item.qty}</p>
                        <div class="review-item-price">₹${(item.price * item.qty).toLocaleString()}</div>
                    </div>
                </div>
            `;
        });

        const discount = parseFloat(document.getElementById('hiddenDiscountAmount').value) || 0;
        
        document.getElementById('checkoutSubtotal').innerText = '₹' + subtotal.toLocaleString();
        
        if (discount > 0) {
            document.getElementById('discountRow').style.display = 'flex';
            document.getElementById('checkoutDiscount').innerText = '₹' + discount.toLocaleString();
        } else {
            document.getElementById('discountRow').style.display = 'none';
        }

        // We will call calculateShipping() which will update Shipping and Total
        calculateShipping();
    }

    async function calculateShipping() {
        const stateInput = document.getElementsByName('state')[0];
        const state = stateInput.value.trim();
        const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        let subtotal = 0;
        cart.forEach(item => subtotal += (item.price * item.qty));
        const discount = parseFloat(document.getElementById('hiddenDiscountAmount').value) || 0;

        if (!state) {
            document.getElementById('shippingRow').style.display = 'none';
            document.getElementById('checkoutTotal').innerText = '₹' + (subtotal - discount).toLocaleString();
            return;
        }

        try {
            const response = await fetch('{{ route("get_shipping_charge") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ state: state, subtotal: subtotal })
            });
            const data = await response.json();
            
            const shipping = data.shipping || 0;
            document.getElementById('shippingRow').style.display = 'flex';
            document.getElementById('checkoutShipping').innerText = shipping === 0 ? 'FREE' : '₹' + shipping.toLocaleString();
            document.getElementById('checkoutTotal').innerText = '₹' + (subtotal + shipping - discount).toLocaleString();
        } catch (error) {
            console.error('Error fetching shipping:', error);
        }
    }

    // Add listener to state input
    document.getElementsByName('state')[0].addEventListener('change', calculateShipping);

    window.selectSavedAddress = function(addr, element) {
        // Highlight selected card
        document.querySelectorAll('.address-card').forEach(card => card.classList.remove('active'));
        element.classList.add('active');

        // Fill form fields
        document.getElementsByName('first_name')[0].value = addr.sfirst_name;
        document.getElementsByName('last_name')[0].value = addr.slast_name;
        document.getElementsByName('email')[0].value = addr.semail;
        document.getElementsByName('phone')[0].value = addr.sphone_number;
        document.getElementsByName('address')[0].value = addr.saddress;
        document.getElementsByName('city')[0].value = addr.scity;
        document.getElementsByName('state')[0].value = addr.sstate;
        document.getElementsByName('pincode')[0].value = addr.spincode;

        // Trigger shipping calculation
        calculateShipping();

        // Scroll to personal info briefly to show it's filled
        // document.querySelector('.checkout-section:nth-child(2)').scrollIntoView({ behavior: 'smooth' });
    };


    // Inject cart JSON into hidden field before form submit
    window.handleOrderSubmit = function(e) {
        const cart = JSON.parse(localStorage.getItem(CART_KEY) || '[]');
        if (cart.length === 0) {
            alert('Your cart is empty! Please add items first.');
            window.location.href = '{{ route("shop") }}';
            return false;
        }
        document.getElementById('cart_items_input').value = JSON.stringify(cart);
        return true;
    };

    // Payment Option Switching
    const pOptions = document.querySelectorAll('.payment-option');
    pOptions.forEach(opt => {
      opt.addEventListener('click', () => {
        pOptions.forEach(o => o.classList.remove('active'));
        opt.classList.add('active');
      });
    });

    // Initial load check for coupon from cart page (localStorage)
    const initCoupon = () => {
        const COUPON_KEY = 'you_applied_coupon';
        const couponData = JSON.parse(localStorage.getItem(COUPON_KEY));
        if (couponData) {
            document.getElementById('hiddenCouponCode').value = couponData.code;
            document.getElementById('hiddenDiscountAmount').value = couponData.discount;
        }
    };
    initCoupon();

    renderCheckoutReview();
</script>
@endsection

